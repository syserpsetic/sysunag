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
        // if (session('malla_validacion_leer_cobros_repetidos')!='1') {
        //     return view("error")->with("code_error",'403');
        // }

        // $estudiantes = DB::select("WITH
        //         PERIODO_ACTUAL AS (
        //             SELECT
        //                 *
        //             FROM
        //                 DBLINK (
        //                     'dbname=una_dev host=".env('DB_HOST')." user=".env('DB_USERNAME')." password=".env('DB_PASSWORD')."',
        //                     '
        //                     select anio, periodo from tbl_utic_periodo_academico where borrado = false'
        //                 ) X (ANIO INTEGER, PERIODO INTEGER)
        //         )
        //     SELECT
        //         MVE.NUMERO_REGISTRO_ASIGNADO,
        //         MVE.ID_TIPO_MOVIMIENTO,
        //         TM.NOMBRE MOVIMIENTO,
        //         COUNT(1) COBROS_REPETIDOS
        //     FROM
        //         COREBANK.CORE_MOVIMIENTO_COBROS_ESTUDIANTE MVE
        //         JOIN COREBANK.CORE_TIPO_MOVIMIENTO TM ON MVE.ID_TIPO_MOVIMIENTO = TM.ID_TIPO_MOVIMIENTO
        //         JOIN PERIODO_ACTUAL PA ON TRUE
        //     WHERE
        //         MVE.ANIO = PA.ANIO
        //         AND MVE.PERIODO = PA.PERIODO
        //         AND MVE.BORRADO = FALSE
        //         AND TM.BORRADO = FALSE
        //         AND MVE.ID_TIPO_MOVIMIENTO != 11
        //     GROUP BY
        //         MVE.NUMERO_REGISTRO_ASIGNADO,
        //         MVE.ID_TIPO_MOVIMIENTO,
        //         TM.NOMBRE
        //     HAVING
        //         COUNT(1) > 1");

        throw New Exception('Llegamos');
        return view("sys.mallaValidacion.cobroRepetedidoEstudiantes")->with("estudiantes", $estudiantes);
    }
}
