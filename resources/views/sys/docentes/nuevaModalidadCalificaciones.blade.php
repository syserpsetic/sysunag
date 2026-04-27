@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('css/handsontable.full.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <style>
        /* Handsontable dentro del nuevo diseño */
        #hot {
            width: 100%;
            /* overflow: hidden; */
        }

        .wtHolder {
            overflow-x: auto !important;
            overflow-y: auto !important;
        }



        /* Fila con suma de notas que excede 100 */
        .htCore td.fila-suma-excedida {
            background-color: #fde8e8 !important;
            border-top: 1px solid #dc3545 !important;
            border-bottom: 1px solid #dc3545 !important;
        }

        /* Ocultar el scroll del clone superior */
        .ht_clone_top .wtHolder {
            overflow-x: hidden !important;
        }

        .stat-card {
            border-left: 4px solid var(--azul);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-card.verde {
            border-left-color: var(--verde);
        }

        .stat-card.rojo {
            border-left-color: var(--rojo);
        }

        .stat-card.cafe {
            border-left-color: var(--cafe);
        }

        .stat-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #6c757d;
            font-weight: 600;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--azul);
        }

        .stat-sub {
            font-size: 12px;
            color: #888;
        }

        /* Periodo abierto/cerrado banner */
        .periodo-banner {
            border-radius: 8px;
            padding: 10px 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .periodo-abierto {
            background: #d3eed7;
            color: var(--verdeOscuro);
        }

        .periodo-cerrado {
            background: #fde8e8;
            color: var(--rojo);
        }

        /* Calendario periodos */
        .calendario-item {
            padding: 6px 14px;
            border-radius: 6px;
            margin-bottom: 4px;
            font-size: 13px;
            background: #f0f4ff;
            border-left: 3px solid var(--azul);
        }

        .calendario-item.active {
            background: var(--verdeClaro);
            border-left-color: var(--verde);
            font-weight: 700;
        }

        /* Temporizador */
        #temporizador {
            font-size: 18px;
            font-weight: 700;
            color: var(--azul);
        }

        /* Toolbar de acciones */
        .acciones-toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: flex-end;
            margin-bottom: 16px;
        }





        /* ============================================================
                           HANDSONTABLE
                           ============================================================ */

        /* ── CONTENEDOR ── */
        /* ── CONTENEDOR ── */
        #hot {
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(19, 84, 35, 0.12);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            animation: hotFadeIn 0.4s ease forwards;
        }

        @media (max-width: 768px) {
            #hot {
                overflow: visible !important;
                border-radius: 4px !important;
            }

            .ht_clone_left,
            .ht_clone_top_left_corner {
                display: none !important;
            }

            .wtHolder {
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch !important;
            }

            .ht_clone_top .wtHolder {
                overflow-x: auto !important;
            }

            .acciones-toolbar {
                justify-content: flex-start;
            }

            .stat-value {
                font-size: 20px;
            }
        }

        /* ── SCROLL ── */
        .wtHolder {
            overflow-x: auto !important;
            overflow-y: auto !important;
        }

        .ht_clone_top .wtHolder {
            overflow-x: hidden !important;
        }

        /* ── TABLA BASE ── */
        .handsontable table.htCore {
            border-collapse: separate;
            border-spacing: 0;
        }

        /* ── HEADERS DE COLUMNA ── */
        .handsontable thead th,
        .handsontable .ht_clone_top thead th,
        .handsontable .ht_clone_left thead th,
        .handsontable .ht_clone_top_left_corner thead th {
            background: #135423 !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            font-size: 11.5px !important;
            letter-spacing: 0.4px !important;
            text-transform: uppercase !important;
            padding: 10px 8px !important;
            border-right: 1px solid rgba(255, 255, 255, 0.12) !important;
            border-bottom: 2px solid #1ba333 !important;
            white-space: nowrap !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        /* Forzar color blanco en elementos internos del header */
        .handsontable thead th .colHeader,
        .handsontable thead th span,
        .handsontable thead th button,
        .handsontable .ht_clone_top thead th .colHeader,
        .handsontable .ht_clone_top thead th span {
            color: #ffffff !important;
        }

        /* ── OCULTAR BOTÓN DROPDOWN DE HEADERS ── */
        .handsontable thead th .changeType,
        .handsontable thead th button.changeType,
        .handsontable .htDropdownMenu {
            display: none !important;
        }

        /* Hover en headers */
        .handsontable thead th:hover {
            background: #1ba333 !important;
            cursor: pointer;
        }

        /* ── HEADER DE FILA (números) ── */
        .handsontable .rowHeader,
        .handsontable .ht_clone_left tbody th {
            background: #f0fff4 !important;
            color: #135423 !important;
            font-weight: 700 !important;
            font-size: 11px !important;
            border-right: 2px solid #b2dfb8 !important;
            text-align: center !important;
        }

        /* ── CELDAS BASE ── */
        .handsontable td {
            font-size: 13px !important;
            font-family: 'Segoe UI', system-ui, sans-serif !important;
            padding: 5px 10px !important;
            border-right: 1px solid #e8f0e9 !important;
            border-bottom: 1px solid #e8f0e9 !important;
            transition: background 0.15s ease;
            vertical-align: middle !important;
            white-space: nowrap !important;
            line-height: 1.3 !important;
        }

        /* ── FILAS ALTERNAS ── */
        .handsontable tr:nth-child(even) td {
            background-color: #f5fbf5 !important;
        }

        .handsontable tr:nth-child(odd) td {
            background-color: #ffffff !important;
        }

        /* ── HOVER EN FILA ── */
        .handsontable tr:hover td {
            background-color: #e8f5e9 !important;
        }

        /* ── CELDA SELECCIONADA ── */
        .handsontable td.area,
        .handsontable td.current {
            background-color: #c8e6c9 !important;
            border: 1px solid #135423 !important;
            outline: none !important;
        }

        /* ── CELDA EN EDICIÓN ── */
        .handsontable td.current.highlight {
            background-color: #b2dfb8 !important;
        }

        /* ── CELDAS READ-ONLY ── */
        .handsontable td[style*="background: rgb(222, 222, 222)"],
        .handsontable td[style*="background: #DEDEDE"],
        .handsontable td[style*="background:#DEDEDE"] {
            background-color: #e0e8e1 !important;
            color: #7a8f7b !important;
            cursor: not-allowed !important;
        }

        /* ── COLUMNAS FIJAS (Código y Nombre) ── */
        .handsontable .ht_clone_left td {
            background: #f0fff4 !important;
            border-right: 2px solid #b2dfb8 !important;
            font-weight: 600 !important;
            color: #0f4019 !important;
        }

        .handsontable .ht_clone_left tr:nth-child(even) td {
            background: #e8f5e9 !important;
        }

        .handsontable .ht_clone_left tr:hover td {
            background: #c8e6c9 !important;
        }

        /* ── CELDA INVÁLIDA (fuera de rango) ── */
        .handsontable td.htInvalid {
            background-color: #fff0f0 !important;
            border: 1px solid #ff4d4d !important;
        }

        /* ── INPUT DENTRO DE CELDA ── */
        .handsontable .handsontableInput {
            font-size: 13px !important;
            font-family: 'Segoe UI', system-ui, sans-serif !important;
            color: #0f4019 !important;
            background: #f0fff4 !important;
            border: 2px solid #135423 !important;
            border-radius: 4px !important;
            padding: 4px 8px !important;
            box-shadow: 0 0 0 3px rgba(19, 84, 35, 0.12) !important;
            outline: none !important;
        }

        /* ── CONTEXT MENU (click derecho) ── */
        .handsontable .htContextMenu {
            border-radius: 8px !important;
            box-shadow: 0 8px 24px rgba(19, 84, 35, 0.18) !important;
            border: 1px solid #b2dfb8 !important;
            overflow: hidden !important;
        }

        .handsontable .htContextMenu td {
            font-size: 12.5px !important;
            padding: 7px 14px !important;
            color: #135423 !important;
            border: none !important;
            background: #ffffff !important;
        }

        .handsontable .htContextMenu td:hover,
        .handsontable .htContextMenu tr:hover td {
            background: #e8f5e9 !important;
            color: #0f4019 !important;
        }

        /* ── SCROLLBAR PERSONALIZADO ── */
        .wtHolder::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }

        .wtHolder::-webkit-scrollbar-track {
            background: #f0fff4;
            border-radius: 4px;
        }

        .wtHolder::-webkit-scrollbar-thumb {
            background: #7bc47f;
            border-radius: 4px;
        }

        .wtHolder::-webkit-scrollbar-thumb:hover {
            background: #135423;
        }

        /* ── BORDES DE SELECCIÓN ── */
        .handsontable .wtBorder.current {
            background-color: #135423 !important;
        }

        .handsontable .wtBorder.area {
            background-color: #1ba333 !important;
        }

        /* ── CORNER (esquina superior izquierda) ── */
        .handsontable .ht_clone_top_left_corner thead th {
            background: #0f4019 !important;
        }

        /* ── ANIMACIÓN SUAVE AL CARGAR ── */
        @keyframes hotFadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@section('content')
    @foreach ($asignaturas_list as $rowObj)
        @php $row = (array) $rowObj; @endphp

        {{-- ============================================================ --}}
        {{-- ENCABEZADO                                                    --}}
        {{-- ============================================================ --}}
        <div class="row">
            <div class="col-12">
                <div class="card bg-primary" border:none;">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center gap-3">
                            <i data-feather="award" style="width:48px;height:48px;color:#fff;stroke:#fff;"></i>
                            <div>
                                <h2 class="mb-0 fw-bold text-white" style="font-size:28px;letter-spacing:1px;">
                                    CUADRO DE CALIFICACIONES
                                </h2>
                                <div class="mt-1 text-white"
                                    style="color:#ffffff;font-size:13px;font-weight:600;letter-spacing:0.5px;">
                                    <i data-feather="book-open" style="width:13px;height:13px;stroke:#ffffff;"></i>
                                    {{ strtoupper($row['carrera']) }}
                                </div>
                            </div>
                        </div>
                        <img src="{{ url(asset('/assets/images/UNAG_BLANCO.png')) }}" class="d-none d-md-block"
                            style="position:absolute; right:20px; top:50%; transform:translateY(-50%); height:60px; opacity:0.9;">
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- TARJETAS DE INFORMACIÓN                                       --}}
        {{-- ============================================================ --}}
        <div class="row g-3 mb-3">

            {{-- Asignatura --}}
            <div class="col-md-3 col-sm-6">
                <div class="card stat-card h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="stat-label mb-1"><i data-feather="book" style="width:14px;height:14px;"></i> Asignatura
                        </div>
                        <div class="stat-value" style="font-size:20px;">{{ $row['asignatura'] }}</div>
                        <div class="stat-sub mt-1">
                            <span class="badge bg-secondary"
                                style="color:#fff !important;">{{ $row['id_asignatura'] }}</span>
                            <span class="badge bg-primary ms-1">UV: {{ $row['unidades_valorativas'] }}</span>
                            {{-- <span class="badge bg-info ms-1">{{ $row['sede'] }}</span> --}}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Docente --}}
            <div class="col-md-3 col-sm-6">
                <div class="card stat-card h-100">
                    <div class="card-body d-flex flex-column justify-content-center gap-3">
                        <div>
                            <div class="stat-label mb-1">
                                <i data-feather="user" style="width:14px;height:14px;"></i> Docente
                            </div>
                            <div class="stat-value" style="font-size:18px;">{{ $row['docente'] }}</div>
                        </div>
                        <div class="border-top pt-2 d-flex gap-3">
                            <div>
                                <div class="stat-label"><i data-feather="map-pin" style="width:12px;height:12px;"></i> Sede
                                </div>
                                <small class="fw-600" style="font-size:12px;"><b>{{ strtoupper($row['sede']) }}</b></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección --}}
            <div class="col-md-3 col-sm-6">
                <div class="card stat-card h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-center gap-2">
                        <div>
                            <div class="stat-label mb-1">
                                <i data-feather="layers" style="width:14px;height:14px;"></i> Sección
                            </div>
                            <div class="stat-value">{{ $row['etiqueta_bloque'] }}</div>
                        </div>
                        <div class="border-top pt-2">
                            <div class="stat-label">Jornada</div>
                            <div class="d-flex align-items-center justify-content-center gap-1 mt-1"><b>
                                    @if ($row['jornada'] == 'NOCTURNA')
                                        <i data-feather="moon" style="width:13px;height:13px;"></i>
                                    @elseif ($row['jornada'] == 'FIN DE SEMANA')
                                        <i data-feather="umbrella" style="width:13px;height:13px;"></i>
                                    @else
                                        <i data-feather="sun" style="width:13px;height:13px;"></i>
                                    @endif
                                    <small
                                        style="font-size:11px;font-weight:600;color:#444;">{{ $row['jornada'] ?: 'DIURNA' }}</small>
                                </b>
                            </div>
                        </div>
                        <div class="border-top pt-2">
                            <div class="stat-label">Período Académico</div>
                            <div style="font-size:20px;font-weight:700;color:var(--azul);">
                                {{ $row['periodo_academico_bloque'] }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Estadísticas --}}
            <div class="col-md-3 col-sm-6">
                <div class="card stat-card h-100">
                    <div class="card-body text-center">
                        <div class="stat-label mb-1">
                            <i data-feather="users" style="width:14px;height:14px;"></i> Matriculados
                        </div>
                        <div class="stat-value">{{ $row['total_matriculados'] }}</div>
                        <div class="mt-2 d-grid gap-1" style="grid-template-columns: 1fr 1fr;">
                            <div id="lblAPR" class="rounded p-1 text-white text-center"
                                style="background:#135423;font-size:11px;font-weight:700;">
                                <i data-feather="arrow-up" style="width:11px;height:11px;stroke:#fff;"></i> APR:
                                {{ $row['aprobados'] }}
                            </div>
                            <div id="lblREP" class="rounded p-1 text-white text-center"
                                style="background:#1ba333;font-size:11px;font-weight:700;">
                                <i data-feather="arrow-down" style="width:11px;height:11px;stroke:#fff;"></i> REP:
                                {{ $row['reprobados'] }}
                            </div>
                            <div id="lblNSP" class="rounded p-1 text-white text-center"
                                style="background:#2d7a3a;font-size:11px;font-weight:700;">
                                — NSP: {{ $row['nsp'] }}
                            </div>
                            <div id="lblABD" class="rounded p-1 text-white text-center"
                                style="background:#4a9e57;font-size:11px;font-weight:700;">
                                — ABD: {{ $row['abd'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ============================================================ --}}
        {{-- ESTADO DEL PERIODO + CALENDARIO                               --}}
        {{-- ============================================================ --}}
        <div class="row g-3 mb-3">

            {{-- Banner periodo abierto/cerrado --}}
            <div class="col-md-3">
                <div id="divInfoCerrado"
                    class="periodo-banner periodo-cerrado @if ($tieneAccesoGuardarCalificacionesAsignaturas == 1) d-none @endif">
                    <i data-feather="lock" style="width:22px;height:22px;"></i>
                    <div>
                        <div>PERIODO CERRADO</div>
                        <small style="font-weight:400;">No hay periodo de calificaciones aperturado</small>
                    </div>
                </div>
                <div id="divInfoAperturado"
                    class="periodo-banner periodo-abierto @if ($tieneAccesoGuardarCalificacionesAsignaturas != 1) d-none @endif">
                    <i data-feather="unlock" style="width:22px;height:22px;"></i>
                    <div>
                        <div>PERIODO ABIERTO</div>
                        <small style="font-weight:400;">Registro de calificaciones habilitado</small>
                    </div>
                </div>
            </div>

            {{-- Calendario de periodos --}}
            <div class="col-md-5">
                <div class="card border-secondary h-100">
                    <div class="card-header bg-primary text-white py-2">
                        <h6 class="mb-0 text-white">
                            <i data-feather="calendar" style="width:16px;height:16px;"></i>
                            Períodos de Subida de Calificaciones
                        </h6>
                    </div>
                    <div class="card-body py-2">
                        @foreach ($calendario_calificaciones_asignatura as $row2Obj)
                            @php $row2 = (array) $row2Obj; @endphp
                            <div class="calendario-item {{ $row2['periodo_actual'] }}">
                                <i data-feather="clock" style="width:12px;height:12px;"></i>
                                Del {{ $row2['fecha_inicial'] }} al {{ $row2['fecha_final'] }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Temporizador --}}
            <div class="col-md-4">
                <div class="card border-secondary h-100">
                    <div class="card-header bg-primary text-white py-2">
                        <h6 class="mb-0 text-white">
                            <i data-feather="clock" style="width:16px;height:16px;"></i>
                            Tiempo Restante
                        </h6>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div class="text-center">
                            <i data-feather="clock" style="width:40px;height:40px;color:var(--verdeOscuro);"></i>
                            <div id="temporizador" class="mt-2">Cargando...</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ============================================================ --}}
        {{-- BARRA DE ACCIONES + HANDSONTABLE                             --}}
        {{-- ============================================================ --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-verdeClaro text-white d-flex justify-content-between align-items-center">
                        <h5 class=" mb-0">
                            <i data-feather="edit-3" class="icon-lg pb-3px"></i> Cuadro de Calificaciones
                        </h5>
                    </div>
                    <div class="card-body">

                        {{-- Toolbar --}}
                        <div class="acciones-toolbar">
                            <a class="btn bg-azul btn-sm" id="btnRegresar"
                                href="{{ url('/') }}/docentes/cargaAcademica">
                                <i data-feather="arrow-left" style="width:15px;height:15px;"></i> Regresar
                            </a>
                            <a class="btn btn-warning btn-sm" id="btn_aca_seccion_comentario">
                                <i data-feather="message-square" style="width:15px;height:15px;"></i> Observaciones
                            </a>
                            <a class="btn btn-primary btn-sm" id="btnCuadroCalificaciones" target="_blank"
                                {{-- onclick="guardarCalificaciones()" --}}
                                href="{{ url('/docentes/' . $row['id_empleado'] . '/secciones/' . $seccionId . '/calificaciones/' . $row['id_asignatura'] . '/cuadro-calificaciones') }}">
                                <i data-feather="file-text" style="width:15px;height:15px;"></i> Cuadro PDF
                            </a>
                            @if ($tieneAccesoGuardarCalificacionesAsignaturas == 1 && $currentUserId == $docenteId)
                                <a class="btn bg-azul btn-sm" id="btnGuardarCalificaciones">
                                    <i data-feather="save" style="width:15px;height:15px;"></i> Guardar
                                </a>
                            @endif
                        </div>

                        {{-- Handsontable --}}
                        <div id="hot"></div>

                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- MODAL OBSERVACIONES (comentario de sección)                   --}}
        {{-- ============================================================ --}}
        <div class="modal fade" id="modal_aca_seccion_comentario" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h6 class="modal-title text-white">
                            <i data-feather="message-square" class="icon-lg pb-3px"></i> Observaciones de la Sección
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">

                        {{-- Accordion Comentarios existentes --}}
                        <div class="accordion mb-3" id="accordionComentarios">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseComentarios">
                                        <i data-feather="list" style="width:15px;height:15px;" class="me-2"></i>
                                        Comentarios registrados
                                    </button>
                                </h2>
                                <div id="collapseComentarios" class="accordion-collapse collapse">
                                    <div class="accordion-body p-2">
                                        <div class="table-responsive">
                                            <table class="jambo_table table table-hover table-sm"
                                                id="tbl_aca_seccion_comentario" border="1">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th class="text-white">Id</th>
                                                        <th class="text-white">Sección</th>
                                                        <th class="text-white">Observación</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($aca_seccion_comentario_list as $rowComentarioObj)
                                                        @php $rowComentario = (array) $rowComentarioObj; @endphp
                                                        <tr>
                                                            <td>{{ $rowComentario['id'] }}</td>
                                                            <td>{{ $rowComentario['id_seccion'] }}</td>
                                                            <td>{{ $rowComentario['texto_comentario'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseNuevaObs">
                                        <i data-feather="plus-circle" style="width:15px;height:15px;" class="me-2"></i>
                                        Agregar Observación
                                    </button>
                                </h2>
                                <div id="collapseNuevaObs" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <textarea class="form-control" id="texto_comentario" name="texto_comentario" rows="4"
                                            placeholder="Escriba aquí la observación..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer bg-secondary">
                        <button type="button" class="btn btn-danger btn-xs" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" id="btn_guardar_aca_seccion_comentario" class="btn btn-primary btn-xs">
                            <i data-feather="save" style="width:14px;height:14px;"></i> Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL OBSERVACIONES GENERALES (frmAcaSeccion) --}}
        <div class="modal fade" id="frmAcaSeccion" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h6 class="modal-title text-white">
                            <i data-feather="file-text" class="icon-lg pb-3px"></i> Observaciones del Cuadro
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <textarea name="txtObservacion" id="txtObservacion" class="form-control" rows="5"
                            placeholder="Observaciones...">{{ $row['observaciones'] }}</textarea>
                        <small class="text-muted mt-2 d-block">
                            <i data-feather="info" style="width:13px;height:13px;"></i>
                            Las observaciones ingresadas serán visualizables en el cuadro impreso de calificaciones.
                        </small>
                    </div>
                    <div class="modal-footer bg-secondary">
                        <button type="button" class="btn btn-danger btn-xs" id="btnCerrarFrmAcaSeccion"
                            data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn-xs" id="btnGuardarFrmAcaSeccion">
                            <i data-feather="save" style="width:14px;height:14px;"></i> Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL ELIMINAR COMENTARIO --}}
        <div class="modal fade" id="modal_eliminar_aca_seccion_comentario" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title text-white">
                            <i data-feather="trash-2" class="icon-lg pb-3px"></i> Eliminar Registro
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body text-center py-4">
                        <i data-feather="alert-circle" class="text-warning" style="width:60px;height:60px;"></i>
                        <h5 class="mt-3"><strong>¿Seguro que desea eliminar este registro?</strong></h5>
                        <p class="text-muted">Esta acción no se puede revertir.</p>
                    </div>
                    <div class="modal-footer bg-secondary">
                        <button type="button" class="btn btn-secondary btn-xs" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="btn_eliminar_aca_seccion_comentario" class="btn btn-danger btn-xs">
                            <i data-feather="trash-2" style="width:14px;height:14px;"></i> Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('js/handsontable.full.js') }}"></script>
    <script src="{{ asset('js/all.min.js') }}"></script>

    @foreach ($asignaturas_list as $rowObj)
        @php $row = (array) $rowObj; @endphp
        <script type="text/javascript">
            var idEstadoAbandono = 4;
            var idEstadoNoSePresento = 3;
            var idEstadoReprobado = 1;

            var urlguardarObservaciones = "{{ url('docentes/secciones/' . $seccionId . '/guardarObservaciones') }}";
            var url_guardar_aca_seccion_comentario = "{{ url('docentes/secciones/obs-comentarios') }}/guardar";

            var accion = null;
            var id = null;
            var texto_comentario = null;
            var table = null;
            var rowNumber = null;
            var matriculados = null;
            var hot = null;
            var dataOutput = null;
            var gradeValidator = null;
            var txtObservaciones = null;
            var filasConError = new Set();
            var _toastErrorTimeout = null;
            var hayChangios = false;
            var navegandoConPermiso = false;

            var columnaNotaFinal =
                3 +
                @if ($row['nota_nombre_1'] != null)
                    1
                @else
                    0
                @endif +
            @if ($row['nota_nombre_2'] != null)
                1
            @else
                0
            @endif +
            @if ($row['nota_nombre_3'] != null)
                1
            @else
                0
            @endif +
            @if ($row['nota_nombre_4'] != null)
                1
            @else
                0
            @endif +
            @if ($row['nota_nombre_5'] != null)
                1
            @else
                0
            @endif +
            @if ($row['nota_nombre_6'] != null)
                1
            @else
                0
            @endif +
            @if ($row['nota_nombre_7'] != null)
                1
            @else
                0
            @endif +
            @if ($row['nota_nombre_8'] != null)
                1
            @else
                0
            @endif +
            @if ($row['nota_nombre_9'] != null)
                1
            @else
                0
            @endif +
            @if ($row['nota_nombre_10'] != null)
                1
            @else
                0
            @endif +
            @if ($row['nota_nombre_11'] != null)
                1
            @else
                0
            @endif +
            @if ($row['nota_nombre_12'] != null)
                1
            @else
                0
            @endif +
            @if ($row['nota_nombre_13'] != null)
                1
            @else
                0
            @endif +
            @if ($row['nota_nombre_14'] != null)
                1
            @else
                0
            @endif +
            @if ($row['nota_nombre_15'] != null)
                1
            @else
                0
            @endif ;

            var columnaEstadoCalificacion = columnaNotaFinal + 1;
            var columnaRecuperacion = columnaNotaFinal - 1;

            $(document).ready(function() {
                espera('Cargando calificaciones...');

                var form_data = {
                    seccionId: {{ $seccionId }},
                    idDocente: {{ $docenteId }}
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#modal_aca_seccion_comentario').on('shown.bs.modal', function() {
                    if (table == null) {
                        table = $("#tbl_aca_seccion_comentario").DataTable({
                            destroy: true
                        });
                    }
                });

                // ----- Observaciones generales (frmAcaSeccion) -----
                $('#btnGuardarFrmAcaSeccion').on('click', function() {
                    txtObservaciones = $('#txtObservacion').val();
                    $.ajax({
                        type: 'post',
                        url: urlguardarObservaciones,
                        data: {
                            'observaciones': txtObservaciones,
                            'seccionId': {{ $seccionId }}
                        },
                        success: function(data) {
                            if (data.msgError != null) {
                                Swal.fire('Error', data.msgError, 'error');
                            } else {
                                $('#frmAcaSeccion').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Guardado',
                                    text: data.msgSuccess,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                });

                // ----- gradeValidator -----
                gradeValidator = function(value, callback) {
                    callback(value >= 0 && value <= 100);
                };

                // ----- Cargar matriculados → Handsontable -----
                $.ajax({
                    url: "{{ url('docentes/obtener-matriculados-seccion') }}",
                    type: 'post',
                    data: form_data,
                    success: function(data) {

                        @if ($tieneAsignaturasLaboratorioGrupo == 1)
                            matriculados = data.matriculados.filter(d => d.modalidad_laboratorio_grupo ==
                                true);
                        @else
                            matriculados = data.matriculados;
                        @endif

                        var hotElement = document.querySelector('#hot');
                        var hotSettings = {
                            data: matriculados,
                            columns: [{
                                    data: 'numero_registro_estudiante',
                                    type: 'text',
                                    readOnly: true
                                },
                                {
                                    data: 'nombre_completo_por_apellido',
                                    type: 'text',
                                    readOnly: true
                                },
                                @if ($row['nota_nombre_1'] != null)
                                    {
                                        data: 'nota_1',
                                        type: 'numeric',
                                        @if ($currentUserId != $row['docente_calificador_1'] || $tieneAccesoGuardarCalificacionesAsignaturas != 1)
                                            readOnly: true,
                                        @else
                                            readOnly: false,
                                        @endif
                                        numericFormat: {
                                            pattern: '0.00'
                                        },
                                        validator: gradeValidator
                                    },
                                @endif
                                @if ($row['nota_nombre_2'] != null)
                                    {
                                        data: 'nota_2',
                                        type: 'numeric',
                                        @if ($currentUserId != $row['docente_calificador_2'] || $tieneAccesoGuardarCalificacionesAsignaturas != 1)
                                            readOnly: true,
                                        @else
                                            readOnly: false,
                                        @endif
                                        numericFormat: {
                                            pattern: '0.00'
                                        },
                                        validator: gradeValidator
                                    },
                                @endif
                                @if ($row['nota_nombre_3'] != null)
                                    {
                                        data: 'nota_3',
                                        type: 'numeric',
                                        @if ($currentUserId != $row['docente_calificador_3'] || $tieneAccesoGuardarCalificacionesAsignaturas != 1)
                                            @if ($tieneAsignaturasLaboratorioGrupo != 1)
                                                readOnly: true,
                                            @else
                                                readOnly: false,
                                            @endif
                                        @else
                                            readOnly: false,
                                        @endif
                                        numericFormat: {
                                            pattern: '0.00'
                                        },
                                        validator: gradeValidator
                                    },
                                @endif
                                @if ($row['nota_nombre_4'] != null)
                                    {
                                        data: 'nota_4',
                                        type: 'numeric',
                                        @if ($currentUserId != $row['docente_calificador_4'] || $tieneAccesoGuardarCalificacionesAsignaturas != 1)
                                            readOnly: true,
                                        @else
                                            readOnly: false,
                                        @endif
                                        numericFormat: {
                                            pattern: '0.00'
                                        },
                                        validator: gradeValidator
                                    },
                                @endif
                                @if ($row['nota_nombre_5'] != null)
                                    {
                                        data: 'nota_5',
                                        type: 'numeric',
                                        @if ($currentUserId != $row['docente_calificador_5'] || $tieneAccesoGuardarCalificacionesAsignaturas != 1)
                                            readOnly: true,
                                        @else
                                            readOnly: false,
                                        @endif
                                        numericFormat: {
                                            pattern: '0.00'
                                        },
                                        validator: gradeValidator
                                    },
                                @endif
                                @if ($row['nota_nombre_6'] != null)
                                    {
                                        data: 'nota_6',
                                        type: 'numeric',
                                        @if ($currentUserId != $row['docente_calificador_6'] || $tieneAccesoGuardarCalificacionesAsignaturas != 1)
                                            readOnly: true,
                                        @else
                                            readOnly: false,
                                        @endif
                                        numericFormat: {
                                            pattern: '0.00'
                                        },
                                        validator: gradeValidator
                                    },
                                @endif
                                @if ($row['nota_nombre_7'] != null)
                                    {
                                        data: 'nota_7',
                                        type: 'numeric',
                                        @if ($currentUserId != $row['docente_calificador_7'] || $tieneAccesoGuardarCalificacionesAsignaturas != 1)
                                            @if ($tieneAsignaturasLaboratorioGrupo != 1)
                                                readOnly: true,
                                            @else
                                                readOnly: false,
                                            @endif
                                        @else
                                            readOnly: false,
                                        @endif
                                        numericFormat: {
                                            pattern: '0.00'
                                        },
                                        validator: gradeValidator
                                    },
                                @endif
                                @if ($row['nota_nombre_8'] != null)
                                    {
                                        data: 'nota_8',
                                        type: 'numeric',
                                        @if ($currentUserId != $row['docente_calificador_8'] || $tieneAccesoGuardarCalificacionesAsignaturas != 1)
                                            readOnly: true,
                                        @else
                                            readOnly: false,
                                        @endif
                                        numericFormat: {
                                            pattern: '0.00'
                                        },
                                        validator: gradeValidator
                                    },
                                @endif
                                @if ($row['nota_nombre_9'] != null)
                                    {
                                        data: 'nota_9',
                                        type: 'numeric',
                                        @if ($currentUserId != $row['docente_calificador_9'] || $tieneAccesoGuardarCalificacionesAsignaturas != 1)
                                            readOnly: true,
                                        @else
                                            readOnly: false,
                                        @endif
                                        numericFormat: {
                                            pattern: '0.00'
                                        },
                                        validator: gradeValidator
                                    },
                                @endif
                                @if ($row['nota_nombre_10'] != null)
                                    {
                                        data: 'nota_10',
                                        type: 'numeric',
                                        @if ($currentUserId != $row['docente_calificador_10'] || $tieneAccesoGuardarCalificacionesAsignaturas != 1)
                                            readOnly: true,
                                        @else
                                            readOnly: false,
                                        @endif
                                        numericFormat: {
                                            pattern: '0.00'
                                        },
                                        validator: gradeValidator
                                    },
                                @endif
                                @if ($row['nota_nombre_11'] != null)
                                    {
                                        data: 'nota_11',
                                        type: 'numeric',
                                        @if ($currentUserId != $row['docente_calificador_11'] || $tieneAccesoGuardarCalificacionesAsignaturas != 1)
                                            @if ($tieneAsignaturasLaboratorioGrupo != 1)
                                                readOnly: true,
                                            @else
                                                readOnly: false,
                                            @endif
                                        @else
                                            readOnly: false,
                                        @endif
                                        numericFormat: {
                                            pattern: '0.00'
                                        },
                                        validator: gradeValidator
                                    },
                                @endif
                                @if ($row['nota_nombre_12'] != null)
                                    {
                                        data: 'nota_12',
                                        type: 'numeric',
                                        @if ($currentUserId != $row['docente_calificador_12'] || $tieneAccesoGuardarCalificacionesAsignaturas != 1)
                                            readOnly: true,
                                        @else
                                            readOnly: false,
                                        @endif
                                        numericFormat: {
                                            pattern: '0.00'
                                        },
                                        validator: gradeValidator
                                    },
                                @endif
                                @if ($row['nota_nombre_13'] != null)
                                    {
                                        data: 'nota_13',
                                        type: 'numeric',
                                        @if ($currentUserId != $row['docente_calificador_13'] || $tieneAccesoGuardarCalificacionesAsignaturas != 1)
                                            readOnly: true,
                                        @else
                                            readOnly: false,
                                        @endif
                                        numericFormat: {
                                            pattern: '0.00'
                                        },
                                        validator: gradeValidator
                                    },
                                @endif
                                @if ($row['nota_nombre_14'] != null)
                                    {
                                        data: 'nota_14',
                                        type: 'numeric',
                                        @if ($currentUserId != $row['docente_calificador_14'] || $tieneAccesoGuardarCalificacionesAsignaturas != 1)
                                            readOnly: true,
                                        @else
                                            readOnly: false,
                                        @endif
                                        numericFormat: {
                                            pattern: '0.00'
                                        },
                                        validator: gradeValidator
                                    },
                                @endif
                                @if ($row['nota_nombre_15'] != null)
                                    {
                                        data: 'nota_15',
                                        type: 'numeric',
                                        @if ($currentUserId != $row['docente_calificador_15'] || $tieneAccesoGuardarCalificacionesAsignaturas != 1)
                                            readOnly: true,
                                        @else
                                            readOnly: false,
                                        @endif
                                        numericFormat: {
                                            pattern: '0.00'
                                        },
                                        validator: gradeValidator
                                    },
                                @endif {
                                    data: 'recuperacion',
                                    type: 'numeric',
                                    @if ($currentUserId != $row['id_docente_titular'] || $tieneAccesoGuardarCalificacionesAsignaturas != 1)
                                        readOnly: true,
                                    @else
                                        readOnly: false,
                                    @endif
                                    numericFormat: {
                                        pattern: '0.00'
                                    },
                                    validator: gradeValidator
                                },
                                {
                                    data: 'nota',
                                    type: 'numeric',
                                    readOnly: true,
                                    validator: gradeValidator
                                },
                                {
                                    data: 'estado_calificacion',
                                    type: 'text',
                                    readOnly: true
                                }
                            ],
                            stretchH: 'all',
                            renderAllRows: false,
                            width: '100%',
                            height: 'auto',
                            preventOverflow: 'horizontal',
                            fixedColumnsLeft: 2,
                            autoWrapRow: true,
                            maxRows: 1000,
                            manualRowResize: true,
                            manualColumnResize: true,
                            cells: function(row, col) {
                                var cellProperties = {};
                                var idEstadoForzadoCell = matriculados[row][
                                    'id_estado_calificacion_forzado'
                                ];
                                if (idEstadoForzadoCell > 0 && idEstadoForzadoCell != 5) {
                                    cellProperties.renderer = 'estadoForzadoRenderer';
                                } else if (idEstadoForzadoCell == 5) {
                                    cellProperties.renderer = 'sancionadoRenderer';
                                } else {
                                    cellProperties.renderer = 'defaultRenderer';
                                }
                                return cellProperties;
                            },
                            @if (
                                $tieneAccesoGuardarCalificacionesAsignaturas == 1 &&
                                    ($currentUserId == $row['docente_calificador_1'] ||
                                        $currentUserId == $row['docente_calificador_2']))
                                contextMenu: {
                                    items: {
                                        'no_se_presento': {
                                            name: 'Forzar No Se Presentó',
                                            callback: function(src, changes) {
                                                var row = hot.getSelected()[0][0];
                                                if (matriculados[row][
                                                        'id_estado_calificacion_forzado'
                                                    ] == 5) {
                                                    alert('¡Estudiante sancionado!');
                                                    return;
                                                }
                                                matriculados[row][
                                                        'id_estado_calificacion_forzado'
                                                    ] =
                                                    idEstadoNoSePresento;
                                                hot.setDataAtCell(row, columnaNotaFinal, 0);
                                                hot.setDataAtCell(row, columnaEstadoCalificacion,
                                                    'NSP');
                                            }
                                        },
                                        'reprobado': {
                                            name: 'Forzar Reprobado',
                                            callback: function(src, changes) {
                                                var row = hot.getSelected()[0][0];
                                                if (matriculados[row][
                                                        'id_estado_calificacion_forzado'
                                                    ] == 5) {
                                                    alert('¡Estudiante sancionado!');
                                                    return;
                                                }
                                                matriculados[row][
                                                        'id_estado_calificacion_forzado'
                                                    ] =
                                                    idEstadoReprobado;
                                                hot.setDataAtCell(row, columnaNotaFinal, 0);
                                                hot.setDataAtCell(row, columnaEstadoCalificacion,
                                                    'REP');
                                            }
                                        },
                                        'abandono': {
                                            name: 'Forzar Abandono',
                                            callback: function(src, changes) {
                                                var row = hot.getSelected()[0][0];
                                                if (matriculados[row][
                                                        'id_estado_calificacion_forzado'
                                                    ] == 5) {
                                                    alert('¡Estudiante sancionado!');
                                                    return;
                                                }
                                                matriculados[row][
                                                        'id_estado_calificacion_forzado'
                                                    ] =
                                                    idEstadoAbandono;
                                                hot.setDataAtCell(row, columnaNotaFinal, 0);
                                                hot.setDataAtCell(row, columnaEstadoCalificacion,
                                                    'ABD');
                                            }
                                        },
                                        'clear': {
                                            name: 'Quitar Estado Forzado',
                                            callback: function(src, changes) {
                                                var row = hot.getSelected()[0][0];
                                                if (matriculados[row][
                                                        'id_estado_calificacion_forzado'
                                                    ] == 5) {
                                                    alert('¡Estudiante sancionado!');
                                                    return;
                                                }
                                                matriculados[row][
                                                    'id_estado_calificacion_forzado'
                                                ] = null;
                                                hot.setDataAtCell(row, columnaNotaFinal, 0);
                                                hot.setDataAtCell(row, columnaEstadoCalificacion,
                                                    null);
                                            }
                                        },
                                        sp1: '---------',
                                        'sancion': {
                                            name() {
                                                return '<b><i class="fa fa-exclamation-triangle text-danger"></i> Ver sanciones</b>';
                                            },
                                            callback: function(src, changes) {
                                                var row = hot.getSelected()[0][0];
                                                alert(matriculados[row]['sancion']);
                                            }
                                        }
                                    }
                                },
                            @endif
                            rowHeaders: true,
                            colHeaders: [
                                'Código', 'Nombre',
                                @if ($row['nota_nombre_1'] != null)
                                    "{{ $row['nota_nombre_1'] }}({{ $row['nota_maxima_1'] }})",
                                @endif
                                @if ($row['nota_nombre_2'] != null)
                                    "{{ $row['nota_nombre_2'] }}({{ $row['nota_maxima_2'] }})",
                                @endif
                                @if ($row['nota_nombre_3'] != null)
                                    "{{ $row['nota_nombre_3'] }}({{ $row['nota_maxima_3'] }})",
                                @endif
                                @if ($row['nota_nombre_4'] != null)
                                    "{{ $row['nota_nombre_4'] }}({{ $row['nota_maxima_4'] }})",
                                @endif
                                @if ($row['nota_nombre_5'] != null)
                                    "{{ $row['nota_nombre_5'] }}({{ $row['nota_maxima_5'] }})",
                                @endif
                                @if ($row['nota_nombre_6'] != null)
                                    "{{ $row['nota_nombre_6'] }}({{ $row['nota_maxima_6'] }})",
                                @endif
                                @if ($row['nota_nombre_7'] != null)
                                    "{{ $row['nota_nombre_7'] }}({{ $row['nota_maxima_7'] }})",
                                @endif
                                @if ($row['nota_nombre_8'] != null)
                                    "{{ $row['nota_nombre_8'] }}({{ $row['nota_maxima_8'] }})",
                                @endif
                                @if ($row['nota_nombre_9'] != null)
                                    "{{ $row['nota_nombre_9'] }}({{ $row['nota_maxima_9'] }})",
                                @endif
                                @if ($row['nota_nombre_10'] != null)
                                    "{{ $row['nota_nombre_10'] }}({{ $row['nota_maxima_10'] }})",
                                @endif
                                @if ($row['nota_nombre_11'] != null)
                                    "{{ $row['nota_nombre_11'] }}({{ $row['nota_maxima_11'] }})",
                                @endif
                                @if ($row['nota_nombre_12'] != null)
                                    "{{ $row['nota_nombre_12'] }}({{ $row['nota_maxima_12'] }})",
                                @endif
                                @if ($row['nota_nombre_13'] != null)
                                    "{{ $row['nota_nombre_13'] }}({{ $row['nota_maxima_13'] }})",
                                @endif
                                @if ($row['nota_nombre_14'] != null)
                                    "{{ $row['nota_nombre_14'] }}({{ $row['nota_maxima_14'] }})",
                                @endif
                                @if ($row['nota_nombre_15'] != null)
                                    "{{ $row['nota_nombre_15'] }}({{ $row['nota_maxima_15'] }})",
                                @endif
                                'REC', 'NOTA FINAL', 'ESTADO'
                            ],
                            manualRowMove: true,
                            manualColumnMove: true,
                            filters: true,
                            //dropdownMenu: true,
                            afterChange: function(changes, source) {
                                if (source === 'loadData') return;
                                hayChangios = true;
                                changes.forEach(([row, prop, oldValue, newValue]) => {
                                    if (prop == 'nota' || prop == 'estado_calificacion')
                                        return;

                                    var eval1 = null,
                                        eval2 = null,
                                        eval3 = null,
                                        eval4 = null,
                                        eval5 = null,
                                        eval6 = null,
                                        eval7 = null,
                                        eval8 = null,
                                        eval9 = null,
                                        eval10 = null,
                                        eval11 = null,
                                        eval12 = null,
                                        eval13 = null,
                                        eval14 = null,
                                        eval15 = null;
                                    var totalAcumulativo = [0, 0, 0, 0],
                                        totalEvaluacion = [0, 0, 0, 0],
                                        totalLaboratorio = [0, 0, 0, 0],
                                        totalReposicion = [0, 0, 0, 0],
                                        totalParcial = [0, 0, 0, 0];

                                    @if ($row['nota_nombre_1'] != null)
                                        eval1 = this.getDataAtCell(row, 2);
                                        if (eval1 === '') {
                                            eval1 = null;
                                        }
                                        @if ($row['nota_parcial_1'] != null)
                                            if (eval1 != null && eval1 >= 0 && eval1 <=
                                                100) {
                                                @if ($row['nota_tipo_evaluacion_1'] == 1)
                                                    totalAcumulativo[
                                                        {{ $row['nota_parcial_1'] }} -
                                                        1] += parseFloat(
                                                        eval1);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_1'] == 2)
                                                    totalEvaluacion[
                                                        {{ $row['nota_parcial_1'] }} -
                                                        1] += parseFloat(
                                                        eval1);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_1'] == 3)
                                                    totalLaboratorio[
                                                        {{ $row['nota_parcial_1'] }} -
                                                        1] += parseFloat(
                                                        eval1);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_1'] == 4)
                                                    totalReposicion[
                                                        {{ $row['nota_parcial_1'] }} -
                                                        1] += parseFloat(
                                                        eval1);
                                                @endif
                                            }
                                        @endif
                                    @endif
                                    @if ($row['nota_nombre_2'] != null)
                                        eval2 = this.getDataAtCell(row, 3);
                                        if (eval2 === '') {
                                            eval2 = null;
                                        }
                                        @if ($row['nota_parcial_2'] != null)
                                            if (eval2 != null && eval2 >= 0 && eval2 <=
                                                100) {
                                                @if ($row['nota_tipo_evaluacion_2'] == 1)
                                                    totalAcumulativo[
                                                        {{ $row['nota_parcial_2'] }} -
                                                        1] += parseFloat(
                                                        eval2);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_2'] == 2)
                                                    totalEvaluacion[
                                                        {{ $row['nota_parcial_2'] }} -
                                                        1] += parseFloat(
                                                        eval2);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_2'] == 3)
                                                    totalLaboratorio[
                                                        {{ $row['nota_parcial_2'] }} -
                                                        1] += parseFloat(
                                                        eval2);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_2'] == 4)
                                                    totalReposicion[
                                                        {{ $row['nota_parcial_2'] }} -
                                                        1] += parseFloat(
                                                        eval2);
                                                @endif
                                            }
                                        @endif
                                    @endif
                                    @if ($row['nota_nombre_3'] != null)
                                        eval3 = this.getDataAtCell(row, 4);
                                        if (eval3 === '') {
                                            eval3 = null;
                                        }
                                        @if ($row['nota_parcial_3'] != null)
                                            if (eval3 != null && eval3 >= 0 && eval3 <=
                                                100) {
                                                @if ($row['nota_tipo_evaluacion_3'] == 1)
                                                    totalAcumulativo[
                                                        {{ $row['nota_parcial_3'] }} -
                                                        1] += parseFloat(
                                                        eval3);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_3'] == 2)
                                                    totalEvaluacion[
                                                        {{ $row['nota_parcial_3'] }} -
                                                        1] += parseFloat(
                                                        eval3);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_3'] == 3)
                                                    totalLaboratorio[
                                                        {{ $row['nota_parcial_3'] }} -
                                                        1] += parseFloat(
                                                        eval3);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_3'] == 4)
                                                    totalReposicion[
                                                        {{ $row['nota_parcial_3'] }} -
                                                        1] += parseFloat(
                                                        eval3);
                                                @endif
                                            }
                                        @endif
                                    @endif
                                    @if ($row['nota_nombre_4'] != null)
                                        eval4 = this.getDataAtCell(row, 5);
                                        if (eval4 === '') {
                                            eval4 = null;
                                        }
                                        @if ($row['nota_parcial_4'] != null)
                                            if (eval4 != null && eval4 >= 0 && eval4 <=
                                                100) {
                                                @if ($row['nota_tipo_evaluacion_4'] == 1)
                                                    totalAcumulativo[
                                                        {{ $row['nota_parcial_4'] }} -
                                                        1] += parseFloat(
                                                        eval4);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_4'] == 2)
                                                    totalEvaluacion[
                                                        {{ $row['nota_parcial_4'] }} -
                                                        1] += parseFloat(
                                                        eval4);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_4'] == 3)
                                                    totalLaboratorio[
                                                        {{ $row['nota_parcial_4'] }} -
                                                        1] += parseFloat(
                                                        eval4);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_4'] == 4)
                                                    totalReposicion[
                                                        {{ $row['nota_parcial_4'] }} -
                                                        1] += parseFloat(
                                                        eval4);
                                                @endif
                                            }
                                        @endif
                                    @endif
                                    @if ($row['nota_nombre_5'] != null)
                                        eval5 = this.getDataAtCell(row, 6);
                                        if (eval5 === '') {
                                            eval5 = null;
                                        }
                                        @if ($row['nota_parcial_5'] != null)
                                            if (eval5 != null && eval5 >= 0 && eval5 <=
                                                100) {
                                                @if ($row['nota_tipo_evaluacion_5'] == 1)
                                                    totalAcumulativo[
                                                        {{ $row['nota_parcial_5'] }} -
                                                        1] += parseFloat(
                                                        eval5);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_5'] == 2)
                                                    totalEvaluacion[
                                                        {{ $row['nota_parcial_5'] }} -
                                                        1] += parseFloat(
                                                        eval5);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_5'] == 3)
                                                    totalLaboratorio[
                                                        {{ $row['nota_parcial_5'] }} -
                                                        1] += parseFloat(
                                                        eval5);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_5'] == 4)
                                                    totalReposicion[
                                                        {{ $row['nota_parcial_5'] }} -
                                                        1] += parseFloat(
                                                        eval5);
                                                @endif
                                            }
                                        @endif
                                    @endif
                                    @if ($row['nota_nombre_6'] != null)
                                        eval6 = this.getDataAtCell(row, 7);
                                        if (eval6 === '') {
                                            eval6 = null;
                                        }
                                        @if ($row['nota_parcial_6'] != null)
                                            if (eval6 != null && eval6 >= 0 && eval6 <=
                                                100) {
                                                @if ($row['nota_tipo_evaluacion_6'] == 1)
                                                    totalAcumulativo[
                                                        {{ $row['nota_parcial_6'] }} -
                                                        1] += parseFloat(
                                                        eval6);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_6'] == 2)
                                                    totalEvaluacion[
                                                        {{ $row['nota_parcial_6'] }} -
                                                        1] += parseFloat(
                                                        eval6);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_6'] == 3)
                                                    totalLaboratorio[
                                                        {{ $row['nota_parcial_6'] }} -
                                                        1] += parseFloat(
                                                        eval6);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_6'] == 4)
                                                    totalReposicion[
                                                        {{ $row['nota_parcial_6'] }} -
                                                        1] += parseFloat(
                                                        eval6);
                                                @endif
                                            }
                                        @endif
                                    @endif
                                    @if ($row['nota_nombre_7'] != null)
                                        eval7 = this.getDataAtCell(row, 8);
                                        if (eval7 === '') {
                                            eval7 = null;
                                        }
                                        @if ($row['nota_parcial_7'] != null)
                                            if (eval7 != null && eval7 >= 0 && eval7 <=
                                                100) {
                                                @if ($row['nota_tipo_evaluacion_7'] == 1)
                                                    totalAcumulativo[
                                                        {{ $row['nota_parcial_7'] }} -
                                                        1] += parseFloat(
                                                        eval7);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_7'] == 2)
                                                    totalEvaluacion[
                                                        {{ $row['nota_parcial_7'] }} -
                                                        1] += parseFloat(
                                                        eval7);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_7'] == 3)
                                                    totalLaboratorio[
                                                        {{ $row['nota_parcial_7'] }} -
                                                        1] += parseFloat(
                                                        eval7);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_7'] == 4)
                                                    totalReposicion[
                                                        {{ $row['nota_parcial_7'] }} -
                                                        1] += parseFloat(
                                                        eval7);
                                                @endif
                                            }
                                        @endif
                                    @endif
                                    @if ($row['nota_nombre_8'] != null)
                                        eval8 = this.getDataAtCell(row, 9);
                                        if (eval8 === '') {
                                            eval8 = null;
                                        }
                                        @if ($row['nota_parcial_8'] != null)
                                            if (eval8 != null && eval8 >= 0 && eval8 <=
                                                100) {
                                                @if ($row['nota_tipo_evaluacion_8'] == 1)
                                                    totalAcumulativo[
                                                        {{ $row['nota_parcial_8'] }} -
                                                        1] += parseFloat(
                                                        eval8);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_8'] == 2)
                                                    totalEvaluacion[
                                                        {{ $row['nota_parcial_8'] }} -
                                                        1] += parseFloat(
                                                        eval8);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_8'] == 3)
                                                    totalLaboratorio[
                                                        {{ $row['nota_parcial_8'] }} -
                                                        1] += parseFloat(
                                                        eval8);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_8'] == 4)
                                                    totalReposicion[
                                                        {{ $row['nota_parcial_8'] }} -
                                                        1] += parseFloat(
                                                        eval8);
                                                @endif
                                            }
                                        @endif
                                    @endif
                                    @if ($row['nota_nombre_9'] != null)
                                        eval9 = this.getDataAtCell(row, 10);
                                        if (eval9 === '') {
                                            eval9 = null;
                                        }
                                        @if ($row['nota_parcial_9'] != null)
                                            if (eval9 != null && eval9 >= 0 && eval9 <=
                                                100) {
                                                @if ($row['nota_tipo_evaluacion_9'] == 1)
                                                    totalAcumulativo[
                                                        {{ $row['nota_parcial_9'] }} -
                                                        1] += parseFloat(
                                                        eval9);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_9'] == 2)
                                                    totalEvaluacion[
                                                        {{ $row['nota_parcial_9'] }} -
                                                        1] += parseFloat(
                                                        eval9);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_9'] == 3)
                                                    totalLaboratorio[
                                                        {{ $row['nota_parcial_9'] }} -
                                                        1] += parseFloat(
                                                        eval9);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_9'] == 4)
                                                    totalReposicion[
                                                        {{ $row['nota_parcial_9'] }} -
                                                        1] += parseFloat(
                                                        eval9);
                                                @endif
                                            }
                                        @endif
                                    @endif
                                    @if ($row['nota_nombre_10'] != null)
                                        eval10 = this.getDataAtCell(row, 11);
                                        if (eval10 === '') {
                                            eval10 = null;
                                        }
                                        @if ($row['nota_parcial_10'] != null)
                                            if (eval10 != null && eval10 >= 0 && eval10 <=
                                                100) {
                                                @if ($row['nota_tipo_evaluacion_10'] == 1)
                                                    totalAcumulativo[
                                                        {{ $row['nota_parcial_10'] }} -
                                                        1] += parseFloat(
                                                        eval10);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_10'] == 2)
                                                    totalEvaluacion[
                                                        {{ $row['nota_parcial_10'] }} -
                                                        1] += parseFloat(
                                                        eval10);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_10'] == 3)
                                                    totalLaboratorio[
                                                        {{ $row['nota_parcial_10'] }} -
                                                        1] += parseFloat(
                                                        eval10);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_10'] == 4)
                                                    totalReposicion[
                                                        {{ $row['nota_parcial_10'] }} -
                                                        1] += parseFloat(
                                                        eval10);
                                                @endif
                                            }
                                        @endif
                                    @endif
                                    @if ($row['nota_nombre_11'] != null)
                                        eval11 = this.getDataAtCell(row, 12);
                                        if (eval11 === '') {
                                            eval11 = null;
                                        }
                                        @if ($row['nota_parcial_11'] != null)
                                            if (eval11 != null && eval11 >= 0 && eval11 <=
                                                100) {
                                                @if ($row['nota_tipo_evaluacion_11'] == 1)
                                                    totalAcumulativo[
                                                        {{ $row['nota_parcial_11'] }} -
                                                        1] += parseFloat(
                                                        eval11);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_11'] == 2)
                                                    totalEvaluacion[
                                                        {{ $row['nota_parcial_11'] }} -
                                                        1] += parseFloat(
                                                        eval11);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_11'] == 3)
                                                    totalLaboratorio[
                                                        {{ $row['nota_parcial_11'] }} -
                                                        1] += parseFloat(
                                                        eval11);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_11'] == 4)
                                                    totalReposicion[
                                                        {{ $row['nota_parcial_11'] }} -
                                                        1] += parseFloat(
                                                        eval11);
                                                @endif
                                            }
                                        @endif
                                    @endif
                                    @if ($row['nota_nombre_12'] != null)
                                        eval12 = this.getDataAtCell(row, 13);
                                        if (eval12 === '') {
                                            eval12 = null;
                                        }
                                        @if ($row['nota_parcial_12'] != null)
                                            if (eval12 != null && eval12 >= 0 && eval12 <=
                                                100) {
                                                @if ($row['nota_tipo_evaluacion_12'] == 1)
                                                    totalAcumulativo[
                                                        {{ $row['nota_parcial_12'] }} -
                                                        1] += parseFloat(
                                                        eval12);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_12'] == 2)
                                                    totalEvaluacion[
                                                        {{ $row['nota_parcial_12'] }} -
                                                        1] += parseFloat(
                                                        eval12);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_12'] == 3)
                                                    totalLaboratorio[
                                                        {{ $row['nota_parcial_12'] }} -
                                                        1] += parseFloat(
                                                        eval12);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_12'] == 4)
                                                    totalReposicion[
                                                        {{ $row['nota_parcial_12'] }} -
                                                        1] += parseFloat(
                                                        eval12);
                                                @endif
                                            }
                                        @endif
                                    @endif
                                    @if ($row['nota_nombre_13'] != null)
                                        eval13 = this.getDataAtCell(row, 14);
                                        if (eval13 === '') {
                                            eval13 = null;
                                        }
                                        @if ($row['nota_parcial_13'] != null)
                                            if (eval13 != null && eval13 >= 0 && eval13 <=
                                                100) {
                                                @if ($row['nota_tipo_evaluacion_13'] == 1)
                                                    totalAcumulativo[
                                                        {{ $row['nota_parcial_13'] }} -
                                                        1] += parseFloat(
                                                        eval13);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_13'] == 2)
                                                    totalEvaluacion[
                                                        {{ $row['nota_parcial_13'] }} -
                                                        1] += parseFloat(
                                                        eval13);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_13'] == 3)
                                                    totalLaboratorio[
                                                        {{ $row['nota_parcial_13'] }} -
                                                        1] += parseFloat(
                                                        eval13);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_13'] == 4)
                                                    totalReposicion[
                                                        {{ $row['nota_parcial_13'] }} -
                                                        1] += parseFloat(
                                                        eval13);
                                                @endif
                                            }
                                        @endif
                                    @endif
                                    @if ($row['nota_nombre_14'] != null)
                                        eval14 = this.getDataAtCell(row, 15);
                                        if (eval14 === '') {
                                            eval14 = null;
                                        }
                                        @if ($row['nota_parcial_14'] != null)
                                            if (eval14 != null && eval14 >= 0 && eval14 <=
                                                100) {
                                                @if ($row['nota_tipo_evaluacion_14'] == 1)
                                                    totalAcumulativo[
                                                        {{ $row['nota_parcial_14'] }} -
                                                        1] += parseFloat(
                                                        eval14);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_14'] == 2)
                                                    totalEvaluacion[
                                                        {{ $row['nota_parcial_14'] }} -
                                                        1] += parseFloat(
                                                        eval14);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_14'] == 3)
                                                    totalLaboratorio[
                                                        {{ $row['nota_parcial_14'] }} -
                                                        1] += parseFloat(
                                                        eval14);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_14'] == 4)
                                                    totalReposicion[
                                                        {{ $row['nota_parcial_14'] }} -
                                                        1] += parseFloat(
                                                        eval14);
                                                @endif
                                            }
                                        @endif
                                    @endif
                                    @if ($row['nota_nombre_15'] != null)
                                        eval15 = this.getDataAtCell(row, 16);
                                        if (eval15 === '') {
                                            eval15 = null;
                                        }
                                        @if ($row['nota_parcial_15'] != null)
                                            if (eval15 != null && eval15 >= 0 && eval15 <=
                                                100) {
                                                @if ($row['nota_tipo_evaluacion_15'] == 1)
                                                    totalAcumulativo[
                                                        {{ $row['nota_parcial_15'] }} -
                                                        1] += parseFloat(
                                                        eval15);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_15'] == 2)
                                                    totalEvaluacion[
                                                        {{ $row['nota_parcial_15'] }} -
                                                        1] += parseFloat(
                                                        eval15);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_15'] == 3)
                                                    totalLaboratorio[
                                                        {{ $row['nota_parcial_15'] }} -
                                                        1] += parseFloat(
                                                        eval15);
                                                @endif
                                                @if ($row['nota_tipo_evaluacion_15'] == 4)
                                                    totalReposicion[
                                                        {{ $row['nota_parcial_15'] }} -
                                                        1] += parseFloat(
                                                        eval15);
                                                @endif
                                            }
                                        @endif
                                    @endif

                                    var recuperacion = this.getDataAtCell(row,
                                        columnaRecuperacion);
                                    if (recuperacion === '') recuperacion = null;

                                    var calificacionFinal = 0;
                                    var estadoCalificacionFinal = null;
                                    var idEstadoCalificacionForzado = matriculados[row][
                                        'id_estado_calificacion_forzado'
                                    ];

                                    for (var i = 0; i < totalParcial.length; i++) {
                                        if (totalReposicion[i] > 0) {
                                            totalParcial[i] = parseFloat(totalAcumulativo[
                                                    i]) + parseFloat(totalReposicion[i]) +
                                                parseFloat(totalLaboratorio[i]);
                                        } else {
                                            totalParcial[i] = parseFloat(totalAcumulativo[
                                                    i]) + parseFloat(totalEvaluacion[i]) +
                                                parseFloat(totalLaboratorio[i]);
                                        }
                                        calificacionFinal += totalParcial[i];
                                    }

                                    if (recuperacion != null && recuperacion >= 0 &&
                                        recuperacion <= 100 && calificacionFinal >= 40) {
                                        calificacionFinal = recuperacion;
                                    } else if (calificacionFinal < 40 && recuperacion !=
                                        null) {
                                        window.alert('¡Error! La nota de recuperación ' +
                                            recuperacion +
                                            ' no puede ser asignada, la nota final debe ser mayor o igual a 40%'
                                        );
                                    }

                                    calificacionFinal = Math.round(calificacionFinal);

                                    if (calificacionFinal == 0) {
                                        if (eval1 == null && eval2 == null && eval3 ==
                                            null && eval4 == null && eval5 == null &&
                                            eval6 == null && eval7 == null && eval8 ==
                                            null && eval9 == null && eval10 == null &&
                                            eval11 == null && eval12 == null && eval13 ==
                                            null && eval14 == null && eval15 == null) {
                                            calificacionFinal = null;
                                        }
                                    } else if (calificacionFinal < 0 || calificacionFinal >
                                        100) {
                                        calificacionFinal = null;
                                    }

                                    // Highlight de fila: rojo si suma > 100, limpio si está bien
                                    var _hot = this, _row = row;
                                    var _sumaExcedida = (calificacionFinal === null &&
                                        (totalParcial[0] + totalParcial[1] + totalParcial[2] + totalParcial[3]) > 100);
                                    setTimeout(function() {
                                        var numCols = _hot.countCols();
                                        for (var c = 0; c < numCols; c++) {
                                            _hot.setCellMeta(_row, c, 'className',
                                                _sumaExcedida ? 'fila-suma-excedida' : '');
                                        }
                                        _hot.render();
                                        if (_sumaExcedida) {
                                            filasConError.add(_row + 1);
                                        } else {
                                            filasConError.delete(_row + 1);
                                        }
                                        clearTimeout(_toastErrorTimeout);
                                        if (filasConError.size > 0) {
                                            _toastErrorTimeout = setTimeout(function() {
                                                var lista = Array.from(filasConError)
                                                    .sort(function(a, b) { return a - b; })
                                                    .join(', ');
                                                var label = filasConError.size > 1 ? 'Filas' : 'Fila';
                                                Swal.fire({
                                                    toast: true,
                                                    position: 'bottom-end',
                                                    icon: 'warning',
                                                    title: 'La suma de notas supera 100',
                                                    text: label + ': ' + lista,
                                                    showConfirmButton: false,
                                                    timer: 4000,
                                                    timerProgressBar: true
                                                });
                                            }, 150);
                                        }
                                    }, 0);

                                    if (idEstadoCalificacionForzado == 0 ||
                                        idEstadoCalificacionForzado == null) {
                                        if (calificacionFinal === 0)
                                            estadoCalificacionFinal = 'NSP';
                                        else if (calificacionFinal > 0 &&
                                            calificacionFinal < 60)
                                            estadoCalificacionFinal = 'REP';
                                        else if (calificacionFinal >= 60 &&
                                            calificacionFinal <= 100)
                                            estadoCalificacionFinal = 'APR';
                                        else estadoCalificacionFinal = null;
                                    } else {
                                        if (idEstadoCalificacionForzado == idEstadoAbandono)
                                            estadoCalificacionFinal = 'ABD';
                                        else if (idEstadoCalificacionForzado ==
                                            idEstadoNoSePresento) estadoCalificacionFinal =
                                            'NSP';
                                        else if (idEstadoCalificacionForzado ==
                                            idEstadoReprobado) estadoCalificacionFinal =
                                            'REP';
                                        else estadoCalificacionFinal = null;
                                        calificacionFinal = 0;
                                    }

                                    this.setDataAtCell(row, columnaNotaFinal,
                                        calificacionFinal);
                                    this.setDataAtCell(row, columnaEstadoCalificacion,
                                        estadoCalificacionFinal);
                                });
                            },
                            licenseKey: 'b2455-d0184-9cc94-04409-6b848',
                            language: 'es-MX'
                        };
                        var isMobile = window.innerWidth <= 768;

                        if (isMobile) {
                            hotSettings.stretchH = 'none';
                            hotSettings.fixedColumnsLeft = 0;
                            hotSettings.rowHeaders = false;
                            hotSettings.width = window.innerWidth -
                            32; // ancho real de pantalla menos padding
                            hotSettings.colWidths = 90;
                            // Quitar preventOverflow que interfiere con scroll móvil
                            delete hotSettings.preventOverflow;
                        }

                        hot = new Handsontable(hotElement, hotSettings);

                        // En móvil, forzar eliminación de clones DESPUÉS de que Handsontable termine de renderizar
                        if (isMobile) {
                            setTimeout(function() {
                                var estiloForzado = document.createElement('style');
                                estiloForzado.innerHTML = `
            .ht_clone_left { display: none !important; width: 0 !important; }
            .ht_clone_top_left_corner { display: none !important; width: 0 !important; }
        `;
                                document.head.appendChild(estiloForzado);
                                hot.render();
                            }, 500);
                        }


                        Swal.close();
                    },
                    error: function(xhr) {
                        Swal.close();
                        console.log(xhr.responseText);
                    }
                });

                // ----- Guardar calificaciones -----
                $('#btnGuardarCalificaciones').on('click', function(event) {
                    event.preventDefault();
                    guardarCalificaciones();
                });

                // ----- Regresar con confirmación SweetAlert2 -----
                @if (
                    $tieneAccesoGuardarCalificacionesAsignaturas == 1 &&
                        ($currentUserId == $row['docente_calificador_1'] ||
                            $currentUserId == $row['docente_calificador_2'] ||
                            $tieneAsignaturasLaboratorioGrupo == 1))
                    $('#btnRegresar').on('click', function(e) {
                        e.preventDefault();
                        var url = $(this).attr('href');
                        if (!hayChangios) {
                            navegandoConPermiso = true;
                            window.location.href = url;
                            return;
                        }
                        Swal.fire({
                            title: '¿Desea salir?',
                            html: 'Tiene cambios sin guardar.<br>¿Qué desea hacer?',
                            icon: 'warning',
                            showDenyButton: true,
                            showCancelButton: true,
                            confirmButtonText: 'Guardar y Salir',
                            denyButtonText: 'Salir sin guardar',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: '#1ba333',
                            denyButtonColor: '#6c757d',
                            customClass: { denyButton: 'text-white' },
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                guardarCalificaciones(function() {
                                    navegandoConPermiso = true;
                                    window.location.href = url;
                                });
                            } else if (result.isDenied) {
                                navegandoConPermiso = true;
                                window.location.href = url;
                            }
                        });
                    });

                    window.addEventListener('beforeunload', function(e) {
                        if (navegandoConPermiso) return;
                        guardarCalificaciones();
                        e.preventDefault();
                        e.returnValue = '¿Estás seguro?';
                        return '¿Seguro que desea dejar este sitio?';
                    });
                @endif

                // ----- Modal observaciones sección -----
                $('#btn_aca_seccion_comentario').on('click', function() {
                    accion = 1;
                    $('#modal_aca_seccion_comentario').modal('show');
                });

                $('#modal_aca_seccion_comentario').on('show.bs.modal', function(e) {
                    var tl = $(e.relatedTarget);
                    id = tl.data('id');
                    texto_comentario = tl.data('texto_comentario');
                    $('#texto_comentario').val(texto_comentario);
                });

                $('#modal_eliminar_aca_seccion_comentario').on('show.bs.modal', function(e) {
                    var tl = $(e.relatedTarget);
                    id = tl.data('id');
                    texto_comentario = tl.data('texto_comentario');
                    accion = 3;
                });

                $('#tbl_aca_seccion_comentario tbody').on('click', 'tr', function() {
                    rowNumber = parseInt(table.row(this).index());
                    accion = 2;
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                });

                $('.modal-footer').on('click', '#btn_guardar_aca_seccion_comentario', function() {
                    texto_comentario = $('#texto_comentario').val();
                    espera('Guardando observación...');
                    guardar_aca_seccion_comentario();
                });

                $('.modal-footer').on('click', '#btn_eliminar_aca_seccion_comentario', function() {
                    guardar_aca_seccion_comentario();
                });
            });

            // ================================================================
            // Funciones globales
            // ================================================================

            function espera(html) {
                let timerInterval
                Swal.fire({
                    imageUrl: "{{ url(asset('/assets/images/unag_loading.gif')) }}",
                    title: '¡Espera!',
                    html: html,
                    timer: null,
                    timerProgressBar: true,
                    allowOutsideClick: false, // ← no se cierra al hacer click afuera
                    allowEscapeKey: false, // ← no se cierra con ESC
                    allowEnterKey: false, // ← no se cierra con Enter
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
                })
            }

            function guardarCalificaciones(onSuccessCallback) {
                espera('Tu información se esta guardando...');
                $.ajax({
                    url: '{{ url('/docentes/guardarCalificaciones') }}',
                    type: 'POST',
                    data: {
                        matriculados: JSON.stringify(matriculados),
                        'seccionId': {{ $seccionId }},
                        @if ($row['nota_nombre_1'] != null)
                            nota_nombre_1: "{{ $row['nota_nombre_1'] }}",
                            nota_maxima_1: ({{ $row['nota_maxima_1'] }}),
                            nota_parcial_1: ({{ $row['nota_parcial_1'] }}),
                            nota_tipo_evaluacion_1: ({{ $row['nota_tipo_evaluacion_1'] }}),
                        @endif
                        @if ($row['nota_nombre_2'] != null)
                            nota_nombre_2: "{{ $row['nota_nombre_2'] }}",
                            nota_maxima_2: ({{ $row['nota_maxima_2'] }}),
                            nota_parcial_2: ({{ $row['nota_parcial_2'] }}),
                            nota_tipo_evaluacion_2: ({{ $row['nota_tipo_evaluacion_2'] }}),
                        @endif
                        @if ($row['nota_nombre_3'] != null)
                            nota_nombre_3: "{{ $row['nota_nombre_3'] }}",
                            nota_maxima_3: ({{ $row['nota_maxima_3'] }}),
                            nota_parcial_3: ({{ $row['nota_parcial_3'] }}),
                            nota_tipo_evaluacion_3: ({{ $row['nota_tipo_evaluacion_3'] }}),
                        @endif
                        @if ($row['nota_nombre_4'] != null)
                            nota_nombre_4: "{{ $row['nota_nombre_4'] }}",
                            nota_maxima_4: ({{ $row['nota_maxima_4'] }}),
                            nota_parcial_4: ({{ $row['nota_parcial_4'] }}),
                            nota_tipo_evaluacion_4: ({{ $row['nota_tipo_evaluacion_4'] }}),
                        @endif
                        @if ($row['nota_nombre_5'] != null)
                            nota_nombre_5: "{{ $row['nota_nombre_5'] }}",
                            nota_maxima_5: ({{ $row['nota_maxima_5'] }}),
                            nota_parcial_5: ({{ $row['nota_parcial_5'] }}),
                            nota_tipo_evaluacion_5: ({{ $row['nota_tipo_evaluacion_5'] }}),
                        @endif
                        @if ($row['nota_nombre_6'] != null)
                            nota_nombre_6: "{{ $row['nota_nombre_6'] }}",
                            nota_maxima_6: ({{ $row['nota_maxima_6'] }}),
                            nota_parcial_6: ({{ $row['nota_parcial_6'] }}),
                            nota_tipo_evaluacion_6: ({{ $row['nota_tipo_evaluacion_6'] }}),
                        @endif
                        @if ($row['nota_nombre_7'] != null)
                            nota_nombre_7: "{{ $row['nota_nombre_7'] }}",
                            nota_maxima_7: ({{ $row['nota_maxima_7'] }}),
                            nota_parcial_7: ({{ $row['nota_parcial_7'] }}),
                            nota_tipo_evaluacion_7: ({{ $row['nota_tipo_evaluacion_7'] }}),
                        @endif
                        @if ($row['nota_nombre_8'] != null)
                            nota_nombre_8: "{{ $row['nota_nombre_8'] }}",
                            nota_maxima_8: ({{ $row['nota_maxima_8'] }}),
                            nota_parcial_8: ({{ $row['nota_parcial_8'] }}),
                            nota_tipo_evaluacion_8: ({{ $row['nota_tipo_evaluacion_8'] }}),
                        @endif
                        @if ($row['nota_nombre_9'] != null)
                            nota_nombre_9: "{{ $row['nota_nombre_9'] }}",
                            nota_maxima_9: ({{ $row['nota_maxima_9'] }}),
                            nota_parcial_9: ({{ $row['nota_parcial_9'] }}),
                            nota_tipo_evaluacion_9: ({{ $row['nota_tipo_evaluacion_9'] }}),
                        @endif
                        @if ($row['nota_nombre_10'] != null)
                            nota_nombre_10: "{{ $row['nota_nombre_10'] }}",
                            nota_maxima_10: ({{ $row['nota_maxima_10'] }}),
                            nota_parcial_10: ({{ $row['nota_parcial_10'] }}),
                            nota_tipo_evaluacion_10: ({{ $row['nota_tipo_evaluacion_10'] }}),
                        @endif
                        @if ($row['nota_nombre_11'] != null)
                            nota_nombre_11: "{{ $row['nota_nombre_11'] }}",
                            nota_maxima_11: ({{ $row['nota_maxima_11'] }}),
                            nota_parcial_11: ({{ $row['nota_parcial_11'] }}),
                            nota_tipo_evaluacion_11: ({{ $row['nota_tipo_evaluacion_11'] }}),
                        @endif
                        @if ($row['nota_nombre_12'] != null)
                            nota_nombre_12: "{{ $row['nota_nombre_12'] }}",
                            nota_maxima_12: ({{ $row['nota_maxima_12'] }}),
                            nota_parcial_12: ({{ $row['nota_parcial_12'] }}),
                            nota_tipo_evaluacion_12: ({{ $row['nota_tipo_evaluacion_12'] }}),
                        @endif
                        @if ($row['nota_nombre_13'] != null)
                            nota_nombre_13: "{{ $row['nota_nombre_13'] }}",
                            nota_maxima_13: ({{ $row['nota_maxima_13'] }}),
                            nota_parcial_13: ({{ $row['nota_parcial_13'] }}),
                            nota_tipo_evaluacion_13: ({{ $row['nota_tipo_evaluacion_13'] }}),
                        @endif
                        @if ($row['nota_nombre_14'] != null)
                            nota_nombre_14: "{{ $row['nota_nombre_14'] }}",
                            nota_maxima_14: ({{ $row['nota_maxima_14'] }}),
                            nota_parcial_14: ({{ $row['nota_parcial_14'] }}),
                            nota_tipo_evaluacion_14: ({{ $row['nota_tipo_evaluacion_14'] }}),
                        @endif
                        @if ($row['nota_nombre_15'] != null)
                            nota_nombre_15: "{{ $row['nota_nombre_15'] }}",
                            nota_maxima_15: ({{ $row['nota_maxima_15'] }}),
                            nota_parcial_15: ({{ $row['nota_parcial_15'] }}),
                            nota_tipo_evaluacion_15: ({{ $row['nota_tipo_evaluacion_15'] }}),
                        @endif
                    },
                    success: function(data) {
                        Swal.close();
                        dataOutput = data;
                        hayChangios = false;
                        if (dataOutput.msgError != null) {
                            Swal.fire('Error', dataOutput.msgError, 'error');
                        } else {
                            if (typeof onSuccessCallback === 'function') {
                                onSuccessCallback();
                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Guardado',
                                    text: dataOutput.msgSuccess,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                        }

                        var acc = dataOutput.tieneAccesoGuardarCalificacionesAsignaturas;
                        if (acc != 1) {
                            $('#divInfoCerrado').removeClass('d-none');
                            $('#divInfoAperturado').addClass('d-none');
                        } else {
                            $('#divInfoCerrado').addClass('d-none');
                            $('#divInfoAperturado').removeClass('d-none');
                        }

                        $('#lblAPR').html(
                            '<i data-feather="arrow-up" style="width:11px;height:11px;stroke:#fff;"></i> APR: ' +
                            dataOutput.totalAprobados);
                        $('#lblREP').html(
                            '<i data-feather="arrow-down" style="width:11px;height:11px;stroke:#fff;"></i> REP: ' +
                            dataOutput.totalReprobados);
                        $('#lblNSP').html('— NSP: ' + dataOutput.totalNSP);
                        feather.replace();

                        // $('#lblAPR').html('<i data-feather="arrow-up" style="width:12px;height:12px;"></i> APR: ' +
                        //     dataOutput.totalAprobados);
                        // $('#lblREP').html(
                        //     '<i data-feather="arrow-down" style="width:12px;height:12px;"></i> REP: ' +
                        //     dataOutput.totalReprobados);
                        // $('#lblNSP').text('— NSP: ' + dataOutput.totalNSP);
                        // feather.replace();
                    },
                    error: function(xhr) {
                        Swal.close();
                        console.log(xhr.responseText);
                    }
                });
            }

            function guardar_aca_seccion_comentario() {
                $.ajax({
                    type: 'post',
                    url: url_guardar_aca_seccion_comentario,
                    data: {
                        'id': id,
                        'id_seccion': {{ $seccionId }},
                        'texto_comentario': texto_comentario,
                        accion: accion
                    },
                    success: function(data) {
                        Swal.close();
                        if (data.msgError != null) {
                            Swal.fire('Error', data.msgError, 'error');
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Guardado',
                                text: data.msgSuccess,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            $('#modal_aca_seccion_comentario').modal('hide');

                            // Solo procesar la lista si no es eliminación y si existe
                            if (accion != 3 && data.aca_seccion_comentario_list != null) {
                                for (var i = 0; i < data.aca_seccion_comentario_list.length; i++) {
                                    var r = data.aca_seccion_comentario_list[i];
                                    var fila = [r.id, r.id_seccion, r.texto_comentario];
                                    if (accion == 1) {
                                        table.row.add(fila).draw();
                                    } else if (accion == 2) {
                                        table.row(rowNumber).data(fila).draw();
                                    }
                                }
                            }

                            if (accion == 3) {
                                $('#modal_eliminar_aca_seccion_comentario').modal('hide');
                                table.row(rowNumber).remove().draw();
                            }
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }

            // Renderers Handsontable
            function estadoForzadoRenderer(instance, td, row, col, prop, value, cellProperties) {
                Handsontable.renderers.TextRenderer.apply(this, arguments);
                td.style.background = '#FFB900';
            }
            Handsontable.renderers.registerRenderer('estadoForzadoRenderer', estadoForzadoRenderer);

            function defaultRenderer(instance, td, row, col, prop, value, cellProperties) {
                Handsontable.renderers.TextRenderer.apply(this, arguments);
                if (cellProperties.readOnly == true) {
                    setTimeout(function() {
                        td.style.setProperty('background', '#e8f0e9', 'important');
                        td.style.setProperty('color', '#7a8f7b', 'important');
                        td.style.setProperty('cursor', 'not-allowed', 'important');
                    }, 0);
                } else {
                    setTimeout(function() {
                        td.style.setProperty('background', '', 'important');
                        td.style.setProperty('color', '', 'important');
                    }, 0);
                }
            }
            Handsontable.renderers.registerRenderer('defaultRenderer', defaultRenderer);

            function errorRenderer(instance, td, row, col, prop, value, cellProperties) {
                Handsontable.renderers.TextRenderer.apply(this, arguments);
                td.style.background = 'red';
            }
            Handsontable.renderers.registerRenderer('errorRenderer', errorRenderer);

            function sancionadoRenderer(instance, td, row, col, prop, value, cellProperties) {
                Handsontable.renderers.TextRenderer.apply(this, arguments);
                td.style.background = 'red';
                td.style.color = 'white';
                cellProperties.readOnly = true;
            }
            Handsontable.renderers.registerRenderer('sancionadoRenderer', sancionadoRenderer);
        </script>
    @endforeach

    {{-- Temporizador --}}
    <script>
        $(document).ready(function() {
            @if (empty($calendario_calificaciones_asignatura_segundos_restantes))
                var tiempo = 0;
            @else
                var tiempo = {{ $calendario_calificaciones_asignatura_segundos_restantes['tiempo_restante'] }};
            @endif

            function actualizarTemporizador() {
                if (tiempo > 0) {
                    const dias = Math.floor(tiempo / 86400);
                    const horas = Math.floor((tiempo % 86400) / 3600);
                    const minutos = Math.floor((tiempo % 3600) / 60);
                    const segundos = tiempo % 60;
                    let texto = '';
                    if (dias > 0) texto += `${dias} día${dias > 1 ? 's' : ''}, `;
                    if (horas > 0 || dias > 0) texto += `${horas} hora${horas > 1 ? 's' : ''}, `;
                    if (minutos > 0 || horas > 0 || dias > 0) texto += `${minutos} min y `;
                    texto += `${segundos} seg`;
                    $('#temporizador').text('Quedan: ' + texto);
                    tiempo--;
                } else {
                    $('#temporizador').text('¡Período de Calificaciones Cerrado!').css('color', 'var(--rojo)');
                    clearInterval(intervalo);
                }
            }

            const intervalo = setInterval(actualizarTemporizador, 1000);
            actualizarTemporizador();
        });
    </script>
@endpush
