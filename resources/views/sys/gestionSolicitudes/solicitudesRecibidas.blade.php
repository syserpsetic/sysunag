@extends('sys.gestionSolicitudes.solicitudes')

@section('content_gs')
         
            <div class="p-3 border-bottom">
              <div class="row align-items-center">
                <div class="col-lg-6">
                  <div class="d-flex align-items-end mb-2 mb-md-0">
                    <i data-feather="inbox" class="text-muted me-2"></i>
                    <h4 class="me-1">Solicitudes Recibidas</h4>
                    @if($conteo_solicitudes['nuevas']> 0)
                      <span class="text-muted">({{$conteo_solicitudes['nuevas']}} solicitudes nuevas)</span>
                    @endif
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
            <!-- <div class="p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap">
              <div class="d-none d-md-flex align-items-center flex-wrap">
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
              </div> 
            </div>-->
            @if(empty($solicitudes_recibidas))
            <div class="email-list">
              <div class="page-content d-flex align-items-center justify-content-center">

                <div class="row w-100 mx-0 auth-page">
                  <div class="col-md-8 col-xl-6 mx-auto d-flex flex-column align-items-center text-center">
                    
                    <!-- Ícono Feather -->
                    <i data-feather="inbox" class="text-muted mb-3" style="width: 100px; height: 100px; stroke-width: 1.5;"></i>
                    
                    <h3 class="fw-bold mb-2 text-muted">Sin solicitudes recibidas</h3>
                    <h6 class="text-muted mb-3">Por el momento no tienes solicitudes nuevas en tu bandeja.</h6>
                  </div>
                </div>

              </div>
            @endif
            @foreach($solicitudes_recibidas as $row)
            <div @if($row['solicitud_vista']) class="email-list-item" @else class="email-list-item email-list-item--unread" @endif>
                <a href="{{ url('/gestion_solicitudes/solicitud/') }}/{{$row['id_solicitud']}}/leer" class="email-list-detail">
                    <div class="content">
                    <span class="from">
                      @if(!$row['solicitud_vista'])<small><span class="badge rounded-pill translate-middle p-2 bg-danger border border-light rounded-circle">  &nbsp; </span></small>@endif
                     <strong>{{$row['departamento']}} | GS-{{$row['id_solicitud']}}</strong> 
                    </span>
                    <p>
                        <font class="msg">{!!$row['descripcion']!!}</font>
                    </p>
                    </div>
                    <span class="date">
                      @if($row['adjuntos'] > 0)
                        <span class="icon"><i data-feather="paperclip"></i> </span>
                      @endif
                    {{$row['fecha']}}
                    </span>
                </a>
            </div>
            @endforeach
      
       
@endsection