@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="row">
        <div class="col-12 col-md-12 col-xl-12">
            <div class="card">
                <div class="card-body">

                    {{-- ENCABEZADO --}}
                    <div class="alert alert-dark" role="alert">
                        <h1 class="display-3 d-flex align-items-center">
                            <i data-feather="book-open" class="me-3" style="width: 60px; height: 60px;"></i>
                            <strong>CARGA ACADÉMICA</strong>
                        </h1>
                        <h4 class="lead bg-white">
                            <div class="alert alert-fill-white" role="alert">
                                Pantalla de administración de asignaturas, módulos, PPS y SSC.
                                <hr class="my-2">
                                <div class="d-flex align-items-center">
                                    <i data-feather="user" class="me-2" style="width: 20px; height: 20px;"></i>
                                    <span class="fw-bold">Docente:</span>&nbsp;
                                    {{ !empty($cargaAsignaturas) ? $cargaAsignaturas[0]['docente'] : (!empty($cargaModulos) ? $cargaModulos[0]['docente'] : 'Sin asignar') }}
                                </div>
                            </div>
                        </h4>
                    </div>

                    <hr />

                    {{-- TABS NAV --}}
                    <ul class="nav nav-tabs" id="tabsCargaAcademica" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active d-flex align-items-center gap-2" id="tab-asignaturas"
                                data-bs-toggle="tab" data-bs-target="#panel-asignaturas"
                                type="button" role="tab">
                                <i data-feather="list" style="width:16px;height:16px;"></i>
                                Asignaturas
                                <span class="badge bg-primary ms-1">{{ count($cargaAsignaturas ?? []) }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center gap-2" id="tab-modulos"
                                data-bs-toggle="tab" data-bs-target="#panel-modulos"
                                type="button" role="tab">
                                <i data-feather="grid" style="width:16px;height:16px;"></i>
                                Módulos
                                <span class="badge bg-primary ms-1">{{ count($cargaModulos ?? []) }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center gap-2" id="tab-pps"
                                data-bs-toggle="tab" data-bs-target="#panel-pps"
                                type="button" role="tab">
                                <i data-feather="clipboard" style="width:16px;height:16px;"></i>
                                PPS
                                <span class="badge bg-primary ms-1">{{ count($cargaPps ?? []) }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center gap-2" id="tab-ssc"
                                data-bs-toggle="tab" data-bs-target="#panel-ssc"
                                type="button" role="tab">
                                <i data-feather="briefcase" style="width:16px;height:16px;"></i>
                                SSC
                                <span class="badge bg-primary ms-1">{{ count($cargaSsc ?? []) }}</span>
                            </button>
                        </li>
                    </ul>

                    {{-- TABS CONTENT --}}
                    <div class="tab-content pt-3" id="tabsCargaAcademicaContent">

                        {{-- PANEL ASIGNATURAS --}}
                        <div class="tab-pane fade show active" id="panel-asignaturas" role="tabpanel">
                            <div class="card border-secondary">
                                <div class="card-header bg-azul text-white d-flex justify-content-between align-items-center">
                                    <h5 class="text-white mb-0">
                                        <i class="text-white icon-lg pb-3px" data-feather="list"></i> Asignaturas
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="jambo_table table table-hover" id="tbl_asignaturas" border="1">
                                            <thead class="bg-primary">
                                                <tr class="headings">
                                                    <th scope="col" class="text-white">#</th>
                                                    <th scope="col" class="text-white">Carrera</th>
                                                    <th scope="col" class="text-white">Código de Asignatura</th>
                                                    <th scope="col" class="text-white">Asignatura</th>
                                                    <th scope="col" class="text-white">Sede</th>
                                                    <th scope="col" class="text-white">PA</th>
                                                    <th scope="col" class="text-white">Sección</th>
                                                    <th scope="col" class="text-white">Matriculados</th>
                                                    <th scope="col" class="text-white">Aprobados</th>
                                                    <th scope="col" class="text-white">Reprobados</th>
                                                    <th scope="col" class="text-white">Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cargaAsignaturas ?? [] as $row)
                                                    <tr style="font-size: small;">
                                                        <td>{{ $row['fila'] }}</td>
                                                        <td>{{ $row['id_carrera'] }}</td>
                                                        <td>{{ $row['id_asignatura_referencia'] }}</td>
                                                        <td>{{ $row['asignatura'] }}</td>
                                                        <td>{{ $row['sede'] }}</td>
                                                        <td>{{ $row['periodo_academico_bloque'] }}</td>
                                                        <td>{{ $row['etiqueta_bloque'] }}</td>
                                                        <td>{{ $row['total_matriculados'] }}</td>
                                                        <td class="text-success fw-bold">{{ $row['aprobados'] }}</td>
                                                        <td class="text-danger fw-bold">{{ $row['reprobados'] }}</td>
                                                        <td>
                                                            <a type="button" class="btn btn-info btn-icon btn-xs"
                                                                href="{{ url('docentes/'.$row['id_usuario'].'/secciones/'.$row['id_seccion'].'/calificaciones/asignaturas') }}"
                                                                title="Ver matriculados">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                            <a type="button" class="btn btn-warning btn-icon btn-xs"
                                                                href="{{ url('modalidad/docentes/'.$row['id_usuario'].'/secciones/'.$row['id_seccion'].'/configuracion') }}"
                                                                title="Configuración">
                                                                <i data-feather="settings"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PANEL MÓDULOS --}}
                        <div class="tab-pane fade" id="panel-modulos" role="tabpanel">
                            <div class="card border-secondary">
                                <div class="card-header bg-azul text-white d-flex justify-content-between align-items-center">
                                    <h5 class="text-white mb-0">
                                        <i class="text-white icon-lg pb-3px" data-feather="grid"></i> Módulos
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="jambo_table table table-hover" id="tbl_modulos" border="1">
                                            <thead class="bg-primary">
                                                <tr class="headings">
                                                    <th scope="col" class="text-white">#</th>
                                                    <th scope="col" class="text-white">Carrera</th>
                                                    <th scope="col" class="text-white">Código de Laboratorio</th>
                                                    <th scope="col" class="text-white">Laboratorio</th>
                                                    <th scope="col" class="text-white">Código de Módulo</th>
                                                    <th scope="col" class="text-white">Módulo</th>
                                                    <th scope="col" class="text-white">Sede</th>
                                                    <th scope="col" class="text-white">PA</th>
                                                    <th scope="col" class="text-white">Rotación</th>
                                                    <th scope="col" class="text-white">Matriculados</th>
                                                    <th scope="col" class="text-white">Aprobados</th>
                                                    <th scope="col" class="text-white">Reprobados</th>
                                                    <th scope="col" class="text-white">Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cargaModulos ?? [] as $row)
                                                    <tr style="font-size: small;">
                                                        <td>{{ $row['fila'] }}</td>
                                                        <td>{{ $row['id_carrera'] }}</td>
                                                        <td>{{ $row['id_laboratorio'] }}</td>
                                                        <td>{{ $row['laboratorio'] }}</td>
                                                        <td>{{ $row['id_modulo'] }}</td>
                                                        <td>{{ $row['modulo'] }}</td>
                                                        <td>{{ $row['sede'] }}</td>
                                                        <td>{{ $row['periodo_academico_bloque'] }}</td>
                                                        <td>{{ $row['etiqueta_bloque'] }}</td>
                                                        <td>{{ $row['total_matriculados'] }}</td>
                                                        <td class="text-success fw-bold">{{ $row['aprobados'] }}</td>
                                                        <td class="text-danger fw-bold">{{ $row['reprobados'] }}</td>
                                                        <td>
                                                            <a type="button" class="btn btn-info btn-icon btn-xs"
                                                                href="{{ url('modalidad/docentes/'.$row['id_usuario'].'/modulos/'.$row['id_bloque_modulo'].'/calificaciones/asignaturas') }}"
                                                                title="Ver matriculados">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                            <a type="button" class="btn btn-warning btn-icon btn-xs"
                                                                href="{{ url('modalidad/docentes/'.$row['id_usuario'].'/modulos/'.$row['id_bloque_modulo'].'/configuracion') }}"
                                                                title="Configuración">
                                                                <i data-feather="settings"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PANEL PPS --}}
                        <div class="tab-pane fade" id="panel-pps" role="tabpanel">
                            <div class="card border-secondary">
                                <div class="card-header bg-azul text-white d-flex justify-content-between align-items-center">
                                    <h5 class="text-white mb-0">
                                        <i class="text-white icon-lg pb-3px" data-feather="clipboard"></i> PPS
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="jambo_table table table-hover" id="tbl_pps" border="1">
                                            <thead class="bg-primary">
                                                <tr class="headings">
                                                    <th scope="col" class="text-white">Estudiante Registro</th>
                                                    <th scope="col" class="text-white">Estudiante Nombre</th>
                                                    <th scope="col" class="text-white">Tipo Asesor</th>
                                                    <th scope="col" class="text-white">Tipo Trabajo</th>
                                                    <th scope="col" class="text-white">
                                                        @if($fechaSeguimientoAnteproyecto)
                                                            Seguimiento Anteproyecto
                                                        @endif
                                                    </th>
                                                    <th scope="col" class="text-white">Nota</th>
                                                    <th scope="col" class="text-white">Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cargaPps ?? [] as $row)
                                                    <tr style="font-size: small;">
                                                        <td>{{ $row['numero_registro_asignado'] }}</td>
                                                        <td>{{ $row['nombre'] }}</td>
                                                        <td>{{ $row['tipo_asesor'] }}</td>
                                                        <td>{{ $row['tipo_trabajo'] }}</td>

                                                        {{-- Columna Seguimiento Anteproyecto --}}
                                                        <td>
                                                            @if($fechaSeguimientoAnteproyecto && $row['nuevo_formato'] == 'NO')
                                                                @if($row['url_seguimiento'])
                                                                    @if($row['tipo_asesor'] == 'Principal')
                                                                        @if($row['tipo_trabajo'] == 'Anteproyecto')
                                                                            <a target="_blank" href="{{ url('documentos/pps/'.$row['url_seguimiento']) }}" class="btn btn-info btn-xs">
                                                                                <i data-feather="eye" style="width:14px;height:14px;"></i> Ver Evidencia
                                                                            </a>
                                                                        @endif
                                                                    @else
                                                                        @if($row['tipo_trabajo'] == 'Anteproyecto')
                                                                            <span class="badge bg-success">Seguimiento Validado</span>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    @if($row['tipo_asesor'] == 'Principal')
                                                                        @if($row['tipo_trabajo'] == 'Anteproyecto')
                                                                            <a href="{{ url('docentes/seguimiento/'.$row['id']) }}" class="btn btn-warning btn-xs">
                                                                                <i data-feather="upload" style="width:14px;height:14px;"></i> Subir Evidencia
                                                                            </a>
                                                                        @endif
                                                                    @else
                                                                        @if($row['tipo_trabajo'] == 'Anteproyecto')
                                                                            <span class="badge bg-secondary">Seguimiento No Validado</span>
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        </td>

                                                        {{-- Columna Nota --}}
                                                        <td>
                                                            @if($row['nuevo_formato'] == 'SI')
                                                                <a href="{{ url('docentesRRNN/'.$row['tipo_asesor'].'/'.$row['tipo_trabajo'].'/'.$row['numero_registro_asignado'].'/'.$row['id']) }}"
                                                                    class="btn btn-primary btn-xs">
                                                                    <i data-feather="edit-2" style="width:14px;height:14px;"></i> Ingresar Nota
                                                                </a>
                                                            @else
                                                                <a href="{{ url('docentes/'.$row['tipo_asesor'].'/'.$row['tipo_trabajo'].'/'.$row['numero_registro_asignado'].'/'.$row['id']) }}"
                                                                    class="btn btn-primary btn-xs">
                                                                    <i data-feather="edit-2" style="width:14px;height:14px;"></i> Ingresar Nota
                                                                </a>
                                                            @endif
                                                        </td>

                                                        {{-- Columna Observaciones --}}
                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-info btn-icon btn-xs"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modal_observaciones_pps"
                                                                data-id="{{ $row['id'] }}"
                                                                title="Ver observaciones">
                                                                <i data-feather="message-circle"></i>
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

                        {{-- PANEL SSC --}}
                        <div class="tab-pane fade" id="panel-ssc" role="tabpanel">
                            <div class="card border-secondary">
                                <div class="card-header bg-azul text-white d-flex justify-content-between align-items-center">
                                    <h5 class="text-white mb-0">
                                        <i class="text-white icon-lg pb-3px" data-feather="briefcase"></i> SSC
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="jambo_table table table-hover" id="tbl_ssc" border="1">
                                            <thead class="bg-primary">
                                                <tr class="headings">
                                                    <th scope="col" class="text-white">Id</th>
                                                    <th scope="col" class="text-white">Nombre</th>
                                                    <th scope="col" class="text-white">Facultad</th>
                                                    <th scope="col" class="text-white">Fecha Inicio</th>
                                                    <th scope="col" class="text-white">Fecha Fin</th>
                                                    <th scope="col" class="text-white">Entidad Beneficiada</th>
                                                    <th scope="col" class="text-white">Tipo Trabajo</th>
                                                    <th scope="col" class="text-white">Estado Actual</th>
                                                    <th scope="col" class="text-white">Opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cargaSsc ?? [] as $row)
                                                    <tr style="font-size: small;">
                                                        <td>{{ $row['id'] }}</td>
                                                        <td>{{ $row['nombre'] }}</td>
                                                        <td>{{ $row['facultad'] }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($row['fecha_inicio_servicio'])->format('d/m/Y') }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($row['fecha_fin_servicio'])->format('d/m/Y') }}</td>
                                                        <td>{{ $row['nombre_entidad_beneficiada'] }}</td>
                                                        <td>{{ $row['tipo_trabajo'] }}</td>
                                                        <td>
                                                            @php
                                                                $estado = strtolower($row['estado'] ?? '');
                                                                $badgeClass = match($estado) {
                                                                    'aprobado' => 'bg-success',
                                                                    'cerrado'  => 'bg-secondary',
                                                                    'pendiente'=> 'bg-warning',
                                                                    'rechazado'=> 'bg-danger',
                                                                    default    => 'bg-secondary',
                                                                };
                                                            @endphp
                                                            <span class="badge {{ $badgeClass }}">{{ ucfirst($row['estado'] ?? 'Sin estado') }}</span>
                                                            @if(!empty($row['informe_estado']))
                                                                <br><small class="text-danger fw-bold">{{ $row['informe_estado'] }}</small>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{-- Detalle Horas y Subir Informe (solo aprobado o cerrado) --}}
                                                            @if($row['estado'] == 'aprobado' || $row['estado'] == 'cerrado')
                                                                <a type="button" class="btn btn-warning btn-icon btn-xs"
                                                                    href="{{ url('ssc/proyectos/detalleHoras/'.$row['id']) }}"
                                                                    title="Detalle Horas">
                                                                    <i data-feather="clock"></i>
                                                                </a>
                                                                <a type="button" class="btn btn-info btn-icon btn-xs"
                                                                    href="{{ url('ssc/proyectos/informes/'.$row['id']) }}"
                                                                    title="Subir Informe">
                                                                    <i data-feather="upload"></i>
                                                                </a>
                                                            @endif

                                                            {{-- Cerrar Proyecto (solo aprobado y puede_cerrar_proyecto) --}}
                                                            @if($row['estado'] == 'aprobado' && $row['puede_cerrar_proyecto'] == true)
                                                                <button type="button"
                                                                    class="btn btn-danger btn-icon btn-xs"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modal_cerrar_ssc"
                                                                    data-id="{{ $row['id'] }}"
                                                                    title="Cerrar Proyecto">
                                                                    <i data-feather="lock"></i>
                                                                </button>
                                                            @endif

                                                            {{-- Detalle (siempre visible) --}}
                                                            <button type="button"
                                                                class="btn btn-primary btn-icon btn-xs"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modal_detalle_ssc"
                                                                data-id="{{ $row['id'] }}"
                                                                data-nombre="{{ $row['nombre'] }}"
                                                                data-descripcion="{{ $row['descripcion'] }}"
                                                                data-facultad="{{ $row['facultad'] }}"
                                                                data-pais="{{ $row['pais'] }}"
                                                                data-departamento="{{ $row['departamento'] }}"
                                                                data-municipio="{{ $row['municipio'] }}"
                                                                data-comunidad="{{ $row['comunidad_ejecucion'] }}"
                                                                data-fecha_inicio="{{ $row['fecha_inicio_servicio'] }}"
                                                                data-fecha_fin="{{ $row['fecha_fin_servicio'] }}"
                                                                data-entidad="{{ $row['nombre_entidad_beneficiada'] }}"
                                                                data-tipo_trabajo="{{ $row['tipo_trabajo'] }}"
                                                                data-horas="{{ $row['horas_maximas'] }}"
                                                                data-estado="{{ $row['estado'] }}"
                                                                title="Ver Detalle">
                                                                <i data-feather="eye"></i>
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

                    </div>{{-- fin tab-content --}}

                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- MODALES                                                       --}}
    {{-- ============================================================ --}}

    {{-- MODAL OBSERVACIONES PPS --}}
    <div class="modal fade" id="modal_observaciones_pps" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white">
                        <i data-feather="message-circle" class="icon-lg pb-3px"></i> Observaciones Del Estado De La PPS
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            1. El coordinador realizó el registro de la PPS, cambió estado a "Registrado" (1/7).
                            <i id="regla_1" data-feather="minus" style="color:#0066ff; width:20px;height:20px;"></i>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            2. La coordinación aprobó el registro de la PPS, cambió estado a "Aprobado" (2/7).
                            <i id="regla_2" data-feather="minus" style="color:#0066ff; width:20px;height:20px;"></i>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            3. El estudiante agendó la fecha cuando se presentará a la defensa (3/7).
                            <i id="regla_3" data-feather="minus" style="color:#0066ff; width:20px;height:20px;"></i>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            4. Los asesores realizaron las evaluaciones de la PPS (4/7).
                            <i id="regla_4" data-feather="minus" style="color:#0066ff; width:20px;height:20px;"></i>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            5. El asesor principal subió el informe y la presentación (5/7).
                            <i id="regla_5" data-feather="minus" style="color:#0066ff; width:20px;height:20px;"></i>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            6. El asesor principal validó y promedió la nota, en caso de anteproyecto también subió la evidencia de seguimiento (6/7).
                            <i id="regla_6" data-feather="minus" style="color:#0066ff; width:20px;height:20px;"></i>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            7. La SETIC migró la nota al respectivo historial del estudiante (7/7).
                            <i id="regla_7" data-feather="minus" style="color:#0066ff; width:20px;height:20px;"></i>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer bg-secondary">
                    <button type="button" class="btn btn-danger btn-xs" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DETALLE SSC --}}
    <div class="modal fade" id="modal_detalle_ssc" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h6 class="modal-title text-white">
                        <i data-feather="briefcase" class="icon-lg pb-3px"></i> Detalle SSC
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="card-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Nombre</label>
                                    <input type="text" readonly class="form-control" id="ssc_det_nombre">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Descripción</label>
                                    <input type="text" readonly class="form-control" id="ssc_det_descripcion">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Facultad</label>
                                    <input type="text" readonly class="form-control" id="ssc_det_facultad">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tipo de Trabajo</label>
                                    <input type="text" readonly class="form-control" id="ssc_det_tipo_trabajo">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">País</label>
                                    <input type="text" readonly class="form-control" id="ssc_det_pais">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Departamento</label>
                                    <input type="text" readonly class="form-control" id="ssc_det_departamento">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Municipio</label>
                                    <input type="text" readonly class="form-control" id="ssc_det_municipio">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Comunidad</label>
                                    <input type="text" readonly class="form-control" id="ssc_det_comunidad">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Fecha Inicio</label>
                                    <input type="text" readonly class="form-control" id="ssc_det_fecha_inicio">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Fecha Fin</label>
                                    <input type="text" readonly class="form-control" id="ssc_det_fecha_fin">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Entidad Beneficiada</label>
                                    <input type="text" readonly class="form-control" id="ssc_det_entidad">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Horas Máximas</label>
                                    <input type="text" readonly class="form-control" id="ssc_det_horas">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Estado Actual</label>
                                    <input type="text" readonly class="form-control" id="ssc_det_estado">
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

    {{-- MODAL CERRAR PROYECTO SSC --}}
    <div class="modal fade" id="modal_cerrar_ssc" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">
                        <i data-feather="lock" class="icon-lg pb-3px"></i> Cerrar Proyecto
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 text-center mb-3">
                            <i data-feather="alert-circle" class="text-warning" style="width:70px;height:70px;"></i>
                            <h5 class="mt-3"><strong>¿Realmente deseas cerrar este proyecto?</strong></h5>
                            <p class="fw-normal text-muted">Este proceso no se puede revertir</p>
                        </div>
                    </div>
                    <form id="form_cerrar_ssc" method="POST" action="{{ url('ssc/proyectos/estados') }}">
                        @csrf
                        <input type="hidden" id="ssc_cerrar_id" name="id_solicitud">
                        <input type="hidden" name="bandera" value="4">
                        <div class="mb-3">
                            <label class="form-label">Observación <small class="text-muted">(opcional)</small></label>
                            <input type="text" class="form-control" name="observacion" placeholder="Texto opcional...">
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-secondary">
                    <button type="button" class="btn btn-danger btn-xs" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" form="form_cerrar_ssc" class="btn btn-primary btn-xs">Cerrar Proyecto</button>
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

        var dtLangConfig = {
            processing: "Procesando...",
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ registros",
            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            infoPostFix: "",
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
        };

        var url_pps_observaciones = "{{ url('asignaturas/pps/observaciones') }}";

        function initDataTable(id) {
            var table = $(id).DataTable({
                "aLengthMenu": [
                    [10, 30, 50, 100, -1],
                    [10, 30, 50, 100, "Todo"]
                ],
                "iDisplayLength": 10,
                language: dtLangConfig
            });
            $(id).each(function() {
                var datatable = $(this);
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Buscar');
                search_input.removeClass('form-control-sm');
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
            });
            return table;
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            initDataTable('#tbl_asignaturas');

            var modulosIniciado = false;
            var ppsIniciado     = false;
            var sscIniciado     = false;

            document.getElementById('tab-modulos').addEventListener('shown.bs.tab', function() {
                if (!modulosIniciado) { initDataTable('#tbl_modulos'); modulosIniciado = true; }
            });
            document.getElementById('tab-pps').addEventListener('shown.bs.tab', function() {
                if (!ppsIniciado) { initDataTable('#tbl_pps'); ppsIniciado = true; }
            });
            document.getElementById('tab-ssc').addEventListener('shown.bs.tab', function() {
                if (!sscIniciado) { initDataTable('#tbl_ssc'); sscIniciado = true; }
            });

            // Modal Observaciones PPS
            $('#modal_observaciones_pps').on('show.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id');
                // Reset iconos
                for (var i = 1; i <= 7; i++) {
                    $('#regla_' + i).attr('data-feather', 'minus').css({'color': '#0066ff'});
                }
                feather.replace();
                $.ajax({
                    type: 'post',
                    url: url_pps_observaciones,
                    data: { id: id },
                    success: function(data) {
                        if (data.pps_observaciones && data.pps_observaciones.length > 0) {
                            var row = data.pps_observaciones[0];
                            // Reglas 1, 2, 3 siempre en check si hay datos
                            ['regla_1','regla_2','regla_3'].forEach(function(r) {
                                $('#' + r).attr('data-feather', 'check-circle').css({'color': 'green'});
                            });
                            // Reglas 4-7 condicionales
                            ['regla_4','regla_5','regla_6','regla_7'].forEach(function(r) {
                                if (row[r] == '1') {
                                    $('#' + r).attr('data-feather', 'check-circle').css({'color': 'green'});
                                } else {
                                    $('#' + r).attr('data-feather', 'minus').css({'color': '#0066ff'});
                                }
                            });
                            feather.replace();
                        }
                    },
                    error: function(xhr) { alert(xhr.responseText); }
                });
            });

            // Modal Detalle SSC
            $('#modal_detalle_ssc').on('show.bs.modal', function(e) {
                var t = $(e.relatedTarget);
                $('#ssc_det_nombre').val(t.data('nombre'));
                $('#ssc_det_descripcion').val(t.data('descripcion'));
                $('#ssc_det_facultad').val(t.data('facultad'));
                $('#ssc_det_tipo_trabajo').val(t.data('tipo_trabajo'));
                $('#ssc_det_pais').val(t.data('pais'));
                $('#ssc_det_departamento').val(t.data('departamento'));
                $('#ssc_det_municipio').val(t.data('municipio'));
                $('#ssc_det_comunidad').val(t.data('comunidad'));
                $('#ssc_det_fecha_inicio').val(t.data('fecha_inicio'));
                $('#ssc_det_fecha_fin').val(t.data('fecha_fin'));
                $('#ssc_det_entidad').val(t.data('entidad'));
                $('#ssc_det_horas').val(t.data('horas'));
                $('#ssc_det_estado').val(t.data('estado'));
            });

            // Modal Cerrar SSC
            $('#modal_cerrar_ssc').on('show.bs.modal', function(e) {
                $('#ssc_cerrar_id').val($(e.relatedTarget).data('id'));
            });

        });
    </script>
@endpush