@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <style>
        :root {
            --azul: #203b76;
            --verde: #1ba333;
            --verdeClaro: #d3eed7;
        }
        .card-header-pps,
        .card-header-pps h5,
        .card-header-pps small {
            background: var(--verdeOscuro) !important;
            color: #fff !important;
        }
        .badge-azul {
            background: var(--azul) !important;
            color: #fff !important;
        }
        .badge-verde {
            background: var(--verde) !important;
            color: #fff !important;
        }
        .slider-group {
            margin-bottom: 1.2rem;
        }
        .slider-label {
            font-weight: 500;
            font-size: 0.92rem;
        }
        .slider-val {
            min-width: 36px;
            text-align: center;
            font-size: 0.95rem;
        }
        .form-range::-webkit-slider-thumb {
            background-color: var(--amarillo) !important;
        }
        .form-range::-moz-range-thumb {
            background-color: var(--amarillo) !important;
        }
        .form-range::-webkit-slider-runnable-track {
            background: linear-gradient(to right, var(--amarillo) 0%, var(--amarillo) var(--fill-pct, 0%), #dee2e6 var(--fill-pct, 0%), #dee2e6 100%) !important;
            height: 6px;
            border-radius: 3px;
        }
        .form-range::-moz-range-track {
            background: #dee2e6 !important;
            height: 6px;
            border-radius: 3px;
        }
        .form-range::-moz-range-progress {
            background: var(--amarillo) !important;
            height: 6px;
            border-radius: 3px;
        }
        .nota-final-badge {
            font-size: 1.8rem !important;
            padding: 0.6rem 1.8rem !important;
            color: #fff !important;
            letter-spacing: 0.05em;
        }
        .nota-promedio-badge {
            font-size: 1.6rem;
            padding: 0.4rem 1.2rem;
            color: #fff !important;
        }
        .btn-amarillo-institucional {
            background: var(--amarillo) !important;
            color: #000 !important;
            border-color: var(--amarillo) !important;
        }
        .btn-amarillo-institucional:hover {
            background: #e6b800 !important;
            color: #000 !important;
            border-color: #e6b800 !important;
        }
        .upload-area {
            border: 2px dashed #adb5bd;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            background: #f8f9fa;
            cursor: pointer;
            transition: border-color 0.2s;
        }
        .upload-area:hover {
            border-color: var(--azul);
        }
        .upload-filename {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 0.4rem;
        }
    </style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">

            {{-- ENCABEZADO --}}
            <div class="card-header card-header-pps d-flex justify-content-between align-items-center flex-wrap gap-2" style="position:relative;">
                <div>
                    <h5 class="mb-0 d-flex align-items-center gap-2">
                        <i data-feather="award" style="width:22px;height:22px;"></i>
                        Evaluación PPS — Ingresar Nota
                    </h5>
                    <small class="opacity-75">
                        {{ $nombre_estudiante ?? '—' }}
                        &nbsp;|&nbsp; Registro: {{ $numero_registro_asignado }}
                        &nbsp;|&nbsp; {{ $tipo_asesor }}
                        &nbsp;|&nbsp; {{ $tipo_trabajo }}
                    </small>
                </div>
                <img src="{{ url(asset('/assets/images/UNAG_BLANCO.png')) }}"
                     class="d-none d-md-block"
                     style="position:absolute;right:20px;top:50%;transform:translateY(-50%);height:55px;opacity:0.9;">
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <a href="{{ url('docentes/cargaAcademica') }}" class="btn btn-outline-secondary btn-sm">
                        <i data-feather="arrow-left" style="width:14px;height:14px;"></i> Volver
                    </a>
                </div>

                {{-- ══════════════════════════════════════════════════════ --}}
                {{-- ESTADO: VALIDADO                                       --}}
                {{-- ══════════════════════════════════════════════════════ --}}
                @if($estado === 'validado')

                    <div class="text-center mb-4">
                        <div class="mb-2" style="color:var(--verde);">
                            <i data-feather="check-circle" style="width:48px;height:48px;"></i>
                        </div>
                        <span class="badge nota-final-badge" style="background:var(--verde);">
                            Nota Final: {{ $nota_final ?? '—' }}
                        </span>
                        <p class="text-muted mt-2">Esta evaluación ya fue validada y no puede modificarse.</p>

                        @if($tipo_asesor === 'Principal')
                        @php
                            $qActa = '?nuevo_formato=' . urlencode($nuevo_formato);
                            $qEval = '?nuevo_formato=' . urlencode($nuevo_formato) . '&tipo_trabajo=' . urlencode($tipo_trabajo);

                            $labelEval = match($tipo_trabajo) {
                                'Tesis'        => 'Evaluación de Tesis',
                                'Anteproyecto' => $nuevo_formato === 'SI' ? 'Evaluación Proyecto Tesis' : 'Evaluación Anteproyecto',
                                'Informe_final'=> $nuevo_formato === 'SI' ? 'Evaluación Final Tesis'   : 'Evaluación Informe Final',
                                default        => 'Evaluación',
                            };
                        @endphp
                        <div class="d-flex justify-content-center gap-2 mt-3">
                            <a class="btn btn-primary btn-sm" target="_blank"
                               href="{{ url('docentes/pps/' . $id . '/' . $numero_registro_asignado . '/acta') . $qActa }}">
                                <i data-feather="file-text" style="width:15px;height:15px;"></i> Acta de Sustentación
                            </a>
                            @if(in_array($tipo_trabajo, ['Tesis', 'Anteproyecto', 'Informe_final']))
                            <a class="btn btn-sm btn-amarillo-institucional" target="_blank"
                               href="{{ url('docentes/pps/' . $id . '/' . $numero_registro_asignado . '/evaluacion-reporte') . $qEval }}">
                                <i data-feather="clipboard" style="width:15px;height:15px;"></i> {{ $labelEval }}
                            </a>
                            @endif
                        </div>
                        @endif
                    </div>

                    <h6 class="fw-bold mt-3 mb-2">
                        <i data-feather="users" style="width:16px;height:16px;"></i> Notas por Evaluador
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-hover" id="tbl_docentes_val">
                            <thead style="background:var(--azul);">
                                <tr>
                                    <th style="color:#fff !important;">Docente</th>
                                    <th style="color:#fff !important;">Tipo Asesor</th>
                                    <th class="text-center" style="color:#fff !important;">Nota Oral</th>
                                    <th class="text-center" style="color:#fff !important;">Nota Escrita</th>
                                    <th class="text-center" style="color:#fff !important;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($nota_docentes as $nd)
                                <tr>
                                    <td>{{ $nd['docente'] ?? ($nd->docente ?? '—') }}</td>
                                    <td>{{ $nd['tipo_asesor'] ?? ($nd->tipo_asesor ?? '—') }}</td>
                                    <td class="text-center">{{ $nd['nota_oral'] ?? ($nd->nota_oral ?? 0) }}</td>
                                    <td class="text-center">{{ $nd['nota_escrita'] ?? ($nd->nota_escrita ?? 0) }}</td>
                                    <td class="text-center fw-bold">{{ $nd['nota_total'] ?? ($nd->nota_total ?? 0) }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center text-muted">Sin evaluaciones registradas.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                {{-- ══════════════════════════════════════════════════════ --}}
                {{-- ESTADO: NUEVO o EDITAR                                 --}}
                {{-- ══════════════════════════════════════════════════════ --}}
                @else

                    {{-- Formulario de sliders --}}
                    <form id="form_nota_pps">
                        @csrf
                        <input type="hidden" name="id_reserva"               value="{{ $id }}">
                        <input type="hidden" name="numero_registro_asignado"  value="{{ $numero_registro_asignado }}">
                        <input type="hidden" name="tipo_asesor"               value="{{ $tipo_asesor }}">
                        <input type="hidden" name="tipo_trabajo"              value="{{ $tipo_trabajo }}">

                        {{-- ── ORAL (común a todos) ──────────────────────── --}}
                        <div class="row mb-3">
                            <div class="col-12">
                                <h6 class="fw-bold" style="color:var(--azul);">
                                    <i data-feather="mic" style="width:16px;height:16px;"></i> Presentación Oral
                                </h6>
                            </div>

                            {{-- Expresión Oral (max 5) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Expresión Oral <small class="text-muted">(máx 5)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_oral">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['expresion_oral'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="oral" id="oral"
                                        min="0" max="5" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['expresion_oral'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            {{-- Ayuda Audiovisuales (max 5) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Ayuda Audiovisuales <small class="text-muted">(máx 5)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_audiovisual">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['ayuda_audiovisuales'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="audiovisual" id="audiovisual"
                                        min="0" max="5" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['ayuda_audiovisuales'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            {{-- Dominio del Tema --}}
                            @if($tipo_trabajo === 'Anteproyecto' || $nuevo_formato === 'NO')
                            {{-- dominio_tema max 30 --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Dominio del Tema <small class="text-muted">(máx 30)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_tema">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['dominio_tema'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="tema" id="tema"
                                        min="0" max="30" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['dominio_tema'] ?? 0) : 0 }}">
                                </div>
                            </div>
                            @else
                            {{-- RRNN nuevo_formato='SI' dominio_tema max 20 --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Dominio del Tema <small class="text-muted">(máx 20)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_tema">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['dominio_tema'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="tema" id="tema"
                                        min="0" max="20" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['dominio_tema'] ?? 0) : 0 }}">
                                </div>
                            </div>
                            @endif
                        </div>

                        <hr>

                        {{-- ── ESCRITA ────────────────────────────────────── --}}
                        <div class="row mb-3">
                            <div class="col-12">
                                <h6 class="fw-bold" style="color:var(--azul);">
                                    <i data-feather="file-text" style="width:16px;height:16px;"></i> Evaluación Escrita
                                </h6>
                            </div>

                            {{-- Título (max 2) — todos --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Título <small class="text-muted">(máx 2)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_titulo">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['titulo'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="titulo" id="titulo"
                                        min="0" max="2" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['titulo'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            @if($tipo_trabajo === 'Anteproyecto')
                            {{-- ── ANTEPROYECTO ──────────────────────────── --}}

                            {{-- Hipótesis (max 3) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Hipótesis <small class="text-muted">(máx 3)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_hipotesis">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['hipotesis'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="hipotesis" id="hipotesis"
                                        min="0" max="3" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['hipotesis'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            {{-- Introducción (max 10) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Introducción <small class="text-muted">(máx 10)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_introduccion">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['introduccion'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="introduccion" id="introduccion"
                                        min="0" max="10" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['introduccion'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            {{-- Objetivos (max 10) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Objetivos <small class="text-muted">(máx 10)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_objetivos">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['objetivos'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="objetivos" id="objetivos"
                                        min="0" max="10" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['objetivos'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            {{-- Revisión de Literatura (max 15) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Revisión de Literatura <small class="text-muted">(máx 15)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_literatura">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['revision_literatura'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="literatura" id="literatura"
                                        min="0" max="15" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['revision_literatura'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            {{-- Metodología (max 20) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Metodología <small class="text-muted">(máx 20)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_metodologia">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['metodologia'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="metodologia" id="metodologia"
                                        min="0" max="20" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['metodologia'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            @elseif($nuevo_formato === 'NO')
                            {{-- ── INFORME FINAL REGULAR ────────────────── --}}

                            {{-- Resumen (max 2) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Resumen <small class="text-muted">(máx 2)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_resumen">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['resumen'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="resumen" id="resumen"
                                        min="0" max="2" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['resumen'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            {{-- Introducción (max 3) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Introducción <small class="text-muted">(máx 3)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_introduccion">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['introduccion'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="introduccion" id="introduccion"
                                        min="0" max="3" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['introduccion'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            {{-- Objetivos (max 3) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Objetivos <small class="text-muted">(máx 3)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_objetivos">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['objetivos'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="objetivos" id="objetivos"
                                        min="0" max="3" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['objetivos'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            {{-- Revisión de Literatura (max 15) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Revisión de Literatura <small class="text-muted">(máx 15)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_literatura">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['revision_literatura'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="literatura" id="literatura"
                                        min="0" max="15" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['revision_literatura'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            {{-- Materiales y Métodos (max 10) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Materiales y Métodos <small class="text-muted">(máx 10)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_materiales">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['materiales_metodos'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="materiales" id="materiales"
                                        min="0" max="10" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['materiales_metodos'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            {{-- Resultados y Discusión (max 20) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Resultados y Discusión <small class="text-muted">(máx 20)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_resultados">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['resultados_discusion'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="resultados" id="resultados"
                                        min="0" max="20" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['resultados_discusion'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            {{-- Conclusiones y Recomendaciones (max 5) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Conclusiones y Recomendaciones <small class="text-muted">(máx 5)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_conclusiones">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['conclusiones_recomendaciones'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="conclusiones" id="conclusiones"
                                        min="0" max="5" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['conclusiones_recomendaciones'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            @else
                            {{-- ── INFORME FINAL RRNN (nuevo_formato='SI', IG-250201) ── --}}

                            {{-- Resumen (max 4) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Resumen <small class="text-muted">(máx 4)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_resumen">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['resumen'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="resumen" id="resumen"
                                        min="0" max="4" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['resumen'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            {{-- Introducción (max 5) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Introducción <small class="text-muted">(máx 5)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_introduccion">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['introduccion'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="introduccion" id="introduccion"
                                        min="0" max="5" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['introduccion'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            {{-- Hipótesis (max 2) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Hipótesis <small class="text-muted">(máx 2)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_hipotesis">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['hipotesis'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="hipotesis" id="hipotesis"
                                        min="0" max="2" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['hipotesis'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            {{-- Objetivos (max 3) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Objetivos <small class="text-muted">(máx 3)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_objetivos">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['objetivos'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="objetivos" id="objetivos"
                                        min="0" max="3" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['objetivos'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            {{-- Revisión de Literatura (max 12) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Revisión de Literatura <small class="text-muted">(máx 12)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_literatura">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['revision_literatura'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="literatura" id="literatura"
                                        min="0" max="12" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['revision_literatura'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            {{-- Metodología (max 12) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Metodología <small class="text-muted">(máx 12)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_metodologia">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['metodologia'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="metodologia" id="metodologia"
                                        min="0" max="12" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['metodologia'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            {{-- Resultados y Discusión (max 20) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Resultados y Discusión <small class="text-muted">(máx 20)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_resultados">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['resultados_discusion'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="resultados" id="resultados"
                                        min="0" max="20" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['resultados_discusion'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            {{-- Conclusiones y Recomendaciones (max 5) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Conclusiones y Recomendaciones <small class="text-muted">(máx 5)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_conclusiones">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['conclusiones_recomendaciones'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="conclusiones" id="conclusiones"
                                        min="0" max="5" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['conclusiones_recomendaciones'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            {{-- Referencias (max 5) --}}
                            <div class="col-md-4">
                                <div class="slider-group">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="slider-label">Referencias <small class="text-muted">(máx 5)</small></label>
                                        <span class="badge badge-azul slider-val" id="val_referencias">{{ $estado === 'editar' && $evaluacion ? ($evaluacion['referencias'] ?? 0) : 0 }}</span>
                                    </div>
                                    <input type="range" class="form-range" name="referencias" id="referencias"
                                        min="0" max="5" step="1"
                                        value="{{ $estado === 'editar' && $evaluacion ? ($evaluacion['referencias'] ?? 0) : 0 }}">
                                </div>
                            </div>

                            @endif
                        </div>

                        <div class="d-flex gap-2 mt-3">
                            <button type="button" id="btn_guardar_nota" class="btn btn-sm" style="background:var(--verde);color:#fff;">
                                <i data-feather="save" style="width:14px;height:14px;"></i> Guardar Nota
                            </button>
                            <a href="{{ url('docentes/cargaAcademica') }}" class="btn btn-secondary btn-sm">
                                <i data-feather="x" style="width:14px;height:14px;"></i> Cancelar
                            </a>
                        </div>
                    </form>

                    {{-- ══════════════════════════════════════════════════════ --}}
                    {{-- SECCIÓN VALIDACIÓN y TABLA (solo Principal)            --}}
                    {{-- ══════════════════════════════════════════════════════ --}}
                    @if($tipo_asesor === 'Principal')
                    @if($estado === 'editar' && $validar === 'Si')
                    <hr class="my-4">
                    <div class="card border-0" style="background:var(--verdeClaro);">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3" style="color:var(--azul);">
                                <i data-feather="check-square" style="width:16px;height:16px;"></i>
                                Validar Nota Final — Todos los evaluadores han ingresado su nota
                            </h6>

                            <div class="mb-3 text-center">
                                <p class="mb-1 text-muted">Nota Promedio Calculada</p>
                                <span class="badge nota-promedio-badge" style="background:var(--azul);">
                                    {{ $nota_promedio ?? '—' }}
                                </span>
                            </div>

                            <div class="row g-3 mb-3">
                                {{-- Archivo Informe --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Informe</label>
                                    <div class="upload-area" id="area_informe" onclick="document.getElementById('file_informe').click()">
                                        <i data-feather="upload" style="width:20px;height:20px;color:var(--azul);"></i>
                                        <span class="d-block mt-1">Seleccionar archivo</span>
                                    </div>
                                    <input type="file" id="file_informe" class="d-none">
                                    <div class="progress mt-1 d-none" id="prog_informe" style="height:6px;">
                                        <div class="progress-bar" id="bar_informe" style="background:var(--azul);width:0%"></div>
                                    </div>
                                    <div id="preview_informe" style="display:none;margin-top:10px;">
                                        <div class="card" style="border:1px solid var(--verde);border-radius:8px;background:#f0faf2;">
                                            <div class="card-body py-2 px-3 d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i data-feather="check-circle" style="width:20px;height:20px;stroke:var(--verde);"></i>
                                                    <span id="label_informe" style="font-size:13px;font-weight:600;color:var(--azul);word-break:break-all;"></span>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-danger ms-2" id="btn_quitar_informe" style="font-size:11px;white-space:nowrap;">
                                                    <i data-feather="x" style="width:12px;height:12px;"></i> Quitar
                                                </button>
                                            </div>
                                            <iframe id="iframe_informe" src="" style="width:100%;height:340px;border:none;border-top:1px solid #b2dfb8;border-radius:0 0 8px 8px;"></iframe>
                                            <div id="noprev_informe" style="display:none;padding:24px;text-align:center;border-top:1px solid #b2dfb8;">
                                                <i data-feather="eye-off" style="width:32px;height:32px;stroke:#6c757d;"></i>
                                                <p style="color:#6c757d;font-size:13px;margin:8px 0 12px;">Vista previa no disponible para este formato.</p>
                                                <a id="dl_informe" href="#" download style="font-size:13px;" class="btn btn-sm btn-outline-primary">
                                                    <i data-feather="download" style="width:13px;height:13px;"></i> Descargar archivo
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Archivo Presentación --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Presentación</label>
                                    <div class="upload-area" id="area_presentacion" onclick="document.getElementById('file_presentacion').click()">
                                        <i data-feather="upload" style="width:20px;height:20px;color:var(--azul);"></i>
                                        <span class="d-block mt-1">Seleccionar archivo</span>
                                    </div>
                                    <input type="file" id="file_presentacion" class="d-none">
                                    <div class="progress mt-1 d-none" id="prog_presentacion" style="height:6px;">
                                        <div class="progress-bar" id="bar_presentacion" style="background:var(--azul);width:0%"></div>
                                    </div>
                                    <div id="preview_presentacion" style="display:none;margin-top:10px;">
                                        <div class="card" style="border:1px solid var(--verde);border-radius:8px;background:#f0faf2;">
                                            <div class="card-body py-2 px-3 d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i data-feather="check-circle" style="width:20px;height:20px;stroke:var(--verde);"></i>
                                                    <span id="label_presentacion" style="font-size:13px;font-weight:600;color:var(--azul);word-break:break-all;"></span>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-danger ms-2" id="btn_quitar_presentacion" style="font-size:11px;white-space:nowrap;">
                                                    <i data-feather="x" style="width:12px;height:12px;"></i> Quitar
                                                </button>
                                            </div>
                                            <iframe id="iframe_presentacion" src="" style="width:100%;height:340px;border:none;border-top:1px solid #b2dfb8;border-radius:0 0 8px 8px;"></iframe>
                                            <div id="noprev_presentacion" style="display:none;padding:24px;text-align:center;border-top:1px solid #b2dfb8;">
                                                <i data-feather="eye-off" style="width:32px;height:32px;stroke:#6c757d;"></i>
                                                <p style="color:#6c757d;font-size:13px;margin:8px 0 12px;">Vista previa no disponible para este formato.</p>
                                                <a id="dl_presentacion" href="#" download style="font-size:13px;" class="btn btn-sm btn-outline-primary">
                                                    <i data-feather="download" style="width:13px;height:13px;"></i> Descargar archivo
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" id="btn_validar_nota" class="btn btn-sm" style="background:var(--azul);color:#fff;">
                                <i data-feather="shield" style="width:14px;height:14px;"></i> Validar Nota
                            </button>
                        </div>
                    </div>
                    @elseif($estado === 'editar')
                    <div class="alert alert-warning mt-3" role="alert">
                        <i data-feather="alert-triangle" style="width:15px;height:15px;"></i>
                        <strong>Faltan evaluaciones:</strong> No todos los asesores han ingresado su nota aún. La validación estará disponible cuando todos hayan participado.
                    </div>
                    @endif

                    {{-- ══════════════════════════════════════════════════════ --}}
                    {{-- TABLA DE EVALUADORES (estado='editar')                 --}}
                    {{-- ══════════════════════════════════════════════════════ --}}
                    @if($estado === 'editar' && count($nota_docentes) > 0)
                    <hr class="mt-4">
                    <h6 class="fw-bold mt-2 mb-2">
                        <i data-feather="users" style="width:16px;height:16px;"></i> Notas Ingresadas por Evaluador
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm table-hover" id="tbl_docentes_ed">
                            <thead style="background:var(--azul);">
                                <tr>
                                    <th style="color:#fff !important;">Docente</th>
                                    <th style="color:#fff !important;">Tipo Asesor</th>
                                    <th class="text-center" style="color:#fff !important;">Nota Oral</th>
                                    <th class="text-center" style="color:#fff !important;">Nota Escrita</th>
                                    <th class="text-center" style="color:#fff !important;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($nota_docentes as $nd)
                                <tr>
                                    <td>{{ $nd['docente'] ?? ($nd->docente ?? '—') }}</td>
                                    <td>{{ $nd['tipo_asesor'] ?? ($nd->tipo_asesor ?? '—') }}</td>
                                    <td class="text-center">{{ $nd['nota_oral'] ?? ($nd->nota_oral ?? 0) }}</td>
                                    <td class="text-center">{{ $nd['nota_escrita'] ?? ($nd->nota_escrita ?? 0) }}</td>
                                    <td class="text-center fw-bold">{{ $nd['nota_total'] ?? ($nd->nota_total ?? 0) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @endif {{-- fin if Principal --}}

                @endif {{-- fin else (nuevo|editar) --}}

            </div>{{-- card-body --}}
        </div>{{-- card --}}
    </div>{{-- col --}}
</div>{{-- row --}}
@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
(function () {
    // ── Helpers de slider ────────────────────────────────────────────────────
    function updateSliderFill(input) {
        var min = parseFloat(input.min) || 0;
        var max = parseFloat(input.max) || 100;
        var val = parseFloat(input.value) || 0;
        var pct = max === min ? 0 : ((val - min) / (max - min)) * 100;
        input.style.setProperty('--fill-pct', pct + '%');
    }

    function bindSlider(inputId, badgeId) {
        var el = document.getElementById(inputId);
        var badge = document.getElementById(badgeId);
        if (!el || !badge) return;
        updateSliderFill(el);
        el.addEventListener('input', function () {
            badge.textContent = this.value;
            updateSliderFill(this);
        });
    }

    // Oral (todos)
    bindSlider('oral',       'val_oral');
    bindSlider('audiovisual','val_audiovisual');
    bindSlider('tema',       'val_tema');

    // Escrita — común
    bindSlider('titulo',     'val_titulo');

    // Escrita — según tipo
    bindSlider('hipotesis',   'val_hipotesis');
    bindSlider('introduccion','val_introduccion');
    bindSlider('objetivos',   'val_objetivos');
    bindSlider('literatura',  'val_literatura');
    bindSlider('metodologia', 'val_metodologia');
    bindSlider('resumen',     'val_resumen');
    bindSlider('materiales',  'val_materiales');
    bindSlider('resultados',  'val_resultados');
    bindSlider('conclusiones','val_conclusiones');
    bindSlider('referencias', 'val_referencias');

    // ── CSRF token ───────────────────────────────────────────────────────────
    function csrfToken() {
        var m = document.querySelector('meta[name="csrf-token"]');
        return m ? m.getAttribute('content') : '';
    }

    // ── Guardar nota ─────────────────────────────────────────────────────────
    var btnGuardar = document.getElementById('btn_guardar_nota');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', function () {
            var form = document.getElementById('form_nota_pps');
            var data = {};
            var inputs = form.querySelectorAll('input[name]');
            inputs.forEach(function (el) {
                data[el.name] = el.value;
            });

            btnGuardar.disabled = true;
            btnGuardar.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Guardando...';

            fetch('{{ url("docentes/pps/guardar-nota") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken(),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                btnGuardar.disabled = false;
                btnGuardar.innerHTML = '<i data-feather="save" style="width:14px;height:14px;"></i> Guardar Nota';
                feather.replace();

                if (res.msgSuccess) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Guardado',
                        text: res.msgSuccess,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(function () {
                        window.location.href = '{{ url("docentes/cargaAcademica") }}';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: res.msgError || 'Ocurrió un error al guardar.'
                    });
                }
            })
            .catch(function (err) {
                btnGuardar.disabled = false;
                btnGuardar.innerHTML = '<i data-feather="save" style="width:14px;height:14px;"></i> Guardar Nota';
                feather.replace();
                Swal.fire({ icon: 'error', title: 'Error', text: 'Error de red: ' + err.message });
            });
        });
    }

    // ── Upload de archivos (validación) ──────────────────────────────────────
    var filenameInforme      = null;
    var filenamePresentacion = null;

    var URL_DELETE_FILE = '{{ url("docentes/pps/delete-file-temp") }}';

    var URL_DELETE_FILE  = '{{ url("docentes/pps/delete-file-temp") }}';
    var blobUrlInforme      = null;
    var blobUrlPresentacion = null;

    function handleFileInput(inputId, areaId, progId, barId, previewId, labelId, iframeId, noprevId, dlId, blobSetter, callback) {
        var input = document.getElementById(inputId);
        if (!input) return;
        input.addEventListener('change', function () {
            var file = this.files[0];
            if (!file) return;

            var blobUrl = URL.createObjectURL(file);
            blobSetter(blobUrl);
            var isPdf = file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf');
            if (isPdf) {
                document.getElementById(iframeId).src = blobUrl;
                document.getElementById(iframeId).style.display = 'block';
                document.getElementById(noprevId).style.display = 'none';
            } else {
                document.getElementById(iframeId).src = '';
                document.getElementById(iframeId).style.display = 'none';
                document.getElementById(dlId).href = blobUrl;
                document.getElementById(dlId).download = file.name;
                document.getElementById(noprevId).style.display = 'block';
                setTimeout(feather.replace, 0);
            }

            var progEl = document.getElementById(progId);
            var barEl  = document.getElementById(barId);
            progEl.classList.remove('d-none');
            barEl.style.width = '0%';

            var formData = new FormData();
            formData.append('file', file);
            formData.append('_token', csrfToken());

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ url("docentes/pps/upload-file") }}', true);
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken());
            xhr.setRequestHeader('Accept', 'application/json');

            xhr.upload.onprogress = function (e) {
                if (e.lengthComputable) {
                    barEl.style.width = Math.round((e.loaded / e.total) * 100) + '%';
                }
            };

            xhr.onload = function () {
                progEl.classList.add('d-none');
                try {
                    var res = JSON.parse(xhr.responseText);
                    if (res.filename) {
                        callback(res.filename);
                        document.getElementById(labelId).textContent = file.name;
                        document.getElementById(areaId).style.display = 'none';
                        document.getElementById(previewId).style.display = 'block';
                        setTimeout(feather.replace, 0);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error al subir archivo', text: res.error || 'Error desconocido.' });
                        URL.revokeObjectURL(blobUrl);
                        blobSetter(null);
                    }
                } catch (e) {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Respuesta inválida del servidor.' });
                }
            };

            xhr.onerror = function () {
                progEl.classList.add('d-none');
                Swal.fire({ icon: 'error', title: 'Error', text: 'Error de red al subir el archivo.' });
                URL.revokeObjectURL(blobUrl);
                blobSetter(null);
            };

            xhr.send(formData);
        });
    }

    function quitarArchivo(areaId, previewId, iframeId, noprevId, dlId, inputId, filenameActual, blobUrl, blobSetter, resetCallback) {
        if (!filenameActual) return;
        fetch(URL_DELETE_FILE, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken(), 'Accept': 'application/json' },
            body: JSON.stringify({ filename: filenameActual })
        }).catch(function () {});
        if (blobUrl) { URL.revokeObjectURL(blobUrl); blobSetter(null); }
        resetCallback(null);
        document.getElementById(iframeId).src = '';
        document.getElementById(iframeId).style.display = 'block';
        document.getElementById(noprevId).style.display = 'none';
        document.getElementById(dlId).href = '#';
        document.getElementById(previewId).style.display = 'none';
        document.getElementById(areaId).style.display = '';
        document.getElementById(inputId).value = '';
    }

    handleFileInput('file_informe', 'area_informe', 'prog_informe', 'bar_informe', 'preview_informe', 'label_informe', 'iframe_informe', 'noprev_informe', 'dl_informe',
        function (v) { blobUrlInforme = v; },
        function (fn) { filenameInforme = fn; }
    );

    handleFileInput('file_presentacion', 'area_presentacion', 'prog_presentacion', 'bar_presentacion', 'preview_presentacion', 'label_presentacion', 'iframe_presentacion', 'noprev_presentacion', 'dl_presentacion',
        function (v) { blobUrlPresentacion = v; },
        function (fn) { filenamePresentacion = fn; }
    );

    document.getElementById('btn_quitar_informe') && document.getElementById('btn_quitar_informe').addEventListener('click', function () {
        quitarArchivo('area_informe', 'preview_informe', 'iframe_informe', 'noprev_informe', 'dl_informe', 'file_informe', filenameInforme, blobUrlInforme,
            function (v) { blobUrlInforme = v; },
            function (v) { filenameInforme = v; }
        );
    });

    document.getElementById('btn_quitar_presentacion') && document.getElementById('btn_quitar_presentacion').addEventListener('click', function () {
        quitarArchivo('area_presentacion', 'preview_presentacion', 'iframe_presentacion', 'noprev_presentacion', 'dl_presentacion', 'file_presentacion', filenamePresentacion, blobUrlPresentacion,
            function (v) { blobUrlPresentacion = v; },
            function (v) { filenamePresentacion = v; }
        );
    });

    // ── Validar nota ─────────────────────────────────────────────────────────
    var btnValidar = document.getElementById('btn_validar_nota');
    if (btnValidar) {
        btnValidar.addEventListener('click', function () {
            var nota = '{{ $nota_promedio ?? "" }}';

            if (!nota) {
                Swal.fire({ icon: 'warning', title: 'Sin nota promedio', text: 'No se pudo calcular la nota promedio.' });
                return;
            }

            if (!filenameInforme) {
                Swal.fire({ icon: 'warning', title: 'Informe requerido', text: 'Debes subir el informe final antes de validar la nota.', confirmButtonColor: '#203b76' });
                return;
            }

            if (!filenamePresentacion) {
                Swal.fire({ icon: 'warning', title: 'Presentación requerida', text: 'Debes subir la presentación antes de validar la nota.', confirmButtonColor: '#203b76' });
                return;
            }

            Swal.fire({
                icon: 'question',
                title: '¿Validar nota?',
                html: 'Se registrará la nota final de <strong>' + nota + '</strong> puntos.<br>Esta acción no se puede deshacer.',
                showCancelButton: true,
                confirmButtonText: 'Sí, validar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#203b76'
            }).then(function (result) {
                if (!result.isConfirmed) return;

                btnValidar.disabled = true;
                btnValidar.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Validando...';

                fetch('{{ url("docentes/pps/" . $id . "/validar-nota") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken(),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        nota:  nota,
                        copia: filenameInforme,
                        copia2: filenamePresentacion
                    })
                })
                .then(function (r) { return r.json(); })
                .then(function (res) {
                    btnValidar.disabled = false;
                    btnValidar.innerHTML = '<i data-feather="shield" style="width:14px;height:14px;"></i> Validar Nota';
                    feather.replace();

                    if (res.msgSuccess) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Validado',
                            text: res.msgSuccess,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function () {
                            window.location.href = '{{ url("docentes/cargaAcademica") }}';
                        });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: res.msgError || 'Ocurrió un error al validar.' });
                    }
                })
                .catch(function (err) {
                    btnValidar.disabled = false;
                    btnValidar.innerHTML = '<i data-feather="shield" style="width:14px;height:14px;"></i> Validar Nota';
                    feather.replace();
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Error de red: ' + err.message });
                });
            });
        });
    }

})();
</script>
@endpush
