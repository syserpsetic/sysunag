<?php

namespace App\Http\Controllers\MallaValidacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use DB;
Use Session;
use Exception;

class MallaValidacionController extends Controller
{
    public function malla_validaciones(){

        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA').'/api/auth/setic/malla_validacion');

        if($response->status() === 403){
            return view('pages.error-page-403')->with('scopes', $scopes = array());
        }
        
        //throw new Exception($response->status());
        $scopes = $response['scopes'];
        $indicadoresMallaValidaciones = $response['indicadoresMallaValidaciones'];
        $personas = $response['personas'];
        $noticias = $response['noticias'];
        $narracion = $response['narracion'];
        $coutPendientes = $response['coutPendientes'];

        return view("sys.mallaValidacion.mallaValidacion")
        ->with('indicadoresMallaValidaciones', $indicadoresMallaValidaciones)
        ->with('personas', $personas)
        ->with('noticias', $noticias)
        ->with('narracion', $narracion)
        ->with('coutPendientes', $coutPendientes)
        ->with('scopes', $scopes);
    }

    public function malla_validaciones_tareas_pendientes_personas(Request $request){
        $id_member = $request->id_member;
        $msgError = null;
        $msgSuccess = null;
        
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->post(env('API_BASE_URL_ZETA').'/api/auth/setic/malla_validacion/tareas_pendientes_personas', [
            'id_member' => $id_member
        ]);

        if($response->status() === 403){
            return view('pages.error-page-403')->with('scopes', $scopes = array());
        }

        $msgSuccess = $response['msgSuccess'];
        $detalle_tareas = $response['detalle_tareas'];

        return response()->json([
            "msgSuccess" => $msgSuccess,
            "detalle_tareas" => $detalle_tareas
        ]);
    }

    public function malla_cobro_repetido_estudiantes(Request $request){
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->post(env('API_BASE_URL_ZETA').'/api/auth/setic/malla_validacion/cobro_repetido_estudiantes');

        if($response->status() === 403){
            return view('pages.error-page-403')->with('scopes', $scopes = array());
        }
        
        //throw new Exception($response->status());
        $scopes = $response['scopes'];
        $estudiantes = $response['estudiantes'];

        return view("sys.mallaValidacion.cobroRepetedidoEstudiantes")
        ->with("estudiantes", $estudiantes)
        ->with('scopes', $scopes);
    }

    public function malla_secciones_sin_docente(Request $request){
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->post(env('API_BASE_URL_ZETA').'/api/auth/setic/malla_validacion/malla_secciones_sin_docente');

        if($response->status() === 403){
            return view('pages.error-page-403')->with('scopes', $scopes = array());
        }
        
        //throw new Exception($response->status());
        $scopes = $response['scopes'];
        $secciones_sin_docente = $response['secciones_sin_docente'];

        return view("sys.mallaValidacion.seccionesSinDocente")
        ->with("secciones_sin_docente", $secciones_sin_docente)
        ->with('scopes', $scopes);
    }
}
