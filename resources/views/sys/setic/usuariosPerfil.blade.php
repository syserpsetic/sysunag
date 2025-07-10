@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="position-relative">
                <figure class="overflow-hidden mb-0 d-flex justify-content-center">
                    <img src="https://portal.unag.edu.hn/wp-content/uploads/2020/07/encabezado-rrnn.jpg" class="rounded-top" alt="profile cover" />
                </figure>
                <div class="d-flex justify-content-between align-items-center position-absolute top-90 w-100 px-2 px-md-4 mt-n4">
                    <div>
                        <img
                            class="wd-70 rounded-circle"
                            src="{{ asset('/matricula/documentos/fotos/')}}/{{$user['foto']}}"
                            alt="profile"
                            alt="user"
                            onerror="this.onerror=null; this.src='{{ url(asset('/assets/images/user2-403d6e88.png')) }}';"
                        />
                        <span class="h4 ms-3 text-white"><b>{{$user['name']}}</b></span>
                    </div>
                    <div class="d-none d-md-block">
                        <button class="btn btn-primary btn-icon-text"><i data-feather="edit" class="btn-icon-prepend"></i> Edit profile</button>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center p-3 rounded-bottom">
                <ul class="d-flex align-items-center m-0 p-0">
                    <li class="d-flex align-items-center">
                        <i class="me-1 icon-md" data-feather="corner-up-left"></i>
                        <a class="pt-1px d-none d-md-block text-body" id="btn_volver_convenio" href="{{url('setic/usuarios')}}" data-toggle="tooltip" data-placement="top" title="Regresar a Usuarios">
                         Regresar
                        </a>
                    </li>
                    <li class="ms-3 ps-3 border-start d-flex align-items-center active">
                        <i class="me-1 icon-md text-primary" data-feather="columns"></i>
                        <a class="pt-1px d-none d-md-block text-primary" href="#">Resumen</a>
                    </li>
                    <li class="ms-3 ps-3 border-start d-flex align-items-center">
                        <i class="me-1 icon-md" data-feather="user"></i>
                        <a class="pt-1px d-none d-md-block text-body" href="#">About</a>
                    </li>
                    <li class="ms-3 ps-3 border-start d-flex align-items-center">
                        <i class="me-1 icon-md" data-feather="users"></i>
                        <a class="pt-1px d-none d-md-block text-body" href="#">Friends <span class="text-muted tx-12">3,765</span></a>
                    </li>
                    <li class="ms-3 ps-3 border-start d-flex align-items-center">
                        <i class="me-1 icon-md" data-feather="image"></i>
                        <a class="pt-1px d-none d-md-block text-body" href="#">Photos</a>
                    </li>
                    <li class="ms-3 ps-3 border-start d-flex align-items-center">
                        <i class="me-1 icon-md" data-feather="video"></i>
                        <a class="pt-1px d-none d-md-block text-body" href="#">Videos</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row profile-body">
    <!-- left wrapper start -->
    <div class="d-none d-md-block col-md-4 col-xl-2 left-wrapper">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="card-title mb-0">Detalle</h6>
                    <!-- <div class="dropdown">
                        <button class="btn btn-link p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="git-branch" class="icon-sm me-2"></i> <span class="">Update</span></a>
                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View all</span></a>
                        </div>
                    </div> -->
                </div>
                <p>{{$user['name']}}.</p>
                <div class="mt-3">
                    <label class="tx-11 fw-bolder mb-0 text-uppercase">USUARIO:</label>
                    <p class="text-muted">{{$user['username']}}</p>
                </div>
                <!-- <div class="mt-3">
          <label class="tx-11 fw-bolder mb-0 text-uppercase">Lives:</label>
          <p class="text-muted">New York, USA</p>
        </div> -->
                <div class="mt-3">
                    <label class="tx-11 fw-bolder mb-0 text-uppercase">CORREO ELECTRÓNICO:</label>
                    <p class="text-muted">{{$user['email']}}</p>
                </div>
                <!-- <div class="mt-3">
          <label class="tx-11 fw-bolder mb-0 text-uppercase">Website:</label>
          <p class="text-muted">www.nobleui.com</p>
        </div>
        <div class="mt-3 d-flex social-links">
          <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
            <i data-feather="github"></i>
          </a>
          <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
            <i data-feather="twitter"></i>
          </a>
          <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
            <i data-feather="instagram"></i>
          </a>
        </div> -->
            </div>
        </div>
    </div>
    <!-- left wrapper end -->
    <!-- middle wrapper start -->
    <div class="col-md-8 col-xl-8 middle-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="col-12 col-md-12 col-xl-12">
                    <div class="card border-secondary">
                        <div class="card-header bg-azul text-white d-flex justify-content-between align-items-center">
                            <h5 class="text-white mb-0"><i class="text-white icon-lg pb-3px" data-feather="list"></i> Roles Asignados</h5>
                            <button class="btn btn-primary btn-xs" id="btn_agregar_rol" data-bs-toggle="modal" data-bs-target="#modal_agregar_rol"><i class="btn-icon-prepend" data-feather="plus"></i> Agregar Rol</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="jambo_table table table-hover" id="tbl_roles_asignados" border="1">
                                    <thead class="bg-primary">
                                        <tr class="headings">
                                            <th scope="col" class="text-white">Id</th>
                                            <th scope="col" class="text-white">Nombre</th>
                                            <th scope="col" class="text-white">descripcion</th>
                                            <th scope="col" class="text-white">Estado</th>
                                            <th scope="col" class="text-white">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles_asignados as $row)
                                        <tr style="font-size: small;">
                                            <td scope="row">{{$row['id_user_rol']}}</td>
                                            <td scope="row">{{$row['nombre']}}</td>
                                            <td scope="row">{{$row['descripcion']}}</td>
                                            <td scope="row">{{$row['estado']}}</td>
                                            <td scope="row">
                                                @if($row['deleted_at'] != null)
                                                    <button type="button" class="btn btn-primary btn-icon btn-xs btn_asignar"
                                                        data-id="{{$row['id_user_rol']}}"
                                                        data-estado="{{$row['deleted_at']}}"
                                                        >
                                                        <i data-feather="check"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-danger btn-icon btn-xs btn_quitar"
                                                        data-id="{{$row['id_user_rol']}}"
                                                        data-estado="{{$row['deleted_at']}}"
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
    <!-- middle wrapper end -->
    <!-- right wrapper start -->
    <div class="d-none d-xl-block col-xl-2">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card rounded">
                    <div class="card-body">
                        <h6 class="card-title">ROLES ACTIVOS</h6>
                        <div id="roles_activos">
                        @foreach($roles_activos as $row)
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center hover-pointer">
                                    <!-- <img class="img-xs rounded-circle" src="{{ url('https://via.placeholder.com/37x37') }}" alt="" /> -->
                                    <div class="ms-2">
                                        <p>{{$row['nombre']}}</p>
                                        <p class="tx-11 text-muted">{{$row['descripcion']}}</p>
                                    </div>
                                </div>
                                <!-- <button class="btn btn-icon btn-link"><i data-feather="user-plus" class="text-muted"></i></button> -->
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- right wrapper end -->
</div>

<div class="modal fade bd-example modal_agregar_rol" id="modal_agregar_rol" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h6 class="modal-title h6 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="key"></i> Asignar Rol</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="jambo_table table table-hover" id="tbl_roles_no_asignados" border="1">
                                        <thead class="bg-primary">
                                            <tr class="headings">
                                                <th scope="col" class="text-white">Id</th>
                                                <th scope="col" class="text-white">Rol</th>
                                                <th scope="col" class="text-white">descripcion</th>
                                                <th scope="col" class="text-white">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($roles_no_asignados as $row)
                                            <tr style="font-size: small;">
                                                <td scope="row">{{$row['id_rol']}}</td>
                                                <td scope="row">{{$row['nombre']}}</td>
                                                <td scope="row">{{$row['descripcion']}}</td>
                                                <td scope="row">
                                                        <button type="button" class="btn btn-primary btn-icon btn-xs btn_registar_user_rol"
                                                            data-id="{{$row['id_rol']}}"
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
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=mzutkZDE"></script>
  <script type="text/javascript">
    var table = null; 
    var table2 = null; 
    var accion = null;
    var btn_activo = true;
    var id = null;
    var id_user = {{$user['id']}};
    var nombre = null;
    var descripcion = null;
    var estado = null;
    var url_guardar_perfil_rol = "{{url('/setic/usuarios/perfil/roles/guardar')}}"; 
    var rowNumber=null;
    var rowNumber2=null;
    var id_seleccionar = localStorage.getItem("tbl_roles_asignados_id_seleccionar");
    var id_seleccionar2 = localStorage.getItem("tbl_roles_no_asignados_id_seleccionar");
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        table = $('#tbl_roles_asignados').DataTable({
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
            $('#tbl_roles_asignados').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Buscar');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
                });

            $("#tbl_roles_asignados tbody").on( "click", "tr", function () { 
                rowNumber=parseInt(table.row( this ).index()); 
                accion=2; 
                table.$('tr.selected').removeClass('selected'); 
                $(this).addClass('selected'); 
                localStorage.setItem("tbl_roles_asignados_id_seleccionar",table.row( this ).data()[0]); 
            });

        table2 = $('#tbl_roles_no_asignados').DataTable({
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
            $('#tbl_roles_no_asignados').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Buscar');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
                });

            $("#tbl_roles_no_asignados tbody").on( "click", "tr", function () { 
                rowNumber2=parseInt(table2.row( this ).index()); 
                accion=2; 
                table2.$('tr.selected').removeClass('selected'); 
                $(this).addClass('selected'); 
                localStorage.setItem("tbl_roles_no_asignados_id_seleccionar",table2.row( this ).data()[0]); 
            });

    });

    $('#tbl_roles_asignados').on('click', '.btn_quitar', function () {
        accion = 1;
        id = $(this).data('id');
        estado = $(this).data('estado');
        guardar_perfil_roles()
        console.log('ID enviado:', estado, ' ',id);

    });

    $('#tbl_roles_asignados').on('click', '.btn_asignar', function () {
        accion = 1;
        id = $(this).data('id');
        estado = $(this).data('estado');
        guardar_perfil_roles()
        //console.log('ID enviado:', estado);

    });

    $('#tbl_roles_no_asignados').on('click', '.btn_registar_user_rol', function () {
        accion = 2;
        id = $(this).data('id');
        guardar_perfil_roles()
        console.log('ID enviado:', id_user,' ',id);

    }); 

    function guardar_perfil_roles() {
        espera('Tu información se esta guardando...');
        btn_activo = false;
        //console.log(hora_inicio);
        $.ajax({
            type: "post",
            url: url_guardar_perfil_rol,
            data: {
                accion : accion,
                id : id,
                id_user : id_user,
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
                    timer = 1000;
                    var row = data.roles_asignados_list;
                           var boton = null;
                            if(row.deleted_at == null){
                                     boton = `<button type="button" class="btn btn-danger btn-icon btn-xs btn_quitar" data-id="${row.id_user_rol}" data-estado="${row.deleted_at}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </button>`
                            }else{
                                boton = `<button type="button" class="btn btn-primary btn-icon btn-xs btn_asignar" data-id="${row.id_user_rol}" data-estado="${row.deleted_at}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                        </button>`
                            }
                            var nuevaFilaDT=[row.id_user_rol, row.nombre, row.descripcion, row.estado, boton]; 
                            if(accion == 1){
                            table.row(rowNumber).data(nuevaFilaDT);
                            }
                        if(accion == 2){
                            table.row.add(nuevaFilaDT).draw();
                            table2.row(rowNumber2).remove().draw();
                        }

                        $("#roles_activos").html('');
                        //console.log(roles_activos_list.length)
                        for(var i = 0; i < data.roles_activos_list.length; i++){
                            //console.log(i)
                            var roles_activos_list = data.roles_activos_list[i];
                            $("#roles_activos").append(`<div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center hover-pointer">
                                    <div class="ms-2">
                                        <p>${roles_activos_list.nombre}</p>
                                        <p class="tx-11 text-muted">${roles_activos_list.descripcion}</p>
                                    </div>
                                </div>
                            </div>`);
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
            icon: 'warning',
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