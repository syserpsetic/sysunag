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
            "scopes"=> $scopes
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

    if ($response->status() === 403) {
        abort(403);
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

    if ($response->status() === 403) {
        abort(403);
    }

    return response()->json($response->json());
}




   
}
