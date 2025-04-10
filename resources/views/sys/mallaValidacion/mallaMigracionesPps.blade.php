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
                    <i data-feather="upload" class="me-3" style="width: 90px; height: 90px;"></i>
                    <strong>MIGRACIONES PPS</strong>
                </h1>
                <h4 class="lead bg-white"><div class="alert alert-fill-white" role="alert">Estudiantes que no tienen migrada la nota PPS.</div></h4>
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
                        <h5 class="card-header bg-azul text-white"><i class="text-white icon-lg pb-3px" data-feather="users"></i> Estudiantes</h5>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="display responsive table-hover" style="width:100%" id="tbl_malla_validaciones_estudiantes" border="1">
                                    <thead  class="bg-primary">
                                        <tr class="headings" style="font-size: small;">
                                            <th scope="col" class="text-white">Id</th>
                                            <th scope="col" class="text-white">Tipo de Trabajo</th>
                                            <th scope="col" class="text-white">Numero Registro Asignado</th>
                                            <th scope="col" class="text-white">Nombre Completo por Apellido</th>
                                            <th scope="col" class="text-white">Los asesores realizaron las evaluaciones de la PPS</th>
                                            <th scope="col" class="text-white">El asesor principal subió el informe y la presentación</th>
                                            <th scope="col" class="text-white">El asesor principal validó y promedió la nota, en caso de anteproyecto también subió la evidencia de seguimiento</th>
                                            <th scope="col" class="text-white">La SETIC migró la nota al respectivo historial del estudiante</th>
                                            <th scope="col" class="text-white">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($estudiantes as $row)
                                        <tr style="font-size: small;">
                                            <td scope="row">{{$row['id']}}</td>
                                            <td scope="row">{{$row['tipo_trabajo']}}</td>
                                            <td scope="row">{{$row['numero_registro_asignado']}}</td>
                                            <td scope="row">{{$row['nombre_completo_por_apellido']}}</td>
                                            <td scope="row">
                                                @if($row['regla_4'] == 1)
                                                    <span class="badge bg-success"><i data-feather="check-circle" class="icon-lg pb-3px text-white"></i></span>
                                                @else
                                                    <span class="badge bg-danger"><i data-feather="x" class="icon-lg pb-3px text-white"></i></span>
                                                @endif
                                            </td>
                                            <td scope="row">
                                                @if($row['regla_5'] == 1)
                                                    <span class="badge bg-success"><i data-feather="check-circle" class="icon-lg pb-3px text-white"></i></span>
                                                @else
                                                    <span class="badge bg-danger"><i data-feather="x" class="icon-lg pb-3px text-white"></i></span>
                                                @endif
                                            </td>
                                            <td scope="row">
                                                @if($row['regla_6'] == 1)
                                                    <span class="badge bg-success"><i data-feather="check-circle" class="icon-lg pb-3px text-white"></i></span>
                                                @else
                                                    <span class="badge bg-danger"><i data-feather="x" class="icon-lg pb-3px text-white"></i></span>
                                                @endif
                                            </td>
                                            <td scope="row">
                                                @if($row['regla_7'] == 1)
                                                    <span class="badge bg-success"><i data-feather="check-circle" class="icon-lg pb-3px text-white"></i></span>
                                                @else
                                                    <span class="badge bg-danger"><i data-feather="x" class="icon-lg pb-3px text-white"></i></span>
                                                @endif
                                            </td>
                                            <td scope="row">
                                                @if($row['regla_4'] == 1 && $row['regla_5'] == 1 && $row['regla_6'] == 1)
                                                    <button type="button" class="btn btn-primary btn-xs" 
                                                    data-toggle="modal"
                                                    data-target="#modal_alertafffff"
                                                    data-toggle="tooltip" 
                                                    data-placement="top" 
                                                    data-nombre_completo_por_apellido="{{$row['nombre_completo_por_apellido']}}"
                                                    data-numero_registro_asignado="{{$row['numero_registro_asignado']}}"
                                                    title="Migrar nota de PPS al historial">
                                                    <i data-feather="check-circle" class="btn-icon-prepend"></i> Migrar Nota
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
                responsive: true,
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