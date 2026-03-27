<?php

namespace App\Http\Controllers\Reingresos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use DB;
Use Session;
use Exception;

class ReingresosController extends Controller
{
    //
    public function ver_reingresos(){
           $response = Http::withHeaders([
            'Authorization' => session('token'),
                ])->get(env('API_BASE_URL_ZETA').'/api/auth/tipocobrosreingresos');

            if($response->status() === 403){
                return view('pages.error.403')->with('scopes', []);
            }

            $data = $response->json();//convierte la respuesta en un array

          $scopes = $data['scopes'] ??[];//si no existe usa el array vacio
          $ver_reingresos = $data['tipos_cobros_reingresos'] ??[];

        return view ('sys.Reingresos.reingresos')->with('ver_reingresos', $ver_reingresos)->with('scopes', $scopes);

    }

    public function guardar_tipos_reingresos(Request $request){
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->post(env('API_BASE_URL_ZETA').'/api/auth/tipocobrosreingresos/guardar', [
            'id' => $request->id,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'monto' => $request->monto,
            'accion' => $request->accion
        ]);

        if($response->status() === 403){
            return view('pages.error.403')->with('scopes', $scopes = array());
        }
        $scopes = $response['scopes'] ??[];
        $guardar_tipos_reingresos = $response['reingreso_list'] ??[];

        return response()->json(["reingreso_list"=>$guardar_tipos_reingresos]);
    }
    //MODIFICADO
    public function buscar_persona(Request $request){
        $estatus = null;
        $estado = null;
        $msgSuccess = null;
        $msgError = null;
        $datos = null;

        if ($request->has('identidad') && $request->ajax()) {
            try {
                $response = Http::withHeaders([])->get(
                    env('API_BASE_URL_ZETA') . '/api/tipocobrosreingresos/buscar',
                    ['identidad' => $request->identidad]
                );

                if ($response->successful()) {
                    $data = $response->json();

                    if (isset($data['estado'])) {
                        $estatus = $data['estatus'] ?? true;
                        $estado = $data['estado'];
                        $datos = $data['datos'] ?? null;
                        $msgSuccess = $data['msgSuccess'] ?? 'Estudiante encontrado correctamente.';
                        $msgError = $data['msgError'] ?? null;
                    } else {
                        $estatus = false;
                        $estado = 'error';
                        $msgError = 'Respuesta inesperada del servidor';
                    }
                } else {
                    $estatus = false;
                    $estado = 'error';
                    $msgError = 'Error al consultar la API';
                }
            } catch (\Exception $e) {
                $estatus = false;
                $estado = 'error';
                $msgError = $e->getMessage();
            }

            // ✅ ÚNICO RETURN JSON FUERA DEL TRY-CATCH
            return response()->json([
                'estatus' => $estatus,
                'estado' => $estado,
                'msgSuccess' => $msgSuccess,
                'msgError' => $msgError,
                'datos' => $datos
            ]);
        }

        return view('sys.Reingresos.buscador');
    }

    public function mostrar_formulario(Request $request){
     $identidad = $request->get('identidad');
        $persona = null;
        $tiene_solicitud_abierta = false;

        if ($identidad) {
            $response = Http::withHeaders([])
                ->get(env('API_BASE_URL_ZETA') . '/api/tipocobrosreingresos/buscar', [
                    'identidad' => $identidad
                ]);

            if ($response->successful()) {
                $json = $response->json();
                $persona = $json['datos'] ?? null;

                $tiene_solicitud_abierta = $this->verificar_solicitud_abierta($identidad);
            }

            //dd($persona);
        }

        return view('sys.Reingresos.formulario', compact('persona', 'identidad', 'tiene_solicitud_abierta'));

    }

    private function verificar_solicitud_abierta($identidad){
          $response = Http::withHeaders([])
        ->get(env('API_BASE_URL_ZETA') . '/api/tipocobrosreingresos/verificar_solicitud',
            ['identidad' => $identidad]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['tiene_solicitud_abierta'] ?? false;
        }
        return false;
    }
    //MODIFICADO TODOS LOS DE ABAJO
    public function guardar_formulario(Request $request){
        $success = null;
        $mensaje = null;
        $errors = null;
        $data = null;
        $statusCode = 200;

        // ✅ VALIDACIÓN: Único caso donde se permite return temprano
        $validator = Validator::make($request->all(), [
            'identidad' => 'required',
            'primer_nombre' => 'required|string|max:100',
            'segundo_nombre' => 'nullable|string|max:100',
            'primer_apellido' => 'required|string|max:100',
            'segundo_apellido' => 'nullable|string|max:100',
            'telefono' => 'required|string|max:20',
            'correo' => 'required|email|max:150',
        ], [
            'primer_nombre.required' => 'El primer nombre es obligatorio.',
            'primer_apellido.required' => 'El primer apellido es obligatorio.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo debe tener un formato válido.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Verificar solicitud abierta
        if ($this->verificar_solicitud_abierta($request->identidad)) {
            $success = false;
            $mensaje = 'Ya cuenta con una solicitud de reingreso en proceso.';
            $statusCode = 409;
        } else {
            try {
                $response = Http::withHeaders([])
                    ->post(env('API_BASE_URL_ZETA') . '/api/tipocobrosreingresos/guardar_formulario',
                        $request->all()
                    );

                if ($response->successful()) {
                    $responseData = $response->json();
                    $success = $responseData['estatus'] ?? false;
                    $mensaje = $responseData['msgSuccess'] ?? $responseData['msgError'] ?? 'Operación completada';
                    $data = $responseData;
                } else {
                    $success = false;
                    $mensaje = 'Error al procesar la solicitud.';
                    $statusCode = 500;
                }
            } catch (\Exception $e) {
                $success = false;
                $mensaje = 'Error de conexión: ' . $e->getMessage();
                $statusCode = 500;
            }
        }

        // ✅ ÚNICO RETURN JSON FUERA DEL TRY-CATCH
        return response()->json([
            'success' => $success,
            'mensaje' => $mensaje,
            'data' => $data
        ], $statusCode);
    }

    // MÉTODO 4: solicitudes_nuevas - SIN CAMBIOS
    public function solicitudes_nuevas(Request $request){
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/tipocobrosreingresos/solicitudesn');

            if ($response->status() === 403) {
                return view('pages.error.403')->with('scopes', []);
            }

            if ($response->status() === 401) {
                return redirect()->route('login')->with('error', 'Sesión expirada');
            }

            if (!$response->successful()) {
                \Log::error('Error al obtener solicitudes nuevas', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return view('sys.Reingresos.solicitudesnuevas')
                    ->with('solicitudesnuevas', [])
                    ->with('scopes', [])
                    ->with('tipo_usuario', 'coordinador')
                    ->with('error', 'Error al cargar las solicitudes: ' . $response->status());
            }

            $data = $response->json();
            if (($data['estatus'] ?? false) === false) {
                return view('sys.Reingresos.solicitudesnuevas')
                    ->with('solicitudesnuevas', [])
                    ->with('scopes', $data['scopes'] ?? [])
                    ->with('tipo_usuario', 'coordinador')
                    ->with('error', $data['msgError'] ?? 'Error desconocido');
            }

            $scopes = $data['scopes'] ?? [];
            $solicitudesnuevas = $data['solicitudesnuevas'] ?? [];

            return view('sys.Reingresos.solicitudesnuevas')
                ->with('solicitudesnuevas', $solicitudesnuevas)
                ->with('scopes', $scopes)
                ->with('tipo_usuario', 'coordinador');

        } catch (\Exception $e) {
            \Log::error('Excepción en solicitudes_nuevas', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return view('sys.Reingresos.solicitudesnuevas')
                ->with('solicitudesnuevas', [])
                ->with('scopes', [])
                ->with('tipo_usuario', 'coordinador')
                ->with('error', 'Error de conexión: ' . $e->getMessage());
        }
    }

    // MÉTODO 5: solicitudes_vicerrector - SIN CAMBIOS
    public function solicitudes_vicerrector(Request $request){
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/tipocobrosreingresos/solicitudesvicerrector');

            if ($response->status() === 403) {
                return view('pages.error.403')->with('scopes', []);
            }

            $data = $response->json();
            $scopes = $data['scopes'] ?? [];
            $solicitudesvicerrector = $data['solicitudesvicerrector'] ?? [];

            $responseBecas = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/tipocobrosreingresos/tiposbeca');

            $tipos_beca = [];
            if ($responseBecas->successful()) {
                $dataBecas = $responseBecas->json();
                $tipos_beca = $dataBecas['tipos_beca'] ?? [];
            }

            return view('sys.Reingresos.solicitudesnuevas')
                ->with('solicitudesvicerrector', $solicitudesvicerrector)
                ->with('tipos_beca', $tipos_beca)
                ->with('scopes', $scopes)
                ->with('tipo_usuario', 'vicerrector');

        } catch (\Exception $e) {
            return view('sys.Reingresos.solicitudesnuevas')
                ->with('solicitudesvicerrector', [])
                ->with('tipos_beca', [])
                ->with('scopes', [])
                ->with('tipo_usuario', 'vicerrector')
                ->with('error', 'Error de conexión: ' . $e->getMessage());
        }
    }

    // MÉTODO 6: guardar_dictamen_coordinador - CORREGIDO CON ESTÁNDARES
    public function guardar_dictamen_coordinador(Request $request){
        $responseData = null;
        $statusCode = 500;

        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/tipocobrosreingresos/guardar-dictamen-coordinador', [
                'id_solicitud' => $request->id_solicitud,
                'dictamen' => $request->dictamen,
                'descripcion' => $request->descripcion
            ]);

            $responseData = $response->json();
            $statusCode = $response->status();
        } catch (\Exception $e) {
            $responseData = [
                'estatus' => false,
                'mensaje' => 'Error de conexión: ' . $e->getMessage()
            ];
            $statusCode = 500;
        }

        // ✅ ÚNICO RETURN JSON FUERA DEL TRY-CATCH
        return response()->json($responseData, $statusCode);
    }

    // MÉTODO 7: guardar_dictamen_vicerrector - CORREGIDO CON ESTÁNDARES
    public function guardar_dictamen_vicerrector(Request $request){
        $responseData = null;


        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/tipocobrosreingresos/guardar-dictamen-vicerrector', [
                'id_solicitud' => $request->id_solicitud,
                'dictamen' => $request->dictamen,
                'descripcion' => $request->descripcion,
                'id_tipo_beca' => $request->id_tipo_beca,
                'numero_registro_asignado' => $request->numero_registro_asignado,
                'periodo_academico' => $request->periodo_academico
            ]);

            $responseData = $response->json();
            $statusCode = $response->status();
        } catch (\Exception $e) {
            $responseData = [
                'estatus' => false,
                'mensaje' => 'Error de conexión: ' . $e->getMessage()
            ];

        }

        // ✅ ÚNICO RETURN JSON FUERA DEL TRY-CATCH
        return response()->json($responseData, $statusCode);
    }

    // MÉTODO 8: ObtenerProcesos - CORREGIDO CON ESTÁNDARES
    public function ObtenerProcesos(Request $request){
        $responseData = null;

        try {
            // ✅ CORRECCIÓN: Los parámetros GET van en la URL, no en el segundo parámetro
            $url = env('API_BASE_URL_ZETA') . '/api/auth/tipocobrosreingresos/procesos-solicitudes';
            $url .= '?username=' . urlencode(session('username'));

            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get($url);

            if($response->status() === 403){
                return view('pages.error.403')->with('scopes', []);
            }

            $responseData = $response->json();
            $statusCode = $response->status();

        } catch (\Exception $e) {
            \Log::error('Error en ObtenerProcesos: ' . $e->getMessage());
            $responseData = [
                'success' => false,
                'message' => 'Error de conexión: ' . $e->getMessage()
            ];
        }

        return response()->json($responseData, $statusCode);
    }

    // MÉTODO 9: solicitudes_finalizadas - CORREGIDO CON ESTÁNDARES
    public function solicitudes_finalizadas(Request $request){
        $responseData = null;
        $statusCode = 500;

        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA') . '/api/auth/tipocobrosreingresos/finalizadas-solicitudes', [
                'username' => session('username')
            ]);

            $responseData = $response->json();
            $statusCode = $response->status();
        } catch (\Exception $e) {
            $responseData = [
                'success' => false,
                'message' => 'Error de conexión: ' . $e->getMessage()
            ];
            $statusCode = 500;
        }

        // ✅ ÚNICO RETURN JSON FUERA DEL TRY-CATCH
        return response()->json($responseData, $statusCode);
    }

    // MÉTODO 10: cerrar_solicitud - CORREGIDO CON ESTÁNDARES
    public function cerrar_solicitud(Request $request){

        $responseData = null;


        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/tipocobrosreingresos/cerrar-solicitud', [
                'id_solicitud' => $request->id_solicitud,
                'saldo' => $request->saldo,
                'observacion' => $request->observacion ?? null
            ]);

            $responseData = $response->json();
            $statusCode = $response->status();
        } catch (\Exception $e) {
              \Log::error('Error en ObtenerProcesos: ' . $e->getMessage());
            $responseData = [
                'estatus' => false,
                'mensaje' => 'Error de conexión: ' . $e->getMessage()
            ];

        }

        // ✅ ÚNICO RETURN JSON FUERA DEL TRY-CATCH
        return response()->json($responseData, $statusCode);
    }
    // MÉTODO PARA VER TRAZABILIDAD
    public function ver_trazabilidad(Request $request){
        $responseData = null;
        $statusCode = 500;

        try {
            $identidad = $request->query('identidad');

            if (!$identidad) {
                return view('sys.Reingresos.trazabilidad')
                    ->with('error', 'No se proporcionó identidad')
                    ->with('trazabilidad', null);
            }

            $url = env('API_BASE_URL_ZETA') . '/api/tipocobrosreingresos/trazabilidad-solicitud';

            \Log::info('=== TRAZABILIDAD DEBUG ===');
            \Log::info('URL completa:', ['url' => $url]);
            \Log::info('Identidad:', ['identidad' => $identidad]);

            $response = Http::get($url, [
                'identidad' => $identidad
            ]);

            $responseData = $response->json();
            $statusCode = $response->status();

            \Log::info('Status HTTP:', ['status' => $statusCode]);
            \Log::info('Respuesta completa:', ['response' => $responseData]);

            // DEPURACIÓN: Mostrar la respuesta en la vista
            if (!isset($responseData['estatus']) || !$responseData['estatus']) {
                $errorMsg = $responseData['msgError'] ?? 'No se encontró información de la solicitud';

                \Log::warning('API retornó estatus false o no existe');

                return view('sys.Reingresos.trazabilidad')
                    ->with('error', $errorMsg)
                    ->with('trazabilidad', null)
                    ->with('identidad', $identidad)
                    ->with('debug_info', [
                        'url' => $url,
                        'identidad' => $identidad,
                        'status' => $statusCode,
                        'response' => $responseData
                    ]);
            }

            if (!isset($responseData['trazabilidad']) || empty($responseData['trazabilidad'])) {
                \Log::warning('No hay datos de trazabilidad en la respuesta');

                return view('sys.Reingresos.trazabilidad')
                    ->with('error', 'No se encontraron datos de trazabilidad para esta identidad')
                    ->with('trazabilidad', null)
                    ->with('identidad', $identidad)
                    ->with('debug_info', [
                        'mensaje' => 'Array de trazabilidad vacío',
                        'response' => $responseData
                    ]);
            }

            $trazabilidadData = (object) $responseData['trazabilidad'][0];

            // Procesar historial_evaluaciones
            if (isset($trazabilidadData->historial_evaluaciones)) {
                if (is_string($trazabilidadData->historial_evaluaciones)) {
                    $trazabilidadData->historial_evaluaciones = json_decode($trazabilidadData->historial_evaluaciones);
                } elseif (is_array($trazabilidadData->historial_evaluaciones)) {
                    $trazabilidadData->historial_evaluaciones = json_decode(json_encode($trazabilidadData->historial_evaluaciones));
                }
            }

            \Log::info('Datos procesados correctamente');
            \Log::info('Propiedades del objeto:', ['props' => array_keys(get_object_vars($trazabilidadData))]);

            return view('sys.Reingresos.trazabilidad')
                ->with('trazabilidad', $trazabilidadData)
                ->with('identidad', $identidad);

        } catch (\Exception $e) {
            \Log::error('Excepción en trazabilidad:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return view('sys.Reingresos.trazabilidad')
                ->with('error', 'Error de conexión: ' . $e->getMessage())
                ->with('trazabilidad', null)
                ->with('debug_exception', $e->getMessage());
        }
    }
    //LISTA DE COORDINADORES
    public function verc_coordinadores(Request $request){
              $response = Http::withHeaders([
            'Authorization' => session('token'),
                ])->get(env('API_BASE_URL_ZETA').'/api/auth/tipocobrosreingresos/coordinadores');

            if($response->status() === 403){
                return view('pages.error.403')->with('scopes', []);
            }

            $data = $response->json();//convierte la respuesta en un array

          $scopes = $data['scopes'] ??[];//si no existe usa el array vacio
          $verc_coordinadores     = $data['coordinador_carrera'] ??[];

        return view ('sys.Reingresos.coordinadores')->with('verc_coordinadores', $verc_coordinadores)->with('scopes', $scopes);

    }
    //GUARDAR COORDINADORES
    public function guardarc_coordinadores(Request $request){
                $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->post(env('API_BASE_URL_ZETA') . '/api/auth/tipocobrosreingresos/guardarc', [
            'id_coordinador_carrera' => $request->id_coordinador_carrera,
            'id_empleado'            => $request->id_empleado,
            'id_carrera'             => $request->id_carrera,
            'id_sede'                => $request->id_sede,
            'accion'                 => $request->accion,
            'nombre_completo'        => $request->nombre_completo,
            'nombre_carrera'         => $request->nombre_carrera,
            'nombre_sede'            => $request->nombre_sede,
        ]);

        if ($response->status() === 403) {
            return view('pages.error.403')->with('scopes', []);
        }

        $estatus     = $response['estatus'] ?? false;
        $msgSuccess  = $response['msgSuccess'] ?? null;
        $msgError    = $response['msgError'] ?? null;
        $coordinador = $response['coordinador'] ?? null;

        return response()->json([
            "estatus"     => $estatus,
            "msgSuccess"  => $msgSuccess,
            "msgError"    => $msgError,
            "coordinador" => $coordinador
        ]);
    }
    //LISTAR INFORMACION DE EMPLEADOS, SEDES, Y CARRERAS
    public function listar_datos_coordinadores(Request $request){
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA').'/api/auth/tipocobrosreingresos/listas');

        return response()->json($response->json());
    }

    //VER AUTORIADES
    public function vera_autoridades(Request $request){
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA').'/api/auth/tipocobrosreingresos/autoridades');

        if ($response->status() === 403) {
            return view('pages.error.403')->with('scopes', []);
        }

        $data            = $response->json();
        $scopes          = $data['scopes']          ?? [];
        $vera_autoridades = $data['autoridad_cargo'] ?? [];

        return view('sys.Reingresos.autoridades')
            ->with('vera_autoridades', $vera_autoridades)
            ->with('scopes', $scopes);
    }

// GUARDAR / ACTUALIZAR / ELIMINAR AUTORIDAD
    public function guardara_autoridades(Request $request){
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->post(env('API_BASE_URL_ZETA') . '/api/auth/tipocobrosreingresos/guardara', [
            'id_autoridad'    => $request->id_autoridad,
            'id_empleado'     => $request->id_empleado,
            'id_cargo'        => $request->id_cargo,
            'id_sede'         => $request->id_sede,
            'nombre_completo' => $request->nombre_completo,
            'nombre_cargo'    => $request->nombre_cargo,
            'nombre_sede'     => $request->nombre_sede,
            'accion'          => $request->accion
        ]);

        if ($response->status() === 403) {
            return view('pages.error.403')->with('scopes', []);
        }

        $estatus    = $response['estatus']    ?? false;
        $msgSuccess = $response['msgSuccess'] ?? null;
        $msgError   = $response['msgError']   ?? null;
        $autoridad  = $response['autoridad']  ?? null;

        return response()->json([
            "estatus"    => $estatus,
            "msgSuccess" => $msgSuccess,
            "msgError"   => $msgError,
            "autoridad"  => $autoridad
        ]);
    }

// LISTAR EMPLEADOS, CARGOS Y SEDES PARA LOS SELECTS
    public function listar_datos_autoridades(Request $request){
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA').'/api/auth/tipocobrosreingresos/listasa');

            return response()->json($response->json());
    }





}
