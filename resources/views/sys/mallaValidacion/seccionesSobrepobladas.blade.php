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
                <h1 class="display-1 d-flex align-items-center">
                    <i data-feather="book" class="me-3" style="width: 90px; height: 90px;"></i>
                    <strong>SECCIONES</strong>
                </h1>
                <h4 class="lead bg-white"><div class="alert alert-fill-white" role="alert">Secciones que sobrepasan el límtie permitido de 45 estudiantes.</div></h4>
                <br>
                <div class="col-md-3">
                        <a class="btn btn-info btn-sm" id="btn_volver_convenio" href="{{url('setic/malla_validacion')}}" data-toggle="tooltip" data-placement="top" title="Regresar a Malla de Validaciones">
                        <i class="btn-icon-prepend" data-feather="corner-up-left"></i> Regresar
                        </a>
                    </div>
            </div>
                <hr />
                <div class="col-12 col-md-12 col-xl-12">
                    <div class="card border-secondary">
                        <h5 class="card-header bg-azul text-white"><i class="text-white icon-lg pb-3px" data-feather="list"></i> Secciones</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="jambo_table table table-hover" id="tbl_malla_validaciones_estudiantes" border="1">
                                    <thead class="bg-primary">
                                        <tr class="headings">
                                            <th scope="col" class="text-white">Matriculados</th>
                                            <th scope="col" class="text-white">Asignatura</th>
                                            <th scope="col" class="text-white">Carrera</th>
                                            <th scope="col" class="text-white">Etiqueta Bloque</th>
                                            <th scope="col" class="text-white">Jornada</th>
                                            <th scope="col" class="text-white">Sede</th>
                                            <th scope="col" class="text-white">Docente</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($estudiantes as $row)
                                        <tr style="font-size: small;">
                                            <td scope="row">{{$row['matriculados']}}</td>
                                            <td scope="row">{{$row['id_asignatura']}} {{$row['asignatura']}}</td>
                                            <td scope="row">{{$row['id_carrera']}}</td>
                                            <td scope="row">{{$row['etiqueta_bloque']}}</td>
                                            <td scope="row">{{$row['jornada']}}</td>
                                            <td scope="row">{{$row['sede']}}</td>
                                            <td scope="row">{{$row['nombre_completo_docente']}}</td>
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
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        table = $('#tbl_malla_validaciones_estudiantes').DataTable({
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
            $('#tbl_malla_validaciones_estudiantes').each(function() {
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