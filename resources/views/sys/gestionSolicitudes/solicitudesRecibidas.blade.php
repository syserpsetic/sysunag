@extends('sys.gestionSolicitudes.solicitudes')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

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
            <br>
                        <div class="table-responsive">
                <table class="jambo_table table table-hover"
                      style="width:100%; table-layout: fixed;"
                      id="tbl_recibidas" border="1">

                    <thead style="display:none;">
                        <tr class="headings">
                            <th style="width:10%;"></th>
                            <th style="width:80%;"></th>
                            <th style="width:10%;"></th>
                        </tr>
                    </thead>

                    <tbody>

                    @foreach($solicitudes_recibidas as $row)
                    @if(!$row['solicitud_vista'])
                        <tr style="font-size: small; cursor:pointer; font-weight: bold;" onclick="window.location='{{ url('/gestion_solicitudes/solicitud/'.$row['id_solicitud'].'/leer') }}'">
                    @else 
                        <tr style="font-size: small; cursor:pointer;" onclick="window.location='{{ url('/gestion_solicitudes/solicitud/'.$row['id_solicitud'].'/leer') }}'">
                    @endif
                            <td scope="row"
                                style="width:10%; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                
                                    GS-{{$row['id_solicitud']}} {{$row['departamento']}}
                              
                            </td>

                            <td scope="row" style="width:80%;">
                                <div style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                    {!! \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($row['descripcion'])), 600) !!}
                                </div>
                            </td>

                            <td scope="row"
                                style="width:10%; text-align:right; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">

                                @if($row['adjuntos'] > 0)
                                    <span class="icon">
                                        <i data-feather="paperclip" style="width:14px; height:14px;"></i>
                                    </span>
                                @endif

                                {{$row['fecha']}}
                            </td>

                        </tr>

                        {{-- <div @if($row['solicitud_vista']) class="email-list-item" @else class="email-list-item email-list-item--unread" @endif>
                            <a href="{{ url('/gestion_solicitudes/solicitud/') }}/{{$row['id_solicitud']}}/leer" class="email-list-detail">
                                <div class="content">
                                <span class="from">
                                  @if(!$row['solicitud_vista'])<small><span class="badge rounded-pill translate-middle p-2 bg-warning border border-light rounded-circle">  &nbsp; </span></small>@endif
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
                        </div> --}}
                    @endforeach

                    </tbody>
                </table>
            </div>
@endsection
@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush
@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=mzutkZDE"></script>
  <script type="text/javascript">
    var table = null; 
    var rowNumber=null;
    var id_seleccionar = localStorage.getItem("tbl_roles_id_seleccionar");
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        table = $('#tbl_recibidas').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, 100,-1],
                    [10, 30, 50, 100,"Todo"]
                ],
                "iDisplayLength": 10,
                order: []  ,
                language: {
                    processing:     "Procesando...",
                    search:         "Buscar:",
                    lengthMenu:     "Mostrar _MENU_ registros",
                    info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    infoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    infoFiltered:   "(filtrado de un total de _MAX_ registros)",
                    infoPostFix:    "",
                    loadingRecords: "Cargando...",
                    zeroRecords:    "No se encontraron resultados",
                    emptyTable:     "Ningún dato disponible en esta tabla",
                    paginate: {
                        first:      "Primero",
                        previous:   "Anterior",
                        next:       "Siguiente",
                        last:       "Último"
                    },
                    aria: {
                        sortAscending:  ": Activar para ordenar la columna de manera ascendente",
                        sortDescending: ": Activar para ordenar la columna de manera descendente"
                    }
                }
                });
            $('#tbl_recibidas').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Buscar');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
                });

    });

  </script>
@endpush