<?php

namespace App\Http\Controllers\Egresados;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPJasper\PHPJasper;
use Illuminate\View\View;

class ReportsEgresadosController extends Controller
{
    public function prueba()
    {
        $jasper = new PHPJasper;

        // Ruta directa al java.exe de Java 8
        $java8Path = '"C:\Program Files\Java\jdk1.8.0_251\bin\java.exe"'; // Cambia por tu ruta real

        $input = base_path('App/Documents/Reports/users_report.jrxml');
        $output = public_path('\documentos\reportes');

        $inputCompilado = 'users_report.jasper';

        if(!file_exists($inputCompilado)){
            $jasper=new PHPJasper;
            $jasper-> compile($input)->execute();
        }

        // Ejecutar Jasper usando Java 8
        $jasper->process(
            $input,
            $output,
            ['format' => ['pdf']]
        )->execute();

        // Ruta al PDF generado
        $file = $output . '/sample.pdf';

        // Mostrar en el navegador
        return response()->file($file);
    }
}
