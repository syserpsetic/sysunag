<?php

namespace App\Http\Controllers\Egresados;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use DB;
Use Session;
use Exception;

class EgresadosController extends Controller
{
    public function ver_datos_generales(){

        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA').'/api/auth/egresados/datos_generales');

        if($response->status() === 403){
            return view('pages.error.403')->with('scopes', $scopes = array());
        }
        
        //throw new Exception($response->status());
        $scopes = $response['scopes'];
        $datos_generales = $response['datos_generales'];
        $departamentos = $response['departamentos'];
        $datos_academicos = $response['datos_academicos'];
        $paises = $response['paises'];
        $tipos_grados_academicos = $response['tipos_grados_academicos'];
        $experiencia_laboral = $response['experiencia_laboral'];

        return view("sys.egresados.datos_generales")
        ->with("datos_generales", $datos_generales)
        ->with("departamentos", $departamentos)
        ->with("scopes", $scopes)
        ->with("datos_academicos", $datos_academicos)
        ->with("paises", $paises)
        ->with("tipos_grados_academicos", $tipos_grados_academicos)
        ->with("experiencia_laboral", $experiencia_laboral)
        ;
    }

    public function ver_municipios(Request $request){
        $msgSuccess = null;
        $msgError = null;

        $response = Http::withHeaders([
                'Authorization' => session('token'),
                'Content-Type' => 'application/json',
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/egresados/datos_generales/municipios', [
                'departamento' => $request->departamento,
            ]);

        if($response->status() === 403){
            return view('pages.error.403')->with('scopes', $scopes = array());
        }
        
        //throw new Exception($response->status());
        $scopes = $response['scopes'];
        $municipios = $response['municipios'];

        return response()->json([
            "msgSuccess" => $msgSuccess,
            "msgError" => $msgError,
            "municipios" => $municipios
        ]);
    }

    public function guardar_datos_generales(Request $request){
        $msgSuccess = null;
        $msgError = null;
        //dd($request->all());
        try {
            //throw new Exception('Epa', true);
            $response = Http::withHeaders([
                'Authorization' => session('token'),
                'Content-Type' => 'application/json',
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/egresados/datos_generales/guardar', [
                'id' => $request->id,
                'primer_nombre_estudiante' => $request->primer_nombre_estudiante,
                'segundo_nombre_estudiante' => $request->segundo_nombre_estudiante,
                'primer_apellido_estudiante' => $request->primer_apellido_estudiante,
                'segundo_apellido_estudiante' => $request->segundo_apellido_estudiante,
                'correo_electronico' => $request->correo_electronico,
                'identidad_estudiante' => $request->identidad_estudiante,
                'direccion_local_telefono' => $request->direccion_local_telefono,
                'fecha_nacimiento_estudiante' => $request->fecha_nacimiento_estudiante,
                'gender_radio' => $request->gender_radio,
                'departamento' => $request->departamento,
                'municipio' => $request->municipio,
                'direccion_local_barrio_colonia' => $request->direccion_local_barrio_colonia,
            ]);
            //throw new Exception($response->status(), true);
            $data = $response->json();
            if($response->status() === 200){
                if(!$data["estatus"]){
                    $msgError = "Desde backend: ".$data["msgError"];
                }

                $msgSuccess = $data["msgSuccess"];
                //$zona_list = $data["zona_list"];
                //throw New Exception($estados_list, true);
            }elseif($response->status() === 403){
                $msgError = "No tiene permisos para realizar esta acción";
            }
        } catch (Exception $e) {
            $msgError = $e->getMessage();
        }

        return response()->json([
            "msgSuccess" => $msgSuccess,
            "msgError" => $msgError
        ]);
        ;
    }

    public function guardar_datos_academicos(Request $request){
        $msgSuccess = null;
        $msgError = null;
        //dd($request->all());
        try {
            //throw new Exception($request->formacion, true);
            $response = Http::withHeaders([
                'Authorization' => session('token'),
                'Content-Type' => 'application/json',
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/egresados/datos_academicos/guardar', [
                'accion' => $request->accion,
                'id' => $request->id,
                'numero_registro_asignado' => $request->numero_registro_asignado,
                'formacion' => $request->formacion,
                'institucion' => $request->institucion,
                'id_pais' => $request->id_pais,
                'id_grado_cademico' => $request->id_grado_cademico,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'descripcion' => $request->descripcion
            ]);
            //throw new Exception($response->status(), true);
            $data = $response->json();
            if($response->status() === 200){
                if(!$data["estatus"]){
                    $msgError = "Desde backend: ".$data["msgError"];
                }

                $msgSuccess = $data["msgSuccess"];
                //$zona_list = $data["zona_list"];
                //throw New Exception($estados_list, true);
            }elseif($response->status() === 403){
                $msgError = "No tiene permisos para realizar esta acción";
            }
        } catch (Exception $e) {
            $msgError = $e->getMessage();
        }

        return response()->json([
            "msgSuccess" => $msgSuccess,
            "msgError" => $msgError
        ]);
    }

    public function guardar_esperiencia_laboral(Request $request){
        $msgSuccess = null;
        $msgError = null;
        //dd($request->all());
        try {
            //throw new Exception($request->puesto, true);
            $response = Http::withHeaders([
                'Authorization' => session('token'),
                'Content-Type' => 'application/json',
            ])->post(env('API_BASE_URL_ZETA').'/api/auth/egresados/esperiencia_laboral/guardar', [
                'accion' => $request->accion,
                'id' => $request->id,
                'numero_registro_asignado' => $request->numero_registro_asignado,
                'puesto' => $request->puesto,
                'empleador' => $request->empleador,
                'departamento' => $request->departamento,
                'lugar' => $request->lugar,
                'fecha_inicio_experiencia_laboaral' => $request->fecha_inicio_experiencia_laboaral,
                'fecha_fin_experiencia_laboaral' => $request->fecha_fin_experiencia_laboaral,
                'descripcion_experiencia_laboaral' => $request->descripcion_experiencia_laboaral
            ]);
            //throw new Exception($response->status(), true);
            $data = $response->json();
            if($response->status() === 200){
                if(!$data["estatus"]){
                    $msgError = "Desde backend: ".$data["msgError"];
                }

                $msgSuccess = $data["msgSuccess"];
                //$zona_list = $data["zona_list"];
                //throw New Exception($estados_list, true);
            }elseif($response->status() === 403){
                $msgError = "No tiene permisos para realizar esta acción";
            }
        } catch (Exception $e) {
            $msgError = $e->getMessage();
        }

        return response()->json([
            "msgSuccess" => $msgSuccess,
            "msgError" => $msgError
        ]);
    }
}
