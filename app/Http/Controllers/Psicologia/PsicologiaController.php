<?php

namespace App\Http\Controllers\Psicologia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\View\View;
use DB;
Use Session;
use Exception;
use Mail;


class PsicologiaController extends Controller
{

    //VISTA DE CALENDARIO

    // Mostrar la vista del calendario de citas
    public function calendario_citas(Request $request)
    {
        try {
            // Obtener pacientes
            $responsePacientes = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/psicologia/pacientes');

            if($responsePacientes->status() === 403){
                return view('pages.error.403')->with('scopes', []);
            }

            // Obtener tipo_cita
            $responseTipoCita = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/psicologia/tipos-cita');

            if($responseTipoCita->status() === 403){
                return view('pages.error.403')->with('scopes', []);
            }

            // Obtener empleados (anteriormente profesionales)
            $responseEmpleados = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/psicologia/empleados');

            if($responseEmpleados->status() === 403){
                return view('pages.error.403')->with('scopes', []);
            }

            $scopes = $responsePacientes->json('scopes', []);
            $pacientes = $responsePacientes->json('pacientes', []);
            $empleados = $responseEmpleados->json('empleados', []);
            $tipocita = $responseTipoCita->json('tipos_cita', []);

            return view("sys.psicologia.calendarioCita")
                ->with("pacientes", $pacientes)
                ->with("empleados", $empleados)
                ->with("tipos_cita", $tipocita)
                ->with('scopes', $scopes);

        } catch (Exception $e) {
            return view("sys.psicologia.calendarioCita")
                ->with("pacientes", [])
                ->with("empleados", [])
                ->with("tipos_cita", [])
                ->with('scopes', [])
                ->with('error', 'Error al cargar datos: ' . $e->getMessage());
        }
    }

    // Función para guardar una nueva cita
    public function guardar_cita(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/psicologia/citas', [
                'numero_registro_asignado' => $request->numero_registro_asignado,
                'id_empleado' => $request->id_empleado,
                'fecha_cita' => $request->fecha_cita,
                'hora_cita' => $request->hora_cita,
                'id_tipo' => $request->id_tipo,
                'observaciones' => $request->observaciones
            ]);

            // Obtener la respuesta como array
            $responseData = $response->json();
            
            // Verificar si la respuesta del backend fue exitosa
            if ($response->successful() && isset($responseData['estatus']) && $responseData['estatus'] === true) {
                return response()->json([
                    'estatus' => true,
                    'mensaje' => $responseData['msgSuccess'],
                    'numero_registro_cita' => $responseData['numero_registro_cita'] ?? null
                ], 200);
            } else {
                // Si el backend retornó un error
                return response()->json([
                    'estatus' => false,
                    'mensaje' => $responseData['msgError'] ?? 'Error desconocido al guardar la cita'
                ], 400);
            }
            
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error de conexión con el servidor. Por favor, inténtelo más tarde.',
                'error_tipo' => 'conexion_api'
            ], 503);
        } catch (\Exception $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error interno: ' . $e->getMessage(),
                'error_tipo' => 'general'
            ], 500);
        }
    }

    // Función para consultar citas, y como respuesta devuelve un JSON con las citas
    public function obtener_citas(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/psicologia/citas');

            if ($response->successful()) {
                $data = $response->json();
                
                // Verificar que la respuesta tenga la estructura esperada
                if (isset($data['estatus']) && $data['estatus'] === true) {
                    return response()->json($data);
                } else {
                    return response()->json([
                        'estatus' => false,
                        'mensaje' => $data['mensaje'] ?? 'Error en la respuesta del servidor',
                        'citas' => []
                    ], 500);
                }
            } else {
                $statusCode = $response->status();
                $responseData = $response->json();
                
                return response()->json([
                    'estatus' => false,
                    'mensaje' => $responseData['mensaje'] ?? 'Error al obtener las citas',
                    'citas' => []
                ], $statusCode);
            }

        } catch (Exception $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error interno del servidor',
                'citas' => []
            ], 500);
        }
    }

    //Obtiene las estadísticas de citas desde el servicio externo y retorna la respuesta en formato JSON.
    public function estadisticas_citas(Request $request)
    {
        try {
            // Enviar solicitud al backend unag_service
            $response = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Authorization' => session('token'),
                    'Accept' => 'application/json'
                ])
                ->get(env('API_BASE_URL_ZETA')."/api/auth/psicologia/estadisticas");
            
            // Procesar respuesta
            if ($response->successful()) {
                $data = $response->json();
                
                return response()->json([
                    'estatus' => true,
                    'mensaje' => 'Estadísticas obtenidas exitosamente',
                    'estadisticas' => $data['estadisticas'] ?? []
                ]);
            }
            
            // Manejar errores del backend
            $errorData = $response->json();
            return response()->json([
                'estatus' => false,
                'mensaje' => $errorData['msgError'] ?? 'Error al obtener estadísticas',
                'error' => $errorData
            ], $response->status());
            
        } catch (ConnectionException $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error de conexión con el servicio de estadísticas: '.$e->getMessage()
            ], 503);
            
        } catch (Exception $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error inesperado: '.$e->getMessage()
            ], 500);
        }
    }

    // Actualiza el estado de una cita validando datos y comunicándose con el servicio externo.
    public function actualizar_estado_cita(Request $request, $id_cita)
    {
        try {
            // 1. Validación básica del ID
            if (!is_numeric($id_cita) || $id_cita <= 0) {
                return response()->json([
                    'estatus' => false,
                    'mensaje' => 'ID de cita inválido. Debe ser un número positivo.'
                ], 400);
            }

            // 2. Validación de campos requeridos
            if ((!$request->has('fecha_cita') || !$request->has('hora_cita') )&& $request->has('nuevoEstado')) {
                return response()->json([
                    'estatus' => false,
                    'mensaje' => 'Los campos fecha_cita y hora_cita son requeridos para posponer la cita'
                ], 400);
            }

            // 3. Validación de formatos
            if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $request->fecha_cita)) {
                return response()->json([
                    'estatus' => false,
                    'mensaje' => 'Formato de fecha inválido. Use YYYY-MM-DD'
                ], 400);
            }

            if (!preg_match('/^\d{2}:\d{2}$/', $request->hora_cita)) {
                return response()->json([
                    'estatus' => false,
                    'mensaje' => 'Formato de hora inválido. Use HH:MM en formato 24h'
                ], 400);
            }

            // 4. Preparar datos para el backend
            $data = [
                'id_cita' => $id_cita,
                'fecha_cita' => $request->fecha_cita,
                'hora_cita' => $request->hora_cita,
                '_token' => csrf_token()
            ];

            // 5. Enviar al backend unag_service
            $response = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Authorization' => session('token'),
                    'Accept' => 'application/json'
                ])
                ->post(env('API_BASE_URL_ZETA')."/api/auth/psicologia/citas/{$id_cita}/estado", $data);

            // 6. Procesar respuesta
            if ($response->successful()) {
                return response()->json([
                    'estatus' => true,
                    'mensaje' => 'Cita pospuesta exitosamente',
                    'data' => $response->json()
                ]);
            }

            // 7. Manejar errores del backend
            $errorData = $response->json();
            return response()->json([
                'estatus' => false,
                'mensaje' => $errorData['msgError'] ?? 'Error al posponer la cita',
                'error' => $errorData
            ], $response->status());

        } catch (ConnectionException $e) {
            // 8. Error de conexión
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error de conexión con el servicio de citas: '.$e->getMessage()
            ], 503);

        } catch (Exception $e) {
            // 9. Error inesperado
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error inesperado: '.$e->getMessage()
            ], 500);
        }
    }

    // Cancela una cita validando el ID, enviando la solicitud al servicio externo.
    public function cancelar_cita(Request $request, $id_cita)
    {
        try {
            // 1. Validación básica del ID
            if (!is_numeric($id_cita) || $id_cita <= 0) {
                return response()->json([
                    'estatus' => false,
                    'mensaje' => 'ID de cita inválido. Debe ser un número positivo.'
                ], 400);
            }
            
            // 2. Preparar datos para el backend
            $data = [
                'id_cita' => $id_cita,
                '_token' => csrf_token()
            ];
            
            // 3. Enviar al backend unag_service
            $response = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Authorization' => session('token'),
                    'Accept' => 'application/json'
                ])
                ->post(env('API_BASE_URL_ZETA')."/api/auth/psicologia/citas/{$id_cita}/cancelar", $data);
            
            // 4. Procesar respuesta
            if ($response->successful()) {
                return response()->json([
                    'estatus' => true,
                    'mensaje' => 'Cita cancelada exitosamente',
                    'data' => $response->json()
                ]);
            }
            
            // 5. Manejar errores del backend
            $errorData = $response->json();
            return response()->json([
                'estatus' => false,
                'mensaje' => $errorData['msgError'] ?? 'Error al cancelar la cita',
                'error' => $errorData
            ], $response->status());
            
        } catch (ConnectionException $e) {
            // 6. Error de conexión
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error de conexión con el servicio de citas: '.$e->getMessage()
            ], 503);
            
        } catch (Exception $e) {
            // 7. Error inesperado
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error inesperado: '.$e->getMessage()
            ], 500);
        }
    }

    //FIN DE LAS FUNCIONES VISTA

    //VISTA DE CALENDARIO
    public function obtener_datos_cita($id_cita)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/psicologia/cita/'.$id_cita.'/datos');

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['estatus']) && $data['estatus'] === true) {
                    return response()->json($data);
                } else {
                    return response()->json([
                        'estatus' => false,
                        'mensaje' => $data['mensaje'] ?? 'Error en la respuesta del servidor',
                        'cita' => null
                    ], 500);
                }
            } else {
                $statusCode = $response->status();
                $responseData = $response->json();
                
                return response()->json([
                    'estatus' => false,
                    'mensaje' => $responseData['mensaje'] ?? 'Error al obtener los datos de la cita',
                    'cita' => null
                ], $statusCode);
            }
        } catch (Exception $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error interno del servidor',
                'cita' => null
            ], 500);
        }
    }

    //FUNCIONES DE LA VISTA DE EVALUACION
    public function obtener_catalogos_motivo_consulta(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/psicologia/catalogos-motivo');

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json([
                    'estatus' => false,
                    'mensaje' => $response->json()['mensaje'] ?? 'Error al obtener catálogos de motivo de consulta',
                    'catalogos' => []
                ], $response->status());
            }
        } catch (ConnectionException $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error de conexión con el servidor',
                'catalogos' => []
            ], 503);
        } catch (Exception $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error interno: ' . $e->getMessage(),
                'catalogos' => []
            ], 500);
        }
    }

    // Obtiene los catálogos de antecedentes clínicos desde el servicio externo y retorna la respuesta en formato JSON.
    public function obtener_catalogos_historial_clinico_antecedentes(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/psicologia/catalogos-antecedentes');

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json([
                    'estatus' => false,
                    'mensaje' => $response->json()['mensaje'] ?? 'Error al obtener catálogos de historial clinico',
                    'catalogos' => []
                ], $response->status());
            }
        } catch (ConnectionException $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error de conexión con el servidor',
                'catalogos' => []
            ], 503);
        } catch (Exception $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error interno: ' . $e->getMessage(),
                'catalogos' => []
            ], 500);
        }
    }

    // Obtiene los catálogos de evaluación desde el servicio externo y retorna la respuesta en formato JSON.
    public function obtener_catalogos_evaluacion(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/psicologia/catalogos-evaluacion');

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json([
                    'estatus' => false,
                    'mensaje' => $response->json()['mensaje'] ?? 'Error al obtener catálogos de evaluación',
                    'catalogos' => []
                ], $response->status());
            }
        } catch (ConnectionException $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error de conexión con el servidor',
                'catalogos' => []
            ], 503);
        } catch (Exception $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error interno: ' . $e->getMessage(),
                'catalogos' => []
            ], 500);
        }
    }

    // Obtiene los catálogos de intervención desde el servicio externo y retorna la respuesta en formato JSON.
    public function obtener_catalogos_intervencion(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/psicologia/catalogos-intervencion');

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json([
                    'estatus' => false,
                    'mensaje' => $response->json()['mensaje'] ?? 'Error al obtener catálogos',
                    'catalogos' => []
                ], $response->status());
            }
        } catch (ConnectionException $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error de conexión con el servidor',
                'catalogos' => []
            ], 503);
        } catch (Exception $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error interno: ' . $e->getMessage(),
                'catalogos' => []
            ], 500);
        }
    }

    // Obtiene los catálogos de profesional desde el servicio externo y retorna la respuesta en formato JSON.
    public function obtener_catalogos_profesional(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/psicologia/catalogos-profesional');

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'estatus' => $data['estatus'] ?? true,
                    'mensaje' => $data['mensaje'] ?? 'Catálogos obtenidos',
                    'data' => $data['data'] ?? []
                ]);
            }

            return response()->json([
                'estatus' => false,
                'mensaje' => $response->json()['mensaje'] ?? 'Error en la respuesta del servidor',
                'data' => []
            ], $response->status());

        } catch (ConnectionException $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'No se pudo conectar con el servidor de catálogos',
                'data' => []
            ], 503);
        } catch (Exception $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error inesperado: '.$e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    // Guarda la evaluación psicológica validando los datos y enviando la
// solicitud al servicio externo.
public function guardar_evaluacion_psicologia(Request $request, $id_cita)
{
    try {
        // Validar que id_cita sea un número entero válido
        if (!is_numeric($id_cita)) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'ID de cita inválido'
            ], 400);
        }
        // Validar que id_empleado esté presente
        if (!$request->has('id_empleado') || empty($request->input('id_empleado'))) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'ID de empleado es requerido'
            ], 400);
        }
        // MAPEO CORREGIDO PARA COINCIDIR CON BACKEND
        $formData = [
            'id_cita' => (int)$id_cita,
            'id_empleado' => $request->input('id_empleado'),
            'id_clinica' => $request->input('id_clinica'),
            // Sección II: Motivo de consulta
            'motivo_consulta' => [
                'descripcion' => $request->input('motivo_consulta.descripcion', ''),
                'frecuencia_sintomas' => $request->input('motivo_consulta.frecuencia_sintomas'),
                'impacto_vida_diaria' => $request->input('motivo_consulta.impacto_vida_diaria', []),
                'factores_desencadenantes' => $request->input('motivo_consulta.factores_desencadenantes', [])
            ],
            // Sección III: Historial clínico
            'historial_clinico' => [
                'tipo_trastorno' => $request->input('historial_clinico.tipo_trastorno', []),
                'antecedentes_salud_mental' => $request->input('historial_clinico.antecedentes_salud_mental', []),
                'consumo_sustancias' => $request->input('historial_clinico.consumo_sustancias', [])
            ],
            // Sección IV: Evaluación psicológica - CORREGIDO
            'evaluacion_psicologica' => [
                'observaciones_clinicas' => $request->input('evaluacion_psicologica.observaciones_clinicas', ''),
                'otros_criterios' => $request->input('evaluacion_psicologica.otros_criterios', ''),
                'resultados_pruebas' => $request->input('evaluacion_psicologica.resultados_pruebas', ''),
                'pruebas_psicologicas' => $request->input('evaluacion_psicologica.pruebas_psicologicas', [])
            ],
            // Sección V: Plan de intervención - CORREGIDO
            'plan_intervencion' => [
                'objetivos_terapeuticos' => $request->input('plan_intervencion.objetivos_terapeuticos', []),
                'estrategias_intervencion' => $request->input('plan_intervencion.estrategias_intervencion', []),
                'frecuencia_sesiones' => $request->input('plan_intervencion.frecuencia_sesiones'),
                'tipos_terapias' => $request->input('plan_intervencion.tipos_terapias', []),
                'derivacion_servicios' => $request->input('plan_intervencion.derivacion_servicios', '0'),
                'id_clinica' => $request->input('plan_intervencion.id_clinica') // AGREGADO
            ],
            // Sección VI: Seguimiento y evolución - CORREGIDO
            'seguimiento_evolucion' => [
                'historial' => $request->input('seguimiento_evolucion.historial', ''),
                'resultados_obtenido' => $request->input('seguimiento_evolucion.resultados_obtenidos', ''),
                'recomendaciones' => $request->input('seguimiento_evolucion.recomendaciones', ''),
                'criterios_cumplidos' => $request->input('seguimiento_evolucion.criterios_cumplidos', false)
            ]
        ];
        // Limpiar arrays vacíos para evitar errores
        $formData = $this->limpiarArraysVacios($formData);
        // Realizar la petición al backend
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->post(env('API_BASE_URL_ZETA') . '/api/auth/psicologia/citas/' . $id_cita . '/evaluacion', $formData);
        // Verificar si la petición fue exitosa
        if ($response->successful()) {
            $responseData = $response->json();
            if (isset($responseData['estatus']) && $responseData['estatus'] === true) {
                $responseData['cita_datos'] = $responseData['cita_datos'] ?? null;
                $cita_datos = $responseData['cita_datos'][0];
                // Solo enviar correo si derivacion_servicios es "1" y hay id_clinica
                $derivacion_servicios = $request->input('plan_intervencion.derivacion_servicios');
                $id_clinica = $request->input('plan_intervencion.id_clinica');
                if (($derivacion_servicios === '1' || $derivacion_servicios === 1) && !empty($id_clinica) && $id_clinica !== null) {
                    $this->enviarCorreoPorClinica((int)$id_clinica, $cita_datos);
                }
                return response()->json([
                    'estatus' => true,
                    'mensaje' => $responseData['msgSuccess'] ?? 'Evaluación guardada exitosamente',
                    'numerosRegistro' => $responseData['numerosRegistro'] ?? null
                ], 200);
            } else {
                return response()->json([
                    'estatus' => false,
                    'mensaje' => $responseData['msgError'] ?? 'Error desconocido al guardar la evaluación'
                ], 400);
            }
        } else {
            // Error en la respuesta HTTP
            $statusCode = $response->status();
            $responseData = $response->json();
            $errorMessage = 'Error del servidor';
            if (isset($responseData['msgError'])) {
                $errorMessage = $responseData['msgError'];
            } elseif (isset($responseData['message'])) {
                $errorMessage = $responseData['message'];
            }
            return response()->json([
                'estatus' => false,
                'mensaje' => $errorMessage
            ], $statusCode);
        }
    } catch (\Illuminate\Http\Client\ConnectionException $e) {
        return response()->json([
            'estatus' => false,
            'mensaje' => 'Error de conexión con el servidor. Verifique su conexión a internet.',
            'error_tipo' => 'conexion_api'
        ], 503);
    } catch (\Illuminate\Http\Client\RequestException $e) {
        return response()->json([
            'estatus' => false,
            'mensaje' => 'Error en la petición al servidor: ' . $e->getMessage(),
            'error_tipo' => 'request_error'
        ], 500);
    } catch (\Exception $e) {
        return response()->json([
            'estatus' => false,
            'mensaje' => 'Error interno del servidor: ' . $e->getMessage(),
            'error_tipo' => 'general'
        ], 500);
    }
}

private function enviarCorreoPorClinica($id_clinica, $cita_datos)
{
    // Definir destinatarios por clínica
    $destinatarios = [];
    $nombre_clinica = '';
    
    if ($id_clinica == 1) {
        $destinatarios = ['cgarcia@unag.edu.hn'];
        $nombre_clinica = 'Clínica médica';
    } elseif ($id_clinica == 2) {
        $destinatarios = ['dayanarrcc@gmail.com'];
        $nombre_clinica = 'Clínica de nutrición';
    } elseif ($id_clinica == 3) {
        $destinatarios = ['clinica3@unag.edu.hn'];
        $nombre_clinica = 'Trabajo social';
    } else {
        // Si no hay clínica válida, no enviar correo
        return false;
    }
    
    // Crear subject personalizado
    $subject = 'Confirmación de cita psicológica - ' . $nombre_clinica . ' - ' . $cita_datos['numero_registro_asignado'];
    
    try {
        // Enviar correo
        Mail::send('sys/psicologia/correoCitas', [
            'numero_registro_asignado' => $cita_datos['numero_registro_asignado'],
            'nombre_completo_estudiante' => $cita_datos['nombre_completo_estudiante'],
            'fecha_cita' => $cita_datos['fecha_cita'],
            'observaciones' => $cita_datos['observaciones'],
            'nombre_clinica' => $nombre_clinica
        ], function($msj) use($subject, $destinatarios) {
            $msj->from(env('MAIL_USERNAME'));
            $msj->subject($subject);
            $msj->to($destinatarios);
        });
        
        return true;
    } catch (\Exception $e) {
        // Log del error si es necesario
        \Log::error('Error enviando correo a clínica ' . $id_clinica . ': ' . $e->getMessage());
        return false;
    }
}

    /**
     * Limpia arrays vacíos y valores nulos para evitar errores en el backend
     */
    private function limpiarArraysVacios($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    // Filtrar valores nulos, vacíos y strings vacíos, pero mantener el 0
                    $data[$key] = array_filter($value, function($item) {
                        return $item !== null && $item !== '' && $item !== [];
                    });
                    
                    // Si después de filtrar el array queda vacío, mantenerlo como array vacío
                    if (empty($data[$key])) {
                        $data[$key] = [];
                    }
                } elseif (is_string($value)) {
                    // Limpiar strings de espacios en blanco
                    $data[$key] = trim($value);
                }
            }
        }
        return $data;
    }
    
    //FIN DE LAS FUNCIONES VISTA

    //FUNCIONES DE LA VISTA HISTORIAL

    // Obtiene el historial de un estudiante por su número de registro
    public function obtener_historial($numeroRegistro)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/psicologia/historial/'.$numeroRegistro);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['success']) && $data['success'] === true) {
                    return response()->json([
                        'estatus' => true,
                        'historial' => $data['historial']
                    ]);
                } else {
                    return response()->json([
                        'estatus' => false,
                        'mensaje' => $data['message'] ?? 'Error en la respuesta del servidor',
                        'historial' => null
                    ], 500);
                }
            } else {
                $statusCode = $response->status();
                $responseData = $response->json();
                
                return response()->json([
                    'estatus' => false,
                    'mensaje' => $responseData['message'] ?? 'Error al obtener el historial',
                    'historial' => null
                ], $statusCode);
            }
        } catch (Exception $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error interno del servidor: ' . $e->getMessage(),
                'historial' => null
            ], 500);
        }
    }

    // Obtiene los datos de evaluación de una cita específica
    public function obtener_datos_evaluacion(Request $request)
    {
        $idCita = $request->query('id_cita');
        $numeroRegistro = $request->query('numero_registro');

        // Validación del ID de cita
        if (empty($idCita)) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Se requiere el ID de cita',
                'data' => null
            ], 400);
        }

        try {
            \Log::debug('Solicitud de datos de evaluación recibida', [
                'id_cita' => $idCita,
                'numero_registro' => $numeroRegistro,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Preparar parámetros para el backend
            $params = [
                'id_cita' => $idCita
            ];

            if (!empty($numeroRegistro)) {
                $params['numero_registro'] = $numeroRegistro;
            }

            // Hacer petición al backend con autenticación
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/psicologia/evaluacion/datos',
                $params
            );

            \Log::debug('Respuesta del backend recibida', [
                'status' => $response->status(),
                'response_time' => $response->handlerStats()['total_time'] ?? null
            ]);

            if (!$response->successful()) {
                \Log::error('Error en respuesta del backend', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                    'token_presente' => !empty(session('token'))
                ]);

                // Si es error de autenticación, limpiar sesión
                if ($response->status() === 401) {
                    session()->forget('token');
                    return response()->json([
                        'estatus' => false,
                        'mensaje' => 'Sesión expirada. Por favor, recargue la página e inicie sesión nuevamente.',
                        'data' => null,
                        'redirect' => true
                    ], 401);
                }

                return response()->json([
                    'estatus' => false,
                    'mensaje' => 'Error al comunicarse con el servicio de psicología',
                    'data' => null
                ], $response->status());
            }

            $data = $response->json();

            if (!isset($data['estatus']) || $data['estatus'] !== true) {
                \Log::warning('Respuesta inesperada del backend', $data);
                return response()->json([
                    'estatus' => false,
                    'mensaje' => $data['msgError'] ?? 'Respuesta inesperada del servidor',
                    'data' => null
                ], 500);
            }

            // Verificar que tengamos datos
            if (empty($data['data'])) {
                \Log::warning('No se encontraron datos para la cita', ['id_cita' => $idCita]);
                return response()->json([
                    'estatus' => false,
                    'mensaje' => 'No se encontraron datos para esta cita',
                    'data' => null
                ], 404);
            }

            // El backend ya retorna los datos estructurados, solo los pasamos directamente
            return response()->json([
                'estatus' => true,
                'data' => $data['data'], // Los datos ya vienen estructurados del backend
                'metadata' => [
                    'numero_registro' => $data['data']['datos_generales']['estudiante']['numero_registro'] ?? null,
                    'fecha_consulta' => now()->toDateTimeString()
                ]
            ]);

        } catch (\Illuminate\Http\Client\RequestException $e) {
            \Log::error('Error de conexión con el backend: ' . $e->getMessage());
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error al conectar con el servicio de psicología',
                'data' => null
            ], 503);
        } catch (\Exception $e) {
            \Log::error('Error inesperado: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Ocurrió un error inesperado: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    // FIN HISTORIAL

    //FUNCION PARA LA VISTA HISOTRIAL CLINICO

        //VISTA DE CALENDARIO

        // Obtiene el historial clínico de los estudiantes para la vista de historial clínico
    public function historial_clinico(Request $request)
    {
        try {
            // Si es una petición AJAX (para DataTable)
            if ($request->ajax()) {
                $responsehistorial = Http::withHeaders([
                    'Authorization' => session('token'),
                ])->get(env('API_BASE_URL_ZETA').'/api/auth/psicologia/historial-clinico', [
                    'draw' => $request->input('draw', 1),
                    'start' => $request->input('start', 0),
                    'length' => $request->input('length', 10)
                ]);

                if($responsehistorial->status() === 403){
                    return response()->json([
                        'draw' => intval($request->input('draw')),
                        'recordsTotal' => 0,
                        'recordsFiltered' => 0,
                        'data' => [],
                        'error' => 'No autorizado'
                    ], 403);
                }

                return response()->json($responsehistorial->json());
            }

            // CARGAR LOS SCOPES COMO EN CALENDARIO
            $scopes = app('App\Http\Controllers\ControladorPermisos')->ver_permisos();
            
            return view("sys.psicologia.historialClinico")
                ->with('scopes', $scopes);

        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'draw' => intval($request->input('draw')),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                    'error' => 'Error al cargar datos: ' . $e->getMessage()
                ], 500);
            }

            // ← TAMBIÉN EN CASO DE ERROR
            $scopes = app('App\Http\Controllers\ControladorPermisos')->ver_permisos();
            
            return view("sys.psicologia.historialClinico")
                ->with('scopes', $scopes)
                ->with('error', 'Error al cargar datos: ' . $e->getMessage());
        }
    }

    // FIN HISTORIAL CLINICO

    // Obtiene los catálogos de clínica desde el servicio externo y retorna la información en JSON.
    public function obtener_catalogos_clinica(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/psicologia/catalogos-clinica');

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'estatus' => $data['estatus'] ?? true,
                    'mensaje' => $data['mensaje'] ?? 'Catálogos obtenidos',
                    'data' => $data['data'] ?? []
                ]);
            }

            return response()->json([
                'estatus' => false,
                'mensaje' => $response->json()['mensaje'] ?? 'Error en la respuesta del servidor',
                'data' => []
            ], $response->status());

        } catch (ConnectionException $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'No se pudo conectar con el servidor de catálogos',
                'data' => []
            ], 503);
        } catch (Exception $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error inesperado: '.$e->getMessage(),
                'data' => []
            ], 500);
        }
    }

}