@extends('sys.gestionSolicitudes.solicitudes')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/easymde/easymde.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content_gs')
<style>
.file-attachment {
  position: relative;
  display: inline-block;
  cursor: pointer;
}

.file-attachment img {
  width: 200px;
  border-radius: 6px;
  transition: opacity 0.3s ease;
}

.download-btn {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: rgba(0, 123, 255, 0.9);
  color: #fff;
  padding: 8px 12px;
  border-radius: 6px;
  font-size: 14px;
  text-decoration: none;
  display: none; /* oculto por defecto */
}

.file-attachment:hover img {
  opacity: 0.6;
}

.file-attachment:hover .download-btn {
  display: block; /* aparece solo al pasar el mouse */
}

.file-upload {
      border: 2px dashed #ccc;
      border-radius: 10px;
      padding: 20px;
      text-align: center;
      cursor: pointer;
      transition: 0.2s;
    }
    .file-upload:hover {
      background-color: #f9f9f9;
    }
    .file-list {
      margin-top: 15px;
    }
    .file-item {
      background: #f2f2f2;
      border-radius: 6px;
      padding: 8px 12px;
      margin-bottom: 5px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 14px;
    }
    .file-item button {
      background: none;
      border: none;
      color: #d33;
      font-weight: bold;
      cursor: pointer;
      font-size: 16px;
    }
    #btnRemitir {
        transition: all 0.3s ease-in-out;
    }

    .btn-fixed-top {
        position: fixed;
        top: 80px; /* más abajo, no tan arriba */
        right: 30px;
        z-index: 1050;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        transform: translateY(0);
        animation: fadeSlide 0.3s ease-in-out;
    }

    @keyframes fadeSlide {
        from {
            opacity: 0;
            transform: translateY(-15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .tooltip .tooltip-inner {
    background-color: #000000 !important; /* fondo blanco */
    color: #ffffff !important;            /* texto negro */
    border: 1px solid #000000;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .tooltip.bs-tooltip-bottom .tooltip-arrow::before,
    .tooltip.bs-tooltip-top .tooltip-arrow::before,
    .tooltip.bs-tooltip-start .tooltip-arrow::before,
    .tooltip.bs-tooltip-end .tooltip-arrow::before {
        border-color: #fff !important; /* flecha blanca */
    }
</style>
@foreach($detalle_solicitud as $row) @if($loop->first)
<div class="d-flex align-items-center justify-content-between p-3 border-bottom tx-16 bg-primary">
    <div class="d-flex align-items-center">
        <!--<i data-feather="star" class="text-primary icon-lg me-2"></i>-->
        <span><b><font class="text-white">{{$row['departamento_remitente']}} | GS-{{$row['id_solicitud']}}</font></b></span>
    </div>
    <div>
        <!-- <span>Remisiones</span> -->

        <div class="d-flex align-items-center gap-2">

            <h5 class="mb-0">
                <span class="badge bg-light">
                    <b>{{$estado_actual['nombre']}}</b>
                </span>
            </h5>

            @if($remitir && ($estado_actual['id'] != 4))
            <a id="btnRemitir"
                class="btn bg-amarillo btn-xs text-dark"
                data-bs-toggle="modal"
                data-bs-target="#modal_remision"
                title="Haz clic aquí para remitir la solicitud al finalizar.">
                <i data-feather="share" class="text-dark icon-lg pb-3px"></i> 
                Remitir
            </a>
            @endif

        </div>
        <!--  <div class="actions dropdown">
                    <a href="#" data-bs-toggle="dropdown"><i data-feather="share" class="icon-lg text-muted"></i></a>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal_remision">Remisión Interna</a>
                      <a class="dropdown-item" href="#">Remisión Externa</a>
                      <a class="dropdown-item" href="#">Spam</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item text-danger" href="#">Delete</a> 
                    </div>
                  </div>-->
        <!-- <a class="me-2" type="button" data-bs-toggle="tooltip" data-bs-title="Print"><i data-feather="printer" class="text-muted icon-lg"></i></a>
                <a type="button" data-bs-toggle="tooltip" data-bs-title="Delete"><i data-feather="trash" class="text-muted icon-lg"></i></a> -->
        <!-- <button type="button" class="btn btn-success btn-xs">Externa</button>
        <button type="button" class="btn btn-info btn-xs">Interna</button> -->
    </div>
</div>
<div class="d-flex align-items-center justify-content-between flex-wrap px-3 py-2 border-bottom">
    <div class="d-flex align-items-center">
        <div class="me-2">
            <img src="https://portal.unag.edu.hn/matricula/documentos/fotos/{{$row['foto']}}" alt="Avatar" class="rounded-circle img-xs" onerror="this.onerror=null; this.src='{{ url(asset('/assets/images/user2-403d6e88.png')) }}';" />
        </div>
        <div class="d-flex align-items-center">
            <a href="#" class="text-body">{{$row['name_remitente']}}</a>
            <span class="mx-2 text-muted">para</span>
            <a href="#" class="text-body me-2">{{$row['departamento_destinatario']}}<small class="mx-2 text-muted">{!!$row['name_destinatario']!!}</small></a>
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
    <div class="tx-13 text-muted mt-2 mt-sm-0">{{$row['fecha_hora']}} {{--@if($row['solicitud_vista'])<i data-feather="check" class="icon-xs text-success"></i>@endif--}}</div>
</div>
    <div class="p-4 border-bottom">
        <div class="d-flex justify-content-between align-items-center">
        
        <div class="ms-0 tx-13">
            <h6><span class="badge bg-light"><i data-feather="clock" class="icon-xs text-dark"></i> {{$row['estado']}}</span></h6>
        </div>

        <div class="tx-13">
            @if($row['solicitud_vencida']) 
                <span class="badge bg-danger text-white">{{$row['fecha_hora_vencimiento']}}</span>
            @else 
                ◉ Vence: {{$row['fecha_hora_vencimiento']}}
            @endif
        </div>

    </div>
    <br>
    {!!$row['descripcion']!!}
    <hr />
    @php $conteoAdjuntos = 0; @endphp @foreach($adjuntos as $row2) @php if($row2['id_trazabilidad'] == $row['id_trazabilidad']){ $conteoAdjuntos++; } @endphp @endforeach @foreach($adjuntos as $row2) @if($loop->first)
    <div class="mb-3"><span>Adjuntos ({{$conteoAdjuntos}} archivos) </span></div>
    @endif
    <ul class="nav flex-column">
        @if($row2['id_trazabilidad'] == $row['id_trazabilidad'])
        <li class="nav-item">
            <a href="{{ url('/gestion_solicitudes/solicitud/') }}/{{$row['id_solicitud']}}/leer/trazabilidad/{{$row['id_trazabilidad']}}/adjuntos/{{$row2['archivo']}}/descargar" class="nav-link text-body">
                <span data-feather="file" class="icon-lg text-muted"></span> {{$row2['archivo']}}
                <!-- <span class="text-muted tx-11">(250 KB)</span> -->
            </a>
        </li>
        @endif
    </ul>
    @endforeach
</div>
<hr />
<div class="p-3">
    <h4 class="mb-5"><strong><i data-feather="git-commit" class="icon-lg me-2"></i> Trazabilidad</strong></h4>
    
    @else
    <div class="row">
        <center class="col-md-1 col-sm-1 flex justify-content-center" style="overflow:hidden;">
                <div class="bg-primary w-5" style="width:20px; height:20px; border-radius:60%; margin-top:40px;">&nbsp;</div>
                <div class="bg-amarillo w-5" style="width:3px; height:100%;">&nbsp;</div>
        </center>
        <div class="col-md-11 col-sm-11">
            <div class="d-flex align-items-center justify-content-between flex-wrap px-4 py-4 border-bottom bg-grisClaro">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <img src="https://portal.unag.edu.hn/matricula/documentos/fotos/{{$row['foto']}}" alt="Avatar" class="rounded-circle img-xs" onerror="this.onerror=null; this.src='{{ url(asset('/assets/images/user2-403d6e88.png')) }}';" />
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="#" class="text-body">{{$row['name_remitente']}}</a>
                            <span class="mx-2 text-muted">para</span>
                            <a href="#" class="text-body me-2">{{$row['departamento_destinatario']}}<small class="mx-2 text-muted">{!!$row['name_destinatario']!!}</small></a>
                        </div>
                    </div>
                    <div class="tx-13 text-muted mt-2 mt-sm-0">{{$row['fecha_hora']}} {{--@if($row['solicitud_vista'])<i data-feather="check" class="icon-xs text-success"></i>@endif--}}</div>
                </div>
                <div class="p-4 border-bottom">
                    <div class="p-4 border-bottom">
                            <div class="d-flex justify-content-between align-items-center">
                            
                            <div class="ms-0 tx-13">
                                @if($row['id_estado'] == 1) 
                                    <h6><span class="badge bg-light"><i data-feather="clock" class="icon-xs text-dark"></i> {{$row['estado']}}</span></h6>
                                @elseif($row['id_estado'] == 2) 
                                    <h6><span class="badge bg-info"><i data-feather="refresh-cw" class="icon-xs text-dark"></i> {{$row['estado']}}</span></h6>
                                @elseif($row['id_estado'] == 3) 
                                    <h6><span class="badge bg-warning"><i data-feather="eye" class="icon-xs text-dark"></i> {{$row['estado']}}</span></h6>
                                @elseif($row['id_estado'] == 4) 
                                    <h6 class=""><span class="badge bg-success text-white"><i data-feather="check" class="icon-xs text-white"></i> {{$row['estado']}}</span></h6>
                                @endif
                            </div>

                            <div class="tx-13">
                                @if($row['fecha_hora_vencimiento'] != null)<p class="ms-3 tx-13">@if($row['solicitud_vencida']) <span class="badge bg-danger text-white"> {{$row['fecha_hora_vencimiento']}}</span>@else ◉ Vence: {{$row['fecha_hora_vencimiento']}} @endif</p><P></P>@endif
                            </div>

                        </div>
                        <br>
                    {!!$row['descripcion']!!}
                    <hr />
                    @php $conteoAdjuntos = 0; @endphp @foreach($adjuntos as $row2) @php if($row2['id_trazabilidad'] == $row['id_trazabilidad']){ $conteoAdjuntos++; } @endphp @endforeach @foreach($adjuntos as $row2) @if($loop->first)
                    <div class="mb-3"><span>Adjuntos ({{$conteoAdjuntos}} archivos)</span></div>
                    @endif
                    <ul class="nav flex-column">
                        @if($row2['id_trazabilidad'] == $row['id_trazabilidad'])
                        <li class="nav-item">
                            <a href="{{ url('/gestion_solicitudes/solicitud/') }}/{{$row['id_solicitud']}}/leer/trazabilidad/{{$row2['id_trazabilidad']}}/adjuntos/{{$row2['archivo']}}/descargar" class="nav-link text-body">
                                <span data-feather="file" class="icon-lg text-muted"></span> {{$row2['archivo']}}
                                <!-- <span class="text-muted tx-11">(250 KB)</span> -->
                            </a>
                        </li>
                        @endif
                    </ul>
                    @endforeach
                </div>
                <hr />
            </div>
        </div>
    </div>
            @endif @endforeach
</div>

<div class="modal fade bd-example modal_remision" id="modal_remision" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h6 class="modal-title h6 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="share"></i> Remitir</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="card-body">
                <div></div>
                <div class="p-3 pb-0">
                    <div class="to">
                        <div class="row mb-3">
                            <label class="col-md-2 col-lg-2 col-form-label">Para:</label>
                            @if($yo_help_desk)
                            <div class="col-md-5">
                                <div class="mb-2 d-flex align-items-center">
                                    <div class="form-check me-2">
                                        <input type="radio" class="form-check-input" name="remision" id="remisionInterna" checked />
                                        <label class="form-check-label mb-0" for="remisionInterna">Remisión Interna</label>
                                    </div>
                                </div>

                                <select class="js-example-basic-single form-select" id="empleado">
                                    @foreach($empleados as $row)
                                    <option value="{{$row['id']}}">{{$row['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-2 d-flex align-items-center">
                                    <div class="form-check me-2">
                                        <input type="radio" class="form-check-input" name="remision" id="remisionExterna" />
                                        <label class="form-check-label mb-0" for="remisionExterna">Remisión Externa</label>
                                    </div>
                                </div>

                                <select class="js-example-basic-single form-select" id="departamento" disabled>
                                    @foreach($departamentos as $row)
                                    <option value="{{$row['id_departamento']}}">{{$row['descripcion']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @elseif($estado_actual['id'] == 3 && $yo_solicitante)
                                <div class="col-md-10">
                                    <div class="alert alert-fill-light" role="alert">
                                        <div class="row align-items-center">

                                            <div class="col-md-8">
                                                <small>
                                                    La presente remisión se encuentra en espera de ser terminada.
                                                    Si considera que la solicitud ya ha sido completada, puede proceder a finalizarla haciendo clic en el botón <b>Terminado</b>.
                                                    En caso contrario, puede enviarla nuevamente a proceso haciendo clic en el botón <b>Proceso</b> si aún existen acciones pendientes por realizar.
                                                </small>
                                            </div>

                                            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                                                <div class="btn-group" role="group">
                                                    @if($estado_actual['id'] == 2 || ($estado_actual['id'] == 3 && $yo_solicitante))
                                                    <input type="radio" class="btn-check" name="btnradio" id="btnradioProceso" autocomplete="off" checked>
                                                    <label class="btn btn-outline-info" for="btnradioProceso">
                                                        <i data-feather="refresh-cw" class="icon-sm"></i> Proceso
                                                    </label>
                                                    @endif

                                                    @if($estado_actual['id'] == 3 && $yo_solicitante)
                                                    <input type="radio" class="btn-check" name="btnradio" id="btnradioTerminado" autocomplete="off">
                                                    <label class="btn btn-outline-success" for="btnradioTerminado">
                                                        <i data-feather="check" class="icon-sm"></i> Terminado
                                                    </label>
                                                    @endif
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @else
                            <div class="col-md-10">
                                <div class="alert alert-fill-light" role="alert">
                                    <strong>La presente remisión está dirigida a los Help Desk de su departamento.</strong>
                                </div>
                            </div>
                            @endif
                        </div>
                        @if($yo_help_desk)
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="check_fecha_hora_vencimiento" name="check_fecha_hora_vencimiento">
                                    <label class="form-check-label" for="check_fecha_hora_vencimiento">
                                        Fecha y hora de vencimiento:
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group flatpickr" id="flatpickr-date">
                                    <input type="text" class="form-control" placeholder="Selecciona una fecha" data-input id="fecha_vencimiento">
                                    <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group flatpickr" id="flatpickr-time">
                                    <input type="text" class="form-control" placeholder="Selecciona una hora" data-input id="hora_vencimiento">
                                    <span class="input-group-text input-group-addon" data-toggle><i data-feather="clock"></i></span>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex justify-content-end">
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    @if(($yo_help_desk))
                                    <input type="radio" class="btn-check" name="btnradio" id="btnradioProceso" autocomplete="off" checked>
                                    <label class="btn btn-outline-info" for="btnradioProceso"><i data-feather="refresh-cw" class="icon-sm"></i> Proceso</label>
                                    @endif
                                    @if($yo_help_desk && !$yo_solicitante)
                                    <input type="radio" class="btn-check" name="btnradio" id="btnradioRevision" autocomplete="off">
                                    <label class="btn btn-outline-success" for="btnradioRevision"><i data-feather="eye" class="icon-sm"></i> Revisión</label>
                                    @endif
                                    @if($yo_solicitante)
                                    <input type="radio" class="btn-check" name="btnradio" id="btnradioTerminado" autocomplete="off">
                                    <label class="btn btn-outline-dark" for="btnradioTerminado"><i data-feather="check" class="icon-sm"></i> Terminado</label>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="px-3">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label visually-hidden" for="descripcion_solicitud">Descriptions </label>
                            <textarea class="form-control" name="easymde" id="descripcion_solicitud" rows="5" placeholder="Escriba aquí..."></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 stretch-card grid-margin grid-margin-md-0">
                            <div class="card-body">
                                <h6 class="card-title">Adjuntar Archivos</h6>
                                <!-- <p class="text-muted mb-3">Arrastra y suelta tus archivos aquí, o haz clic para seleccionarlos y cargarlos.</p>
                <form action="#" class="dropzone" id="adjuntos_solicitud"></form> -->

                                <div class="file-upload" id="fileUpload">
                                    <p>Arrastra o haz clic para seleccionar archivos</p>
                                    <input type="file" id="inputArchivos" multiple hidden />
                                </div>

                                <div id="fileList" class="file-list"></div>
                            </div>
                        </div>

                        <div>
                            <div class="col-md-12">
                                <div class="d-grid gap-2">
                                <button class="btn btn-primary me-1 mb-1" type="button" id="enviar_remision"><i data-feather="send" class="icon-lg me-2"></i> Enviar</button>
                                </div>
                                <!-- <button class="btn btn-secondary me-1 mb-1" type="button"> Cancel</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer bg-secondary">
                <button type="button" class="btn btn-danger btn-xs" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-xs" id="btn_guardar_datos_academicos">Guardar</button>
            </div> -->
        </div>
    </div>
</div>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/easymde/easymde.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/dropzone/dropzone.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/email.js') }}"></script>
  <script src="{{ asset('assets/js/dropzone.js') }}"></script>
  <script src="{{ asset('assets/js/tinymce.js') }}"></script>
  <script src="{{ asset('assets/js/easymde.js') }}"></script>
  <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
  <script src="{{ asset('assets/js/flatpickr/dist/110n/es.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=mzutkZDE"></script>
  <script type="text/javascript">
    var accion = null;
    var id_solicitud = {{$id_solicitud}};
    var btn_activo = true;
    var empleado = null;
    var departamento = null;
    var fecha_vencimiento = null;
    var hora_vencimiento = null;
    var descripcion = null;
    var adjuntos = null;
    var yo_help_desk = "{{$yo_help_desk}}";
    var yo_solicitante = "{{$yo_solicitante}}";
    var id_estado = {{$estado_actual['id']}};
    var url_guardar_remision = "{{url('/gestion_solicitudes/solicitud/remitir/guardar')}}"; 
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const fechaHoraValida = obtenerFechaHoraValida();
        const btn = document.getElementById("btnRemitir");
        const offset = btn.offsetTop;

        // Inicializar tooltip manual
        const tooltip = new bootstrap.Tooltip(btn, {
            placement: 'bottom',
            trigger: 'manual'
        });

        // Mostrar tooltip automáticamente
        tooltip.show();

        // Ocultar después de 5 segundos
        setTimeout(function () {
            tooltip.hide();
        }, 10000);

        // Scroll flotante
        window.addEventListener("scroll", function() {
            if (window.scrollY > offset) {
                btn.classList.add("btn-fixed-top");
            } else {
                btn.classList.remove("btn-fixed-top");
            }
        });

        if(yo_help_desk || yo_solicitante){
            eleccion_estado();
        }
    

    $(function() {
                'use strict';

                //Tinymce editor
                if ($("#descripcion_solicitud").length) {
                    tinymce.init({
                    selector: '#descripcion_solicitud',
                    height: 250,
                    menubar: false,
                    default_text_color: 'red',
                    plugins: 'advlist autolink lists link image charmap preview anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen',
                    toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
                    //toolbar2: 'forecolor backcolor emoticons',
                    image_advtab: false,
                    paste_data_images: false,
                    templates: [{
                        title: 'Test template 1',
                        content: 'Test 1'
                        },
                        // {
                        // title: 'Test template 2',
                        // content: 'Test 2'
                        // }
                    ],
                    content_css: []
                    });
                }
                
            });

    $(function() {
        'use strict';

        // date picker 
        if($('#flatpickr-date').length) {
            flatpickr("#flatpickr-date", {
            wrap: true,
            dateFormat: "Y-m-d",
            locale: "es",
            minDate: "today",
            disable: [
                    function(date) {
                        // 0 = domingo, 6 = sábado
                        return (date.getDay() === 0 || date.getDay() === 6);
                    }
                ],
            });
        }


        // time picker
        if($('#flatpickr-time').length) {
            flatpickr("#flatpickr-time", {
            wrap: true,
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            minTime: "today",
            minTime: "08:00",
            maxTime: "16:30"
            });
        }

    });

    $("#btn_info_fechas").on("click", function () {
        recomendacion_fecha(fechaHoraValida);
    });
      
    $("#enviar_remision").on("click", function () {
        departamento = $("#departamento").val();
        empleado = $("#empleado").val();
        descripcion = tinymce.get('descripcion_solicitud').getContent();
        @if($yo_help_desk)
            fecha_vencimiento = $("#fecha_vencimiento").val();
            hora_vencimiento = $("#hora_vencimiento").val();

            const ahora = new Date();
            const horas = String(ahora.getHours()).padStart(2, '0');
            const minutos = String(ahora.getMinutes()).padStart(2, '0');
            const horaActual = horas + ":" + minutos;
            //console.log(horaActual); // Ejemplo: 14:35
            if ($('#check_fecha_hora_vencimiento').is(':checked')) {
                if(fecha_vencimiento == null || fecha_vencimiento == ''){
                    Toast.fire({
                        icon: 'error',
                        title: 'Por favor, asigne una fecha de vencimiento.'
                    })
                    return true;
                }

                if(hora_vencimiento == null || hora_vencimiento == ''){
                    Toast.fire({
                        icon: 'error',
                        title: 'Por favor, asigne una hora de vencimiento.'
                    })
                    return true;
                }
            }
            /*if(hora_vencimiento <= horaActual){
                Toast.fire({
                    icon: 'error',
                    title: 'No puede seleccionar una hora anterior a la actual.'
                })
                return true;
            }

            if((fecha_vencimiento+' '+hora_vencimiento) <= fechaHoraValida){
                recomendacion_fecha(fechaHoraValida);
                return true;
            }*/
        @endif
            if(descripcion == null || descripcion == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Por favor, describe tu solicitud antes de enviarla.'
                })
                return true;
            }
            
            if(btn_activo){
                guardar_remision();
            }
            

    });

    $("#modal_remision").on("show.bs.modal", function (e) {
            $('#empleado').select2({
              dropdownParent: $('#modal_remision'),
              width: '100%'
            });
            $('#departamento').select2({
              dropdownParent: $('#modal_remision'),
              width: '100%'
            });
    });

      $('#remisionInterna').prop('checked', true);
      $('#empleado').prop('disabled', false);
      $('#departamento').prop('disabled', true);
      accion = 1;

      $('input[name="remision"]').on('change', function() {
        if ($('#remisionInterna').is(':checked')) {
          $('#empleado').prop('disabled', false);
          $('#departamento').prop('disabled', true);
          accion = 1;
        } else {
          $('#empleado').prop('disabled', true);
          $('#departamento').prop('disabled', false);
          accion = 2;
        }
      });

      $('#check_fecha_hora_vencimiento').prop('checked', true);
      $('input[name="check_fecha_hora_vencimiento"]').on('change', function() {
        if ($('#check_fecha_hora_vencimiento').is(':checked')) {
          /*$('#fecha_vencimiento').prop('disabled', false);
          $('#hora_vencimiento').prop('disabled', false);*/
          $('#flatpickr-date').show();
          $('#flatpickr-time').show();
        } else {
          /*$('#fecha_vencimiento').prop('disabled', true);
          $('#hora_vencimiento').prop('disabled', true);*/
          $('#flatpickr-date').hide();
          $('#flatpickr-time').hide();
          $('#fecha_vencimiento').val('');
          $('#hora_vencimiento').val('');
        }
      });

      $('input[name="btnradio"]').on('change', function() {
        eleccion_estado();
      });
    });

    function eleccion_estado(){
        if ($('#btnradioProceso').is(':checked')) {
          id_estado = 2;
        } else if($('#btnradioRevision').is(':checked')){
          id_estado = 3;
        } else if($('#btnradioTerminado').is(':checked')){
          id_estado = 4;
        }
    }

     const inputArchivos = document.getElementById('inputArchivos');
        const fileUpload = document.getElementById('fileUpload');
        const fileList = document.getElementById('fileList');
        let archivosSeleccionados = [];

        // Abrir selector al hacer clic en el área
        fileUpload.addEventListener('click', () => inputArchivos.click());

        // Arrastrar y soltar
        fileUpload.addEventListener('dragover', e => {
          e.preventDefault();
          fileUpload.style.backgroundColor = '#eef';
        });
        fileUpload.addEventListener('dragleave', () => {
          fileUpload.style.backgroundColor = '';
        });
        fileUpload.addEventListener('drop', e => {
          e.preventDefault();
          fileUpload.style.backgroundColor = '';
          agregarArchivos(e.dataTransfer.files);
        });

        // Al seleccionar archivos manualmente
        inputArchivos.addEventListener('change', e => agregarArchivos(e.target.files));

        // Función para agregar archivos
        function agregarArchivos(files) {
          for (const file of files) {
            // Evitar duplicados por nombre
            if (!archivosSeleccionados.some(f => f.name === file.name)) {
              archivosSeleccionados.push(file);
            }
          }
          mostrarListaArchivos();
        }

        // Mostrar lista de archivos
        function mostrarListaArchivos() {
          fileList.innerHTML = '';
          archivosSeleccionados.forEach((file, index) => {
            const item = document.createElement('div');
            item.className = 'file-item';
            item.innerHTML = `
              <span>${file.name} (${(file.size/1024).toFixed(1)} KB)</span>
              <button onclick="eliminarArchivo(${index})">&times;</button>
            `;
            fileList.appendChild(item);
          });
        }

        // Eliminar archivo de la lista
        function eliminarArchivo(index) {
          archivosSeleccionados.splice(index, 1);
          mostrarListaArchivos();
        }




    function guardar_remision() {
        espera('Enviando tu remisión...');
        const formData = new FormData();
        // Agregar archivos
        archivosSeleccionados.forEach((file, i) => {
            formData.append('archivos[]', file, file.name);
        });

        // Agregar otros campos
        formData.append('accion', accion);
        formData.append('id_solicitud', id_solicitud);
        formData.append('empleado', empleado);
        formData.append('departamento', departamento);
        formData.append('fecha_vencimiento', fecha_vencimiento);
        formData.append('hora_vencimiento', hora_vencimiento);
        formData.append('descripcion', descripcion);
        formData.append('id_estado', id_estado);

        btn_activo = false;

        $.ajax({
            type: "post",
            url: url_guardar_remision,
            data: formData,
            processData: false, // IMPORTANTE: evita que jQuery convierta los datos a string
            contentType: false, // IMPORTANTE: permite enviar multipart/form-data
            success: function (data) {
                if (data.msgError != null) {
                    titleMsg = "Error al Guardar";
                    textMsg = data.msgError;
                    typeMsg = "error";
                    timer = null;
                    btn_activo = true;
                    timeout = data.timeout;
                } else {
                    titleMsg = "Remisión Enviada";
                    textMsg = data.msgSuccess;
                    typeMsg = "success";
                    timer = null;
                    timeout = false;
       
                    //btn_activo = true;
                }
                //console.log(textMsg);
                ToastLG({
                    icon: typeMsg,
                    title: titleMsg,
                    html: textMsg,
                    timer: timer,
                    timeout: timeout
                })

            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            },
        });
    }

    const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

    const ToastLG = (options) => {
        Swal.fire({
            showConfirmButton: (typeMsg == 'error') ? false : true,
            showDenyButton: timeout,
            showCancelButton: (typeMsg == 'success') ? false : true,
            confirmButtonText: 'Aceptar',
            denyButtonText: 'Reintentar',
            cancelButtonText: 'Cancelar',
            timerProgressBar: true,
            allowOutsideClick: false,
            ...options
        }).then((result) => {

            if (result.isConfirmed) {
                espera('Recargando...');
                location.reload(); // opción 1
            }

            else if (result.isDenied) {
                guardar_remision()
            }

            else if (result.isDismissed) {
                console.log('El usuario canceló'); // opción 3
            }

        });
    };

    function espera(html){
        let timerInterval
        Swal.fire({
            imageUrl: "{{ url(asset('/assets/images/unag_loading.gif')) }}",
            // icon: 'warning',
            title: '¡Espera!',
            html: html,
            timer: null,
            timerProgressBar: true,
            allowOutsideClick: false,
            didOpen: () => {
            Swal.showLoading()
            timerInterval = setInterval(() => {
                const content = Swal.getHtmlContainer()
                if (content) {
                const b = content.querySelector('b')
                if (b) {
                    b.textContent = Swal.getTimerLeft()
                }
                }
            }, 100)
            },
            willClose: () => {
            clearInterval(timerInterval)
            }
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
            console.log('I was closed by the timer')
            }
        })
    }

    
    function recomendacion_fecha(fechaHoraValida){
        Swal.fire({
            title: 'Recomendación',
            icon: 'info',
            confirmButtonText: 'Aceptar',
            html: `
                <div style="text-align: justify; line-height: 1.5;">
                    La fecha y hora de vencimiento de la solicitud deben establecerse de manera que sean al menos <b>seis (6) horas</b> posteriores a la hora actual,
                    respetando únicamente los días laborales de <b>lunes a viernes</b>,
                    dentro del horario comprendido entre <b>08:00 y 16:30</b>.<br><br>
                    Esto garantiza que las solicitudes se gestionen dentro de los períodos hábiles y evita la programación de vencimientos fuera del horario laboral.<br><br>
                    <center>Fecha y hora sugerida a partir de este momento:<br> <strong>${fechaHoraValida}</strong></center>
                </div>
            `
        });
    }

    function obtenerFechaHoraValida() {
        let ahora = new Date();

        // Definir horario laboral
        const horaInicio = 8;
        const horaFin = 16;
        const minutoFin = 30;

        // Sumar 6 horas
        let horasSumar = 6;
        let minutosSumar = 0;

        while (horasSumar > 0) {
            let horaActual = ahora.getHours();
            let minutoActual = ahora.getMinutes();

            // Si estamos antes de la jornada laboral, mover al inicio
            if (horaActual < horaInicio || (horaActual === horaInicio && minutoActual === 0)) {
                ahora.setHours(horaInicio, 0, 0, 0);
                horaActual = horaInicio;
                minutoActual = 0;
            }

            // Calcular minutos disponibles hasta el fin de jornada
            let minutosDisponibles = (horaFin * 60 + minutoFin) - (horaActual * 60 + minutoActual);

            if (horasSumar * 60 <= minutosDisponibles) {
                // Cabe en el día actual
                ahora.setMinutes(minutoActual + horasSumar * 60);
                horasSumar = 0;
            } else {
                // No cabe, usar lo que queda y pasar al siguiente día hábil
                horasSumar -= minutosDisponibles / 60;
                // Pasar al siguiente día
                ahora.setDate(ahora.getDate() + 1);
                ahora.setHours(horaInicio, 0, 0, 0);

                // Evitar sábados y domingos
                while (ahora.getDay() === 0 || ahora.getDay() === 6) {
                    ahora.setDate(ahora.getDate() + 1);
                }
            }
        }

        // Retornar en formato YYYY-MM-DD HH:MM
        const yyyy = ahora.getFullYear();
        const mm = String(ahora.getMonth() + 1).padStart(2, '0');
        const dd = String(ahora.getDate()).padStart(2, '0');
        const hh = String(ahora.getHours()).padStart(2, '0');
        const min = String(ahora.getMinutes()).padStart(2, '0');

        return `${yyyy}-${mm}-${dd} ${hh}:${min}`;
        }

  </script>
@endpush