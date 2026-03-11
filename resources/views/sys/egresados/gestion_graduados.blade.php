@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
            <div class="alert alert-dark" role="alert">
                <h1 class="display-3 d-flex align-items-center">
                    <i data-feather="bookmark" class="me-3" style="width: 60px; height: 60px;"></i>
                    <strong>GESTIÓN DE GRADUADOS</strong>
                </h1>
                <h4 class="lead bg-white"><div class="alert alert-fill-white" role="alert">Pantalla de administración de graduados.</div></h4>
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
                        <h5 class="card-header bg-azul text-white"><i class="text-white icon-lg pb-3px" data-feather="users"></i> Graduados</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="jambo_table table table-hover" style="width:100%" id="tbl_graduados" border="1">
                                    <thead class="bg-primary">
                                        <tr class="headings">
                                            <th scope="col" class="text-white">Foto</th>
                                            <th scope="col" class="text-white">Numero Registro</th>
                                            <th scope="col" class="text-white">Nombre</th>
                                            <th scope="col" class="text-white">Grado Academico</th>
                                            <th scope="col" class="text-white">Carrera</th>
                                            <!-- <th scope="col" class="text-white">Sanción</th> -->
                                            <th scope="col" class="text-white">Mes/Años Graduación</th>
                                            <th scope="col" class="text-white">Contraseña Modificada</th>
                                            <th scope="col" class="text-white">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
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

<div class="modal fade modal_restablecer_contrasena" id="modal_restablecer_contrasena" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title h4" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="key"></i> Restablecer Contraseña</h5>
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
                                        <h4><label class="form-label"><strong>¿Realmente desea restablecer la contraseña de este usuario?</strong></label></h4>
                                        <br>
                                        <h5><label class="form-label" id="modal_restablecer_contrasena_informacion"></label></h5>
                                        <br><br>
                                        <p class="fw-normal">Este proceso no se puede revertir.</p>
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
                <button type="button" class="btn btn-primary btn-sm" id="btn_restablecer_contrasena">Restablecer</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
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
    var url_data_graduados = "{{url('/egresados/gestion_graduados/data')}}";
    var url_restabelecer_contrasena = "{{url('/egresados/gestion_graduados/restablecer_contrasena')}}";
    var btn_activo = true;
    var id_user = null;
    var var_nombre_completo = null;
    var var_numero_registro_asignado = null;
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        table = $('#tbl_graduados').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: url_data_graduados,
                    type: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}'
                    }
                },
                aLengthMenu: [
                    [10, 30, 50, 100, -1],
                    [10, 30, 50, 100, "Todo"]
                ],
                iDisplayLength: 10,
                language: {
                    processing: "Procesando...",
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                    infoFiltered: "(filtrado de un total de _MAX_ registros)",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron resultados",
                    emptyTable: "Ningún dato disponible en esta tabla",
                    paginate: {
                        first: "Primero",
                        previous: "Anterior",
                        next: "Siguiente",
                        last: "Último"
                    },
                    aria: {
                        sortAscending: ": Activar para ordenar la columna de manera ascendente",
                        sortDescending: ": Activar para ordenar la columna de manera descendente"
                    }
                },
                columns: [
                    {
                        data: 'numero_registro_asignado',
                        render: function (data, type, row) {
                            return `<img
                                    src="https://portal.unag.edu.hn/matricula/documentos/fotos/${data}.jpg"
                                    class="img-xs rounded-circle"
                                    alt="user"
                                    style="width:40px;height:40px;object-fit:cover;"
                                    onerror="this.onerror=null; this.src='{{ url(asset('/assets/images/user2-403d6e88.png')) }}';"
                                />`;
                            
                        },
                        orderable: false,
                        searchable: false,
                        width: "10%"
                    },
                    { data: 'numero_registro_asignado' },
                    { data: 'nombre_completo' },
                    { data: 'grado_academico_obtenido' },
                    { data: 'nombre_carrera' },
                    { data: 'mes_anio_graduacion' },
                    {
                            data: 'forzar_cambio_contrasenia',
                            render: function(data){
                                if(data){
                                    return `<span class="badge bg-danger text-white">Pendiente</span>`;
                                }else{
                                    return `<span class="badge bg-success text-white">Modificada</span>`;
                                }
                            }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return `
                                <button class="btn btn-sm btn-warning me-1" onclick="modalRestablecer('${row.id}','${row.numero_registro_asignado}', '${row.nombre_completo}')"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-key text-dark"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg> Restablecer Contraseña</button>
                            `;
                        }
                    }
                ]
            });


            $('#tbl_graduados').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Buscar');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
                });

        $("#btn_restablecer_contrasena").on("click", function () {
            if(btn_activo){
                restabelerContrasena();
            }
            
        })

    });

    function modalRestablecer(id, numero_registro_asignado, nombre_completo){
        //alert(username)
        id_user = id;
        var_nombre_completo = nombre_completo;
        var_numero_registro_asignado = numero_registro_asignado;
        $("#modal_restablecer_contrasena").modal("show");
        $("#modal_restablecer_contrasena_informacion").html(`<img
                                    src="https://portal.unag.edu.hn/matricula/documentos/fotos/${numero_registro_asignado}.jpg"
                                    class="img-xs rounded-circle"
                                    alt="user"
                                    style="width:100px;height:100px;object-fit:cover;"
                                    onerror="this.onerror=null; this.src='{{ url(asset('/assets/images/user2-403d6e88.png')) }}';"
                                /><br><br><small class="fw-normal"><b>${nombre_completo}</b></small>`);
    }

    function restabelerContrasena(){
        espera('Restableciedo contraseña...');
        btn_activo = false;
        //console.log(hora_inicio);
        $.ajax({
            type: "post",
            url: url_restabelecer_contrasena,
            data: {
                id : id_user,
  
            },
            success: function (data) {
                if (data.msgError != null) {
                    titleMsg = "Error al Guardar";
                    textMsg = data.msgError;
                    typeMsg = "error";
                    timer = null;
                    btn_activo = true;
                } else {
                    titleMsg = "Contraseña Restablecida Exitosamente";
                    textMsg = `
                        <div style="display:flex; gap:10px; align-items:center;">
                            <input id="password_generada" class="form-control" 
                                value="${data.contrasena}" disabled style="margin:0; flex:1;">
                                
                            
                        </div>

                        <p style="font-size:12px; margin-top:10px;">
                            <b></b>Haga clic en <b>Copiar Contraseña</b> para guardar la contraseña. 
                            Al presionar <b>Aceptar</b> esta ventana se cerrará.
                        </p>
                    `;
                    $("#modal_restablecer_contrasena").modal("hide");
                    typeMsg = "success";
                    timer = null;
                    btn_activo = true;
                }
                //console.log(textMsg);
                ToastLG({
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

    const ToastLG = (options) => {
        Swal.fire({
            showConfirmButton: (typeMsg == 'error') ? false : true,
            showCancelButton: (typeMsg == 'success') ? false : true,
            showDenyButton: true,
            denyButtonColor: '#203b76',
            confirmButtonText: 'Aceptar',
            denyButtonText: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy text-white"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg> <font class="text-white">Copiar Contraseña</font>',
            cancelButtonText: 'Cancelar',
            timerProgressBar: true,
            allowOutsideClick: false,
            preDeny: () => {

            const input = document.getElementById('password_generada');

            if (!input) {
                Swal.showValidationMessage('No se encontró la contraseña');
                return false;
            }

            var mensaje = `Estimado graduado se ha restablecido la contraseña de su cuenta exitosamente.
Puede ingresar con las siguientes credenciales:
    ->Nombre: ${var_nombre_completo} 
    ->Usuario: ${var_numero_registro_asignado}  
    ->Contraseña: ${input.value}
    ->Sitio Web: https://sys.unag.edu.hn/login_graduados`;

            navigator.clipboard.writeText(mensaje);

            Swal.update({
                footer: '<span class="badge bg-success"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check text-white"><polyline points="20 6 9 17 4 12"></polyline></svg> <font class="text-white">Contraseña copiada al portapapeles</font></span>'
            });

            return false; 
        },

        ...options
        }).then((result) => {

            if (result.isConfirmed) {
                espera('Recargando...');
                location.reload(); 
            }
            else if (result.isDismissed) {
                console.log('El usuario canceló'); 
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

  </script>
@endpush