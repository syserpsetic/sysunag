@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet" />
    <style>
        .stat-card { border-left: 4px solid var(--azul); transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-label { font-size: 11px; text-transform: uppercase; letter-spacing: .5px; color: #6c757d; font-weight: 600; }
        .stat-value { font-size: 26px; font-weight: 700; color: var(--azul); }
        .stat-card.verde { border-left-color: var(--verde); }
        .stat-card.verde .stat-value { color: var(--verdeOscuro); }
        .stat-card.rojo { border-left-color: #dc3545; }
        .stat-card.rojo .stat-value { color: #dc3545; }
        .stat-card.amarillo { border-left-color: var(--amarillo); }
        .stat-card.amarillo .stat-value { color: #b38600; }
        .btn-seguimiento { min-width: 195px; justify-content: center; }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12 col-md-12 col-xl-12">
            <div class="card">
                <div class="card-body">

                    {{-- ENCABEZADO --}}
                    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3"
                         style="background:var(--verdeOscuro);border-radius:6px;position:relative;">
                        <div>
                            <h5 class="mb-0 d-flex align-items-center gap-2" style="color:#fff!important;">
                                <i data-feather="book-open" style="width:22px;height:22px;"></i>
                                Carga Académica
                            </h5>
                            <small style="color:rgba(255,255,255,0.8);">
                                <i data-feather="user" style="width:13px;height:13px;"></i>
                                {{ !empty($cargaAsignaturas) ? $cargaAsignaturas[0]['docente'] : (!empty($cargaModulos) ? $cargaModulos[0]['docente'] : 'Sin asignar') }}
                            </small>
                        </div>
                        <img src="{{ url(asset('/assets/images/UNAG_BLANCO.png')) }}"
                             class="d-none d-md-block"
                             style="position:absolute;right:20px;top:50%;transform:translateY(-50%);height:55px;opacity:0.9;">
                    </div>

                    {{-- FLASH SSC --}}
                    @if(session('ssc_success'))
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                            <i data-feather="check-circle" style="width:18px;height:18px;"></i>
                            {{ session('ssc_success') }}
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('ssc_error'))
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                            <i data-feather="alert-circle" style="width:18px;height:18px;"></i>
                            {{ session('ssc_error') }}
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

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
                                    @php
                                        $aTotal       = count($cargaAsignaturas ?? []);
                                        $aMatriculados= array_sum(array_column($cargaAsignaturas ?? [], 'total_matriculados'));
                                        $aAprobados   = array_sum(array_column($cargaAsignaturas ?? [], 'aprobados'));
                                        $aReprobados  = array_sum(array_column($cargaAsignaturas ?? [], 'reprobados'));
                                    @endphp
                                    <div class="row g-3 mb-3">
                                        <div class="col-6 col-md-3">
                                            <div class="card stat-card h-100">
                                                <div class="card-body text-center">
                                                    <div class="stat-label"><i data-feather="list" style="width:13px;height:13px;"></i> Secciones</div>
                                                    <div class="stat-value">{{ $aTotal }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="card stat-card h-100">
                                                <div class="card-body text-center">
                                                    <div class="stat-label"><i data-feather="users" style="width:13px;height:13px;"></i> Matriculados</div>
                                                    <div class="stat-value">{{ $aMatriculados }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="card stat-card verde h-100">
                                                <div class="card-body text-center">
                                                    <div class="stat-label"><i data-feather="arrow-up" style="width:13px;height:13px;"></i> Aprobados</div>
                                                    <div class="stat-value">{{ $aAprobados }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="card stat-card rojo h-100">
                                                <div class="card-body text-center">
                                                    <div class="stat-label"><i data-feather="arrow-down" style="width:13px;height:13px;"></i> Reprobados</div>
                                                    <div class="stat-value">{{ $aReprobados }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                                            <a type="button" class="btn bg-azul btn-xs d-inline-flex align-items-center gap-1"
                                                                href="{{ url('docentes/'.$row['id_usuario'].'/secciones/'.$row['id_seccion'].'/calificaciones/asignaturas') }}">
                                                                <i data-feather="eye" style="width:13px;height:13px;"></i> Ver
                                                            </a>
                                                            <a type="button" class="btn btn-warning btn-xs d-inline-flex align-items-center gap-1"
                                                                href="{{ url('docentes/'.$row['id_usuario'].'/secciones/'.$row['id_seccion'].'/configuracion') }}">
                                                                <i data-feather="settings" style="width:13px;height:13px;"></i> Configurar
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
                                    @php
                                        $mTotal       = count($cargaModulos ?? []);
                                        $mMatriculados= array_sum(array_column($cargaModulos ?? [], 'total_matriculados'));
                                        $mAprobados   = array_sum(array_column($cargaModulos ?? [], 'aprobados'));
                                        $mReprobados  = array_sum(array_column($cargaModulos ?? [], 'reprobados'));
                                    @endphp
                                    <div class="row g-3 mb-3">
                                        <div class="col-6 col-md-3">
                                            <div class="card stat-card h-100">
                                                <div class="card-body text-center">
                                                    <div class="stat-label"><i data-feather="grid" style="width:13px;height:13px;"></i> Módulos</div>
                                                    <div class="stat-value">{{ $mTotal }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="card stat-card h-100">
                                                <div class="card-body text-center">
                                                    <div class="stat-label"><i data-feather="users" style="width:13px;height:13px;"></i> Matriculados</div>
                                                    <div class="stat-value">{{ $mMatriculados }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="card stat-card verde h-100">
                                                <div class="card-body text-center">
                                                    <div class="stat-label"><i data-feather="arrow-up" style="width:13px;height:13px;"></i> Aprobados</div>
                                                    <div class="stat-value">{{ $mAprobados }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="card stat-card rojo h-100">
                                                <div class="card-body text-center">
                                                    <div class="stat-label"><i data-feather="arrow-down" style="width:13px;height:13px;"></i> Reprobados</div>
                                                    <div class="stat-value">{{ $mReprobados }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                                            <a type="button" class="btn bg-azul btn-xs d-inline-flex align-items-center gap-1"
                                                                href="{{ url('modalidad/docentes/'.$row['id_usuario'].'/modulos/'.$row['id_bloque_modulo'].'/calificaciones/asignaturas') }}">
                                                                <i data-feather="eye" style="width:13px;height:13px;"></i> Ver
                                                            </a>
                                                            <a type="button" class="btn btn-warning btn-xs d-inline-flex align-items-center gap-1"
                                                                href="{{ url('modalidad/docentes/'.$row['id_usuario'].'/modulos/'.$row['id_bloque_modulo'].'/configuracion') }}">
                                                                <i data-feather="settings" style="width:13px;height:13px;"></i> Configurar
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
                                    @php
                                        $pTotal      = count($cargaPps ?? []);
                                        $pPrincipal  = count(array_filter($cargaPps ?? [], fn($r) => $r['tipo_asesor'] === 'Principal'));
                                        $pSecundario = $pTotal - $pPrincipal;
                                        $pTipos      = array_count_values(array_column($cargaPps ?? [], 'tipo_trabajo'));
                                    @endphp
                                    <div class="row g-3 mb-3">
                                        <div class="col-6 col-md-3">
                                            <div class="card stat-card h-100">
                                                <div class="card-body text-center">
                                                    <div class="stat-label"><i data-feather="clipboard" style="width:13px;height:13px;"></i> Total Estudiantes</div>
                                                    <div class="stat-value">{{ $pTotal }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="card stat-card verde h-100">
                                                <div class="card-body text-center">
                                                    <div class="stat-label"><i data-feather="star" style="width:13px;height:13px;"></i> Como Principal</div>
                                                    <div class="stat-value">{{ $pPrincipal }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="card stat-card amarillo h-100">
                                                <div class="card-body text-center">
                                                    <div class="stat-label"><i data-feather="user" style="width:13px;height:13px;"></i> Como Secundario</div>
                                                    <div class="stat-value">{{ $pSecundario }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="card stat-card h-100">
                                                <div class="card-body text-center">
                                                    <div class="stat-label"><i data-feather="file-text" style="width:13px;height:13px;"></i> Tipos de Trabajo</div>
                                                    <div class="mt-1">
                                                        @foreach($pTipos as $tipo => $cant)
                                                            <span class="badge bg-azul mb-1" style="color:#fff!important;font-size:11px;">{{ $tipo }}: {{ $cant }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                                                            <a target="_blank" href="{{ url('docentes/pps/'.$row['id'].'/evidencia') }}"
                                                                                class="btn btn-xs btn-info d-inline-flex align-items-center gap-1 btn-seguimiento">
                                                                                <i data-feather="eye" style="width:13px;height:13px;"></i> Ver Evidencia
                                                                            </a>
                                                                        @endif
                                                                    @else
                                                                        @if($row['tipo_trabajo'] == 'Anteproyecto')
                                                                            <span class="btn btn-xs d-inline-flex align-items-center gap-1 btn-seguimiento" style="background:#198754;color:#fff!important;cursor:default;">
                                                                                <i data-feather="check-circle" style="width:13px;height:13px;"></i> Seguimiento Validado
                                                                            </span>
                                                                        @endif
                                                                    @endif
                                                                @else
                                                                    @if($row['tipo_asesor'] == 'Principal')
                                                                        @if($row['tipo_trabajo'] == 'Anteproyecto')
                                                                            <button type="button"
                                                                                class="btn btn-xs btn-evidencia-pps d-inline-flex align-items-center gap-1 btn-seguimiento"
                                                                                data-bs-toggle="modal" data-bs-target="#modal_subir_evidencia_pps"
                                                                                data-id="{{ $row['id'] }}"
                                                                                data-estudiante="{{ $row['nombre'] }}"
                                                                                data-registro="{{ $row['numero_registro_asignado'] }}"
                                                                                data-tesis="{{ $row['nombre_tesis'] ?? '' }}"
                                                                                style="background:var(--amarillo);color:var(--azul);border:none;font-weight:600;">
                                                                                <i data-feather="upload" style="width:13px;height:13px;"></i> Subir Evidencia
                                                                            </button>
                                                                        @endif
                                                                    @else
                                                                        @if($row['tipo_trabajo'] == 'Anteproyecto')
                                                                            <span class="btn btn-xs d-inline-flex align-items-center gap-1 btn-seguimiento" style="background:var(--azul);color:#fff!important;cursor:default;">
                                                                                <i data-feather="alert-circle" style="width:13px;height:13px;"></i> Seguimiento No Validado
                                                                            </span>
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        </td>

                                                        {{-- Columna Nota --}}
                                                        <td>
                                                            <a href="{{ url('docentes/pps/'.$row['tipo_asesor'].'/'.$row['tipo_trabajo'].'/'.$row['numero_registro_asignado'].'/'.$row['id'].'/evaluacion') }}"
                                                                class="btn btn-primary btn-xs">
                                                                <i data-feather="edit-2" style="width:14px;height:14px;"></i> Ingresar Nota
                                                            </a>
                                                        </td>

                                                        {{-- Columna Observaciones --}}
                                                        <td>
                                                            <button type="button"
                                                                class="btn btn-info btn-xs d-inline-flex align-items-center gap-1"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modal_observaciones_pps"
                                                                data-id="{{ $row['id'] }}">
                                                                <i data-feather="message-circle" style="width:13px;height:13px;"></i> Observaciones
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
                                    @php
                                        $sTotal     = count($cargaSsc ?? []);
                                        $sAprobados = count(array_filter($cargaSsc ?? [], fn($r) => strtolower($r['estado'] ?? '') === 'aprobado'));
                                        $sCerrados  = count(array_filter($cargaSsc ?? [], fn($r) => strtolower($r['estado'] ?? '') === 'cerrado'));
                                        $sPendientes= count(array_filter($cargaSsc ?? [], fn($r) => strtolower($r['estado'] ?? '') === 'pendiente'));
                                    @endphp
                                    <div class="row g-3 mb-3">
                                        <div class="col-6 col-md-3">
                                            <div class="card stat-card h-100">
                                                <div class="card-body text-center">
                                                    <div class="stat-label"><i data-feather="briefcase" style="width:13px;height:13px;"></i> Total Proyectos</div>
                                                    <div class="stat-value">{{ $sTotal }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="card stat-card verde h-100">
                                                <div class="card-body text-center">
                                                    <div class="stat-label"><i data-feather="check-circle" style="width:13px;height:13px;"></i> Aprobados</div>
                                                    <div class="stat-value">{{ $sAprobados }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="card stat-card rojo h-100">
                                                <div class="card-body text-center">
                                                    <div class="stat-label"><i data-feather="lock" style="width:13px;height:13px;"></i> Cerrados</div>
                                                    <div class="stat-value">{{ $sCerrados }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="card stat-card amarillo h-100">
                                                <div class="card-body text-center">
                                                    <div class="stat-label"><i data-feather="clock" style="width:13px;height:13px;"></i> Pendientes</div>
                                                    <div class="stat-value">{{ $sPendientes }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                                                <a type="button" class="btn btn-warning btn-xs d-inline-flex align-items-center gap-1"
                                                                    href="{{ url('ssc/proyectos/detalleHoras/'.$row['id']) }}">
                                                                    <i data-feather="clock" style="width:13px;height:13px;"></i> Horas
                                                                </a>
                                                                <a type="button" class="btn bg-azul btn-xs d-inline-flex align-items-center gap-1"
                                                                    href="{{ url('ssc/proyectos/informes/'.$row['id']) }}">
                                                                    <i data-feather="upload" style="width:13px;height:13px;"></i> Informes
                                                                </a>
                                                            @endif

                                                            {{-- Cerrar Proyecto (solo aprobado y puede_cerrar_proyecto) --}}
                                                            @if($row['estado'] == 'aprobado' && $row['puede_cerrar_proyecto'] == true)
                                                                <button type="button"
                                                                    class="btn btn-danger btn-xs d-inline-flex align-items-center gap-1"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modal_cerrar_ssc"
                                                                    data-id="{{ $row['id'] }}">
                                                                    <i data-feather="lock" style="width:13px;height:13px;"></i> Cerrar
                                                                </button>
                                                            @endif

                                                            {{-- Detalle (siempre visible) --}}
                                                            <button type="button"
                                                                class="btn btn-primary btn-xs d-inline-flex align-items-center gap-1"
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
                                                                data-estado="{{ $row['estado'] }}">
                                                                <i data-feather="eye" style="width:13px;height:13px;"></i> Detalle
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

    {{-- MODAL SUBIR EVIDENCIA PPS --}}
    <div class="modal fade" id="modal_subir_evidencia_pps" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-azul" style="border:none;">
                    <h5 class="modal-title text-white fw-bold d-flex align-items-center gap-2">
                        <i data-feather="upload" style="width:18px;height:18px;stroke:#fff;"></i>
                        Subir Evidencia de Seguimiento
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    {{-- Info del estudiante --}}
                    <div class="row g-2 mb-4">
                        <div class="col-md-8">
                            <div class="card stat-card" style="border-left:4px solid var(--azul);">
                                <div class="card-body py-2 px-3">
                                    <div style="font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:#6c757d;font-weight:600;">Estudiante</div>
                                    <div id="pps_evidencia_estudiante" style="font-size:15px;font-weight:700;color:var(--azul);"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card stat-card" style="border-left:4px solid var(--amarillo);">
                                <div class="card-body py-2 px-3">
                                    <div style="font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:#6c757d;font-weight:600;">N° Registro</div>
                                    <div id="pps_evidencia_registro" style="font-size:15px;font-weight:700;color:var(--azul);"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" id="pps_evidencia_tesis_wrap">
                            <div class="card stat-card" style="border-left:4px solid var(--verde);">
                                <div class="card-body py-2 px-3">
                                    <div style="font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:#6c757d;font-weight:600;">Anteproyecto</div>
                                    <div id="pps_evidencia_tesis" style="font-size:13px;font-weight:600;color:var(--azul);"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Área de upload --}}
                    <div id="pps_upload_area"
                        style="border:2px dashed var(--azul);border-radius:10px;background:var(--verdeClaro);
                               padding:32px;text-align:center;cursor:pointer;transition:background .2s;"
                        onclick="document.getElementById('pps_file_input').click()">
                        <i data-feather="file-text" style="width:40px;height:40px;stroke:var(--azul);margin-bottom:10px;"></i>
                        <p style="font-size:14px;color:var(--azul);font-weight:600;margin:0;">Haz clic para seleccionar un PDF</p>
                        <p style="font-size:12px;color:#6c757d;margin:4px 0 0;">Solo archivos .pdf — máx. 10 MB</p>
                    </div>
                    <input type="file" id="pps_file_input" accept=".pdf" style="display:none;">

                    {{-- Archivo seleccionado --}}
                    <div id="pps_preview_wrap" style="display:none;margin-top:16px;">
                        <div class="card" style="border:1px solid var(--verde);border-radius:8px;background:#f0faf2;">
                            <div class="card-body py-3 px-4 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <i data-feather="file-text" style="width:32px;height:32px;stroke:var(--azul);flex-shrink:0;"></i>
                                    <div>
                                        <div id="pps_file_nombre" style="font-size:14px;font-weight:700;color:var(--azul);"></div>
                                        <div style="font-size:11px;color:#6c757d;">Archivo listo para guardar</div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-danger" id="pps_btn_quitar" style="font-size:11px;">
                                    <i data-feather="trash-2" style="width:12px;height:12px;"></i> Quitar
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Spinner upload --}}
                    <div id="pps_uploading" style="display:none;text-align:center;padding:20px;">
                        <div class="spinner-border text-primary" style="width:2rem;height:2rem;"></div>
                        <p style="margin-top:10px;font-size:13px;color:var(--azul);">Subiendo archivo...</p>
                    </div>

                    <input type="hidden" id="pps_filename_guardado">
                    <input type="hidden" id="pps_id_reserva">
                </div>
                <div class="modal-footer" style="border:none;">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-sm fw-bold" id="pps_btn_guardar"
                        style="background:var(--verde);color:#fff;display:none;">
                        <i data-feather="save" style="width:14px;height:14px;stroke:#fff;"></i> Guardar Evidencia
                    </button>
                </div>
            </div>
        </div>
    </div>

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
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
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

        // Prioridades responsive por tabla:
        // 1 = nunca se oculta, números altos = primeros en ocultarse
        var responsivePriorities = {
            '#tbl_asignaturas': [
                { responsivePriority: 1,     targets: 3  }, // Asignatura
                { responsivePriority: 1,     targets: -1 }, // Opciones
                { responsivePriority: 2,     targets: 5  }, // PA
                { responsivePriority: 3,     targets: 6  }, // Sección
                { responsivePriority: 4,     targets: 7  }, // Matriculados
                { responsivePriority: 5,     targets: 8  }, // Aprobados
                { responsivePriority: 6,     targets: 9  }, // Reprobados
                { responsivePriority: 10001, targets: 0  }, // #
                { responsivePriority: 10002, targets: 1  }, // Carrera
                { responsivePriority: 10003, targets: 2  }, // Código
                { responsivePriority: 10004, targets: 4  }, // Sede
            ],
            '#tbl_modulos': [
                { responsivePriority: 1,     targets: 2  }, // Módulo
                { responsivePriority: 1,     targets: -1 }, // Opciones
                { responsivePriority: 2,     targets: 4  }, // PA
                { responsivePriority: 3,     targets: 5  }, // Bloque
                { responsivePriority: 4,     targets: 6  }, // Matriculados
                { responsivePriority: 5,     targets: 7  }, // Aprobados
                { responsivePriority: 6,     targets: 8  }, // Reprobados
                { responsivePriority: 10001, targets: 0  }, // #
                { responsivePriority: 10002, targets: 1  }, // Carrera
                { responsivePriority: 10003, targets: 3  }, // Sede
            ],
            '#tbl_pps': [
                { responsivePriority: 1,     targets: 1  }, // Nombre
                { responsivePriority: 1,     targets: -1 }, // Observaciones
                { responsivePriority: 2,     targets: -2 }, // Nota
                { responsivePriority: 3,     targets: 3  }, // Tipo Trabajo
                { responsivePriority: 4,     targets: 2  }, // Tipo Asesor
                { responsivePriority: 10001, targets: 0  }, // Registro
                { responsivePriority: 10002, targets: 4  }, // Seguimiento
            ],
            '#tbl_ssc': [
                { responsivePriority: 1,     targets: 1  }, // Nombre
                { responsivePriority: 1,     targets: -1 }, // Opciones
                { responsivePriority: 2,     targets: 7  }, // Estado
                { responsivePriority: 3,     targets: 6  }, // Tipo Trabajo
                { responsivePriority: 10001, targets: 0  }, // ID
                { responsivePriority: 10002, targets: 2  }, // Facultad
                { responsivePriority: 10003, targets: 3  }, // Fecha Inicio
                { responsivePriority: 10004, targets: 4  }, // Fecha Fin
                { responsivePriority: 10005, targets: 5  }, // Entidad
            ],
        };

        function initDataTable(id) {
            var table = $(id).DataTable({
                "aLengthMenu": [
                    [10, 30, 50, 100, -1],
                    [10, 30, 50, 100, "Todo"]
                ],
                "iDisplayLength": 10,
                language: dtLangConfig,
                responsive: true,
                columnDefs: responsivePriorities[id] || []
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

            // ── Modal Subir Evidencia PPS ────────────────────────────
            var urlUploadEvidencia       = "{{ url('docentes/pps/upload-evidencia') }}";
            var urlGuardarEvidencia      = "{{ url('docentes/pps/guardar-evidencia') }}";
            var urlDeleteEvidenciaTemp   = "{{ url('docentes/pps/delete-evidencia-temp') }}";
            var ppsFilenameSubido   = null;  // variable de closure — fuente de verdad

            function ppsResetModal() {
                ppsFilenameSubido = null;
                $('#pps_preview_wrap').hide();
                $('#pps_btn_guardar').hide();
                $('#pps_uploading').hide();
                $('#pps_upload_area').show();
                $('#pps_file_input').val('');
            }

            $(document).on('click', '.btn-evidencia-pps', function () {
                var btn = this;
                $('#pps_id_reserva').val(btn.getAttribute('data-id'));
                $('#pps_evidencia_estudiante').text(btn.getAttribute('data-estudiante'));
                $('#pps_evidencia_registro').text(btn.getAttribute('data-registro'));
                var tesis = btn.getAttribute('data-tesis') || '';
                if (tesis) {
                    $('#pps_evidencia_tesis').text(tesis);
                    $('#pps_evidencia_tesis_wrap').show();
                } else {
                    $('#pps_evidencia_tesis_wrap').hide();
                }
                ppsResetModal();
                setTimeout(feather.replace, 0);
            });

            $('#pps_file_input').on('change', function () {
                var file = this.files[0];
                if (!file) return;
                if (file.type !== 'application/pdf') {
                    Swal.fire({ icon: 'error', title: 'Archivo inválido', text: 'Solo se permiten archivos PDF.', confirmButtonColor: '#203b76' });
                    return;
                }
                if (file.size > 10 * 1024 * 1024) {
                    Swal.fire({ icon: 'error', title: 'Archivo muy grande', text: 'El archivo no debe superar 10 MB.', confirmButtonColor: '#203b76' });
                    return;
                }
                $('#pps_upload_area').hide();
                $('#pps_uploading').show();

                var formData = new FormData();
                formData.append('file', file);
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                $.ajax({
                    url: urlUploadEvidencia,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (data) {
                        $('#pps_uploading').hide();
                        if (!data || data.error) {
                            Swal.fire({ icon: 'error', title: 'Error', text: (data && data.error) ? data.error : 'Respuesta inválida del servidor.', confirmButtonColor: '#203b76' });
                            $('#pps_upload_area').show();
                            return;
                        }
                        if (!data.filename) {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'El servidor no devolvió el nombre del archivo.', confirmButtonColor: '#203b76' });
                            $('#pps_upload_area').show();
                            return;
                        }
                        ppsFilenameSubido = data.filename;
                        $('#pps_file_nombre').html('<i data-feather="check-circle" style="width:14px;height:14px;stroke:var(--verde);"></i> ' + file.name);
                        $('#pps_preview_wrap').show();
                        $('#pps_btn_guardar').show();
                        setTimeout(feather.replace, 0);
                    },
                    error: function (xhr) {
                        $('#pps_uploading').hide();
                        $('#pps_upload_area').show();
                        var msg = 'No se pudo subir el archivo.';
                        try { var r = JSON.parse(xhr.responseText); if (r.error) msg = r.error; } catch(e) {}
                        Swal.fire({ icon: 'error', title: 'Error (' + xhr.status + ')', text: msg, confirmButtonColor: '#203b76' });
                    }
                });
            });

            $('#pps_btn_quitar').on('click', function () {
                var fileAnterior = ppsFilenameSubido;
                ppsResetModal();
                if (fileAnterior) {
                    $.post(urlDeleteEvidenciaTemp, {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        filename: fileAnterior
                    });
                }
            });

            $(document).on('click', '#pps_btn_guardar', function () {
                var filename  = ppsFilenameSubido;
                var idReserva = $('#pps_id_reserva').val();
                if (!filename) {
                    Swal.fire({ icon: 'warning', title: 'Sin archivo', text: 'No hay archivo subido.', confirmButtonColor: '#203b76' });
                    return;
                }
                var btn = $(this);
                btn.prop('disabled', true).text('Guardando...');

                $.ajax({
                    url: urlGuardarEvidencia,
                    type: 'POST',
                    data: { _token: $('meta[name="csrf-token"]').attr('content'), id_reserva: idReserva, filename: filename },
                    success: function (data) {
                        btn.prop('disabled', false).html('<i data-feather="save" style="width:14px;height:14px;stroke:#fff;"></i> Guardar Evidencia');
                        if (data.msgError) {
                            Swal.fire({ icon: 'error', title: 'Error', text: data.msgError, confirmButtonColor: '#203b76' });
                            return;
                        }
                        var modalEl = document.getElementById('modal_subir_evidencia_pps');
                        var modal = bootstrap.Modal.getInstance(modalEl);
                        if (modal) modal.hide();
                        Swal.fire({ icon: 'success', title: '¡Guardado!', text: data.msgSuccess, timer: 2000, showConfirmButton: false });
                        setTimeout(function () { location.reload(); }, 2100);
                    },
                    error: function () {
                        btn.prop('disabled', false).html('<i data-feather="save" style="width:14px;height:14px;stroke:#fff;"></i> Guardar Evidencia');
                        Swal.fire({ icon: 'error', title: 'Error de conexión', text: 'No se pudo guardar la evidencia.', confirmButtonColor: '#203b76' });
                    }
                });
            });
            // ── Fin Modal Subir Evidencia PPS ───────────────────────

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