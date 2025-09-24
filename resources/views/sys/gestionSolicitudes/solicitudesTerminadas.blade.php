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
                <li class="nav-item {{ active_class(['solicitudes/vencidas']) }}">
                  <a class="nav-link d-flex align-items-center" href="{{ url('/solicitudes/vencidas') }}">
                    <i data-feather="alert-triangle" class="icon-lg me-2"></i>
                    Vencidas
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
            <div class="p-3 border-bottom">
              <div class="row align-items-center">
                <div class="col-lg-6">
                  <div class="d-flex align-items-end mb-2 mb-md-0">
                    <i data-feather="check-circle" class="text-muted me-2"></i>
                    <h4 class="me-1">Solicitudes Terminadas</h4>
                    <!-- <span class="text-muted">(2 solitudes nuevas)</span> -->
                  </div>
                </div>
                <div class="col-lg-6">
                  <!-- <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search mail...">
                    <button class="btn btn-light btn-icon" type="button" id="button-search-addon"><i data-feather="search"></i></button>
                  </div> -->
                </div>
              </div>
            </div>
            <div class="p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap">
              <!-- <div class="d-none d-md-flex align-items-center flex-wrap">
                <div class="form-check me-3">
                  <input type="checkbox" class="form-check-input" id="inboxCheckAll">
                </div>
                <div class="btn-group me-2">
                  <button class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" type="button"> With selected <span class="caret"></span></button>
                  <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" href="#">Mark as read</a>
                    <a class="dropdown-item" href="#">Mark as unread</a><a class="dropdown-item" href="#">Spam</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#">Delete</a>
                  </div>
                </div>
                <div class="btn-group me-2">
                  <button class="btn btn-outline-primary" type="button">Archive</button>
                  <button class="btn btn-outline-primary" type="button">Span</button>
                  <button class="btn btn-outline-primary" type="button">Delete</button>
                </div>
                <div class="btn-group me-2 d-none d-xl-block">
                  <button class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" type="button">Order by <span class="caret"></span></button>
                  <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" href="#">Date</a>
                    <a class="dropdown-item" href="#">From</a>
                    <a class="dropdown-item" href="#">Subject</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Size</a>
                  </div>
                </div>
              </div>
              <div class="d-flex align-items-center justify-content-end flex-grow-1">
                <span class="me-2">1-10 of 253</span>
                <div class="btn-group">
                  <button class="btn btn-outline-secondary btn-icon" type="button"><i data-feather="chevron-left"></i></button>
                  <button class="btn btn-outline-secondary btn-icon" type="button"><i data-feather="chevron-right"></i></button>
                </div>
              </div> -->
            </div>
            <div class="email-list">
              
             <!-- email list item -->
            <div class="email-list-item">
            <!--<div class="email-list-actions">
                <div class="form-check">
                <input type="checkbox" class="form-check-input">
                </div>
                <a class="favorite" href="javascript:;"><span><i data-feather="star"></i></span></a>
            </div>-->
            <a href="{{ url('/solicitudes/trazabilidad') }}" class="email-list-detail">
                <div class="content">
                <span class="from">Recursos Humanos</span>
                <p class="msg">Estimados, les recordamos que el plazo para la actualización de expedientes del personal administrativo vence el 20 de marzo. Por favor, entregue la documentación requerida en la plataforma de gestión de talento humano.</p>
                </div>
                <span class="date">
                <span class="icon"><i data-feather="paperclip"></i> </span>
                14 Mar
                </span>
            </a>
            </div>

            <!-- email list item -->
            <div class="email-list-item">
            <!--<div class="email-list-actions">
                <div class="form-check">
                <input type="checkbox" class="form-check-input">
                </div>
                <a class="favorite" href="#"><span><i data-feather="star" class="text-warning"></i></span></a>
            </div>-->
            <a href="{{ url('/solicitudes/trazabilidad') }}" class="email-list-detail">
                <div class="content">
                <span class="from">Dirección Académica de Autoevaluación y Acreditación para la Calidad Educativa</span>
                <p class="msg">Se comunica a los coordinadores de carrera que la próxima reunión de seguimiento a los procesos de acreditación se realizará el día 25 de marzo. Favor preparar los informes de avance.</p>
                </div>
                <span class="date">
                <span class="icon"><i data-feather="paperclip"></i> </span>
                18 Mar
                </span>
            </a>
            </div>

            <!-- email list item -->
            <div class="email-list-item">
            <!--<div class="email-list-actions">
                <div class="form-check">
                <input type="checkbox" class="form-check-input">
                </div>
                <a class="favorite" href="javascript:;"><span><i data-feather="star"></i></span></a>
            </div>-->
            <a href="{{ url('/solicitudes/trazabilidad') }}" class="email-list-detail">
                <div class="content">
                <span class="from">Dirección Académica del Sistema de Educación a Distancia</span>
                <p class="msg">Estimados docentes, se informa que la plataforma de clases virtuales tendrá mantenimiento el próximo fin de semana. Por favor, tomen las previsiones necesarias con sus actividades académicas.</p>
                </div>
                <span class="date">
                22 Mar
                </span>
            </a>
            </div>

            <!-- email list item -->
            <div class="email-list-item">
            <!--<div class="email-list-actions">
                <div class="form-check">
                <input type="checkbox" class="form-check-input">
                </div>
                <a class="favorite" href="javascript:;"><span><i data-feather="star"></i></span></a>
            </div>-->
            <a href="{{ url('/solicitudes/trazabilidad') }}" class="email-list-detail">
                <div class="content">
                <span class="from">Asesoría Legal</span>
                <p class="msg">Se recuerda a todas las unidades académicas que cualquier convenio interinstitucional debe ser revisado y validado previamente por esta oficina. Favor remitir los documentos con anticipación.</p>
                </div>
                <span class="date">
                25 Mar
                </span>
            </a>
            </div>


            </div>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</div>
@endsection