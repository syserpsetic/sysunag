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


     public function reporte_facturas(Request $request, $id)
    {
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->timeout(120)->get(env('API_BASE_URL_ZETA') . "/api/auth/almacen/reporte_facturas/{$id}");

        if ($response->status() === 403) {
            abort(403);
        }

        return response($response->body(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="factura_' . $id . '.pdf"');
    }



     public function reporteSolevenciaAdministrativa(Request $request, $numero_registro_asignado)
    {
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->timeout(120)->get(env('API_BASE_URL_ZETA') . "/api/auth/secretariageneral/estudiantes/perfil/reporte/{$numero_registro_asignado}");

        if ($response->status() === 403) {
            abort(403);
        }

        return response($response->body(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="solvencia_administrativa_' . $numero_registro_asignado . '.pdf"');
    }

   public function reporteSolvenciaRegistro(Request $request, $numero_registro_asignado)
    {
        $respuesta_peticion_pdf = Http::withHeaders([
            'Authorization' => session('token'),
        ])->timeout(120)->get(env('API_BASE_URL_ZETA') . "/api/auth/secretariageneral/estudiantes/perfil/reporteregistro/{$numero_registro_asignado}");

        if ($respuesta_peticion_pdf->status() === 403) {
            abort(403);
        }

        return response($respuesta_peticion_pdf->body(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="solvencia_registro_' . $numero_registro_asignado . '.pdf"');
    }

    public function reporteSolvenciaArchivo(Request $request, $numero_registro_asignado)
    {
        $respuesta_peticion_pdf = Http::withHeaders([
            'Authorization' => session('token'),
        ])->timeout(120)->get(env('API_BASE_URL_ZETA') . "/api/auth/secretariageneral/estudiantes/perfil/reportearchivo/{$numero_registro_asignado}");

        if ($respuesta_peticion_pdf->status() === 403) {
            abort(403);
        }

        if (!$respuesta_peticion_pdf->successful()) {
            return "Error desde Zeta (Solvencia Archivo): " . $respuesta_peticion_pdf->body();
        }

        return response($respuesta_peticion_pdf->body(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="solvencia_archivo_' . $numero_registro_asignado . '.pdf"');
    }

}
