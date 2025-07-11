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
                    <strong>ROL PERMISOS</strong>
                </h1>
                <h4 class="lead bg-white"><div class="alert alert-fill-white" role="alert">Pantalla de asignación de permisos al rol: <b>{{$rol['nombre']}}</b>.</div></h4>
                <br>
                <div class="col-md-3">
                        <a class="btn btn-info btn-sm" id="btn_volver_convenio" href="{{url('setic/roles')}}" data-toggle="tooltip" data-placement="top" title="Regresar a Roles">
                        <i class="btn-icon-prepend" data-feather="corner-up-left"></i> Regresar
                        </a>
                    </div>
            </div>
                <hr />
                <div class="col-12 col-md-12 col-xl-12">
                    <div class="card border-secondary">
                        <div class="card-header bg-azul text-white d-flex justify-content-between align-items-center">
                            <h5 class="text-white mb-0">
                                <i class="text-white icon-lg pb-3px" data-feather="list"></i> Permisos Asignados
                            </h5>
                            <button class="btn btn-primary btn-xs" id="btn_agregar_rol" data-bs-toggle="modal" data-bs-target="#modal_asignar_permiso">
                                <i class="btn-icon-prepend" data-feather="plus"></i> Asignar
                            </butotn>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="jambo_table table table-hover" id="tbl_permisos_asignados" border="1">
                                    <thead class="bg-primary">
                                        <tr class="headings">
                                            <th scope="col" class="text-white">Id</th>
                                            <th scope="col" class="text-white">Permiso</th>
                                            <th scope="col" class="text-white">descripcion</th>
                                            <th scope="col" class="text-white">Estado</th>
                                            <th scope="col" class="text-white">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permisos_asignados as $row)
                                        <tr style="font-size: small;">
                                            <td scope="row">{{$row['id_rol_permiso']}}</td>
                                            <td scope="row">{{$row['permiso']}}</td>
                                            <td scope="row">{{$row['descripcion']}}</td>
                                            <td scope="row">{{$row['estado_permiso']}}</td>
                                            <td scope="row">
                                                @if($row['borrado'])
                                                    <button type="button" class="btn btn-primary btn-icon btn-xs btn_asignar"
                                                        data-id="{{$row['id_rol_permiso']}}"
                                                        data-estado="{{$row['borrado']}}"
                                                        >
                                                        <i data-feather="check"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-danger btn-icon btn-xs btn_quitar"
                                                        data-id="{{$row['id_rol_permiso']}}"
                                                        data-estado="{{$row['borrado']}}"
                                                        >
                                                        <i data-feather="x"></i>
                                                    </button>
                                                @endif
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

<div class="modal fade bd-example modal_asignar_permiso" id="modal_asignar_permiso" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h6 class="modal-title h6 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="lock"></i> Asignar Permiso</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="jambo_table table table-hover" id="tbl_permisos_no_asignados" border="1">
                                        <thead class="bg-primary">
                                            <tr class="headings">
                                                <th scope="col" class="text-white">Id</th>
                                                <th scope="col" class="text-white">Permiso</th>
                                                <th scope="col" class="text-white">descripcion</th>
                                                <th scope="col" class="text-white">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($permisos_no_asignados as $row)
                                            <tr style="font-size: small;">
                                                <td scope="row">{{$row['id_permiso']}}</td>
                                                <td scope="row">{{$row['nombre']}}</td>
                                                <td scope="row">{{$row['descripcion']}}</td>
                                                <td scope="row">
                                                        <button type="button" class="btn btn-primary btn-icon btn-xs btn_registrar_permiso_rol"
                                                            data-id="{{$row['id_permiso']}}"
                                                            data-nombre="{{$row['nombre']}}"
                                                            data-descripcion="{{$row['descripcion']}}"
                                                            >
                                                            <i data-feather="check"></i>
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
            <div class="modal-footer bg-secondary">
                <button type="button" class="btn btn-danger btn-xs" data-bs-dismiss="modal">Cerrar</button>
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
    var table2 = null; 
    var accion = null;
    var btn_activo = true;
    var id_rol = {{$rol['id_rol']}};
    var id = null;
    var nombre = null;
    var descripcion = null;
    var estado = null;
    var url_guardar_rol_permiso = "{{url('/setic/roles/permisos/guardar')}}"; 
    var rowNumber=null;
    var rowNumber2=null;
    var id_seleccionar = localStorage.getItem("tbl_permisos_asignados_id_seleccionar");
    var id_seleccionar2 = localStorage.getItem("tbl_permisos_no_asignados_id_seleccionar");
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        table = $('#tbl_permisos_asignados').DataTable({
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
            $('#tbl_permisos_asignados').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Buscar');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
                });

            $("#tbl_permisos_asignados tbody").on( "click", "tr", function () { 
                rowNumber=parseInt(table.row( this ).index()); 
                table.$('tr.selected').removeClass('selected'); 
                $(this).addClass('selected'); 
                localStorage.setItem("tbl_permisos_asignados_id_seleccionar",table.row( this ).data()[0]); 
            });

    table2 = $('#tbl_permisos_no_asignados').DataTable({
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
            $('#tbl_permisos_no_asignados').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Buscar');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
                });

            $("#tbl_permisos_no_asignados tbody").on( "click", "tr", function () { 
                rowNumber2=parseInt(table2.row( this ).index()); 
                accion=2; 
                table2.$('tr.selected').removeClass('selected'); 
                $(this).addClass('selected'); 
                localStorage.setItem("tbl_permisos_no_asignados_id_seleccionar",table2.row( this ).data()[0]); 
            });

    });

    $('#tbl_permisos_asignados').on('click', '.btn_quitar', function () {
        accion = 1;
        id = $(this).data('id');
        estado = $(this).data('estado');
        guardar_role_permiso()
        //console.log('ID enviado:', estado);

    });

    $('#tbl_permisos_asignados').on('click', '.btn_asignar', function () {
        accion = 1;
        id = $(this).data('id');
        estado = $(this).data('estado');
        guardar_role_permiso()
        //console.log('ID enviado:', estado);

    });

    $('#tbl_permisos_no_asignados').on('click', '.btn_registrar_permiso_rol', function () {
        accion = 2;
        id = $(this).data('id');
        estado = $(this).data('estado');
        guardar_role_permiso()
        //console.log('ID enviado:', estado);

    });

    function guardar_role_permiso() {
        espera('Tu información se esta guardando...');
        btn_activo = false;
        console.log(id+' '+estado);
        $.ajax({
            type: "post",
            url: url_guardar_rol_permiso,
            data: {
                accion : accion,
                id : id,
                estado : estado,
                id_rol : id_rol
  
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
                    timer = 1000;
  
                        var row = data.permisos_asignados_list;
                        //console.log(row.borrado);
                           var boton = null;
                            if(row.borrado){
                                    boton = `<button type="button" class="btn btn-primary btn-icon btn-xs btn_asignar" data-id="${row.id_rol_permiso}" data-estado="${row.borrado}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                        </button>`
                                    
                            }else{
                                boton = `<button type="button" class="btn btn-danger btn-icon btn-xs btn_quitar" data-id="${row.id_rol_permiso}" data-estado="${row.borrado}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>`
                            }
                            var nuevaFilaDT=[row.id_rol_permiso, row.permiso, row.descripcion, row.estado_permiso, boton]; 
                            table.row(rowNumber).data(nuevaFilaDT);
                        if(accion == 2){
                            table.row.add(nuevaFilaDT).draw();
                            table2.row(rowNumber2).remove().draw();
                        }
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