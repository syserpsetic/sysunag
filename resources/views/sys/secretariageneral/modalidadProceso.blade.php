@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-dark" role="alert">
                    <h1 class="display-3 d-flex align-items-center">
                        <i data-feather="layers" class="me-3" style="width: 60px; height: 60px;"></i>
                        <strong>MODALIDADES DEL PROCESO</strong>
                    </h1>
                    <h4 class="lead bg-white"><div class="alert alert-fill-white" role="alert">Administración de las modalidades de graduación.</div></h4>
                </div>
                <hr />
                <div class="col-12 col-md-12 col-xl-12">
                    <div class="card border-secondary">
                        <div class="card-header bg-azul text-white d-flex justify-content-between align-items-center">
                            <h5 class="text-white mb-0">
                                <i class="text-white icon-lg pb-3px" data-feather="list"></i> Lista de Modalidades
                            </h5>
                             @if(in_array('secretaria_general_escribir_modalidades_de_graduacion', $scopes))
                                <button class="btn btn-primary btn-xs" id="btn_agregar_modalidad" data-bs-toggle="modal" data-bs-target="#modal_gestion_modalidad">
                                    <i class="btn-icon-prepend" data-feather="plus"></i> Agregar Modalidad
                                </button>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="jambo_table table table-hover" id="tbl_modalidades" border="1">
                                    <thead class="bg-primary text-white">
                                        <tr class="headings">
                                            <th scope="col" class="text-white">Id</th>
                                            <th scope="col" class="text-white">Nombre</th>
                                            <th scope="col" class="text-white">Descripción</th>
                                            <th scope="col" class="text-white">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($modalidades))
                                            @foreach ($modalidades as $row)
                                            <tr style="font-size: small;">
                                                <td scope="row">{{$row['id']}}</td>
                                                <td scope="row">{{$row['nombre']}}</td>
                                                <td scope="row">{{$row['descripcion']}}</td>
                                                <td scope="row">
                                                @if(in_array('secretaria_general_escribir_modalidades_de_graduacion', $scopes))
                                                    <button type="button" class="btn btn-warning btn-icon btn-xs btn_editar"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#modal_gestion_modalidad"
                                                        data-id="{{$row['id']}}"
                                                        data-nombre="{{$row['nombre']}}"
                                                        data-descripcion="{{$row['descripcion']}}"
                                                        >
                                                        <i data-feather="check-square"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-danger btn-icon btn-xs"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#modal_eliminar_modalidad"
                                                        data-id="{{$row['id']}}"
                                                        data-nombre="{{$row['nombre']}}"
                                                        >
                                                        <i data-feather="trash-2"></i>
                                                    </button>
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
<div class="modal fade bd-example" id="modal_gestion_modalidad" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h6 class="modal-title h6 text-white"><i class="icon-lg pb-3px" data-feather="layers"></i> Gestión de Modalidad</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label for="modal_nombre_modalidad" class="form-label">Nombre</label>
                                        <input id="modal_nombre_modalidad" class="form-control" type="text" placeholder="Ej: EXAMEN GENERAL..."/>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="modal_descripcion_modalidad" class="form-label">Descripción</label>
                                        <textarea id="modal_descripcion_modalidad" class="form-control" rows="4" placeholder="Detalles adicionales..."></textarea>
                                    </div>
                                </div>
                            </div>
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
<div class="modal fade" id="modal_eliminar_modalidad" tabindex="-1" aria-hidden="true">
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
                                        <h5><label class="form-label" id="lbl_eliminar_nombre"></label></h5>
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
                <button type="button" class="btn btn-primary btn-sm" id="btn_confirmar_eliminar">Eliminar</button>
            </div>
        </div>
    </div>
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
  <script type="text/javascript">
    var table = null; 
    var accion = null; 
    var btn_activo = true;
    var id = null;
    var url_guardar = "{{url('/secretariageneral/modalidadProceso/guardar')}}"; 
    var rowNumber = null;

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        table = $('#tbl_modalidades').DataTable({
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

        $('#tbl_modalidades').each(function() {
            var datatable = $(this);
            var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
            search_input.attr('placeholder', 'Buscar');
            search_input.removeClass('form-control-sm');
            var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
            length_sel.removeClass('form-control-sm');
        });

        $("#tbl_modalidades tbody").on( "click", "tr", function () { 
            rowNumber = parseInt(table.row( this ).index()); 
            table.$('tr.selected').removeClass('selected'); 
            $(this).addClass('selected'); 
        });

    });

    $("#btn_agregar_modalidad").on("click", function () { 
        accion = 1; 
        id = null; 
        $("#modal_nombre_modalidad").val("");
        $("#modal_descripcion_modalidad").val("");
    });

    $("#modal_gestion_modalidad").on("show.bs.modal", function (e) {
        var trigger = $(e.relatedTarget);
        if(trigger.data("id")){
            accion = 2;
            id = trigger.data("id");
            $("#modal_nombre_modalidad").val(trigger.data("nombre"));
            $("#modal_descripcion_modalidad").val(trigger.data("descripcion"));
        }
    });

    $("#modal_eliminar_modalidad").on("show.bs.modal", function (e) {
        var trigger = $(e.relatedTarget);
        id = trigger.data("id");
        $("#lbl_eliminar_nombre").html(trigger.data("nombre"));
    });

    $("#btn_guardar").on("click", function () {
        if($("#modal_nombre_modalidad").val() == ''){
            Toast.fire({ icon: 'error', title: 'El nombre es obligatorio.' });
            return;
        }
        if(btn_activo) guardar(); 
    });

    $("#btn_confirmar_eliminar").on("click", function () { 
        accion = 3; 
        if(btn_activo) guardar(); 
    });

    function guardar() {
        espera('Tu información se esta guardando...');
        btn_activo = false;

        $.ajax({
            type: "post",
            url: url_guardar,
            data: {
                accion: accion,
                id: id,
                nombre: $("#modal_nombre_modalidad").val(),
                descripcion: $("#modal_descripcion_modalidad").val()
            },
            success: function (data) {
                if (data.msgError != null) {
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

                    if(accion == 3){
                        table.row(rowNumber).remove().draw();
                        $("#modal_eliminar_modalidad").modal("hide");
                    } else {
                        // AQUÍ APLICAMOS EL CAMBIO ESTRICTAMENTE NECESARIO DE LA REFACTORIZACIÓN
                        var row = data.modalidad_procesada; 
                        
                        var nuevaFilaDT = [
                            row.id, 
                            row.nombre, 
                            row.descripcion, 
                            '<button type="button" class="btn btn-warning btn-icon btn-xs btn_editar" data-bs-toggle="modal" data-bs-target="#modal_gestion_modalidad" '+
                            'data-id="'+row.id+'" data-nombre="'+row.nombre+'" data-descripcion="'+row.descripcion+'">'+
                                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>'+
                            '</button> '+
                            '<button type="button" class="btn btn-danger btn-icon btn-xs" data-bs-toggle="modal" data-bs-target="#modal_eliminar_modalidad" '+
                            'data-id="'+row.id+'" data-nombre="'+row.nombre+'">'+
                                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>'+
                            '</button>'
                        ];

                        if(accion == 1) table.row.add(nuevaFilaDT).draw();
                        else if(accion == 2) table.row(rowNumber).data(nuevaFilaDT).draw();
                        
                        $("#modal_gestion_modalidad").modal("hide");
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