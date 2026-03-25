<?php

namespace App\Http\Controllers\Almacen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\View\View;
use DB;
Use Session;
use Exception;
use Mail;


class AlmacenController extends Controller
{


    public function almacen_dashboard(Request $request)
    {
        try {
            // Obtener pacientes
            $responsePacientes = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/psicologia/pacientes');

            if($responsePacientes->status() === 403){
                return view('pages.error.403')->with('scopes', []);
            }

            // Obtener tipo_cita
            $responseTipoCita = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/psicologia/tipos-cita');

            if($responseTipoCita->status() === 403){
                return view('pages.error.403')->with('scopes', []);
            }

            // Obtener empleados (anteriormente profesionales)
            $responseEmpleados = Http::withHeaders([
                'Authorization' => session('token'),
            ])->get(env('API_BASE_URL_ZETA').'/api/auth/psicologia/empleados');

            if($responseEmpleados->status() === 403){
                return view('pages.error.403')->with('scopes', []);
            }

            $scopes = $responsePacientes->json('scopes', []);
            $pacientes = $responsePacientes->json('pacientes', []);
            $empleados = $responseEmpleados->json('empleados', []);
            $tipocita = $responseTipoCita->json('tipos_cita', []);

            return view("sys.almacen.dashboard")
                ->with("pacientes", $pacientes)
                ->with("empleados", $empleados)
                ->with("tipos_cita", $tipocita)
                ->with('scopes', $scopes);

        } catch (Exception $e) {
            return view("sys.almacen.dashboard")
                ->with("pacientes", [])
                ->with("empleados", [])
                ->with("tipos_cita", [])
                ->with('scopes', [])
                ->with('error', 'Error al cargar datos: ' . $e->getMessage());
        }
    }
}