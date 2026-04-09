<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReportsController extends Controller
{
    public function cuadroCalificacionesSeccion(Request $request, $docenteId, $seccionId, $idAsignatura)
    {
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA') . "/api/auth/docentes/{$docenteId}/secciones/{$seccionId}/calificaciones/{$idAsignatura}/cuadro");

        if ($response->status() === 403) {
            abort(403);
        }

        return response($response->body(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="Cuadro de Calificaciones - Seccion ' . $seccionId . '.pdf"');
    }

    public function cuadroCalificacionesModulo(Request $request, $docenteId, $bloqueModuloId, $idModulo)
    {
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA') . "/api/auth/docentes/{$docenteId}/bloques-modulo/{$bloqueModuloId}/cuadro");

        if ($response->status() === 403) {
            abort(403);
        }

        return response($response->body(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="Cuadro de Calificaciones - Modulo ' . $bloqueModuloId . '.pdf"');
    }

    public function reportePrematricula(Request $request, $registro)
    {
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->timeout(120)->get(env('API_BASE_URL_ZETA') . "/api/auth/estudiantes/{$registro}/reporte/prematricula");

        if ($response->status() === 403) {
            abort(403);
        }

        return response($response->body(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="prematricula_' . $registro . '.pdf"');
    }

    public function reporte_proveedores(Request $request, $fecha1,$fecha2,$proveedor)
    {
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->timeout(120)->get(env('API_BASE_URL_ZETA') . "/api/auth/almacen/reporte_proveedores/{$fecha1}/{$fecha2}/{$proveedor}");

        if ($response->status() === 403) {
            abort(403);
        }

        return response($response->body(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="proveedores_' . $fecha1 . '.pdf"');
    }

      public function reporte_areas(Request $request, $fecha1,$fecha2,$area)
    {
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->timeout(120)->get(env('API_BASE_URL_ZETA') . "/api/auth/almacen/reporte_area/{$fecha1}/{$fecha2}/{$area}");

        if ($response->status() === 403) {
            abort(403);
        }

        return response($response->body(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="area_' . $fecha1 . '.pdf"');
    }

}