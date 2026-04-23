@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('css/handsontable.full.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <style>
        #hot { width: 100%; }

        .stat-card {
            border-left: 4px solid var(--azul);
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-card.verde { border-left-color: var(--verde); }

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
        .stat-sub { font-size: 12px; color: #888; }

        .estado-banner {
            border-radius: 8px;
            padding: 10px 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .estado-aprobado { background: #d3eed7; color: var(--verdeOscuro); }
        .estado-cerrado  { background: #fde8e8; color: #c0392b; }

        /* ── ACCIONES ── */
        .acciones-toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: flex-end;
            margin-bottom: 16px;
        }

        @media (max-width: 768px) {
            #hot { border-radius: 4px !important; }
            .acciones-toolbar { justify-content: flex-start; }
            .stat-value { font-size: 20px; }
        }

        /* ════════════════════════════════════════
           HANDSONTABLE — mismo estilo calificaciones
           ════════════════════════════════════════ */
        #hot {
            width: 100%;
            border-radius: 10px;
            overflow: auto;
            box-shadow: 0 4px 24px rgba(19,84,35,.12);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            animation: hotFadeIn 0.4s ease forwards;
        }

        /* Scrollbar visible con colores institucionales */
        #hot ::-webkit-scrollbar        { width: 8px; height: 8px; }
        #hot ::-webkit-scrollbar-track  { background: #e8f5e9; border-radius: 4px; }
        #hot ::-webkit-scrollbar-thumb  { background: #1ba333; border-radius: 4px; }
        #hot ::-webkit-scrollbar-thumb:hover { background: #135423; }

        .handsontable table.htCore { border-collapse: separate; border-spacing: 0; }

        /* Headers columna */
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
            border-right: 1px solid rgba(255,255,255,.12) !important;
            border-bottom: 2px solid #1ba333 !important;
            white-space: nowrap !important;
            text-shadow: 0 1px 2px rgba(0,0,0,.2);
        }
        .handsontable thead th .colHeader,
        .handsontable thead th span,
        .handsontable .ht_clone_top thead th .colHeader { color: #ffffff !important; }

        .handsontable thead th .changeType,
        .handsontable thead th button.changeType,
        .handsontable .htDropdownMenu { display: none !important; }

        .handsontable thead th:hover { background: #1ba333 !important; cursor: pointer; }

        /* Header fila (números) */
        .handsontable .rowHeader,
        .handsontable .ht_clone_left tbody th {
            background: #f0fff4 !important;
            color: #135423 !important;
            font-weight: 700 !important;
            font-size: 11px !important;
            border-right: 2px solid #b2dfb8 !important;
            text-align: center !important;
        }

        /* Celdas */
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

        .handsontable tr:nth-child(even) td { background-color: #f5fbf5 !important; }
        .handsontable tr:nth-child(odd)  td { background-color: #ffffff   !important; }
        .handsontable tr:hover td           { background-color: #e8f5e9   !important; }

        .handsontable td.area,
        .handsontable td.current {
            background-color: #c8e6c9 !important;
            border: 1px solid #135423 !important;
            outline: none !important;
        }
        .handsontable td.current.highlight { background-color: #b2dfb8 !important; }

        /* Inválida */
        .handsontable td.htInvalid {
            background-color: #fff0f0 !important;
            border: 1px solid #ff4d4d !important;
        }

        /* Input en celda */
        .handsontable .handsontableInput {
            font-size: 13px !important;
            font-family: 'Segoe UI', system-ui, sans-serif !important;
            color: #0f4019 !important;
            background: #f0fff4 !important;
            border: 2px solid #135423 !important;
            border-radius: 4px !important;
            padding: 4px 8px !important;
            box-shadow: 0 0 0 3px rgba(19,84,35,.12) !important;
            outline: none !important;
        }

        /* Context menu */
        .handsontable .htContextMenu {
            border-radius: 8px !important;
            box-shadow: 0 8px 24px rgba(19,84,35,.18) !important;
            border: 1px solid #b2dfb8 !important;
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

        /* Bordes selección */
        .handsontable .wtBorder.current { background-color: #135423 !important; }
        .handsontable .wtBorder.area    { background-color: #1ba333 !important; }

        /* Corner */
        .handsontable .ht_clone_top_left_corner thead th { background: #0f4019 !important; }

        @keyframes hotFadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0);   }
        }
    </style>
@endpush

@section('content')

    {{-- ══════════════════════════════════════════
         ENCABEZADO — logo UNAG (mismo que calificaciones)
         ══════════════════════════════════════════ --}}
    <div class="row">
        <div class="col-12">
            <div class="card bg-primary" style="position:relative;overflow:hidden;">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center gap-3">
                        <i data-feather="clock" style="width:48px;height:48px;color:#fff;stroke:#fff;"></i>
                        <div>
                            <h2 class="mb-0 fw-bold text-white" style="font-size:26px;letter-spacing:1px;">
                                DETALLE DE HORAS — SSC
                            </h2>
                            <div class="mt-1 text-white" style="font-size:13px;font-weight:600;letter-spacing:0.5px;">
                                <i data-feather="briefcase" style="width:13px;height:13px;stroke:#ffffff;"></i>
                                {{ strtoupper($nombre ?? 'PROYECTO #' . $id_solicitud) }}
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

    {{-- ══════════════════════════════════════════
         TARJETAS DE INFORMACIÓN
         ══════════════════════════════════════════ --}}
    <div class="row g-3 mb-3 mt-1">

        {{-- Proyecto --}}
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <div class="stat-label mb-1">
                        <i data-feather="briefcase" style="width:14px;height:14px;"></i> Proyecto SSC
                    </div>
                    <div class="stat-value" style="font-size:20px;line-height:1.2;">
                        {{ $nombre ?? 'Sin nombre' }}
                    </div>
                    <div class="stat-sub mt-1">
                        <span class="badge bg-secondary" style="color:#fff!important;">ID #{{ $id_solicitud }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Horas máximas --}}
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card verde h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <div class="stat-label mb-1">
                        <i data-feather="clock" style="width:14px;height:14px;"></i> Horas Máximas
                    </div>
                    <div class="stat-value" style="color:var(--verdeOscuro);">{{ $horas_max ?? 0 }}</div>
                    <div class="stat-sub mt-1">Valor máximo permitido por estudiante</div>
                </div>
            </div>
        </div>

        {{-- Estado --}}
        <div class="col-md-4 col-sm-12">
            <div class="card stat-card h-100">
                <div class="card-body d-flex flex-column justify-content-center gap-2">
                    <div class="stat-label mb-1">
                        <i data-feather="activity" style="width:14px;height:14px;"></i> Estado del Proyecto
                    </div>
                    @if($estado == 'aprobado')
                        <div class="estado-banner estado-aprobado">
                            <i data-feather="unlock" style="width:20px;height:20px;"></i>
                            <div>
                                <div>APROBADO</div>
                                <small style="font-weight:400;">Puedes editar las horas</small>
                            </div>
                        </div>
                    @elseif($estado == 'cerrado')
                        <div class="estado-banner estado-cerrado">
                            <i data-feather="lock" style="width:20px;height:20px;"></i>
                            <div>
                                <div>CERRADO</div>
                                <small style="font-weight:400;">Solo lectura</small>
                            </div>
                        </div>
                    @else
                        <div class="estado-banner" style="background:#fff3cd;color:#856404;">
                            <i data-feather="alert-circle" style="width:20px;height:20px;"></i>
                            <div>{{ ucfirst($estado ?? 'Sin estado') }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════
         TOOLBAR DE ACCIONES
         ══════════════════════════════════════════ --}}
    <div class="acciones-toolbar">
        @if($estado == 'aprobado')
            <button id="btn_guardar_horas"
                    class="btn btn-success d-flex align-items-center gap-2 fw-bold">
                <i data-feather="save" style="width:16px;height:16px;"></i> Guardar Horas
            </button>
        @endif
        <a href="{{ url('docentes/cargaAcademica') }}"
           class="btn btn-secondary d-flex align-items-center gap-2">
            <i data-feather="arrow-left" style="width:16px;height:16px;"></i> Regresar
        </a>
    </div>

    {{-- ══════════════════════════════════════════
         SPINNER / HANDSONTABLE
         ══════════════════════════════════════════ --}}
    <div id="loading_horas" class="text-center py-5">
        <div class="spinner-border" style="width:2.5rem;height:2.5rem;color:var(--verde);"></div>
        <p class="mt-3 text-muted fw-600">Cargando estudiantes...</p>
    </div>

    <div id="hot" style="display:none;"></div>

@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/handsontable.full.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    var ID_SOLICITUD = {{ $id_solicitud }};
    var HORAS_MAX    = {{ $horas_max ?? 0 }};
    var ESTADO       = '{{ $estado }}';

    var URL_DATA    = '{{ url("ssc/proyectos/detalleHoras/" . $id_solicitud . "/data") }}';
    var URL_GUARDAR = '{{ url("ssc/proyectos/detalleHoras/" . $id_solicitud . "/guardar") }}';

    var hot         = null;
    var estudiantes = [];

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    // ── Renderer readonly (gris, igual que calificaciones) ──
    function rendererReadonly(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);
        td.style.background   = '#e0e8e1';
        td.style.color        = '#7a8f7b';
        td.style.cursor       = 'not-allowed';
        td.style.fontWeight   = '500';
    }

    // ── Renderer editable (verde claro) ──
    function rendererEditable(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.NumericRenderer.apply(this, arguments);
        if (cellProperties.valid === false) {
            td.style.background = '#fff0f0';
            td.style.border     = '1px solid #ff4d4d';
        } else {
            td.style.background = '#f0fff4';
            td.style.color      = '#0f4019';
            td.style.fontWeight = '700';
        }
    }

    Handsontable.renderers.registerRenderer('rendererReadonly', rendererReadonly);
    Handsontable.renderers.registerRenderer('rendererEditable', rendererEditable);

    // ── Validador horas ──
    function validarHoras(value, callback) {
        if (value === null || value === '' || value === undefined) {
            callback(true);
            return;
        }
        callback(Number(value) >= 0 && Number(value) <= HORAS_MAX);
    }

    $(document).ready(function () {

        $.ajax({
            url: URL_DATA,
            type: 'POST',
            success: function (data) {
                if (data.msgError) {
                    $('#loading_horas').hide();
                    Swal.fire({ icon: 'error', title: 'Error', text: data.msgError, confirmButtonColor: '#203b76' });
                    return;
                }

                estudiantes = data.estudiantes || [];
                var soloLectura = (ESTADO !== 'aprobado');

                // Mostrar ANTES de inicializar para que Handsontable calcule anchos correctamente
                $('#loading_horas').hide();
                $('#hot').show();

                var settings = {
                    data: estudiantes,
                    columns: [
                        {
                            data: 'numero_registro_asignado',
                            type: 'text',
                            readOnly: true,
                            renderer: 'rendererReadonly',
                        },
                        {
                            data: 'nombre',
                            type: 'text',
                            readOnly: true,
                            renderer: 'rendererReadonly',
                        },
                        {
                            data: 'horas_totales',
                            type: 'numeric',
                            readOnly: soloLectura,
                            renderer: soloLectura ? 'rendererReadonly' : 'rendererEditable',
                            validator: validarHoras,
                            allowInvalid: true,
                        },
                    ],
                    colHeaders: ['Código', 'Nombre Estudiante', 'Horas Completadas'],
                    rowHeaders: true,
                    stretchH: 'all',
                    autoWrapRow: true,
                    manualRowResize: true,
                    manualColumnResize: true,
                    filters: true,
                    dropdownMenu: false,
                    licenseKey: 'non-commercial-and-evaluation',
                    height: 'auto',
                    minSpareRows: 0,
                    afterChange: function (changes) {
                        if (!changes) return;
                        // re-renderizar para aplicar color correcto
                        this.render();
                    },
                };

                hot = new Handsontable(document.querySelector('#hot'), settings);
                feather.replace();
            },
            error: function () {
                $('#loading_horas').hide();
                Swal.fire({ icon: 'error', title: 'Error de conexion', text: 'No se pudo cargar los estudiantes.', confirmButtonColor: '#203b76' });
            }
        });

        // ── Guardar ──
        $('#btn_guardar_horas').on('click', function () {
            if (!hot) return;
            hot.validateCells(function (valid) {
                if (!valid) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Horas invalidas',
                        html: 'Hay celdas marcadas en <span style="color:#ff4d4d;font-weight:700;">rojo</span>.<br>El valor debe estar entre <strong>0</strong> y <strong>' + HORAS_MAX + '</strong>.',
                        confirmButtonColor: '#203b76'
                    });
                    return;
                }
                guardarHoras();
            });
        });
    });

    function guardarHoras() {
        var btn = $('#btn_guardar_horas');
        btn.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm me-1"></span> Guardando...'
        );

        $.ajax({
            url: URL_GUARDAR,
            type: 'POST',
            data: { estudiantes: JSON.stringify(estudiantes) },
            success: function (data) {
                btn.prop('disabled', false).html(
                    '<i data-feather="save" style="width:16px;height:16px;"></i> Guardar Horas'
                );
                setTimeout(feather.replace, 0);

                if (data.msgError) {
                    Swal.fire({ icon: 'error', title: 'Error', text: data.msgError, confirmButtonColor: '#203b76' });
                } else {
                    Swal.fire({ icon: 'success', title: '¡Guardado!', text: data.msgSuccess, timer: 2000, showConfirmButton: false });
                }
            },
            error: function () {
                btn.prop('disabled', false).html(
                    '<i data-feather="save" style="width:16px;height:16px;"></i> Guardar Horas'
                );
                Swal.fire({ icon: 'error', title: 'Error de conexion', text: 'No se pudo guardar las horas.', confirmButtonColor: '#203b76' });
            }
        });
    }
</script>
@endpush
