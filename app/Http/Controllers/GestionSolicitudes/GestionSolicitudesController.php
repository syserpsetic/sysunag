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
        return view('sys/gestionSolicitudes/solicitudesRecibidas')->with('scopes', array());
    }

    public function ver_solicitudes_leer(){
        return view('sys/gestionSolicitudes/solicitudesLeer')->with('scopes', array());
    }

    public function ver_solicitudes_nueva(){
        return view('sys/gestionSolicitudes/solicitudesNueva')->with('scopes', array());
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
