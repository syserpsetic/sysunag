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
                <h4>Gestión de Solicitudes</h4>
                <p class="text-muted">UNAG</p>
              </div>
            </div>
            <div class="d-grid my-3">
              <a class="btn btn-primary" href="{{ url('/solicitudes/nueva') }}">Nueva Solicitud</a>
            </div>
            <div class="email-aside-nav collapse">
              <ul class="nav flex-column">
                <li class="nav-item {{ active_class(['solicitudes/recibidas']) }}">
                  <a class="nav-link d-flex align-items-center" href="{{ url('/solicitudes/recibidas') }}">
                    <i data-feather="inbox" class="icon-lg me-2"></i>
                    Recibidas
                    <span class="badge bg-danger fw-bolder ms-auto text-white">2
                  </a>
                </li>
                <li class="nav-item {{ active_class(['solicitudes/enviadas']) }}">
                  <a class="nav-link d-flex align-items-center" href="{{ url('/solicitudes/enviadas') }}">
                    <i data-feather="share" class="icon-lg me-2"></i>
                    Enviadas
                  </a>
                </li>
                <li class="nav-item {{ active_class(['solicitudes/proceso']) }}">
                  <a class="nav-link d-flex align-items-center" href="{{ url('/solicitudes/proceso') }}">
                    <i data-feather="refresh-ccw" class="icon-lg me-2"></i>
                    En Proceso
                    <span class="badge bg-secondary fw-bolder ms-auto text-white">4
                  </a>
                </li>
                <li class="nav-item {{ active_class(['solicitudes/terminadas']) }}">
                  <a class="nav-link d-flex align-items-center" href="{{ url('/solicitudes/terminadas') }}">
                    <i data-feather="check-circle" class="icon-lg me-2"></i>
                    Terminadas
                  </a>
                </li>
                <!-- <li class="nav-item">
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
            <div class="d-flex align-items-center justify-content-between p-3 border-bottom tx-16">
              <div class="d-flex align-items-center">
                <!--<i data-feather="star" class="text-primary icon-lg me-2"></i>-->
                <span>Secretaria General</span>
              </div>
              <div>
                <span>Remisiones</span>
                <!-- <a class="me-2" type="button" data-bs-toggle="tooltip" data-bs-title="Forward"><i data-feather="share" class="text-muted icon-lg"></i></a>
                <a class="me-2" type="button" data-bs-toggle="tooltip" data-bs-title="Print"><i data-feather="printer" class="text-muted icon-lg"></i></a>
                <a type="button" data-bs-toggle="tooltip" data-bs-title="Delete"><i data-feather="trash" class="text-muted icon-lg"></i></a> -->
                <button type="button" class="btn btn-success btn-xs">Externa</button>
                <button type="button" class="btn btn-info btn-xs">Interna</button>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-between flex-wrap px-3 py-2 border-bottom">
              <div class="d-flex align-items-center">
                <div class="me-2">
                  <img src="{{ url('https://via.placeholder.com/36x36') }}" alt="Avatar" class="rounded-circle img-xs" onerror="this.onerror=null; this.src='{{ url(asset('/assets/images/user2-403d6e88.png')) }}';">
                </div>
                <div class="d-flex align-items-center">
                  <a href="#" class="text-body">Juana Iris Barahona</a> 
                  <span class="mx-2 text-muted">para</span>
                  <a href="#" class="text-body me-2">SETIC</a>
                  <!-- <div class="actions dropdown">
                    <a href="#" data-bs-toggle="dropdown"><i data-feather="chevron-down" class="icon-lg text-muted"></i></a>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item" href="#">Mark as read</a>
                      <a class="dropdown-item" href="#">Mark as unread</a>
                      <a class="dropdown-item" href="#">Spam</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item text-danger" href="#">Delete</a>
                    </div>
                  </div> -->
                </div>
              </div>
              <div class="tx-13 text-muted mt-2 mt-sm-0">Nov 20, 11:20 AM</div>
            </div>
            <div class="p-4 border-bottom">
              <p>Estimados,</p>
                <br>
                <p>
                A la SETIC:  
                Por este medio solicitamos muy respetuosamente realizar el cambio de carrera del estudiante Juan Pérez, con número de cuenta 25A0000, de la carrera de Ingeniería Agronómica a la carrera de Administracón de Empresas.  
                Agradecemos su pronta gestión y confirmación de este trámite.
                </p>
                <br>
                <p><strong>Atentamente</strong>,<br> Juana Iris Barahona</p>
            </div>
            <div class="p-3">
            <div class="mb-3">Adjuntos <span>(2 archivos, 1.25 MB)</span></div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                    <a href="javascript:;" class="nav-link text-body">
                        <span data-feather="file" class="icon-lg text-muted"></span> SolicitudCambioCarrera.docx 
                        <span class="text-muted tx-11">(250 KB)</span>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="javascript:;" class="nav-link text-body">
                        <span data-feather="file" class="icon-lg text-muted"></span> PlanEstudio_Carreras.pdf 
                        <span class="text-muted tx-11">(1 MB)</span>
                    </a>
                    </li>
                </ul>
            </div>

          </div>
        </div>
        
      </div>
    </div>
  </div>
</div>
@endsection