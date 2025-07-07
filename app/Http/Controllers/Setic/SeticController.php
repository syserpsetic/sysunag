<?php

namespace App\Http\Controllers\Setic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use DB;
Use Session;
use Exception;

class SeticController extends Controller
{
    private $ruta_base_blade_setic='sys.setic.';

    function usuarios(){
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA').'/api/auth/setic/usuarios');

        if($response->status() === 403){
            return view('pages.error.403')->with('scopes', $scopes = array());
        }
        //return view('pages.error.construccion')->with('scopes', $scopes = array());
        $scopes = $response['scopes'];
        $resumen = $response['resumen'];

        return view($this->ruta_base_blade_setic.'usuarios')
        ->with('resumen',$resumen)
        ->with('scopes',$scopes)
        ;
    }

    function usuariosdata(Request $request){
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA').'/api/auth/setic/usuarios/data');

        $draw = intval($request->input('draw'));
        $start = intval($request->input('start'));
        $length = intval($request->input('length'));
        $search = $request->input('search.value');

        $estudiantesQuery = $response['estudiantesQuery'];

        // Total sin filtro
        $recordsTotal = count($estudiantesQuery);

        // Aplicar filtro si hay búsqueda
        if (!empty($search)) {
            $estudiantesQuery = array_filter($estudiantesQuery, function ($row) use ($search) {
                return stripos($row['username'], $search) !== false ||
                    stripos($row['foto'], $search) !== false ||
                    stripos($row['tipousuario'], $search) !== false||
                    stripos($row['sancion'], $search) !== false||
                    stripos($row['actualizaciondatos'], $search) !== false||
                    stripos($row['estado'], $search) !== false;
            });
        }

        $recordsFiltered = count($estudiantesQuery);

        // Cortar para paginación
        $data = array_slice($estudiantesQuery, $start, $length);

        // Respuesta
        $response = [
            "draw" => $draw,
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => array_values($data)
        ];


        return json_encode($response);

    }

    function roles(){
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA').'/api/auth/setic/roles');

        if($response->status() === 403){
            return view('pages.error.403')->with('scopes', $scopes = array());
        }
        //return view('pages.error.construccion')->with('scopes', $scopes = array());
        $scopes = $response['scopes'];
        $roles = $response['roles'];

        return view($this->ruta_base_blade_setic.'roles')
        ->with('roles',$roles)
        ->with('scopes',$scopes)
        ;
    }

    function guardar_roles(Request $request){
        $msgSuccess = null;
        $msgError = null;
        //print_r($request->all());
        try {
            //throw new Exception('Epa', true);
            $response = Http::withHeaders([
                'Authorization' => session('token'),
                'Content-Type' => 'application/json',
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/setic/roles/guardar', [
                'id' => $request->id,
                'accion' => $request->accion,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'estado' => $request->estado

            ]);
            //throw new Exception($response->status(), true);
            $data = $response->json();
            if($response->status() === 200){
                if(!$data["estatus"]){
                    $msgError = "Desde backend: ".$data["msgError"];
                }

                $msgSuccess = $data["msgSuccess"];
                $rol_list = $data["rol_list"];

            }elseif($response->status() === 403){
                $msgError = "No tiene permisos para realizar esta acción";
            }
        } catch (Exception $e) {
            $msgError = $e->getMessage();
        }

        return response()->json([
            "msgSuccess" => $msgSuccess,
            "msgError" => $msgError,
            "rol_list" => $rol_list
        ]);
    }
}
