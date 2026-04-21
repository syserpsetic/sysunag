@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
@endpush

@section('content')

@php
    $esta_graduado = false;
    if(isset($solicitudes) && count($solicitudes) > 0){
        foreach($solicitudes as $solicitud_individual){
            if($solicitud_individual->graduado != null){
                $esta_graduado = true;
                break;
            }
        }
    }
@endphp

<div class="row">
    <div class="col-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                
                {{-- ENCABEZADO --}}
                <div class="alert alert-dark" role="alert">
                    <h1 class="display-3 d-flex align-items-center">
                        <i data-feather="file-text" class="me-3" style="width: 60px; height: 60px;"></i>
                        <strong>SOLICITUDES DE GRADUACIÓN</strong>
                    </h1>
                    <h4 class="lead bg-white"><div class="alert alert-fill-white" role="alert">Administración de sus trámites de graduación.</div></h4>
                </div>
                <hr />

                {{-- TARJETA PRINCIPAL --}}
                <div class="col-12 col-md-12 col-xl-12">
                    <div class="card border-secondary">
                        
                        <div class="card-header bg-azul text-white d-flex justify-content-between align-items-center">
                            <h5 class="text-white mb-0">
                                <i class="text-white icon-lg pb-3px" data-feather="list"></i> Historial de Solicitudes
                            </h5>
                            <div>
                                @if(!$esta_graduado)
                                    <button class="btn btn-primary btn-xs" id="btn_nueva_solicitud" data-bs-toggle="modal" data-bs-target="#modal_gestion_solicitud">
                                        <i class="btn-icon-prepend" data-feather="plus"></i> Nueva Solicitud
                                    </button>
                                @else
                                    <span class="badge bg-success text-white py-2"><i data-feather="award" class="icon-sm"></i> Expediente Cerrado (Graduado)</span>
                                @endif
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                {{-- AQUI agregué las clases dt-responsive y nowrap para que funcione bien --}}
                                <table class="jambo_table table table-hover dt-responsive nowrap" id="tbl_solicitudes" border="1" style="width: 100%;">
                                    <thead class="bg-primary text-white">
                                        <tr class="headings">
                                            {{-- Aseguramos que la primera columna siempre se vea (all) --}}
                                            <th scope="col" class="text-white all">ID</th>
                                            <th scope="col" class="text-white">Proceso</th>
                                            <th scope="col" class="text-white">Modalidad</th>
                                            <th scope="col" class="text-white">Fecha Solicitud</th>
                                            <th scope="col" class="text-white">Estado</th>
                                            <th scope="col" class="text-white">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($solicitudes) && count($solicitudes) > 0)
                                            @foreach($solicitudes as $fila_solicitud)
                                            <tr style="font-size: small;">
                                                <td scope="row" class="align-middle">{{ $fila_solicitud->id }}</td>
                                                <td scope="row" class="align-middle"><span class="fw-bold">{{ $fila_solicitud->nombre_proceso }}</span></td>
                                                <td scope="row" class="align-middle">{{ $fila_solicitud->modalidad }}</td>
                                                <td scope="row" class="align-middle">{{ $fila_solicitud->fecha_solicitud }}</td>
                                                <td scope="row" class="align-middle">
                                                    @if($fila_solicitud->es_activo == 1)
                                                        <span class="badge bg-success text-white">{{ $fila_solicitud->estado_texto }}</span>
                                                    @else
                                                        <span class="badge bg-danger text-white">{{ $fila_solicitud->estado_texto }}</span>
                                                    @endif
                                                </td>
                                                <td scope="row" class="align-middle">
                                                    @if($fila_solicitud->es_activo == 1)
                                                        <div class="d-flex gap-2">
                                                            <a href="{{ url('/secretariageneral/estudiantes/perfil/' . ($perfil->numero_registro_asignado ?? '')) }}" 
                                                               class="btn btn-info btn-xs text-dark fw-bold d-inline-flex align-items-center" 
                                                               title="Verificar Documentación">
                                                                <i data-feather="file-text" style="width: 14px; height: 14px; margin-right: 4px;"></i> Verificar Documentación
                                                            </a>

                                                            <button type="button" class="btn btn-warning btn-icon btn-xs btn_editar" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#modal_gestion_solicitud"
                                                                data-id="{{ $fila_solicitud->id }}"
                                                                data-proceso="{{ $fila_solicitud->id_proceso_graduacion ?? '' }}"
                                                                {{ $fila_solicitud->graduado != null ? 'disabled' : '' }}>
                                                                <i data-feather="check-square"></i>
                                                            </button>
                                                            
                                                            <button type="button" class="btn btn-danger btn-icon btn-xs btn_eliminar" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#modal_eliminar_solicitud"
                                                                data-id="{{ $fila_solicitud->id }}"
                                                                data-nombre="Solicitud #{{ $fila_solicitud->id }}"
                                                                {{ $fila_solicitud->graduado != null ? 'disabled' : '' }}>
                                                                <i data-feather="trash-2"></i>
                                                            </button>
                                                        </div>
                                                    @else
                                                        <span class="text-muted small"><i data-feather="lock" style="width: 14px; height: 14px;"></i> Cerrada</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- MODAL GESTIÓN --}}
<div class="modal fade bd-example" id="modal_gestion_solicitud" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h6 class="modal-title h6 text-white"><i class="icon-lg pb-3px" data-feather="file-plus"></i> Gestión de Solicitud</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12">
                            @if($perfil)
                            <form id="form_datos">
                                <input type="hidden" name="accion" id="hdn_accion" value="1">
                                <input type="hidden" name="id" id="hdn_id_solicitud" value="">
                                <input type="hidden" name="id_carrera_admitido" value="{{ $perfil->id_carrera_admitido }}">
                                <input type="hidden" name="numero_registro" value="{{ $perfil->numero_registro_asignado }}">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="sel_proceso" class="form-label">Elija el Proceso</label>
                                            <select class="form-select" name="id_proceso" id="sel_proceso" required>
                                                <option value="" selected disabled>-- SELECCIONE --</option>
                                                @foreach($cat['procesos'] as $proceso_disponible)
                                                    <option value="{{ $proceso_disponible->id }}">{{ $proceso_disponible->nombre_mostrar }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <h6 class="text-secondary border-bottom pb-2 mb-3 fw-bold text-uppercase mt-2">Datos Personales</h6>

                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label class="small text-muted fw-bold">Nombre Completo:</label>
                                            <input type="text" class="form-control form-control-sm bg-secondary bg-opacity-10" value="{{ $perfil->nombre_completo }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="small text-muted fw-bold">Registro #:</label>
                                            <input type="text" class="form-control form-control-sm bg-secondary bg-opacity-10 fw-bold" value="{{ $perfil->numero_registro_asignado }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="small text-dark fw-bold text-decoration-underline">Nacionalidad:</label>
                                            <input type="text" class="form-control form-control-sm border-warning fw-bold" name="nacionalidad" id="txt_nacionalidad" value="{{ $perfil->nacionalidad }}">
                                        </div>
                                    </div>
                                    
                                    {{-- SELECT DE DEPARTAMENTO --}}
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="small text-dark fw-bold text-decoration-underline">Depto. Nacimiento:</label>
                                            <select class="form-select form-select-sm border-warning" name="id_depto" id="sel_depto">
                                                <option value="" selected disabled>-- SELECCIONE --</option>
                                                @foreach($cat['deptos'] as $departamento)
                                                    <option value="{{ $departamento->id_departamento }}" {{ $perfil->departamento_de_nacimiento_estudiante == $departamento->id_departamento ? 'selected' : '' }}>
                                                        {{ $departamento->descripcion_departamento }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    {{-- SELECT DE MUNICIPIO --}}
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="small text-dark fw-bold text-decoration-underline">Muni. Nacimiento:</label>
                                            <select class="form-select form-select-sm border-warning" name="id_muni" id="sel_muni">
                                                <option value="" selected disabled>-- SELECCIONE --</option>
                                                {{-- Se llena dinámicamente con JavaScript según el departamento --}}
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="small text-dark fw-bold text-decoration-underline">Estado Civil:</label>
                                            <select class="form-select form-select-sm border-warning" name="id_estado_civil">
                                                @foreach($cat['civil'] as $estado_civil)
                                                    <option value="{{ $estado_civil->cod_referencia }}" {{ $perfil->estado_civil_estudiante == $estado_civil->cod_referencia ? 'selected' : '' }}>{{ $estado_civil->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="small text-dark fw-bold text-decoration-underline">Edad:</label>
                                            <input type="text" class="form-control form-control-sm border-warning text-center" name="edad" value="{{ $perfil->edad_estudiante }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="small text-dark fw-bold text-decoration-underline">Identidad:</label>
                                            <input type="text" class="form-control form-control-sm border-warning" name="identidad" value="{{ $perfil->identidad_estudiante }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="small text-dark fw-bold text-decoration-underline">Etnia:</label>
                                            <select class="form-select form-select-sm border-warning" name="id_etnia">
                                                @foreach($cat['etnias'] as $etnia)
                                                    <option value="{{ $etnia->id_etnia }}" {{ $perfil->nombre_grupo_etnico == $etnia->id_etnia ? 'selected' : '' }}>{{ $etnia->descripcion_etnia }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="small text-muted fw-bold">Carrera:</label>
                                            <input type="text" class="form-control form-control-sm bg-secondary bg-opacity-10 fw-bold" value="{{ $perfil->nombre_carrera }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="small text-dark fw-bold text-decoration-underline">Celular:</label>
                                            <input type="text" class="form-control form-control-sm border-warning" name="telefono_celular" value="{{ $perfil->telefono_estudiante }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="small text-dark fw-bold text-decoration-underline">Tel. Fijo:</label>
                                            <input type="text" class="form-control form-control-sm border-warning" name="telefono_fijo" value="{{ $perfil->telefono_casa_materna_paterna }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="small text-dark fw-bold text-decoration-underline">Tel. Pariente:</label>
                                            <input type="text" class="form-control form-control-sm border-warning" name="telefono_pariente" value="{{ $perfil->telefono_pariente_cercano }}">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="small text-muted fw-bold">Correo Electrónico:</label>
                                            <input type="text" class="form-control form-control-sm bg-secondary bg-opacity-10" value="{{ $perfil->email }}" readonly>
                                        </div>
                                    </div>

                                </div>
                            </form>
                            @else
                                <div class="alert alert-danger">Error: No se encontraron datos.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-secondary">
                <button type="button" class="btn btn-danger btn-xs" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-xs" id="btn_guardar">Guardar</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL ELIMINAR --}}
<div class="modal fade" id="modal_eliminar_solicitud" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog text-center">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title h4 text-white"><i class="icon-lg pb-3px" data-feather="x"></i> Cancelar Solicitud</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="row">
                            <center>
                                <i class="btn-icon-prepend text-warning" data-feather="alert-circle" style="width: 90px; height: 90px;"></i>
                                <br><br>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <h4><label class="form-label"><strong>¿Realmente deseas cancelar esta solicitud?</strong></label></h4>
                                        <br>
                                        <h5><label class="form-label" id="lbl_eliminar_nombre"></label></h5>
                                        <br>
                                        <p class="fw-normal">Quedará registrada en el historial como CANCELADA.</p>
                                    </div>
                                </div>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-secondary">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-sm" id="btn_confirmar_eliminar">Sí, Cancelar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
  <script type="text/javascript">
    var table = null; 
    var accion = null;
    var btn_activo = true;
    var id = null;
    var url_guardar = "{{url('/secretariageneral/solicitudEstudiante/guardar')}}"; 
    
    var num_registro = "{{ $perfil->numero_registro_asignado ?? '' }}";
    var url_perfil = "{{ url('/secretariageneral/estudiantes/perfil/') }}/" + num_registro;
    var rowNumber = null;

    var catalogo_municipios = @json($cat['munis'] ?? []);
    var municipio_guardado_perfil = "{{ $perfil->municipio_de_nacimiento_estudiante ?? '' }}";

    function actualizar_select_municipios(identificador_departamento_seleccionado, identificador_municipio_seleccionar) {
        var select_municipio_html = $('#sel_muni');
        select_municipio_html.empty();
        select_municipio_html.append('<option value="" selected disabled>-- SELECCIONE --</option>');

        if (identificador_departamento_seleccionado) {
            var lista_municipios_filtrados = catalogo_municipios.filter(function(municipio_actual) {
                return municipio_actual.id_departamento == identificador_departamento_seleccionado;
            });

            lista_municipios_filtrados.forEach(function(municipio_actual) {
                var atributo_html_seleccionado = (municipio_actual.id_municipio == identificador_municipio_seleccionar) ? 'selected' : '';
                select_municipio_html.append('<option value="' + municipio_actual.id_municipio + '" ' + atributo_html_seleccionado + '>' + municipio_actual.descripcion_municipio + '</option>');
            });
        }
    }
    
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        table = $('#tbl_solicitudes').DataTable({
                responsive: true, 
                columnDefs: [
                    {
                        className: 'dtr-control',
                        orderable: false,
                        targets: 0
                    }
                ],
                "aLengthMenu": [
                    [10, 30, 50, 100,-1],
                    [10, 30, 50, 100,"Todo"]
                ],
                "iDisplayLength": 10,
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

        $('#tbl_solicitudes').each(function() {
            var datatable = $(this);
            var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
            search_input.attr('placeholder', 'Buscar');
            search_input.removeClass('form-control-sm');
            var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
            length_sel.removeClass('form-control-sm');
        });

        $("#tbl_solicitudes tbody").on( "click", "tr", function () { 
            rowNumber = parseInt(table.row( this ).index()); 
            table.$('tr.selected').removeClass('selected'); 
            $(this).addClass('selected'); 
        });

        $('#sel_depto').on('change', function() {
            var departamento_elegido = $(this).val();
            actualizar_select_municipios(departamento_elegido, null);
        });

        var departamento_inicial = $('#sel_depto').val();
        if (departamento_inicial) {
            actualizar_select_municipios(departamento_inicial, municipio_guardado_perfil);
        }
    });

    $("#btn_nueva_solicitud").on("click", function () {
        accion = 1;
        id = null;
        $("#hdn_accion").val("1");
        $("#hdn_id_solicitud").val("");
        $("#sel_proceso").val("");
    });

    $("#tbl_solicitudes tbody").on("click", ".btn_editar", function () {
        accion = 1; 
        id = $(this).data("id");
        $("#hdn_accion").val("1"); 
        $("#hdn_id_solicitud").val(id);
        var proceso = $(this).data("proceso"); 
        if(proceso) $("#sel_proceso").val(proceso);
    });

    $("#tbl_solicitudes tbody").on("click", ".btn_eliminar", function () {
        var nombre = $(this).data("nombre"); 
        id = $(this).data("id");
        $("#lbl_eliminar_nombre").html(nombre);
    });

    $("#btn_guardar").on("click", function () {
        if($("#sel_proceso").val() == null || $("#txt_nacionalidad").val().trim() == '') {
            Toast.fire({
                icon: 'error',
                title: 'Complete todos los campos obligatorios.'
            })
            return true;
        }
        
        if(btn_activo){
            guardar_solicitud();
        }
    });

    $(".modal-footer").on("click", "#btn_confirmar_eliminar", function () { 
        accion = 3;
        if(btn_activo){
            guardar_solicitud(); 
        }
    }); 

    function guardar_solicitud() {
        espera('Procesando...');
        btn_activo = false;

        var data = $("#form_datos").serialize();
        if(accion == 3) {
            data = { id: id, accion: 3, numero_registro: "", id_carrera_admitido: "" };
        }

        $.ajax({
            type: "post",
            url: url_guardar,
            data: data,
            success: function (data) {
                if (!data.estatus) {
                    titleMsg = "Error al Guardar";
                    textMsg = data.msgError;
                    typeMsg = "error";
                    timer = null;
                    btn_activo = true;
                } else {
                    titleMsg = "Datos Guardados";
                    textMsg = data.msgSuccess;
                    typeMsg = "success";
                    timer = 2000;

                    var row = data.registro;
                    
                    var badge = row.es_activo == 1 
                        ? '<span class="badge bg-success text-white">' + row.estado_texto + '</span>' 
                        : '<span class="badge bg-danger text-white">' + row.estado_texto + '</span>';

                    var botones = '';
                    if (row.es_activo == 1) {
                        
                        var disabled_attr = row.graduado != null ? 'disabled' : '';

                        botones = '<div class="d-flex gap-2">' +
                                  '<a href="'+url_perfil+'" class="btn btn-info btn-xs text-dark fw-bold d-inline-flex align-items-center" title="Verificar Documentación">' +
                                  '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text" style="margin-right:4px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> Verificar Documentación' +
                                  '</a> ' +
                                  '<button type="button" class="btn btn-warning btn-icon btn-xs btn_editar" data-bs-toggle="modal" data-bs-target="#modal_gestion_solicitud" ' +
                                  'data-id="'+row.id+'" data-proceso="'+row.id_proceso_graduacion+'" '+disabled_attr+'>'+
                                    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>'+
                                  '</button> ' +
                                  '<button type="button" class="btn btn-danger btn-icon btn-xs btn_eliminar" data-bs-toggle="modal" data-bs-target="#modal_eliminar_solicitud" ' +
                                  'data-id="'+row.id+'" data-nombre="Solicitud #'+row.id+'" '+disabled_attr+'>'+
                                    '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>'+
                                  '</button>' +
                                  '</div>';
                    } else {
                        botones = '<span class="text-muted small"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg> Cerrada</span>';
                    }

                    var nuevaFilaDT = [
                        row.id,
                        '<span class="fw-bold">' + row.nombre_proceso + '</span>',
                        row.modalidad,
                        row.fecha_solicitud,
                        badge,
                        botones
                    ];
                     
                    if(accion==1 && !id) {
                        table.row.add(nuevaFilaDT).draw();
                    } else {
                        table.row(rowNumber).data(nuevaFilaDT).draw();
                    }

                    $("#modal_gestion_solicitud").modal("hide");
                    $("#modal_eliminar_solicitud").modal("hide");
                    btn_activo = true;
                }
                
                ToastLG.fire({
                    icon: typeMsg,
                    title: titleMsg,
                    html: textMsg,
                    timer: timer
                })

            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
                btn_activo = true;
            }
        });
    }

    const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

    const ToastLG = Swal.mixin({
            showConfirmButton: false,
            timerProgressBar: true,
        });

    function espera(html){
        let timerInterval
        Swal.fire({
            imageUrl: "{{ url(asset('/assets/images/unag_loading.gif')) }}",
            title: '¡Espera!',
            html: html,
            timer: null,
            timerProgressBar: true,
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
            if (result.dismiss === Swal.DismissReason.timer) {
            console.log('I was closed by the timer')
            }
        })
    }

  </script>
@endpush