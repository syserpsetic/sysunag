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
                    <i data-feather="git-commit" class="text-muted me-2"></i>
                    <h4 class="me-1">Trazabilidad</h4>
                  </div>
                </div>
                <hr>
                <h5 class="me-1">Solicitud de Recursos Humanos</h5>
                <p class="msg">Estimados, les recordamos que el plazo para la actualización de expedientes del personal administrativo vence el 20 de marzo. Por favor, entregue la documentación requerida en la plataforma de gestión de talento humano.</p>
                <div class="col-lg-6">
                  <!-- <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search mail...">
                    <button class="btn btn-light btn-icon" type="button" id="button-search-addon"><i data-feather="search"></i></button>
                  </div> -->
                </div>
              </div>
            </div>
            <div id="content">
                <ul class="timeline">
                    <li class="event" data-date="2025-09-08 | 08:45 AM">
                        <h3 class="title">Departamento de SETIC</h3>
                        <p>Solicitud de incorporación de un analista de soporte técnico para fortalecer la mesa de ayuda institucional.</p>
                    </li>
                    <li class="event" data-date="2025-09-10 | 09:30 AM">
                        <h3 class="title">Departamento de Ingeniería</h3>
                        <p>Solicitud de contratación de un desarrollador junior para cubrir vacante en el área de sistemas.</p>
                    </li>
                    <li class="event" data-date="2025-09-12 | 02:15 PM">
                        <h3 class="title">Departamento de Contabilidad</h3>
                        <p>Requerimiento de capacitación en normativa tributaria para el equipo de auxiliares contables.</p>    
                    </li>
                    <li class="event" data-date="2025-09-13 | 03:40 PM">
                        <h3 class="title">Departamento de Logística</h3>
                        <p>Solicitud de dos asistentes administrativos temporales para apoyo en inventarios trimestrales.</p>    
                    </li>
                    <li class="event" data-date="2025-09-15 | 10:00 AM">
                        <h3 class="title">Departamento de Recursos Humanos</h3>
                        <p>Solicitud de actualización de manual de puestos y perfiles para la institución.</p>    
                    </li>
                    <li class="event" data-date="2025-09-17 | 01:10 PM">
                        <h3 class="title">Departamento Académico</h3>
                        <p>Requerimiento de contratación de docentes interinos para cubrir licencias temporales.</p>    
                    </li>
                    <li class="event" data-date="2025-09-18 | 04:45 PM">
                        <h3 class="title">Departamento de Ventas</h3>
                        <p>Solicitud de evaluación de desempeño para el personal de ventas del trimestre actual.</p>    
                    </li>
                    <li class="event" data-date="2025-09-20 | 11:20 AM">
                        <h3 class="title">Departamento de Atención al Cliente</h3>
                        <p>Requerimiento de incorporación de dos asistentes temporales para soporte en campañas.</p>    
                    </li>
                    <li class="event" data-date="2025-09-21 | 09:00 AM">
                        <h3 class="title">Departamento de Comunicación Institucional</h3>
                        <p>Solicitud de diseñador gráfico para apoyo en campañas de difusión digital.</p>    
                    </li>
                    <li class="event" data-date="2025-09-22 | 02:30 PM">
                        <h3 class="title">Departamento de Compras</h3>
                        <p>Requerimiento de auxiliar administrativo para seguimiento de órdenes de proveedores.</p>    
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