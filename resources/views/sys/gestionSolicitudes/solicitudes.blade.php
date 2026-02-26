@extends('layout.master')

@section('content')
<div class="row inbox-wrapper">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3 border-end-lg">
            <div class="d-flex align-items-center justify-content-between">
              <button class="navbar-toggle btn btn-icon border d-block d-lg-none" data-bs-target=".email-aside-nav" data-bs-toggle="collapse" type="button">
                <span class="icon"><i data-feather="chevron-down"></i></span>
              </button>
              <div class="order-first">
                <h4><b>Gestión de Solicitudes</b></h4>
                <img src="{{ url(asset('/assets/images/UNAG_COLOR.png')) }}" alt="Logo" style="height: 40px; width: auto; margin-right: 5px;">
              </div>
            </div>
            <div class="d-grid my-3">
              <a class="btn btn-primary" href="{{ url('/gestion_solicitudes/nueva') }}"><i data-feather="edit" class="icon-lg me-2"></i> Nueva Solicitud</a>
            </div>
            <div class="email-aside-nav collapse">
              <ul class="nav flex-column">
                <li class="nav-item {{ active_class(['gestion_solicitudes/recibidas']) }}">
                  <a class="nav-link d-flex align-items-center" href="{{ url('/gestion_solicitudes/recibidas') }}">
                    <i data-feather="inbox" class="icon-lg me-2"></i>
                    Recibidas
                    @if($conteo_solicitudes['nuevas'] > 0)
                        <span class="badge bg-danger fw-bolder ms-auto text-white">{{$conteo_solicitudes['nuevas']}}</span>
                    @endif
                  </a>
                </li>
                <li class="nav-item {{ active_class(['gestion_solicitudes/enviadas']) }}">
                  <a class="nav-link d-flex align-items-center" href="{{ url('/gestion_solicitudes/enviadas') }}">
                    <i data-feather="send" class="icon-lg me-2"></i>
                    Enviadas
                    @if($conteo_solicitudes['enviadas_sin_leer'] > 0)
                        <span class="badge bg-warning fw-bolder ms-auto text-dark">{{$conteo_solicitudes['enviadas_sin_leer']}}</span>
                    @endif
                  </a>
                </li>
                <!-- <li class="nav-item {{ active_class(['gestion_solicitudes/proceso']) }}">
                  <a class="nav-link d-flex align-items-center" href="{{ url('/gestion_solicitudes/proceso') }}">
                    <i data-feather="refresh-ccw" class="icon-lg me-2"></i>
                    En Proceso
                    <span class="badge bg-secondary fw-bolder ms-auto text-white">4
                  </a>
                </li>
                <li class="nav-item {{ active_class(['gestion_solicitudes/terminadas']) }}">
                  <a class="nav-link d-flex align-items-center" href="{{ url('/gestion_solicitudes/terminadas') }}">
                    <i data-feather="check-circle" class="icon-lg me-2"></i>
                    Terminadas
                  </a>
                </li>
                <li class="nav-item {{ active_class(['gestion_solicitudes/vencidas']) }}">
                  <a class="nav-link d-flex align-items-center" href="{{ url('/gestion_solicitudes/vencidas') }}">
                    <i data-feather="alert-triangle" class="icon-lg me-2"></i>
                    Vencidas
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center" href="#">
                    <i data-feather="star" class="icon-lg me-2"></i>
                    Tags
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center" href="#">
                    <i data-feather="trash" class="icon-lg me-2"></i>
                    Trash
                  </a>
                </li>
              </ul>
              <p class="text-muted tx-12 fw-bolder text-uppercase mb-2 mt-4">Labels</p>
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center" href="#">
                    <i data-feather="tag" class="text-warning icon-lg me-2"></i>
                    Important
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center" href="#">
                  <i data-feather="tag" class="text-primary icon-lg me-2"></i> 
                  Business 
                </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center" href="#">
                    <i data-feather="tag" class="text-info icon-lg me-2"></i> 
                    Inspiration 
                  </a>
                </li> -->
              </ul>
            </div>
          </div>
          <div class="col-lg-9">
            @yield('content_gs')
          </div>
        </div>
        
      </div>
    </div>
  </div>
</div>
@endsection