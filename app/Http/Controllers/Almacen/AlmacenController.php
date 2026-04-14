<?php

namespace App\Http\Controllers\Almacen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\View\View;
use App\Http\Controllers\ControladorPermisos;
use DB;
Use Session;
use Exception;
use Mail;


class AlmacenController extends Controller
{


    public function almacen_dashboard(Request $request)
    {       
        //$scopes = new ControladorPermisos();
        //$scopes = $scopes->ver_permisos();

         $proveedores_list = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/almacen/proveedores');

            if($proveedores_list->status() === 403){
                return view('pages.error.403')->with('scopes', []);
            }

            $area_list = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/almacen/areas');

            if($area_list->status() === 403){
                return view('pages.error.403')->with('scopes', []);
            }

            $scopes = $proveedores_list->json('scopes', []);
            $proveedores_list = $proveedores_list->json('proveedores_list', []);
            $area_list = $area_list->json('area_list', []);

        return view("sys.almacen.dashboard")->with('scopes', $scopes)->with('proveedores_list', $proveedores_list)->with('area_list', $area_list);       
    }

    public function almacen_resumen(Request $request)
    {
        
     
        try {
            // Enviar solicitud al backend unag_service
            $response = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Authorization' => session('token'),
                    'Accept' => 'application/json'
                ])
                ->get(env('API_BASE_URL_ZETA')."/api/auth/almacen/resumen");
            
            // Procesar respuesta
            if ($response->successful()) {
                $data = $response->json();
                
                return response()->json([
                    'estatus' => true,
                    'mensaje' => 'Resumen obtenidas exitosamente',
                    'estadisticas' => $data['estadisticas'] ?? []
                ]);
            }
            
            // Manejar errores del backend
            $errorData = $response->json();
            return response()->json([
                'estatus' => false,
                'mensaje' => $errorData['msgError'] ?? 'Error al obtener resumen',
                'error' => $errorData
            ], $response->status());
            
        } catch (ConnectionException $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error de conexión con el servicio de resumen: '.$e->getMessage()
            ], 503);
            
        } catch (Exception $e) {
            return response()->json([
                'estatus' => false,
                'mensaje' => 'Error inesperado: '.$e->getMessage()
            ], 500);
        }
    }

      function almacen_factura(){
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA').'/api/auth/almacen/factura');

        if($response->status() === 403){
            return view('pages.error.403')->with('scopes', $scopes = array());
        }
        //return view('pages.error.construccion')->with('scopes', $scopes = array());
        $scopes = $response['scopes'];
        $resumen = $response['resumen'];


        return view('sys.almacen.factura')
        ->with('resumen',$resumen)
        ->with('scopes',$scopes)
        ;
    }


    function almacen_factura_data(Request $request){
       $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA').'/api/auth/almacen/factura/data');

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
                return stripos($row['n_factura'], $search) !== false ||
                    stripos($row['usuario'], $search) !== false ||
                    stripos($row['fecha_libros'], $search) !== false;
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


}