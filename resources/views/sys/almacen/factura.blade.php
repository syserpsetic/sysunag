@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
            <div class="alert alert-dark" role="alert">
                <h1 class="display-3 d-flex align-items-center">
                    <i data-feather="list" class="me-3" style="width: 60px; height: 60px;"></i>
                    <strong>FACTURAS</strong>
                </h1>
                <h4 class="lead bg-white"><div class="alert alert-fill-white" role="alert">Pantalla de administración de facturas.</div></h4>
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
                                <i class="text-white icon-lg pb-3px" data-feather="list"></i> Facturas
                            </h5>
                            <button class="btn btn-primary btn-xs" id="btn_agregar_rol" data-bs-toggle="modal" data-bs-target="#modal_agregar_rol">
                                <i class="btn-icon-prepend" data-feather="plus"></i> Agregar Factura
                            </butotn>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="jambo_table table table-hover" style="width:100%" id="tbl_usuarios" border="1">
                                    <thead class="bg-primary">
                                        <tr class="headings">
                                            <th scope="col" class="text-white">Número</th>
                                            <th scope="col" class="text-white">Usuario</th>
                                            <th scope="col" class="text-white">Fecha en Libro</th>      
                                            <th scope="col" class="text-white">Fecha Registro</th>  
                                            <th scope="col" class="text-white">Comedor</th>                                  
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

@endsection
@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush
@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=mzutkZDE"></script>
  <script type="text/javascript">
    var table = null; 
    var url_data_usuarios = "{{url('/almacen/factura/data')}}";
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        table = $('#tbl_usuarios').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: url_data_usuarios,
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
                    { data: 'n_factura' },
                    { data: 'usuario' },
                    /*{
                        data: 'foto',
                         render: function (data, type, row) {
                            return `<img
                                                                src="https://portal.unag.edu.hn/matricula/documentos/fotos/${data}"
                                                                class="img-xs rounded-circle"
                                                                alt="user"
                                                                onerror="this.onerror=null; this.src='{{ url(asset('/assets/images/user2-403d6e88.png')) }}';"
                                                            />`;
                            
                        }, 
                        orderable: false,
                        searchable: false,
                        width: "10%"
                    },
                    { data: 'tipousuario' },
                    //{ data: 'sancion' },
                    { data: 'actualizaciondatos' },*/
                    { data: 'fecha_libros' },
                    { data: 'created_at' },
                    { data: 'comedor' },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            if (row.requisicion) {
                            return `
                                <button class="btn btn-sm btn-primary me-1" onclick="editarUsuario('${row.username}')">
                                    <svg width="15" height="15" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="#fff" d="M8,2 C14,2 16,8 16,8 C16,8 14,14 8,14 C2,14 0,8 0,8 C0,8 2,2 8,2 Z M8,4 C5.76219,4 4.27954,5.08865 3.28644,6.28037 C2.78373,6.88363 2.42604,7.49505 2.1951,7.95693 L2.17372,8 L2.1951,8.04307 C2.42604,8.50495 2.78373,9.11637 3.28644,9.71963 C4.27954,10.9113 5.76219,12 8,12 C10.2378,12 11.7205,10.9113 12.7136,9.71963 C13.2163,9.11637 13.574,8.50495 13.8049,8.04307 L13.8263,8 L13.8049,7.95693 C13.574,7.49505 13.2163,6.88363 12.7136,6.28037 C11.7205,5.08865 10.2378,4 8,4 Z M8,5 C8.30747,5 8.60413,5.04625 8.88341,5.13218 C8.36251,5.36736 8,5.89135 8,6.5 C8,7.32843 8.67157,8 9.5,8 C10.1087,8 10.6326,7.63749 10.8678,7.11659 C10.9537,7.39587 11,7.69253 11,8 C11,9.65685 9.65685,11 8,11 C6.34315,11 5,9.65685 5,8 C5,6.34315 6.34315,5 8,5 Z"/>
                                    </svg> Ver
                                </button>
                                <button class="btn btn-sm btn-primary me-1" onclick="editarUsuario('${row.username}')">
                                    <svg fill="#fff" width="15" height="15" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M21,12a1,1,0,0,0-1,1v6a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V5A1,1,0,0,1,5,4h6a1,1,0,0,0,0-2H5A3,3,0,0,0,2,5V19a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V13A1,1,0,0,0,21,12ZM6,12.76V17a1,1,0,0,0,1,1h4.24a1,1,0,0,0,.71-.29l6.92-6.93h0L21.71,8a1,1,0,0,0,0-1.42L17.47,2.29a1,1,0,0,0-1.42,0L13.23,5.12h0L6.29,12.05A1,1,0,0,0,6,12.76ZM16.76,4.41l2.83,2.83L18.17,8.66,15.34,5.83ZM8,13.17l5.93-5.93,2.83,2.83L10.83,16H8Z"/></svg> Editar
                                </button>
                                <button title='Ya existe una requisición'  class="btn btn-sm btn-secondary me-1" >
                                    <svg fill="#fff" width="15" height="15" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 363.579 363.579" style="enable-background:new 0 0 363.579 363.579;" xml:space="preserve">
                                    <g>
                                    <path d="M360.082,175.411l-82.42-57.744c-1.413-0.99-2.725-1.514-4.249-1.514c-3.307,0-6.413,2.512-6.413,7.313v34.323H161.436
                                        c-4.963,0-9.436,4.167-9.436,9.13v29.75c0,4.963,4.474,9.12,9.436,9.12H267v34.341c0,4.801,3.108,7.659,6.415,7.659
                                        c0.001,0-0.119,0-0.119,0c1.524,0,3.018-0.696,4.43-1.687l82.384-57.826c2.213-1.55,3.467-3.922,3.468-6.432
                                        C363.579,179.335,362.296,176.962,360.082,175.411z"/>
                                    <path d="M297.943,261.789c-1.384,0-2.678,1.072-2.698,1.092l-20.005,14.014c-0.173,0.114-4.24,2.852-4.24,7.896
                                        c0,1.403,0,5.185,0,7H29v-219h242c0,0,0,4.938,0,6.75c0,4.085,3.98,6.981,4.154,7.105l21.664,15.178
                                        c0.032,0.021,0.795,0.521,1.674,0.521c1.145,0,2.508-0.769,2.508-4.429V65.841c0-12.926-10.126-23.052-23.052-23.052H24.052
                                        C10.79,42.79,0,53.131,0,65.841v230.896l0,0c0,13.036,11.012,24.049,24.048,24.052c0.001,0,0.002,0,0.004,0h0h253.896h0
                                        c0.002,0,0.003,0,0.005,0C290.662,320.787,301,309.998,301,296.738V267.79C301,262.83,299.338,261.789,297.943,261.789z
                                        M299.97,98.723c0.016-0.254,0.03-0.514,0.03-0.809C300,98.179,299.988,98.452,299.97,98.723z M299.92,99.24
                                        c0.008-0.066,0.018-0.125,0.025-0.194C299.938,99.112,299.928,99.175,299.92,99.24z M300,296.738
                                        C300,296.738,300,296.738,300,296.738L300,296.738L300,296.738z M299.989,267.147c0.007,0.216,0.011,0.432,0.011,0.643
                                        C300,267.565,299.995,267.355,299.989,267.147z M299.975,266.811c0.002,0.039,0.005,0.079,0.007,0.119
                                        C299.98,266.888,299.977,266.851,299.975,266.811z"/>
                                    </g>
                                    </svg> Requisición
                                </button>
                            `;}else {
                                return `
                                <button class="btn btn-sm btn-primary me-1" onclick="editarUsuario('${row.username}')">
                                    <svg width="15" height="15" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="#fff" d="M8,2 C14,2 16,8 16,8 C16,8 14,14 8,14 C2,14 0,8 0,8 C0,8 2,2 8,2 Z M8,4 C5.76219,4 4.27954,5.08865 3.28644,6.28037 C2.78373,6.88363 2.42604,7.49505 2.1951,7.95693 L2.17372,8 L2.1951,8.04307 C2.42604,8.50495 2.78373,9.11637 3.28644,9.71963 C4.27954,10.9113 5.76219,12 8,12 C10.2378,12 11.7205,10.9113 12.7136,9.71963 C13.2163,9.11637 13.574,8.50495 13.8049,8.04307 L13.8263,8 L13.8049,7.95693 C13.574,7.49505 13.2163,6.88363 12.7136,6.28037 C11.7205,5.08865 10.2378,4 8,4 Z M8,5 C8.30747,5 8.60413,5.04625 8.88341,5.13218 C8.36251,5.36736 8,5.89135 8,6.5 C8,7.32843 8.67157,8 9.5,8 C10.1087,8 10.6326,7.63749 10.8678,7.11659 C10.9537,7.39587 11,7.69253 11,8 C11,9.65685 9.65685,11 8,11 C6.34315,11 5,9.65685 5,8 C5,6.34315 6.34315,5 8,5 Z"/>
                                    </svg> Ver
                                </button>
                                <button class="btn btn-sm btn-primary me-1"  onclick="editarUsuario('${row.username}')">
                                    <svg fill="#fff" width="15" height="15" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M21,12a1,1,0,0,0-1,1v6a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V5A1,1,0,0,1,5,4h6a1,1,0,0,0,0-2H5A3,3,0,0,0,2,5V19a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V13A1,1,0,0,0,21,12ZM6,12.76V17a1,1,0,0,0,1,1h4.24a1,1,0,0,0,.71-.29l6.92-6.93h0L21.71,8a1,1,0,0,0,0-1.42L17.47,2.29a1,1,0,0,0-1.42,0L13.23,5.12h0L6.29,12.05A1,1,0,0,0,6,12.76ZM16.76,4.41l2.83,2.83L18.17,8.66,15.34,5.83ZM8,13.17l5.93-5.93,2.83,2.83L10.83,16H8Z"/></svg> Editar
                                </button>
                                <button title='Crear requisición' class="btn btn-sm btn-primary me-1" onclick="editarUsuario('${row.username}')">
                                    <svg fill="#fff" width="15" height="15" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 363.579 363.579" style="enable-background:new 0 0 363.579 363.579;" xml:space="preserve">
                                    <g>
                                    <path d="M360.082,175.411l-82.42-57.744c-1.413-0.99-2.725-1.514-4.249-1.514c-3.307,0-6.413,2.512-6.413,7.313v34.323H161.436
                                        c-4.963,0-9.436,4.167-9.436,9.13v29.75c0,4.963,4.474,9.12,9.436,9.12H267v34.341c0,4.801,3.108,7.659,6.415,7.659
                                        c0.001,0-0.119,0-0.119,0c1.524,0,3.018-0.696,4.43-1.687l82.384-57.826c2.213-1.55,3.467-3.922,3.468-6.432
                                        C363.579,179.335,362.296,176.962,360.082,175.411z"/>
                                    <path d="M297.943,261.789c-1.384,0-2.678,1.072-2.698,1.092l-20.005,14.014c-0.173,0.114-4.24,2.852-4.24,7.896
                                        c0,1.403,0,5.185,0,7H29v-219h242c0,0,0,4.938,0,6.75c0,4.085,3.98,6.981,4.154,7.105l21.664,15.178
                                        c0.032,0.021,0.795,0.521,1.674,0.521c1.145,0,2.508-0.769,2.508-4.429V65.841c0-12.926-10.126-23.052-23.052-23.052H24.052
                                        C10.79,42.79,0,53.131,0,65.841v230.896l0,0c0,13.036,11.012,24.049,24.048,24.052c0.001,0,0.002,0,0.004,0h0h253.896h0
                                        c0.002,0,0.003,0,0.005,0C290.662,320.787,301,309.998,301,296.738V267.79C301,262.83,299.338,261.789,297.943,261.789z
                                        M299.97,98.723c0.016-0.254,0.03-0.514,0.03-0.809C300,98.179,299.988,98.452,299.97,98.723z M299.92,99.24
                                        c0.008-0.066,0.018-0.125,0.025-0.194C299.938,99.112,299.928,99.175,299.92,99.24z M300,296.738
                                        C300,296.738,300,296.738,300,296.738L300,296.738L300,296.738z M299.989,267.147c0.007,0.216,0.011,0.432,0.011,0.643
                                        C300,267.565,299.995,267.355,299.989,267.147z M299.975,266.811c0.002,0.039,0.005,0.079,0.007,0.119
                                        C299.98,266.888,299.977,266.851,299.975,266.811z"/>
                                    </g>
                                    </svg> Requisición
                                </button>
                            `;
                            }
                            
                        }
                    }
                ]
            });


            $('#tbl_usuarios').each(function() {
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

    function editarUsuario(username){
        //alert(username)
        window.location.href = "{{url('/setic/usuarios/perfil/')}}/"+username;
    }

  </script>
@endpush