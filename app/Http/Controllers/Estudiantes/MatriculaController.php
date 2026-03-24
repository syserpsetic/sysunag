<?php

namespace App\Http\Controllers\Estudiantes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MatriculaController extends Controller
{
    public function ver_prematricula(Request $request, $registro)
    {
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA') . "/api/auth/estudiantes/{$registro}/matricula");

        if ($response->status() === 403) {
            return view('pages.error.403')->with('scopes', []);
        }

        if (!$response->successful()) {
            $error = $response->json('error') ?? 'Error al cargar la matrícula (HTTP ' . $response->status() . ')';
            abort(500, $error);
        }

        $data = $response->json();

        return view('sys.estudiantes.prematricula', [
            'informacion_estudiante'                  => $data['informacion_estudiante'],
            'listado_asignaturas_modulos'              => $data['listado_asignaturas_modulos'],
            'listado_asignaturas_modulos_matriculados' => $data['listado_asignaturas_modulos_matriculados'],
            'saldo'                                   => $data['saldo'],
            'conteo_modulos_asignaturas_matriculadas'  => $data['conteo_modulos_asignaturas_matriculadas'],
            'periodo_actual'                          => $data['periodo_actual'],
            'scopes'                                  => $data['scopes'] ?? [],
            'numero_registro_asignado'                => $registro,
        ]);
    }

    public function guardar_prematricula(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->post(env('API_BASE_URL_ZETA') . '/api/auth/estudiantes/matricula/guardar', $request->all());

        if ($response->status() === 403) {
            return view('pages.error.403')->with('scopes', []);
        }

        return response()->json($response->json());
    }

    public function desmatricular(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->post(env('API_BASE_URL_ZETA') . '/api/auth/estudiantes/matricula/desmatricular', $request->all());

        if ($response->status() === 403) {
            return view('pages.error.403')->with('scopes', []);
        }

        return response()->json($response->json());
    }
}
