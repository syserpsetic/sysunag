@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
@endpush

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-dark" role="alert">
                    <h1 class="display-3 d-flex align-items-center">
                        <i data-feather="book-open" class="me-3" style="width: 60px; height: 60px;"></i>
                        <strong>PROCESOS DE GRADUACIÓN</strong>
                    </h1>
                    <h4 class="lead bg-white"><div class="alert alert-fill-white" role="alert">Pantalla de administración de procesos de graduación.</div></h4>
                </div>
                <hr />
                <div class="col-12 col-md-12 col-xl-12">
                    <div class="card border-secondary">
                        <div class="card-header bg-azul text-white d-flex justify-content-between align-items-center">
                            <h5 class="text-white mb-0">
                                <i class="text-white icon-lg pb-3px" data-feather="list"></i> Lista de Procesos
                            </h5>
                            @if(in_array('secretaria_general_escribir_proceso_graduacion', $scopes))
                                <button class="btn btn-primary btn-xs" id="btn_agregar_proceso" data-bs-toggle="modal" data-bs-target="#modal_agregar_proceso">
                                    <i class="btn-icon-prepend" data-feather="plus"></i> Agregar Proceso
                                </button>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="jambo_table table table-hover" id="tbl_procesos" border="1">
                                    <thead class="bg-primary text-white">
                                        <tr class="headings">
                                            <th scope="col" class="text-white">Id</th>
                                            <th scope="col" class="text-white">Nombre Proceso</th>
                                            <th scope="col" class="text-white">F. Inicio</th>
                                            <th scope="col" class="text-white">F. Final</th>
                                            <th scope="col" class="text-white">Sede</th>
                                            <th scope="col" class="text-white">Modalidad</th>
                                            <th scope="col" class="text-white">Actos</th>
                                            <th scope="col" class="text-white text-center">Enrolados</th>
                                            <th scope="col" class="text-white">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($procesos) && count($procesos) > 0)
                                            @foreach ($procesos as $proceso_individual)
                                            <tr style="font-size: small;">
                                                <td scope="row">{{$proceso_individual['id']}}</td>
                                                <td scope="row">{{$proceso_individual['nombre_proceso']}}</td>
                                                <td scope="row">{{$proceso_individual['fecha_inicio_proceso']}}</td>
                                                <td scope="row">{{$proceso_individual['fecha_final_proceso']}}</td>
                                                <td scope="row">{{$proceso_individual['descripcion_sede']}}</td>
                                                <td scope="row">{{$proceso_individual['nombre_modalidad']}}</td>
                                                <td scope="row" style="max-width: 200px; white-space: normal;">
                                                    <small>{{$proceso_individual['actos_nombres']}}</small>
                                                </td>
                                                <td scope="row" class="text-center">
                                                    <span class="badge bg-primary fs-6">{{$proceso_individual['total_enrolados'] ?? 0}}</span>
                                                </td>
                                                <td scope="row">
                                                    @if(in_array('secretaria_general_escribir_proceso_graduacion', $scopes))
                                                        <button type="button" class="btn btn-warning btn-icon btn-xs btn_editar_proceso"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modal_agregar_proceso"
                                                            data-id="{{$proceso_individual['id']}}"
                                                            data-nombre="{{$proceso_individual['nombre_proceso']}}"
                                                            data-descripcion="{{$proceso_individual['descripcion']}}"
                                                            data-fecha_inicio="{{$proceso_individual['fecha_inicio_proceso']}}"
                                                            data-fecha_final="{{$proceso_individual['fecha_final_proceso']}}"
                                                            data-sede="{{$proceso_individual['id_sede']}}"
                                                            data-modalidad="{{$proceso_individual['id_modalidades']}}"
                                                            data-actos="{{$proceso_individual['actos_ids']}}"
                                                            >
                                                            <i data-feather="check-square"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-icon btn-xs"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modal_eliminar_proceso"
                                                            data-id="{{$proceso_individual['id']}}"
                                                            data-nombre="{{$proceso_individual['nombre_proceso']}}"
                                                            >
                                                            <i data-feather="trash-2"></i>
                                                        </button>
                                                    @endif
                                                    @if(in_array('secretaria_general_leer_proceso_graduacion_estudiantes', $scopes))
                                                        <a href="{{url('secretariageneral/procesoGraduacion')}}/{{$proceso_individual['id']}}/estudiantes" 
                                                        class="btn btn-info btn-icon btn-xs">
                                                            <i data-feather="users"></i>
                                                        </a>
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

{{-- MODAL AGREGAR / EDITAR --}}
<div class="modal fade bd-example modal_agregar_proceso" id="modal_agregar_proceso" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title h6 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="book-open"></i> Datos del Proceso</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="modal_proceso_nombre" class="form-label">Nombre del Proceso</label>
                                        <input id="modal_proceso_nombre" class="form-control" type="text" placeholder="ESCRIBA EL NOMBRE..."/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="modal_proceso_fecha_inicio" class="form-label">Fecha Inicio</label>
                                        <input id="modal_proceso_fecha_inicio" class="form-control" type="date" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="modal_proceso_fecha_final" class="form-label">Fecha Final</label>
                                        <input id="modal_proceso_fecha_final" class="form-control" type="date" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="modal_proceso_sede" class="form-label">Sede</label>
                                        <select id="modal_proceso_sede" class="form-select">
                                            <option value="" selected disabled>SELECCIONE...</option>
                                            @foreach($sedes as $sede_individual)
                                                <option value="{{ $sede_individual['id_sede'] }}">{{ $sede_individual['descripcion_sede'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="modal_proceso_modalidad" class="form-label">Modalidad</label>
                                        <select id="modal_proceso_modalidad" class="form-select">
                                            <option value="" selected disabled>SELECCIONE...</option>
                                            @if(isset($modalidades))
                                                @foreach($modalidades as $modalidad_individual)
                                                    <option value="{{ $modalidad_individual['id'] }}">{{ $modalidad_individual['nombre'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="modal_proceso_descripcion" class="form-label">Descripción</label>
                                        <textarea class="form-control" id="modal_proceso_descripcion" rows="3" placeholder="Escriba aquí..."></textarea>
                                    </div>
                                </div>

                                {{-- SECCIÓN ACTOS (Checkboxes) --}}
                                <div class="col-md-12">
                                    <hr>
                                    <label class="form-label fw-bold">Actos de Graduación Habilitados:</label>
                                    <div class="row">
                                        @if(isset($actos))
                                            @foreach($actos as $acto_individual)
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input check_acto" type="checkbox" id="acto_{{$acto_individual['id']}}" value="{{$acto_individual['id']}}">
                                                    <label class="form-check-label" for="acto_{{$acto_individual['id']}}">{{$acto_individual['nombre']}}</label>
                                                </div>
                                            </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-secondary">
                <button type="button" class="btn btn-danger btn-xs" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-xs" id="btn_guardar_proceso">Guardar</button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL ELIMINAR --}}
<div class="modal fade modal_eliminar_proceso" id="modal_eliminar_proceso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog text-center">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title h4 text-white"><i class="icon-lg pb-3px" data-feather="x"></i> Eliminar Registro</h5>
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
                                        <h4><label class="form-label"><strong>¿Realmente deseas eliminar este registro?</strong></label></h4>
                                        <br>
                                        <h5><label class="form-label" id="modal_eliminar_informacion"></label></h5>
                                        <br>
                                        <p class="fw-normal">Este proceso no se puede revertir</p>
                                    </div>
                                </div>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-secondary">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-sm" id="btn_confirmar_eliminar_proceso">Eliminar</button>
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
    
    var tabla_procesos = null; 
    var accion_form = null;
    var btn_activo = true;
    var id_proceso = null;
    var url_guardar_proceso = "{{url('/secretariageneral/procesoGraduacion/guardar')}}"; 
    var indice_fila = null;

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        tabla_procesos = $('#tbl_procesos').DataTable({
                responsive: true,
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

        $('#tbl_procesos').each(function() {
            var datatable = $(this);
            var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
            search_input.attr('placeholder', 'Buscar');
            search_input.removeClass('form-control-sm');
            var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
            length_sel.removeClass('form-control-sm');
        });

        $("#tbl_procesos tbody").on( "click", "tr", function () { 
            indice_fila = parseInt(tabla_procesos.row( this ).index()); 
            tabla_procesos.$('tr.selected').removeClass('selected'); 
            $(this).addClass('selected'); 
        });

    });

    $("#btn_agregar_proceso").on("click", function () { 
        accion_form = 1; 
        id_proceso = null; 
        limpiar_formulario();
    });

    $("#modal_agregar_proceso").on("show.bs.modal", function (e) {
        var trigger = $(e.relatedTarget);
        limpiar_formulario();

        if(trigger.data("id")){
            accion_form = 2;
            id_proceso = trigger.data("id");
            $("#modal_proceso_nombre").val(trigger.data("nombre"));
            $("#modal_proceso_descripcion").val(trigger.data("descripcion"));
            $("#modal_proceso_fecha_inicio").val(trigger.data("fecha_inicio"));
            $("#modal_proceso_fecha_final").val(trigger.data("fecha_final"));
            $("#modal_proceso_sede").val(trigger.data("sede"));
            $("#modal_proceso_modalidad").val(trigger.data("modalidad"));

            var actosStr = trigger.data("actos"); 
            if(actosStr){
                var actosArray = String(actosStr).split(',');
                actosArray.forEach(function(actoId) {
                    $("#acto_" + actoId).prop('checked', true);
                });
            }
        }
    });

    function limpiar_formulario(){
        $("#modal_proceso_nombre, #modal_proceso_descripcion, #modal_proceso_fecha_inicio, #modal_proceso_fecha_final").val("");
        $("#modal_proceso_sede, #modal_proceso_modalidad").val("");
        $(".check_acto").prop('checked', false); 
    }

    $("#modal_eliminar_proceso").on("show.bs.modal", function (e) {
        var trigger = $(e.relatedTarget);
        id_proceso = trigger.data("id");
        $("#modal_eliminar_informacion").html(trigger.data("nombre"));
    });

    $("#btn_guardar_proceso").on("click", function () {
        if($("#modal_proceso_nombre").val() == '' || $("#modal_proceso_sede").val() == null || $("#modal_proceso_modalidad").val() == null || $("#modal_proceso_fecha_inicio").val() == '' || $("#modal_proceso_fecha_final").val() == ''){
            Toast.fire({ icon: 'error', title: 'Faltan campos requeridos.' });
            return;
        }
        if($("#modal_proceso_fecha_final").val() <= $("#modal_proceso_fecha_inicio").val()){
            Toast.fire({ icon: 'warning', title: 'La fecha final debe ser mayor a la inicial.' });
            return;
        }
        if(btn_activo) guardar(); 
    });

    $("#btn_confirmar_eliminar_proceso").on("click", function () { 
        accion_form = 3; 
        if(btn_activo) guardar(); 
    }); 

    function guardar() {
        espera('Guardando información...');
        btn_activo = false;

        var actosSeleccionados = [];
        $(".check_acto:checked").each(function() {
            actosSeleccionados.push($(this).val());
        });

        $.ajax({
            type: "post",
            url: url_guardar_proceso,
            data: {
                accion: accion_form,
                id: id_proceso,
                nombre_proceso: $("#modal_proceso_nombre").val(),
                descripcion: $("#modal_proceso_descripcion").val(),
                fecha_inicio: $("#modal_proceso_fecha_inicio").val(),
                fecha_final: $("#modal_proceso_fecha_final").val(),
                id_sede: $("#modal_proceso_sede").val(),
                modalidad: $("#modal_proceso_modalidad").val(),
                actos: actosSeleccionados 
            },
            success: function (respuesta) {
                var titleMsg = "";
                var textMsg = "";
                var typeMsg = "";
                var timer = null;

                if (respuesta.msgError != null) {
                    titleMsg = "Error al Guardar";
                    textMsg = respuesta.msgError;
                    typeMsg = "error";
                    btn_activo = true;
                } else {
                    titleMsg = "Datos Guardados";
                    textMsg = respuesta.msgSuccess;
                    typeMsg = "success";
                    timer = 2000;

                    if(accion_form == 3){
                        tabla_procesos.row(indice_fila).remove().draw();
                        $("#modal_eliminar_proceso").modal("hide");
                    } else {
                        var proceso = respuesta.procesos_list; 
                        
                        var nuevaFilaDT = [
                            proceso.id, 
                            proceso.nombre_proceso, 
                            proceso.fecha_inicio_proceso, 
                            proceso.fecha_final_proceso, 
                            proceso.descripcion_sede, 
                            proceso.nombre_modalidad,
                            '<small>'+ (proceso.actos_nombres ? proceso.actos_nombres : 'Sin actos') +'</small>',
                            '<center><span class="badge bg-primary fs-6">'+ (proceso.total_enrolados ? proceso.total_enrolados : 0) +'</span></center>',
                            '<button type="button" class="btn btn-warning btn-icon btn-xs btn_editar_proceso" data-bs-toggle="modal" data-bs-target="#modal_agregar_proceso" '+
                            'data-id="'+proceso.id+'" data-nombre="'+proceso.nombre_proceso+'" data-descripcion="'+proceso.descripcion+'" '+
                            'data-fecha_inicio="'+proceso.fecha_inicio_proceso+'" data-fecha_final="'+proceso.fecha_final_proceso+'" '+
                            'data-sede="'+proceso.id_sede+'" data-modalidad="'+proceso.id_modalidades+'" data-actos="'+proceso.actos_ids+'">'+
                                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>'+
                            '</button> '+
                            '<button type="button" class="btn btn-danger btn-icon btn-xs" data-bs-toggle="modal" data-bs-target="#modal_eliminar_proceso" '+
                            'data-id="'+proceso.id+'" data-nombre="'+proceso.nombre_proceso+'">'+
                                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>'+
                            '</button> '+
                            '<a href="{{url("secretariageneral/procesoGraduacion")}}/'+proceso.id+'/estudiantes" class="btn btn-info btn-icon btn-xs">'+
                                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>'+
                            '</a>'
                        ];

                        if(accion_form == 1) tabla_procesos.row.add(nuevaFilaDT).draw();
                        else if(accion_form == 2) tabla_procesos.row(indice_fila).data(nuevaFilaDT).draw();
                        
                        $("#modal_agregar_proceso").modal("hide");
                    }

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