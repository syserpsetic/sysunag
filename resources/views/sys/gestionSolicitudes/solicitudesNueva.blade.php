@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/easymde/easymde.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" />
@endpush

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
            <div>
              <div class="d-flex align-items-center p-3 border-bottom tx-16">
                <span data-feather="edit" class="icon-md me-2"></span>
                Nueva Solicitud
              </div>
            </div>
            <div class="p-3 pb-0">
              <div class="to">
                <div class="row mb-3">
                  <label class="col-md-2 col-form-label">Para:</label>
                  <div class="col-md-10">
                    <select class="compose-multiple-select form-select">
                      <option value="AL">ANALISIS SOCIOECONOMICO</option>
                      <option value="WY">ASESORIA LEGAL</option>
                      <option value="AM">COORDINACION DE LA CARRERA DE INGENIERIA EN ZOOTECNIA</option>
                      <option value="CA">DIRECCION DE DOCENCIA</option>
                      <option value="RU">SECRETARIA GENERAL</option>
                    </select>
                  </div>
                </div>
              </div>
              <!-- <div class="to cc">
                <div class="row mb-3">
                  <label class="col-md-2 col-form-label">Cc</label>
                  <div class="col-md-10">
                    <select class="compose-multiple-select form-select" multiple="multiple">
                      <option value="Alabama">Alabama</option>
                      <option value="Alaska" selected="selected">Alaska</option>
                      <option value="Melbourne">Melbourne</option>
                      <option value="Victoria" selected="selected">Victoria</option>
                      <option value="Newyork">Newyork</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="subject">
                <div class="row mb-3">
                  <label class="col-md-2 col-form-label">Subject</label>
                  <div class="col-md-10">
                    <input class="form-control" type="text">
                  </div>
                </div>
              </div> -->
            </div>
            <div class="px-3">
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label visually-hidden" for="easyMdeEditor">Descriptions </label>
                  <textarea class="form-control" name="easymde" id="easyMdeEditor" rows="5"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 stretch-card grid-margin grid-margin-md-0">
           
                    <div class="card-body">
                      <h6 class="card-title">Adjuntar Archivos</h6>
                      <p class="text-muted mb-3">Arrastra y suelta tus archivos aquí, o haz clic para seleccionarlos y cargarlos.</p>
                      <form action="/file-upload" class="dropzone" id="exampleDropzone"></form>
                    </div>
                </div>

              <div>
                <div class="col-md-12">
                  <button class="btn btn-primary me-1 mb-1" type="submit"> Enviar</button>
                  <!-- <button class="btn btn-secondary me-1 mb-1" type="button"> Cancel</button> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/easymde/easymde.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/dropzone/dropzone.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/email.js') }}"></script>
  <script src="{{ asset('assets/js/dropzone.js') }}"></script>
@endpush