<?php

namespace App\Http\Controllers\Docentes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use DB;
Use Session;
use Exception;

class DocentesController extends Controller
{
    public function ver_carga_academica_docente(){
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA').'/api/auth/docentes/cargaAcademica');

       
        if($response->status() === 403){
            return view('pages.error.403')->with('scopes', $scopes = array());
        }
        
        $scopes = $response['scopes'];
        $cargaAsignaturas = $response['cargaAsignaturas'];
        $cargaModulos = $response['cargaModulos'];
        $cargaPps = $response['cargaPps'];
        $cargaSsc = $response['cargaSsc'];
        $fechaSeguimientoAnteproyecto = $response['fecha_seguimiento_anteproyecto'];

        return view("sys.docentes.cargaAcademica")
            ->with("scopes", $scopes)
            ->with("cargaAsignaturas", $cargaAsignaturas)
            ->with("cargaModulos", $cargaModulos)
            ->with("cargaPps", $cargaPps)
            ->with("cargaSsc", $cargaSsc)
            ->with("fechaSeguimientoAnteproyecto", $fechaSeguimientoAnteproyecto);
    }

    public function asignarCalificacionesNuevaModalidad(Request $request, $docenteId, $seccionId,$modulo_back){
        
        $response = Http::withHeaders([
        'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA') . "/api/auth/docentes/$docenteId/secciones/$seccionId/calificaciones/$modulo_back");

       
        if($response->status() === 403){
            return view('pages.error.403')->with('scopes', $scopes = array());
        }
        
         $scopes = $response['scopes'];
         $data = $response->json();

        $encabezado = $data['encabezado'];

        
        $vista = "sys.".$encabezado['vista']; // "sys.docentes.nuevaModalidadCalificaciones"

       
        $tieneAccesoGuardarCalificacionesAsignaturas = $data['tieneAccesoGuardarCalificacionesAsignaturas'];
        $tieneAsignaturasLaboratorioGrupo = $data['tieneAsignaturasLaboratorioGrupo'];
        $modulo_back = $data['modulo_back'];
        $calendario_calificaciones_asignatura = $data['calendario_calificaciones_asignatura'];
        $calendario_calificaciones_asignatura_segundos_restantes = $data['calendario_calificaciones_asignatura_segundos_restantes'];

       
        $seccionId = $encabezado['seccionId'];
        $docenteId = $encabezado['docenteId'];
        $asignaturas_list = $encabezado['asignaturas_list'];
        $aca_seccion_comentario_list = $encabezado['aca_seccion_comentario_list'];

        $tokenString = substr(session('token'), 7);
        $payload = json_decode(base64_decode(explode('.', $tokenString)[1]), true);
        $currentUserId = (int)($payload['sub'] ?? 0);

        return view($vista, [
            "seccionId" => $seccionId,
            "docenteId" => $docenteId,
            "asignaturas_list" => $asignaturas_list,
            "aca_seccion_comentario_list" => $aca_seccion_comentario_list,
            "tieneAccesoGuardarCalificacionesAsignaturas" => $tieneAccesoGuardarCalificacionesAsignaturas,
            "tieneAsignaturasLaboratorioGrupo" => $tieneAsignaturasLaboratorioGrupo,
            "modulo_back" => $modulo_back,
            "calendario_calificaciones_asignatura" => $calendario_calificaciones_asignatura,
            "calendario_calificaciones_asignatura_segundos_restantes" => $calendario_calificaciones_asignatura_segundos_restantes,
            "scopes"=> $scopes,
            "currentUserId" => $currentUserId
        ]);
    }


    public function nuevaModalidadMatriculadosSeccion(Request $request){
        
        $response = Http::withHeaders([
        'Authorization' => session('token'),
        ])->post(
            env('API_BASE_URL_ZETA') . "/api/auth/docentes/obtener-matriculados-seccion",
            [
        'seccionId' => $request->input('seccionId'),
        'docenteId' => $request->input('idDocente'),
    ]
        );
       
        if($response->status() === 403){
            return view('pages.error.403')->with('scopes', $scopes = array());
        }
        
         $scopes = $response['scopes'];
         $data = $response->json();

        
         return response()->json($data, 200); 
    }


    public function guardarCalificaciones(Request $request){
    
    $response = Http::withHeaders([
        'Authorization' => session('token'),
    ])->post(
        env('API_BASE_URL_ZETA') . "/api/auth/docentes/guardarCalificaciones",
        $request->all()  
    );
   
    if($response->status() === 403){
        return view('pages.error.403')->with('scopes', $scopes = array());
    }

    // Devuelve la respuesta de la API directo al blade
    return response()->json($response->json());
}

    public function guardarObservacionesSeccion(Request $request, $seccionId)
{
    $response = Http::withHeaders([
        'Authorization' => session('token'),
    ])->post(env('API_BASE_URL_ZETA') . "/api/auth/docentes/secciones/{$seccionId}/guardarObservaciones", [
        'observaciones' => $request->observaciones,
        'seccionId' => $seccionId
    ]);

    if($response->status() === 403){
        return view('pages.error.403')->with('scopes', $scopes = array());
    }

    return response()->json($response->json());
}

public function guardar_aca_seccion_comentario(Request $request)
{
    $response = Http::withHeaders([
        'Authorization' => session('token'),
    ])->post(env('API_BASE_URL_ZETA') . '/api/auth/docentes/secciones/obs-comentarios/guardar', [
        'id'              => $request->id,
        'id_seccion'      => $request->id_seccion,
        'texto_comentario'=> $request->texto_comentario,
        'accion'          => $request->accion,
    ]);

   if($response->status() === 403){
        return view('pages.error.403')->with('scopes', $scopes = array());
    }

    return response()->json($response->json());
}

// ─── Módulos ─────────────────────────────────────────────────────────────────

    public function asignarCalificacionesModuloNuevaModalidad(Request $request, $docenteId, $bloqueModuloId, $modulo_back)
    {
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA') . "/api/auth/docentes/{$docenteId}/bloques-modulo/{$bloqueModuloId}/calificaciones/{$modulo_back}");

        if ($response->status() === 403) {
            return view('pages.error.403')->with('scopes', []);
        }

        $data = $response->json();

        return view('sys.docentes.calificacionesModuloNuevaModalidad', [
            'modulos_list'                           => $data['modulos_list'],
            'bloqueModuloId'                         => $data['bloqueModuloId'],
            'docenteId'                              => $data['docenteId'],
            'tieneAccesoGuardarCalificacionesModulos' => $data['tieneAccesoGuardarCalificacionesModulos'],
            'modulo_back'                            => $data['modulo_back'],
            'scopes'                                 => $data['scopes'],
        ]);
    }

    public function matriculadosModuloNuevaModalidad(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->post(env('API_BASE_URL_ZETA') . '/api/auth/docentes/obtener-matriculados-modulo', [
            'bloqueModuloId' => $request->input('bloqueModuloId'),
            'idDocente'      => $request->input('idDocente'),
        ]);

        if ($response->status() === 403) {
            return view('pages.error.403')->with('scopes', []);
        }

        return response()->json($response->json(), 200);
    }

    public function guardarCalificacionesModuloNuevaModalidad(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->post(env('API_BASE_URL_ZETA') . '/api/auth/docentes/guardarCalificacionesModulo', $request->all());

        if ($response->status() === 403) {
            return view('pages.error.403')->with('scopes', []);
        }

        return response()->json($response->json());
    }

    public function guardarObservacionesModulo(Request $request, $bloqueModuloId)
    {
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->post(env('API_BASE_URL_ZETA') . "/api/auth/docentes/modulos/{$bloqueModuloId}/guardarObservaciones", [
            'observaciones'  => $request->observaciones,
            'bloqueModuloId' => $bloqueModuloId,
        ]);

        if ($response->status() === 403) {
            return view('pages.error.403')->with('scopes', []);
        }

        return response()->json($response->json());
    }

// ─── Sección configuración ───────────────────────────────────────────────────

public function getSeccionConfiguracionColumnas(Request $request)
{
    $response = Http::withHeaders([
        'Authorization' => session('token'),
    ])->post(env('API_BASE_URL_ZETA') . '/api/auth/docentes/secciones/configuracion/columnas', [
        'seccionId' => $request->input('seccionId'),
    ]);

    if($response->status() === 403){
        return view('pages.error.403')->with('scopes', $scopes = array());
    }

    return response()->json($response->json());
}

public function guardarSeccionConfiguracionColumnas(Request $request)
{
    $response = Http::withHeaders([
        'Authorization' => session('token'),
    ])->post(env('API_BASE_URL_ZETA') . '/api/auth/docentes/secciones/configuracion/columnas/guardar', [
        'columnasEvaluacion' => $request->input('columnasEvaluacion'),
        'seccionId'          => $request->input('seccionId'),
    ]);

    if($response->status() === 403){
        return view('pages.error.403')->with('scopes', $scopes = array());
    }

    return response()->json($response->json());
}

public function verSeccionConfiguracionEvaluacion(Request $request, $docenteId, $seccionId)
{
    $response = Http::withHeaders([
        'Authorization' => session('token'),
    ])->post(env('API_BASE_URL_ZETA') . '/api/auth/docentes/' . $docenteId . '/secciones/' . $seccionId . '/configuracion', [
        'docenteId' => $docenteId,
        'seccionId' => $seccionId,
    ]);

    if($response->status() === 403){
        return view('pages.error.403')->with('scopes', $scopes = array());
    }

    $data = $response->json();

    return view('sys.docentes.seccionesConfiguracionColumnas', [
        'seccionId'                   => $data['seccionId'],
        'docenteId'                   => $data['docenteId'],
        'asignaturas_list'            => $data['asignaturas_list'],
        'aca_seccion_comentario_list' => $data['aca_seccion_comentario_list'],
        'scopes'                      => $data['scopes'],
    ]);
}




// ─── Configuración columnas módulo ───────────────────────────────────────────

public function verBloqueModuloConfiguracionEvaluacion(Request $request, $docenteId, $bloqueModuloId)
{
    $response = Http::withHeaders([
        'Authorization' => session('token'),
    ])->get(env('API_BASE_URL_ZETA') . "/api/auth/docentes/{$docenteId}/bloques-modulo/{$bloqueModuloId}/configuracion");

    if ($response->status() === 403) {
        return view('pages.error.403')->with('scopes', []);
    }

    $data = $response->json();

    return view('sys.docentes.bloqueModuloConfiguracionColumnas', [
        'modulos_list'   => $data['modulos_list'],
        'bloqueModuloId' => $data['bloqueModuloId'],
        'scopes'         => $data['scopes'],
    ]);
}

public function getBloqueModuloConfiguracionColumnas(Request $request)
{
    $response = Http::withHeaders([
        'Authorization' => session('token'),
    ])->post(env('API_BASE_URL_ZETA') . '/api/auth/docentes/bloques-modulo/configuracion/columnas', [
        'bloqueModuloId' => $request->input('bloqueModuloId'),
    ]);

    if ($response->status() === 403) {
        return view('pages.error.403')->with('scopes', []);
    }

    return response()->json($response->json());
}

public function guardarBloqueModuloConfiguracionColumnas(Request $request)
{
    $response = Http::withHeaders([
        'Authorization' => session('token'),
    ])->post(env('API_BASE_URL_ZETA') . '/api/auth/docentes/bloques-modulo/configuracion/columnas/guardar', [
        'columnasEvaluacion' => $request->input('columnasEvaluacion'),
        'bloqueModuloId'     => $request->input('bloqueModuloId'),
    ]);

    if ($response->status() === 403) {
        return view('pages.error.403')->with('scopes', []);
    }

    return response()->json($response->json());
}

// ── PPS Evidencia ────────────────────────────────────────────────

public function uploadEvidenciaPps(Request $request)
{
    $file = $request->file('file');
    if (!$file) {
        return response()->json(['error' => 'El proxy no recibió el archivo.'], 422);
    }

    $response = Http::withHeaders(['Authorization' => session('token')])
        ->timeout(60)
        ->attach('file', file_get_contents($file->getRealPath()), $file->getClientOriginalName())
        ->post(env('API_BASE_URL_ZETA') . '/api/auth/docentes/pps/upload-evidencia');

    if ($response->status() === 403) {
        return response()->json(['error' => 'Sin permiso.'], 403);
    }

    $data = $response->json();

    if (!$data || !isset($data['filename'])) {
        return response()->json([
            'error' => 'API HTTP ' . $response->status() . ': ' . substr($response->body(), 0, 300)
        ]);
    }

    return response()->json($data);
}

public function guardarEvidenciaPps(Request $request)
{
    $response = Http::withHeaders(['Authorization' => session('token')])
        ->post(env('API_BASE_URL_ZETA') . '/api/auth/docentes/pps/guardar-evidencia', $request->all());

    if ($response->status() === 403) {
        return response()->json(['error' => 'Sin permiso.'], 403);
    }

    return response()->json($response->json());
}

public function verEvidenciaPps(Request $request, $id)
{
    $response = Http::withHeaders(['Authorization' => session('token')])
        ->timeout(30)
        ->get(env('API_BASE_URL_ZETA') . "/api/auth/docentes/pps/{$id}/evidencia");

    if ($response->status() === 403) { abort(403); }
    if ($response->status() === 404) { abort(404); }

    return response($response->body(), 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="evidencia_pps.pdf"');
}

public function deleteEvidenciaTempPps(Request $request)
{
    $response = Http::withHeaders(['Authorization' => session('token')])
        ->post(env('API_BASE_URL_ZETA') . '/api/auth/docentes/pps/delete-evidencia-temp', $request->all());

    if ($response->status() === 403) {
        return response()->json(['error' => 'Sin permiso.'], 403);
    }

    return response()->json($response->json());
}

public function deleteFileTempPps(Request $request)
{
    $response = Http::withHeaders(['Authorization' => session('token')])
        ->post(env('API_BASE_URL_ZETA') . '/api/auth/docentes/pps/delete-file-temp', $request->all());

    if ($response->status() === 403) {
        return response()->json(['error' => 'Sin permiso.'], 403);
    }

    return response()->json($response->json());
}

public function evaluacionPps(Request $request, $tipoAsesor, $tipoTrabajo, $numeroRegistro, $id)
{
    $response = Http::withHeaders(['Authorization' => session('token')])
        ->get(env('API_BASE_URL_ZETA') . "/api/auth/docentes/pps/{$tipoAsesor}/{$tipoTrabajo}/{$numeroRegistro}/{$id}/evaluacion");

    if ($response->status() === 403) {
        return view('pages.error.403')->with('scopes', []);
    }

    $data = $response->json();

    return view('sys.docentes.evaluacionPps', [
        'estado'                   => $data['estado'],
        'tipo_asesor'              => $data['tipo_asesor'],
        'tipo_trabajo'             => $data['tipo_trabajo'],
        'numero_registro_asignado' => $data['numero_registro_asignado'],
        'nombre_estudiante'        => $data['nombre_estudiante'],
        'id'                       => $data['id'],
        'nuevo_formato'            => $data['nuevo_formato'],
        'id_evaluacion'            => $data['id_evaluacion'],
        'evaluacion'               => $data['evaluacion'],
        'nota_docentes'            => $data['nota_docentes'],
        'nota_promedio'            => $data['nota_promedio'],
        'validar'                  => $data['validar'],
        'nota_final'               => $data['nota_final'],
        'scopes'                   => $data['scopes'],
    ]);
}

public function guardarNotaPps(Request $request)
{
    $response = Http::withHeaders(['Authorization' => session('token')])
        ->post(env('API_BASE_URL_ZETA') . '/api/auth/docentes/pps/guardar-nota', $request->all());

    if ($response->status() === 403) {
        return response()->json(['error' => 'Sin permiso.'], 403);
    }

    return response()->json($response->json());
}

public function uploadFilePps(Request $request)
{
    $file = $request->file('file');
    if (!$file) {
        return response()->json(['error' => 'No se recibió el archivo.'], 422);
    }

    $response = Http::withHeaders(['Authorization' => session('token')])
        ->timeout(60)
        ->attach('file', file_get_contents($file->getRealPath()), $file->getClientOriginalName())
        ->post(env('API_BASE_URL_ZETA') . '/api/auth/docentes/pps/upload-file');

    if ($response->status() === 403) {
        return response()->json(['error' => 'Sin permiso.'], 403);
    }

    $data = $response->json();
    if (!$data || !isset($data['filename'])) {
        return response()->json(['error' => 'API HTTP ' . $response->status() . ': ' . substr($response->body(), 0, 200)]);
    }

    return response()->json($data);
}

public function validarNotaPps(Request $request, $id)
{
    $response = Http::withHeaders(['Authorization' => session('token')])
        ->post(env('API_BASE_URL_ZETA') . "/api/auth/docentes/pps/{$id}/validar-nota", $request->all());

    if ($response->status() === 403) {
        return response()->json(['error' => 'Sin permiso.'], 403);
    }

    return response()->json($response->json());
}

public function observacionesPps(Request $request)
{
    $response = Http::withHeaders(['Authorization' => session('token')])
        ->post(env('API_BASE_URL_ZETA') . '/api/auth/docentes/pps/observaciones', $request->all());

    if ($response->status() === 403) {
        return response()->json(['error' => 'Sin permiso.'], 403);
    }

    return response()->json($response->json());
}

// ══════════════════════════════════════════════════════
// SSC — Servicio Social Comunitario
// ══════════════════════════════════════════════════════

public function ssc_upload_informe(Request $request)
{
    $file = $request->file('file');
    if (!$file) {
        return response()->json(['error' => 'El proxy no recibio el archivo.'], 422);
    }

    $response = Http::withHeaders(['Authorization' => session('token')])
        ->timeout(60)
        ->attach('file', file_get_contents($file->getRealPath()), $file->getClientOriginalName())
        ->post(env('API_BASE_URL_ZETA') . '/api/auth/docentes/ssc/upload-informe');

    if ($response->status() === 403) {
        return response()->json(['error' => 'Sin permiso.'], 403);
    }

    $data = $response->json();
    if (!$data || !isset($data['filename'])) {
        return response()->json([
            'error' => 'API HTTP ' . $response->status() . ': ' . substr($response->body(), 0, 300)
        ]);
    }

    return response()->json($data);
}

public function ssc_ver_documento($filename)
{
    if (strpos($filename, '/') !== false || strpos($filename, '\\') !== false || strpos($filename, '..') !== false) {
        abort(400);
    }
    $response = Http::timeout(30)
        ->get(env('API_BASE_URL_ZETA') . '/documentos/ssc/' . $filename);

    if ($response->status() !== 200) {
        abort(404);
    }

    return response($response->body())
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
}

public function ssc_delete_informe_archivo(Request $request)
{
    $filename = $request->input('filename');
    if (!$filename) {
        return response()->json(['error' => 'Nombre de archivo requerido.'], 422);
    }

    $response = Http::withHeaders(['Authorization' => session('token')])
        ->delete(env('API_BASE_URL_ZETA') . '/api/auth/docentes/ssc/informes/archivo/' . $filename);

    if ($response->status() === 403) {
        return response()->json(['error' => 'Sin permiso.'], 403);
    }

    return response()->json($response->json());
}

public function ssc_cerrar_proyecto(Request $request)
{
    $response = Http::withHeaders(['Authorization' => session('token')])
        ->post(env('API_BASE_URL_ZETA') . '/api/auth/docentes/ssc/proyectos/cerrar', $request->all());

    if ($response->status() === 403) {
        return view('pages.error.403')->with('scopes', []);
    }

    $data = $response->json();

    if (!empty($data['msgError'])) {
        return redirect()->back()->with('ssc_error', $data['msgError']);
    }

    return redirect()->back()->with('ssc_success', $data['msgSuccess']);
}

public function ssc_ver_detalle_horas(Request $request, $id)
{
    $response = Http::withHeaders(['Authorization' => session('token')])
        ->get(env('API_BASE_URL_ZETA') . "/api/auth/docentes/ssc/proyectos/{$id}/detalle-horas");

    if ($response->status() === 403) {
        return view('pages.error.403')->with('scopes', []);
    }

    $data = $response->json();

    return view('sys.docentes.sscDetalleHoras', [
        'id_solicitud' => $data['id_solicitud'],
        'nombre'       => $data['nombre'] ?? null,
        'horas_max'    => $data['horas_max'],
        'estado'       => $data['estado'],
        'scopes'       => $data['scopes'] ?? [],
    ]);
}

public function ssc_detalle_horas_data(Request $request, $id)
{
    $response = Http::withHeaders(['Authorization' => session('token')])
        ->post(env('API_BASE_URL_ZETA') . "/api/auth/docentes/ssc/proyectos/{$id}/detalle-horas/data", $request->all());

    if ($response->status() === 403) {
        return response()->json(['msgError' => 'Sin permiso.'], 403);
    }

    return response()->json($response->json());
}

public function ssc_detalle_horas_guardar(Request $request, $id)
{
    $response = Http::withHeaders(['Authorization' => session('token')])
        ->post(env('API_BASE_URL_ZETA') . "/api/auth/docentes/ssc/proyectos/{$id}/detalle-horas/guardar", $request->all());

    if ($response->status() === 403) {
        return response()->json(['msgError' => 'Sin permiso.'], 403);
    }

    return response()->json($response->json());
}

public function ssc_ver_informes(Request $request, $id)
{
    $response = Http::withHeaders(['Authorization' => session('token')])
        ->get(env('API_BASE_URL_ZETA') . "/api/auth/docentes/ssc/proyectos/{$id}/informes");

    if ($response->status() === 403) {
        return view('pages.error.403')->with('scopes', []);
    }

    $data = $response->json();

    return view('sys.docentes.sscInformes', [
        'id_solicitud'           => $id,
        'nombre'                 => $data['nombre'] ?? null,
        'estado'                 => $data['estado'],
        'todos'                  => $data['todos'],
        'ssc_informes_list'      => $data['ssc_informes_list'],
        'estudiantes_disponibles'=> $data['estudiantes_disponibles'],
        'scopes'                 => $data['scopes'] ?? [],
    ]);
}

public function ssc_informes_guardar(Request $request, $id)
{
    $response = Http::withHeaders(['Authorization' => session('token')])
        ->post(env('API_BASE_URL_ZETA') . "/api/auth/docentes/ssc/proyectos/{$id}/informes/guardar", $request->all());

    if ($response->status() === 403) {
        return response()->json(['msgError' => 'Sin permiso.'], 403);
    }

    return response()->json($response->json());
}

}
