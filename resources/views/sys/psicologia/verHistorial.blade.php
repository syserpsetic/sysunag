@extends('layout.master')
@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #28a745, #20c997);">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1 text-white">
                            <i class="fas fa-user-md me-2"></i>
                            Historial del Paciente
                        </h4>
                        <p class="mb-0 opacity-75 text-white">
                            <i class="fas fa-calendar me-1"></i>
                            Sistema de Psicología - UNAG
                        </p>
                    </div>
                    @if( $id_origen == 1 )
    <a href="{{ route('calendario_citas', ['id_cita' => $id_cita]) }}" class="btn btn-light btn-sm">
        <i class="fas fa-arrow-left me-1"></i>
        Regresar al calendario
    </a>
@elseif( $id_origen == 2 )
    <a href="javascript:history.back()" class="btn btn-light btn-sm">
        <i class="fas fa-arrow-left me-1"></i>
        Regresar
    </a>
@else
    <a href="{{ route('calendario_citas') }}" class="btn btn-light btn-sm">
        <i class="fas fa-arrow-left me-1"></i>
        Regresar al Calendario
    </a>
@endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Indicador de carga global -->
<div id="loadingIndicator" class="text-center py-5">
    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
        <span class="visually-hidden">Cargando...</span>
    </div>
    <p class="mt-3 text-muted h5">Cargando datos del historial del paciente...</p>
</div>

<!-- Contenido principal -->
<div id="historialContent" style="display: none;">
    <!-- Secciones del historial -->
    
    <div id="seccionDatosPaciente" style="display: none;">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                         <h5 class="mb-0" style="color: white !important;">
                            <i class="fas fa-user me-2"></i>
                            Datos del Paciente
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4" id="contenedorDatosPaciente"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="seccionMotivoConsulta" style="display: none;">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-info text-white">
                         <h5 class="mb-0" style="color: white !important;">
                            <i class="fas fa-clipboard-list me-2"></i>
                            Motivo de la Consulta
                        </h5>
                    </div>
                    <div class="card-body" id="motivoConsultaCard"></div>
                </div>
            </div>
        </div>
    </div>

     <div id="seccionHistorialClinico" style="display: none;">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0" style="color: white !important;">
                            <i class="fas fa-history me-2"></i>
                            Historial Clínico y Antecedentes
                        </h5>
                    </div>
                    <div class="card-body" id="historialClinicoCard"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="seccionEvaluacion" style="display: none;">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white">
                         <h5 class="mb-0" style="color: white !important;">
                            <i class="fas fa-brain me-2"></i>
                            Evaluación Psicológica
                        </h5>
                    </div>
                    <div class="card-body" id="evaluacionCard"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="seccionIntervencion" style="display: none;">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-secondary text-white">
                         <h5 class="mb-0" style="color: white !important;">
                            <i class="fas fa-tasks me-2"></i>
                            Plan de Intervención
                        </h5>
                    </div>
                    <div class="card-body" id="intervencionCard"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="seccionSeguimiento" style="display: none;">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white">
                         <h5 class="mb-0" style="color: white !important;">
                            <i class="fas fa-clipboard-check me-2"></i>
                            Seguimiento y Evolución
                        </h5>
                    </div>
                    <div class="card-body" id="seguimientoCard"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensaje cuando no hay datos -->
    <div id="sinDatosMensaje" class="text-center py-5" style="display: none;">
        <i class="fas fa-info-circle fa-3x text-muted mb-3"></i>
        <h4 class="text-muted">No se encontraron datos registrados para este paciente</h4>
        <p class="text-muted">El historial clínico no contiene información disponible.</p>
    </div>
</div>

<!-- SOLO EL ID DE CITA ES NECESARIO -->
<input type="hidden" id="idCita" value="{{ $id_cita }}">

@endsection

@push('custom-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const idCita = document.getElementById('idCita').value;
        
        // Validar que tenemos el ID de cita
        if (!idCita) {
            mostrarError('No se pudo obtener el ID de cita para cargar el historial');
            return;
        }
        
        // Primero obtenemos los datos completos incluyendo el número de registro
        obtenerDatosCompletos(idCita);
    });

    // Función mejorada para validar datos
    function esValido(valor) {
        if (valor === null || valor === undefined || valor === '') {
            return false;
        }
        if (typeof valor === 'string' && valor.trim() === '') {
            return false;
        }
        if (Array.isArray(valor) && valor.length === 0) {
            return false;
        }
        return true;
    }

    function obtenerDatosCompletos(idCita) 
    {
        console.log('=== INICIO OBTENER DATOS ===');
        console.log('ID Cita:', idCita);
        
        document.getElementById('loadingIndicator').style.display = 'block';
        
        $.ajax({
            url: `/psicologia/evaluacion/datos?id_cita=${idCita}`,
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            beforeSend: function(xhr) {
                console.log('=== ENVIANDO PETICIÓN ===');
                console.log('URL:', `/psicologia/evaluacion/datos?id_cita=${idCita}`);
                console.log('Headers:', {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                });
            },
            success: function(data) {
                console.log('=== RESPUESTA EXITOSA ===');
                console.log('Data completa:', data);
                console.log('Estatus:', data.estatus);
                console.log('Tipo de data:', typeof data.data);
                
                if (data.estatus && data.data) {
                    console.log('Procesando datos...');
                    procesarDatos(data.data);
                } else {
                    console.log('Error en datos:', data.mensaje || data.msgError);
                    mostrarError(data.mensaje || data.msgError || 'Datos no disponibles');
                }
            },
            error: function(xhr, status, error) {
                console.log('=== ERROR EN PETICIÓN ===');
                console.log('XHR Status:', xhr.status);
                console.log('XHR Ready State:', xhr.readyState);
                console.log('Status Text:', xhr.statusText);
                console.log('Error:', error);
                console.log('Response Text:', xhr.responseText);
                
                let errorMessage = 'Error al cargar el historial';
                
                try {
                    console.log('Intentando parsear responseText...');
                    const response = JSON.parse(xhr.responseText);
                    console.log('Response parseado:', response);
                    errorMessage = response.mensaje || response.msgError || response.message || errorMessage;
                } catch (e) {
                    console.log('No se pudo parsear responseText:', e);
                    if (xhr.status === 0) {
                        errorMessage = 'Error de conexión - Verifica tu conexión a internet';
                    } else if (xhr.status === 404) {
                        errorMessage = 'Endpoint no encontrado (404)';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Error interno del servidor (500)';
                    } else {
                        errorMessage = `Error ${xhr.status}: ${error}`;
                    }
                }
                
                console.log('Mensaje final de error:', errorMessage);
                mostrarError(errorMessage);
            },
            complete: function() {
                console.log('=== PETICIÓN COMPLETADA ===');
                document.getElementById('loadingIndicator').style.display = 'none';
            }
        });
    }

    function handleResponse(response) {
        if (!response.ok) {
            throw new Error(`Error del servidor: ${response.status}`);
        }
        return response.json();
    }

    function procesarDatos(datos) {
        let tieneDatos = false;

        // Procesar cada sección con validación mejorada
        if (procesarDatosPaciente(datos.datos_generales)) tieneDatos = true;
        if (procesarMotivoConsulta(datos.motivos_consulta)) tieneDatos = true;
        if (procesarHistorialClinico(datos.historial_clinico)) tieneDatos = true;
        if (procesarEvaluacion(datos.evaluaciones)) tieneDatos = true;
        if (procesarIntervencion(datos.intervenciones)) tieneDatos = true;
        if (procesarSeguimiento(datos.seguimientos)) tieneDatos = true;

        // Mostrar mensaje si no hay datos
        if (!tieneDatos) {
            document.getElementById('sinDatosMensaje').style.display = 'block';
        }

        document.getElementById('loadingIndicator').style.display = 'none';
        document.getElementById('historialContent').style.display = 'block';
    }

    function procesarDatosPaciente(datos) {
        if (!datos || !datos.estudiante) return false;

        const campos = {
            // Columna 1
            numero_registro: { icono: 'fas fa-id-card', label: 'Número de Registro', columna: 'izquierda' },
            nombre_completo: { icono: 'fas fa-user', label: 'Nombre Completo', columna: 'izquierda' },
            fecha_nacimiento: { icono: 'fas fa-calendar-alt', label: 'Fecha Nacimiento', columna: 'izquierda' },
            edad: { icono: 'fas fa-birthday-cake', label: 'Edad', columna: 'izquierda' },
            telefono: { icono: 'fas fa-phone', label: 'Teléfono', columna: 'izquierda' },
            sexo: { icono: 'fas fa-venus-mars', label: 'Sexo', columna: 'izquierda' },

            // Columna 2
            nombre_profesional: { icono: 'fas fa-user-md', label: 'Profesional a Cargo', externo: true, columna: 'derecha' },
            carrera: { icono: 'fas fa-graduation-cap', label: 'Carrera Universitaria', columna: 'derecha' },
            correo: { icono: 'fas fa-envelope', label: 'Correo Institucional', columna: 'derecha' },
            anio_academico: { icono: 'fas fa-calendar', label: 'Año Académico', columna: 'derecha' },
            edificio: { icono: 'fas fa-building', label: 'Edificio', columna: 'derecha' },
            aula: { icono: 'fas fa-door-open', label: 'Cuarto', columna: 'derecha' },
        };

        let htmlIzq = '';
        let htmlDer = '';
        let tieneDatos = false;

        for (const [key, config] of Object.entries(campos)) {
            let valor;

            if (config.externo) {
                valor = datos[key];
            } else {
                valor = datos.estudiante[key];
            }

            if (esValido(valor)) {
                const campoHtml = `
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted">
                            <i class="${config.icono} text-primary me-1"></i>
                            ${config.label}
                        </label>
                        <div class="p-2 bg-light rounded border">${valor}</div>
                    </div>`;

                if (config.columna === 'izquierda') {
                    htmlIzq += campoHtml;
                } else {
                    htmlDer += campoHtml;
                }

                tieneDatos = true;
            }
        }

        if (tieneDatos) {
            document.getElementById('contenedorDatosPaciente').innerHTML = `
                <div class="col-md-6">${htmlIzq}</div>
                <div class="col-md-6">${htmlDer}</div>`;
            document.getElementById('seccionDatosPaciente').style.display = 'block';
            return true;
        }

        return false;
    }

    function procesarMotivoConsulta(motivo) {
        if (!motivo || !esValido(motivo.descripcion)) return false;

        let html = `
            <div class="mb-3">
                <label class="form-label fw-bold text-muted">Descripción del Motivo:</label>
                <div class="p-3 bg-light rounded border">
                    ${motivo.descripcion}
                </div>
            </div>`;

        if (motivo.detalles && Array.isArray(motivo.detalles) && motivo.detalles.length > 0) {
            let detallesHtml = '<div class="row g-3 mt-3">';
            let tieneDetalles = false;

            motivo.detalles.forEach(detalle => {
                const campos = [];
                if (esValido(detalle.frecuencia_sintomas)) {
                    campos.push(`<div><strong>Frecuencia:</strong> ${detalle.frecuencia_sintomas}</div>`);
                }
                if (esValido(detalle.impacto_vida)) {
                    campos.push(`<div><strong>Impacto:</strong> ${detalle.impacto_vida}</div>`);
                }
                if (esValido(detalle.factor_desencadenante)) {
                    campos.push(`<div><strong>Factores:</strong> ${detalle.factor_desencadenante}</div>`);
                }

                if (campos.length > 0) {
                    detallesHtml += `
                        <div class="col-md-6">
                            <div class="border rounded p-3 bg-white">
                                ${campos.join('')}
                            </div>
                        </div>`;
                    tieneDetalles = true;
                }
            });

            detallesHtml += '</div>';
            if (tieneDetalles) html += detallesHtml;
        }

        document.getElementById('motivoConsultaCard').innerHTML = html;
        document.getElementById('seccionMotivoConsulta').style.display = 'block';
        return true;
    }

    function procesarHistorialClinico(historial) 
    {
        if (!historial || !esValido(historial.antecedentes_familiares)) return false;

        let html = `
            <div class="mb-3">
                <label class="form-label fw-bold text-muted">Antecedentes Familiares de Trastorno:</label>
                <div class="p-3 bg-light rounded border">
                    <span class="badge ${historial.antecedentes_familiares === 'Sí' ? 'bg-warning' : 'bg-success'}">
                        ${historial.antecedentes_familiares}
                    </span>
                </div>
            </div>`;

        if (historial.detalles && Array.isArray(historial.detalles) && historial.detalles.length > 0) {
            let detallesHtml = '<div class="row g-3 mt-3">';
            let tieneDetalles = false;

            historial.detalles.forEach(detalle => {
                const campos = [];
                if (esValido(detalle.antecedente_salud_mental)) {
                    campos.push(`<div><strong>Antecedente:</strong> ${detalle.antecedente_salud_mental}</div>`);
                }
                if (esValido(detalle.consumo_sustancias)) {
                    campos.push(`<div><strong>Consumo:</strong> ${detalle.consumo_sustancias}</div>`);
                }
                if (esValido(detalle.tipo_trastorno)) {
                    campos.push(`<div><strong>Trastorno:</strong> ${detalle.tipo_trastorno}</div>`);
                }

                if (campos.length > 0) {
                    detallesHtml += `
                        <div class="col-md-6">
                            <div class="border rounded p-3 bg-white">
                                ${campos.join('')}
                            </div>
                        </div>`;
                    tieneDetalles = true;
                }
            });

            detallesHtml += '</div>';
            if (tieneDetalles) html += detallesHtml;
        }

        document.getElementById('historialClinicoCard').innerHTML = html;
        document.getElementById('seccionHistorialClinico').style.display = 'block';
        return true;
    }

    function procesarEvaluacion(evaluacion) {
        if (!evaluacion) return false;
        
        let html = '<div class="row g-3">';
        let tieneDatos = false;

        if (esValido(evaluacion.resultados)) {
            html += `
                <div class="col-md-6">
                    <label class="form-label fw-bold text-muted">Resultados de Pruebas:</label>
                    <div class="p-3 bg-light rounded border">
                        ${evaluacion.resultados}
                    </div>
                </div>`;
            tieneDatos = true;
        }

        if (esValido(evaluacion.diagnostico)) {
            html += `
                <div class="col-md-6">
                    <label class="form-label fw-bold text-muted">Diagnóstico:</label>
                    <div class="p-3 bg-light rounded border">
                        ${evaluacion.diagnostico}
                    </div>
                </div>`;
            tieneDatos = true;
        }

        if (esValido(evaluacion.otros_criterios)) {
            html += `
                <div class="col-12">
                    <label class="form-label fw-bold text-muted">Otros Criterios:</label>
                    <div class="p-3 bg-light rounded border">
                        ${evaluacion.otros_criterios}
                    </div>
                </div>`;
            tieneDatos = true;
        }

        if (evaluacion.pruebas && Array.isArray(evaluacion.pruebas) && evaluacion.pruebas.length > 0) {
            let pruebasHtml = '<div class="col-12 mt-3"><label class="form-label fw-bold text-muted">Pruebas Aplicadas:</label><ul class="list-group">';
            let tienePruebas = false;

            evaluacion.pruebas.forEach(prueba => {
                if (esValido(prueba.prueba_psicologica)) {
                    pruebasHtml += `
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            ${prueba.prueba_psicologica}
                        </li>`;
                    tienePruebas = true;
                }
            });

            pruebasHtml += '</ul></div>';
            if (tienePruebas) html += pruebasHtml;
        }

        html += '</div>';

        if (tieneDatos) {
            document.getElementById('evaluacionCard').innerHTML = html;
            document.getElementById('seccionEvaluacion').style.display = 'block';
            return true;
        }
        return false;
    }

    function procesarIntervencion(intervencion) {
        if (!intervencion) return false;

        let html = '';
        let tieneDatos = false;

        if (esValido(intervencion.derivacion_servicios_salud)) {
            html += `
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted">Derivación a Servicios de Salud:</label>
                    <div class="p-3 bg-light rounded border">
                        <span class="badge ${intervencion.derivacion_servicios_salud === 'Sí' ? 'bg-success' : 'bg-secondary'}">
                            ${intervencion.derivacion_servicios_salud}
                        </span>
                    </div>
                </div>`;
            tieneDatos = true;
        }

        if (intervencion.detalles && Array.isArray(intervencion.detalles) && intervencion.detalles.length > 0) {
            let detallesHtml = '<div class="row g-3 mt-3">';
            let tieneDetalles = false;

            intervencion.detalles.forEach(detalle => {
                const campos = [];
                if (esValido(detalle.objetivo_terapeutico)) {
                    campos.push(`<div><strong>Objetivo:</strong> ${detalle.objetivo_terapeutico}</div>`);
                }
                if (esValido(detalle.estrategia_intervencion)) {
                    campos.push(`<div><strong>Estrategia:</strong> ${detalle.estrategia_intervencion}</div>`);
                }
                if (esValido(detalle.tipo_terapia)) {
                    campos.push(`<div><strong>Terapia:</strong> ${detalle.tipo_terapia}</div>`);
                }
                if (esValido(detalle.frecuencia_sesion)) {
                    campos.push(`<div><strong>Frecuencia:</strong> ${detalle.frecuencia_sesion}</div>`);
                }

                if (campos.length > 0) {
                    detallesHtml += `
                        <div class="col-md-6">
                            <div class="border rounded p-3 bg-white">
                                ${campos.join('')}
                            </div>
                        </div>`;
                    tieneDetalles = true;
                }
            });

            detallesHtml += '</div>';
            if (tieneDetalles) {
                html += detallesHtml;
                tieneDatos = true;
            }
        }

        if (tieneDatos) {
            document.getElementById('intervencionCard').innerHTML = html;
            document.getElementById('seccionIntervencion').style.display = 'block';
            return true;
        }
        return false;
    }

    function procesarSeguimiento(seguimiento) {
        if (!seguimiento) return false;

        let html = '';
        let tieneDatos = false;

        if (esValido(seguimiento.historial)) {
            html += `
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted">Historial:</label>
                    <div class="p-3 bg-light rounded border">
                        ${seguimiento.historial}
                    </div>
                </div>`;
            tieneDatos = true;
        }

        if (esValido(seguimiento.resultados)) {
            html += `
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted">Resultados Obtenidos:</label>
                    <div class="p-3 bg-light rounded border">
                        ${seguimiento.resultados}
                    </div>
                </div>`;
            tieneDatos = true;
        }

        if (esValido(seguimiento.recomendaciones)) {
            html += `
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted">Recomendaciones:</label>
                    <div class="p-3 bg-light rounded border">
                        ${seguimiento.recomendaciones}
                    </div>
                </div>`;
            tieneDatos = true;
        }

        if (esValido(seguimiento.criterios_cumplidos)) {
            html += `
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted">Criterios Cumplidos:</label>
                    <div class="p-3 bg-light rounded border">
                        <span class="badge ${seguimiento.criterios_cumplidos === 'Sí' ? 'bg-success' : 'bg-warning'}">
                            ${seguimiento.criterios_cumplidos}
                        </span>
                    </div>
                </div>`;
            tieneDatos = true;
        }

        if (tieneDatos) {
            document.getElementById('seguimientoCard').innerHTML = html;
            document.getElementById('seccionSeguimiento').style.display = 'block';
            return true;
        }
        return false;
    }

    function mostrarError(mensaje) {
        document.getElementById('loadingIndicator').style.display = 'none';

        const errorHtml = `
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-exclamation-triangle text-danger mb-3" style="font-size: 3rem;"></i>
                            <h4 class="text-danger mb-3">Error al Cargar el Historial</h4>
                            <p class="text-muted mb-4">${mensaje}</p>
                            <div class="d-flex gap-2 justify-content-center">
                                <button class="btn btn-primary" onclick="location.reload()">
                                    <i class="fas fa-redo me-2"></i>
                                    Intentar Nuevamente
                                </button>
                                <a href="{{ route('evaluacion_paciente', ['id_cita' => $id_cita]) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Volver a Evaluación
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;

        document.getElementById('historialContent').innerHTML = errorHtml;
        document.getElementById('historialContent').style.display = 'block';
    }
</script>
@endpush