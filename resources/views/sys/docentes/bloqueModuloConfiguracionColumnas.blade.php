@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('css/handsontable.full.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <style>
        .stat-card {
            border-left: 4px solid var(--azul);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
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

        /* Toolbar de acciones */
        .acciones-toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: flex-end;
            margin-bottom: 16px;
        }

        /* Instrucciones */
        .instruccion-card {
            border-left: 4px solid var(--amarillo);
            background: #fffdf0;
            border-radius: 6px;
            padding: 14px 18px;
        }

        .instruccion-card .instruccion-titulo {
            font-weight: 700;
            font-size: 13px;
            color: var(--cafe);
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 6px;
        }

        .instruccion-card ul {
            margin: 0;
            padding-left: 18px;
        }

        .instruccion-card ul li {
            font-size: 13px;
            color: #555 !important;
            margin-bottom: 2px;
        }

        /* Indicador suma total */
        #indicadorSuma {
            font-size: 15px;
            font-weight: 700;
            transition: color 0.3s;
        }

        #indicadorSuma.valido {
            color: var(--verdeOscuro);
        }

        #indicadorSuma.invalido {
            color: var(--rojo);
        }

        /* ============================================================
           HANDSONTABLE
        ============================================================ */
        #hot {
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(19, 84, 35, 0.12);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            animation: hotFadeIn 0.4s ease forwards;
        }

        .wtHolder {
            overflow-x: auto !important;
            overflow-y: auto !important;
        }

        .ht_clone_top .wtHolder {
            overflow-x: hidden !important;
        }

        .handsontable table.htCore {
            border-collapse: separate;
            border-spacing: 0;
        }

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
            border-right: 1px solid rgba(255,255,255,0.12) !important;
            border-bottom: 2px solid #1ba333 !important;
            white-space: nowrap !important;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }

        .handsontable thead th .colHeader,
        .handsontable thead th span,
        .handsontable .ht_clone_top thead th .colHeader,
        .handsontable .ht_clone_top thead th span {
            color: #ffffff !important;
        }

        .handsontable thead th .changeType,
        .handsontable thead th button.changeType,
        .handsontable .htDropdownMenu {
            display: none !important;
        }

        .handsontable thead th:hover {
            background: #1ba333 !important;
        }

        .handsontable .rowHeader,
        .handsontable .ht_clone_left tbody th {
            background: #f0fff4 !important;
            color: #135423 !important;
            font-weight: 700 !important;
            font-size: 11px !important;
            border-right: 2px solid #b2dfb8 !important;
            text-align: center !important;
        }

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
        .handsontable tr:nth-child(odd) td  { background-color: #ffffff !important; }
        .handsontable tr:hover td           { background-color: #e8f5e9 !important; }

        .handsontable td.area,
        .handsontable td.current {
            background-color: #c8e6c9 !important;
            border: 1px solid #135423 !important;
            outline: none !important;
        }

        .handsontable .ht_clone_left td {
            background: #f0fff4 !important;
            border-right: 2px solid #b2dfb8 !important;
            font-weight: 600 !important;
            color: #0f4019 !important;
        }

        .handsontable td.htInvalid {
            background-color: #fff0f0 !important;
            border: 1px solid #ff4d4d !important;
        }

        .handsontable .handsontableInput {
            font-size: 13px !important;
            color: #0f4019 !important;
            background: #f0fff4 !important;
            border: 2px solid #135423 !important;
            border-radius: 4px !important;
            padding: 4px 8px !important;
            box-shadow: 0 0 0 3px rgba(19,84,35,0.12) !important;
            outline: none !important;
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
        <div class="row mb-3">
            <div class="col-12">
                <div class="card bg-primary" style="border:none;">
                    <div class="card-body py-3" style="position:relative;">
                        <div class="d-flex align-items-center gap-3">
                            <i data-feather="settings" style="width:48px;height:48px;color:#fff;stroke:#fff;flex-shrink:0;"></i>
                            <div>
                                <h2 class="mb-0 fw-bold text-white" style="font-size:24px;letter-spacing:1px;">
                                    CONFIGURACIÓN DE CUADRO DE EVALUACIONES — MÓDULOS
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
        <div class="row g-3 mb-3">

            {{-- Módulo --}}
            <div class="col-md-4 col-sm-6">
                <div class="card stat-card h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="stat-label mb-1">
                            <i data-feather="layers" style="width:14px;height:14px;"></i> Módulo
                        </div>
                        <div class="stat-value" style="font-size:20px;">{{ $row['modulo'] }}</div>
                        <div class="stat-sub mt-1">
                            <span class="badge bg-secondary" style="color:#fff !important;">{{ $row['id_modulo'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Docente --}}
            <div class="col-md-4 col-sm-6">
                <div class="card stat-card h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="stat-label mb-1">
                            <i data-feather="user" style="width:14px;height:14px;"></i> Docente
                        </div>
                        <div class="stat-value" style="font-size:18px;">{{ $row['docente'] }}</div>
                    </div>
                </div>
            </div>

            {{-- Total Matriculados --}}
            <div class="col-md-4 col-sm-6">
                <div class="card stat-card h-100">
                    <div class="card-body d-flex flex-column justify-content-center gap-2">
                        <div>
                            <div class="stat-label mb-1">
                                <i data-feather="users" style="width:14px;height:14px;"></i> Total Matriculados
                            </div>
                            <div class="stat-value">{{ $row['total_matriculados'] }}</div>
                        </div>
                        <div class="border-top pt-2 d-flex gap-3">
                            <div class="text-center">
                                <div class="stat-label" style="color:#1ba333;">APR</div>
                                <span class="fw-bold" style="color:#1ba333;font-size:18px;">{{ $row['aprobados'] }}</span>
                            </div>
                            <div class="text-center">
                                <div class="stat-label" style="color:#dc3545;">REP</div>
                                <span class="fw-bold" style="color:#dc3545;font-size:18px;">{{ $row['reprobados'] }}</span>
                            </div>
                            <div class="text-center">
                                <div class="stat-label" style="color:#6c757d;">NSP</div>
                                <span class="fw-bold" style="color:#6c757d;font-size:18px;">{{ $row['nsp'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ============================================================ --}}
        {{-- INSTRUCCIONES                                                 --}}
        {{-- ============================================================ --}}
        <div class="row mb-3">
            <div class="col-12">
                <div class="instruccion-card">
                    <div class="instruccion-titulo">
                        <i data-feather="info" style="width:14px;height:14px;"></i> Instrucciones
                    </div>
                    <ul>
                        <li>Cada evaluación puede tener una <b>Descripción</b> opcional.</li>
                        <li>Cada evaluación debe tener una <b>Nota Máxima</b> entre <b>0</b> y <b>100</b>.</li>
                        <li>La suma de todas las notas máximas debe ser exactamente igual a <b>100</b>.</li>
                        <li>El nombre de la evaluación no es editable, solo la descripción y la nota máxima.</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- TABLA DE CONFIGURACIÓN                                        --}}
        {{-- ============================================================ --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-verdeClaro d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i data-feather="sliders" class="icon-lg pb-3px"></i> Evaluaciones del Módulo
                        </h5>
                        {{-- Indicador suma en tiempo real --}}
                        <div class="d-flex align-items-center gap-2">
                            <span class="stat-label mb-0">Total acumulado:</span>
                            <span id="indicadorSuma" class="invalido">0 / 100</span>
                        </div>
                    </div>
                    <div class="card-body">

                        {{-- Toolbar --}}
                        <div class="acciones-toolbar">
                            <a class="btn bg-azul btn-sm"
                                href="{{ url('/') }}/docentes/cargaAcademica">
                                <i data-feather="arrow-left" style="width:15px;height:15px;"></i> Regresar
                            </a>
                            <a class="btn btn-primary btn-sm" id="btnGuardarConfiguraciones">
                                <i data-feather="save" style="width:15px;height:15px;"></i> Guardar
                            </a>
                        </div>

                        {{-- Handsontable --}}
                        <div id="hot"></div>

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

            var hot              = null;
            var dataOutput       = null;
            var columnasEvaluacion = null;
            var gradeValidator   = null;

            var urlColumnas  = "{{ url('docentes/bloques-modulo/configuracion/columnas') }}";
            var urlGuardar   = "{{ url('docentes/bloques-modulo/configuracion/columnas/guardar') }}";

            // ─── Indicador suma (excluye columnas de reposición: ids 4 y 8) ──
            var COLUMNAS_REPOSICION = [4, 8];
            function actualizarIndicadorSuma() {
                if (!columnasEvaluacion) return;
                var total = 0;
                columnasEvaluacion.forEach(function(col) {
                    if (COLUMNAS_REPOSICION.indexOf(col.id_columna_evaluacion) !== -1) return;
                    var val = parseFloat(col.nota_maxima);
                    if (!isNaN(val)) total += val;
                });
                total = Math.round(total * 100) / 100;
                var el = document.getElementById('indicadorSuma');
                el.textContent = total + ' / 100';
                el.className = (total === 100) ? 'valido' : 'invalido';
            }

            // ─── SweetAlert espera ────────────────────────────────────────
            function espera(html) {
                Swal.fire({
                    imageUrl: "{{ url(asset('/assets/images/unag_loading.gif')) }}",
                    title: '¡Espera!',
                    html: html,
                    timer: null,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    didOpen: () => { Swal.showLoading(); }
                });
            }

            // ─── Guardar configuración ────────────────────────────────────
            function guardarConfiguracionEvaluaciones() {
                espera('Guardando configuración...');
                $.ajax({
                    url: urlGuardar,
                    type: 'POST',
                    data: {
                        columnasEvaluacion: JSON.stringify(columnasEvaluacion),
                        bloqueModuloId: {{ $bloqueModuloId }}
                    },
                    success: function(data) {
                        Swal.close();
                        dataOutput = data;
                        if (dataOutput.msgError != null) {
                            Swal.fire('Error', dataOutput.msgError, 'error');
                        } else {
                            // Actualizar ids retornados por el servidor
                            if (dataOutput.calificacionesFinales) {
                                dataOutput.calificacionesFinales.forEach(function(obj) {
                                    columnasEvaluacion[obj.fila - 1]['id_bloque_modulo_columna_eval'] = obj.id_bloque_modulo_columna_eval;
                                });
                            }
                            Swal.fire({
                                icon: 'success',
                                title: 'Guardado',
                                text: dataOutput.msgSuccess,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.close();
                        console.log(xhr.responseText);
                    }
                });
            }

            // ─── Document ready ───────────────────────────────────────────
            $(document).ready(function() {

                espera('Cargando evaluaciones...');

                $.ajaxSetup({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
                });

                gradeValidator = function(value, callback) {
                    callback(value >= 0 && value <= 100);
                };

                // Cargar columnas de evaluación
                $.ajax({
                    url: urlColumnas,
                    type: 'post',
                    data: { bloqueModuloId: {{ $bloqueModuloId }} },
                    success: function(data) {
                        columnasEvaluacion = data;
                        actualizarIndicadorSuma();

                        var hotElement  = document.querySelector('#hot');
                        var hotSettings = {
                            data: columnasEvaluacion,
                            columns: [
                                {
                                    data: 'nota_nombre',
                                    type: 'text',
                                    readOnly: true
                                },
                                {
                                    data: 'descripcion',
                                    type: 'text',
                                    readOnly: false
                                },
                                {
                                    data: 'nota_maxima',
                                    type: 'numeric',
                                    readOnly: false,
                                    numericFormat: { pattern: '0.00' },
                                    validator: gradeValidator
                                }
                            ],
                            stretchH: 'all',
                            width: '100%',
                            height: 'auto',
                            autoWrapRow: true,
                            maxRows: 1000,
                            manualRowResize: true,
                            manualColumnResize: true,
                            manualRowMove: true,
                            rowHeaders: true,
                            colHeaders: ['Evaluación', 'Descripción', 'Nota Máxima'],
                            filters: true,
                            cells: function(row, col) {
                                var cellProperties = {};
                                cellProperties.renderer = 'defaultRenderer';
                                return cellProperties;
                            },
                            afterChange: function(changes, source) {
                                if (source === 'loadData') return;
                                actualizarIndicadorSuma();
                            },
                            licenseKey: 'b2455-d0184-9cc94-04409-6b848',
                            language: 'es-MX'
                        };

                        var isMobile = window.innerWidth <= 768;
                        if (isMobile) {
                            hotSettings.stretchH  = 'none';
                            hotSettings.rowHeaders = false;
                            hotSettings.width     = window.innerWidth - 32;
                            hotSettings.colWidths = 120;
                        }

                        hot = new Handsontable(hotElement, hotSettings);
                        Swal.close();
                    },
                    error: function(xhr) {
                        Swal.close();
                        console.log(xhr.responseText);
                    }
                });

                // Botón guardar
                $('#btnGuardarConfiguraciones').on('click', function(e) {
                    e.preventDefault();
                    guardarConfiguracionEvaluaciones();
                });
            });

            // ─── Renderer: readOnly gris institucional ────────────────────
            function defaultRenderer(instance, td, row, col, prop, value, cellProperties) {
                Handsontable.renderers.TextRenderer.apply(this, arguments);
                if (cellProperties.readOnly) {
                    setTimeout(function() {
                        td.style.setProperty('background', '#e8f0e9', 'important');
                        td.style.setProperty('color',      '#7a8f7b', 'important');
                        td.style.setProperty('cursor',     'not-allowed', 'important');
                    }, 0);
                } else {
                    setTimeout(function() {
                        td.style.setProperty('background', '', 'important');
                        td.style.setProperty('color',      '', 'important');
                    }, 0);
                }
            }
            Handsontable.renderers.registerRenderer('defaultRenderer', defaultRenderer);

        </script>
    @endforeach
@endpush
