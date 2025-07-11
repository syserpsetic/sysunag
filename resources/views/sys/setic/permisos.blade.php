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
                    <i data-feather="lock" class="me-3" style="width: 60px; height: 60px;"></i>
                    <strong>PERMISOS</strong>
                </h1>
                <h4 class="lead bg-white"><div class="alert alert-fill-white" role="alert">Pantalla de adminisración de permisos.</div></h4>
                <br>
                <!-- <div class="col-md-3">
                        <a class="btn btn-info btn-sm" id="btn_volver_convenio" href="{{url('setic/malla_validacion')}}" data-toggle="tooltip" data-placement="top" title="Regresar a Malla de Validaciones">
                        <i class="btn-icon-prepend" data-feather="corner-up-left"></i> Regresar
                        </a>
                    </div> -->
            </div>
                <hr />
                <div class="col-12 col-md-12 col-xl-12">
                    <div class="card border-secondary">
                        <div class="card-header bg-azul text-white d-flex justify-content-between align-items-center">
                            <h5 class="text-white mb-0">
                                <i class="text-white icon-lg pb-3px" data-feather="list"></i> Permisos
                            </h5>
                            <button class="btn btn-primary btn-xs" id="btn_agregar_rol" data-bs-toggle="modal" data-bs-target="#modal_agregar_permioso">
                                <i class="btn-icon-prepend" data-feather="plus"></i> Agregar Permiso
                            </butotn>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="jambo_table table table-hover" id="tbl_roles" border="1">
                                    <thead class="bg-primary">
                                        <tr class="headings">
                                            <th scope="col" class="text-white">Id</th>
                                            <th scope="col" class="text-white">Nombre</th>
                                            <th scope="col" class="text-white">Descripcion</th>
                                            <th scope="col" class="text-white">Página</th>
                                            <th scope="col" class="text-white">Requisito</th>
                                            <th scope="col" class="text-white">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permisos as $row)
                                        <tr style="font-size: small;">
                                            <td scope="row">{{$row['id_permiso']}}</td>
                                            <td scope="row">{{$row['nombre']}}</td>
                                            <td scope="row">{{$row['descripcion']}}</td>
                                            <td scope="row">{{$row['pagina']}}</td>
                                            <td scope="row">{{$row['requisito']}}</td>
                                            <td scope="row">
                                                <button type="button" class="btn btn-warning btn-icon btn-xs btn_editar_rol"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target=".modal_agregar_permioso"
                                                    data-id="{{$row['id_permiso']}}"
                                                    data-nombre="{{$row['nombre']}}"
                                                    data-descripcion="{{$row['descripcion']}}"
                                                    >
                                                    <i data-feather="check-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-icon btn-xs"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target=".modal_eliminar_rol"
                                                    data-id="{{$row['id_permiso']}}"
                                                    data-nombre="{{$row['nombre']}}"
                                                    data-descripcion="{{$row['descripcion']}}"
                                                    >
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
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

<div class="modal fade bd-example modal_agregar_permioso" id="modal_agregar_permioso" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h6 class="modal-title h6 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="lock"></i> Registrar Nuevo Permiso</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="modal_agregar_permioso_nombre" class="form-label">Nombre</label>
                                        <input id="modal_agregar_permioso_nombre" class="form-control" type="text" placeholder="Nombre del permio..."/>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label for="modal_agregar_permioso_descripcion" class="form-label">Descripción</label>
                                            <div class="form-check form-switch m-0">
                                                <input type="checkbox" class="form-check-input" id="formSwitch1_agregar_rol_etado" />
                                                <label class="form-check-label" for="formSwitch1_agregar_rol_etado">Activo</label>
                                            </div>
                                        </div>
                                        <textarea class="form-control" name="tinymce" id="modal_agregar_permioso_descripcion" maxlength="100"
                                            rows="4"
                                            placeholder="Escriba aquí..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-secondary">
                <button type="button" class="btn btn-danger btn-xs" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-xs" id="btn_guardar_rol">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal_eliminar_rol" id="modal_eliminar_rol" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title h4 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="x"></i> Eliminar Registro</h5>
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
                                        <h5><label class="form-label" id="modal_eliminar_rol_informacion"></label></h5>
                                        <br>
                                        <p class="fw-normal">Este proceso no se puede revertir</p>
                                    </div>
                                </div>
                            </center>
                        </div>
                        <!-- Row -->
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-secondary">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-sm" id="btn_eliminar_rol">Eliminar</button>
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
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=mzutkZDE"></script>
  <script type="text/javascript">
    var table = null; 
    var accion = null;
    var btn_activo = true;
    var id = null;
    var nombre = null;
    var descripcion = null;
    var estado = null;
    var url_guardar_rol = "{{url('/setic/roles/guardar')}}"; 
    var rowNumber=null;
    var id_seleccionar = localStorage.getItem("tbl_roles_id_seleccionar");
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        table = $('#tbl_roles').DataTable({
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
            $('#tbl_roles').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Buscar');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
                });

            $("#tbl_roles tbody").on( "click", "tr", function () { 
                rowNumber=parseInt(table.row( this ).index()); 
                accion=2; 
                table.$('tr.selected').removeClass('selected'); 
                $(this).addClass('selected'); 
                localStorage.setItem("tbl_roles_id_seleccionar",table.row( this ).data()[0]); 
            });

    });

    // $(".btn_editar_rol").on("click", function () {
    //     accion = 2;
    // })

    $("#btn_agregar_rol").on("click", function () {
        accion = 1;
    })

    $("#modal_agregar_permioso").on("show.bs.modal", function (e) {
        $('#formSwitch1_agregar_rol_etado').prop('checked', false);
        var triggerLink = $(e.relatedTarget);
        id = triggerLink.data("id");
        nombre = triggerLink.data("nombre");
        descripcion = triggerLink.data("descripcion");
        estado = triggerLink.data("estado");
        $("#modal_agregar_permioso_nombre").val(nombre);
        $("#modal_agregar_permioso_descripcion").val(descripcion);
        console.log(estado)
        if(estado == 1){
            $('#formSwitch1_agregar_rol_etado').prop('checked', true);
        }
    });

    $("#modal_eliminar_rol").on("show.bs.modal", function (e) {
            var triggerLink = $(e.relatedTarget);
            id = triggerLink.data("id");
            nombre = triggerLink.data("nombre");
            descripcion = triggerLink.data("descripcion");
            estado = triggerLink.data("estado");
            $("#modal_eliminar_rol_informacion").html(nombre);
    });

    $("#btn_guardar_rol").on("click", function () {
        nombre = $("#modal_agregar_permioso_nombre").val();
        descripcion = $("#modal_agregar_permioso_descripcion").val();
        if ($('#formSwitch1_agregar_rol_etado').is(':checked')) {
            estado = 1;
        } else {
            estado = 2;
        }
        
     
            if(nombre == null || nombre == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Valor requerido para Nombre.'
                })
                return true;
            }

            if(descripcion == null || descripcion == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Valor requerido para Descripción.'
                })
                return true;
            }
            
            if(btn_activo){
                guardar_rol();
            }
            

    });

    $(".modal-footer").on("click", "#btn_eliminar_rol", function () { 
            accion = 3;
            if(btn_activo){
                guardar_rol(); 
            }
    }); 

    function guardar_rol() {
        espera('Tu información se esta guardando...');
        btn_activo = false;
        //console.log(hora_inicio);
        $.ajax({
            type: "post",
            url: url_guardar_rol,
            data: {
                accion : accion,
                id : id,
                nombre : nombre,
                descripcion : descripcion,
                estado : estado,
  
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
                    if(accion==1 || accion==2){
                        var row = data.rol_list;
                        //console.log(row);
                        var nuevaFilaDT=[row.id_rol, row.nombre, row.descripcion, row.estado_rol,
                            '<button type="button" class="btn btn-warning btn-icon btn-xs btn_editar_rol" data-bs-toggle="modal" data-bs-target=".modal_agregar_permioso" '+
                            'data-id="'+row.id_rol+'" '+
                            'data-nombre="'+row.nombre+'" '+
                            'data-descripcion="'+row.descripcion+'" '+
                            'data-estado="'+row.id_estado+'">'+
                                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>'+
                            '</button> '+
                            '<button type="button" class="btn btn-danger btn-icon btn-xs" data-bs-toggle="modal" data-bs-target=".modal_eliminar_rol" '+
                            'data-id="'+row.id_rol+'" '+
                            'data-nombre="'+row.nombre+'" '+
                            'data-descripcion="'+row.descripcion+'" '+
                            'data-estado="'+row.id_estado+'">'+
                                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>'+
                            '</button> '+
                            '<a type="button" class="btn btn-info btn-icon btn-xs" href="{{url('setic/roles/')}}/'+row.id_rol+'/permisos"> '+
                                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg> '+
                            '</a>'
                        ];
                    }
                     
                    if(accion==1) {
                        table.row.add(nuevaFilaDT).draw();
                    }else if (accion==2) {
                        table.row(rowNumber).data(nuevaFilaDT);
                    }else if(accion==3){
                        table.row(rowNumber).remove().draw();
                        $("#modal_eliminar_rol").modal("hide");
                    }
                    $("#modal_agregar_permioso").modal("hide");
                    btn_activo = true;
                }
                //console.log(textMsg);
                ToastLG.fire({
                    icon: typeMsg,
                    title: titleMsg,
                    html: textMsg,
                    timer: timer
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

    const ToastLG = Swal.mixin({
            //toast: true,
            //position: 'top-end',
            showConfirmButton: false,
            timerProgressBar: true,
        });

    function espera(html){
        let timerInterval
        Swal.fire({
            imageUrl: "{{ url(asset('/assets/images/unag_loading.gif')) }}",
            // icon: 'warning',
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
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
            console.log('I was closed by the timer')
            }
        })
    }

  </script>
@endpush