<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use geekcom\phpjasper\PHPJasper;

class CompileJasperReport extends Command
{
    protected $signature = 'jasper:compile';
    protected $description = 'Compila archivos JRXML a JASPER';

    public function handle()
    {
        $input = storage_path('App/Documents/Reports/users_report.jrxml');
        $output = storage_path('app/reports/');
        
        $jasper = new PHPJasper;
        $jasper->compile($input, $output)->execute();
        
        $this->info('Reporte compilado exitosamente a: ' . $output . 'users_report.jasper');
    }
}