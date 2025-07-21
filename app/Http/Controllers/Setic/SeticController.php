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
                    stripos($row['name'], $search) !== false ||
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

    function usuario_perfil($username){
        $msgSuccess = null;
        $msgError = null;
        
        $response = Http::withHeaders([
                'Authorization' => session('token'),
                'Content-Type' => 'application/json',
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/setic/usuarios/perfil', [
                'username' => $username,

            ]);

        if($response->status() === 403){
            return view('pages.error.403')->with('scopes', $scopes = array());
        }
        //return view('pages.error.construccion')->with('scopes', $scopes = array());
        $scopes = $response['scopes'];
        $user = $response['user'];
        $roles_asignados = $response['roles_asignados'];
        $roles_no_asignados = $response['roles_no_asignados'];
        $roles_activos = $response['roles_activos'];

        return view($this->ruta_base_blade_setic.'usuariosPerfil')
        ->with('user',$user)
        ->with('roles_asignados',$roles_asignados)
        ->with('roles_no_asignados',$roles_no_asignados)
        ->with('roles_activos',$roles_activos)
        ->with('scopes',$scopes)
        ;
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

    public function roles_permisos($id_rol){
        //throw New Exception($id_rol);
        $response = Http::withHeaders([
                'Authorization' => session('token'),
                'Content-Type' => 'application/json',
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/setic/roles/permisos', [
                'id_rol' => $id_rol,

            ]);

        if($response->status() === 403){
            return view('pages.error.403')->with('scopes', $scopes = array());
        }
        //return view('pages.error.construccion')->with('scopes', $scopes = array());
        $scopes = $response['scopes'];
        $permisos_asignados = $response['permisos_asignados'];
        $permisos_no_asignados = $response['permisos_no_asignados'];
        $rol = $response['rol'];

        return view($this->ruta_base_blade_setic.'rolesPermisos')
        ->with('permisos_asignados',$permisos_asignados)
        ->with('permisos_no_asignados',$permisos_no_asignados)
        ->with('rol',$rol)
        ->with('scopes',$scopes)
        ;
    }

    function guardar_roles_permisos(Request $request){
        $msgSuccess = null;
        $msgError = null;
        //print_r($request->all());
        try {
            //throw new Exception('Epa', true);
            $response = Http::withHeaders([
                'Authorization' => session('token'),
                'Content-Type' => 'application/json',
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/setic/roles/permisos/guardar', [
                'accion' => $request->accion,
                'id' => $request->id,
                'estado' => $request->estado,
                'id_rol' => $request->id_rol

            ]);
            //throw new Exception($response->status(), true);
            $data = $response->json();
            if($response->status() === 200){
                if(!$data["estatus"]){
                    $msgError = "Desde backend: ".$data["msgError"];
                }

                $msgSuccess = $data["msgSuccess"];
                $permisos_asignados_list = $data["permisos_asignados_list"];

            }elseif($response->status() === 403){
                $msgError = "No tiene permisos para realizar esta acción";
            }
        } catch (Exception $e) {
            $msgError = $e->getMessage();
        }

        return response()->json([
            "msgSuccess" => $msgSuccess,
            "msgError" => $msgError,
            "permisos_asignados_list" => $permisos_asignados_list
        ]);
    }

    function permisos(){
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA').'/api/auth/setic/permisos');

        if($response->status() === 403){
            return view('pages.error.403')->with('scopes', $scopes = array());
        }
        //return view('pages.error.construccion')->with('scopes', $scopes = array());
        $scopes = $response['scopes'];
        $permisos = $response['permisos'];
        $paginas = $response['paginas'];
        $permiso_requisito = $response['permiso_requisito'];

        return view($this->ruta_base_blade_setic.'permisos')
        ->with('permisos',$permisos)
        ->with('paginas',$paginas)
        ->with('permiso_requisito',$permiso_requisito)
        ->with('scopes',$scopes)
        ;
    }

    function guardar_permisos(Request $request){
        $msgSuccess = null;
        $msgError = null;
        $permisos_list = null;
        $roles_activos_list = null;
        //print_r($request->all());
        try {
            //throw new Exception('Epa', true);
            $response = Http::withHeaders([
                'Authorization' => session('token'),
                'Content-Type' => 'application/json',
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/setic/permisos/guardar', [
                'id' => $request->id,
                'accion' => $request->accion,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'id_pagina' => $request->id_pagina,
                'id_permiso_requisito' => $request->id_permiso_requisito,
                'estado' => $request->estado

            ]);
            //throw new Exception($response->status(), true);
            $data = $response->json();
            if($response->status() === 200){
                if(!$data["estatus"]){
                    $msgError = "Desde backend: ".$data["msgError"];
                }

                $msgSuccess = $data["msgSuccess"];
                $permisos_list = $data["permisos_list"];

            }elseif($response->status() === 403){
                $msgError = "No tiene permisos para realizar esta acción";
            }
        } catch (Exception $e) {
            $msgError = $e->getMessage();
        }

        return response()->json([
            "msgSuccess" => $msgSuccess,
            "msgError" => $msgError,
            "permisos_list" => $permisos_list
        ]);
    }

    function guardar_perfil_roles(Request $request){
        $msgSuccess = null;
        $msgError = null;
        $roles_asignados_list = null;
        $roles_activos_list = null;
        //print_r($request->all());
        try {
            //throw new Exception('Epa', true);
            $response = Http::withHeaders([
                'Authorization' => session('token'),
                'Content-Type' => 'application/json',
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/setic/usuarios/perfil/roles/guardar', [
                'id' => $request->id,
                'accion' => $request->accion,
                'id_user' => $request->id_user,
                'estado' => $request->estado

            ]);
            //throw new Exception($response->status(), true);
            $data = $response->json();
            if($response->status() === 200){
                if(!$data["estatus"]){
                    $msgError = "Desde backend: ".$data["msgError"];
                }

                $msgSuccess = $data["msgSuccess"];
                $roles_asignados_list = $data["roles_asignados_list"];
                $roles_activos_list = $data["roles_activos_list"];

            }elseif($response->status() === 403){
                $msgError = "No tiene permisos para realizar esta acción";
            }
        } catch (Exception $e) {
            $msgError = $e->getMessage();
        }

        return response()->json([
            "msgSuccess" => $msgSuccess,
            "msgError" => $msgError,
            "roles_asignados_list" => $roles_asignados_list,
            "roles_activos_list" => $roles_activos_list
        ]);
    }

    function paginas(){
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA').'/api/auth/setic/paginas');

        if($response->status() === 403){
            return view('pages.error.403')->with('scopes', $scopes = array());
        }
        //return view('pages.error.construccion')->with('scopes', $scopes = array());
        $scopes = $response['scopes'];
        $paginas = $response['paginas'];

        return view($this->ruta_base_blade_setic.'paginas')
        ->with('paginas',$paginas)
        ->with('scopes',$scopes)
        ;
    }

    function guardar_paginas(Request $request){
        $msgSuccess = null;
        $msgError = null;
        $paginas_list = null;
        //print_r($request->all());
        try {
            //throw new Exception('Epa', true);
            $response = Http::withHeaders([
                'Authorization' => session('token'),
                'Content-Type' => 'application/json',
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/setic/paginas/guardar', [
                'id' => $request->id,
                'accion' => $request->accion,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion

            ]);
            //throw new Exception($response->status(), true);
            $data = $response->json();
            if($response->status() === 200){
                if(!$data["estatus"]){
                    $msgError = "Desde backend: ".$data["msgError"];
                }

                $msgSuccess = $data["msgSuccess"];
                $paginas_list = $data["paginas_list"];

            }elseif($response->status() === 403){
                $msgError = "No tiene permisos para realizar esta acción";
            }
        } catch (Exception $e) {
            $msgError = $e->getMessage();
        }

        return response()->json([
            "msgSuccess" => $msgSuccess,
            "msgError" => $msgError,
            "paginas_list" => $paginas_list
        ]);
    }
}
