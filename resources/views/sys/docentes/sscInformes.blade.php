@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <style>
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
            font-size: 22px;
            font-weight: 700;
            color: var(--azul);
            line-height: 1.2;
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

        .acciones-toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: flex-end;
            margin-bottom: 16px;
        }
        @media (max-width: 768px) {
            .acciones-toolbar { justify-content: flex-start; }
            .stat-value { font-size: 16px; }
        }
    </style>
@endpush

@section('content')

    {{-- ══════════════════════════════════════════
         ENCABEZADO — logo UNAG
         ══════════════════════════════════════════ --}}
    <div class="row">
        <div class="col-12">
            <div class="card bg-primary" style="position:relative;overflow:hidden;">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center gap-3">
                        <i data-feather="file-text" style="width:48px;height:48px;color:#fff;stroke:#fff;"></i>
                        <div>
                            <h2 class="mb-0 fw-bold text-white" style="font-size:26px;letter-spacing:1px;">
                                INFORMES — SSC
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
                    <div class="stat-value">{{ $nombre ?? 'Sin nombre' }}</div>
                    <div class="stat-sub mt-1">
                        <span class="badge bg-secondary" style="color:#fff!important;">ID #{{ $id_solicitud }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total informes --}}
        <div class="col-md-4 col-sm-6">
            <div class="card stat-card verde h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <div class="stat-label mb-1">
                        <i data-feather="file-text" style="width:14px;height:14px;"></i> Total Informes
                    </div>
                    <div class="stat-value" style="font-size:40px;color:var(--verdeOscuro);">
                        {{ count($ssc_informes_list) }}
                    </div>
                    <div class="stat-sub mt-1">Informes registrados</div>
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
                                <small style="font-weight:400;">Puedes agregar y editar informes</small>
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

    {{-- TOOLBAR --}}
    <div class="acciones-toolbar">
        <a href="{{ url('docentes/cargaAcademica') }}"
           class="btn btn-secondary d-flex align-items-center gap-2">
            <i data-feather="arrow-left" style="width:16px;height:16px;"></i> Regresar
        </a>
    </div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                {{-- CARD TABLA --}}
                <div class="card border-secondary">
                    <div class="card-header bg-azul text-white d-flex justify-content-between align-items-center">
                        <h5 class="text-white mb-0 d-flex align-items-center gap-2">
                            <i data-feather="list" style="width:18px;height:18px;"></i> Lista de Informes
                        </h5>
                        @if($estado == 'aprobado' && $todos == 'no')
                            <button type="button" class="btn btn-sm d-flex align-items-center gap-1"
                                style="background:var(--amarillo);color:var(--azul);font-weight:600;"
                                id="btn_agregar_informe">
                                <i data-feather="plus" style="width:15px;height:15px;"></i> Agregar Informe
                            </button>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="jambo_table table table-hover" id="tbl_informes" border="1">
                                <thead class="bg-primary">
                                    <tr class="headings">
                                        <th class="text-white">Id</th>
                                        <th class="text-white">Descripcion</th>
                                        <th class="text-white">Estudiantes</th>
                                        <th class="text-white">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ssc_informes_list as $row)
                                    <tr style="font-size:small;">
                                        <td>{{ $row['id'] }}</td>
                                        <td>{{ $row['nombre'] }}</td>
                                        <td>{{ $row['estudiante'] }}</td>
                                        <td class="d-flex gap-1 flex-wrap">
                                            @if($estado == 'aprobado')
                                                <button type="button" class="btn btn-primary btn-xs d-inline-flex align-items-center gap-1 btn-editar-informe"
                                                    data-id="{{ $row['id'] }}"
                                                    data-nombre="{{ $row['nombre'] }}"
                                                    data-estudiante="{{ $row['estudiante'] }}"
                                                    data-informe="{{ $row['informe'] }}">
                                                    <i data-feather="edit-2" style="width:13px;height:13px;"></i> Editar
                                                </button>
                                                <button type="button" class="btn btn-danger btn-xs d-inline-flex align-items-center gap-1 btn-eliminar-informe"
                                                    data-id="{{ $row['id'] }}"
                                                    data-nombre="{{ $row['nombre'] }}">
                                                    <i data-feather="trash-2" style="width:13px;height:13px;"></i> Eliminar
                                                </button>
                                            @endif
                                            <a class="btn btn-info btn-xs d-inline-flex align-items-center gap-1"
                                               target="_blank"
                                               href="{{ url('ssc/documentos/' . $row['informe']) }}">
                                                <i data-feather="file-text" style="width:13px;height:13px;"></i> Ver
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
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════ --}}
{{-- MODAL AGREGAR / EDITAR INFORME                  --}}
{{-- ════════════════════════════════════════════════ --}}
<div class="modal fade" id="modal_informe" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-azul">
                <h5 class="modal-title text-white fw-bold d-flex align-items-center gap-2">
                    <i data-feather="file-text" style="width:18px;height:18px;stroke:#fff;"></i>
                    <span id="modal_informe_titulo" style="color:#fff!important;">Informe</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">

                {{-- Descripcion --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Descripcion <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="inf_nombre" placeholder="Descripcion del informe...">
                </div>

                {{-- Estudiante --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Estudiante <span class="text-danger">*</span></label>
                    <select class="form-select" id="inf_estudiante">
                        @foreach($estudiantes_disponibles as $est)
                            <option value="{{ $est['numero_registro_asignado'] }}">
                                {{ $est['numero_registro_asignado'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Upload PDF --}}
                <div class="mb-2">
                    <label class="form-label fw-bold">Informe (PDF) <span class="text-danger">*</span></label>
                </div>

                {{-- Preview actual (modo edición) --}}
                <div id="inf_preview_actual" style="display:none;margin-bottom:12px;">
                    <div class="card" style="border:1px solid var(--azul);border-radius:8px;background:#f0f4ff;">
                        <div class="card-body py-2 px-3 d-flex align-items-center gap-3">
                            <i data-feather="file-text" style="width:26px;height:26px;stroke:var(--azul);"></i>
                            <div>
                                <div style="font-size:12px;color:#6c757d;">Informe actual</div>
                                <div id="inf_nombre_actual" style="font-size:13px;font-weight:600;color:var(--azul);"></div>
                            </div>
                            <a id="inf_link_actual" href="#" target="_blank"
                               class="btn btn-xs btn-outline-primary ms-auto" style="font-size:11px;">
                                <i data-feather="eye" style="width:12px;height:12px;"></i> Ver
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Area de upload --}}
                <div id="inf_upload_area"
                    style="border:2px dashed var(--azul);border-radius:10px;background:var(--verdeClaro);
                           padding:28px;text-align:center;cursor:pointer;transition:background .2s;"
                    onclick="document.getElementById('inf_file_input').click()">
                    <i data-feather="upload-cloud" style="width:36px;height:36px;stroke:var(--azul);margin-bottom:8px;"></i>
                    <p style="font-size:13px;color:var(--azul);font-weight:600;margin:0;">Haz clic para subir un PDF</p>
                    <p style="font-size:11px;color:#6c757d;margin:4px 0 0;">Solo .pdf — max. 10 MB</p>
                </div>
                <input type="file" id="inf_file_input" accept=".pdf" style="display:none;">

                {{-- Archivo seleccionado --}}
                <div id="inf_preview_nuevo" style="display:none;margin-top:12px;">
                    <div class="card" style="border:1px solid var(--verde);border-radius:8px;background:#f0faf2;">
                        <div class="card-body py-2 px-3 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <i data-feather="check-circle" style="width:22px;height:22px;stroke:var(--verde);"></i>
                                <div id="inf_file_nombre" style="font-size:13px;font-weight:600;color:var(--azul);"></div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger" id="inf_btn_quitar" style="font-size:11px;">
                                <i data-feather="x" style="width:12px;height:12px;"></i> Quitar
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Spinner upload --}}
                <div id="inf_uploading" style="display:none;text-align:center;padding:16px;">
                    <div class="spinner-border text-primary" style="width:1.8rem;height:1.8rem;"></div>
                    <p style="font-size:12px;color:var(--azul);margin-top:8px;">Subiendo PDF...</p>
                </div>

                <input type="hidden" id="inf_id">
                <input type="hidden" id="inf_filename">
            </div>
            <div class="modal-footer" style="border:none;">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-sm fw-bold" id="inf_btn_guardar"
                    style="background:var(--verde);color:#fff;">
                    <i data-feather="save" style="width:14px;height:14px;stroke:#fff;"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════ --}}
{{-- MODAL ELIMINAR INFORME                          --}}
{{-- ════════════════════════════════════════════════ --}}
<div class="modal fade" id="modal_eliminar_informe" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white d-flex align-items-center gap-2">
                    <i data-feather="trash-2" style="width:18px;height:18px;stroke:#fff;"></i> Eliminar Informe
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i data-feather="alert-triangle" class="text-danger mb-3" style="width:60px;height:60px;"></i>
                <h5>¿Eliminar este informe?</h5>
                <p class="text-muted mb-1" id="eliminar_informe_nombre" style="font-size:13px;"></p>
                <p class="text-danger fw-bold" style="font-size:12px;">Esta accion no se puede revertir.</p>
                <input type="hidden" id="eliminar_informe_id">
            </div>
            <div class="modal-footer bg-secondary">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger btn-sm" id="btn_confirmar_eliminar">
                    <i data-feather="trash-2" style="width:14px;height:14px;"></i> Eliminar
                </button>
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
<script>
    var ID_SOLICITUD = {{ $id_solicitud }};
    var ESTADO       = '{{ $estado }}';

    var URL_GUARDAR       = '{{ url("ssc/proyectos/informes/" . $id_solicitud . "/guardar") }}';
    var URL_UPLOAD        = '{{ url("ssc/upload-informe") }}';
    var URL_DELETE_FILE   = '{{ url("ssc/informes/archivo/eliminar") }}';
    var URL_DOC_SSC       = '{{ url("ssc/documentos") }}/';

    var dtLang = {
        processing: "Procesando...", search: "Buscar:",
        lengthMenu: "Mostrar _MENU_ registros",
        info: "Mostrando del _START_ al _END_ de _TOTAL_ registros",
        infoEmpty: "Sin resultados", zeroRecords: "No se encontraron resultados",
        emptyTable: "Ningún dato disponible", loadingRecords: "Cargando...",
        paginate: { first: "Primero", previous: "Anterior", next: "Siguiente", last: "Último" }
    };

    var table        = null;
    var accion       = null;   // 1=crear, 2=editar, 3=eliminar
    var infFilename  = null;   // nombre del archivo subido (fuente de verdad)

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    // ── DataTable ──
    $(document).ready(function () {
        table = $('#tbl_informes').DataTable({ language: dtLang, pageLength: 25 });
        setTimeout(feather.replace, 0);

        // ── Abrir modal AGREGAR ──
        $('#btn_agregar_informe').on('click', function () {
            accion = 1;
            resetModal();
            $('#modal_informe_titulo').text('Agregar Informe');
            new bootstrap.Modal(document.getElementById('modal_informe')).show();
        });

        // ── Abrir modal EDITAR ──
        $(document).on('click', '.btn-editar-informe', function () {
            accion = 2;
            resetModal();
            var btn = this;
            $('#inf_id').val(btn.getAttribute('data-id'));
            $('#inf_nombre').val(btn.getAttribute('data-nombre'));
            $('#inf_estudiante').val(btn.getAttribute('data-estudiante').split(',')[0].trim());

            var archivoActual = btn.getAttribute('data-informe');
            if (archivoActual) {
                infFilename = archivoActual;
                $('#inf_filename').val(archivoActual);
                $('#inf_nombre_actual').text(archivoActual);
                $('#inf_link_actual').attr('href', URL_DOC_SSC + archivoActual);
                $('#inf_preview_actual').show();
            }

            $('#modal_informe_titulo').text('Editar Informe');
            new bootstrap.Modal(document.getElementById('modal_informe')).show();
            setTimeout(feather.replace, 0);
        });

        // ── Abrir modal ELIMINAR ──
        $(document).on('click', '.btn-eliminar-informe', function () {
            accion = 3;
            var id = this.getAttribute('data-id');
            var nombre = this.getAttribute('data-nombre');
            $('#eliminar_informe_id').val(id);
            $('#eliminar_informe_nombre').text('"' + nombre + '"');
            new bootstrap.Modal(document.getElementById('modal_eliminar_informe')).show();
        });

        // ── Confirmar eliminar ──
        $('#btn_confirmar_eliminar').on('click', function () {
            var id = $('#eliminar_informe_id').val();
            guardarInforme({ id: id, accion: 3 });
            var modalEl = document.getElementById('modal_eliminar_informe');
            bootstrap.Modal.getInstance(modalEl).hide();
        });

        // ── Upload PDF ──
        $('#inf_file_input').on('change', function () {
            var file = this.files[0];
            if (!file) return;
            if (file.type !== 'application/pdf') {
                Swal.fire({ icon: 'error', title: 'Archivo invalido', text: 'Solo se permiten archivos PDF.', confirmButtonColor: '#203b76' });
                return;
            }
            if (file.size > 10 * 1024 * 1024) {
                Swal.fire({ icon: 'error', title: 'Archivo muy grande', text: 'El archivo no debe superar 10 MB.', confirmButtonColor: '#203b76' });
                return;
            }

            $('#inf_upload_area').hide();
            $('#inf_uploading').show();

            var formData = new FormData();
            formData.append('file', file);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: URL_UPLOAD,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#inf_uploading').hide();
                    if (!data || data.error) {
                        Swal.fire({ icon: 'error', title: 'Error', text: (data && data.error) ? data.error : 'Respuesta invalida del servidor.', confirmButtonColor: '#203b76' });
                        $('#inf_upload_area').show();
                        return;
                    }
                    infFilename = data.filename;
                    $('#inf_filename').val(data.filename);
                    $('#inf_file_nombre').text(file.name);
                    $('#inf_preview_nuevo').show();
                    setTimeout(feather.replace, 0);
                },
                error: function (xhr) {
                    $('#inf_uploading').hide();
                    $('#inf_upload_area').show();
                    Swal.fire({ icon: 'error', title: 'Error al subir', text: 'No se pudo subir el archivo.', confirmButtonColor: '#203b76' });
                }
            });
        });

        // ── Quitar archivo nuevo ──
        $('#inf_btn_quitar').on('click', function () {
            var archivoTemp = infFilename;
            infFilename = $('#inf_filename').val() || null; // restaurar referencia al archivo guardado (si lo hay)
            resetUploadArea();
            if (archivoTemp && archivoTemp !== infFilename) {
                $.post(URL_DELETE_FILE, {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    filename: archivoTemp
                });
            }
        });

        // ── Guardar (crear/editar) ──
        $('#inf_btn_guardar').on('click', function () {
            var nombre    = $('#inf_nombre').val().trim();
            var estudiante = $('#inf_estudiante').val();
            var filename  = $('#inf_filename').val().trim();
            var id        = $('#inf_id').val();

            if (!nombre) {
                Swal.fire({ icon: 'warning', title: 'Campo requerido', text: 'Ingresa una descripcion para el informe.', confirmButtonColor: '#203b76' });
                return;
            }
            if (!estudiante) {
                Swal.fire({ icon: 'warning', title: 'Campo requerido', text: 'Selecciona un estudiante.', confirmButtonColor: '#203b76' });
                return;
            }
            if (!filename) {
                Swal.fire({ icon: 'warning', title: 'Campo requerido', text: 'Adjunta el PDF del informe.', confirmButtonColor: '#203b76' });
                return;
            }

            guardarInforme({ id: id, nombre: nombre, estudiante: estudiante, informe: filename, accion: accion });

            var modalEl = document.getElementById('modal_informe');
            bootstrap.Modal.getInstance(modalEl).hide();
        });
    });

    // ── Funcion AJAX guardar/eliminar ──
    function guardarInforme(payload) {
        $.ajax({
            type: 'POST',
            url: URL_GUARDAR,
            data: payload,
            success: function (data) {
                if (data.msgError) {
                    Swal.fire({ icon: 'error', title: 'Error', text: data.msgError, confirmButtonColor: '#203b76' });
                    return;
                }
                Swal.fire({ icon: 'success', title: '¡Listo!', text: data.msgSuccess, timer: 2000, showConfirmButton: false });
                // Refrescar tabla
                setTimeout(function () { location.reload(); }, 2100);
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Error de conexion', text: 'No se pudo completar la operacion.', confirmButtonColor: '#203b76' });
            }
        });
    }

    // ── Reset modal ──
    function resetModal() {
        infFilename = null;
        $('#inf_id').val('');
        $('#inf_nombre').val('');
        $('#inf_filename').val('');
        $('#inf_file_input').val('');
        $('#inf_preview_actual').hide();
        $('#inf_preview_nuevo').hide();
        $('#inf_uploading').hide();
        $('#inf_upload_area').show();
    }

    function resetUploadArea() {
        $('#inf_preview_nuevo').hide();
        $('#inf_file_input').val('');
        $('#inf_upload_area').show();
    }
</script>
@endpush
