@extends('layout.master')
@push('plugin-styles')
<link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row inbox-wrapper">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    {{-- SIDEBAR --}}
                    <div class="col-lg-3 border-end-lg">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <button class="navbar-toggle btn btn-icon border d-block d-lg-none"
                                data-bs-target=".email-aside-nav"
                                data-bs-toggle="collapse"
                                type="button">
                                <span class="icon"><i data-feather="chevron-down"></i></span>
                            </button>
                            <div class="order-first">
                                <h4 class="mb-1">Solicitudes de Reingreso</h4>
                                <p class="text-muted mb-0">
                                    @if(isset($tipo_usuario) && $tipo_usuario == 'coordinador')
                                        Coordinación Académica
                                    @else
                                        Vicerrectoría
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="email-aside-nav collapse">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center justify-content-between" href="javascript:void(0);" onclick="cambiarVista('nuevas')">
                                       <div class ="d-flex align-items-center">
                                        <i data-feather="inbox" class="icon-lg me-2"></i>
                                        <span>Nuevas</span>
                                       </div>
                                        @if(isset($tipo_usuario) && $tipo_usuario == 'coordinador')
                                            <span class="badge bg-light text-dark border" id="badgeNuevas" style="font-weight: 500;">
                                                {{ isset($solicitudesnuevas) ? count($solicitudesnuevas) : 0 }}
                                            </span>
                                        @else
                                            <span class="badge bg-light text-dark border" id="badgeNuevas" style="font-weight: 500;">
                                                {{ isset($solicitudesvicerrector) ? count($solicitudesvicerrector) : 0 }}
                                            </span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center  justify-content-between" href="javascript:void(0);" onclick="cambiarVista('procesos')" >
                                       <div class="d-flex align-items-center">
                                        <i data-feather="clock" class="icon-lg me-2"></i>
                                        En Proceso
                                       </div>
                                         <span class="badge bg-light text-dark border" id="badgeProcesos" style="font-weight: 500;">0</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center  justify-content-between" href="javascript:void(0);" onclick="cambiarVista('finalizadas')">
                                        <div class="d-flex align-items-center">
                                        <i data-feather="check-circle" class="icon-lg me-2"></i>
                                        Finalizadas
                                        </div>
                                        <span class="badge bg-light text-dark border" id="badgeFinalizadas" style="font-weight: 500;">0</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-9">
                        {{-- SEMÁFORO INDICADOR --}}
                        <div class="card mb-3 border">
                            <div class="card-body p-3">
                                <h6 class="card-title text-uppercase mb-3" style="font-size: 0.875rem; letter-spacing: 0.5px;">
                                    <i data-feather="info" style="width:14px;height:14px;"></i> Indicadores de Estado
                                </h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" class="btn btn-success btn-sm position-relative"
                                        data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top"
                                        data-bs-trigger="hover" data-bs-content="SOLICITUD FINALIZADA/FAVORABLE"
                                        style="width: 32px; height: 32px; padding: 0;">
                                        <i data-feather="check-circle" style="width:16px;height:16px;"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm position-relative"
                                        data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top"
                                        data-bs-trigger="hover" data-bs-content="SOLICITUD EN PROCESO"
                                        style="background-color: #203B76; color: white; width: 32px; height: 32px; padding: 0;">
                                        <i data-feather="loader" style="width:16px;height:16px;"></i>
                                    </button>
                                    <button type="button" class="btn btn-secondary btn-sm position-relative"
                                        data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top"
                                        data-bs-trigger="hover" data-bs-content="ESTUDIANTE INACTIVO/AUSENTE"
                                        style="width: 32px; height: 32px; padding: 0;">
                                        <i data-feather="user-x" style="width:16px;height:16px;"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm position-relative"
                                        data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top"
                                        data-bs-trigger="hover" data-bs-content="ESTUDIANTE SANCIONADO"
                                        style="width: 32px; height: 32px; padding: 0;">
                                        <i data-feather="alert-triangle" style="width:16px;height:16px;"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm position-relative"
                                        data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top"
                                        data-bs-trigger="hover" data-bs-content="ESTUDIANTE CON SALDO PENDIENTE/INFAVORABLE"
                                        style="width: 32px; height: 32px; padding: 0;">
                                        <i data-feather="alert-octagon" style="width:16px;height:16px;"></i>
                                    </button>
                                     <button type="button" class="btn btn-info btn-sm position-relative"
                                        data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top"
                                        data-bs-trigger="hover" data-bs-content="INFORMATIVO"
                                        style="width: 32px; height: 32px; padding: 0;">
                                        <i data-feather="info" style="width:16px;height:16px;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- ENCABEZADO(header) --}}
                        <div class="p-3 border-bottom">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-end mb-2 mb-md-0">
                                        <i data-feather="inbox" class="text-muted me-2" id="iconoVista"></i>
                                        <h4 class="me-1 mb-0" id="tituloVista">Bandeja de Entrada</h4>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <input class="form-control" type="text" id="searchInput"
                                            placeholder="Buscar por nombre o identidad...">
                                        <button class="btn btn-light btn-icon" type="button">
                                            <i data-feather="search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- LISTA DE SOLICITUDES NUEVAS --}}
                        <div class="list-group list-group-flush" id="listaNuevas" style="display: block;">
                            @if(isset($tipo_usuario) && $tipo_usuario == 'coordinador')
                                @forelse($solicitudesnuevas ?? [] as $solicitud)
                                    <a href="javascript:void(0);"
                                        class="list-group-item list-group-item-action"
                                        data-solicitud='@json($solicitud)'
                                        onclick="abrirSolicitud({{ $solicitud['id_solicitud']}})">
                                        <div class="d-flex w-100 justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-bold">{{ $solicitud['nombre_completo'] }}</h6>
                                                <p class="mb-2 text-muted small">
                                                    <strong>ID:</strong> {{ $solicitud['identidad'] }} |
                                                    <strong>Carrera:</strong> {{ $solicitud['carrera'] }}
                                                </p>
                                                <div>
                                                    <span class="badge {{ $solicitud['estado_estudiante'] == 'Sancionado' ? 'bg-warning text-dark' : ($solicitud['estado_estudiante'] == 'Ausente' ? 'bg-secondary' : 'bg-info') }}" style="font-size: 0.75rem;">
                                                        {{ $solicitud['estado_estudiante'] }}
                                                    </span>
                                                    @if($solicitud['saldo'] > 0)
                                                        <span class="badge bg-danger ms-1" style="font-size: 0.75rem;">
                                                            <i data-feather="alert-triangle" style="width:12px;height:12px;"></i>
                                                            Saldo: L. {{ number_format($solicitud['saldo'], 2) }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-success ms-1" style="font-size: 0.75rem;">
                                                            <i data-feather="check-circle" style="width:12px;height:12px;"></i>
                                                            Sin Deuda
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <small class="text-muted">
                                                {{ $solicitud['ultimo_periodo'] }}/{{ $solicitud['ultimo_ingreso'] }}
                                            </small>
                                        </div>
                                    </a>
                                @empty
                                    <div class="text-center p-5">
                                        <i data-feather="inbox" style="width: 48px; height: 48px;" class="text-muted mb-3"></i>
                                        <p class="text-muted">No hay solicitudes pendientes</p>
                                    </div>
                                @endforelse
                            @else
                                @forelse($solicitudesvicerrector ?? [] as $solicitud)
                                    <a href="javascript:void(0);"
                                        class="list-group-item list-group-item-action"
                                        data-solicitud='@json($solicitud)'
                                        onclick="abrirSolicitudVicerrector({{ $solicitud['id_solicitud'] }})">
                                        <div class="d-flex w-100 justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1 fw-bold">{{ $solicitud['nombre_completo'] }}</h6>
                                                <p class="mb-2 text-muted small">
                                                    <strong>ID:</strong> {{ $solicitud['identidad'] }} |
                                                    <strong>Carrera:</strong> {{ $solicitud['carrera'] }}
                                                </p>
                                                <div>
                                                    <span class="badge {{ $solicitud['estado_estudiante'] == 'Sancionado' ? 'bg-warning text-dark' : ($solicitud['estado_estudiante'] == 'Ausente' ? 'bg-secondary' : 'bg-info') }}" style="font-size: 0.75rem;">
                                                        {{ $solicitud['estado_estudiante'] }}
                                                    </span>
                                                    @if($solicitud['saldo'] > 0)
                                                        <span class="badge bg-danger ms-1" style="font-size: 0.75rem;">
                                                            Saldo: L. {{ number_format($solicitud['saldo'], 2) }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-success ms-1" style="font-size: 0.75rem;">
                                                            Sin Deuda
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <small class="text-muted">
                                                Coord: {{ $solicitud['coordinador_nombre'] ?? 'N/A' }}
                                            </small>
                                        </div>
                                    </a>
                                @empty
                                    <div class="text-center p-5">
                                        <i data-feather="inbox" style="width: 48px; height: 48px;" class="text-muted mb-3"></i>
                                        <p class="text-muted">No hay solicitudes pendientes</p>
                                    </div>
                                @endforelse
                            @endif
                        </div>

                        {{-- LISTA DE SOLICITUDES EN PROCESO --}}
                        <div class="list-group list-group-flush" id="listaProcesos" style="display: none;"></div>

                        {{-- LISTA DE SOLICITUDES FINALIZADAS --}}
                        <div class="list-group list-group-flush" id="listaFinalizadas" style="display: none;"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODALES --}}
{{-- Modal para Ver Solicitud Completa (Coordinador) --}}
<div class="modal fade" id="modalSolicitudCoordinador" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">
                    <i data-feather="file-text" class="me-2"></i>
                    Solicitud de Reingreso
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;" id="contenidoSolicitudCoordinador"></div>
            <div class="modal-footer d-flex justify-content-between align-items-center">
                <div id="estadoDeuda"></div>
                <div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i data-feather="x" class="me-1" style="width:16px;"></i> Cerrar
                    </button>
                    <button type="button" class="btn btn-danger" onclick="abrirModalDictamen(3)">
                        <i data-feather="x-circle" class="me-1" style="width:16px;"></i> Infavorable
                    </button>
                    <button type="button" class="btn btn-success" onclick="abrirModalDictamen(2)">
                        <i data-feather="check-circle" class="me-1" style="width:16px;"></i> Favorable
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal para Ver Solicitud en Proceso/Finalizada --}}
<div class="modal fade" id="modalSolicitudProceso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #203B76; color: white !important; ">
                <h5 class="modal-title" style="color: white !important;">
                    <i data-feather="file-text" class="me-2" style="color: white !important;"></i>
                    <span id="tituloModalProceso" style="color: white !important;">Solicitud de Reingreso</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;" id="contenidoSolicitudProceso"></div>
            <div class="modal-footer d-flex justify-content-between align-items-center">
                <div id="estadoDeudaProceso"></div>
                <div id="botonesAccionProceso">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i data-feather="x" class="me-1" style="width:16px;"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal para Ver Solicitud Completa (Vicerrector) --}}
<div class="modal fade" id="modalSolicitudVicerrector" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title text-white">
                    <i data-feather="file-text" class="me-2"></i>
                    Solicitud de Reingreso - Evaluación Vicerrectoría
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;" id="contenidoSolicitudVicerrector"></div>
            <div class="modal-footer d-flex justify-content-between align-items-center">
                <div id="estadoDeudaVicerrector"></div>
                <div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i data-feather="x" class="me-1" style="width:16px;"></i> Cerrar
                    </button>
                    <button type="button" class="btn btn-success" onclick="abrirModalDictamenVicerrector(2)">
                        <i data-feather="check-circle" class="me-1" style="width:16px;"></i> Dictaminar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal para Ingresar Dictamen (Coordinador) --}}
<div class="modal fade" id="modalDictamenCoordinador" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-dark" id="tituloDictamen"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formDictamenCoordinador">
                    <input type="hidden" id="id_solicitud_dictamen" name="id_solicitud">
                    <input type="hidden" id="dictamen_tipo" name="dictamen">
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i data-feather="dollar-sign" class="me-1" style="width:16px;"></i>
                            Estado Financiero del Estudiante:
                        </label>
                        <div id="alertaSaldo"></div>
                    </div>
                    <div class="mb-3">
                        <label for="descripcionDictamen" class="form-label fw-bold">
                            <i data-feather="edit" class="me-1" style="width:16px;"></i>
                            Descripción del Dictamen <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="descripcionDictamen" name="descripcion" rows="6"
                            placeholder="Ingrese los motivos de su decisión (mínimo 20 caracteres)..." required></textarea>
                        <small class="text-muted">
                            <i data-feather="info" style="width:14px;"></i>
                            Explique claramente las razones de su dictamen. Esta información será enviada al vicerrector.
                        </small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i data-feather="x" class="me-1" style="width:16px;"></i> Cancelar
                </button>
                <button type="button" class="btn btn-primary" onclick="guardarDictamenCoordinador()">
                    <i data-feather="save" class="me-1" style="width:16px;"></i> Enviar Dictamen
                </button>
            </div>
        </div>
    </div>
</div>


{{--NUEVO MODAL PARA INGRESAR DICTAMEN DEL VICERRECTOR--}}
<div class="modal fade" id="modalDictamenVicerrector" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title text-white" id="tituloDictamenVicerrector"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formDictamenVicerrector">
                    <input type="hidden" id="id_solicitud_dictamen_vice" name="id_solicitud">
                    <input type="hidden" id="dictamen_tipo_vice" name="dictamen">
                    <input type="hidden" id="numero_registro_vice" name="numero_registro_asignado">

                    <!-- Estado Financiero -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i data-feather="dollar-sign" class="me-1" style="width:16px;"></i>
                            Estado Financiero del Estudiante:
                        </label>
                        <div id="alertaSaldoVicerrector"></div>
                    </div>

                    <!-- ✅ SECCIÓN DE BECA Y PERIODO ACADÉMICO (SIDE BY SIDE) -->
                    <div class="mb-3" id="seccionBecaPeriodo" style="display: none;">
                        <div class="row">
                            <!-- Columna: Tipo de Beca -->
                            <div class="col-md-6">
                                <label for="tipoBeca" class="form-label fw-bold">
                                    <i data-feather="award" class="me-1" style="width:16px;"></i>
                                    Tipo de Beca <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="tipoBeca" name="id_tipo_beca">
                                    <option value="">Seleccione un tipo de beca...</option>
                                    @if(isset($tipos_beca))
                                        @foreach($tipos_beca as $beca)
                                            <option value="{{ $beca['id']}}" data-monto="{{ $beca['monto'] }}">
                                                {{ $beca['nombre'] }} - {{ $beca['descripcion'] }} (L. {{ number_format($beca['monto'], 2) }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <small class="text-muted">
                                    <i data-feather="info" style="width:14px;"></i>
                                    Seleccione el tipo de beca a asignar
                                </small>
                            </div>

                            <!-- ✅ Columna: Periodo Académico -->
                            <div class="col-md-6">
                                <label for="periodoAcademico" class="form-label fw-bold">
                                    <i data-feather="calendar" class="me-1" style="width:16px;"></i>
                                    Periodo de Reincorporación <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="periodoAcademico" name="periodo_academico" required>
                                    <option value="">Seleccione periodo...</option>
                                    <option value="1">Periodo 1</option>
                                    <option value="2">Periodo 2</option>
                                    <option value="3">Periodo 3</option>
                                    <option value="4">Periodo 4</option>
                                    <option value="5">Periodo 5</option>
                                    <option value="6">Periodo 6</option>
                                    <option value="7">Periodo 7</option>
                                    <option value="8">Periodo 8</option>
                                    <option value="9">Periodo 9</option>
                                    <option value="10">Periodo 10</option>
                                    <option value="11">Periodo 11</option>
                                    <option value="12">Periodo 12</option>
                                    <option value="13">Periodo 13</option>
                                    <option value="14">Periodo 14</option>
                                    <option value="15">Periodo 15</option>
                                    <option value="16">Periodo 16</option>
                                    <option value="17">Periodo 17</option>
                                </select>
                                <small class="text-muted">
                                    <i data-feather="info" style="width:14px;"></i>
                                    Periodo al que regresará el estudiante
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Descripción del Dictamen -->
                    <div class="mb-3">
                        <label for="descripcionDictamenVicerrector" class="form-label fw-bold">
                            <i data-feather="edit" class="me-1" style="width:16px;"></i>
                            Descripción del Dictamen <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="descripcionDictamenVicerrector" name="descripcion" rows="6"
                            placeholder="Ingrese los motivos de su decisión (mínimo 20 caracteres)..." required></textarea>
                        <small class="text-muted">
                            <i data-feather="info" style="width:14px;"></i>
                            Explique claramente las razones de su dictamen final.
                        </small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i data-feather="x" class="me-1" style="width:16px;"></i> Cancelar
                </button>
                <button type="button" class="btn btn-primary" onclick="guardarDictamenVicerrector()">
                    <i data-feather="save" class="me-1" style="width:16px;"></i> Enviar Dictamen
                </button>
            </div>
        </div>
    </div>
</div>

{{--NUEVO SCRIPT DE MODAL--}}
{{-- Modal para Cerrar Solicitud (Solo Vicerrector) --}}
<div class="modal fade" id="modalCerrarSolicitud" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title text-white">
                    <i data-feather="check-circle" class="me-2"></i>
                    Finalizar Solicitud
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" role="alert">
                    <h6 class="alert-heading">
                        <i data-feather="check-circle"></i> Solicitud Aprobada
                    </h6>
                    <p class="mb-0">El estudiante cumple con todos los requisitos y no presenta deudas pendientes.</p>
                </div>
                <p class="mb-3">¿Está seguro de que desea dar por <strong>finalizada</strong> esta solicitud?</p>
                <input type="hidden" id="id_solicitud_cerrar">
                <input type="hidden" id="saldo_solicitud_cerrar">
                <div class="alert alert-info" role="alert">
                    <small>
                        <strong><i data-feather="info" style="width:14px;"></i> Nota:</strong>
                        Al cerrar esta solicitud, se completará el proceso de reingreso y el estudiante será notificado de la aprobación.
                        Esta acción es <strong>irreversible</strong>.
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i data-feather="x" class="me-1" style="width:16px;"></i> Cancelar
                </button>
                <!-- CORRECCIÓN: usar onclick en vez de id con paréntesis -->
                <button type="button" class="btn btn-success" onclick="confirmarCierreSolicitud()">
                    <i data-feather="check" class="me-1" style="width:16px;"></i> Sí, Finalizar Solicitud
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
// Variables Globales [let es igual que var pero mas moderno y mejor, utilizado cuando sus valores cambian]
let solicitudActual = null;
let tipoUsuario = "{{ $tipo_usuario ?? 'coordinador' }}";
let vistaActual = 'nuevas';
let datosProcesos = [];
let datosFinalizadas = [];

// Cambiar entre vistas
function cambiarVista(vista) {
    vistaActual = vista;

    // Ocultar todas las listas
    document.getElementById('listaNuevas').style.display = 'none';
    document.getElementById('listaProcesos').style.display = 'none';
    document.getElementById('listaFinalizadas').style.display = 'none';

    // Remover clase active de todos los nav-link
    document.querySelectorAll('.email-aside-nav .nav-link').forEach(link => {
        link.classList.remove('active');
    });

    // Actualizar título y mostrar vista correspondiente
    const tituloVista = document.getElementById('tituloVista');
    const iconoVista = document.getElementById('iconoVista');

    if (vista === 'nuevas') {
        document.getElementById('listaNuevas').style.display = 'block';
        tituloVista.textContent = 'Bandeja de Entrada';
        iconoVista.setAttribute('data-feather', 'inbox');
        document.querySelectorAll('.email-aside-nav .nav-link')[0].classList.add('active');
    } else if (vista === 'procesos') {
        document.getElementById('listaProcesos').style.display = 'block';
        tituloVista.textContent = 'Solicitudes en Proceso';
        iconoVista.setAttribute('data-feather', 'clock');
        document.querySelectorAll('.email-aside-nav .nav-link')[1].classList.add('active');
        cargarProcesos();
    } else if (vista === 'finalizadas') {
        document.getElementById('listaFinalizadas').style.display = 'block';
        tituloVista.textContent = 'Solicitudes Finalizadas';
        iconoVista.setAttribute('data-feather', 'check-circle');
        document.querySelectorAll('.email-aside-nav .nav-link')[2].classList.add('active');
        cargarFinalizadas();
    }

    feather.replace();
}
// Cargar Solicitudes en Proceso
function cargarProcesos() {
    const listaProcesos = document.getElementById('listaProcesos');
    listaProcesos.innerHTML = '<div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>';
 //USO FETCH EN VEZ DEL AJAX; Fetch es la forma moderna de hacer AJAX (sin usar jQuery).
    fetch('/solicitudesnuevas/procesos-solicitudes', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {

        if (data.msgSuccess && data.data) {
            datosProcesos = data.data;
            document.getElementById('badgeProcesos').textContent = data.total || 0;
            renderizarProcesos(data.data);
        } else {
            listaProcesos.innerHTML = '<div class="text-center p-5"><i data-feather="clock" style="width: 48px; height: 48px;" class="text-muted mb-3"></i><p class="text-muted">No hay solicitudes en proceso</p></div>';
            feather.replace();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        listaProcesos.innerHTML = '<div class="text-center p-5"><div class="alert alert-danger">Error al cargar las solicitudes en proceso</div></div>';
    });
}
// Renderizar Lista de Procesos
function renderizarProcesos(procesos) {
    const listaProcesos = document.getElementById('listaProcesos');

    //console.log(procesos)
    if (procesos.length === 0) {
        listaProcesos.innerHTML = '<div class="text-center p-5"><i data-feather="clock" style="width: 48px; height: 48px;" class="text-muted mb-3"></i><p class="text-muted">No hay solicitudes en proceso</p></div>';
        feather.replace();
        return;
    }

    let html = '';
    procesos.forEach(proceso => {
        const saldo = parseFloat(proceso.saldo || 0);
        const dictamenFinal = proceso.dictamen_final || 'Pendiente';
        const badgeColor = dictamenFinal === 'Favorable' ? 'bg-success' : (dictamenFinal === 'No favorable' ? 'bg-danger' : 'bg-secondary');

        html += `
            <a href="javascript:void(0);"
                class="list-group-item list-group-item-action"
                onclick="abrirSolicitudProceso('${proceso.identidad}')">
                <div class="d-flex w-100 justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-bold">${proceso.nombre_completo}</h6>
                        <p class="mb-2 text-muted small">
                            <strong>ID:</strong> ${proceso.identidad} |
                            <strong>Último Período:</strong> ${proceso.ultimo_periodo}/${proceso.ultimo_ingreso}
                        </p>
                        <div>
                            <span class="badge ${badgeColor}" style="font-size: 0.75rem; color: white !important;">
                                ${dictamenFinal}
                            </span>
                            ${saldo > 0 ?
                                `<span class="badge bg-danger ms-1" style="font-size: 0.75rem; color: white !important;">
                                    Saldo: L. ${saldo.toFixed(2)}
                                </span>` :
                                `<span class="badge bg-success ms-1" style="font-size: 0.75rem; color: white !important;">
                                    Sin Deuda
                                </span>`
                            }
                            ${proceso.tipo_beca ?
                                `<span class="badge bg-info ms-1" style="font-size: 0.75rem;">
                                    Beca: ${proceso.tipo_beca}
                                </span>` : ''
                            }
                        </div>
                    </div>
                    <small class="text-muted">
                        <span class="badge" style="background-color: #203B76!important; color: white !important;">En Proceso</span>
                    </small>
                </div>
            </a>
        `;
    });

    listaProcesos.innerHTML = html;
    feather.replace();
}
// Abrir Solicitud en Proceso
function abrirSolicitudProceso(identidad) {
    const proceso = datosProcesos.find(p => p.identidad === identidad);
    if (!proceso) {
        Swal.fire('Error', 'No se encontró la solicitud', 'error');
        return;
    }

    solicitudActual = proceso;

    // Construir contenido del modal
    let contenido = `
        <div class="card border-start border-4 bg-light" style="border-color: #203B76 !important;">
            <div class="card-body">
                <h5 class="card-title  mb-3">
                    <i data-feather="file-text" class="me-2"></i>
                    Solicitud de Reingreso - En Proceso
                </h5>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-uppercase mb-3" style="font-size: 0.875rem; letter-spacing: 0.5px;">
                            <i data-feather="user" class="me-1" style="width:16px;"></i>
                            Datos del Estudiante
                        </h6>
                        <p class="mb-2"><strong>Nombre:</strong> ${proceso.nombre_completo}</p>
                        <p class="mb-2"><strong>Identidad:</strong> ${proceso.identidad}</p>
                        <p class="mb-2"><strong>Teléfono:</strong> ${proceso.telefono || 'N/A'}</p>
                        <p class="mb-2"><strong>Correo:</strong> ${proceso.correo || 'N/A'}</p>
                        ${proceso.sancion ? `<p class="mb-0"><strong>Sanción:</strong> <span class="badge bg-warning text-dark">${proceso.sancion}</span></p>` : ''}
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-uppercase mb-3" style="font-size: 0.875rem; letter-spacing: 0.5px;">
                            <i data-feather="book" class="me-1" style="width:16px;"></i>
                            Información Académica
                        </h6>
                        <p class="mb-2"><strong>Último Ingreso:</strong> ${proceso.ultimo_periodo}/${proceso.ultimo_ingreso}</p>
                        <p class="mb-2"><strong>Total Cobrado:</strong> L. ${parseFloat(proceso.total_cobrado || 0).toFixed(2)}</p>
                        <p class="mb-2"><strong>Total Pagado:</strong> L. ${parseFloat(proceso.total_pagado || 0).toFixed(2)}</p>
                        <p class="mb-0"><strong>Saldo:</strong> <span class="${proceso.saldo > 0 ? 'text-danger' : 'text-success'} fw-bold">L. ${parseFloat(proceso.saldo || 0).toFixed(2)}</span></p>
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="text-uppercase mb-3" style="font-size: 0.875rem; letter-spacing: 0.5px;">
                    <i data-feather="file-text" class="me-1" style="width:16px;"></i>
                    Dictámenes Establecidos
                </h6>

                ${proceso.dictamenes ? generarDictamenesHTML(proceso) : '<p class="text-muted">No hay dictámenes registrados</p>'}


            </div>
        </div>
    `;

    document.getElementById('contenidoSolicitudProceso').innerHTML = contenido;

    // Estado de deuda
    let estadoDeuda = proceso.saldo > 0
        ? `<span class="badge bg-warning text-dark">
            <i data-feather="alert-triangle" style="width:16px;height:16px;"></i>
            Saldo Pendiente: L. ${parseFloat(proceso.saldo).toFixed(2)}
        </span>`
        : `<span class="badge bg-success">
            <i data-feather="check-circle" style="width:16px;height:16px;"></i>
            Libre de Deudas
        </span>`;
    document.getElementById('estadoDeudaProceso').innerHTML = estadoDeuda;

    // Botones de acción (solo para vicerrector) TRABAJANDO EN FUNCIONABILIDAD
    let botonesHTML = `<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
        <i data-feather="x" class="me-1" style="width:16px;"></i> Cerrar
    </button>`;

    if (tipoUsuario === 'vicerrector' && proceso.saldo == 0) {
        botonesHTML += `
            <button type="button" class="btn btn-success" onclick="abrirModalFinalizarProceso()">
                <i data-feather="check-circle" class="me-1" style="width:16px;"></i> Finalizar Solicitud
            </button>
        `;
    }

    document.getElementById('botonesAccionProceso').innerHTML = botonesHTML;

    if (typeof feather !== 'undefined') feather.replace();

    const modal = new bootstrap.Modal(document.getElementById('modalSolicitudProceso'));
    modal.show();
}
//  Dictámenes Coordinador
function generarDictamenesHTML(proceso) {
    const usuarios = (proceso.usuarios_que_dictaminaron || '').split(' | ');
    const dictamenes = (proceso.dictamenes || '').split(' | ');
    const descripciones = (proceso.descripciones || '').split(' | ');
    const situaciones = (proceso.situaciones || '').split(' | ');

    let html = '';

    for (let i = 0; i < usuarios.length; i++) {
        if (!usuarios[i]) continue;

        const dictamen = dictamenes[i] == '1' ? 'Favorable' : 'Infavorable';
        const badgeColor = dictamen === 'Favorable' ? 'bg-success' : 'bg-danger';
        const rol = i === 0 ? 'Coordinador' : 'Vicerrector';


        html += `
            <div class="card mb-3 border-start border-4 ${dictamen === 'Favorable' ? 'border-success' : 'border-danger'}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="mb-0">
                            <i data-feather="${i === 0 ? 'user' : 'shield'}" class="me-1" style="width:16px;"></i>
                            Dictamen del ${rol}
                        </h6>
                        <span class="badge ${badgeColor}">${dictamen}</span>
                    </div>
                    <p class="mb-2 text-muted small"><strong>Usuario:</strong> ${usuarios[i]}</p>
                    <p class="mb-0"><strong>Observación:</strong></p>
                    <div class="bg-white p-3 rounded mt-2 border">
                        ${descripciones[i] || 'Sin descripción'}
                    </div>
                </div>
            </div>
        `;
    }

    return html;
}
function abrirModalFinalizarProceso() {
    if (!solicitudActual) {
        Swal.fire('Error', 'No hay solicitud seleccionada', 'error');
        return;
    }

    // ✅ PRIMERO: Validar que el estudiante no tenga deudas
    if (solicitudActual.saldo > 0) {
        Swal.fire({
            icon: 'warning',
            title: 'No se Puede Cerrar',
            html: `El estudiante tiene un saldo pendiente de <strong>L. ${parseFloat(solicitudActual.saldo).toFixed(2)}</strong>`,
            confirmButtonColor: '#ffc107'
        });
        return;
    }

    // ✅ SEGUNDO: Establecer los valores ANTES de cerrar el modal
    document.getElementById('id_solicitud_cerrar').value = solicitudActual.id_solicitud;
    document.getElementById('saldo_solicitud_cerrar').value = solicitudActual.saldo || 0;

    console.log('✅ Datos guardados para cerrar:', {
        id: solicitudActual.id_solicitud,
        saldo: solicitudActual.saldo
    });

    // ✅ TERCERO: Ahora sí, cerrar el modal actual y abrir el de cierre
    const modalProcesoEl = document.getElementById('modalSolicitudProceso');
    const modalCerrarEl = document.getElementById('modalCerrarSolicitud');

    const modalProceso = bootstrap.Modal.getInstance(modalProcesoEl);

    // Evento para abrir el modal de cierre cuando se termine de cerrar el actual
    modalProcesoEl.addEventListener('hidden.bs.modal', function abrirModalCerrar() {
        modalProcesoEl.removeEventListener('hidden.bs.modal', abrirModalCerrar);

        // Limpiar aria-hidden
        const app = document.getElementById('app');
        if (app) {
            app.removeAttribute('aria-hidden');
            app.removeAttribute('inert');
        }

        // Limpiar backdrops
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => backdrop.remove());

        // Remover modal-open si no hay otros modales
        if (document.querySelectorAll('.modal.show').length === 0) {
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        }

        // Abrir modal de cierre
        setTimeout(() => {
            modalCerrarEl.removeAttribute('aria-hidden');
            const modalCerrar = new bootstrap.Modal(modalCerrarEl);
            modalCerrar.show();
        }, 150);
    });

    // Cerrar modal actual
    if (modalProceso) {
        modalProceso.hide();
    }
}
// Cargar Solicitudes Finalizadas
function cargarFinalizadas() {
    const listaFinalizadas = document.getElementById('listaFinalizadas');
    listaFinalizadas.innerHTML = '<div class="text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>';
 //USO FETCH EN VEZ DEL AJAX; Fetch es la forma moderna de hacer AJAX (sin usar jQuery).
    fetch('/solicitudesnuevas/finalizadas', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data) {
            datosFinalizadas = data.data;
            document.getElementById('badgeFinalizadas').textContent = data.total || 0;
            renderizarFinalizadas(data.data);
        } else {
            listaFinalizadas.innerHTML = '<div class="text-center p-5"><i data-feather="check-circle" style="width: 48px; height: 48px;" class="text-muted mb-3"></i><p class="text-muted">No hay solicitudes finalizadas</p></div>';
            feather.replace();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        listaFinalizadas.innerHTML = '<div class="text-center p-5"><div class="alert alert-danger">Error al cargar las solicitudes finalizadas</div></div>';
    });
}
// Renderizar Lista de Finalizadas
function renderizarFinalizadas(finalizadas) {
    const listaFinalizadas = document.getElementById('listaFinalizadas');

    if (finalizadas.length === 0) {
        listaFinalizadas.innerHTML = '<div class="text-center p-5"><i data-feather="check-circle" style="width: 48px; height: 48px;" class="text-muted mb-3"></i><p class="text-muted">No hay solicitudes finalizadas</p></div>';
        feather.replace();
        return;
    }

    let html = '';
    finalizadas.forEach(finalizada => {
        html += `
            <a href="javascript:void(0);"
                class="list-group-item list-group-item-action"
                onclick="abrirSolicitudFinalizada('${finalizada.identidad}')">
                <div class="d-flex w-100 justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-bold">${finalizada.nombre_completo}</h6>
                        <p class="mb-2 text-muted small">
                            <strong>ID:</strong> ${finalizada.identidad} |
                            <strong>Aprobadores:</strong> ${(finalizada.aprobadores || '').split(' | ').length}
                        </p>
                        <div>
                            <span class="badge bg-success" style="font-size: 0.75rem;">
                                <i data-feather="check-circle" style="width:12px;height:12px;"></i>
                                Finalizada
                            </span>
                            <span class="badge bg-info ms-1" style="font-size: 0.75rem;">
                                ${finalizada.total_aprobaciones} Aprobación(es)
                            </span>
                        </div>
                    </div>
                    <small class="text-muted">
                        ${new Date(finalizada.fecha_ultima_aprobacion).toLocaleDateString('es-HN')}
                    </small>
                </div>
            </a>
        `;
    });

    listaFinalizadas.innerHTML = html;
    feather.replace();
}
// Abrir Solicitud Finalizada
function abrirSolicitudFinalizada(identidad) {
    const finalizada = datosFinalizadas.find(f => f.identidad === identidad);
    if (!finalizada) {
        Swal.fire('Error', 'No se encontró la solicitud', 'error');
        return;
    }

    solicitudActual = finalizada;

    const aprobadores = (finalizada.aprobadores || '').split(' | ');
    const observaciones = (finalizada.observaciones || '').split(' | ');

    let observacionesHTML = '';
    for (let i = 0; i < aprobadores.length; i++) {
        if (!aprobadores[i]) continue;

        observacionesHTML += `
            <div class="card mb-3 border-start border-success border-4">
                <div class="card-body">
                    <h6 class="mb-2">
                        <i data-feather="user-check" class="me-1" style="width:16px;"></i>
                        Aprobación de ${aprobadores[i]}
                    </h6>
                    <div class="bg-white p-3 rounded border">
                        ${observaciones[i] || 'Sin observaciones'}
                    </div>
                </div>
            </div>
        `;
    }

    let contenido = `
        <div class="card border-start border-success border-4 bg-light">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i data-feather="check-circle" class="me-2"></i>
                    Solicitud de Reingreso - Finalizada
                </h5>

                <div class="alert alert-success mb-4">
                    <h6 class="alert-heading">
                        <i data-feather="check-circle" class="me-1"></i>
                        Solicitud Aprobada y Completada
                    </h6>
                    <p class="mb-0">Esta solicitud ha sido procesada exitosamente y el reingreso ha sido aprobado.</p>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-uppercase mb-3" style="font-size: 0.875rem; letter-spacing: 0.5px;">
                            <i data-feather="user" class="me-1" style="width:16px;"></i>
                            Datos del Estudiante
                        </h6>
                        <p class="mb-2"><strong>Nombre:</strong> ${finalizada.nombre_completo}</p>
                        <p class="mb-0"><strong>Identidad:</strong> ${finalizada.identidad}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-uppercase mb-3" style="font-size: 0.875rem; letter-spacing: 0.5px;">
                            <i data-feather="info" class="me-1" style="width:16px;"></i>
                            Información de Aprobación
                        </h6>
                        <p class="mb-2"><strong>Total Aprobaciones:</strong> ${finalizada.total_aprobaciones}</p>
                        <p class="mb-0"><strong>Fecha Última Aprobación:</strong> ${new Date(finalizada.fecha_ultima_aprobacion).toLocaleDateString('es-HN')}</p>
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="text-uppercase mb-3" style="font-size: 0.875rem; letter-spacing: 0.5px;">
                    <i data-feather="file-text" class="me-1" style="width:16px;"></i>
                    Historial de Aprobaciones
                </h6>

                ${observacionesHTML}
            </div>
        </div>
    `;

    document.getElementById('contenidoSolicitudProceso').innerHTML = contenido;
    document.getElementById('tituloModalProceso').textContent = 'Solicitud Finalizada';
    document.getElementById('estadoDeudaProceso').innerHTML = '<span class="badge bg-success"><i data-feather="check-circle" style="width:16px;height:16px;"></i> Aprobada</span>';
    document.getElementById('botonesAccionProceso').innerHTML = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i data-feather="x" class="me-1" style="width:16px;"></i> Cerrar</button>';

    if (typeof feather !== 'undefined') feather.replace();

    const modal = new bootstrap.Modal(document.getElementById('modalSolicitudProceso'));
    modal.show();
}
// COORDINADOR: Abrir Solicitud
function abrirSolicitud(idSolicitud) {
    const solicitudElement = document.querySelector(`[data-solicitud*='"id_solicitud":${idSolicitud}']`);
    if (!solicitudElement) {
        Swal.fire('Error', 'No se encontró la solicitud', 'error');
        return;
    }
    solicitudActual = JSON.parse(solicitudElement.getAttribute('data-solicitud'));

    let mensajeSolicitud = `
        <div class="card border-start border-primary border-4 bg-light">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i data-feather="file-text" class="me-2"></i>
                    SOLICITUD DE REINGRESO #${solicitudActual.id_solicitud}
                </h5>
                <p class="mb-2"><strong>Señor Coordinador de la carrera de ${solicitudActual.carrera}</strong></p>
                <p class="mb-3"><strong>Presente.-</strong></p>
                <p class="text-justify">
                    Yo, <strong>${solicitudActual.nombre_completo}</strong>, con número de identificación
                    <strong>${solicitudActual.identidad}</strong>, número de celular <strong>${solicitudActual.telefono}</strong>,
                    correo electrónico <strong>${solicitudActual.correo}</strong>, me dirijo a usted de manera respetuosa
                    para solicitar el reingreso a la Universidad, con el propósito de continuar mis estudios en la
                    carrera de <strong>${solicitudActual.carrera}</strong>.
                </p>
                <p class="text-justify">
                    El motivo de mi retiro fue por <strong>${solicitudActual.estado_estudiante}</strong>${solicitudActual.estado_estudiante === 'Sancionado' && solicitudActual.sancion ? `: <em>${solicitudActual.sancion}</em>` : ''}.
                </p>
                <p class="text-justify">
                    Deseo manifestar que mi último periodo cursado fue el <strong>${solicitudActual.ultimo_periodo}</strong>
                    del año <strong>${solicitudActual.ultimo_ingreso}</strong>, y actualmente cuento con un saldo de:
                    <strong class="${solicitudActual.saldo > 0 ? 'text-danger' : 'text-success'}">
                        L. ${parseFloat(solicitudActual.saldo).toFixed(2)}
                    </strong> lempiras.
                </p>
                <p class="text-justify">
                    Expreso mi firme deseo de retomar mis estudios con responsabilidad, compromiso y dedicación,
                    ya que cuento con las condiciones necesarias para continuar satisfactoriamente mi formación académica.
                </p>
                <p class="text-justify">
                    Agradezco de antemano la atención brindada a la presente solicitud y quedo atento(a) a cualquier
                    requerimiento o documentación adicional que deba presentar para completar el proceso de reingreso.
                </p>
                <p class="text-justify mb-4">
                    Sin otro particular, me despido cordialmente, reiterando mi disposición para cumplir con los
                    lineamientos establecidos.
                </p>
                <hr class="my-3">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong><i data-feather="user" class="me-1" style="width:16px;"></i>Datos de Contacto:</strong></p>
                        <p class="mb-1 small"><i data-feather="phone" class="me-1" style="width:14px;"></i> ${solicitudActual.telefono}</p>
                        <p class="mb-0 small"><i data-feather="mail" class="me-1" style="width:14px;"></i> ${solicitudActual.correo}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong><i data-feather="book" class="me-1" style="width:16px;"></i>Información Académica:</strong></p>
                        <p class="mb-1 small">Carrera: ${solicitudActual.carrera}</p>
                        <p class="mb-0 small">Último periodo: ${solicitudActual.ultimo_periodo}/${solicitudActual.ultimo_ingreso}</p>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.getElementById('contenidoSolicitudCoordinador').innerHTML = mensajeSolicitud;

    let estadoDeuda = solicitudActual.saldo > 0
        ? `<span class="badge bg-warning text-dark">
            <i data-feather="alert-triangle" style="width:16px;height:16px;"></i>
            Saldo Pendiente: L. ${parseFloat(solicitudActual.saldo).toFixed(2)}
        </span>`
        : `<span class="badge bg-success">
            <i data-feather="check-circle" style="width:16px;height:16px;"></i>
            Libre de Deudas
        </span>`;
    document.getElementById('estadoDeuda').innerHTML = estadoDeuda;

    if (typeof feather !== 'undefined') feather.replace();
    const modal = new bootstrap.Modal(document.getElementById('modalSolicitudCoordinador'));
    modal.show();
}
// COORDINADOR: Abrir Modal Dictamen
function abrirModalDictamen(tipoDictamen) {
    if (!solicitudActual) return;

    const modalSolicitud = bootstrap.Modal.getInstance(document.getElementById('modalSolicitudCoordinador'));
    if (modalSolicitud) modalSolicitud.hide();

    document.getElementById('id_solicitud_dictamen').value = solicitudActual.id_solicitud;
    document.getElementById('dictamen_tipo').value = tipoDictamen;

    const titulo = tipoDictamen === 2
        ? '<i data-feather="check-circle" class="me-2"></i>Dictamen Favorable'
        : '<i data-feather="x-circle" class="me-2"></i>Dictamen Infavorable';
    document.getElementById('tituloDictamen').innerHTML = titulo;

    let alertaSaldo = solicitudActual.saldo > 0
        ? `<div class="alert alert-warning mb-0">
            <i data-feather="alert-triangle" class="me-2"></i>
            <strong>Saldo Pendiente:</strong> L. ${parseFloat(solicitudActual.saldo).toFixed(2)}
        </div>`
        : `<div class="alert alert-success mb-0">
            <i data-feather="check-circle" class="me-2"></i>
            <strong>Estado Financiero:</strong> Libre de Deudas (L. 0.00)
        </div>`;
    document.getElementById('alertaSaldo').innerHTML = alertaSaldo;

    document.getElementById('descripcionDictamen').value = '';

    if (typeof feather !== 'undefined') feather.replace();
    const modal = new bootstrap.Modal(document.getElementById('modalDictamenCoordinador'));
    modal.show();
}
// COORDINADOR: Guardar Dictamen
function guardarDictamenCoordinador() {
    const descripcion = document.getElementById('descripcionDictamen').value.trim();

    if (!descripcion) {
        Swal.fire({
            icon: 'warning',
            title: 'Campo Requerido',
            text: 'Debe ingresar una descripción del dictamen',
            confirmButtonColor: '#3085d6'
        });
        return;
    }

    if (descripcion.length < 20) {
        Swal.fire({
            icon: 'warning',
            title: 'Descripción Muy Corta',
            text: 'La descripción debe tener al menos 20 caracteres',
            confirmButtonColor: '#3085d6'
        });
        return;
    }

    Swal.fire({
        title: 'Guardando Dictamen...',
        html: 'Por favor espere un momento',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });
 //USO FETCH EN VEZ DEL AJAX; Fetch es la forma moderna de hacer AJAX (sin usar jQuery).
    fetch('/solicitudesnuevas/guardar-dictamen-coordinador', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id_solicitud: document.getElementById('id_solicitud_dictamen').value,
            dictamen: document.getElementById('dictamen_tipo').value,
            descripcion: descripcion
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.estatus) {
            Swal.fire({
                icon: 'success',
                title: '¡Dictamen Guardado!',
                html: data.mensaje,
                confirmButtonColor: '#28a745',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalDictamenCoordinador'));
                if (modal) modal.hide();
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: data.mensaje || 'No se pudo guardar el dictamen',
                confirmButtonColor: '#d33'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de Conexión',
            text: 'No se pudo conectar con el servidor',
            confirmButtonColor: '#d33'
        });
    });
}
// VICERRECTOR: Abrir Solicitud
function abrirSolicitudVicerrector(idSolicitud) {
    const solicitudElement = document.querySelector(`[data-solicitud*='"id_solicitud":${idSolicitud}']`);
    if (!solicitudElement) {
        Swal.fire('Error', 'No se encontró la solicitud', 'error');
        return;
    }
    solicitudActual = JSON.parse(solicitudElement.getAttribute('data-solicitud'));

    let mensajeSolicitud = `
        <div class="card border-start border-info border-4 bg-light">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i data-feather="file-text" class="me-2"></i>
                    SOLICITUD DE REINGRESO #${solicitudActual.id_solicitud}
                </h5>
                <p class="mb-2"><strong>Señor VICERRECTOR</strong></p>
                <p class="mb-3"><strong>Presente.-</strong></p>
                <p class="text-justify">
                    Me permito remitir a su consideración la solicitud de reingreso presentada por el estudiante
                    <strong>${solicitudActual.nombre_completo}</strong>, con número de identificación
                    <strong>${solicitudActual.identidad}</strong>, número de celular <strong>${solicitudActual.telefono}</strong>,
                    correo electrónico <strong>${solicitudActual.correo}</strong>, quien manifiesta su intención de
                    continuar con sus estudios en la carrera de <strong>${solicitudActual.carrera}</strong>.
                </p>
                <p class="text-justify">
                    El motivo de su retiro académico fue por <strong>${solicitudActual.estado_estudiante}</strong>${solicitudActual.estado_estudiante === 'Sancionado' && solicitudActual.sancion ? `: <em>${solicitudActual.sancion}</em>` : ''}.
                    El estudiante cursó por última vez en el periodo <strong>${solicitudActual.ultimo_periodo}</strong> en el año
                    <strong>${solicitudActual.ultimo_ingreso}</strong>, y actualmente registra un saldo pendiente de
                    <strong class="${solicitudActual.saldo > 0 ? 'text-danger' : 'text-success'}">
                        L. ${parseFloat(solicitudActual.saldo).toFixed(2)}
                    </strong> lempiras.
                </p>

                <div class="alert alert-info mt-3">
                    <h6 class="alert-heading">
                        <i data-feather="user-check" class="me-1"></i>
                        Evaluación del Coordinador
                    </h6>
                    <p class="mb-1"><strong>Coordinador:</strong> ${solicitudActual.coordinador_nombre || 'N/A'}</p>
                    <p class="mb-0"><strong>Observación:</strong></p>
                    <p class="mb-0 mt-2 p-2 bg-white rounded">${solicitudActual.descripcion_coordinador || 'Sin descripción'}</p>
                </div>
                <p class="text-justify">
                    Con base en lo anterior, solicito respetuosamente su visto bueno para dar continuidad al trámite
                    correspondiente. Asimismo, se agradecerá su orientación respecto al tipo de beca que podría ser
                    asignado al estudiante, a fin de facilitar su proceso de reincorporación a la vida académica.
                </p>
                <p class="text-justify mb-4">
                    Sin otro particular, agradezco de antemano su atención y quedo atento(a) a cualquier disposición adicional.
                </p>
                <p class="mt-4"><strong>Atentamente,</strong><br>${solicitudActual.coordinador_nombre || 'Coordinador Académico'}</p>
                <hr class="my-3">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong><i data-feather="user" class="me-1" style="width:16px;"></i>Datos del Estudiante:</strong></p>
                        <p class="mb-1 small"><i data-feather="user" class="me-1" style="width:14px;"></i> ${solicitudActual.nombre_completo}</p>
                        <p class="mb-1 small"><i data-feather="credit-card" class="me-1" style="width:14px;"></i> ${solicitudActual.identidad}</p>
                        <p class="mb-1 small"><i data-feather="phone" class="me-1" style="width:14px;"></i> ${solicitudActual.telefono}</p>
                        <p class="mb-0 small"><i data-feather="mail" class="me-1" style="width:14px;"></i> ${solicitudActual.correo}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong><i data-feather="book" class="me-1" style="width:16px;"></i>Información Académica:</strong></p>
                        <p class="mb-1 small">Carrera: ${solicitudActual.carrera}</p>
                        <p class="mb-1 small">Último periodo: ${solicitudActual.ultimo_periodo}/${solicitudActual.ultimo_ingreso}</p>
                        <p class="mb-1 small">Inicio de estudios: ${solicitudActual.primer_periodo || 'N/A'}/${solicitudActual.primer_ingreso || 'N/A'}</p>
                        <p class="mb-0 small">Registro: ${solicitudActual.numero_registro_asignado || 'N/A'}</p>
                    </div>
                </div>
            </div>
        </div>
    `;

    document.getElementById('contenidoSolicitudVicerrector').innerHTML = mensajeSolicitud;

    let estadoDeuda = solicitudActual.saldo > 0
        ? `<span class="badge bg-warning text-dark">
            <i data-feather="alert-triangle" style="width:16px;height:16px;"></i>
            Saldo: L. ${parseFloat(solicitudActual.saldo).toFixed(2)}
        </span>`
        : `<span class="badge bg-success">
            <i data-feather="check-circle" style="width:16px;height:16px;"></i>
            Sin Deuda
        </span>`;
    document.getElementById('estadoDeudaVicerrector').innerHTML = estadoDeuda;

    if (typeof feather !== 'undefined') feather.replace();
    const modal = new bootstrap.Modal(document.getElementById('modalSolicitudVicerrector'));
    modal.show();
}
//NUEVO MODAL 19/11
function abrirModalDictamenVicerrector(tipoDictamen) {
    if (!solicitudActual) return;

    const modalSolicitud = bootstrap.Modal.getInstance(document.getElementById('modalSolicitudVicerrector'));
    if (modalSolicitud) modalSolicitud.hide();

    document.getElementById('id_solicitud_dictamen_vice').value = solicitudActual.id_solicitud;
    document.getElementById('dictamen_tipo_vice').value = tipoDictamen;
    document.getElementById('numero_registro_vice').value = solicitudActual.numero_registro_asignado || '';

    const titulo = tipoDictamen === 2
        ? '<i data-feather="check-circle" class="me-2"></i>Dictamen Favorable - Vicerrectoría'
        : '<i data-feather="x-circle" class="me-2"></i>Dictamen Infavorable - Vicerrectoría';
    document.getElementById('tituloDictamenVicerrector').innerHTML = titulo;

    let alertaSaldo = solicitudActual.saldo > 0
        ? `<div class="alert alert-warning mb-0">
            <i data-feather="alert-triangle" class="me-2"></i>
            <strong>Saldo Pendiente:</strong> L. ${parseFloat(solicitudActual.saldo).toFixed(2)}
        </div>`
        : `<div class="alert alert-success mb-0">
            <i data-feather="check-circle" class="me-2"></i>
            <strong>Estado Financiero:</strong> Libre de Deudas (L. 0.00)
        </div>`;
    document.getElementById('alertaSaldoVicerrector').innerHTML = alertaSaldo;

    const seccionBecaPeriodo = document.getElementById('seccionBecaPeriodo');
    const selectBeca = document.getElementById('tipoBeca');
    const selectPeriodo = document.getElementById('periodoAcademico');

    if (tipoDictamen === 2 ) {
        seccionBecaPeriodo.style.display = 'block';
        selectBeca.required = true;
        selectPeriodo.required = true;
    } else {
        seccionBecaPeriodo.style.display = 'none';
        selectBeca.required = false;
        selectPeriodo.required = false;
        selectBeca.value = '';
        selectPeriodo.value = '';
    }

    document.getElementById('descripcionDictamenVicerrector').value = '';

    if (typeof feather !== 'undefined') feather.replace();

    const modal = new bootstrap.Modal(document.getElementById('modalDictamenVicerrector'));
    modal.show();
}
//NUEVA FUNCION 19/11 AQUI
function guardarDictamenVicerrector() {
    const descripcion = document.getElementById('descripcionDictamenVicerrector').value.trim();
    const dictamen = document.getElementById('dictamen_tipo_vice').value;
    const tipoBeca = document.getElementById('tipoBeca').value;
    const periodoAcademico = document.getElementById('periodoAcademico').value; // ✅ NUEVO

    // Validaciones
    if (!descripcion) {
        Swal.fire({
            icon: 'warning',
            title: 'Campo Requerido',
            text: 'Debe ingresar una descripción del dictamen',
            confirmButtonColor: '#3085d6'
        });
        return;
    }

    if (descripcion.length < 20) {
        Swal.fire({
            icon: 'warning',
            title: 'Descripción Muy Corta',
            text: 'La descripción debe tener al menos 20 caracteres',
            confirmButtonColor: '#3085d6'
        });
        return;
    }

    if (dictamen == 2 && !tipoBeca) {
        Swal.fire({
            icon: 'warning',
            title: 'Beca Requerida',
            text: 'Debe seleccionar un tipo de beca cuando el dictamen es favorable',
            confirmButtonColor: '#3085d6'
        });
        return;
    }

    // ✅ VALIDAR PERIODO ACADÉMICO
    if (dictamen == 2 && !periodoAcademico) {
        Swal.fire({
            icon: 'warning',
            title: 'Periodo Requerido',
            text: 'Debe seleccionar el periodo académico de reincorporación',
            confirmButtonColor: '#3085d6'
        });
        return;
    }

    Swal.fire({
        title: 'Guardando Dictamen...',
        html: 'Por favor espere un momento',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    // ✅ ENVIAR CON PERIODO ACADÉMICO
    fetch('/solicitudesnuevas/guardar-dictamen-vicerrector', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id_solicitud: document.getElementById('id_solicitud_dictamen_vice').value,
            dictamen: dictamen,
            descripcion: descripcion,
            id_tipo_beca: tipoBeca || null,
            numero_registro_asignado: document.getElementById('numero_registro_vice').value,
            periodo_academico: periodoAcademico // ✅ NUEVO
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.estatus) {
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalDictamenVicerrector'));
            if (modal) modal.hide();

            if (dictamen == 2 && solicitudActual.saldo == 0) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Dictamen Guardado!',
                    html: `${data.mensaje}<br><br>¿Desea finalizar la solicitud ahora?`,
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="me-1" data-feather="check"></i> Sí, Finalizar',
                    cancelButtonText: 'Ahora No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        abrirModalCerrarSolicitud();
                    } else {
                        location.reload();
                    }
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: '¡Dictamen Guardado!',
                    html: data.mensaje,
                    confirmButtonColor: '#28a745'
                }).then(() => {
                    location.reload();
                });
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: data.mensaje || 'No se pudo guardar el dictamen',
                confirmButtonColor: '#d33'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de Conexión',
            text: 'No se pudo conectar con el servidor',
            confirmButtonColor: '#d33'
        });
    });
}
function generarDictamenesHTML(proceso) {
    const usuarios = (proceso.usuarios_que_dictaminaron || '').split(' | ');
    const dictamenes = (proceso.dictamenes || '').split(' | ');
    const descripciones = (proceso.descripciones || '').split(' | ');

    let html = '';

    for (let i = 0; i < usuarios.length; i++) {
        if (!usuarios[i]) continue;

        const dictamen = dictamenes[i] == '1' ? 'Favorable' : 'Infavorable';
        const badgeColor = dictamen === 'Favorable' ? 'bg-success' : 'bg-danger';
        const rol = i === 0 ? 'Vicerrector' : 'Coordinador';

        html += `
        <div class="card mb-3 border-start border-4 ${dictamen === 'Favorable' ? 'border-success' : 'border-danger'}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="mb-0">
                        <i data-feather="${i === 0 ? 'shield' : 'user'}" class="me-1" style="width:16px;"></i>
                        Dictamen del ${rol}
                    </h6>
                    <span class="badge ${badgeColor}">${dictamen}</span>
                </div>
                <p class="mb-2 text-muted small"><strong>Usuario:</strong> ${usuarios[i]}</p>
                <p class="mb-0"><strong>Observación:</strong></p>
                <div class="bg-white p-3 rounded mt-2 border">
                    ${descripciones[i] || 'Sin descripción'}
                </div>
            </div>
        </div>
        `;
    }

    if (proceso.tipo_beca || proceso.periodo_academico) {
        html += `
        <div class="alert alert-info mt-3">
            <h6 class="alert-heading">
                <i data-feather="file-text" class="me-1"></i>
                Información de Reincorporación
            </h6>
            <div class="row">
                ${proceso.tipo_beca ? `
                <div class="col-md-6">
                    <p class="mb-1"><strong>Beca Asignada:</strong> ${proceso.tipo_beca}</p>
                    <p class="mb-1"><strong>Descripción:</strong> ${proceso.descripcion_beca || 'N/A'}</p>
                    <p class="mb-0"><strong>Monto:</strong> L. ${parseFloat(proceso.monto_beca || 0).toFixed(2)}</p>
                </div>
                ` : ''}
                ${proceso.periodo_academico ? `
                <div class="col-md-6">
                    <p class="mb-0">
                        <i data-feather="calendar" class="me-1" style="width:16px;"></i>
                        <strong>Periodo Académico Asignado:</strong>
                        <span class="badge bg-primary" style="font-size: 1rem;">Periodo ${proceso.periodo_academico}</span>
                    </p>
                </div>
                ` : ''}
            </div>
        </div>
        `;
    }

    return html;
}
// VICERRECTOR: Abrir Modal Cerrar
function abrirModalCerrarSolicitud() {
    if (!solicitudActual) return;

    if (solicitudActual.saldo > 0) {
        Swal.fire({
            icon: 'warning',
            title: 'No se Puede Cerrar',
            html: `El estudiante tiene un saldo pendiente de <strong>L. ${parseFloat(solicitudActual.saldo).toFixed(2)}</strong>`,
            confirmButtonColor: '#ffc107'
        });
        return;
    }

    document.getElementById('id_solicitud_cerrar').value = solicitudActual.id_solicitud;
    document.getElementById('saldo_solicitud_cerrar').value = solicitudActual.saldo;

    // ✅ Cerrar cualquier modal abierto antes de abrir el nuevo
    const modalesAbiertos = document.querySelectorAll('.modal.show');
    modalesAbiertos.forEach(modalEl => {
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) {
            modalInstance.hide();
        }
    });

    // ✅ Esperar a que se cierren los modales anteriores
    setTimeout(() => {
        const modalCerrar = document.getElementById('modalCerrarSolicitud');
        modalCerrar.removeAttribute('aria-hidden'); // ✅ Importante
        const modal = new bootstrap.Modal(modalCerrar);
        modal.show();
    }, 300);
}
//VICERRECTOR NUEVO CODIGO DE CIERRE
function confirmarCierreSolicitud() {
    const idSolicitud = parseInt(document.getElementById('id_solicitud_cerrar').value, 10);
    const saldo = parseFloat(document.getElementById('saldo_solicitud_cerrar').value);
    const observacion = 'Solicitud cerrada por el sistema';

    // ✅ VALIDAR DATOS ANTES DE ENVIAR
    if (!idSolicitud || isNaN(idSolicitud)) {
        Swal.fire('Error', 'ID de solicitud inválido', 'error');
        return;
    }

    if (isNaN(saldo)) {
        Swal.fire('Error', 'Saldo inválido', 'error');
        return;
    }

    console.log('📤 Datos a enviar:', { id_solicitud: idSolicitud, saldo: saldo, observacion: observacion });

    Swal.fire({
        title: 'Finalizando Solicitud...',
        html: 'Por favor espere',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    fetch('/solicitudesnuevas/cerrar-solicitud', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id_solicitud: idSolicitud,
            saldo: saldo,
            observacion: observacion
        })
    })
    .then(res => {
        console.log('📥 Status de respuesta:', res.status);
        if (!res.ok) {
            return res.json().then(errData => {
                console.error('❌ Error del servidor:', errData);
                throw new Error(JSON.stringify(errData));
            });
        }
        return res.json();
    })
    .then(data => {
        console.log('✅ Respuesta exitosa:', data);
        if (data.estatus) {
            Swal.fire({
                icon: 'success',
                title: '¡Solicitud Finalizada!',
                html: data.msgSuccess,
                confirmButtonColor: '#28a745'
            }).then(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalCerrarSolicitud'));
                if (modal) modal.hide();
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: data.msgError || 'No se pudo cerrar la solicitud',
                confirmButtonColor: '#d33'
            });
        }
    })
    .catch(err => {
        console.error('❌ Error completo:', err);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: err.message || 'No se pudo conectar con el servidor',
            confirmButtonColor: '#d33'
        });
    });
}
 //codigo para evitar el error de enfoque
   document.getElementById('modalCerrarSolicitud')
        .addEventListener('hidden.bs.modal', function () {
            document.activeElement.blur();
        });

// Búsqueda en Tiempo Real; en el buscador
document.addEventListener('DOMContentLoaded', function() {

    // Configurar todos los modales para manejar aria-hidden correctamente
    const todosLosModales = document.querySelectorAll('.modal');
    todosLosModales.forEach(modal => {
        // Cuando un modal se muestra
        modal.addEventListener('show.bs.modal', function () {
            this.removeAttribute('aria-hidden');
        });

        // Cuando un modal se ha mostrado completamente
        modal.addEventListener('shown.bs.modal', function () {
            this.removeAttribute('aria-hidden');
            this.setAttribute('aria-modal', 'true');

            // Enfocar el primer elemento enfocable
            const primerEnfocable = this.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            if (primerEnfocable) {
                setTimeout(() => primerEnfocable.focus(), 100);
            }
        });

        // Cuando un modal se está ocultando
        modal.addEventListener('hide.bs.modal', function () {
            this.setAttribute('aria-hidden', 'true');
            this.removeAttribute('aria-modal');
        });

        // Cuando un modal se ha ocultado completamente
        modal.addEventListener('hidden.bs.modal', function () {
            // Limpiar backdrop huérfanos
            const backdrops = document.querySelectorAll('.modal-backdrop');
            if (document.querySelectorAll('.modal.show').length === 0) {
                backdrops.forEach(backdrop => backdrop.remove());
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
            }

            // Quitar aria-hidden del contenedor principal si no hay modales abiertos
            const mainWrapper = document.getElementById('app');
            if (mainWrapper && document.querySelectorAll('.modal.show').length === 0) {
                mainWrapper.removeAttribute('aria-hidden');
                mainWrapper.removeAttribute('inert');
            }

            // Limpiar el foco
            if (document.activeElement && document.activeElement.tagName !== 'BODY') {
                document.activeElement.blur();
            }
        });
    });

    // Búsqueda en tiempo real
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const vistas = ['listaNuevas', 'listaProcesos', 'listaFinalizadas'];

            vistas.forEach(vistaId => {
                const vista = document.getElementById(vistaId);
                if (vista.style.display !== 'none') {
                    const solicitudes = vista.querySelectorAll('.list-group-item');
                    solicitudes.forEach(function(solicitud) {
                        const texto = solicitud.textContent.toLowerCase();
                        solicitud.style.display = texto.includes(searchTerm) ? '' : 'none';
                    });
                }
            });
        });
    }

    if (typeof feather !== 'undefined') feather.replace();

    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    document.querySelectorAll('.email-aside-nav .nav-link')[0].classList.add('active');
});


</script>
@endpush
