@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('css/handsontable.full.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <style>
        #hot { width: 100%; }
        .wtHolder { overflow-x: auto !important; overflow-y: auto !important; }
        .ht_clone_top .wtHolder { overflow-x: hidden !important; }

        /* Fila con suma de notas que excede 100 */
        .htCore td.fila-suma-excedida {
            background-color: #fde8e8 !important;
            border-top: 1px solid #dc3545 !important;
            border-bottom: 1px solid #dc3545 !important;
        }

        .stat-card { border-left: 4px solid var(--azul); transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-label { font-size: 11px; text-transform: uppercase; letter-spacing: .5px; color: #6c757d; font-weight: 600; }
        .stat-value { font-size: 28px; font-weight: 700; color: var(--azul); }
        .stat-sub { font-size: 12px; color: #888; }

        .periodo-banner { border-radius: 8px; padding: 10px 18px; font-weight: 600; display: flex; align-items: center; gap: 10px; }
        .periodo-abierto { background: #d3eed7; color: var(--verdeOscuro); }
        .periodo-cerrado { background: #fde8e8; color: var(--rojo); }

        .acciones-toolbar { display: flex; flex-wrap: wrap; gap: 8px; justify-content: flex-end; margin-bottom: 16px; }

        #hot { width: 100%; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 24px rgba(19,84,35,0.12); font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; animation: hotFadeIn 0.4s ease forwards; }

        .handsontable table.htCore { border-collapse: separate; border-spacing: 0; }
        .handsontable thead th,
        .handsontable .ht_clone_top thead th,
        .handsontable .ht_clone_left thead th,
        .handsontable .ht_clone_top_left_corner thead th {
            background: #135423 !important; color: #ffffff !important; font-weight: 700 !important;
            font-size: 11.5px !important; letter-spacing: 0.4px !important; text-transform: uppercase !important;
            padding: 10px 8px !important; border-right: 1px solid rgba(255,255,255,0.12) !important;
            border-bottom: 2px solid #1ba333 !important; white-space: nowrap !important;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }
        .handsontable thead th .colHeader, .handsontable thead th span,
        .handsontable .ht_clone_top thead th .colHeader, .handsontable .ht_clone_top thead th span { color: #ffffff !important; }
        .handsontable thead th .changeType, .handsontable thead th button.changeType,
        .handsontable .htDropdownMenu { display: none !important; }
        .handsontable thead th:hover { background: #1ba333 !important; cursor: pointer; }
        .handsontable .rowHeader, .handsontable .ht_clone_left tbody th {
            background: #f0fff4 !important; color: #135423 !important; font-weight: 700 !important;
            font-size: 11px !important; border-right: 2px solid #b2dfb8 !important; text-align: center !important;
        }
        .handsontable td {
            font-size: 13px !important; font-family: 'Segoe UI', system-ui, sans-serif !important;
            padding: 5px 10px !important; border-right: 1px solid #e8f0e9 !important;
            border-bottom: 1px solid #e8f0e9 !important; transition: background 0.15s ease;
            vertical-align: middle !important; white-space: nowrap !important; line-height: 1.3 !important;
        }
        .handsontable tr:nth-child(even) td { background-color: #f5fbf5 !important; }
        .handsontable tr:nth-child(odd) td  { background-color: #ffffff !important; }
        .handsontable tr:hover td           { background-color: #e8f5e9 !important; }
        .handsontable td.area, .handsontable td.current { background-color: #c8e6c9 !important; border: 1px solid #135423 !important; outline: none !important; }
        .handsontable .ht_clone_left td { background: #f0fff4 !important; border-right: 2px solid #b2dfb8 !important; font-weight: 600 !important; color: #0f4019 !important; }
        .handsontable .ht_clone_left tr:nth-child(even) td { background: #e8f5e9 !important; }
        .handsontable .ht_clone_left tr:hover td { background: #c8e6c9 !important; }
        .handsontable td.htInvalid { background-color: #fff0f0 !important; border: 1px solid #ff4d4d !important; }
        .handsontable .handsontableInput {
            font-size: 13px !important; color: #0f4019 !important; background: #f0fff4 !important;
            border: 2px solid #135423 !important; border-radius: 4px !important;
            padding: 4px 8px !important; box-shadow: 0 0 0 3px rgba(19,84,35,0.12) !important; outline: none !important;
        }
        .wtHolder::-webkit-scrollbar { width: 7px; height: 7px; }
        .wtHolder::-webkit-scrollbar-track { background: #f0fff4; border-radius: 4px; }
        .wtHolder::-webkit-scrollbar-thumb { background: #7bc47f; border-radius: 4px; }
        .wtHolder::-webkit-scrollbar-thumb:hover { background: #135423; }
        .handsontable .wtBorder.current { background-color: #135423 !important; }
        .handsontable .wtBorder.area    { background-color: #1ba333 !important; }
        .handsontable .ht_clone_top_left_corner thead th { background: #0f4019 !important; }

        @keyframes hotFadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            #hot { overflow: visible !important; border-radius: 4px !important; }
            .ht_clone_left, .ht_clone_top_left_corner { display: none !important; }
            .wtHolder { overflow-x: auto !important; -webkit-overflow-scrolling: touch !important; }
            .acciones-toolbar { justify-content: flex-start; }
            .stat-value { font-size: 20px; }
        }
    </style>
@endpush

@section('content')
    @foreach ($modulos_list as $rowObj)
        @php $row = (array) $rowObj; @endphp

        {{-- ============================================================ --}}
        {{-- ENCABEZADO                                                    --}}
        {{-- ============================================================ --}}
        <div class="row">
            <div class="col-12">
                <div class="card bg-primary" style="border:none;">
                    <div class="card-body py-3" style="position:relative;">
                        <div class="d-flex align-items-center gap-3">
                            <i data-feather="award" style="width:48px;height:48px;color:#fff;stroke:#fff;flex-shrink:0;"></i>
                            <div>
                                <h2 class="mb-0 fw-bold text-white" style="font-size:28px;letter-spacing:1px;">
                                    CUADRO DE CALIFICACIONES — MÓDULOS
                                </h2>
                                <div class="mt-1 text-white" style="font-size:13px;font-weight:600;letter-spacing:0.5px;">
                                    <i data-feather="book-open" style="width:13px;height:13px;stroke:#ffffff;"></i>
                                    {{ strtoupper($row['carrera']) }}
                                </div>
                            </div>
                        </div>
                        <img src="{{ url(asset('/assets/images/UNAG_BLANCO.png')) }}"
                             class="d-none d-md-block"
                             style="position:absolute;right:20px;top:50%;transform:translateY(-50%);height:60px;opacity:0.9;">
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- TARJETAS DE INFORMACIÓN                                       --}}
        {{-- ============================================================ --}}
        <div class="row g-3 mb-3 mt-1">

            {{-- Módulo --}}
            <div class="col-md-3 col-sm-6">
                <div class="card stat-card h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="stat-label mb-1">
                            <i data-feather="layers" style="width:14px;height:14px;"></i> Módulo
                        </div>
                        <div class="stat-value" style="font-size:18px;">{{ $row['modulo'] }}</div>
                        <div class="stat-sub mt-1">
                            <span class="badge bg-secondary" style="color:#fff !important;">{{ $row['laboratorio'] }}</span>
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
                    </div>
                </div>
            </div>

            {{-- Bloque --}}
            <div class="col-md-3 col-sm-6">
                <div class="card stat-card h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-center gap-2">
                        <div>
                            <div class="stat-label mb-1">
                                <i data-feather="grid" style="width:14px;height:14px;"></i> Bloque
                            </div>
                            <div class="stat-value">{{ $row['etiqueta_bloque'] }}</div>
                        </div>
                        <div class="border-top pt-2">
                            <div class="stat-label">Período Académico</div>
                            <div style="font-size:20px;font-weight:700;color:var(--azul);">
                                {{ $row['periodo_academico_bloque'] }}
                            </div>
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
                            <div id="lblAPR" class="rounded p-1 text-white text-center" style="background:#135423;font-size:11px;font-weight:700;">
                                <i data-feather="arrow-up" style="width:11px;height:11px;stroke:#fff;"></i> APR: {{ $row['aprobados'] }}
                            </div>
                            <div id="lblREP" class="rounded p-1 text-white text-center" style="background:#1ba333;font-size:11px;font-weight:700;">
                                <i data-feather="arrow-down" style="width:11px;height:11px;stroke:#fff;"></i> REP: {{ $row['reprobados'] }}
                            </div>
                            <div id="lblNSP" class="rounded p-1 text-white text-center" style="background:#2d7a3a;font-size:11px;font-weight:700;">
                                — NSP: {{ $row['nsp'] }}
                            </div>
                            <div id="lblABD" class="rounded p-1 text-white text-center" style="background:#4a9e57;font-size:11px;font-weight:700;">
                                — ABD: {{ $row['abd'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ============================================================ --}}
        {{-- ESTADO DEL PERIODO                                            --}}
        {{-- ============================================================ --}}
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div id="divInfoCerrado"
                    class="periodo-banner periodo-cerrado @if ($tieneAccesoGuardarCalificacionesModulos == 1) d-none @endif">
                    <i data-feather="lock" style="width:22px;height:22px;"></i>
                    <div>
                        <div>PERIODO CERRADO</div>
                        <small style="font-weight:400;">No hay periodo de calificaciones aperturado</small>
                    </div>
                </div>
                <div id="divInfoAperturado"
                    class="periodo-banner periodo-abierto @if ($tieneAccesoGuardarCalificacionesModulos != 1) d-none @endif">
                    <i data-feather="unlock" style="width:22px;height:22px;"></i>
                    <div>
                        <div>PERIODO ABIERTO</div>
                        <small style="font-weight:400;">Registro de calificaciones habilitado</small>
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
                    <div class="card-header bg-verdeClaro d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i data-feather="edit-3" class="icon-lg pb-3px"></i> Cuadro de Calificaciones
                        </h5>
                    </div>
                    <div class="card-body">

                        {{-- Toolbar --}}
                        <div class="acciones-toolbar">
                            <a class="btn bg-azul btn-sm" id="btnRegresar" href="{{ url('/') }}/docentes/cargaAcademica">
                                <i data-feather="arrow-left" style="width:15px;height:15px;"></i> Regresar
                            </a>
                            <a class="btn btn-warning btn-sm" id="btnObservaciones">
                                <i data-feather="message-square" style="width:15px;height:15px;"></i> Observaciones
                            </a>
                            <a class="btn btn-primary btn-sm" target="_blank"
                               href="{{ url('/docentes/' . $row['id_empleado'] . '/modulos/' . $row['id_bloque_modulo'] . '/calificaciones/' . $row['id_modulo'] . '/cuadro') }}">
                                <i data-feather="file-text" style="width:15px;height:15px;"></i> Cuadro PDF
                            </a>
                            @if ($tieneAccesoGuardarCalificacionesModulos == 1 && $currentUserId == $docenteId)
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
        {{-- MODAL OBSERVACIONES DEL CUADRO                               --}}
        {{-- ============================================================ --}}
        <div class="modal fade" id="frmAcaBloqueModulo" tabindex="-1" aria-hidden="true">
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
                            Las observaciones serán visualizables en el cuadro impreso de calificaciones.
                        </small>
                    </div>
                    <div class="modal-footer bg-secondary">
                        <button type="button" class="btn btn-danger btn-xs" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn-xs" id="btnGuardarObservaciones">
                            <i data-feather="save" style="width:14px;height:14px;"></i> Guardar
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

    @foreach ($modulos_list as $rowObj)
        @php $row = (array) $rowObj; @endphp
        <script type="text/javascript">

            var idEstadoAbandono    = 4;
            var idEstadoNoSePresento = 3;
            var idEstadoReprobado   = 1;
            var minimo_aprobacion   = {{ $row['minimo_aprobacion'] ?? 60 }};

            var urlguardarObservaciones = "{{ url('docentes/modulos/' . $bloqueModuloId . '/guardarObservaciones') }}";

            var matriculados  = null;
            var hot           = null;
            var filasConError    = new Set();
            var _toastErrorTimeout = null;
            var dataOutput    = null;
            var gradeValidator = null;
            var hayChangios = false;
            var navegandoConPermiso = false;

            // ─── Columna nota final (no hay recuperacion en módulos) ──────
            var columnaNotaFinal =
                2 +
                @if ($row['nota_nombre_1']  != null) 1 @else 0 @endif +
                @if ($row['nota_nombre_2']  != null) 1 @else 0 @endif +
                @if ($row['nota_nombre_3']  != null) 1 @else 0 @endif +
                @if ($row['nota_nombre_4']  != null) 1 @else 0 @endif +
                @if ($row['nota_nombre_5']  != null) 1 @else 0 @endif +
                @if ($row['nota_nombre_6']  != null) 1 @else 0 @endif +
                @if ($row['nota_nombre_7']  != null) 1 @else 0 @endif +
                @if ($row['nota_nombre_8']  != null) 1 @else 0 @endif +
                @if ($row['nota_nombre_9']  != null) 1 @else 0 @endif +
                @if ($row['nota_nombre_10'] != null) 1 @else 0 @endif +
                @if ($row['nota_nombre_11'] != null) 1 @else 0 @endif +
                @if ($row['nota_nombre_12'] != null) 1 @else 0 @endif +
                @if ($row['nota_nombre_13'] != null) 1 @else 0 @endif +
                @if ($row['nota_nombre_14'] != null) 1 @else 0 @endif +
                @if ($row['nota_nombre_15'] != null) 1 @else 0 @endif ;

            var columnaEstadoCalificacion = columnaNotaFinal + 1;

            // ─── SweetAlert helpers ───────────────────────────────────────
            function espera(html) {
                Swal.fire({
                    imageUrl: "{{ url(asset('/assets/images/unag_loading.gif')) }}",
                    title: '¡Espera!', html: html,
                    allowOutsideClick: false, allowEscapeKey: false, allowEnterKey: false,
                    didOpen: () => { Swal.showLoading(); }
                });
            }

            $(document).ready(function () {

                espera('Cargando calificaciones...');

                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

                // ── Observaciones ────────────────────────────────────────
                $('#btnObservaciones').on('click', function () {
                    $('#frmAcaBloqueModulo').modal('show');
                });

                $('#btnGuardarObservaciones').on('click', function () {
                    var txtObs = $('#txtObservacion').val();
                    $('#frmAcaBloqueModulo').modal('hide');
                    espera('Guardando observaciones...');
                    $.ajax({
                        type: 'post', url: urlguardarObservaciones,
                        data: { observaciones: txtObs, bloqueModuloId: {{ $bloqueModuloId }} },
                        success: function (data) {
                            Swal.close();
                            if (data.msgError != null) {
                                Swal.fire('Error', data.msgError, 'error');
                            } else {
                                Swal.fire({ icon: 'success', title: 'Guardado', text: data.msgSuccess, timer: 2000, showConfirmButton: false });
                            }
                        },
                        error: function (xhr) {
                            Swal.close();
                            console.log(xhr.responseText);
                        }
                    });
                });

                // ── Validador ─────────────────────────────────────────────
                gradeValidator = function (value, callback) {
                    callback(value >= 0 && value <= 100);
                };

                // ── Cargar matriculados ───────────────────────────────────
                $.ajax({
                    url: "{{ url('docentes/obtener-matriculados-modulo') }}",
                    type: 'post',
                    data: { bloqueModuloId: {{ $bloqueModuloId }}, idDocente: {{ $docenteId }} },
                    success: function (data) {
                        matriculados = data.matriculados;

                        var hotElement  = document.querySelector('#hot');
                        var hotSettings = {
                            data: matriculados,
                            columns: [
                                { data: 'numero_registro_estudiante', type: 'text', readOnly: true },
                                { data: 'nombre_completo_por_apellido', type: 'text', readOnly: true },
                                @if ($row['nota_nombre_1'] != null)
                                {
                                    data: 'nota_1', type: 'numeric',
                                    @if ($currentUserId != $row['docente_calificador_1'] || $tieneAccesoGuardarCalificacionesModulos != 1)
                                        readOnly: true,
                                    @else
                                        readOnly: false,
                                    @endif
                                    numericFormat: { pattern: '0.00' }, validator: gradeValidator
                                },
                                @endif
                                @if ($row['nota_nombre_2'] != null)
                                {
                                    data: 'nota_2', type: 'numeric',
                                    @if ($currentUserId != $row['docente_calificador_2'] || $tieneAccesoGuardarCalificacionesModulos != 1)
                                        readOnly: true,
                                    @else
                                        readOnly: false,
                                    @endif
                                    numericFormat: { pattern: '0.00' }, validator: gradeValidator
                                },
                                @endif
                                @if ($row['nota_nombre_3'] != null)
                                {
                                    data: 'nota_3', type: 'numeric',
                                    @if ($currentUserId != $row['docente_calificador_3'] || $tieneAccesoGuardarCalificacionesModulos != 1)
                                        readOnly: true,
                                    @else
                                        readOnly: false,
                                    @endif
                                    numericFormat: { pattern: '0.00' }, validator: gradeValidator
                                },
                                @endif
                                @if ($row['nota_nombre_4'] != null)
                                {
                                    data: 'nota_4', type: 'numeric',
                                    @if ($currentUserId != $row['docente_calificador_4'] || $tieneAccesoGuardarCalificacionesModulos != 1)
                                        readOnly: true,
                                    @else
                                        readOnly: false,
                                    @endif
                                    numericFormat: { pattern: '0.00' }, validator: gradeValidator
                                },
                                @endif
                                @if ($row['nota_nombre_5'] != null)
                                {
                                    data: 'nota_5', type: 'numeric',
                                    @if ($currentUserId != $row['docente_calificador_5'] || $tieneAccesoGuardarCalificacionesModulos != 1)
                                        readOnly: true,
                                    @else
                                        readOnly: false,
                                    @endif
                                    numericFormat: { pattern: '0.00' }, validator: gradeValidator
                                },
                                @endif
                                @if ($row['nota_nombre_6'] != null)
                                {
                                    data: 'nota_6', type: 'numeric',
                                    @if ($currentUserId != $row['docente_calificador_6'] || $tieneAccesoGuardarCalificacionesModulos != 1)
                                        readOnly: true,
                                    @else
                                        readOnly: false,
                                    @endif
                                    numericFormat: { pattern: '0.00' }, validator: gradeValidator
                                },
                                @endif
                                @if ($row['nota_nombre_7'] != null)
                                {
                                    data: 'nota_7', type: 'numeric',
                                    @if ($currentUserId != $row['docente_calificador_7'] || $tieneAccesoGuardarCalificacionesModulos != 1)
                                        readOnly: true,
                                    @else
                                        readOnly: false,
                                    @endif
                                    numericFormat: { pattern: '0.00' }, validator: gradeValidator
                                },
                                @endif
                                @if ($row['nota_nombre_8'] != null)
                                {
                                    data: 'nota_8', type: 'numeric',
                                    @if ($currentUserId != $row['docente_calificador_8'] || $tieneAccesoGuardarCalificacionesModulos != 1)
                                        readOnly: true,
                                    @else
                                        readOnly: false,
                                    @endif
                                    numericFormat: { pattern: '0.00' }, validator: gradeValidator
                                },
                                @endif
                                @if ($row['nota_nombre_9'] != null)
                                {
                                    data: 'nota_9', type: 'numeric',
                                    @if ($currentUserId != $row['docente_calificador_9'] || $tieneAccesoGuardarCalificacionesModulos != 1)
                                        readOnly: true,
                                    @else
                                        readOnly: false,
                                    @endif
                                    numericFormat: { pattern: '0.00' }, validator: gradeValidator
                                },
                                @endif
                                @if ($row['nota_nombre_10'] != null)
                                {
                                    data: 'nota_10', type: 'numeric',
                                    @if ($currentUserId != $row['docente_calificador_10'] || $tieneAccesoGuardarCalificacionesModulos != 1)
                                        readOnly: true,
                                    @else
                                        readOnly: false,
                                    @endif
                                    numericFormat: { pattern: '0.00' }, validator: gradeValidator
                                },
                                @endif
                                @if ($row['nota_nombre_11'] != null)
                                {
                                    data: 'nota_11', type: 'numeric',
                                    @if ($currentUserId != $row['docente_calificador_11'] || $tieneAccesoGuardarCalificacionesModulos != 1)
                                        readOnly: true,
                                    @else
                                        readOnly: false,
                                    @endif
                                    numericFormat: { pattern: '0.00' }, validator: gradeValidator
                                },
                                @endif
                                @if ($row['nota_nombre_12'] != null)
                                {
                                    data: 'nota_12', type: 'numeric',
                                    @if ($currentUserId != $row['docente_calificador_12'] || $tieneAccesoGuardarCalificacionesModulos != 1)
                                        readOnly: true,
                                    @else
                                        readOnly: false,
                                    @endif
                                    numericFormat: { pattern: '0.00' }, validator: gradeValidator
                                },
                                @endif
                                @if ($row['nota_nombre_13'] != null)
                                {
                                    data: 'nota_13', type: 'numeric',
                                    @if ($currentUserId != $row['docente_calificador_13'] || $tieneAccesoGuardarCalificacionesModulos != 1)
                                        readOnly: true,
                                    @else
                                        readOnly: false,
                                    @endif
                                    numericFormat: { pattern: '0.00' }, validator: gradeValidator
                                },
                                @endif
                                @if ($row['nota_nombre_14'] != null)
                                {
                                    data: 'nota_14', type: 'numeric',
                                    @if ($currentUserId != $row['docente_calificador_14'] || $tieneAccesoGuardarCalificacionesModulos != 1)
                                        readOnly: true,
                                    @else
                                        readOnly: false,
                                    @endif
                                    numericFormat: { pattern: '0.00' }, validator: gradeValidator
                                },
                                @endif
                                @if ($row['nota_nombre_15'] != null)
                                {
                                    data: 'nota_15', type: 'numeric',
                                    @if ($currentUserId != $row['docente_calificador_15'] || $tieneAccesoGuardarCalificacionesModulos != 1)
                                        readOnly: true,
                                    @else
                                        readOnly: false,
                                    @endif
                                    numericFormat: { pattern: '0.00' }, validator: gradeValidator
                                },
                                @endif
                                { data: 'nota',               type: 'numeric', readOnly: true, validator: gradeValidator },
                                { data: 'estado_calificacion', type: 'text',    readOnly: true }
                            ],
                            stretchH: 'all',
                            width: '100%',
                            height: 'auto',
                            fixedColumnsLeft: 2,
                            autoWrapRow: true,
                            maxRows: 1000,
                            manualRowResize: true,
                            manualColumnResize: true,
                            rowHeaders: true,
                            colHeaders: [
                                'Código', 'Nombre',
                                @if ($row['nota_nombre_1']  != null) "{{ $row['nota_nombre_1'] }}({{ $row['nota_maxima_1'] }})", @endif
                                @if ($row['nota_nombre_2']  != null) "{{ $row['nota_nombre_2'] }}({{ $row['nota_maxima_2'] }})", @endif
                                @if ($row['nota_nombre_3']  != null) "{{ $row['nota_nombre_3'] }}({{ $row['nota_maxima_3'] }})", @endif
                                @if ($row['nota_nombre_4']  != null) "{{ $row['nota_nombre_4'] }}({{ $row['nota_maxima_4'] }})", @endif
                                @if ($row['nota_nombre_5']  != null) "{{ $row['nota_nombre_5'] }}({{ $row['nota_maxima_5'] }})", @endif
                                @if ($row['nota_nombre_6']  != null) "{{ $row['nota_nombre_6'] }}({{ $row['nota_maxima_6'] }})", @endif
                                @if ($row['nota_nombre_7']  != null) "{{ $row['nota_nombre_7'] }}({{ $row['nota_maxima_7'] }})", @endif
                                @if ($row['nota_nombre_8']  != null) "{{ $row['nota_nombre_8'] }}({{ $row['nota_maxima_8'] }})", @endif
                                @if ($row['nota_nombre_9']  != null) "{{ $row['nota_nombre_9'] }}({{ $row['nota_maxima_9'] }})", @endif
                                @if ($row['nota_nombre_10'] != null) "{{ $row['nota_nombre_10'] }}({{ $row['nota_maxima_10'] }})", @endif
                                @if ($row['nota_nombre_11'] != null) "{{ $row['nota_nombre_11'] }}({{ $row['nota_maxima_11'] }})", @endif
                                @if ($row['nota_nombre_12'] != null) "{{ $row['nota_nombre_12'] }}({{ $row['nota_maxima_12'] }})", @endif
                                @if ($row['nota_nombre_13'] != null) "{{ $row['nota_nombre_13'] }}({{ $row['nota_maxima_13'] }})", @endif
                                @if ($row['nota_nombre_14'] != null) "{{ $row['nota_nombre_14'] }}({{ $row['nota_maxima_14'] }})", @endif
                                @if ($row['nota_nombre_15'] != null) "{{ $row['nota_nombre_15'] }}({{ $row['nota_maxima_15'] }})", @endif
                                'NOTA FINAL', 'ESTADO'
                            ],
                            cells: function (row, col) {
                                var cellProperties = {};
                                cellProperties.renderer = 'defaultRenderer';
                                return cellProperties;
                            },
                            afterChange: function (changes, source) {
                                if (source === 'loadData') return;
                                hayChangios = true;
                                changes.forEach(([row, prop, oldValue, newValue]) => {
                                    if (prop === 'nota' || prop === 'estado_calificacion') return;

                                    var colBase = 2;
                                    @php $colIdx = 0; @endphp
                                    @for ($i = 1; $i <= 15; $i++)
                                        @if ($row['nota_nombre_' . $i] != null)
                                            var eval{{ $i }} = this.getDataAtCell(row, colBase + {{ $colIdx }});
                                            @php $colIdx++; @endphp
                                        @else
                                            var eval{{ $i }} = null;
                                        @endif
                                    @endfor

                                    var totalAcumulativo = [0,0,0,0];
                                    var totalEvaluacion  = [0,0,0,0];
                                    var totalLaboratorio = [0,0,0,0];
                                    var totalParcial     = [0,0,0,0];

                                    @for ($i = 1; $i <= 15; $i++)
                                        @if ($row['nota_nombre_' . $i] != null)
                                        (function(){
                                            var v = eval{{ $i }};
                                            if (v === '' || v === null) v = null;
                                            if (v !== null && v >= 0 && v <= 100) {
                                                var tipo    = {{ $row['nota_tipo_evaluacion_' . $i] ?? 'null' }};
                                                var parcial = {{ $row['nota_parcial_' . $i] ?? 'null' }};
                                                if (tipo === 1)      totalAcumulativo[parcial - 1] += parseFloat(v);
                                                else if (tipo === 2) totalEvaluacion [parcial - 1] += parseFloat(v);
                                                else if (tipo === 3) totalLaboratorio[parcial - 1] += parseFloat(v);
                                                // tipo 4 (reposicion) no suma al total
                                            }
                                        })();
                                        @endif
                                    @endfor

                                    var calificacionFinal = 0;
                                    for (var i = 0; i < 4; i++) {
                                        totalParcial[i] = totalAcumulativo[i] + totalEvaluacion[i] + totalLaboratorio[i];
                                        calificacionFinal += totalParcial[i];
                                    }
                                    calificacionFinal = Math.round(calificacionFinal);

                                    // Highlight de fila: rojo si suma > 100 o si alguna celda individual > 100
                                    var _algunaExcede = [eval1,eval2,eval3,eval4,eval5,eval6,eval7,eval8,
                                        eval9,eval10,eval11,eval12,eval13,eval14,eval15]
                                        .some(function(v) {
                                            return v !== null && v !== '' && !isNaN(parseFloat(v)) && parseFloat(v) > 100;
                                        });
                                    var _sumaExcedida = calificacionFinal > 100 || _algunaExcede;
                                    if (_sumaExcedida) calificacionFinal = null;

                                    var _hot = this, _row = row;
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

                                    // Si todas las notas son null → final null
                                    var todasNull = (
                                        @for ($i = 1; $i <= 15; $i++)
                                            @if ($row['nota_nombre_' . $i] != null)
                                                (eval{{ $i }} === null || eval{{ $i }} === '') &&
                                            @endif
                                        @endfor
                                        true
                                    );
                                    if (calificacionFinal === 0 && todasNull) {
                                        calificacionFinal = null;
                                    }

                                    var estadoCalificacionFinal = null;
                                    if (calificacionFinal === 0) {
                                        estadoCalificacionFinal = 'NSP';
                                    } else if (calificacionFinal > 0 && calificacionFinal < minimo_aprobacion) {
                                        estadoCalificacionFinal = 'REP';
                                    } else if (calificacionFinal >= minimo_aprobacion && calificacionFinal <= 100) {
                                        estadoCalificacionFinal = 'APR';
                                    }

                                    this.setDataAtCell(row, columnaNotaFinal,          calificacionFinal);
                                    this.setDataAtCell(row, columnaEstadoCalificacion,  estadoCalificacionFinal);
                                });
                            },
                            licenseKey: 'b2455-d0184-9cc94-04409-6b848',
                            language: 'es-MX'
                        };

                        hot = new Handsontable(hotElement, hotSettings);
                        Swal.close();
                    },
                    error: function (xhr) { Swal.close(); console.log(xhr.responseText); }
                });

                // ── Botón guardar ──────────────────────────────────────────
                $('#btnGuardarCalificaciones').on('click', function (e) {
                    e.preventDefault();
                    guardarCalificaciones();
                });

                // ── Regresar con confirmación SweetAlert2 ──────────────────
                @if ($tieneAccesoGuardarCalificacionesModulos == 1 && $currentUserId == $docenteId)
                    $('#btnRegresar').on('click', function (e) {
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
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                guardarCalificaciones(function () {
                                    navegandoConPermiso = true;
                                    window.location.href = url;
                                });
                            } else if (result.isDenied) {
                                navegandoConPermiso = true;
                                window.location.href = url;
                            }
                        });
                    });

                    window.addEventListener('beforeunload', function (e) {
                        if (navegandoConPermiso) return;
                        guardarCalificaciones();
                        e.preventDefault();
                        e.returnValue = '¿Estás seguro?';
                        return '¿Seguro que desea dejar este sitio?';
                    });
                @endif

            });

            // ─── Guardar calificaciones ───────────────────────────────────
            function guardarCalificaciones(onSuccessCallback) {
                espera('Guardando calificaciones...');
                $.ajax({
                    url: "{{ url('docentes/guardarCalificacionesModulo') }}",
                    type: 'POST',
                    data: {
                        matriculados:  JSON.stringify(matriculados),
                        idBloqueModulo: {{ $bloqueModuloId }},
                        nota_nombre_1:  '{{ $row['nota_nombre_1'] }}',
                        nota_nombre_2:  '{{ $row['nota_nombre_2'] }}',
                        nota_nombre_3:  '{{ $row['nota_nombre_3'] }}',
                        nota_nombre_4:  '{{ $row['nota_nombre_4'] }}',
                        nota_nombre_5:  '{{ $row['nota_nombre_5'] }}',
                        nota_nombre_6:  '{{ $row['nota_nombre_6'] }}',
                        nota_nombre_7:  '{{ $row['nota_nombre_7'] }}',
                        nota_nombre_8:  '{{ $row['nota_nombre_8'] }}',
                        nota_nombre_9:  '{{ $row['nota_nombre_9'] }}',
                        nota_nombre_10: '{{ $row['nota_nombre_10'] }}',
                        nota_nombre_11: '{{ $row['nota_nombre_11'] }}',
                        nota_nombre_12: '{{ $row['nota_nombre_12'] }}',
                        nota_nombre_13: '{{ $row['nota_nombre_13'] }}',
                        nota_nombre_14: '{{ $row['nota_nombre_14'] }}',
                        nota_nombre_15: '{{ $row['nota_nombre_15'] }}',
                        nota_maxima_1:  {{ $row['nota_maxima_1'] ?? 0 }},
                        nota_maxima_2:  {{ $row['nota_maxima_2'] ?? 0 }},
                        nota_maxima_3:  {{ $row['nota_maxima_3'] ?? 0 }},
                        nota_maxima_4:  {{ $row['nota_maxima_4'] ?? 0 }},
                        nota_maxima_5:  {{ $row['nota_maxima_5'] ?? 0 }},
                        nota_maxima_6:  {{ $row['nota_maxima_6'] ?? 0 }},
                        nota_maxima_7:  {{ $row['nota_maxima_7'] ?? 0 }},
                        nota_maxima_8:  {{ $row['nota_maxima_8'] ?? 0 }},
                        nota_maxima_9:  {{ $row['nota_maxima_9'] ?? 0 }},
                        nota_maxima_10: {{ $row['nota_maxima_10'] ?? 0 }},
                        nota_maxima_11: {{ $row['nota_maxima_11'] ?? 0 }},
                        nota_maxima_12: {{ $row['nota_maxima_12'] ?? 0 }},
                        nota_maxima_13: {{ $row['nota_maxima_13'] ?? 0 }},
                        nota_maxima_14: {{ $row['nota_maxima_14'] ?? 0 }},
                        nota_maxima_15: {{ $row['nota_maxima_15'] ?? 0 }},
                        nota_parcial_1:  {{ $row['nota_parcial_1']  ?? 'null' }},
                        nota_parcial_2:  {{ $row['nota_parcial_2']  ?? 'null' }},
                        nota_parcial_3:  {{ $row['nota_parcial_3']  ?? 'null' }},
                        nota_parcial_4:  {{ $row['nota_parcial_4']  ?? 'null' }},
                        nota_parcial_5:  {{ $row['nota_parcial_5']  ?? 'null' }},
                        nota_parcial_6:  {{ $row['nota_parcial_6']  ?? 'null' }},
                        nota_parcial_7:  {{ $row['nota_parcial_7']  ?? 'null' }},
                        nota_parcial_8:  {{ $row['nota_parcial_8']  ?? 'null' }},
                        nota_parcial_9:  {{ $row['nota_parcial_9']  ?? 'null' }},
                        nota_parcial_10: {{ $row['nota_parcial_10'] ?? 'null' }},
                        nota_parcial_11: {{ $row['nota_parcial_11'] ?? 'null' }},
                        nota_parcial_12: {{ $row['nota_parcial_12'] ?? 'null' }},
                        nota_parcial_13: {{ $row['nota_parcial_13'] ?? 'null' }},
                        nota_parcial_14: {{ $row['nota_parcial_14'] ?? 'null' }},
                        nota_parcial_15: {{ $row['nota_parcial_15'] ?? 'null' }},
                        nota_tipo_evaluacion_1:  {{ $row['nota_tipo_evaluacion_1']  ?? 'null' }},
                        nota_tipo_evaluacion_2:  {{ $row['nota_tipo_evaluacion_2']  ?? 'null' }},
                        nota_tipo_evaluacion_3:  {{ $row['nota_tipo_evaluacion_3']  ?? 'null' }},
                        nota_tipo_evaluacion_4:  {{ $row['nota_tipo_evaluacion_4']  ?? 'null' }},
                        nota_tipo_evaluacion_5:  {{ $row['nota_tipo_evaluacion_5']  ?? 'null' }},
                        nota_tipo_evaluacion_6:  {{ $row['nota_tipo_evaluacion_6']  ?? 'null' }},
                        nota_tipo_evaluacion_7:  {{ $row['nota_tipo_evaluacion_7']  ?? 'null' }},
                        nota_tipo_evaluacion_8:  {{ $row['nota_tipo_evaluacion_8']  ?? 'null' }},
                        nota_tipo_evaluacion_9:  {{ $row['nota_tipo_evaluacion_9']  ?? 'null' }},
                        nota_tipo_evaluacion_10: {{ $row['nota_tipo_evaluacion_10'] ?? 'null' }},
                        nota_tipo_evaluacion_11: {{ $row['nota_tipo_evaluacion_11'] ?? 'null' }},
                        nota_tipo_evaluacion_12: {{ $row['nota_tipo_evaluacion_12'] ?? 'null' }},
                        nota_tipo_evaluacion_13: {{ $row['nota_tipo_evaluacion_13'] ?? 'null' }},
                        nota_tipo_evaluacion_14: {{ $row['nota_tipo_evaluacion_14'] ?? 'null' }},
                        nota_tipo_evaluacion_15: {{ $row['nota_tipo_evaluacion_15'] ?? 'null' }}
                    },
                    success: function (data) {
                        Swal.close();
                        dataOutput = data;
                        hayChangios = false;
                        if (dataOutput.msgError != null) {
                            Swal.fire('Error', dataOutput.msgError, 'error');
                        } else {
                            if (dataOutput.calificacionesFinales) {
                                dataOutput.calificacionesFinales.forEach(function (obj) {
                                    $(hot.getData()).each(function (i, n) {
                                        if (n.id_reg_matricula_modulo === obj.fila.id_reg_matricula_modulo) {
                                            hot.setDataAtCell(i, columnaEstadoCalificacion, obj.estado_calificacion);
                                            return false;
                                        }
                                    });
                                });
                            }
                            var tieneAcceso = dataOutput.tieneAccesoGuardarCalificacionesModulos;
                            if (tieneAcceso != 1) {
                                $('#divInfoCerrado').removeClass('d-none');
                                $('#divInfoAperturado').addClass('d-none');
                            } else {
                                $('#divInfoCerrado').addClass('d-none');
                                $('#divInfoAperturado').removeClass('d-none');
                            }
                            if (typeof onSuccessCallback === 'function') {
                                onSuccessCallback();
                            } else {
                                Swal.fire({ icon: 'success', title: 'Guardado', text: dataOutput.msgSuccess, timer: 2000, showConfirmButton: false });
                            }
                        }
                    },
                    error: function (xhr) { Swal.close(); console.log(xhr.responseText); }
                });
            }

            // ─── Renderer readOnly ────────────────────────────────────────
            function defaultRenderer(instance, td, row, col, prop, value, cellProperties) {
                Handsontable.renderers.TextRenderer.apply(this, arguments);
                if (cellProperties.readOnly) {
                    setTimeout(function () {
                        td.style.setProperty('background', '#e8f0e9', 'important');
                        td.style.setProperty('color',      '#7a8f7b', 'important');
                        td.style.setProperty('cursor',     'not-allowed', 'important');
                    }, 0);
                } else {
                    setTimeout(function () {
                        td.style.setProperty('background', '', 'important');
                        td.style.setProperty('color',      '', 'important');
                    }, 0);
                }
            }
            Handsontable.renderers.registerRenderer('defaultRenderer', defaultRenderer);

        </script>
    @endforeach
@endpush
