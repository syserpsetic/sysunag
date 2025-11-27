<?php

namespace App\Http\Controllers\Indicadores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\View\View;
use DB;
Use Session;
use Exception;
use Illuminate\Support\Facades\Storage;

class IndicadoresController extends Controller
{
    public function indicadores(){
        $response = Http::withHeaders([
            'Authorization' => session('token'),
        ])->get(env('API_BASE_URL_ZETA').'/api/auth/indicadores');

        if($response->status() === 500){
                return view('pages.error.500')->with('scopes', $scopes = array());
        }

        if($response->status() === 403){
            return view('pages.error.403')->with('scopes', $scopes = array());
        }
        
        //throw new Exception($response->status());
        $scopes = $response['scopes'];
        $conteo_empleados = $response['conteo_empleados'];

        return view("sys.indicadores.indicadores")
        ->with("scopes", $scopes)
        ->with("conteo_empleados", $conteo_empleados)
        ;
    }
}
