
@extends('layout.master')
@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #006837, #28a745);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 text-white">
                            <i class="fas fa-user-md me-2"></i>
                            Historial Clínico
                        </h4>
                        <p class="mb-0 opacity-75 text-white">
                            <i class="fas fa-calendar me-1"></i>
                            Sistema de Psicología - UNAG
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla principal -->
<div class="row">
    <div class="col-12">
        <div class="card border-success shadow-sm">
            <div class="card-header bg-success text-white fw-bold">
                Lista de Pacientes con Citas
            </div>
            <div class="card-body">
                <table id="tablaHistorialPrincipal" class="table table-striped table-hover table-bordered" style="width:100%">
                    <thead class="table-success text-success">
                        <tr>
                            <th class="text-center">ID Cita</th>
                            <th class="text-center">Número Registro</th>
                            <th>Nombre Completo</th>
                            <th class="text-center" style="width: 100px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Historial Clínico -->
<div class="modal fade" id="modalHistorialClinico" tabindex="-1" aria-labelledby="modalHistorialClinicoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #28a745, #20c997);">
                <h5 class="modal-title text-white" id="modalHistorialClinicoLabel">
                    <i class="fas fa-history me-2"></i>
                    Historial Clínico del Paciente
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-0">
                <!-- Loading State -->
                <div id="loadingHistorial" class="text-center py-5">
                    <div class="spinner-border text-success" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Cargando historial...</span>
                    </div>
                    <p class="mt-3 text-muted fs-5">Cargando historial clínico...</p>
                </div>
                <!-- DataTable Content -->
                <div id="contenidoHistorial" style="display: none;" class="p-4">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle" id="tablaHistorial">
                            <thead class="table-success">
                                <tr>
                                    <th class="text-center"><i class="fas fa-hashtag me-1"></i>ID Cita</th>
                                    <th class="text-center"><i class="fas fa-calendar-alt me-1"></i>Número Cita</th>
                                    <th class="text-center"><i class="fas fa-id-card me-1"></i>Número Registro</th>
                                    <th class="text-center"><i class="fas fa-user me-1"></i>Nombre Completo</th>
                                    <th class="text-center"><i class="fas fa-user-md me-1"></i>Profesional Responsable</th>
                                    <th class="text-center"><i class="fas fa-clock me-1"></i>Fecha</th>
                                    <th class="text-center"><i class="fas fa-cogs me-1"></i>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="cuerpoTablaHistorial">
                                <!-- Datos cargados dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<!-- DataTables CSS/JS si no están en master -->
<link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    var modalHistorial = new bootstrap.Modal(document.getElementById('modalHistorialClinico'));
    
    // Inicializar tabla principal
    var tablaPrincipal = $('#tablaHistorialPrincipal').DataTable({
        responsive: true,
        processing: true,
        serverSide: true, // Cambiar a true para usar AJAX
        ajax: {
            url: "{{ route('historial_clinico') }}",
            type: "GET",
            dataType: 'json',
            error: function(xhr, error, thrown) {
                console.error('Error al cargar datos:', xhr.responseText);
                console.error('Status:', xhr.status);
                console.error('Error:', error);
                console.error('Thrown:', thrown);
                
                // Mostrar mensaje de error más específico
                let errorMsg = 'Error al cargar los datos.';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg += ' ' + xhr.responseJSON.error;
                }
                alert(errorMsg + ' Por favor recarga la página.');
            }
        },
        columns: [
            { data: 'id_cita', className: 'text-center' },
            { data: 'numero_registro_asignado', className: 'text-center' },
            { data: 'nombre_completo' },
            {
                data: null,
                className: 'text-center',
                orderable: false,
                render: function(data, type, row) {
                    return `<button class="btn btn-sm btn-success btnVerHistorial"
                                data-id-cita="${row.id_cita}"
                                data-num-registro="${row.numero_registro_asignado}"
                                title="Ver Historial">
                                <i class="fas fa-eye"></i> Ver
                            </button>`;
                }
            }
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
        },
        lengthMenu: [5, 10, 25, 50],
        pageLength: 10,
        order: [[2, 'asc']],
        initComplete: function() {
            console.log('Tabla inicializada correctamente');
        }
    });

    // Evento clic botón Ver del paciente para abrir modal y cargar historial
    $('#tablaHistorialPrincipal tbody').on('click', '.btnVerHistorial', function() {
        var numRegistro = $(this).data('num-registro');
        modalHistorial.show();
        cargarHistorialClinico(numRegistro);
    });

    async function cargarHistorialClinico(numeroRegistro) {
        const loadingHistorial = $('#loadingHistorial');
        const contenidoHistorial = $('#contenidoHistorial');
        const tbody = $('#cuerpoTablaHistorial');
        
        loadingHistorial.show();
        contenidoHistorial.hide();
        tbody.html('');

        try {
            let response = await fetch(`/psicologia/historial/${numeroRegistro}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if (!response.ok) throw new Error('Error en la respuesta del servidor');
            
            let data = await response.json();
            
            if (data.estatus !== true) throw new Error(data.mensaje || 'No se pudo obtener el historial');

            // Destruir DataTable existente si existe
            if ($.fn.DataTable.isDataTable('#tablaHistorial')) {
                $('#tablaHistorial').DataTable().clear().destroy();
            }

            if (data.historial && data.historial.length > 0) {
                let filas = '';
                data.historial.forEach(registro => {
                    filas += `
                        <tr>
                            <td class="text-center">${registro.id_cita || 'N/A'}</td>
                            <td class="text-center">${registro.numero_registro_cita || 'N/A'}</td>
                            <td class="text-center">${registro.numero_registro_asignado || 'N/A'}</td>
                            <td>${registro.nombre_estudiante || 'N/A'}</td>
                            <td>${registro.nombre_profesional || 'No asignado'}</td>
                            <td class="text-center">${registro.fecha_evaluacion ? new Date(registro.fecha_evaluacion).toLocaleDateString() : 'N/A'}</td>
                            <td class="text-center">
                                <button class="btn btn-outline-success btn-sm" 
                                        onclick="verDetalleCita(${registro.id_cita})" 
                                        title="Ver detalle de la cita">
                                    Ver
                                </button>
                            </td>
                        </tr>`;
                });
                tbody.html(filas);
            } else {
                tbody.html(`
                    <tr>
                        <td colspan="7" class="text-center text-muted py-3">
                            <i class="fas fa-info-circle fs-3 text-success mb-2"></i><br>
                            No se encontraron registros
                        </td>
                    </tr>`);
            }

            // Inicializar DataTable del modal
            $('#tablaHistorial').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
                },
                responsive: true,
                lengthMenu: [[5, 10, 25, -1], [5, 10, 25, "Todos"]],
                pageLength: 10,
                order: [[5, 'desc']],
                columnDefs: [
                    { orderable: false, targets: 6 },
                    { width: "8%", targets: 0 },
                    { width: "12%", targets: 1 },
                    { width: "12%", targets: 2 },
                    { width: "25%", targets: 3 },
                    { width: "20%", targets: 4 },
                    { width: "13%", targets: 5 },
                    { width: "10%", targets: 6 }
                ],
                destroy: true
            });

            loadingHistorial.hide();
            contenidoHistorial.show();

        } catch (error) {
            loadingHistorial.hide();
            contenidoHistorial.show();
            alert('Error al cargar historial: ' + error.message);
            console.error(error);
        }
    }

    // Función global para redirigir a detalle cita
    window.verDetalleCita = function(idCita) {
        if (!idCita) {
            alert('ID de cita inválido');
            return;
        }
        window.location.href = `/psicologia/estudiante-historial/${idCita}/2`;
    }
});
</script>
@endpush
Made with
