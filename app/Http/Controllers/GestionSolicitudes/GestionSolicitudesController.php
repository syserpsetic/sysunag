<?php

namespace App\Http\Controllers\GestionSolicitudes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\View\View;
use DB;
Use Session;
use Exception;

class GestionSolicitudesController extends Controller
{
    public function ver_solicitudes_recibidas(){
         $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA').'/api/auth/gestion_solicitudes/recibidas');

        if($response->status() === 500){
                return view('pages.error.500')->with('scopes', $scopes = array());
        }

        if($response->status() === 403){
            return view('pages.error.403')->with('scopes', $scopes = array());
        }
        
        //throw new Exception($response->status());
        $scopes = $response['scopes'];
        $solicitudes_recibidas = $response['solicitudes_recibidas'];
        $conteo_solicitudes_nuevas = $response['conteo_solicitudes_nuevas'];

        return view("sys.gestionSolicitudes.solicitudesRecibidas")
        ->with("scopes", $scopes)
        ->with("solicitudes_recibidas", $solicitudes_recibidas)
        ->with("conteo_solicitudes_nuevas", $conteo_solicitudes_nuevas)
        ;
    }

    public function ver_solicitudes_leer(){
        return view('sys/gestionSolicitudes/solicitudesLeer')->with('scopes', array());
    }

    public function ver_solicitudes_nueva(){
         $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA').'/api/auth/gestion_solicitudes/nueva');

        //throw new Exception($response->status());

        if($response->status() === 500){
                return view('pages.error.500')->with('scopes', $scopes = array());
        }

        if($response->status() === 403){
            return view('pages.error.403')->with('scopes', $scopes = array());
        }
        
        $scopes = $response['scopes'];
        $departamentos = $response['departamentos'];
        $conteo_solicitudes_nuevas = $response['conteo_solicitudes_nuevas'];

        return view("sys.gestionSolicitudes.solicitudesNueva")
        ->with("scopes", $scopes)
        ->with("departamentos", $departamentos)
        ->with("conteo_solicitudes_nuevas", $conteo_solicitudes_nuevas)
        ;
    }

    public function guardar_solicitudes_nueva(Request $request){
        $msgSuccess = null;
        $msgError = null;
        $archivos = array();
        $archivos = $request->file('archivos');

        try {
            // Prepara la solicitud HTTP
            $http = Http::withHeaders([
                'Authorization' => session('token'),
            ])->asMultipart();

            // Adjunta todos los archivos
            if($request->hasFile('archivos')) {
                foreach ($archivos as $archivo) {
                    $http = $http->attach(
                        'adjuntos[]',                              // nombre del campo esperado por la API
                        fopen($archivo->getPathname(), 'r'),       // contenido del archivo
                        $archivo->getClientOriginalName()          // nombre original
                    );
                }
            }

            // Envía la solicitud POST con los demás datos
            $response = $http->post(env('API_BASE_URL_ZETA').'/api/auth/gestion_solicitudes/nueva/guardar', [
                'departamento' => $request->departamento,
                'descripcion'  => $request->descripcion,
            ]);


            //throw new Exception($response->status(), true);
            $data = $response->json();
            if($response->status() === 200){
                if(!$data["estatus"]){
                    throw new Exception("Desde backend: ".$data["msgError"]);
                }
                $id_solicitud = $data["id_solicitud"];
                $trazabilidad = $data["id_trazabilidad"];
                //Verificar si hay archivos
                if($request->hasFile('archivos')) {
                    $archivos = $request->file('archivos'); // Esto es un array de UploadedFile

                    foreach($archivos as $archivo) {
                        // Guardar cada archivo en storage/app/public/solicitudes
                        $nombre = $archivo->getClientOriginalName();
                        $archivo->storeAs('public/adjuntos_gestion_solicitudes/solicitud_'.$id_solicitud.'/trazabilidad_'.$trazabilidad, $nombre);
                    }
                }
                $msgSuccess = $data["msgSuccess"];
            }elseif($response->status() === 403){
                $msgError = "No tiene permisos para realizar esta acción";
            }elseif($response->status() === 500){
                throw new Exception("Desde backend: ".$data["msgError"]);
            }
        } catch (Exception $e) {
            $msgError = $e->getMessage();
        }

        return response()->json([
            "msgSuccess" => $msgSuccess,
            "msgError" => $msgError
        ]);
    }

    public function ver_solicitudes_enviadas(){
        return view('sys/gestionSolicitudes/solicitudesEnviadas')->with('scopes', array());
    }

    public function ver_solicitudes_proceso(){
        return view('sys/gestionSolicitudes/solicitudesProceso')->with('scopes', array());
    }

    public function ver_solicitudes_terminadas(){
        return view('sys/gestionSolicitudes/solicitudesTerminadas')->with('scopes', array());
    }

    public function ver_solicitudes_trazabilidad(){
        return view('sys/gestionSolicitudes/solicitudesTrazabilidad')->with('scopes', array());
    }

    public function ver_solicitudes_vencidas(){
        return view('sys/gestionSolicitudes/solicitudesVencidas')->with('scopes', array());
    }
}
