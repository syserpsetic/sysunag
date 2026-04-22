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
                        <i data-feather="users" class="me-3" style="width: 60px; height: 60px;"></i>
                        <strong>ESTUDIANTES ENROLADOS</strong>
                    </h1>
                    <h4 class="lead bg-white">
                        <div class="alert alert-fill-white" role="alert">
                            Estudiantes registrados mediante solicitud al proceso de gradución: <br>
                            <b>{{ $proceso['nombre_proceso'] ?? 'PROCESO NO ENCONTRADO' }}</b>.
                            <br><br>
                            <span class="fs-6 text-muted">
                                <i data-feather="calendar" class="icon-xs me-1"></i>
                                Vigencia del Proceso: 
                                <strong>{{ $proceso['fecha_inicio_proceso'] ?? '--' }}</strong> al 
                                <strong>{{ $proceso['fecha_final_proceso'] ?? '--' }}</strong> 
                            </span>
                        </div>
                    </h4>
                    <br>
                    <div class="col-md-12 d-flex gap-2">
                        <a class="btn btn-info btn-sm" id="btn_volver" href="{{ url('secretariageneral/procesoGraduacion') }}" data-toggle="tooltip" data-placement="top" title="Regresar">
                            <i class="btn-icon-prepend" data-feather="corner-up-left"></i> Regresar
                        </a>
                        @if(in_array('secretaria_general_graduar_estudiantes', $scopes ?? []))
                        <button type="button" class="btn btn-success btn-sm font-weight-bold" id="btn_ejecutar_graduacion_masiva" data-identificador_proceso="{{ $proceso['id'] ?? '' }}">
                             Graduar Estudiantes
                        </button>
                        @endif
                    </div>
                </div>
                <hr />
                <div class="col-12 col-md-12 col-xl-12">
                    <div class="card border-secondary">
                        <div class="card-header bg-azul text-white d-flex justify-content-between align-items-center">
                            <h5 class="text-white mb-0">
                                <i class="text-white icon-lg pb-3px" data-feather="list"></i> Estudiantes
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="jambo_table table table-hover" id="tbl_estudiantes_enrolados" border="1">
                                    <thead class="bg-primary">
                                        <tr class="headings">
                                            <th scope="col" class="text-white">No.Registro</th>
                                            <th scope="col" class="text-white">Identidad</th>
                                            <th scope="col" class="text-white">Nombre Completo</th>
                                            <th scope="col" class="text-white">Carrera</th>
                                            <th scope="col" class="text-white">Sexo</th>
                                            <th scope="col" class="text-white">Fecha Solicitud</th>
                                            <th scope="col" class="text-white text-center">Expediente</th>
                                            <th scope="col" class="text-white text-center">Estado</th>
                                            <th scope="col" class="text-white">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($estudiantes_enrolados) && count($estudiantes_enrolados) > 0)
                                            @foreach ($estudiantes_enrolados as $estudiante_individual)
                                            <tr style="font-size: small;">
                                                <td scope="row" class="align-middle fw-bold">{{ $estudiante_individual['numero_registro_asignado'] ?? ($estudiante_individual->numero_registro_asignado ?? '') }}</td>
                                                <td scope="row" class="align-middle">{{ $estudiante_individual['identidad_estudiante'] ?? ($estudiante_individual->identidad_estudiante ?? '') }}</td>
                                                <td scope="row" class="align-middle">{{ $estudiante_individual['nombre_completo'] ?? ($estudiante_individual->nombre_completo ?? '') }}</td>
                                                
                                                {{-- Columna Carrera en una sola línea y sin negritas --}}
                                                <td scope="row" class="align-middle text-nowrap">
                                                    {{ $estudiante_individual['id_carrera'] ?? ($estudiante_individual->id_carrera ?? '') }} - {{ $estudiante_individual['nombre_carrera'] ?? ($estudiante_individual->nombre_carrera ?? '') }}
                                                </td>
                                                
                                                <td scope="row" class="align-middle">
                                                    @php $sexo_evaluado = trim($estudiante_individual['sexo_estudiante'] ?? ($estudiante_individual->sexo_estudiante ?? '')); @endphp
                                                    @if($sexo_evaluado == 'F') FEMENINO @elseif($sexo_evaluado == 'M') MASCULINO @else {{ $sexo_evaluado }} @endif
                                                </td>
                                                <td scope="row" class="align-middle">{{ $estudiante_individual['fecha_solicitud'] ?? ($estudiante_individual->fecha_solicitud ?? '') }}</td>
                                                
                                                <td scope="row" class="align-middle text-center">
                                                    @php
                                                        $validados = $estudiante_individual['docs_validados'] ?? ($estudiante_individual->docs_validados ?? 0);
                                                        $requeridos = $estudiante_individual['docs_requeridos'] ?? ($estudiante_individual->docs_requeridos ?? 0);
                                                        $es_completo = ($requeridos > 0 && $validados == $requeridos);
                                                        $faltantes = $requeridos - $validados;
                                                    @endphp
                                                    
                                                    <span>{{ $validados }} / {{ $requeridos }}</span>
                                                    <br>
                                                    @if($es_completo)
                                                        <span class="badge bg-success text-white mt-1">
                                                            <i data-feather="check-circle" class="text-white" style="width: 12px; height: 12px; margin-right: 2px;"></i> Completo
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning text-dark mt-1">
                                                            <i data-feather="clock" class="text-dark" style="width: 12px; height: 12px; margin-right: 2px;"></i> Faltan {{ $faltantes }}
                                                        </span>
                                                    @endif
                                                </td>

                                                <td scope="row" class="align-middle text-center">
                                                    <span class="badge {{ $estudiante_individual['color_estado'] ?? ($estudiante_individual->color_estado ?? 'bg-secondary') }}">
                                                        {{ $estudiante_individual['estado_texto'] ?? ($estudiante_individual->estado_texto ?? '') }}
                                                    </span>
                                                </td>

                                                <td scope="row" class="align-middle">
                                                    @if(in_array('secretaria_general_leer_proceso_graduacion_estudiantes_perfil', $scopes ?? []))
                                                        <a href="{{ url('secretariageneral/estudiantes/perfil') }}/{{ $estudiante_individual['numero_registro_asignado'] ?? ($estudiante_individual->numero_registro_asignado ?? '') }}" 
                                                        class="btn btn-info btn-xs text-dark fw-bold d-inline-flex align-items-center" 
                                                        title="Verificar Documentación">
                                                            <i data-feather="check-square" style="width: 14px; height: 14px; margin-right: 4px;"></i> Verificar Documentación
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
    var tabla_estudiantes_enrolados = null; 
    var indice_fila_seleccionada = null;

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        tabla_estudiantes_enrolados = $('#tbl_estudiantes_enrolados').DataTable({
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

        $('#tbl_estudiantes_enrolados').each(function() {
            var datatable = $(this);
            var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
            search_input.attr('placeholder', 'Buscar');
            search_input.removeClass('form-control-sm');
            var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
            length_sel.removeClass('form-control-sm');
        });

        $("#tbl_estudiantes_enrolados tbody").on("click", "tr", function () { 
            indice_fila_seleccionada = parseInt(tabla_estudiantes_enrolados.row(this).index()); 
            tabla_estudiantes_enrolados.$('tr.selected').removeClass('selected'); 
            $(this).addClass('selected'); 
        });

        $('#btn_ejecutar_graduacion_masiva').on('click', function() {
            var identificador_proceso_actual = $(this).data('identificador_proceso');

            if(!identificador_proceso_actual) {
                Swal.fire('Error', 'No se pudo identificar el proceso de graduación actual.', 'error');
                return;
            }

            Swal.fire({
                title: '¿Confirmar Graduación Masiva?',
                html: "Se procesarán todos los expedientes y se enviarán <b>únicamente</b> los estudiantes con todos sus documentos validados. <br><br><b>¡Esta acción no se puede deshacer!</b>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Ejecutar Graduación',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    espera('Evaluando expedientes y transfiriendo estudiantes aprobados al servidor remoto...');

                    $.ajax({
                        url: "{{ url('/secretariageneral/proceso/graduacion/masiva/ejecutar') }}",
                        type: 'POST',
                        data: {
                            id_proceso_graduacion: identificador_proceso_actual
                        },
                        success: function(respuesta_servidor) {
                            Swal.close();
                            
                            console.log("Respuesta de la API:", respuesta_servidor);

                            if(respuesta_servidor && respuesta_servidor.estatus) {
                                Swal.fire({
                                    title: '¡Operación Exitosa!',
                                    text: respuesta_servidor.msgSuccess,
                                    icon: 'success',
                                    confirmButtonText: 'Entendido'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                var mensaje_falla = (respuesta_servidor && respuesta_servidor.msgError) 
                                                    ? respuesta_servidor.msgError 
                                                    : 'Ocurrió un error en el servidor interno (posible fallo de Base de Datos). Presiona F12 y revisa la Consola.';
                                
                                Swal.fire('Atención', mensaje_falla, 'error');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            Swal.close();
                            console.error("Error AJAX Fatal:", textStatus, errorThrown);
                            console.error("Detalle de respuesta del Backend:", jqXHR.responseText);
                            
                            Swal.fire('Error Crítico (500)', 'El servidor Backend explotó. Presiona F12, ve a la pestaña "Network" (Red) y lee el mensaje de error para saber qué falló.', 'error');
                        }
                    });
                }
            });
        });

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