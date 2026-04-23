@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <style>
        /* ── TARJETAS DE INFO (igual a calificaciones) ── */
        .stat-card {
            border-left: 4px solid var(--azul);
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-card.verde  { border-left-color: var(--verde); }
        .stat-card.amarillo { border-left-color: var(--amarillo); }
        .stat-card.azul { border-left-color: var(--azul); }

        .stat-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #6c757d;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .stat-value {
            font-size: 20px;
            font-weight: 700;
            color: var(--azul);
        }
        .stat-sub { font-size: 12px; color: #888; }

        /* ── SALDO ── */
        .saldo-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 16px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 13px;
        }
        .saldo-row:last-child { border-bottom: none; }
        .saldo-row .monto { font-weight: 700; color: var(--azul); }

        /* ── BADGES DE TIPO ── */
        .badge-tipo {
            font-size: 10px;
            padding: 3px 8px;
            border-radius: 10px;
            font-weight: 600;
            white-space: nowrap;
        }
        .badge-tipo.asignatura { background: #e3ecff; color: var(--azul); }
        .badge-tipo.modulo     { background: #e8f5e9; color: var(--verdeOscuro); }

        /* ── TABLA ── */
        .table-matricula thead th {
            background: #f8f9fa;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #495057;
            font-weight: 700;
            border-bottom: 2px solid #dee2e6;
            padding: 10px 12px;
        }
        .table-matricula tbody td {
            font-size: 13px;
            font-weight: 600;
            vertical-align: middle;
            padding: 9px 12px;
        }
        .table-matricula tbody tr:hover { background: #f0f4ff; }

        /* ── TABS ── */
        #tabsMatricula .nav-link.active,
        #tabsMatricula .nav-link:hover {
            background-color: var(--verdeClaro) !important;
            color: var(--azul) !important;
        }

        /* ── BOTÓN IMPRIMIR ── */
        .btn-imprimir {
            background: var(--amarillo);
            color: var(--azul);
            font-weight: 700;
            border: none;
            border-radius: 6px;
            padding: 7px 18px;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: opacity 0.2s;
        }
        .btn-imprimir:hover { opacity: 0.85; color: var(--azul); }

        table.dataTable thead th,
table.dataTable thead td {
    background-color: var(--verdeClaro) !important;
    color: var(--azul) !important;
}

#ico_info, #ico_saldo {
    transition: transform 0.25s ease;
}
    </style>
@endpush

@section('content')
@php $estudiante = (object) $informacion_estudiante; @endphp

{{-- ============================================================ --}}
{{-- ENCABEZADO (igual a calificaciones: card bg-verde sin gradiente) --}}
{{-- ============================================================ --}}
<div class="row mb-3">
    <div class="col-12">
        <div class="card bg-primary" style="border:none;">
            <div class="card-body py-3" style="position:relative;">
                <div class="d-flex align-items-center gap-3">
                    <i data-feather="clipboard" style="width:48px;height:48px;stroke:#fff;"></i>
                    <div>
                        <h2 class="mb-0 fw-bold text-white" style="font-size:28px;letter-spacing:1px;">
                            MATRÍCULA
                        </h2>
                        <div class="mt-1 text-white" style="font-size:13px;font-weight:600;letter-spacing:0.5px;">
                            <i data-feather="calendar" style="width:13px;height:13px;stroke:#fff;"></i>
                            {{ strtoupper($periodo_actual) }}
                        </div>
                    </div>
                </div>
                <img src="{{ url(asset('/assets/images/UNAG_BLANCO.png')) }}" class="d-none d-md-block"
                    style="position:absolute;right:20px;top:50%;transform:translateY(-50%);height:60px;opacity:0.9;">
            </div>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- INFO ESTUDIANTE + SALDO                                       --}}
{{-- ============================================================ --}}
{{-- ============================================================ --}}
{{-- TARJETA COMPACTA — solo mobile (< lg)                         --}}
{{-- ============================================================ --}}
<div class="d-lg-none mb-4">
    <div class="card shadow-sm" style="border:none;overflow:hidden;">
        {{-- Header con nombre y registro --}}
        <div style="background:var(--azul);padding:14px 18px;">
            <div class="d-flex align-items-center gap-2 mb-1">
                <i data-feather="user" style="width:18px;height:18px;stroke:#fff;flex-shrink:0;"></i>
                <span style="color:#fff !important;font-size:16px;font-weight:700;line-height:1.2;">{{ $estudiante->name }}</span>
            </div>
            <span style="background:var(--amarillo);color:var(--azul);font-size:11px;font-weight:700;padding:2px 10px;border-radius:20px;letter-spacing:.5px;">
                <i data-feather="hash" style="width:10px;height:10px;"></i> {{ $estudiante->numero_registro_asignado }}
            </span>
        </div>

        {{-- Grilla de datos colapsable --}}
        <div class="card-body p-0">

            {{-- Toggle info --}}
            <button class="btn w-100 d-flex justify-content-between align-items-center px-3 py-2"
                data-bs-toggle="collapse" data-bs-target="#collapse_info_estudiante"
                style="background:#f0f4ff;border:none;border-bottom:1px solid #e0e7ff;border-radius:0;font-size:12px;font-weight:700;color:var(--azul);">
                <span><i data-feather="info" style="width:13px;height:13px;"></i> Datos del estudiante</span>
                <i data-feather="chevron-down" style="width:14px;height:14px;transform:rotate(-90deg);" id="ico_info"></i>
            </button>

            <div class="collapse" id="collapse_info_estudiante">
                <div style="display:grid;grid-template-columns:1fr 1fr;border-bottom:1px solid #f0f0f0;">
                    <div style="padding:10px 14px;border-right:1px solid #f0f0f0;">
                        <div style="font-size:10px;text-transform:uppercase;letter-spacing:.5px;color:#999;font-weight:600;margin-bottom:2px;">
                            <i data-feather="award" style="width:10px;height:10px;color:var(--verde);"></i> Carrera
                        </div>
                        <div style="font-size:13px;font-weight:700;color:var(--azul);">{{ $estudiante->carrera }}</div>
                    </div>
                    <div style="padding:10px 14px;">
                        <div style="font-size:10px;text-transform:uppercase;letter-spacing:.5px;color:#999;font-weight:600;margin-bottom:2px;">
                            <i data-feather="map-pin" style="width:10px;height:10px;color:var(--verde);"></i> Sede
                        </div>
                        <div style="font-size:13px;font-weight:700;color:var(--azul);">{{ $estudiante->sede }}</div>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;">
                    <div style="padding:10px 14px;border-right:1px solid #f0f0f0;">
                        <div style="font-size:10px;text-transform:uppercase;letter-spacing:.5px;color:#999;font-weight:600;margin-bottom:2px;">
                            <i data-feather="calendar" style="width:10px;height:10px;color:var(--amarillo);"></i> Periodo
                        </div>
                        <div style="font-size:13px;font-weight:700;color:var(--azul);">{{ $estudiante->periodo_academico }}</div>
                    </div>
                    <div style="padding:10px 14px;border-right:1px solid #f0f0f0;">
                        <div style="font-size:10px;text-transform:uppercase;letter-spacing:.5px;color:#999;font-weight:600;margin-bottom:2px;">
                            <i data-feather="layers" style="width:10px;height:10px;color:var(--amarillo);"></i> Sección
                        </div>
                        <div style="font-size:13px;font-weight:700;color:var(--azul);">{{ $estudiante->etiqueta_seccion }}</div>
                    </div>
                    <div style="padding:10px 14px;">
                        <div style="font-size:10px;text-transform:uppercase;letter-spacing:.5px;color:#999;font-weight:600;margin-bottom:2px;">
                            <i data-feather="clock" style="width:10px;height:10px;color:var(--amarillo);"></i> Jornada
                        </div>
                        <div style="font-size:13px;font-weight:700;color:var(--azul);">{{ $estudiante->id_jornada_modular }}{{ $estudiante->numero_rotacion }}</div>
                    </div>
                </div>
            </div>

            {{-- Toggle saldo --}}
            <button class="btn w-100 d-flex justify-content-between align-items-center px-3 py-2"
                data-bs-toggle="collapse" data-bs-target="#collapse_saldo_mobile"
                style="background:#fffbea;border:none;border-top:1px solid #f0e68c;border-radius:0;font-size:12px;font-weight:700;color:var(--azul);">
                <span><i data-feather="dollar-sign" style="width:13px;height:13px;"></i> Saldo</span>
                <i data-feather="chevron-down" style="width:14px;height:14px;transform:rotate(-90deg);" id="ico_saldo"></i>
            </button>

            <div class="collapse" id="collapse_saldo_mobile">
                <div style="background:#f8f9fa;padding:8px 14px;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:4px;">
                        @foreach ($saldo as $saldorow)
                            <div style="display:flex;justify-content:space-between;align-items:center;background:#fff;border-radius:6px;padding:5px 10px;border:1px solid #eee;">
                                <span style="font-size:10px;color:#777;">{{ $saldorow['descripcionmonto'] }}</span>
                                <span style="font-size:12px;font-weight:700;color:var(--azul);">L.{{ number_format($saldorow['monto'], 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- CARD DESKTOP — solo lg+                                        --}}
{{-- ============================================================ --}}
<div class="d-none d-lg-block mb-4">
    <div class="card shadow-sm" style="border:none;border-radius:10px;overflow:hidden;">

        {{-- Fila 1: nombre + registro --}}
        <div style="background:var(--azul);padding:12px 24px;display:flex;align-items:center;justify-content:space-between;">
            <div class="d-flex align-items-center gap-3">
                <i data-feather="user" style="width:20px;height:20px;stroke:#fff;flex-shrink:0;"></i>
                <span style="color:#fff !important;font-size:17px;font-weight:700;letter-spacing:.3px;">{{ $estudiante->name }}</span>
            </div>
            <span style="background:var(--amarillo);color:var(--azul);font-size:12px;font-weight:700;padding:4px 16px;border-radius:20px;letter-spacing:.5px;">
                <i data-feather="hash" style="width:11px;height:11px;"></i> {{ $estudiante->numero_registro_asignado }}
            </span>
        </div>

        {{-- Fila 2: datos + saldo --}}
        <div style="background:#fff;padding:0;display:flex;align-items:stretch;overflow-x:auto;">

            {{-- Datos académicos --}}
            <div style="flex:1;display:flex;align-items:center;justify-content:space-evenly;padding:12px 16px;gap:0;border-right:1px solid #e8edf5;min-width:0;">
                @php
                    $items = [
                        ['icon'=>'award',    'label'=>'Carrera',  'value'=> $estudiante->carrera],
                        ['icon'=>'map-pin',  'label'=>'Sede',     'value'=> $estudiante->sede],
                        ['icon'=>'calendar', 'label'=>'Periodo',  'value'=> $estudiante->periodo_academico],
                        ['icon'=>'layers',   'label'=>'Sección',  'value'=> $estudiante->etiqueta_seccion],
                        ['icon'=>'clock',    'label'=>'Jornada',  'value'=> $estudiante->id_jornada_modular . $estudiante->numero_rotacion],
                    ];
                @endphp
                @foreach ($items as $i => $item)
                    @if ($i > 0)
                        <div style="width:1px;height:32px;background:#e8edf5;flex-shrink:0;margin:0 12px;"></div>
                    @endif
                    <div style="flex-shrink:0;">
                        <div style="font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:#aaa;font-weight:600;margin-bottom:3px;white-space:nowrap;">
                            <i data-feather="{{ $item['icon'] }}" style="width:11px;height:11px;color:var(--verde);"></i> {{ $item['label'] }}
                        </div>
                        <div style="font-size:15px;font-weight:700;color:var(--azul);white-space:nowrap;">{{ $item['value'] }}</div>
                    </div>
                @endforeach
            </div>

            {{-- Saldo 2x2 --}}
            <div style="flex-shrink:0;display:grid;grid-template-columns:1fr 1fr;gap:6px;padding:10px 16px;align-content:center;">
                @foreach ($saldo as $saldorow)
                    @php
                        $esPagado    = str_contains(strtolower($saldorow['descripcionmonto']), 'pagado');
                        $esPendiente = str_contains(strtolower($saldorow['descripcionmonto']), 'pendiente');
                        $colorMonto  = $esPagado ? '#0F6E56' : ($esPendiente ? '#A32D2D' : 'var(--azul)');
                        $bgCard      = $esPagado ? '#E1F5EE' : ($esPendiente ? '#FCEBEB' : '#f0f4ff');
                    @endphp
                    <div style="background:{{ $bgCard }};border-radius:8px;padding:7px 12px;text-align:center;">
                        <div style="font-size:9px;text-transform:uppercase;letter-spacing:.5px;color:#888;font-weight:600;margin-bottom:3px;white-space:nowrap;">{{ $saldorow['descripcionmonto'] }}</div>
                        <div style="font-size:13px;font-weight:700;color:{{ $colorMonto }};">L. {{ number_format($saldorow['monto'], 2) }}</div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>{{-- /card desktop --}}

{{-- ============================================================ --}}
{{-- TABS: OFERTADOS / MATRICULADOS                                --}}
{{-- ============================================================ --}}
<ul class="nav nav-tabs" id="tabsMatricula" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active d-flex align-items-center gap-2" id="tab-ofertadas"
            data-bs-toggle="tab" data-bs-target="#pane-ofertadas" type="button" role="tab">
            <i data-feather="list" style="width:16px;height:16px;"></i>
            Ofertados
            <span class="badge bg-primary ms-1" id="cnt_ofertados_tab">{{ count($listado_asignaturas_modulos) }}</span>
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link d-flex align-items-center gap-2" id="tab-matriculadas"
            data-bs-toggle="tab" data-bs-target="#pane-matriculadas" type="button" role="tab">
            <i data-feather="check-circle" style="width:16px;height:16px;"></i>
            Matriculados
            @foreach ($conteo_modulos_asignaturas_matriculadas as $conteo)
                @php $conteo = (array) $conteo; @endphp
                @if ($conteo['tipo'] == 'ASIGNATURA')
                    <span class="badge bg-primary ms-1" id="cnt_asignaturas_tab">{{ $conteo['matriculadas'] }} Asig.</span>
                @else
                    <span class="badge bg-primary ms-1" id="cnt_modulos_tab">{{ $conteo['matriculadas'] }} Mód.</span>
                @endif
            @endforeach
        </button>
    </li>
</ul>

<div class="tab-content pt-3">

    {{-- PANE OFERTADOS --}}
    <div class="tab-pane fade show active" id="pane-ofertadas" role="tabpanel">
        <div class="card border-secondary">
            <div class="card-header bg-primary text-white">
                <h5 class="text-white mb-0">
                    <i data-feather="list" style="width:16px;height:16px;stroke:#fff;"></i> Ofertados
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-matricula table-hover" id="tbl_ofertadas">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Asignatura / Módulo</th>
                                <th>Sede</th>
                                <th>Sección</th>
                                <th>UV</th>
                                <th>Horario</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listado_asignaturas_modulos as $row)
                                @php $row = (array) $row; @endphp
                                <tr>
                                    <td>
                                        @if ($row['tipo'] == 'ASIGNATURA')
                                            <span class="badge-tipo asignatura"><i data-feather="book" style="width:10px;height:10px;"></i> Asignatura</span>
                                        @else
                                            <span class="badge-tipo modulo"><i data-feather="layers" style="width:10px;height:10px;"></i> Módulo</span>
                                        @endif
                                    </td>
                                    <td>{{ $row['asignatura'] }}</td>
                                    <td>{{ $row['sede'] }}</td>
                                    <td>{{ $row['seccion'] }}</td>
                                    <td><span class="badge bg-primary">{{ $row['unidades_valorativas'] }}</span></td>
                                    <td>
                                        @if ($row['tipo'] == 'ASIGNATURA')
                                            <button type="button" class="btn btn-sm btn-outline-primary btn-horario"
                                                data-bs-toggle="modal" data-bs-target="#modal_horario"
                                                data-lunes="{{ $row['lunes'] }}" data-martes="{{ $row['martes'] }}"
                                                data-miercoles="{{ $row['miercoles'] }}" data-jueves="{{ $row['jueves'] }}"
                                                data-viernes="{{ $row['viernes'] }}" data-sabado="{{ $row['sabado'] }}"
                                                data-domingo="{{ $row['domingo'] }}" data-asignatura="{{ $row['asignatura'] }}"
                                                style="font-size:11px;">
                                                <i data-feather="clock" style="width:11px;height:11px;"></i> Ver
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn bg-azul btn-sm btn_prematricula" data-id_ofertada="{{ $row['id'] }}"
                                            style="font-size:12px;">
                                            <i data-feather="plus-circle" style="width:13px;height:13px;stroke:#fff;"></i> Matricular
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

    {{-- PANE MATRICULADOS --}}
    <div class="tab-pane fade" id="pane-matriculadas" role="tabpanel">
        <div class="card border-secondary">
            <div class="card-header bg-primary text-white d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <span class="text-white fw-bold"><i data-feather="check-circle" style="width:16px;height:16px;stroke:#fff;"></i> Matriculados</span>
                    @foreach ($conteo_modulos_asignaturas_matriculadas as $conteo)
                        @php $conteo = (array) $conteo; @endphp
                        @if ($conteo['tipo'] == 'ASIGNATURA')
                            <span class="text-white" style="font-size:13px;font-weight:600;white-space:nowrap;">
                                <i data-feather="book" style="width:13px;height:13px;stroke:#fff;"></i>
                                Asig.: <strong id="cnt_asignaturas">{{ $conteo['matriculadas'] }}</strong>
                            </span>
                        @else
                            <span class="text-white" style="font-size:13px;font-weight:600;white-space:nowrap;">
                                <i data-feather="layers" style="width:13px;height:13px;stroke:#fff;"></i>
                                Mód.: <strong id="cnt_modulos">{{ $conteo['matriculadas'] }}</strong>
                            </span>
                        @endif
                    @endforeach
                </div>
                <a href="{{ url('estudiantes/' . $numero_registro_asignado . '/reporte/prematricula') }}" target="_blank" class="btn-imprimir" style="white-space:nowrap;">
                    <i data-feather="printer" style="width:14px;height:14px;"></i> Imprimir
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-matricula table-hover" id="tbl_matriculadas">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Asignatura / Módulo</th>
                                <th>Sede</th>
                                <th>Sección</th>
                                <th>UV</th>
                                <th>Horario</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listado_asignaturas_modulos_matriculados as $row)
                                @php $row = (array) $row; @endphp
                                <tr>
                                    <td>
                                        @if ($row['tipo'] == 'ASIGNATURA')
                                            <span class="badge-tipo asignatura"><i data-feather="book" style="width:10px;height:10px;"></i> Asignatura</span>
                                        @else
                                            <span class="badge-tipo modulo"><i data-feather="layers" style="width:10px;height:10px;"></i> Módulo</span>
                                        @endif
                                    </td>
                                    <td>{{ $row['asignatura'] }}</td>
                                    <td>{{ $row['sede'] }}</td>
                                    <td>{{ $row['seccion'] }}</td>
                                    <td><span class="badge bg-primary">{{ $row['unidades_valorativas'] }}</span></td>
                                    <td>
                                        @if ($row['tipo'] == 'ASIGNATURA')
                                            <button type="button" class="btn btn-sm btn-outline-primary btn-horario"
                                                data-bs-toggle="modal" data-bs-target="#modal_horario"
                                                data-lunes="{{ $row['lunes'] }}" data-martes="{{ $row['martes'] }}"
                                                data-miercoles="{{ $row['miercoles'] }}" data-jueves="{{ $row['jueves'] }}"
                                                data-viernes="{{ $row['viernes'] }}" data-sabado="{{ $row['sabado'] }}"
                                                data-domingo="{{ $row['domingo'] }}" data-asignatura="{{ $row['asignatura'] }}"
                                                style="font-size:11px;">
                                                <i data-feather="clock" style="width:11px;height:11px;"></i> Ver
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm btn_desmatricular" data-id="{{ $row['id'] }}"
                                            style="font-size:12px;">
                                            <i data-feather="x-circle" style="width:13px;height:13px;stroke:#fff;"></i> Cancelar
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

</div>{{-- /tab-content --}}

{{-- ============================================================ --}}
{{-- MODAL HORARIO                                                  --}}
{{-- ============================================================ --}}
<div class="modal fade" id="modal_horario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary" style="border:none;">
                <h5 class="modal-title text-white fw-bold d-flex align-items-center gap-2">
                    <i data-feather="clock" style="width:17px;height:17px;stroke:#fff;"></i>
                    <span class="text-white" id="titulo_modal_horario"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <table class="table table-bordered table-hover mb-0 text-center" style="font-size:13px;">
                    <thead>
                        <tr style="background:var(--verdeClaro);">
                            <th style="color:var(--verdeOscuro);width:40%;">DÍA</th>
                            <th style="color:var(--verdeOscuro);">HORA INICIO — HORA FIN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td class="fw-bold">Lunes</td><td id="horario_lunes"></td></tr>
                        <tr><td class="fw-bold">Martes</td><td id="horario_martes"></td></tr>
                        <tr><td class="fw-bold">Miércoles</td><td id="horario_miercoles"></td></tr>
                        <tr><td class="fw-bold">Jueves</td><td id="horario_jueves"></td></tr>
                        <tr><td class="fw-bold">Viernes</td><td id="horario_viernes"></td></tr>
                        <tr><td class="fw-bold">Sábado</td><td id="horario_sabado"></td></tr>
                        <tr><td class="fw-bold">Domingo</td><td id="horario_domingo"></td></tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="border:none;">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
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
<script>
    // Rotar flechas de los colapsables mobile
    document.getElementById('collapse_info_estudiante').addEventListener('hide.bs.collapse', function () {
        document.getElementById('ico_info').style.transform = 'rotate(-90deg)';
    });
    document.getElementById('collapse_info_estudiante').addEventListener('show.bs.collapse', function () {
        document.getElementById('ico_info').style.transform = 'rotate(0deg)';
    });
    document.getElementById('collapse_saldo_mobile').addEventListener('hide.bs.collapse', function () {
        document.getElementById('ico_saldo').style.transform = 'rotate(-90deg)';
    });
    document.getElementById('collapse_saldo_mobile').addEventListener('show.bs.collapse', function () {
        document.getElementById('ico_saldo').style.transform = 'rotate(0deg)';
    });

    var table_ofertadas    = null;
    var table_matriculadas = null;
    var id_ofertada        = null;
    var estudiante         = "{{ $numero_registro_asignado }}";
    var url_guardar        = "{{ url('/estudiantes/matricula/guardar') }}";
    var url_desmatricular  = "{{ url('/estudiantes/matricula/desmatricular') }}";

    $(document).ready(function () {

        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        var dtLang = {
            processing: "Procesando...", search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ registros",
            info: "Mostrando del _START_ al _END_ de _TOTAL_ registros",
            infoEmpty: "Mostrando 0 registros", zeroRecords: "No se encontraron resultados",
            emptyTable: "Ningún dato disponible", loadingRecords: "Cargando...",
            paginate: { first: "Primero", previous: "Anterior", next: "Siguiente", last: "Último" }
        };

        // Columnas: Tipo | Asignatura | Sede | Sección | UV | Horario | Acción
        // responsivePriority: 1 = siempre visible, números altos = primeros en ocultarse
        var dtOpts = {
            language: dtLang,
            pageLength: 25,
            aLengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todo"]],
            autoWidth: false,
            responsive: true,
            columnDefs: [
                { responsivePriority: 1,     targets: 1  }, // Asignatura — nunca se oculta
                { responsivePriority: 10001, targets: 0  }, // Tipo
                { responsivePriority: 10002, targets: 2  }, // Sede
                { responsivePriority: 10003, targets: 3  }, // Sección
                { responsivePriority: 10004, targets: 4  }, // UV
                { responsivePriority: 10005, targets: 5  }, // Horario
                { responsivePriority: 10006, targets: -1 }, // Acción
            ]
        };

        // Ambas tablas se inicializan al cargar
        table_ofertadas    = $('#tbl_ofertadas').DataTable(dtOpts);
        table_matriculadas = $('#tbl_matriculadas').DataTable(dtOpts);

        // Al abrir el tab de matriculadas, solo ajustar anchos (ya está inicializada)
        $('#tabsMatricula button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            if ($(e.target).data('bs-target') === '#pane-matriculadas') {
                table_matriculadas.columns.adjust().draw();
                table_matriculadas.responsive.recalc();
            }
            feather.replace();
        });

        // Modal horario — poblar celdas al click; Bootstrap abre el modal via data-bs-toggle
        $(document).on('click', '.btn-horario', function () {
            var el  = this;
            var val = function (attr) {
                return (el.getAttribute(attr) || '').trim() || '—';
            };
            document.getElementById('titulo_modal_horario').textContent = el.getAttribute('data-asignatura') || '';
            document.getElementById('horario_lunes').textContent     = val('data-lunes');
            document.getElementById('horario_martes').textContent    = val('data-martes');
            document.getElementById('horario_miercoles').textContent = val('data-miercoles');
            document.getElementById('horario_jueves').textContent    = val('data-jueves');
            document.getElementById('horario_viernes').textContent   = val('data-viernes');
            document.getElementById('horario_sabado').textContent    = val('data-sabado');
            document.getElementById('horario_domingo').textContent   = val('data-domingo');
        });

        // ── MATRICULAR ─────────────────────────────────────────
        $('#tbl_ofertadas').on('click', '.btn_prematricula', function (e) {
            e.stopPropagation();
            id_ofertada  = $(this).data('id_ofertada');
            var $clicked = $(this).closest('tr');
            var $tr      = $clicked.hasClass('child') ? $clicked.prev('tr') : $clicked;
            gestionar_matricula($tr);
        });

        // ── DESMATRICULAR ───────────────────────────────────────
        $('#tbl_matriculadas').on('click', '.btn_desmatricular', function (e) {
            e.stopPropagation();
            id_ofertada  = $(this).data('id');
            var $clicked = $(this).closest('tr');
            var $tr      = $clicked.hasClass('child') ? $clicked.prev('tr') : $clicked;
            gestionar_desmatricular($tr);
        });

    });

    // ── AJAX MATRICULAR ─────────────────────────────────────────
    function gestionar_matricula($tr) {
        $.ajax({
            url: url_guardar,
            type: 'post',
            data: { id_ofertada: id_ofertada, numero_registro_asignado: estudiante },
            success: function (data) {
                if (data.msgError != null) {
                    Swal.fire({ icon: 'error', title: 'Error', text: data.msgError, confirmButtonColor: '#203b76' });
                } else {
                    Swal.fire({ icon: 'success', title: '¡Matriculado!', text: data.msgSuccess, timer: 2000, showConfirmButton: false });
                    actualizarContadores(data.conteo_modulos_asignaturas_matriculadas);
                    var row = data.listado_asignaturas_modulos_matriculados[0];
                    table_ofertadas.row($tr).remove().draw();
                    $('#cnt_ofertados_tab').text(table_ofertadas.rows().count());
                    table_matriculadas.row.add([
                        badgePorTipo(row.tipo),
                        row.asignatura,
                        row.sede,
                        row.seccion,
                        '<span class="badge bg-primary">' + row.unidades_valorativas + '</span>',
                        row.tipo === 'ASIGNATURA' ? btnHorarioHtml(row) : '',
                        '<button class="btn btn-danger btn-sm btn_desmatricular" data-id="' + row.id + '" style="font-size:12px;">' +
                        '<i data-feather="x-circle" style="width:13px;height:13px;stroke:#fff;"></i> Cancelar</button>'
                    ]).draw();
                    setTimeout(feather.replace, 0);
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Error de conexión', text: 'No se pudo conectar con el servidor.', confirmButtonColor: '#203b76' });
            }
        });
    }

    // ── AJAX DESMATRICULAR ──────────────────────────────────────
    function gestionar_desmatricular($tr) {
        Swal.fire({
            title: '¿Cancelar matrícula?',
            text: 'Se quitará la asignatura/módulo de tu matrícula.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'No'
        }).then(function (result) {
            if (!result.isConfirmed) return;
            $.ajax({
                url: url_desmatricular,
                type: 'post',
                data: { id_ofertada: id_ofertada, numero_registro_asignado: estudiante },
                success: function (data) {
                    if (data.msgError != null) {
                        Swal.fire({ icon: 'error', title: 'Error', text: data.msgError, confirmButtonColor: '#203b76' });
                    } else {
                        Swal.fire({ icon: 'success', title: 'Cancelado', text: data.msgSuccess, timer: 2000, showConfirmButton: false });
                        actualizarContadores(data.conteo_modulos_asignaturas_matriculadas);
                        var row = data.listado_asignaturas_modulos[0];
                        table_matriculadas.row($tr).remove().draw();
                        table_ofertadas.row.add([
                            badgePorTipo(row.tipo),
                            row.asignatura,
                            row.sede,
                            row.seccion,
                            '<span class="badge bg-primary">' + row.unidades_valorativas + '</span>',
                            row.tipo === 'ASIGNATURA' ? btnHorarioHtml(row) : '',
                            '<button class="btn bg-azul btn-sm btn_prematricula" data-id_ofertada="' + row.id + '" style="font-size:12px;">' +
                            '<i data-feather="plus-circle" style="width:13px;height:13px;stroke:#fff;"></i> Matricular</button>'
                        ]).draw();
                        $('#cnt_ofertados_tab').text(table_ofertadas.rows().count());
                        setTimeout(feather.replace, 0);
                    }
                },
                error: function () {
                    Swal.fire({ icon: 'error', title: 'Error de conexión', text: 'No se pudo conectar con el servidor.', confirmButtonColor: '#203b76' });
                }
            });
        });
    }

    // ── HELPERS ─────────────────────────────────────────────────
    function actualizarContadores(conteo) {
        if (!conteo) return;
        conteo.forEach(function (c) {
            if (c.tipo === 'ASIGNATURA') {
                $('#cnt_asignaturas').text(c.matriculadas);
                $('#cnt_asignaturas_tab').text(c.matriculadas + ' Asig.');
            } else {
                $('#cnt_modulos').text(c.matriculadas);
                $('#cnt_modulos_tab').text(c.matriculadas + ' Mód.');
            }
        });
    }

    function badgePorTipo(tipo) {
        if (tipo === 'ASIGNATURA')
            return '<span class="badge-tipo asignatura"><i data-feather="book" style="width:10px;height:10px;"></i> Asignatura</span>';
        return '<span class="badge-tipo modulo"><i data-feather="layers" style="width:10px;height:10px;"></i> Módulo</span>';
    }

    function btnHorarioHtml(row) {
        return '<button type="button" class="btn btn-sm btn-outline-primary btn-horario"' +
            ' data-bs-toggle="modal" data-bs-target="#modal_horario"' +
            ' data-lunes="'     + (row.lunes     || '') + '"' +
            ' data-martes="'    + (row.martes    || '') + '"' +
            ' data-miercoles="' + (row.miercoles || '') + '"' +
            ' data-jueves="'    + (row.jueves    || '') + '"' +
            ' data-viernes="'   + (row.viernes   || '') + '"' +
            ' data-sabado="'    + (row.sabado    || '') + '"' +
            ' data-domingo="'   + (row.domingo   || '') + '"' +
            ' data-asignatura="' + row.asignatura + '"' +
            ' style="font-size:11px;"><i data-feather="clock" style="width:11px;height:11px;"></i> Ver</button>';
    }
</script>
@endpush
