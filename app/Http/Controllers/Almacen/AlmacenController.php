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
        $scopes = new ControladorPermisos();
        $scopes = $scopes->ver_permisos();

        return view("sys.almacen.dashboard")->with('scopes', $scopes);       
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


}