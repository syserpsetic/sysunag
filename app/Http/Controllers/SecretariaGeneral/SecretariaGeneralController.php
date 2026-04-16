<?php

namespace App\Http\Controllers\SecretariaGeneral;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use DB;
use Session;
use Exception;

class SecretariaGeneralController extends Controller
{
    public function estudiantes(){
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA').'/api/auth/secretariageneral/estudiantes');

        if($response->status() === 403){
            return view('pages.error.403')->with('scopes', []);
        }

        $data = $response->json();
        $scopes = $data['scopes'] ?? [];
        $resumen = $data['resumen'] ?? [];

        return view("sys.secretariageneral.estudianteGraduacion")
            ->with('resumen', $resumen)
            ->with('scopes', $scopes);
    }

   public function estudiantesdatos(Request $request){
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA').'/api/auth/secretariageneral/estudiantes/data');

        $draw = intval($request->input('draw'));
        $start = intval($request->input('start'));
        $length = intval($request->input('length'));
        $search = $request->input('search.value');

        $data = $response->json();
        $estudiantesQuery = $data['procesoestudiantesQuery'] ?? [];

        $recordsTotal = count($estudiantesQuery);
        
        $estudiantesFiltrados = $estudiantesQuery;

        if (!empty($search)) {
            $estudiantesFiltrados = array_filter($estudiantesQuery, function ($row) use ($search) {
                return stripos((string)$row['numero_registro_asignado'], $search) !== false ||
                       stripos((string)$row['nombre_completo'], $search) !== false ||
                       stripos((string)$row['id_carrera'], $search) !== false ||
                       stripos((string)$row['anio'], $search) !== false ||
                       stripos((string)$row['jornada'], $search) !== false ||
                       stripos((string)$row['asignaturas_matriculadas'], $search) !== false;
            });
        }

        $recordsFiltered = count($estudiantesFiltrados);

        $data = array_slice(array_values($estudiantesFiltrados), $start, $length);

        $response_json = [
            "draw" => $draw,
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        ];

        return json_encode($response_json);
    }

   public function estudiantesperfil($numero_registro_asignado) {
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
                'Content-Type' => 'application/json',
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/secretariageneral/estudiantes/perfil', [
                'numero_registro_asignado' => $numero_registro_asignado, 
            ]);

            if ($response->status() === 403) {
                return view('pages.error.403')->with('scopes', []);
            }

            $data = $response->json();

            if(isset($data['estatus']) && $data['estatus'] == false) {
                return back()->withErrors(['error' => 'Error: ' . ($data['msgError'] ?? 'No se pudo cargar el perfil')]);
            }

            return view("sys.secretariageneral.estudiantePerfil")
                ->with('user', $data['user'] ?? [])
                ->with('documentos', $data['documentos'] ?? [])
                ->with('es_solvente_administrativo', $data['es_solvente_administrativo'] ?? false)
                ->with('es_solvente_registro', $data['es_solvente_registro'] ?? false)
                ->with('es_solvente_archivo', $data['es_solvente_archivo'] ?? false)
                ->with('id_solicitud', $data['id_solicitud'] ?? null)
                ->with('id_proceso_graduacion', $data['id_proceso_graduacion'] ?? null)
                ->with('graduado', $data['graduado'] ?? null) 
                ->with('scopes', $data['scopes'] ?? []);

        } catch (Exception $excepcion) {
            return view("sys.secretariageneral.estudiantePerfil")
                ->with('user', [])
                ->with('documentos', []) 
                ->with('es_solvente_administrativo', null)
                ->with('es_solvente_registro', null)
                ->with('es_solvente_archivo', null)
                ->with('id_solicitud', null)
                ->with('id_proceso_graduacion', null)
                ->with('graduado', null)
                ->with('scopes', [])
                ->withErrors(['error' => 'Fallo de conexión con el servidor.']);
        }
    }

    public function validar_documento_estudiante(Request $request) {
        $msgSuccess = null;
        $msgError = null;
        $estatus = false;
        $documento_procesado = null;
        $documentos_lista = null;
        $id_proceso_graduacion = null;

        $archivos = $request->file('archivos') ?? [];

        try {
            $http = Http::withHeaders([
                'Authorization' => session('token'),
                'Accept'        => 'application/json',
            ]);

            if ($request->hasFile('archivos')) {
                $http = $http->asMultipart();
                foreach ($archivos as $archivo) {
                    $http = $http->attach(
                        'archivos[]', 
                        fopen($archivo->getPathname(), 'r'), 
                        $archivo->getClientOriginalName()
                    );
                }
            }

            $response = $http->post(env('API_BASE_URL_ZETA').'/api/auth/secretariageneral/estudiantes/documento/validar', [
                'id_documento' => $request->id_documento,
                'id_solicitud' => $request->id_solicitud,
                'tipo_accion'  => $request->tipo_accion, 
                'observacion'  => $request->observacion,
            ]);

            $data = $response->json();

            if($response->status() === 200){
                if(!$data["estatus"]){
                    $msgError = "Desde backend: " . $data["msgError"];
                } else {
                    $msgSuccess = $data["msgSuccess"];
                    $estatus = true;
                    $documento_procesado = $data["documento_procesado"] ?? null;
                    $documentos_lista = $data["documentos_lista"] ?? null;
                    $id_proceso_graduacion = $data["id_proceso_graduacion"] ?? null;
                    
                    if ($request->hasFile('archivos') && $request->tipo_accion != 'cancelar') {
                        $id_validacion = $data["id_validacion"]; 
                        foreach ($archivos as $archivo) {
                            $nombre_original = $archivo->getClientOriginalName();
                            $ruta_destino = "proceso_graduacion/pg_{$id_proceso_graduacion}/pgse_{$request->id_solicitud}/pgdvse_{$id_validacion}";
                            $archivo->storeAs($ruta_destino, $nombre_original, 'public');
                        }
                    }
                }
            } elseif($response->status() === 403){
                $msgError = "No tiene permisos para realizar esta acción";
            } else {
                $msgError = "Error en el servidor API (" . $response->status() . ")";
            }

        } catch (Exception $excepcion) {
            $msgError = "Error de conexión: " . $excepcion->getMessage();
        }

        return response()->json([
            "estatus"               => $estatus,
            "msgSuccess"            => $msgSuccess,
            "msgError"              => $msgError,
            "documento_procesado"   => $documento_procesado,
            "documentos_lista"      => $documentos_lista,
            "id_proceso_graduacion" => $id_proceso_graduacion
        ]);
    }

    public function descargar_documento($id_proceso, $id_solicitud, $id_validacion, $nombre_archivo) {
        $nombre_archivo_decodificado = urldecode($nombre_archivo);
        
        $ruta_fisica = storage_path("app/public/proceso_graduacion/pg_{$id_proceso}/pgse_{$id_solicitud}/pgdvse_{$id_validacion}/{$nombre_archivo_decodificado}");

        if (file_exists($ruta_fisica)) {
            return response()->download($ruta_fisica);
        }

        abort(404, 'El archivo solicitado no se encuentra en el servidor.');
    }
    
    public function eliminar_archivo_estudiante(Request $request) {
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
                'Accept'        => 'application/json',
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/secretariageneral/estudiantes/documento/archivo/eliminar', [
                'id_archivo' => $request->id_archivo
            ]);

            if ($response->status() === 200) {
                return response()->json($response->json());
            }
            
            return response()->json([
                "estatus" => false, 
                "msgError" => "Error API ".$response->status().": ".$response->body()
            ]);

        } catch (Exception $excepcion) {
            return response()->json(["estatus" => false, "msgError" => "Fallo de conexión."]);
        }
    }

   public function proceso_graduacion(){
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/secretariageneral/procesoGraduacion');

            if($response->status() === 403){
                return view('pages.error.403')->with('scopes', []);
            }

            $data = $response->json();
            
            $scopes      = $data['scopes'] ?? [];
            $procesos    = $data['procesos'] ?? []; 
            $sedes       = $data['sedes'] ?? []; 
            $modalidades = $data['modalidades'] ?? []; 
            $actos       = $data['actos'] ?? [];      

            return view("sys.secretariageneral.procesoGraduacion")
                ->with('procesos', $procesos)
                ->with('sedes', $sedes)
                ->with('modalidades', $modalidades)
                ->with('actos', $actos)
                ->with('scopes', $scopes);

        } catch (Exception $excepcion) {
            return back()->withErrors(['error' => 'Error de conexión: ' . $excepcion->getMessage()]);
        }
    }

    public function guardar_procesograduacion(Request $request){
        $msgSuccess = null; 
        $msgError = null; 
        $procesos_list = null;
        $estatus = false; 

        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
                'Content-Type' => 'application/json',
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/secretariageneral/procesoGraduacion/guardar', [
                'id'             => $request->id,
                'accion'         => $request->accion,
                'nombre_proceso' => $request->nombre_proceso,
                'descripcion'    => $request->descripcion,
                'fecha_inicio'   => $request->fecha_inicio,
                'fecha_final'    => $request->fecha_final,
                'id_sede'        => $request->id_sede,
                'modalidad'      => $request->modalidad,
                'actos'          => $request->actos      
            ]);

            $data = $response->json();

            if($response->status() === 200){
                $estatus = $data["estatus"] ?? false;

                if(!$estatus){ 
                    $msgError = "Desde backend: " . $data["msgError"]; 
                } else {
                    $msgSuccess = $data["msgSuccess"];
                    $procesos_list = $data["procesos_list"] ?? [];
                }
            } elseif($response->status() === 403){ 
                $msgError = "No tiene permisos para ejecutar esta acción."; 
            } else {
                $msgError = "Error API (" . $response->status() . ").";
            }
        } catch (Exception $excepcion) { 
            $msgError = "Error de conexión: " . $excepcion->getMessage(); 
        }

        return response()->json([ 
            "estatus"       => $estatus,
            "msgSuccess"    => $msgSuccess, 
            "msgError"      => $msgError, 
            "procesos_list" => $procesos_list 
        ]);
    }

   public function proceso_estudiantes($id_proceso){
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
                'Content-Type' => 'application/json',
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/secretariageneral/procesoGraduacion/estudiantes', [
                'id_proceso' => $id_proceso,
            ]);

            if($response->status() === 403){
                return view('pages.error.403')->with('scopes', []);
            }

            $data = $response->json(); 

            if(isset($data['estatus']) && $data['estatus'] == false) {
                return "ERROR EN BACKEND: " . $data['msgError'];
            }

            return view("sys.secretariageneral.procesoEstudiantes")
                ->with('estudiantes_enrolados', $data['estudiantes_enrolados'] ?? [])
                ->with('proceso', $data['proceso'] ?? null)
                ->with('scopes', $data['scopes'] ?? []);

        } catch (Exception $excepcion) {
            return "ERROR EN FRONTEND: " . $excepcion->getMessage();
        }
    }

    public function documentos_validacion(){
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/secretariageneral/documentosValidacion');

            if($response->status() === 403){
                return view('pages.error.403')->with('scopes', []);
            }

            $data = $response->json();
            $scopes = $data['scopes'] ?? [];
            $documentos = $data['documentos'] ?? [];
            $permisos = $data['permisos'] ?? []; 

            return view("sys.secretariageneral.documentosValidacion")
                ->with('documentos', $documentos)
                ->with('permisos', $permisos) 
                ->with('scopes', $scopes);

        } catch (Exception $excepcion) {
            return back()->withErrors(['error' => 'Error de conexión: ' . $excepcion->getMessage()]);
        }
    }

    public function guardar_documentos_validacion(Request $request){
        $msgSuccess = null;
        $msgError = null;
        $documento_procesado = null;
        $estatus = false; 

        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
                'Content-Type' => 'application/json',
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/secretariageneral/documentosValidacion/guardar', [
                'id'             => $request->id,
                'accion'         => $request->accion,
                'nombre'         => $request->nombre,          
                'descripcion'    => $request->descripcion,
                'estado'         => $request->estado,
                'id_seg_permiso' => $request->id_seg_permiso 
            ]);

            $data = $response->json();

            if($response->status() === 200){
                $estatus = $data["estatus"] ?? false;

                if(!$estatus){
                    $msgError = "Desde backend: " . ($data["msgError"] ?? 'Error desconocido');
                } else {
                    $msgSuccess = $data["msgSuccess"] ?? 'Guardado con éxito';
                    $documento_procesado = $data["documento_procesado"] ?? null;
                }
            } elseif($response->status() === 403){
                $msgError = "No tiene permisos para ejecutar esta acción.";
            } else {
                $msgError = "Error en el servidor API (" . $response->status() . ").";
            }
        } catch (Exception $excepcion) {
            $msgError = "Error de conexión: " . $excepcion->getMessage();
        }

        return response()->json([
            "estatus"             => $estatus,
            "msgSuccess"          => $msgSuccess,
            "msgError"            => $msgError,
            "documento_procesado" => $documento_procesado
        ]);
    }

   public function modalidades_proceso(){
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/secretariageneral/modalidadProceso');

            if($response->status() === 403){
                return view('pages.error.403')->with('scopes', []);
            }

            $data = $response->json();
            $scopes = $data['scopes'] ?? [];
            $modalidades = $data['modalidades'] ?? [];

            return view("sys.secretariageneral.modalidadProceso")
                ->with('modalidades', $modalidades)
                ->with('scopes', $scopes);

        } catch (Exception $excepcion) {
            return back()->withErrors(['error' => 'Error de conexión: ' . $excepcion->getMessage()]);
        }
    }

    public function guardar_modalidades_proceso(Request $request){
        $msgSuccess = null;
        $msgError = null;
        $modalidad_procesada = null;
        $estatus = false; 

        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
                'Content-Type' => 'application/json',
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/secretariageneral/modalidadProceso/guardar', [
                'id'          => $request->id,
                'accion'      => $request->accion,
                'nombre'      => $request->nombre,
                'descripcion' => $request->descripcion
            ]);

            $data = $response->json();

            if($response->status() === 200){
                $estatus = $data["estatus"] ?? false;

                if(!$estatus){
                    $msgError = "Desde backend: " . ($data["msgError"] ?? 'Desconocido');
                } else {
                    $msgSuccess = $data["msgSuccess"] ?? 'Operación exitosa';
                    $modalidad_procesada = $data["modalidad_procesada"] ?? null;
                }
            } elseif($response->status() === 403){
                $msgError = "No tiene permisos para ejecutar esta acción.";
            } else {
                $msgError = "Error API (" . $response->status() . ").";
            }
        } catch (Exception $excepcion) {
            $msgError = "Error de conexión: " . $excepcion->getMessage();
        }

        return response()->json([
            "estatus"             => $estatus,
            "msgSuccess"          => $msgSuccess,
            "msgError"            => $msgError,
            "modalidad_procesada" => $modalidad_procesada
        ]);
    }

    public function actos_proceso(){
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/secretariageneral/actosProceso');

            if($response->status() === 403){
                return view('pages.error.403')->with('scopes', []);
            }

            $data = $response->json();
            $scopes = $data['scopes'] ?? [];
            $actos = $data['actos'] ?? [];

            return view("sys.secretariageneral.actosProceso")
                ->with('actos', $actos)
                ->with('scopes', $scopes);

        } catch (Exception $excepcion) {
            return back()->withErrors(['error' => 'Error de conexión: ' . $excepcion->getMessage()]);
        }
    }

    public function guardar_actos_proceso(Request $request){
        $msgSuccess = null;
        $msgError = null;
        $acto_procesado = null;
        $estatus = false;

        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
                'Content-Type' => 'application/json',
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/secretariageneral/actosProceso/guardar', [
                'id'          => $request->id,
                'accion'      => $request->accion,
                'nombre'      => $request->nombre,
                'descripcion' => $request->descripcion,
                'estado'      => $request->estado
            ]);

            $data = $response->json();

            if($response->status() === 200){
                $estatus = $data["estatus"] ?? false;

                if(!$estatus){
                    $msgError = "Desde backend: " . ($data["msgError"] ?? 'Desconocido');
                } else {
                    $msgSuccess = $data["msgSuccess"] ?? 'Operación exitosa';
                    $acto_procesado = $data["acto_procesado"] ?? null;
                }
            } elseif($response->status() === 403){
                $msgError = "No tiene permisos.";
            } else {
                $msgError = "Error API (" . $response->status() . ").";
            }
        } catch (Exception $excepcion) {
            $msgError = "Error de conexión: " . $excepcion->getMessage();
        }

        return response()->json([
            "estatus"        => $estatus,
            "msgSuccess"     => $msgSuccess,
            "msgError"       => $msgError,
            "acto_procesado" => $acto_procesado
        ]);
    }

   public function solicitud_estudiante() {
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/secretariageneral/solicitudEstudiante');

            if($response->status() === 403){
                return view('pages.error.403')->with('scopes', []);
            }

            $data = $response->object();

            if (!$data) {
                return back()->withErrors(['error' => 'No se recibieron datos de la API']);
            }

            $scopes = isset($data->scopes) ? (array)$data->scopes : [];

            return view("sys.secretariageneral.solicitudesEstudiante")
                ->with('perfil', $data->perfil ?? null)
                ->with('solicitudes', $data->solicitudes ?? [])
                ->with('cat', isset($data->cat) ? (array)$data->cat : [])
                ->with('scopes', $scopes); 

        } catch (Exception $excepcion) {
            return back()->withErrors(['error' => 'Error de conexión: ' . $excepcion->getMessage()]);
        }
    }

    public function guardar_solicitud_estudiante(Request $request) {
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
                'Content-Type' => 'application/json',
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/secretariageneral/solicitudEstudiante/guardar', $request->all());

            if($response->status() === 403){
                return response()->json([
                    'estatus'  => false, 
                    'msgError' => 'No tiene permisos para guardar esta solicitud.'
                ]);
            }

            return response()->json($response->json());

        } catch (Exception $excepcion) {
            return response()->json([
                'estatus'  => false, 
                'msgError' => 'Error de conexión: ' . $excepcion->getMessage()
            ]);
        }
    }

   public function ejecutarGraduacionMasiva(Request $request) {
        try {
            $id_proceso = $request->id_proceso_graduacion;

            $response = Http::withHeaders([
                'Authorization' => session('token'),
                'Content-Type' => 'application/json',
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/secretariageneral/proceso/graduacion/masiva/ejecutar', [
                'id_proceso_graduacion' => $id_proceso, 
            ]);

            if (!$response->successful()) {
                return response()->json([
                    "estatus"  => false, 
                    "msgError" => "El Backend (Zeta) falló con código HTTP " . $response->status() . ". Revisa la consola o los logs de Zeta."
                ]);
            }

            $data = $response->json();

            if ($data === null) {
                 return response()->json([
                    "estatus"  => false,
                    "msgError" => "La respuesta de Zeta no es válida. Probablemente ocurrió un error fatal de base de datos."
                ]);
            }

            return response()->json($data);

        } catch (Exception $excepcion) {
            return response()->json([
                "estatus"  => false, 
                "msgError" => "Error de conexión desde Laravel: " . $excepcion->getMessage()
            ]);
        }
    }
}