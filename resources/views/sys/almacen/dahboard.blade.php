@extends('layout.master')

@section('content')
<!-- Sección de resumen de citas -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Resumen de Citas</h5>
                    <button id="btnActualizarResumen" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-sync-alt"></i> Actualizar
                    </button>
                </div>
                
                <div class="row g-3" id="resumenCitasContainer">
                    <!-- Tarjetas generadas dinámicamente -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Título y card de gestión de citas -->
<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-3">Calendario de Citas</h2>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Gestión de Citas</h5>
                    @if(in_array('clinica_psicologica_escribir_calendario_citas', $scopes))
                        <button class="btn btn-primary" id="btnNuevaCita">
                            <i class="fas fa-plus me-2"></i>Nueva Cita
                        </button>
                    @endif
                </div>
                <p class="card-text mt-2">Aquí puedes visualizar y gestionar todas las citas programadas.</p>
            </div>
        </div>
    </div>
</div>

<!-- Calendario principal -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body p-0" style="min-height: 700px;">
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de crear/agendar cita -->
<div id="crearCitaModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                 @if(in_array('clinica_psicologica_escribir_calendario_citas', $scopes))
                <h5 class="modal-title">Agendar Nueva Cita</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                 @endif
            </div>
            <div class="modal-body">
                <form id="formCrearCita" novalidate>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Número Cita</label>
                            <input type="text" class="form-control" id="numeroRegistroCita" readonly 
                                   placeholder="Se generará al guardar" style="background-color: #f8f9fa;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Estudiante</label>
                            <select class="form-control select2-estudiante" id="selectEstudiante" 
                                    name="numero_registro_asignado" required style="width: 100%;">
                                <option value="">Seleccione un estudiante</option>
                                @foreach($pacientes ?? [] as $paciente)
                                    <option value="{{ $paciente['numero_registro_asignado'] }}">
                                        {{ $paciente['numero_registro_asignado'] }} - {{ $paciente['nombre_completo'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Buscar Empleado</label>
                                <select class="form-control select2-profesional" id="selectEmpleado" name="id_empleado" required>
                                    <option value="">Seleccione un Empleado</option>
                                    @foreach($empleados ?? [] as $empleado)
                                        <option value="{{ $empleado['id_empleado'] }}">
                                            {{ $empleado['nombre_completo'] }}
                                        </option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="fechaCita" name="fecha_cita" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Hora</label>
                            <input type="time" class="form-control" id="horaCita" name="hora_cita" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tipo de Cita</label>
                            <select class="form-select" id="tipoCita" name="id_tipo" required>
                                <option value="">Seleccione tipo</option>
                                @foreach($tipos_cita ?? [] as $tipo)
                                    <option value="{{ $tipo['id'] }}">{{ $tipo['nombre'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observacionesCita" name="observaciones" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                 @if(in_array('clinica_psicologica_escribir_calendario_citas', $scopes))
                <button type="button" class="btn btn-primary" id="btnGuardarCita">Guardar</button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal de posponer cita -->
<div class="modal fade" id="posponerCitaModal" tabindex="-1" aria-labelledby="posponerCitaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="posponerCitaModalLabel">Posponer la cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formPosponerCita">
                    <div class="mb-3">
                        <label for="fechaPosponer" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="fechaPosponer" required 
                               min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <label for="horaPosponer" class="form-label">Hora</label>
                        <input type="time" class="form-control" id="horaPosponer" required
                               min="08:00" max="15:00">
                    </div>
                    <div class="mb-3">
                        <label for="estudiantePosponer" class="form-label">Estudiante</label>
                        <input type="text" class="form-control" id="estudiantePosponer" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-warning" id="btnConfirmarPosponer">Posponer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de gestión de cita -->
<div id="gestionarCitaModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white">Gestión de Cita</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <h6>Estudiante:</h6>
                    <p id="citaEstudiante">-</p>
                </div>
                <div class="mb-3">
                    <h6>Empleado:</h6>
                    <p id="citaEmpleado">-</p>
                </div>
                <div class="mb-3">
                    <h6>Fecha y Hora:</h6>
                    <p id="citaFechaHora">-</p>
                </div>
                <div class="mb-3">
                    <h6>Tipo:</h6>
                    <p id="citaTipo">-</p>
                </div>
                <div class="mb-3">
                    <h6>Estado:</h6>
                    <span class="badge bg-primary" id="citaEstado">Programada</span>
                </div>
                <div class="mb-3">
                    <h6>Observaciones:</h6>
                    <p id="citaObservaciones">-</p>
                </div>
            </div>
            <div class="modal-footer">
                 @if(in_array('clinica_psicologica_escribir_calendario_citas', $scopes))
                <button type="button" class="btn btn-success" id="btnAtenderCita">Atender</button>
                <button type="button" class="btn btn-warning" id="btnPosponerCita">Posponer</button>
                <button type="button" class="btn btn-danger" id="btnCancelarCita">Cancelar Cita</button>
                    @endif
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


@endsection

@push('plugin-styles')
<link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/fullcalendar/index.global.min.js') }}"></script>
<script src="{{ asset('assets/plugins/fullcalendar/locales/es.global.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@push('custom-scripts')
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Variables globales
        let calendar = null;
        let citaSeleccionada = null;
        let todasLasCitas = [];

        // Inicializar Select2
        $(".select2-estudiante, .select2-profesional").select2({
            placeholder: "Seleccione una opción",
            allowClear: true,
            dropdownParent: $("#crearCitaModal"),
            width: "100%",
        });

        // Configuración de las tarjetas del resumen (actualizada)
        const resumenConfig = [
            { 
                id: "totalCitas", 
                title: "Total Citas", 
                color: "primary", 
                icon: "fa-calendar-alt",
                key: "totalcitas" 
            },
            { 
                id: "citasCompletadas", 
                title: "Completadas", 
                color: "success", 
                icon: "fa-check-circle",
                key: "citascompletadas" 
            },
            { 
                id: "citasProgramadas", 
                title: "Programadas", 
                color: "warning", 
                icon: "fa-clock",
                key: "citasprogramadas" 
            },
            { 
                id: "citasCanceladas", 
                title: "Canceladas", 
                color: "danger", 
                icon: "fa-times-circle",
                key: "citascanceladas" 
            },
            { 
                id: "citasPospuestas", 
                title: "Pospuestas", 
                color: "info", 
                icon: "fa-calendar-plus",
                key: "citaspospuestas" 
            },
        ];

        // Función para renderizar las tarjetas del resumen (mejorada)
        function renderizarResumen() {
            const container = $("#resumenCitasContainer");
            container.empty();
            
            resumenConfig.forEach((item) => {
                container.append(`
                    <div class="col-xl-3 col-md-6 col-12 mb-3">
                        <div class="card bg-${item.color} text-white h-100 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title mb-1 text-white">${item.title}</h6>
                                        <h3 class="card-text mb-0 fw-bold text-white" id="${item.id}">
                                            <i class="fas fa-spinner fa-spin text-white"></i>
                                        </h3>
                                    </div>
                                    <div>
                                        <i class="fas ${item.icon} fa-2x text-white"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <small class="text-white">
                                    <i class="fas fa-clock me-1"></i>
                                    <span id="timestamp-${item.id}">Cargando...</span>
                                </small>
                            </div>
                        </div>
                    </div>
                `);
            });
        }

        // Inicializar el calendario con funcionalidad de arrastrar
        function initCalendar() {
            const calendarEl = document.getElementById("calendar");
            if (!calendarEl) {
                console.error("Elemento #calendar no encontrado");
                return;
            }

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: "dayGridMonth",
                locale: "es",
                headerToolbar: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek,timeGridDay",
                },
                editable: true, // Habilitar arrastrar y soltar
                selectable: true,
                dateClick: function (info) {
                    abrirModalNuevaCita(info.dateStr);
                },
                
                events: function (fetchInfo, successCallback, failureCallback) {
                    obtenerCitas(successCallback, failureCallback);
                },
                eventClick: function (info) {
                    citaSeleccionada = info.event;
                    mostrarDetallesCita(info.event);
                },
                eventDrop: async function (info) {
                    await manejarArrastreCita(info);
                },
                eventDidMount: function (info) {
    console.log("Evento montado:", info.event.title);
    // NO cambiar colores de la cita, mantener colores originales por estado
    
    // Tooltip nativo con fondo verde
    const tooltip = `Estudiante: ${info.event.extendedProps.estudiante || 'N/A'}
Empleado: ${info.event.extendedProps.empleado || 'N/A'}
Tipo: ${info.event.extendedProps.tipo || 'N/A'}
Estado: ${info.event.extendedProps.estado || 'N/A'}`;
    
    info.el.setAttribute('title', tooltip);
    
    // Aplicar estilo CSS al tooltip (fondo verde)
    info.el.setAttribute('data-tooltip-style', 'green-bg');
},
                eventTimeFormat: {
                    hour: "2-digit",
                    minute: "2-digit",
                    hour12: true,
                },
                loading: function(bool) {
                    console.log(bool ? 'Cargando eventos...' : 'Carga completada');
                }
            });

            calendar.render();
            actualizarResumenCitas();
        }

        // Función para manejar el arrastre de citas
        async function manejarArrastreCita(info) {
            const $btn = $(info.el).find('.fc-event-main');
            const originalContent = $btn.html();
            $btn.html('<i class="fas fa-spinner fa-spin"></i>');

            try {
                const evento = info.event;
                const nuevaFecha = moment(evento.start).format('YYYY-MM-DD');
                const nuevaHora = moment(evento.start).format('HH:mm');
                
                // Validación básica de fecha futura en el cliente
                if (moment(`${nuevaFecha} ${nuevaHora}`).isSameOrBefore(moment())) {
                    info.revert();
                    await Swal.fire({
                        icon: 'error',
                        title: 'Fecha inválida',
                        text: 'No puede mover una cita a una fecha pasada',
                    });
                    return;
                }

                // Mostrar modal de confirmación
                const { isConfirmed } = await Swal.fire({
                    title: 'Posponer cita',
                    html: `¿Desea posponer la cita a <strong>${moment(evento.start).format('DD/MM/YYYY HH:mm')}</strong>?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#f39c12',
                    confirmButtonText: 'Sí, posponer',
                    cancelButtonText: 'Cancelar'
                });

                if (isConfirmed) {
                    // Actualizar usando la nueva función del backend
                    const success = await actualizarEstadoCita(
                        evento.id,
                        4, // Estado para pospuesta
                        `${nuevaFecha}T${nuevaHora}`
                    );
                    
                    if (!success) {
                        info.revert();
                    }
                } else {
                    info.revert();
                }
            } catch (error) {
                console.error('Error al manejar arrastre:', error);
                info.revert();
                Swal.fire('Error', 'Ocurrió un error al posponer la cita', 'error');
            } finally {
                $btn.html(originalContent);
            }
        }



        // Función para abrir modal de nueva cita
        function abrirModalNuevaCita(fecha) {
            resetFormCita();
            $("#fechaCita").val(fecha).attr('min', new Date().toISOString().split('T')[0]);
            $("#crearCitaModal").modal("show");
        }

        // Obtener citas del servidor
        async function obtenerCitas(successCallback, failureCallback) {
            try {
                const response = await $.ajax({
                    url: '{{ route("obtener_citas") }}',
                    method: "GET",
                    dataType: "json",
                });

                if (!response || response.estatus !== true) {
                    throw new Error(response?.mensaje || "Error en la respuesta del servidor");
                }

                if (!response.citas || !Array.isArray(response.citas)) {
                    throw new Error("Datos de citas no válidos");
                }

                todasLasCitas = response.citas;

                const events = response.citas.map((cita) => {
                    if (!cita.fecha_cita || !cita.hora_cita) {
                        console.warn('Cita sin fecha/hora válida:', cita);
                        return null;
                    }

                    const fechaHora = moment(`${cita.fecha_cita} ${cita.hora_cita}`, "YYYY-MM-DD HH:mm:ss");
                    
                    if (!fechaHora.isValid()) {
                        console.warn('Fecha inválida para cita:', cita);
                        return null;
                    }

                    return {
                        id: cita.id_cita,
                        title: cita.nombre_estudiante || "Cita sin nombre",
                        start: fechaHora.toISOString(),
                        extendedProps: {
                            estudiante: cita.nombre_estudiante,
                            empleado: cita.nombre_empleado,
                            tipo: cita.tipo_cita,
                            estado: cita.estado_cita,
                            observaciones: cita.observaciones,
                            numero_registro_cita: cita.numero_registro_cita,
                            numero_registro_asignado: cita.numero_registro_asignado,
                            id_empleado: cita.id_empleado,
                            id_tipo: cita.id_tipo,
                        },
                        backgroundColor: getColorByStatus(cita.estado_cita),
                        borderColor: getColorByStatus(cita.estado_cita),
                        textColor: "#ffffff",
                    };
                }).filter(event => event !== null);

                successCallback(events);
                actualizarResumenCitas(events);

            } catch (error) {
                console.error("Error al obtener citas:", error);
                mostrarErrorCargaCitas();
                if (typeof failureCallback === "function") {
                    failureCallback(error);
                }
            }
        }

        // Función para mostrar error al cargar citas
        function mostrarErrorCargaCitas() {
            const errorContainer = document.createElement('div');
            errorContainer.className = 'alert alert-danger m-3';
            errorContainer.innerHTML = `
                <i class="fas fa-exclamation-triangle me-2"></i>
                No se pudieron cargar las citas. Por favor intente recargar la página.
            `;
            
            const calendarEl = document.getElementById('calendar');
            if (calendarEl) {
                calendarEl.appendChild(errorContainer);
            }
        }

        // Función para obtener color según estado
        function getColorByStatus(estado) {
            if (!estado) return "#7f8c8d";
            
            switch (estado.toLowerCase()) {
                case "programada": return "#f39c12"; //"#f39c12"; //"#3498db";
                case "completada": return "#2ecc71";
                case "cancelada": return "#e74c3c";
                case "pospuesta": return "#3498db";
                default: return "#7f8c8d";
            }
        }

        // Función para resetear el formulario
        function resetFormCita() {
            $("#formCrearCita")[0].reset();
            $("#numeroRegistroCita").val("");
            $(".select2-estudiante, .select2-profesional").val(null).trigger("change");
            $(".form-control, .form-select").removeClass("is-invalid is-valid");
            $(".invalid-feedback").remove();
        }

        // Función para guardar cita
        $("#btnGuardarCita").click(async function () {
            const $btn = $(this);
            const textoOriginal = $btn.html();
            $btn.prop("disabled", true).html(
                '<span class="spinner-border spinner-border-sm"></span> Guardando...'
            );

            try {
                // Validar campos (código existente)
                const errors = [];
                const campos = {
                    Estudiante: $("#selectEstudiante").val(),
                    Empleado: $("#selectEmpleado").val(),
                    Fecha: $("#fechaCita").val(),
                    Hora: $("#horaCita").val(),
                    "Tipo de cita": $("#tipoCita").val(),
                };

                $(".is-invalid").removeClass("is-invalid");
                
                Object.entries(campos).forEach(([nombre, valor]) => {
                    if (!valor) {
                        errors.push(nombre);
                        const fieldId = nombre.replace(/ /g, "").toLowerCase();
                        const mappings = {
                            'estudiante': 'selectEstudiante',
                            'empleado': 'selectEmpleado',
                            'fecha': 'fechaCita',
                            'hora': 'horaCita',
                            'tipodecita': 'tipoCita'
                        };
                        $(`#${mappings[fieldId] || fieldId}`).addClass("is-invalid");
                    }
                });

                if (errors.length > 0) {
                    const errorMsg = `Los siguientes campos son requeridos: ${errors.join(", ")}`;
                    await Swal.fire("Error", errorMsg, "error");
                    return;
                }

                // Construir datos y enviar (sin verificación de disponibilidad)
                const formData = {
                    numero_registro_asignado: campos["Estudiante"],
                    id_empleado: campos["Empleado"],
                    fecha_cita: campos["Fecha"],
                    hora_cita: campos["Hora"],
                    id_tipo: campos["Tipo de cita"],
                    observaciones: $("#observacionesCita").val(),
                    _token: "{{ csrf_token() }}",
                };

                const response = await $.ajax({
                    url: '{{ route("guardar_cita") }}',
                    method: "POST",
                    data: formData,
                    dataType: "json",
                });

                if (response.estatus === true) {
                    await Swal.fire({
                        title: "¡Cita agendada exitosamente!",
                        html: `Número de Cita: <strong>${response.numero_registro_cita}</strong>`,
                        icon: "success",
                    });
                    calendar.refetchEvents();
                    $("#crearCitaModal").modal("hide");
                    resetFormCita();
                } else {
                    await Swal.fire({
                        icon: "error",
                        title: "Error al guardar la cita",
                        text: response.mensaje || response.msgError || "Error desconocido",
                    });
                }
            } catch (error) {
                // Manejo de errores (código existente)
                console.error("Error completo:", error);
                let errorMessage = "Error desconocido";
                
                if (error.responseJSON) {
                    if (error.responseJSON.estatus === false) {
                        errorMessage = error.responseJSON.mensaje || 
                                    error.responseJSON.msgError || 
                                    "Error en el servidor";
                    } else if (error.responseJSON.message) {
                        errorMessage = error.responseJSON.message;
                    }
                } else if (error.responseText) {
                    try {
                        const parsed = JSON.parse(error.responseText);
                        errorMessage = parsed.mensaje || 
                                    parsed.msgError || 
                                    parsed.message || 
                                    "Error en el servidor";
                    } catch (e) {
                        errorMessage = "Error en el servidor";
                    }
                } else if (error.message) {
                    errorMessage = error.message;
                }

                await Swal.fire({
                    icon: "error",
                    title: "Error al guardar la cita",
                    text: errorMessage,
                });
            } finally {
                $btn.prop("disabled", false).html(textoOriginal);
            }
        });

        // Mostrar detalles de cita en modal
        function mostrarDetallesCita(evento) {
            const props = evento.extendedProps;
            const fechaHora = evento.start
                ? new Date(evento.start).toLocaleString("es-ES", {
                    weekday: "long",
                    year: "numeric",
                    month: "long",
                    day: "numeric",
                    hour: "2-digit",
                    minute: "2-digit",
                })
                : "-";

            $("#citaEstudiante").text(props.estudiante || "-");
            $("#citaEmpleado").text(props.empleado || "-");
            $("#citaFechaHora").text(fechaHora);
            $("#citaTipo").text(props.tipo || "-");
            $("#citaObservaciones").text(props.observaciones || "Ninguna");

            const estadoBadge = $("#citaEstado");
            estadoBadge.removeClass().addClass("badge");

            if (props.estado.toLowerCase() === "programada") {
                estadoBadge.addClass("bg-primary").text("Programada");
                $("#btnAtenderCita, #btnPosponerCita, #btnCancelarCita").show();
            } else if (props.estado.toLowerCase() === "completada") {
                estadoBadge.addClass("bg-success").text("Completada");
                $("#btnAtenderCita, #btnPosponerCita, #btnCancelarCita").hide();
            } else if (props.estado.toLowerCase() === "cancelada") {
                estadoBadge.addClass("bg-danger").text("Cancelada");
                $("#btnAtenderCita, #btnPosponerCita, #btnCancelarCita").hide();
            } else if (props.estado.toLowerCase() === "pospuesta") {
                estadoBadge.addClass("bg-info").text("Pospuesta");
                $("#btnAtenderCita, #btnPosponerCita, #btnCancelarCita").show();
            }
         @if(in_array('clinica_psicologica_escribir_calendario_citas', $scopes))
            $("#gestionarCitaModal").modal("show");
            @endif
        }

        // Función para actualizar resumen de citas (mejorada)
        async function actualizarResumenCitas() {
            try {
                // Mostrar indicador de carga
                resumenConfig.forEach((item) => {
                    $(`#${item.id}`).html('<i class="fas fa-spinner fa-spin"></i>');
                });

                const response = await $.ajax({
                    url: '{{ route("estadisticas_citas") }}',
                    method: 'GET',
                    dataType: 'json'
                });

                if (response.estatus && response.estadisticas) {
                    const stats = response.estadisticas;
                    
                    // Actualizar cada tarjeta con animación
                    resumenConfig.forEach((item) => {
                        const valor = stats[item.key] || 0;
                        animarCambioValor(`#${item.id}`, valor);
                    });

                    // Actualizar tooltips
                    actualizarTooltipsResumen();
                    
                    console.log('Estadísticas actualizadas:', stats);
                } else {
                    throw new Error(response.mensaje || 'Error en la respuesta');
                }
            } catch (error) {
                console.error("Error al actualizar resumen:", error);
                
                // Mostrar error en las tarjetas
                resumenConfig.forEach((item) => {
                    $(`#${item.id}`).html('<i class="fas fa-exclamation-triangle text-danger"></i>');
                });
                
                // Mostrar notificación de error (opcional)
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudieron cargar las estadísticas',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            }
        }

        // Función para animar cambio de valor 
        function animarCambioValor(elemento, nuevoValor) {
            const $elemento = $(elemento);
            const valorActual = parseInt($elemento.text()) || 0;
            
            // Si el valor no ha cambiado, solo actualizar sin animación
            if (valorActual === nuevoValor) {
                $elemento.text(nuevoValor);
                return;
            }
            
            // Animación de contador
            $({ count: valorActual }).animate(
                { count: nuevoValor },
                {
                    duration: 800,
                    easing: 'swing',
                    step: function () {
                        $elemento.text(Math.floor(this.count));
                    },
                    complete: function() {
                        $elemento.text(nuevoValor);
                        
                        // Efecto de pulso para valores que cambiaron
                        if (valorActual !== nuevoValor) {
                            $elemento.closest('.card').addClass('border-light');
                            setTimeout(() => {
                                $elemento.closest('.card').removeClass('border-light');
                            }, 1000);
                        }
                    }
                }
            );
        }

        // Función para actualizar tooltips con timestamp
        function actualizarTooltipsResumen() {
            const timestamp = new Date().toLocaleString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            resumenConfig.forEach((item) => {
               $(`#timestamp-${item.id}`).text(`Actualizado: ${timestamp}`).addClass('text-white');
                $(`#${item.id}`).closest('.card').attr('title', `Última actualización: ${timestamp}`);
            });
        }

        // Llamar al renderizado inicial
        renderizarResumen();

        // Actualización manual
        $("#btnActualizarResumen").click(async function () {
            const $btn = $(this);
            $btn.prop("disabled", true).html(
                '<i class="fas fa-spinner fa-spin"></i> Actualizando'
            );

            try {
                await calendar.refetchEvents();
            } finally {
                setTimeout(() => {
                    $btn.prop("disabled", false).html(
                        '<i class="fas fa-sync-alt"></i> Actualizar'
                    );
                }, 1000);
            }
        });

        // Actualización periódica
        let intervaloResumen = setInterval(actualizarResumenCitas, 300000);

        // Limpiar intervalo
        $(window).on("beforeunload", function () {
            clearInterval(intervaloResumen);
        });

        // Modificar el evento click del botón Atender Cita
        $("#btnAtenderCita").click(function () {
            if (!citaSeleccionada) {
                Swal.fire('Error', 'No se ha seleccionado ninguna cita', 'error');
                return;
            }

            const idCita = citaSeleccionada.id;
            const nombreEstudiante = citaSeleccionada.extendedProps.estudiante;

            Swal.fire({
                title: '¿Iniciar evaluación del paciente?',
                html: `Se abrirá el formulario de evaluación para el estudiante:<br><strong>${nombreEstudiante}</strong>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, iniciar evaluación',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                @if(in_array('clinica_psicologica_escribir_calendario_citas', $scopes))
                    $("#gestionarCitaModal").modal("hide");
                    @endif
                    // Redirigir usando id_cita
                    const urlEvaluacion = `/psicologia/intervencion/${idCita}`;
                    window.location.href = urlEvaluacion;
                }
            });
        });

        // Función para abrir modal de atender cita
        function abrirModalAtenderCita(evento) {
            if (!evento) return;

            const props = evento.extendedProps;
            $("#intervencionNumeroCita").val(props.numero_registro_cita || "-");
            $("#intervencionEstudiante").val(props.estudiante || "-");

            cargarCatalogosIntervencion();
            $("#atenderCitaModal").modal("show");
        }

        // Función para cargar catálogos de intervención
        function cargarCatalogosIntervencion() {
            $.ajax({
                url: '{{ route("obtener_catalogos_intervencion") }}',
                method: "GET",
                success: function (response) {
                    if (response.estatus && response.catalogos) {
                        // Llenar objetivos
                        const objetivosContainer = $("#objetivosContainer");
                        objetivosContainer.empty();
                        response.catalogos.objetivos.forEach((objetivo) => {
                            objetivosContainer.append(`
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="objetivos[]" 
                                        id="objetivo_${objetivo.id_objetivos_terapeuticos}" 
                                        value="${objetivo.id_objetivos_terapeuticos}">
                                    <label class="form-check-label" for="objetivo_${objetivo.id_objetivos_terapeuticos}">
                                        ${objetivo.descripcion_objetivos_terapeuticos}
                                    </label>
                                </div>
                            `);
                        });

                        // Llenar estrategias
                        const estrategiasContainer = $("#estrategiasContainer");
                        estrategiasContainer.empty();
                        response.catalogos.estrategias.forEach((estrategia) => {
                            estrategiasContainer.append(`
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="estrategias[]" 
                                        id="estrategia_${estrategia.id_estrategias_intervencion}" 
                                        value="${estrategia.id_estrategias_intervencion}">
                                    <label class="form-check-label" for="estrategia_${estrategia.id_estrategias_intervencion}">
                                        ${estrategia.descripcion_estrategias_intervencion}
                                    </label>
                                </div>
                            `);
                        });

                        // Llenar frecuencias
                        const frecuenciasContainer = $("#frecuenciasContainer");
                        frecuenciasContainer.empty();
                        response.catalogos.frecuencias.forEach((frecuencia) => {
                            frecuenciasContainer.append(`
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="frecuencias[]" 
                                        id="frecuencia_${frecuencia.id_frecuencia_sesiones}" 
                                        value="${frecuencia.id_frecuencia_sesiones}">
                                    <label class="form-check-label" for="frecuencia_${frecuencia.id_frecuencia_sesiones}">
                                        ${frecuencia.descripcion_frecuencia_sesiones}
                                    </label>
                                </div>
                            `);
                        });

                        // Llenar terapias
                        const terapiasContainer = $("#terapiasContainer");
                        terapiasContainer.empty();
                        response.catalogos.terapias.forEach((terapia) => {
                            terapiasContainer.append(`
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="terapias[]" 
                                        id="terapia_${terapia.id_tipos_terapias}" 
                                        value="${terapia.id_tipos_terapias}">
                                    <label class="form-check-label" for="terapia_${terapia.id_tipos_terapias}">
                                        ${terapia.descripcion_tipos_terapias}
                                    </label>
                                </div>
                            `);
                        });
                    } else {
                        Swal.fire(
                            "Error",
                            "No se pudieron cargar los catálogos",
                            "error"
                        );
                    }
                },
                error: function () {
                    Swal.fire("Error", "Error al cargar los catálogos", "error");
                },
            });
        }

    
        // Modificar el evento click del botón Posponer Cita
    $("#btnPosponerCita").click(function () {
        if (!citaSeleccionada) return;

        const fechaHora = moment(citaSeleccionada.start);
        
        // Mostrar datos actuales
        $("#estudiantePosponer").val(citaSeleccionada.extendedProps.estudiante);
        
        // Establecer valores por defecto (30 mins después)
        const nuevaFechaHora = moment(fechaHora).add(30, 'minutes');
        $("#fechaPosponer").val(nuevaFechaHora.format("YYYY-MM-DD"));
        $("#horaPosponer").val(nuevaFechaHora.format("HH:mm"));

        // Establecer límites de fecha/hora
        $("#fechaPosponer").attr('min', moment().format('YYYY-MM-DD'));
        $("#horaPosponer").attr({
            'min': '08:00',
            'max': '15:00'
        });
         @if(in_array('clinica_psicologica_escribir_calendario_citas', $scopes))
        $("#gestionarCitaModal").modal("hide");
        $("#posponerCitaModal").modal("show");
        @endif
    });

    // Modificar el evento click del botón Cancelar Cita
    $("#btnCancelarCita").click(function () {
        if (!citaSeleccionada) return;
        
        Swal.fire({
            title: "¿Cancelar cita?",
            text: "Esta acción no se puede deshacer",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sí, cancelar",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                cancelarCita(citaSeleccionada.id);
            }
        });
    });

    // ========== NUEVA FUNCIÓN PARA CANCELAR CITA ==========
    
    async function cancelarCita(idCita) {
        try {
            const response = await $.ajax({
                url: `/psicologia/citas/${idCita}/cancelar`,
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (response.estatus) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Cita cancelada',
                    text: response.mensaje || 'La cita ha sido cancelada exitosamente'
                });
                
                // Cerrar modal y refrescar calendario
                 @if(in_array('clinica_psicologica_escribir_calendario_citas', $scopes))
                $("#gestionarCitaModal").modal("hide");
                @endif
                calendar.refetchEvents();
                
            } else {
                throw new Error(response.mensaje || 'Error al cancelar la cita');
            }
            
        } catch (error) {
            console.error('Error en cancelarCita:', error);
            
            let errorMessage = 'Error al cancelar la cita';
            if (error.responseJSON) {
                errorMessage = error.responseJSON.mensaje || 
                            error.responseJSON.msgError || 
                            errorMessage;
            } else if (error.message) {
                errorMessage = error.message;
            }
            
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage
            });
        }
    }

    // Función optimizada para actualizar estado
    async function actualizarEstadoCita(idCita, nuevoEstado, fechaHora = null) {
        try {
            let data = {
                _token: "{{ csrf_token() }}"
            };
            
            // Solo agregar fecha/hora si es para posponer (estado 4)
            if (nuevoEstado === 4 && fechaHora) {
                const [fecha, hora] = fechaHora.split('T');
                data.fecha_cita = fecha;
                data.hora_cita = hora.split(':').slice(0, 2).join(':'); // Asegurar formato HH:MM
            }

            data.nuevoEstado = nuevoEstado;
            
            const response = await $.ajax({
                url: `/psicologia/citas/${idCita}/estado`,
                method: "post",
                data: data,
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (response.estatus) {
                await Swal.fire({
                    icon: 'success',
                    title: 'Cita actualizada',
                    text: response.mensaje || 'Estado cambiado correctamente'
                });
                calendar.refetchEvents();
                return true;
            } else {
                throw new Error(response.mensaje || 'Error al actualizar');
            }
        } catch (error) {
            console.error('Error en actualizarEstadoCita:', error);
            let errorMessage = 'Error al actualizar la cita';
            
            if (error.responseJSON) {
                errorMessage = error.responseJSON.mensaje || error.responseJSON.msgError || errorMessage;
            } else if (error.message) {
                errorMessage = error.message;
            }
            
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage
            });
            return false;
        }
    }

    // Función mejorada para manejar posposición
    $("#btnConfirmarPosponer").click(async function() {
        const $btn = $(this);
        const originalText = $btn.html();
        $btn.prop("disabled", true).html('<i class="fas fa-spinner fa-spin"></i> Procesando...');

        try {
            const nuevaFecha = $("#fechaPosponer").val();
            const nuevaHora = $("#horaPosponer").val();

            // Validaciones básicas en el cliente
            if (!nuevaFecha || !nuevaHora) {
                throw new Error("Debe completar ambos campos: fecha y hora");
            }

            // Validar formato de fecha (YYYY-MM-DD)
            if (!/^\d{4}-\d{2}-\d{2}$/.test(nuevaFecha)) {
                throw new Error("Formato de fecha inválido. Use AAAA-MM-DD");
            }

            // Validar formato de hora (HH:MM)
            if (!/^\d{2}:\d{2}$/.test(nuevaHora)) {
                throw new Error("Formato de hora inválido. Use HH:MM");
            }

            // Validar que no sea en el pasado
            const ahora = new Date();
            const fechaHoraSeleccionada = new Date(`${nuevaFecha}T${nuevaHora}`);
            
            if (fechaHoraSeleccionada < ahora) {
                throw new Error("No puede posponer a una fecha/hora pasada");
            }

            // Confirmación final
            const { isConfirmed } = await Swal.fire({
                title: 'Confirmar posposición',
                html: `¿Desea posponer la cita para el ${moment(fechaHoraSeleccionada).format('DD/MM/YYYY [a las] HH:mm')}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f39c12',
                confirmButtonText: 'Sí, posponer',
                cancelButtonText: 'Cancelar'
            });

            if (!isConfirmed) {
                return;
            }

            // Llamar a la función de actualización
            const success = await actualizarEstadoCita(
                citaSeleccionada.id,
                4, // Estado para pospuesta
                `${nuevaFecha}T${nuevaHora}`
            );

            // Cerrar modal si todo fue exitoso
            if (success) {
                $("#posponerCitaModal").modal("hide");
            }
            
        } catch (error) {
            await Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message,
                timer: 3000
            });
        } finally {
            $btn.prop("disabled", false).html(originalText);
        }
    });

    // Función para obtener texto de acción
    function obtenerTextoAccion(estado) {
        switch(estado) {
            case 1: return 'programada';
            case 2: return 'completada';
            case 3: return 'cancelada';
            case 4: return 'pospuesta';
            default: return 'actualizada';
        }
    }

    function obtenerColorBoton(estado) {
        const colores = {
            1: "#3085d6",
            3: "#d33",
            4: "#f39c12",
        };
        return colores[estado] || "#3085d6";
    }

    function obtenerTextoBoton(estado) {
        const textos = {
            1: "Programar",
            3: "Sí, cancelar",
            4: "Posponer",
        };
        return textos[estado] || "Confirmar";
    }

    // Inicializar el calendario
    initCalendar();

    // Evento para abrir modal desde botón
    $("#btnNuevaCita").click(function () {
        abrirModalNuevaCita(new Date().toISOString().split("T")[0]);
    });
});
</script>
@endpush