@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/prismjs/prism.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-dark" role="alert">
                    <h1 class="display-1 d-flex align-items-center">
                        <i data-feather="users" class="me-3" style="width: 90px; height: 90px;"></i>
                        <strong>COORDINADORES</strong>
                    </h1>
                    <h4 class="lead bg-white">
                        <div class="alert alert-fill-white" role="alert">
                            "Gestión de coordinadores por carrera y sede."
                        </div>
                    </h4>
                    <br>
                </div>
                <hr/>

                <div class="col-12 col-md-12 col-xl-12">
                    <div class="card border-secondary">
                        <h5 class="card-header bg-azul text-white d-flex justify-content-between align-items-center">
                            <span class="text-white">
                                <i class="text-white icon-lg pb-3px" data-feather="layers"></i>
                                Coordinadores de Carrera
                            </span>
                            <button class="btn btn-primary btn-xs" id="btn_agregar_coordinador"
                                    data-bs-toggle="modal" data-bs-target="#modal_agregar_coordinador">
                                <i class="btn-icon-prepend" data-feather="plus"></i> Agregar
                            </button>
                        </h5>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="jambo_table table table-hover" id="tbl_verc_coordinadores" border="1">
                                    <thead class="bg-primary">
                                        <tr class="headings">
                                            <th scope="col" class="text-white">ID</th>
                                            <th scope="col" class="text-white">Identidad</th>
                                            <th scope="col" class="text-white">Primer Nombre</th>
                                            <th scope="col" class="text-white">Segundo Nombre</th>
                                            <th scope="col" class="text-white">Primer Apellido</th>
                                            <th scope="col" class="text-white">Segundo Apellido</th>
                                            <th scope="col" class="text-white">Correo Electrónico</th>
                                            <th scope="col" class="text-white">Carrera</th>
                                            <th scope="col" class="text-white">Sede</th>
                                            <th scope="col" class="text-white">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($verc_coordinadores as $row)
                                        <tr style="font-size: small;">
                                            <td scope="row">{{ $row['id_coordinador_carrera'] }}</td>
                                            <td scope="row">{{ $row['identidad'] }}</td>
                                            <td scope="row">{{ $row['primer_nombre'] }}</td>
                                            <td scope="row">{{ $row['segundo_nombre'] ?? '' }}</td>
                                            <td scope="row">{{ $row['primer_apellido'] }}</td>
                                            <td scope="row">{{ $row['segundo_apellido'] ?? '' }}</td>
                                            <td scope="row">{{ $row['correo_electronico'] }}</td>
                                            <td scope="row">{{ $row['nombre_carrera'] }}</td>
                                            <td scope="row">{{ $row['nombre_sede'] }}</td>
                                            <td>
                                                {{-- Botón Editar --}}
                                                <button type="button" class="btn btn-warning btn-icon btn-xs btn_editar_coordinador"
                                                        data-bs-toggle="modal" data-bs-target="#modal_editar_coordinador"
                                                        data-id_coordinador_carrera="{{ $row['id_coordinador_carrera'] }}"
                                                        data-id_empleado="{{ $row['id_empleado'] ?? '' }}"
                                                        data-id_carrera="{{ $row['id_carrera'] }}"
                                                        data-id_sede="{{ $row['id_sede'] ?? '' }}"
                                                        data-identidad="{{ $row['identidad'] }}"
                                                        data-primer_nombre="{{ $row['primer_nombre'] }}"
                                                        data-segundo_nombre="{{ $row['segundo_nombre'] ?? '' }}"
                                                        data-primer_apellido="{{ $row['primer_apellido'] }}"
                                                        data-segundo_apellido="{{ $row['segundo_apellido'] ?? '' }}"
                                                        data-correo_electronico="{{ $row['correo_electronico'] }}"
                                                        data-nombre_carrera="{{ $row['nombre_carrera'] }}"
                                                        data-nombre_sede="{{ $row['nombre_sede'] }}">
                                                    <i data-feather="edit"></i>
                                                </button>
                                                {{-- Botón Eliminar --}}
                                                <button type="button" class="btn btn-danger btn-icon btn-xs btn_eliminar_coordinador"
                                                        data-id_coordinador_carrera="{{ $row['id_coordinador_carrera'] }}"
                                                        data-id_empleado="{{ $row['id_empleado'] ?? '' }}"
                                                        data-id_carrera="{{ $row['id_carrera'] }}"
                                                        data-id_sede="{{ $row['id_sede'] ?? '' }}"
                                                        data-nombre_completo="{{ trim(implode(' ', array_filter([$row['primer_nombre'], $row['segundo_nombre'] ?? '', $row['primer_apellido'], $row['segundo_apellido'] ?? '']))) }}"
                                                        data-nombre_carrera="{{ $row['nombre_carrera'] }}"
                                                        data-nombre_sede="{{ $row['nombre_sede'] }}"
                                                        data-label="{{ $row['primer_nombre'] }} {{ $row['primer_apellido'] }}">
                                                    <i data-feather="trash"></i>
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
            </div>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- MODAL AGREGAR --}}
{{-- ============================================================ --}}
<div class="modal fade" id="modal_agregar_coordinador" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title h6 text-white" id="modal_agregar_coordinador_label">
                    <i class="icon-lg pb-3px" data-feather="plus-square"></i> Asignar Nuevo Coordinador
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label>Empleado <span class="text-danger">*</span></label>
                        <select id="modal_agregar_coordinador_nombre_empleado" class="form-control select2" style="width:100%">
                            <option value="">-- Seleccione un empleado --</option>
                        </select>
                        <input type="hidden" id="modal_agregar_coordinador_id_empleado" />
                        <div class="invalid-feedback">Seleccione un empleado.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Carrera <span class="text-danger">*</span></label>
                        <select id="modal_agregar_coordinador_nombre_carrera" class="form-control select2" style="width:100%">
                            <option value="">-- Seleccione una carrera --</option>
                        </select>
                        <input type="hidden" id="modal_agregar_coordinador_id_carrera" />
                        <div class="invalid-feedback">Seleccione una carrera.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Sede <span class="text-danger">*</span></label>
                        <select id="modal_agregar_coordinador_nombre_sede" class="form-control select2" style="width:100%">
                            <option value="">-- Seleccione una sede --</option>
                        </select>
                        <input type="hidden" id="modal_agregar_coordinador_id_sede" />
                        <div class="invalid-feedback">Seleccione una sede.</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="boton_guardarc_coordinador">Guardar</button>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- MODAL EDITAR                                                  --}}
{{-- CAMBIO: carrera ahora es un select editable igual que sede   --}}
{{-- ============================================================ --}}
<div class="modal fade" id="modal_editar_coordinador" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h6 class="modal-title h6 text-white" id="modal_editar_coordinador_label">
                    <i class="icon-lg pb-3px" data-feather="edit-3"></i> Editar Coordinador
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                {{-- Campos ocultos --}}
                <input type="hidden" id="modal_editar_coordinador_id_coordinador_carrera" />
                <input type="hidden" id="modal_editar_coordinador_id_empleado" />
                {{-- id_carrera e id_sede se actualizan al cambiar el select --}}
                <input type="hidden" id="modal_editar_coordinador_id_carrera" />
                <input type="hidden" id="modal_editar_coordinador_id_sede" />

                {{-- Información de solo lectura del empleado actual --}}
                <div class="alert alert-info">
                    <strong>Información del Empleado:</strong><br>
                    <span id="info_empleado"></span>
                </div>

                <div class="row">
                    {{-- Carrera: ahora editable con select2 --}}
                    <div class="col-md-6 mb-3">
                        <label>Carrera <span class="text-danger">*</span></label>
                        <select id="modal_editar_coordinador_nombre_carrera" class="form-control select2" style="width:100%">
                            <option value="">-- Seleccione una carrera --</option>
                        </select>
                        <div class="invalid-feedback">Seleccione una carrera.</div>
                    </div>
                    {{-- Sede: editable --}}
                    <div class="col-md-6 mb-3">
                        <label>Sede <span class="text-danger">*</span></label>
                        <select id="modal_editar_coordinador_nombre_sede" class="form-control select2" style="width:100%">
                            <option value="">-- Seleccione una sede --</option>
                        </select>
                        <div class="invalid-feedback">Seleccione una sede.</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" id="boton_editar_coordinador">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/prismjs/prism.js') }}"></script>
<script src="{{ asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
<script src="{{ asset('assets/js/data-table.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/plugins/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/sweet-alert.js') }}"></script>

<script type="text/javascript">

// ================================================================
// Variables globales
// ================================================================
let id_coordinador_carrera = null;
let id_empleado            = null;
let id_carrera             = null;
let id_sede                = null;
let nombre_completo        = null;
let nombre_carrera         = null;
let nombre_sede            = null;
let accion     = 1;
let rowNumber  = null;
let table      = null;

const url_guardarc_coordinadores = '/coordinadores/guardarc';
const url_listas_coordinadores   = '/coordinadores/listas';

// ================================================================
// Toast global
// ================================================================
const ToastLG = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

// ================================================================
// Spinner de espera
// ================================================================
function espera(mensaje) {
    Swal.fire({
        title: mensaje,
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });
}

// ================================================================
// DOCUMENT READY
// ================================================================
$(document).ready(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // ------------------------------------------------------------
    // DataTable
    // ------------------------------------------------------------
    table = $('#tbl_verc_coordinadores').DataTable({
        "aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "Todo"]],
        "iDisplayLength": 10,
        language: {
            processing:     "Procesando...",
            search:         "Buscar:",
            lengthMenu:     "Mostrar _MENU_ registros",
            info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered:   "(filtrado de un total de _MAX_ registros)",
            loadingRecords: "Cargando...",
            zeroRecords:    "No se encontraron resultados",
            emptyTable:     "Ningún dato disponible en esta tabla",
            paginate: {
                first:    "Primero",
                previous: "Anterior",
                next:     "Siguiente",
                last:     "Último"
            },
            aria: {
                sortAscending:  ": Activar para ordenar ascendente",
                sortDescending: ": Activar para ordenar descendente"
            }
        },
        drawCallback: function () {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        }
    });

    // Ajuste visual de controles DataTable
    $('#tbl_verc_coordinadores').each(function () {
        let datatable    = $(this);
        let search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
        search_input.attr('placeholder', 'Buscar').removeClass('form-control-sm');
        datatable.closest('.dataTables_wrapper').find('div[id$=_length] select').removeClass('form-control-sm');
    });

    // Renderizar íconos feather en las filas iniciales
    if (typeof feather !== 'undefined') {
        feather.replace();
    }

    // Resaltar fila seleccionada
    $("#tbl_verc_coordinadores tbody").on("click", "tr", function () {
        rowNumber = parseInt(table.row(this).index());
        accion = 2;
        table.$("tr.selected").removeClass("selected");
        $(this).addClass("selected");
    });

    // ------------------------------------------------------------
    // Cargar listas al abrir modal AGREGAR
    // ------------------------------------------------------------
    $('#modal_agregar_coordinador').on('show.bs.modal', function () {
        cargarListas('agregar');
    });

    // Limpiar modal AGREGAR al cerrarse
    $('#modal_agregar_coordinador').on('hidden.bs.modal', function () {
        limpiarModalAgregar();
        accion = 1;
    });

    // ------------------------------------------------------------
    // Modal EDITAR: poblar datos del registro seleccionado
    // ------------------------------------------------------------
    $('#modal_editar_coordinador').on('show.bs.modal', function (e) {
        let trigger = $(e.relatedTarget);
        rowNumber = table.row(trigger.closest('tr')).index();

        id_coordinador_carrera = trigger.data('id_coordinador_carrera');
        id_empleado            = trigger.data('id_empleado');
        id_carrera             = trigger.data('id_carrera');
        id_sede                = trigger.data('id_sede');
        nombre_carrera         = trigger.data('nombre_carrera');
        nombre_sede            = trigger.data('nombre_sede');

        let identidad          = trigger.data('identidad');
        let primer_nombre      = trigger.data('primer_nombre');
        let segundo_nombre     = trigger.data('segundo_nombre');
        let primer_apellido    = trigger.data('primer_apellido');
        let segundo_apellido   = trigger.data('segundo_apellido');
        let correo_electronico = trigger.data('correo_electronico');

        // Construir nombre_completo para enviarlo al backend
        nombre_completo = [primer_nombre, segundo_nombre, primer_apellido, segundo_apellido]
                            .filter(Boolean).join(' ').trim();

        // Campos ocultos
        $('#modal_editar_coordinador_id_coordinador_carrera').val(id_coordinador_carrera);
        $('#modal_editar_coordinador_id_empleado').val(id_empleado);

        // Bloque informativo del empleado (solo lectura)
        $('#info_empleado').html(`
            <strong>Identidad:</strong> ${identidad || 'N/A'}<br>
            <strong>Nombre:</strong> ${primer_nombre || ''} ${segundo_nombre || ''} ${primer_apellido || ''} ${segundo_apellido || ''}<br>
            <strong>Correo:</strong> ${correo_electronico || 'N/A'}
        `);

        // Cargar selects de carrera y sede con los valores actuales preseleccionados
        cargarListas('editar');
    });

    // Limpiar modal EDITAR al cerrarse
    $('#modal_editar_coordinador').on('hidden.bs.modal', function () {
        limpiarModalEditar();
    });

    // ------------------------------------------------------------
    // Botón GUARDAR (acción 1 - crear)
    // ------------------------------------------------------------
    $('#boton_guardarc_coordinador').on('click', function () {
        accion = 1;
        id_coordinador_carrera = null;

        nombre_completo = $('#modal_agregar_coordinador_nombre_empleado').val().trim();
        nombre_carrera  = $('#modal_agregar_coordinador_nombre_carrera').val().trim();
        nombre_sede     = $('#modal_agregar_coordinador_nombre_sede').val().trim();
        id_empleado     = $('#modal_agregar_coordinador_id_empleado').val();
        id_carrera      = $('#modal_agregar_coordinador_id_carrera').val();
        id_sede         = $('#modal_agregar_coordinador_id_sede').val();

        // Limpiar validaciones previas
        $('#modal_agregar_coordinador_nombre_empleado').removeClass('is-invalid');
        $('#modal_agregar_coordinador_nombre_carrera').removeClass('is-invalid');
        $('#modal_agregar_coordinador_nombre_sede').removeClass('is-invalid');

        let valido = true;

        if (!nombre_completo) {
            $('#modal_agregar_coordinador_nombre_empleado').addClass('is-invalid');
            valido = false;
        }
        if (!nombre_carrera) {
            $('#modal_agregar_coordinador_nombre_carrera').addClass('is-invalid');
            valido = false;
        }
        if (!nombre_sede) {
            $('#modal_agregar_coordinador_nombre_sede').addClass('is-invalid');
            valido = false;
        }

        if (!valido) {
            Swal.fire('Campos obligatorios', 'Completa todos los campos para continuar.', 'warning');
            return;
        }

        guardarc_coordinadores();
    });

    // ------------------------------------------------------------
    // Botón EDITAR (acción 2 - actualizar) — carrera y sede editables
    // ------------------------------------------------------------
    $('#boton_editar_coordinador').on('click', function () {
        accion = 2;

        id_coordinador_carrera = $('#modal_editar_coordinador_id_coordinador_carrera').val();
        id_empleado            = $('#modal_editar_coordinador_id_empleado').val();
        id_carrera             = $('#modal_editar_coordinador_id_carrera').val();
        id_sede                = $('#modal_editar_coordinador_id_sede').val();
        nombre_carrera         = $('#modal_editar_coordinador_nombre_carrera').val().trim();
        nombre_sede            = $('#modal_editar_coordinador_nombre_sede').val().trim();

        // Limpiar validaciones previas
        $('#modal_editar_coordinador_nombre_carrera').removeClass('is-invalid');
        $('#modal_editar_coordinador_nombre_sede').removeClass('is-invalid');

        let valido = true;

        if (!nombre_carrera) {
            $('#modal_editar_coordinador_nombre_carrera').addClass('is-invalid');
            valido = false;
        }
        if (!nombre_sede) {
            $('#modal_editar_coordinador_nombre_sede').addClass('is-invalid');
            valido = false;
        }

        if (!valido) {
            Swal.fire('Campos obligatorios', 'Selecciona carrera y sede para continuar.', 'warning');
            return;
        }

        guardarc_coordinadores();
    });

    // ------------------------------------------------------------
    // Botón ELIMINAR con SweetAlert (acción 3 - eliminar)
    // ------------------------------------------------------------
    $(document).on('click', '.btn_eliminar_coordinador', function () {
        accion = 3;
        let boton = $(this);

        id_coordinador_carrera = boton.data('id_coordinador_carrera');
        id_empleado            = boton.data('id_empleado');
        id_carrera             = boton.data('id_carrera');
        id_sede                = boton.data('id_sede');

        nombre_completo = boton.data('nombre_completo') || '';
        nombre_carrera  = boton.data('nombre_carrera')  || '';
        nombre_sede     = boton.data('nombre_sede')     || '';

        let label     = boton.data('label') || nombre_completo;
        let fila      = boton.closest('tr');
        rowNumber     = table.row(fila).index();

        Swal.fire({
            title: '¿Estás seguro?',
            text: `Se eliminará al coordinador: "${label}"`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                guardarc_coordinadores();
            }
        });
    });

}); // fin document ready


// ================================================================
// Cargar listas de empleados, carreras y sedes desde el backend
// ================================================================
function cargarListas(modal) {
    $.ajax({
        url: url_listas_coordinadores,
        method: 'GET',
        success: function (data) {
            if (!data.estatus) return;

            if (modal === 'agregar') {

                // --- Empleados ---
                let selEmp = $('#modal_agregar_coordinador_nombre_empleado');
                selEmp.empty().append('<option value="">-- Seleccione un empleado --</option>');
                $.each(data.empleados, function (i, emp) {
                    selEmp.append(
                        $('<option>', {
                            value:     emp.nombre_completo,
                            text:      emp.nombre_completo,
                            'data-id': emp.id_empleado
                        })
                    );
                });

                // --- Carreras ---
                let selCar = $('#modal_agregar_coordinador_nombre_carrera');
                selCar.empty().append('<option value="">-- Seleccione una carrera --</option>');
                $.each(data.carreras, function (i, car) {
                    let descripcion = car.nombre_carrera.lastIndexOf('-') !== -1
                        ? car.nombre_carrera.substring(car.nombre_carrera.lastIndexOf('-') + 1).trim()
                        : car.nombre_carrera;
                    selCar.append(
                        $('<option>', {
                            value:     descripcion,
                            text:      car.nombre_carrera,
                            'data-id': car.id_carrera
                        })
                    );
                });

                // --- Sedes ---
                let selSed = $('#modal_agregar_coordinador_nombre_sede');
                selSed.empty().append('<option value="">-- Seleccione una sede --</option>');
                $.each(data.sedes, function (i, sed) {
                    selSed.append(
                        $('<option>', {
                            value:     sed.nombre_sede,
                            text:      sed.nombre_sede,
                            'data-id': sed.id_sede
                        })
                    );
                });

                // Sincronizar hidden ids al cambiar selección
                selEmp.off('change.sync').on('change.sync', function () {
                    $('#modal_agregar_coordinador_id_empleado').val($(this).find(':selected').data('id') || '');
                });
                selCar.off('change.sync').on('change.sync', function () {
                    $('#modal_agregar_coordinador_id_carrera').val($(this).find(':selected').data('id') || '');
                });
                selSed.off('change.sync').on('change.sync', function () {
                    $('#modal_agregar_coordinador_id_sede').val($(this).find(':selected').data('id') || '');
                });

                // Inicializar select2
                selEmp.select2({ dropdownParent: $('#modal_agregar_coordinador'), sorter: data => data });
                selCar.select2({ dropdownParent: $('#modal_agregar_coordinador'), sorter: data => data });
                selSed.select2({ dropdownParent: $('#modal_agregar_coordinador'), sorter: data => data });

            } else if (modal === 'editar') {

                // --- Carreras (con preselección del registro actual) ---
                let selCar = $('#modal_editar_coordinador_nombre_carrera');
                selCar.empty().append('<option value="">-- Seleccione una carrera --</option>');
                $.each(data.carreras, function (i, car) {
                    let descripcion = car.nombre_carrera.lastIndexOf('-') !== -1
                        ? car.nombre_carrera.substring(car.nombre_carrera.lastIndexOf('-') + 1).trim()
                        : car.nombre_carrera;

                    // Preseleccionar comparando descripcion con nombre_carrera guardado
                    let estaSeleccionada = (descripcion === nombre_carrera || car.nombre_carrera === nombre_carrera);

                    selCar.append(
                        $('<option>', {
                            value:     descripcion,
                            text:      car.nombre_carrera,
                            'data-id': car.id_carrera,
                            selected:  estaSeleccionada
                        })
                    );
                });

                // Actualizar hidden id_carrera con el valor preseleccionado
                $('#modal_editar_coordinador_id_carrera').val(selCar.find(':selected').data('id') || '');

                // Sincronizar hidden id_carrera al cambiar selección
                selCar.off('change.sync').on('change.sync', function () {
                    let opt = $(this).find(':selected');
                    $('#modal_editar_coordinador_id_carrera').val(opt.data('id') || '');
                    nombre_carrera = $(this).val();
                });

                // Inicializar select2
                selCar.select2({ dropdownParent: $('#modal_editar_coordinador'), sorter: data => data });

                // --- Sedes (con preselección del registro actual) ---
                let selSed = $('#modal_editar_coordinador_nombre_sede');
                selSed.empty().append('<option value="">-- Seleccione una sede --</option>');
                $.each(data.sedes, function (i, sed) {
                    selSed.append(
                        $('<option>', {
                            value:     sed.nombre_sede,
                            text:      sed.nombre_sede,
                            'data-id': sed.id_sede,
                            selected:  (sed.nombre_sede === nombre_sede)
                        })
                    );
                });

                // Actualizar hidden id_sede con el valor preseleccionado
                $('#modal_editar_coordinador_id_sede').val(selSed.find(':selected').data('id') || '');

                // Sincronizar hidden id_sede al cambiar selección
                selSed.off('change.sync').on('change.sync', function () {
                    let opt = $(this).find(':selected');
                    $('#modal_editar_coordinador_id_sede').val(opt.data('id') || '');
                    nombre_sede = $(this).val();
                });

                // Inicializar select2
                selSed.select2({ dropdownParent: $('#modal_editar_coordinador'), sorter: data => data });
            }
        },
        error: function () {
            Swal.fire('Error', 'No se pudieron cargar los datos de selección.', 'error');
        }
    });
}

// ================================================================
// Limpiar modales
// ================================================================
function limpiarModalAgregar() {
    $('#modal_agregar_coordinador_nombre_empleado').val('').trigger('change');
    $('#modal_agregar_coordinador_nombre_carrera').val('').trigger('change');
    $('#modal_agregar_coordinador_nombre_sede').val('').trigger('change');
    $('#modal_agregar_coordinador_id_empleado').val('');
    $('#modal_agregar_coordinador_id_carrera').val('');
    $('#modal_agregar_coordinador_id_sede').val('');
    $('#modal_agregar_coordinador_nombre_empleado, #modal_agregar_coordinador_nombre_carrera, #modal_agregar_coordinador_nombre_sede')
        .removeClass('is-invalid');
}

function limpiarModalEditar() {
    $('#modal_editar_coordinador_nombre_carrera').val('').trigger('change');
    $('#modal_editar_coordinador_nombre_sede').val('').trigger('change');
    $('#modal_editar_coordinador_id_coordinador_carrera').val('');
    $('#modal_editar_coordinador_id_empleado').val('');
    $('#modal_editar_coordinador_id_carrera').val('');
    $('#modal_editar_coordinador_id_sede').val('');
    $('#info_empleado').html('');
    $('#modal_editar_coordinador_nombre_carrera, #modal_editar_coordinador_nombre_sede')
        .removeClass('is-invalid');
}

// ================================================================
// Función principal AJAX guardar/editar/eliminar
// ================================================================
function guardarc_coordinadores() {
    espera('Procesando...');

    $.ajax({
        url: url_guardarc_coordinadores,
        method: 'POST',
        headers: { 'Authorization': '{{ session("token") }}' },
        data: {
            accion:                 accion,
            id_coordinador_carrera: id_coordinador_carrera,
            id_empleado:            id_empleado,
            id_carrera:             id_carrera,
            id_sede:                id_sede,
            nombre_completo:        nombre_completo,
            nombre_carrera:         nombre_carrera,
            nombre_sede:            nombre_sede
        },
        success: function (data) {
            let titleMsg, textMsg = '', typeMsg, timer;

            if (data.msgError) {
                titleMsg = 'Error al guardar';
                textMsg  = data.msgError;
                typeMsg  = 'error';
                timer    = null;
            } else {
                titleMsg = data.msgSuccess || 'Operación exitosa';
                typeMsg  = 'success';
                timer    = 2000;

                if (data.coordinador) {
                    let row = data.coordinador;
                    let nuevaFilaDT = [
                        row.id_coordinador_carrera,
                        row.identidad          || '',
                        row.primer_nombre      || '',
                        row.segundo_nombre     || '',
                        row.primer_apellido    || '',
                        row.segundo_apellido   || '',
                        row.correo_electronico || '',
                        row.nombre_carrera     || '',
                        row.nombre_sede        || '',
                        generarBotones(row)
                    ];

                    if (accion == 1) {
                        table.row.add(nuevaFilaDT).draw();
                    } else if (accion == 2) {
                        table.row(rowNumber).data(nuevaFilaDT).draw();
                    }
                } else if (accion == 3) {
                    table.row(rowNumber).remove().draw();
                }

                $('.modal').modal('hide');
            }

            ToastLG.fire({ icon: typeMsg, title: titleMsg, html: textMsg, timer });
        },
        error: function (xhr) {
            Swal.fire('Error', xhr.responseText || 'No se pudo procesar la solicitud.', 'error');
        }
    });
}

// ================================================================
// Generar botones de acción para DataTable (filas nuevas/actualizadas)
// ================================================================
function generarBotones(row) {
    let nombreCompleto = [row.primer_nombre, row.segundo_nombre, row.primer_apellido, row.segundo_apellido]
                            .filter(Boolean).join(' ').trim();
    let labelCorto = ((row.primer_nombre || '') + ' ' + (row.primer_apellido || '')).trim();

    return `
        <button type="button" class="btn btn-warning btn-icon btn-xs btn_editar_coordinador"
                data-bs-toggle="modal" data-bs-target="#modal_editar_coordinador"
                data-id_coordinador_carrera="${row.id_coordinador_carrera}"
                data-id_empleado="${row.id_empleado || ''}"
                data-id_carrera="${row.id_carrera}"
                data-id_sede="${row.id_sede || ''}"
                data-identidad="${row.identidad || ''}"
                data-primer_nombre="${row.primer_nombre || ''}"
                data-segundo_nombre="${row.segundo_nombre || ''}"
                data-primer_apellido="${row.primer_apellido || ''}"
                data-segundo_apellido="${row.segundo_apellido || ''}"
                data-correo_electronico="${row.correo_electronico || ''}"
                data-nombre_carrera="${row.nombre_carrera || ''}"
                data-nombre_sede="${row.nombre_sede || ''}">
            <i data-feather="edit"></i>
        </button>
        <button type="button" class="btn btn-danger btn-icon btn-xs btn_eliminar_coordinador"
                data-id_coordinador_carrera="${row.id_coordinador_carrera}"
                data-id_empleado="${row.id_empleado || ''}"
                data-id_carrera="${row.id_carrera}"
                data-id_sede="${row.id_sede || ''}"
                data-nombre_completo="${nombreCompleto}"
                data-nombre_carrera="${row.nombre_carrera || ''}"
                data-nombre_sede="${row.nombre_sede || ''}"
                data-label="${labelCorto}">
            <i data-feather="trash"></i>
        </button>
    `;
}

</script>
@endpush
