@extends('layout.master')
@section('content')
<div class="container-fluid">
    <!-- Encabezado -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #28a745, #20c997);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1 text-white">
                                <i class="fas fa-user-md me-2"></i>
                                Evaluación del Paciente
                            </h4>
                            <p class="mb-0 opacity-75 text-white">
                                <i class="fas fa-calendar me-1"></i>
                                Sistema de Psicología - UNAG
                            </p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('calendario_citas') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>
                                Regresar al Calendario
                            </a>
                            <button type="button" class="btn btn-light btn-sm" id="btnVerHistorial">
                                <i class="fas fa-history me-1"></i>
                                Ver Historial
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navegación por pestañas -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <ul class="nav nav-tabs nav-fill" id="evaluacionTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="seccion1-tab" data-bs-toggle="tab" data-bs-target="#seccion1-content" type="button" role="tab" aria-controls="seccion1-content" aria-selected="true">
                                <i class="fas fa-user me-2"></i>
                                <span class="d-none d-md-inline">I. </span>Datos del Paciente
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="seccion2-tab" data-bs-toggle="tab" data-bs-target="#seccion2-content" type="button" role="tab" aria-controls="seccion2-content" aria-selected="false">
                                <i class="fas fa-clipboard-list me-2"></i>
                                <span class="d-none d-md-inline">II. </span>Motivo
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="seccion3-tab" data-bs-toggle="tab" data-bs-target="#seccion3-content" type="button" role="tab" aria-controls="seccion3-content" aria-selected="false">
                                <i class="fas fa-history me-2"></i>
                                <span class="d-none d-md-inline">III. </span>Historial
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="seccion4-tab" data-bs-toggle="tab" data-bs-target="#seccion4-content" type="button" role="tab" aria-controls="seccion4-content" aria-selected="false">
                                <i class="fas fa-brain me-2"></i>
                                <span class="d-none d-md-inline">IV. </span>Evaluación
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="seccion5-tab" data-bs-toggle="tab" data-bs-target="#seccion5-content" type="button" role="tab" aria-controls="seccion5-content" aria-selected="false">
                                <i class="fas fa-tasks me-2"></i>
                                <span class="d-none d-md-inline">V. </span>Plan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="seccion6-tab" data-bs-toggle="tab" data-bs-target="#seccion6-content" type="button" role="tab" aria-controls="seccion6-content" aria-selected="false">
                                <i class="fas fa-clipboard-check me-2"></i>
                                <span class="d-none d-md-inline">VI. </span>Seguimiento
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="seccion7-tab" data-bs-toggle="tab" data-bs-target="#seccion7-content" type="button" role="tab" aria-controls="seccion7-content" aria-selected="false">
                                <i class="fas fa-user-md me-2"></i>
                                <span class="d-none d-md-inline">VII. </span>Profesional
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido de las pestañas -->
    <div class="tab-content" id="evaluacionTabsContent">
        
       <!---Sección I: Datos del Paciente-->
<div class="tab-pane fade show active" id="seccion1-content" role="tabpanel" aria-labelledby="seccion1-tab">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background: linear-gradient(135deg, #28a745, #20c997);">
                    <h5 class="mb-0 text-white">
                        <i class="fas fa-user me-2"></i>
                        Sección I: Datos del Paciente
                    </h5>
                </div>
                <div class="card-body">
                    <form id="formDatosGenerales">
                        <input type="hidden" id="idCita" name="id_cita" value="{{ $id_cita ?? '' }}">
                        
                        <!---Indicador de carga-->
                        <div id="loadingIndicator" class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p class="mt-2 text-muted">Cargando datos del paciente...</p>
                        </div>
                        
                        <!---Contenido del formulario-->
                        <div id="datosGeneralesContent" style="display: none;">
                            <div class="row g-3">
                                <!---Columna izquierda-->
                                <div class="col-md-6 border-end">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-hashtag text-primary me-1"></i>
                                            Número de Cita
                                        </label>
                                        <input type="text" class="form-control bg-light border-0 shadow-sm" id="numeroRegistroCita" readonly>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-id-card text-primary me-1"></i>
                                            Número de Registro
                                        </label>
                                        <input type="text" class="form-control bg-light border-0 shadow-sm" id="numeroRegistroAsignado" readonly>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-user text-primary me-1"></i>
                                            Nombre Completo
                                        </label>
                                        <input type="text" class="form-control bg-light border-0 shadow-sm" id="nombreCompleto" readonly>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-calendar-alt text-primary me-1"></i>
                                            Fecha de Nacimiento
                                        </label>
                                        <input type="date" class="form-control bg-light border-0 shadow-sm" id="fechaNacimiento" readonly>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-calendar-alt text-primary me-1"></i>
                                            Edad
                                        </label>
                                        <input type="text" class="form-control bg-light border-0 shadow-sm" id="edadEstudiante" readonly>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-phone text-primary me-1"></i>
                                            Teléfono
                                        </label>
                                        <input type="tel" class="form-control bg-light border-0 shadow-sm" id="telefonoEstudiante" readonly>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-venus-mars text-primary me-1"></i>
                                            Sexo
                                        </label>
                                        <input type="text" class="form-control bg-light border-0 shadow-sm" id="sexoEstudiante" readonly>
                                    </div>
                                </div>
                                
                                <!---Columna derecha-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-graduation-cap text-primary me-1"></i>
                                            Carrera Universitaria
                                        </label>
                                        <input type="text" class="form-control bg-light border-0 shadow-sm" id="nombreCarrera" readonly>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-envelope text-primary me-1"></i>
                                            Correo Institucional
                                        </label>
                                        <input type="email" class="form-control bg-light border-0 shadow-sm" id="correoElectronico" readonly>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-layer-group text-primary me-1"></i>
                                            Año Académico
                                        </label>
                                        <input type="text" class="form-control bg-light border-0 shadow-sm" id="anioAcademico" readonly>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-building text-primary me-1"></i>
                                            Edificio
                                        </label>
                                        <input type="text" class="form-control bg-light border-0 shadow-sm" id="edificio" readonly>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-door-open text-primary me-1"></i>
                                            Cuarto
                                        </label>
                                        <input type="text" class="form-control bg-light border-0 shadow-sm" id="numeroCuarto" readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <!---NUEVOS CAMPOS AGREGADOS - Sección adicional-->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6 class="text-muted mb-3 border-bottom pb-2">
                                        <i class="fas fa-home text-primary me-1"></i>
                                        Información Familiar y Residencial
                                    </h6>
                                </div>
                            </div>
                            
                            <div class="row g-3">
                                <!---Campo Dirección-->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                            Dirección
                                        </label>
                                        <textarea class="form-control bg-light border-0 shadow-sm" 
                                                  id="direccionEstudiante" 
                                                  rows="2" 
                                                  readonly></textarea>
                                    </div>
                                </div>
                                
                                <!---Campo Nombre del Padre-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-male text-primary me-1"></i>
                                            Nombre del Padre
                                        </label>
                                        <input type="text" 
                                               class="form-control bg-light border-0 shadow-sm" 
                                               id="nombrePadre" 
                                               readonly>
                                    </div>
                                </div>
                                
                                <!---Campo Nombre de la Madre-->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-female text-primary me-1"></i>
                                            Nombre de la Madre
                                        </label>
                                        <input type="text" 
                                               class="form-control bg-light border-0 shadow-sm" 
                                               id="nombreMadre" 
                                               readonly>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="alert alert-info border-0 shadow-sm">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-info-circle text-info me-2"></i>
                                            <div>
                                                <strong>Información:</strong>
                                                Los datos mostrados son de solo lectura y provienen del expediente del estudiante.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!---Botón de acción-->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary shadow-sm" id="btnSiguiente1">
                                            Siguiente Sección
                                            <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
        <!-- Sección II: Motivo de la consulta -->
        <div class="tab-pane fade" id="seccion2-content" role="tabpanel" aria-labelledby="seccion2-tab">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header" style="background: linear-gradient(135deg, #28a745, #20c997);">
                            <h5 class="mb-0 text-white">
                                <i class="fas fa-clipboard-list me-2"></i>
                                Sección II: Motivo de la Consulta
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="formMotivoConsulta">
                                <!-- Indicador de carga para catálogos -->
                                <div id="loadingCatalogos" class="text-center py-4">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Cargando catálogos...</span>
                                    </div>
                                    <p class="mt-2 text-muted">Cargando opciones...</p>
                                </div>
                                
                                <!-- Contenido del formulario -->
                                <div id="motivoConsultaContent" style="display: none;">
                                    <div class="row g-3">
                                        <!-- Descripción del motivo -->
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-question-circle text-primary me-1"></i>
                                                    Motivo Principal de la Consulta <span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control shadow-sm" id="motivoPrincipal" rows="4" placeholder="Describa el motivo principal por el cual el paciente solicita la consulta..." required></textarea>
                                                <div class="invalid-feedback">
                                                    Por favor, describa el motivo principal de la consulta.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" id="id_citaSeccion2" name="id_cita_seccion2" value="">
                                        <input type="hidden" id="numeroRegistroAsignadoSeccion2" name="numero_registro_asignado_seccion2" value="">
                                        
                                        <!-- Frecuencia de síntomas (Radio buttons) -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-clock text-primary me-1"></i>
                                                    Frecuencia de Síntomas <span class="text-danger">*</span>
                                                </label>
                                                <div class="border rounded p-3 bg-light" id="frecuenciaSintomasContainer">
                                                    <!-- Los radio buttons se cargarán aquí dinámicamente -->
                                                </div>
                                                <div class="invalid-feedback">
                                                    Por favor, seleccione la frecuencia de síntomas.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Impacto en la vida diaria (Checkboxes) -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-home text-primary me-1"></i>
                                                    Impacto en la Vida Diaria <span class="text-danger">*</span>
                                                </label>
                                                <div class="border rounded p-3 bg-light" id="impactoVidaDiariaContainer" style="max-height: 200px; overflow-y: auto;">
                                                    <!-- Los checkboxes se cargarán aquí dinámicamente -->
                                                </div>
                                                <div class="invalid-feedback">
                                                    Por favor, seleccione al menos un impacto en la vida diaria.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Factores desencadenantes (Checkboxes) -->
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-exclamation-triangle text-primary me-1"></i>
                                                    Factores Desencadenantes <span class="text-danger">*</span>
                                                </label>
                                                <div class="border rounded p-3 bg-light" id="factoresDesencadenantesContainer" style="max-height: 200px; overflow-y: auto;">
                                                    <!-- Los checkboxes se cargarán aquí dinámicamente -->
                                                </div>
                                                <div class="invalid-feedback">
                                                    Por favor, seleccione al menos un factor desencadenante.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Botones de acción -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary shadow-sm" id="btnRegresar2">
                                                <i class="fas fa-arrow-left me-2"></i>
                                                Regresar
                                            </button>
                                            <button type="button" class="btn btn-primary shadow-sm" id="btnSiguiente2" disabled>
                                                Siguiente Sección
                                                <i class="fas fa-arrow-right ms-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección III: Historial Clínico y Antecedentes -->
        <div class="tab-pane fade" id="seccion3-content" role="tabpanel" aria-labelledby="seccion3-tab">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header" style="background: linear-gradient(135deg, #28a745, #20c997);">
                            <h5 class="mb-0 text-white">
                                <i class="fas fa-history me-2"></i>
                                Sección III: Historial Clínico y Antecedentes
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="formHistorialClinico">
                                <!-- Indicador de carga para catálogos -->
                                <div id="loadingCatalogos3" class="text-center py-4">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Cargando catálogos...</span>
                                    </div>
                                    <p class="mt-2 text-muted">Cargando opciones de historial clínico...</p>
                                </div>
                                
                                <!-- Contenido del formulario -->
                                <div id="historialClinicoContent" style="display: none;">
                                    <div class="row g-3">
                                        <!-- Antecedentes familiares -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-user-friends text-primary me-1"></i>
                                                    Antecedentes Familiares <span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control shadow-sm" id="antecedentesFamiliares" rows="4" placeholder="Describa los antecedentes familiares relevantes..." required></textarea>
                                                <div class="invalid-feedback">
                                                    Por favor, describa los antecedentes familiares.
                                                </div>
                                            </div>
                                            
                                            <input type="hidden" id="id_citaSeccion3" name="id_cita_seccion3" value="">
                                            <input type="hidden" id="numeroRegistroAsignadoSeccion3" name="numero_registro_asignado_seccion3" value="">
                                            
                                            <!-- Antecedentes familiares de trastornos (ahora como checkboxes) -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-dna text-primary me-1"></i>
                                                    Antecedentes Familiares de Trastornos <span class="text-danger">*</span>
                                                </label>
                                                <div class="border rounded p-3 bg-light" id="tipoTrastornoContainer" style="max-height: 200px; overflow-y: auto;">
                                                    <!-- Checkboxes se cargarán aquí dinámicamente -->
                                                </div>
                                                <div class="invalid-feedback">
                                                    Por favor, seleccione al menos un antecedente familiar de trastorno.
                                                </div>
                                            </div>
                                            
                                            <!-- Antecedentes de salud mental -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-brain text-primary me-1"></i>
                                                    Antecedentes de Salud Mental <span class="text-danger">*</span>
                                                </label>
                                                <div class="border rounded p-3 bg-light" id="antecedentesSaludMentalContainer" style="max-height: 200px; overflow-y: auto;">
                                                    <!-- Checkboxes se cargarán aquí -->
                                                </div>
                                                <div class="invalid-feedback">
                                                    Por favor, seleccione al menos un antecedente de salud mental.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Antecedentes personales -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-user text-primary me-1"></i>
                                                    Antecedentes Personales <span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control shadow-sm" id="antecedentesPersonales" rows="4" placeholder="Describa los antecedentes personales relevantes..." required></textarea>
                                                <div class="invalid-feedback">
                                                    Por favor, describa los antecedentes personales.
                                                </div>
                                            </div>
                                            
                                            <!-- Consumo de sustancias -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-pills text-primary me-1"></i>
                                                    Consumo de Sustancias <span class="text-danger">*</span>
                                                </label>
                                                <div class="border rounded p-3 bg-light" id="consumoSustanciasContainer" style="max-height: 200px; overflow-y: auto;">
                                                    <!-- Checkboxes se cargarán aquí -->
                                                </div>
                                                <div class="invalid-feedback">
                                                    Por favor, seleccione al menos una opción de consumo de sustancias.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Botones de acción -->
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-secondary shadow-sm" id="btnRegresar3">
                                                    <i class="fas fa-arrow-left me-2"></i>
                                                    Regresar
                                                </button>
                                                <button type="button" class="btn btn-primary shadow-sm" id="btnSiguiente3" disabled>
                                                    Siguiente Sección
                                                    <i class="fas fa-arrow-right ms-2"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sección IV: Evaluación Psicológica -->
        <div class="tab-pane fade" id="seccion4-content" role="tabpanel" aria-labelledby="seccion4-tab">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header" style="background: linear-gradient(135deg, #28a745, #20c997);">
                            <h5 class="mb-0 text-white">
                                <i class="fas fa-brain me-2"></i>
                                Sección IV: Evaluación Psicológica
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="formEvaluacionPsicologica">
                                <!-- Indicador de carga para catálogos -->
                                <div id="loadingCatalogos4" class="text-center py-4">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Cargando catálogos...</span>
                                    </div>
                                    <p class="mt-2 text-muted">Cargando opciones de evaluación...</p>
                                </div>
                                
                                <!-- Contenido del formulario -->
                                <div id="evaluacionPsicologicaContent" style="display: none;">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-eye text-primary me-1"></i>
                                                    Observaciones Clínicas <span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control shadow-sm" id="observacionesClinicas" rows="4" placeholder="Describa las observaciones clínicas durante la evaluación..." required></textarea>
                                                <div class="invalid-feedback">
                                                    Por favor, describa las observaciones clínicas.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-eye text-primary me-1"></i>
                                                    Otros Criterios <span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control shadow-sm" id="otrosCriterios" rows="4" placeholder="Describa las otros criterios durante la evaluación..." required></textarea>
                                                <div class="invalid-feedback">
                                                    Por favor, describa otros criterios clínicos.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-chart-line text-primary me-1"></i>
                                                    Resultados de Pruebas <span class="text-danger">*</span>
                                                </label>
                                                <textarea class="form-control shadow-sm" id="resultadosPruebas" rows="4" placeholder="Describa los resultados de las pruebas aplicadas..." required></textarea>
                                                <div class="invalid-feedback">
                                                    Por favor, describa los resultados de las pruebas.
                                                </div>
                                            </div>
                                            
                                            <input type="hidden" id="id_citaSeccion4" name="id_cita_seccion4" value="">
                                            <input type="hidden" id="id_empleado" name="id_empleado_seccion4" value="">
                                            <input type="hidden" id="numeroRegistroAsignadoSeccion4" name="numero_registro_asignado_seccion4" value="">
                                            
                                            <!-- Pruebas psicológicas aplicadas -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-clipboard-check text-primary me-1"></i>
                                                    Pruebas Psicológicas Aplicadas <span class="text-danger">*</span>
                                                </label>
                                                <div class="border rounded p-3 bg-light" id="pruebasPsicologicasContainer" style="max-height: 200px; overflow-y: auto;">
                                                    <!-- Checkboxes se cargarán aquí -->
                                                </div>
                                                <div class="invalid-feedback">
                                                    Por favor, seleccione al menos una prueba aplicada.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Botones de acción -->
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-secondary shadow-sm" id="btnRegresar4">
                                                    <i class="fas fa-arrow-left me-2"></i>
                                                    Regresar
                                                </button>
                                                <button type="button" class="btn btn-primary shadow-sm" id="btnSiguiente4" disabled>
                                                    Siguiente Sección
                                                    <i class="fas fa-arrow-right ms-2"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección V: Plan de Intervención -->
        <div class="tab-pane fade" id="seccion5-content" role="tabpanel" aria-labelledby="seccion5-tab">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header" style="background: linear-gradient(135deg, #28a745, #20c997);">
                            <h5 class="mb-0 text-white">
                                <i class="fas fa-tasks me-2"></i>
                                Sección V: Plan de Intervención
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="formPlanIntervencion">
                                <!-- Indicador de carga para catálogos -->
                                <div id="loadingCatalogos5" class="text-center py-4">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Cargando catálogos...</span>
                                    </div>
                                    <p class="mt-2 text-muted">Cargando opciones de intervención...</p>
                                </div>
                                
                                <!-- Contenido del formulario -->
                                <div id="planIntervencionContent" style="display: none;">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <!-- Objetivos terapéuticos -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-bullseye text-primary me-1"></i>
                                                    Objetivos Terapéuticos <span class="text-danger">*</span>
                                                </label>
                                                <div class="border rounded p-3 bg-light" id="objetivosTerapeuticosContainer"
                                                    style="max-height: 200px; overflow-y: auto;">
                                                    <!-- Checkboxes se cargarán aquí -->
                                                </div>
                                                <div class="invalid-feedback">
                                                    Por favor, seleccione al menos un objetivo terapéutico.
                                                </div>
                                            </div>
                                            
                                            <input type="hidden" id="id_citaSeccion5" name="id_cita_seccion5" value="">
                                            <input type="hidden" id="numeroRegistroAsignadoSeccion5" name="numero_registro_asignado_seccion5" value="">
                                            <input type="hidden" id="id_clinica_selected" name="id_clinica" value="">
                                            
                                            <!-- Estrategias de intervención -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-route text-primary me-1"></i>
                                                    Estrategias de Intervención <span class="text-danger">*</span>
                                                </label>
                                                <div class="border rounded p-3 bg-light" id="estrategiasIntervencionContainer" 
                                                    style="max-height: 200px; overflow-y: auto;">
                                                    <!-- Checkboxes se cargarán aquí -->
                                                </div>
                                                <div class="invalid-feedback">
                                                    Por favor, seleccione al menos una estrategia de intervención.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <!-- Frecuencia de sesiones -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-calendar-alt text-primary me-1"></i>
                                                    Frecuencia de Sesiones <span class="text-danger">*</span>
                                                </label>
                                                <div class="border rounded p-3 bg-light" id="frecuenciaSesionesContainer">
                                                    <!-- Radio buttons se cargarán aquí -->
                                                </div>
                                                <div class="invalid-feedback">
                                                    Por favor, seleccione la frecuencia de sesiones.
                                                </div>
                                            </div>
                                            
                                            <!-- Tipos de terapias -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-hand-holding-heart text-primary me-1"></i>
                                                    Tipos de Terapias <span class="text-danger">*</span>
                                                </label>
                                                <div class="border rounded p-3 bg-light" id="tiposTerapiasContainer"
                                                    style="max-height: 200px; overflow-y: auto;">
                                                    <!-- Checkboxes se cargarán aquí -->
                                                </div>
                                                <div class="invalid-feedback">
                                                    Por favor, seleccione al menos un tipo de terapia.
                                                </div>
                                            </div>
                                            
                                            <!-- Derivación a servicios de salud -->
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-hospital text-primary me-1"></i>
                                                    Derivación a Servicios de Salud
                                                </label>
                                                <div class="border rounded p-3 bg-light">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="derivacion_servicios" 
                                                            id="derivacion_si" value="1" onchange="toggleClinicasContainer()">
                                                        <label class="form-check-label" for="derivacion_si">
                                                            <i class="fas fa-check-circle text-success me-1"></i>
                                                            Sí
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="derivacion_servicios" 
                                                            id="derivacion_no" value="0" checked onchange="toggleClinicasContainer()">
                                                        <label class="form-check-label" for="derivacion_no">
                                                            <i class="fas fa-times-circle text-danger me-1"></i>
                                                            No
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Lista de Clínicas (inicialmente oculta) -->
                                            <div class="mb-3" id="clinicasContainer" style="display: none;">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-clinic-medical text-primary me-1"></i>
                                                    Seleccionar Clínica <span class="text-danger">*</span>
                                                </label>
                                                <div class="border rounded p-3 bg-light" id="clinicasListContainer"
                                                    style="max-height: 200px; overflow-y: auto;">
                                                    
                                                    <!-- Indicador de carga -->
                                                    <div id="loadingClinicas" class="text-center py-3">
                                                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                            <span class="visually-hidden">Cargando clínicas...</span>
                                                        </div>
                                                        <p class="mt-2 text-muted small mb-0">Cargando lista de clínicas...</p>
                                                    </div>
                                                    
                                                    <!-- Radio buttons de clínicas se cargarán aquí -->
                                                    <div id="clinicasRadioContainer" style="display: none;">
                                                        <!-- Se llenarán dinámicamente -->
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">
                                                    Por favor, seleccione una clínica.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Botones de acción -->
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-secondary shadow-sm" id="btnRegresar5">
                                                    <i class="fas fa-arrow-left me-2"></i>
                                                    Regresar
                                                </button>
                                                <button type="button" class="btn btn-primary shadow-sm" id="btnSiguiente5" disabled>
                                                    Siguiente Sección
                                                    <i class="fas fa-arrow-right ms-2"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección VI: Historial de Seguimiento y Evolución -->
        <div class="tab-pane fade" id="seccion6-content" role="tabpanel" aria-labelledby="seccion6-tab">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header" style="background: linear-gradient(135deg, #28a745, #20c997);">
                            <h5 class="mb-0 text-white">
                                <i class="fas fa-clipboard-check me-2"></i>
                                Sección VI: Historial de Seguimiento y Evolución
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="formSeguimientoEvolucion">
                                <input type="hidden" id="id_citaSeccion6" name="id_cita_seccion6" value="">
                                <input type="hidden" id="numeroRegistroAsignadoSeccion6" name="numero_registro_asignado_seccion6" value="">
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-history text-primary me-1"></i>
                                                Historial de Seguimiento <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control shadow-sm" id="historialSeguimiento" rows="6" placeholder="Describa el historial de seguimiento del paciente..." required></textarea>
                                            <div class="invalid-feedback">
                                                Por favor, describa el historial de seguimiento.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-chart-line text-primary me-1"></i>
                                                Resultados Obtenidos <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control shadow-sm" id="resultadosObtenidos" rows="6" placeholder="Describa los resultados obtenidos durante el seguimiento..." required></textarea>
                                            <div class="invalid-feedback">
                                                Por favor, describa los resultados obtenidos.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-lightbulb text-primary me-1"></i>
                                                Recomendaciones <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control shadow-sm" id="recomendaciones" rows="4" placeholder="Describa las recomendaciones para el paciente..." required></textarea>
                                            <div class="invalid-feedback">
                                                Por favor, describa las recomendaciones.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                <i class="fas fa-check-circle text-primary me-1"></i>
                                                Criterios Cumplidos <span class="text-danger">*</span>
                                            </label>
                                            <div class="border rounded p-3 bg-light">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="criterios_cumplidos" id="criterios_si" value="true" required>
                                                    <label class="form-check-label" for="criterios_si">
                                                        Sí
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="criterios_cumplidos" id="criterios_no" value="false">
                                                    <label class="form-check-label" for="criterios_no">
                                                        No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Botones de acción -->
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary shadow-sm" id="btnRegresar6">
                                                <i class="fas fa-arrow-left me-2"></i>
                                                Regresar
                                            </button>
                                            <button type="button" class="btn btn-primary shadow-sm" id="btnSiguiente6" disabled>
                                                Siguiente Sección
                                                <i class="fas fa-arrow-right ms-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección VII: Profesional Responsable -->
        <div class="tab-pane fade" id="seccion7-content" role="tabpanel" aria-labelledby="seccion7-tab">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header" style="background: linear-gradient(135deg, #28a745, #20c997);">
                            <h5 class="mb-0 text-white">
                                <i class="fas fa-user-md me-2"></i>
                                Sección VII: Profesional Responsable
                            </h5>
                        </div>
                        <div class="card-body">
                            <form id="formAsignacionProfesional">
                                <!-- Indicador de carga -->
                                <div id="loadingProfesionales" class="text-center py-4">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Cargando...</span>
                                    </div>
                                    <p class="mt-2 text-muted">Cargando lista de profesionales...</p>
                                </div>
                                
                                <!-- Contenido del formulario -->
                                <div id="asignacionProfesionalContent" style="display: none;">
                                    <div class="alert alert-info border-0 shadow-sm mb-4">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-info-circle text-info me-2"></i>
                                            <div>
                                                <strong>Información:</strong> Seleccione el profesional que será responsable de esta evaluación psicológica.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">
                                                    <i class="fas fa-user-md text-primary me-1"></i>
                                                    Profesional Responsable <span class="text-danger">*</span>
                                                </label>
                                                <div class="border rounded p-3 bg-light" id="profesionalesContainer">
                                                    <!-- Los radio buttons se cargarán aquí dinámicamente -->
                                                </div>
                                                <div class="invalid-feedback">
                                                    Por favor, seleccione un profesional responsable.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Campos ocultos -->
                                        <input type="hidden" id="id_citaSeccion7" name="id_cita_seccion7" value="">
                                        <input type="hidden" id="id_empleado" name="id_empleado" value="">
                                        <input type="hidden" id="numeroRegistroAsignadoSeccion7" name="numero_registro_asignado_seccion7" value="">
                                    </div>
                                    
                                    <!-- Botones de acción -->
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between">
                                                <button type="button" class="btn btn-secondary shadow-sm" id="btnRegresar7">
                                                    <i class="fas fa-arrow-left me-2"></i>
                                                    Regresar
                                                </button>
                                                 @if(in_array('clinica_psicologica_escribir_calendario_citas', $scopes))
                                                <button type="button" class="btn btn-success shadow-sm" id="btnGuardarFormulario" disabled>
                                                    <i class="fas fa-save me-2"></i>
                                                    Guardar Evaluación
                                                </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                        <th class="text-center">
                                            <i class="fas fa-hashtag me-1"></i>
                                            ID Cita
                                        </th>
                                        <th class="text-center">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            Número de Cita
                                        </th>
                                        <th class="text-center">
                                            <i class="fas fa-id-card me-1"></i>
                                            Número de Registro
                                        </th>
                                        <th class="text-center">
                                            <i class="fas fa-user me-1"></i>
                                            Nombre Completo
                                        </th>
                                        <th class="text-center">
                                            <i class="fas fa-user-md me-1"></i>
                                            Profesional Responsable
                                        </th>
                                        <th class="text-center">
                                            <i class="fas fa-clock me-1"></i>
                                            Fecha
                                        </th>
                                        <th class="text-center">
                                            <i class="fas fa-cogs me-1"></i>
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="cuerpoTablaHistorial">
                                    <!-- Los datos se cargarán aquí -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<!-- Font Awesome 4 -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- O Font Awesome 5/6 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush

@push('plugin-scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap5.min.js"></script>
@endpush

@push('custom-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Inicialización - Obtener ID de cita y cargar datos
        const idCita = document.getElementById('idCita').value;
        
        // Inicializar botones como deshabilitados
        document.getElementById('btnSiguiente2').disabled = true;
        document.getElementById('btnSiguiente3').disabled = true;
        document.getElementById('btnSiguiente4').disabled = true;
        document.getElementById('btnSiguiente5').disabled = true;
        document.getElementById('btnGuardarFormulario').disabled = true;
        
        if (idCita) {
            cargarDatosCita(idCita);
        } else {
            mostrarError('No se especificó un ID de cita válido');
        }
        
        // 2. Configurar navegación entre secciones
        setupNavigation();
        
        // 3. Configurar validaciones en tiempo real
        setupValidations();
        
        // 4. Configurar navegación por pestañas
        setupTabNavigation();
    });

    // ==================== FUNCIONES DE NAVEGACIÓN POR PESTAÑAS ====================
    function setupTabNavigation() {
        // Configurar eventos para las pestañas
        const tabs = document.querySelectorAll('#evaluacionTabs button[data-bs-toggle="tab"]');
        
        tabs.forEach(tab => {
            tab.addEventListener('shown.bs.tab', function (event) {
                const targetId = event.target.getAttribute('data-bs-target');
                const sectionNumber = targetId.replace('#seccion', '').replace('-content', '');
                
                // Cargar catálogos según la sección activada
                switch(sectionNumber) {
                    case '2':
                        if (document.getElementById('motivoConsultaContent').style.display === 'none') {
                            cargarCatalogosMotivo();
                        }
                        break;
                    case '3':
                        if (document.getElementById('historialClinicoContent').style.display === 'none') {
                            cargarCatalogosHistorialClinico();
                        }
                        break;
                    case '4':
                        if (document.getElementById('evaluacionPsicologicaContent').style.display === 'none') {
                            cargarCatalogosEvaluacion();
                        }
                        break;
                    case '5':
                        if (document.getElementById('planIntervencionContent').style.display === 'none') {
                            cargarCatalogosIntervencion();
                        }
                        break;
                    case '7':
                        if (document.getElementById('asignacionProfesionalContent').style.display === 'none') {
                            cargarProfesionales();
                        }
                        break;
                }
            });
        });
    }

    // ==================== FUNCIONES DE NAVEGACIÓN MODIFICADAS ====================
    function setupNavigation() {
        // Botones Siguiente - ahora también activan la pestaña siguiente
        document.getElementById('btnSiguiente1').addEventListener('click', () => {
            activarPestana('seccion2-tab');
        });
        
        document.getElementById('btnSiguiente2').addEventListener('click', function() {
            if (validarSeccion2()) {
                activarPestana('seccion3-tab');
            }
        });
        
        document.getElementById('btnSiguiente3').addEventListener('click', function() {
            if (validarSeccion3()) {
                activarPestana('seccion4-tab');
            }
        });
        
        document.getElementById('btnSiguiente4').addEventListener('click', function() {
            if (validarSeccion4()) {
                activarPestana('seccion5-tab');
            }
        });
        
        document.getElementById('btnSiguiente5').addEventListener('click', function() {
            if (validarSeccion5()) {
                activarPestana('seccion6-tab');
            }
        });
        
        document.getElementById('btnSiguiente6').addEventListener('click', function() {
            if (validarSeccion6()) {
                activarPestana('seccion7-tab');
            }
        });
        
        // Botones Regresar - ahora también activan la pestaña anterior
        document.getElementById('btnRegresar2').addEventListener('click', () => activarPestana('seccion1-tab'));
        document.getElementById('btnRegresar3').addEventListener('click', () => activarPestana('seccion2-tab'));
        document.getElementById('btnRegresar4').addEventListener('click', () => activarPestana('seccion3-tab'));
        document.getElementById('btnRegresar5').addEventListener('click', () => activarPestana('seccion4-tab'));
        document.getElementById('btnRegresar6').addEventListener('click', () => activarPestana('seccion5-tab'));
        document.getElementById('btnRegresar7').addEventListener('click', () => activarPestana('seccion6-tab'));
        
        // Botón Guardar
        document.getElementById('btnGuardarFormulario').addEventListener('click', guardarFormularioCompleto);
    }

    // Función para activar una pestaña específica
    function activarPestana(tabId) {
        const tab = document.getElementById(tabId);
        if (tab) {
            const bsTab = new bootstrap.Tab(tab);
            bsTab.show();
        }
    }

    // ==================== FUNCIONES DE VALIDACIÓN ====================
    function setupValidations() {
        // Sección II: Motivo de Consulta
        document.getElementById('motivoPrincipal').addEventListener('input', validarSeccion2);
        document.getElementById('frecuenciaSintomasContainer').addEventListener('change', validarSeccion2);
        document.getElementById('impactoVidaDiariaContainer').addEventListener('change', validarSeccion2);
        document.getElementById('factoresDesencadenantesContainer').addEventListener('change', validarSeccion2);
        
        // Sección III: Historial Clínico
        document.getElementById('antecedentesFamiliares').addEventListener('input', validarSeccion3);
        document.getElementById('tipoTrastornoContainer').addEventListener('change', validarSeccion3);
        document.getElementById('antecedentesSaludMentalContainer').addEventListener('change', validarSeccion3);
        document.getElementById('consumoSustanciasContainer').addEventListener('change', validarSeccion3);
        
        // Sección IV: Evaluación Psicológica
        document.getElementById('observacionesClinicas').addEventListener('input', validarSeccion4);
        document.getElementById('otrosCriterios').addEventListener('input', validarSeccion4);
        document.getElementById('resultadosPruebas').addEventListener('input', validarSeccion4);
        document.getElementById('pruebasPsicologicasContainer').addEventListener('change', validarSeccion4);
        
    // Sección V: Plan de Intervención
        document.getElementById('objetivosTerapeuticosContainer').addEventListener('change', validarSeccion5);
        document.getElementById('estrategiasIntervencionContainer').addEventListener('change', validarSeccion5);
        document.getElementById('frecuenciaSesionesContainer').addEventListener('change', validarSeccion5);
        document.getElementById('tiposTerapiasContainer').addEventListener('change', validarSeccion5);
        
        
      
        
        // Sección VI: Seguimiento y Evolución
        document.getElementById('historialSeguimiento').addEventListener('input', validarSeccion6);
        document.getElementById('resultadosObtenidos').addEventListener('input', validarSeccion6);
        document.getElementById('recomendaciones').addEventListener('input', validarSeccion6);
        document.querySelectorAll('input[name="criterios_cumplidos"]').forEach(radio => {
            radio.addEventListener('change', validarSeccion6);
        });
    }

    document.addEventListener('change', function(e) {
        if (e.target.name === 'derivacion_servicios') {
            toggleClinicasContainer();
        }
    });

    // Event listeners para selección de clínicas
    document.addEventListener('change', function(e) {
        if (e.target.name === 'clinica_seleccionada') {
            const idClinica = e.target.value;
            seleccionarClinica(idClinica);
        }
    });

    function validarSeccion2() {
        const motivo = document.getElementById('motivoPrincipal').value.trim();
        const frecuencia = document.querySelector('input[name="frecuencia_sintomas"]:checked');
        const impactos = document.querySelectorAll('input[name="impacto_vida_diaria[]"]:checked');
        const factores = document.querySelectorAll('input[name="factores_desencadenantes[]"]:checked');
        
        const valido = motivo !== '' && 
                    frecuencia !== null && 
                    impactos.length > 0 && 
                    factores.length > 0;
        
        document.getElementById('btnSiguiente2').disabled = !valido;
        actualizarEstadoPestana('seccion2-tab', valido);
        return valido;
    }

    function validarSeccion3() {
        const antecedentes = document.getElementById('antecedentesFamiliares').value.trim();
        const trastornos = document.querySelectorAll('input[name="tipo_trastorno[]"]:checked');
        const saludMental = document.querySelectorAll('input[name="antecedentes_salud_mental[]"]:checked');
        const sustancias = document.querySelectorAll('input[name="consumo_sustancias[]"]:checked');
        
        const valido = antecedentes !== '' && 
                    trastornos.length > 0 && 
                    saludMental.length > 0 && 
                    sustancias.length > 0;
        
        document.getElementById('btnSiguiente3').disabled = !valido;
        actualizarEstadoPestana('seccion3-tab', valido);
        return valido;
    }

    function validarSeccion4() {
        const observaciones = document.getElementById('observacionesClinicas').value.trim();
        const otrosCriterios = document.getElementById('otrosCriterios').value.trim();
        const resultados = document.getElementById('resultadosPruebas').value.trim();
        const pruebas = document.querySelectorAll('input[name="pruebas_psicologicas[]"]:checked');
        
        const valido = observaciones !== '' && 
                    otrosCriterios !== '' && 
                    resultados !== '' && 
                    pruebas.length > 0;
        
        document.getElementById('btnSiguiente4').disabled = !valido;
        actualizarEstadoPestana('seccion4-tab', valido);
        return valido;
    }

    function validarSeccion5() {
        const objetivos = document.querySelectorAll('input[name="objetivos_terapeuticos[]"]:checked');
        const estrategias = document.querySelectorAll('input[name="estrategias_intervencion[]"]:checked');
        const frecuencia = document.querySelector('input[name="frecuencia_sesiones"]:checked');
        const terapias = document.querySelectorAll('input[name="tipos_terapias[]"]:checked');
        
        // Validar derivación a servicios de salud
        const derivacionSi = document.getElementById('derivacion_si');
        const derivacionNo = document.getElementById('derivacion_no');
        const derivacionSeleccionada = derivacionSi?.checked || derivacionNo?.checked;
        
        // Si se selecciona "Sí" para derivación, validar que se haya seleccionado una clínica
        let clinicaValida = true;
        const clinicasContainer = document.getElementById('clinicasContainer');
        
        if (derivacionSi && derivacionSi.checked && clinicasContainer.style.display !== 'none') {
            const clinicaSeleccionada = document.querySelector('input[name="clinica_seleccionada"]:checked');
            clinicaValida = clinicaSeleccionada !== null;
            
            // Mostrar/ocultar feedback de validación para clínicas
            const clinicasListContainer = document.getElementById('clinicasListContainer');
            if (clinicaValida) {
                clinicasListContainer.classList.remove('is-invalid');
            } else {
                clinicasListContainer.classList.add('is-invalid');
            }
        }
        
        const valido = objetivos.length > 0 &&
                    estrategias.length > 0 &&
                    frecuencia !== null &&
                    terapias.length > 0 &&
                    derivacionSeleccionada &&
                    clinicaValida;
        
        document.getElementById('btnSiguiente5').disabled = !valido;
        actualizarEstadoPestana('seccion5-tab', valido);
        
        return valido;
    }

    function validarSeccion6() {
        const historial = document.getElementById('historialSeguimiento').value.trim();
        const resultados = document.getElementById('resultadosObtenidos').value.trim();
        const recomendaciones = document.getElementById('recomendaciones').value.trim();
        const criterios = document.querySelector('input[name="criterios_cumplidos"]:checked');
        
        const valido = historial !== '' && 
                    resultados !== '' && 
                    recomendaciones !== '' && 
                    criterios !== null;
        
        document.getElementById('btnSiguiente6').disabled = !valido;
        actualizarEstadoPestana('seccion6-tab', valido);
        return valido;
    }

    function validarSeccion7() {
        const profesionalSeleccionado = $('input[name="profesional_responsable"]:checked').length > 0;
        $('#btnGuardarFormulario').prop('disabled', !profesionalSeleccionado);
        actualizarEstadoPestana('seccion7-tab', profesionalSeleccionado);
        
        // Validación visual
        if (profesionalSeleccionado) {
            $('#profesionalesContainer').removeClass('is-invalid');
        } else {
            $('#profesionalesContainer').addClass('is-invalid');
        }
    }

    // Función para actualizar el estado visual de las pestañas
    function actualizarEstadoPestana(tabId, valido) {
        const tab = document.getElementById(tabId);
        if (tab) {
            if (valido) {
                tab.classList.add('text-success');
                tab.classList.remove('text-danger');
                // Agregar ícono de check
                const icon = tab.querySelector('i');
                if (icon && !tab.querySelector('.fa-check')) {
                    const checkIcon = document.createElement('i');
                    checkIcon.className = 'fas fa-check ms-1 text-success';
                    checkIcon.style.fontSize = '0.75em';
                    tab.appendChild(checkIcon);
                }
            } else {
                tab.classList.remove('text-success');
                tab.classList.add('text-danger');
                // Remover ícono de check si existe
                const checkIcon = tab.querySelector('.fa-check');
                if (checkIcon) {
                    checkIcon.remove();
                }
            }
        }
    }

    function validarFormularioCompleto() {
        return validarSeccion2() && validarSeccion3() && validarSeccion4() && 
            validarSeccion5() && validarSeccion6();
    }

    // ==================== FUNCIONES DE CARGA DE DATOS ====================
   async function cargarDatosCita(idCita) {
    try {
        // Mostrar indicador de carga
        const loadingIndicator = document.getElementById('loadingIndicator');
        if (loadingIndicator) loadingIndicator.style.display = 'block';

        const response = await fetch(`/psicologia/cita/${idCita}/datos`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.mensaje || `Error HTTP: ${response.status}`);
        }

        const data = await response.json();

        if (!data.estatus || !data.cita) {
            throw new Error(data.mensaje || 'Datos de cita no disponibles');
        }

        llenarFormulario(data.cita);

    } catch (error) {
        console.error('Error al cargar datos:', error);
        mostrarError(error.message);
        // Ocultar loader en caso de error
        const loadingIndicator = document.getElementById('loadingIndicator');
        if (loadingIndicator) loadingIndicator.style.display = 'none';
    }
}

function llenarFormulario(datos) {
    // Verificar que los elementos esenciales existan
    const loadingIndicator = document.getElementById('loadingIndicator');
    const content = document.getElementById('datosGeneralesContent');

    if (!loadingIndicator || !content) {
        console.error('Elementos esenciales del formulario no encontrados');
        return;
    }

    // Función auxiliar para llenar campos con validación - SIN DATOS EN DURO
    const llenarCampo = (id, valor, formateador = v => v) => {
        const elemento = document.getElementById(id);
        if (elemento) {
            // Solo llenar si hay valor, dejar vacío si no hay datos
            elemento.value = valor ? formateador(valor) : '';
        } else {
            console.warn(`Elemento con ID ${id} no encontrado`);
        }
    };

    try {
        // Obtener id_cita del campo oculto
        const idCitaElement = document.getElementById('idCita');
        if (!idCitaElement) throw new Error('Elemento idCita no encontrado');

        const idCita = idCitaElement.value;

        // Verificar que tenemos número de registro
        if (!datos.numero_registro_asignado) {
            throw new Error('Número de registro no disponible en los datos');
        }

        const numeroRegistro = datos.numero_registro_asignado;

        // Llenar campos en secciones (con validación)
        for (let i = 2; i <= 6; i++) {
            llenarCampo(`id_citaSeccion${i}`, idCita);
            llenarCampo(`numeroRegistroAsignadoSeccion${i}`, numeroRegistro);
        }

        // Llenar campos principales
        llenarCampo('numeroRegistroAsignado', numeroRegistro);
        llenarCampo('numeroRegistroCita', datos.numero_registro_cita);
        llenarCampo('fechaCita', datos.fecha_cita);
        llenarCampo('horaCita', datos.hora_cita);

        // Datos del estudiante
        llenarCampo('nombreCompleto', datos.nombre_estudiante);
        llenarCampo('sexoEstudiante', datos.sexo_estudiante);
        llenarCampo('fechaNacimiento', datos.fecha_nacimiento_estudiante);
        llenarCampo('correoElectronico', datos.correo_electronico);
        llenarCampo('telefonoEstudiante', datos.telefono_estudiante);
        llenarCampo('edadEstudiante', datos.edad, edad => `${edad} años`);
        llenarCampo('nombreCarrera', datos.carrera);
        llenarCampo('anioAcademico', datos.anio_academico);

        // Campos opcionales
        llenarCampo('edificio', datos.descripcion_edificio);
        llenarCampo('numeroCuarto', datos.numero_cuarto);

        // NUEVOS CAMPOS AGREGADOS - SIN DATOS EN DURO
        llenarCampo('direccionEstudiante', datos.direccion_local_barrio_colonia);
        llenarCampo('nombrePadre', datos.nombre_padre);
        llenarCampo('nombreMadre', datos.nombre_madre);

        // Opcional: Si infoAdicional es un contenedor que quieres mostrar/ocultar
        const infoAdicional = document.getElementById('infoAdicional');
        if (infoAdicional) {
            const mostrarInfo = datos.descripcion_edificio || datos.numero_cuarto;
            infoAdicional.style.display = mostrarInfo ? 'block' : 'none';
        }

        // Mostrar contenido y ocultar loader
        loadingIndicator.style.display = 'none';
        content.style.display = 'block';

        // Marcar la primera sección como completada
        actualizarEstadoPestana('seccion1-tab', true);

        // Log para debug - opcional
        console.log('Datos cargados correctamente:', {
            direccion: datos.direccion_local_barrio_colonia || 'Sin dirección',
            padre: datos.nombre_padre || 'Sin datos del padre',
            madre: datos.nombre_madre || 'Sin datos de la madre'
        });

    } catch (error) {
        console.error('Error al llenar formulario:', error);
        loadingIndicator.style.display = 'none';
        mostrarError('Error al cargar los datos del formulario');
    }
}
    // ==================== FUNCIONES PARA CARGAR CATÁLOGOS ====================
    function cargarCatalogosMotivo() {
        $.ajax({
            url: '{{ route("obtener_catalogos_motivo_consulta") }}',
            method: "GET",
            success: function (response) {
                if (response.estatus && response.catalogos) {
                    // Frecuencia de síntomas (radio buttons)
                    const frecuenciaContainer = $("#frecuenciaSintomasContainer");
                    frecuenciaContainer.empty();
                    response.catalogos.frecuencia_sintomas.forEach((frecuencia) => {
                        frecuenciaContainer.append(`
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="frecuencia_sintomas"
                                    id="frecuencia_${frecuencia.id_frecuencia_sintomas}"
                                    value="${frecuencia.id_frecuencia_sintomas}"
                                    onchange="validarSeccion2()">
                                <label class="form-check-label" for="frecuencia_${frecuencia.id_frecuencia_sintomas}">
                                    ${frecuencia.descripcion_frecuencia_sintomas}
                                </label>
                            </div>
                        `);
                    });
                    
                    // Impacto en vida diaria (checkboxes)
                    const impactoContainer = $("#impactoVidaDiariaContainer");
                    impactoContainer.empty();
                    response.catalogos.impacto_vida_diaria.forEach((impacto) => {
                        impactoContainer.append(`
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="impacto_vida_diaria[]"
                                    id="impacto_${impacto.id_impacto_vida_diaria}"
                                    value="${impacto.id_impacto_vida_diaria}"
                                    onchange="validarSeccion2()">
                                <label class="form-check-label" for="impacto_${impacto.id_impacto_vida_diaria}">
                                    ${impacto.descripcion_impacto_vida_diaria}
                                </label>
                            </div>
                        `);
                    });
                    
                    // Factores desencadenantes (checkboxes)
                    const factoresContainer = $("#factoresDesencadenantesContainer");
                    factoresContainer.empty();
                    response.catalogos.factores_desencadenantes.forEach((factor) => {
                        factoresContainer.append(`
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="factores_desencadenantes[]"
                                    id="factor_${factor.id_factores_desencadenantes}"
                                    value="${factor.id_factores_desencadenantes}"
                                    onchange="validarSeccion2()">
                                <label class="form-check-label" for="factor_${factor.id_factores_desencadenantes}">
                                    ${factor.descripcion_factores_desencadenantes}
                                </label>
                            </div>
                        `);
                    });
                    
                    // Ocultar indicador de carga y mostrar contenido
                    $('#loadingCatalogos').hide();
                    $('#motivoConsultaContent').show();
                } else {
                    mostrarError("No se pudieron cargar los catálogos del motivo de consulta");
                }
            },
            error: function () {
                mostrarError("Error al cargar los catálogos del motivo de consulta");
            }
        });
    }

    function cargarCatalogosHistorialClinico() {
        $.ajax({
            url: '{{ route("obtener_catalogos_historial_clinico_antecedentes") }}',
            method: "GET",
            success: function (response) {
                if (response.estatus && response.catalogos) {
                    const tipoTrastornoContainer = $("#tipoTrastornoContainer");
                    tipoTrastornoContainer.empty();
                    
                    // Opción "Ninguno"
                    tipoTrastornoContainer.append(`
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tipo_trastorno[]"
                                id="trastorno_ninguno" value="0"
                                onchange="if(this.checked) {
                                    $('input[name=\"tipo_trastorno[]\"]').not(this).prop('checked', false);
                                    validarSeccion3();
                                }">
                            <label class="form-check-label" for="trastorno_ninguno">
                                Ningún trastorno familiar
                            </label>
                        </div>
                    `);
                    
                    // Opciones de trastornos
                    response.catalogos.tipo_trastorno.forEach((trastorno) => {
                        tipoTrastornoContainer.append(`
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tipo_trastorno[]"
                                    id="trastorno_${trastorno.id_tipo_trastorno}"
                                    value="${trastorno.id_tipo_trastorno}"
                                    onchange="if(this.checked) {
                                        $('#trastorno_ninguno').prop('checked', false);
                                    }
                                    validarSeccion3()">
                                <label class="form-check-label" for="trastorno_${trastorno.id_tipo_trastorno}">
                                    ${trastorno.descripcion_tipo_trastorno}
                                </label>
                            </div>
                        `);
                    });
                    
                    // Antecedentes de salud mental
                    const saludMentalContainer = $("#antecedentesSaludMentalContainer");
                    saludMentalContainer.empty();
                    response.catalogos.antecedentes_salud_mental.forEach((antecedente) => {
                        saludMentalContainer.append(`
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="antecedentes_salud_mental[]"
                                    id="salud_mental_${antecedente.id_antecedentes_salud_mental}"
                                    value="${antecedente.id_antecedentes_salud_mental}"
                                    onchange="validarSeccion3()">
                                <label class="form-check-label" for="salud_mental_${antecedente.id_antecedentes_salud_mental}">
                                    ${antecedente.descripcion_antecedentes_salud_mental}
                                </label>
                            </div>
                        `);
                    });
                    
                    // Consumo de sustancias
                    const sustanciasContainer = $("#consumoSustanciasContainer");
                    sustanciasContainer.empty();
                    response.catalogos.consumo_sustancias.forEach((sustancia) => {
                        sustanciasContainer.append(`
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="consumo_sustancias[]"
                                    id="sustancia_${sustancia.id_consumo_sustancias}"
                                    value="${sustancia.id_consumo_sustancias}"
                                    onchange="validarSeccion3()">
                                <label class="form-check-label" for="sustancia_${sustancia.id_consumo_sustancias}">
                                    ${sustancia.descripcion_consumo_sustancias}
                                </label>
                            </div>
                        `);
                    });
                    
                    // Ocultar indicador de carga y mostrar contenido
                    $('#loadingCatalogos3').hide();
                    $('#historialClinicoContent').show();
                } else {
                    mostrarError("No se pudieron cargar los catálogos de historial clínico");
                }
            },
            error: function () {
                mostrarError("Error al cargar los catálogos de historial clínico");
            }
        });
    }

    function cargarCatalogosEvaluacion() {
        $.ajax({
            url: '{{ route("obtener_catalogos_evaluacion") }}',
            method: "GET",
            success: function (response) {
                if (response.estatus && response.catalogos) {
                    // Pruebas psicológicas
                    const pruebasContainer = $("#pruebasPsicologicasContainer");
                    pruebasContainer.empty();
                    response.catalogos.pruebas_psicologicas.forEach((prueba) => {
                        pruebasContainer.append(`
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="pruebas_psicologicas[]"
                                    id="prueba_${prueba.id_pruebas_psicologicas}"
                                    value="${prueba.id_pruebas_psicologicas}"
                                    onchange="validarSeccion4()">
                                <label class="form-check-label" for="prueba_${prueba.id_pruebas_psicologicas}">
                                    ${prueba.descripcion_pruebas_psicologicas}
                                </label>
                            </div>
                        `);
                    });
                    
                    // Ocultar indicador de carga y mostrar contenido
                    $('#loadingCatalogos4').hide();
                    $('#evaluacionPsicologicaContent').show();
                } else {
                    mostrarError("No se pudieron cargar los catálogos de evaluación psicológica");
                }
            },
            error: function () {
                mostrarError("Error al cargar los catálogos de evaluación psicológica");
            }
        });
    }

    function cargarCatalogosIntervencion() {
        $.ajax({
            url: '{{ route("obtener_catalogos_intervencion") }}',
            method: "GET",
            success: function (response) {
                if (response.estatus && response.catalogos) {
                    // Objetivos terapéuticos
                    const objetivosContainer = $("#objetivosTerapeuticosContainer");
                    objetivosContainer.empty();
                    response.catalogos.objetivos.forEach((objetivo) => {
                        objetivosContainer.append(`
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="objetivos_terapeuticos[]"
                                    id="objetivo_${objetivo.id_objetivos_terapeuticos}"
                                    value="${objetivo.id_objetivos_terapeuticos}"
                                    onchange="validarSeccion5()">
                                <label class="form-check-label" for="objetivo_${objetivo.id_objetivos_terapeuticos}">
                                    ${objetivo.descripcion_objetivos_terapeuticos}
                                </label>
                            </div>
                        `);
                    });
                    
                    // Estrategias de intervención
                    const estrategiasContainer = $("#estrategiasIntervencionContainer");
                    estrategiasContainer.empty();
                    response.catalogos.estrategias.forEach((estrategia) => {
                        estrategiasContainer.append(`
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="estrategias_intervencion[]"
                                    id="estrategia_${estrategia.id_estrategias_intervencion}"
                                    value="${estrategia.id_estrategias_intervencion}"
                                    onchange="validarSeccion5()">
                                <label class="form-check-label" for="estrategia_${estrategia.id_estrategias_intervencion}">
                                    ${estrategia.descripcion_estrategias_intervencion}
                                </label>
                            </div>
                        `);
                    });
                    
                    // Frecuencia de sesiones
                    const frecuenciaContainer = $("#frecuenciaSesionesContainer");
                    frecuenciaContainer.empty();
                    response.catalogos.frecuencias.forEach((frecuencia) => {
                        frecuenciaContainer.append(`
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="frecuencia_sesiones"
                                    id="frecuencia_${frecuencia.id_frecuencia_sesiones}"
                                    value="${frecuencia.id_frecuencia_sesiones}"
                                    onchange="validarSeccion5()">
                                <label class="form-check-label" for="frecuencia_${frecuencia.id_frecuencia_sesiones}">
                                    ${frecuencia.descripcion_frecuencia_sesiones}
                                </label>
                            </div>
                        `);
                    });
                    
                    // Tipos de terapias
                    const terapiasContainer = $("#tiposTerapiasContainer");
                    terapiasContainer.empty();
                    response.catalogos.terapias.forEach((terapia) => {
                        terapiasContainer.append(`
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tipos_terapias[]"
                                    id="terapia_${terapia.id_tipos_terapias}"
                                    value="${terapia.id_tipos_terapias}"
                                    onchange="validarSeccion5()">
                                <label class="form-check-label" for="terapia_${terapia.id_tipos_terapias}">
                                    ${terapia.descripcion_tipos_terapias}
                                </label>
                            </div>
                        `);
                    });
                    
                    // Ocultar indicador de carga y mostrar contenido
                    $('#loadingCatalogos5').hide();
                    $('#planIntervencionContent').show();
                } else {
                    mostrarError("No se pudieron cargar los catálogos de plan de intervención");
                }
            },
            error: function () {
                mostrarError("Error al cargar los catálogos de plan de intervención");
            }
        });
    }

    function cargarProfesionales() {
        $.ajax({
            url: '{{ route("obtener_catalogos_profesional") }}',
            method: "GET",
            beforeSend: function() {
                $('#loadingProfesionales').show();
                $('#asignacionProfesionalContent').hide();
                $('#profesionalesContainer').html('<div class="text-center py-3">Cargando profesionales...</div>');
            },
            success: function(response) {
                if (response.estatus) {
                    const profesionalesContainer = $("#profesionalesContainer");
                    profesionalesContainer.empty();
                    
                    if (response.data && response.data.length > 0) {
                        // Agregar título descriptivo
                        profesionalesContainer.append(`
                            <div class="mb-3 text-muted">
                                <small>Seleccione el profesional que realizará la evaluación:</small>
                            </div>
                        `);
                        
                        // Agregar cada profesional con radio button
                        response.data.forEach((profesional) => {
                            profesionalesContainer.append(`
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="profesional_responsable"
                                        id="profesional_${profesional.id_empleado}"
                                        value="${profesional.id_empleado}"
                                        onchange="actualizarIdEmpleado(${profesional.id_empleado}); validarSeccion7()"
                                        required>
                                    <label class="form-check-label" for="profesional_${profesional.id_empleado}">
                                        ${profesional.nombre_completo}
                                    </label>
                                </div>
                            `);
                        });
                        
                        // Si solo hay un profesional, seleccionarlo automáticamente
                        if (response.data.length === 1) {
                            $(`#profesional_${response.data[0].id_empleado}`).prop('checked', true);
                            actualizarIdEmpleado(response.data[0].id_empleado);
                            validarSeccion7();
                        }
                    } else {
                        profesionalesContainer.html(`
                            <div class="alert alert-warning">
                                ${response.mensaje || "No se encontraron profesionales disponibles"}
                            </div>
                        `);
                    }
                } else {
                    $('#profesionalesContainer').html(`
                        <div class="alert alert-danger">
                            ${response.mensaje || "Error al cargar los profesionales"}
                        </div>
                    `);
                }
            },
            error: function(xhr) {
                let errorMsg = "Error al cargar los profesionales. Intente nuevamente.";
                if (xhr.responseJSON && xhr.responseJSON.mensaje) {
                    errorMsg = xhr.responseJSON.mensaje;
                }
                $('#profesionalesContainer').html(`
                    <div class="alert alert-danger">
                        ${errorMsg}
                    </div>
                `);
            },
            complete: function() {
                $('#loadingProfesionales').hide();
                $('#asignacionProfesionalContent').show();
            }
        });
    }

        // ==================== FUNCIONES PARA MANEJO DE CLÍNICAS ====================
    /**
     * Función para cargar la lista de clínicas desde el servidor
     */
    function cargarClinicas() {
        const loadingClinicas = document.getElementById('loadingClinicas');
        const clinicasRadioContainer = document.getElementById('clinicasRadioContainer');
        
        // Mostrar indicador de carga
        loadingClinicas.style.display = 'block';
        clinicasRadioContainer.style.display = 'none';
        
        $.ajax({
            url: '/psicologia/catalogos-clinica',
            method: 'GET',
            success: function(response) {
                console.log('Respuesta de clínicas:', response);
                
                if (response.estatus && response.data) {
                    // Limpiar contenedor
                    clinicasRadioContainer.innerHTML = '';
                    
                    if (response.data.length > 0) {
                        // Agregar cada clínica como radio button
                        response.data.forEach((clinica) => {
                            const radioHtml = `
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="clinica_seleccionada"
                                        id="clinica_${clinica.id_clinica}"
                                        value="${clinica.id_clinica}"
                                        onchange="seleccionarClinica(${clinica.id_clinica})">
                                    <label class="form-check-label" for="clinica_${clinica.id_clinica}">
                                        ${clinica.descripcion_clinica}
                                    </label>
                                </div>
                            `;
                            clinicasRadioContainer.insertAdjacentHTML('beforeend', radioHtml);
                        });
                    } else {
                        clinicasRadioContainer.innerHTML = `
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                No hay clínicas disponibles en este momento.
                            </div>
                        `;
                    }
                    
                    // Ocultar loading y mostrar contenido
                    loadingClinicas.style.display = 'none';
                    clinicasRadioContainer.style.display = 'block';
                    
                } else {
                    mostrarErrorClinicas(response.mensaje || 'No se pudieron cargar las clínicas');
                }
            },
            error: function(xhr) {
                console.error('Error al cargar clínicas:', xhr);
                let errorMsg = 'Error al cargar las clínicas. Intente nuevamente.';
                
                if (xhr.responseJSON && xhr.responseJSON.mensaje) {
                    errorMsg = xhr.responseJSON.mensaje;
                }
                
                mostrarErrorClinicas(errorMsg);
            }
        });
    }

    /**
     * Función para manejar la selección de una clínica
     * @param {number} idClinica - ID de la clínica seleccionada
     */
    function seleccionarClinica(idClinica) {
        console.log('Clínica seleccionada:', idClinica);
        
        // Actualizar el campo oculto con el ID de la clínica seleccionada
        const idClinicaSelected = document.getElementById('id_clinica_selected');
        if (idClinicaSelected) {
            idClinicaSelected.value = idClinica;
            console.log('Campo id_clinica_selected actualizado:', idClinicaSelected.value);
        }
        
        // Revalidar sección para habilitar botón siguiente
        validarSeccion5();
    }

    /**
     * Función para mostrar errores al cargar clínicas
     * @param {string} mensaje - Mensaje de error
     */
    function mostrarErrorClinicas(mensaje) {
        const loadingClinicas = document.getElementById('loadingClinicas');
        const clinicasRadioContainer = document.getElementById('clinicasRadioContainer');
        
        loadingClinicas.style.display = 'none';
        clinicasRadioContainer.style.display = 'block';
        
        clinicasRadioContainer.innerHTML = `
            <div class="alert alert-danger mb-0">
                <i class="fas fa-exclamation-triangle me-2"></i>
                ${mensaje}
                <br>
                <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="cargarClinicas()">
                    <i class="fas fa-redo me-1"></i>
                    Reintentar
                </button>
            </div>
        `;
    }


    function obtenerDatosClinicaParaGuardado() {
        const derivacionSi = document.getElementById('derivacion_si');
        const derivacionNo = document.getElementById('derivacion_no');
        const idClinicaSelected = document.getElementById('id_clinica_selected');
        
        let derivacionValue = '0'; // Por defecto No
        if (derivacionSi && derivacionSi.checked) {
            derivacionValue = '1';
        } else if (derivacionNo && derivacionNo.checked) {
            derivacionValue = '0';
        }
        
        // Solo enviar id_clinica si derivación es "Sí" y hay una clínica seleccionada
        const idClinica = (derivacionValue === '1' && idClinicaSelected?.value) ? idClinicaSelected.value : null;
        
        console.log('Datos clínica para guardado:', {
            derivacion_servicios: derivacionValue,
            id_clinica: idClinica
        });
        
        return {
            derivacion_servicios: derivacionValue,
            id_clinica: idClinica
        };
    }


        /**
        * Función para mostrar/ocultar el contenedor de clínicas según la derivación seleccionada
        */
    function toggleClinicasContainer() {
        const derivacionSi = document.getElementById('derivacion_si');
        const derivacionNo = document.getElementById('derivacion_no');
        const clinicasContainer = document.getElementById('clinicasContainer');
        const idClinicaSelected = document.getElementById('id_clinica_selected');
        
        console.log('Toggle clínicas - Derivación Sí:', derivacionSi?.checked, 'Derivación No:', derivacionNo?.checked);
        
        if (derivacionSi && derivacionSi.checked) {
            // Mostrar contenedor de clínicas
            clinicasContainer.style.display = 'block';
            
            // Cargar clínicas si no se han cargado aún
            const clinicasRadioContainer = document.getElementById('clinicasRadioContainer');
            if (clinicasRadioContainer.children.length === 0) {
                console.log('Cargando clínicas...');
                cargarClinicas();
            }
        } else {
            // Ocultar contenedor de clínicas
            clinicasContainer.style.display = 'none';
            
            // Limpiar selección de clínica
            const clinicasRadios = document.querySelectorAll('input[name="clinica_seleccionada"]');
            clinicasRadios.forEach(radio => radio.checked = false);
            
            // Limpiar campo oculto
            if (idClinicaSelected) {
                idClinicaSelected.value = '';
                console.log('Campo id_clinica_selected limpiado');
            }
        }
        
        // Revalidar sección
        validarSeccion5();
    }

    // Función para actualizar el ID del empleado en el formulario
    function actualizarIdEmpleado(idEmpleado) {
        $('#id_empleado').val(idEmpleado);
    }

    // Llamar a validarSeccion7 cuando cambie cualquier radio button
    $(document).on('change', 'input[name="profesional_responsable"]', validarSeccion7);

    // ==================== FUNCIÓN PARA GUARDAR TODO EL FORMULARIO ====================
    async function guardarFormularioCompleto() {
        const $btn = $('#btnGuardarFormulario');
        const textoOriginal = $btn.html();
        
        try {
            // Deshabilitar botón y mostrar loader
            $btn.prop("disabled", true).html(
                '<span class="spinner-border spinner-border-sm"></span> Guardando...'
            );
            
            // Validación general del formulario
            if (!validarFormularioCompleto()) {
                await Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor complete todos los campos obligatorios en todas las secciones'
                });
                return;
            }
            
            // Validar profesional seleccionado
            const idEmpleado = $('#id_empleado').val();
            if (!idEmpleado) {
                await Swal.fire({
                    icon: 'warning',
                    title: 'Profesional requerido',
                    text: 'Debe seleccionar un profesional responsable'
                });
                return;
            }
            
            // OBJETO CORREGIDO PARA COINCIDIR CON BACKEND
            const formData = {
                id_cita: $('#idCita').val(),
                id_empleado: idEmpleado,
                
                // SECCIÓN II: Motivo de consulta
                motivo_consulta: {
                    descripcion: $('#motivoPrincipal').val().trim() || '',
                    frecuencia_sintomas: $('input[name="frecuencia_sintomas"]:checked').val() || null,
                    impacto_vida_diaria: $('input[name="impacto_vida_diaria[]"]:checked').map(function() {
                        return this.value;
                    }).get(),
                    factores_desencadenantes: $('input[name="factores_desencadenantes[]"]:checked').map(function() {
                        return this.value;
                    }).get()
                },
                
                // SECCIÓN III: Historial clínico
                historial_clinico: {
                    tipo_trastorno: $('input[name="tipo_trastorno[]"]:checked').map(function() {
                        return this.value;
                    }).get(),
                    antecedentes_salud_mental: $('input[name="antecedentes_salud_mental[]"]:checked').map(function() {
                        return this.value;
                    }).get(),
                    consumo_sustancias: $('input[name="consumo_sustancias[]"]:checked').map(function() {
                        return this.value;
                    }).get()
                },
                
                // SECCIÓN IV: Evaluación psicológica - CORREGIDO
                evaluacion_psicologica: {
                    observaciones_clinicas: $('#observacionesClinicas').val().trim() || '', // Esto irá a diagnostico
                    otros_criterios: $('#otrosCriterios').val().trim() || '',
                    resultados_pruebas: $('#resultadosPruebas').val().trim() || '',
                    pruebas_psicologicas: $('input[name="pruebas_psicologicas[]"]:checked').map(function() {
                        return this.value;
                    }).get()
                },
                
                // SECCIÓN V: Plan de intervención - MODIFICADA PARA INCLUIR CLÍNICAS
                plan_intervencion: {
                    objetivos_terapeuticos: $('input[name="objetivos_terapeuticos[]"]:checked').map(function() {
                        return this.value;
                    }).get(),
                    estrategias_intervencion: $('input[name="estrategias_intervencion[]"]:checked').map(function() {
                        return this.value;
                    }).get(),
                    frecuencia_sesiones: $('input[name="frecuencia_sesiones"]:checked').val() || null,
                    tipos_terapias: $('input[name="tipos_terapias[]"]:checked').map(function() {
                        return this.value;
                    }).get(),
                    derivacion_servicios: $('input[name="derivacion_servicios"]:checked').val() || '0',
                    id_clinica: (() => {
                        const derivacionSi = document.getElementById('derivacion_si');
                        const idClinicaSelected = document.getElementById('id_clinica_selected');
                        
                        // Solo enviar id_clinica si derivación es "Sí" y hay una clínica seleccionada
                        if (derivacionSi && derivacionSi.checked && idClinicaSelected?.value) {
                            return parseInt(idClinicaSelected.value);
                        }
                        return null;
                    })()
                },
                
                // SECCIÓN VI: Seguimiento y evolución - CORREGIDO
                seguimiento_evolucion: {
                    historial: $('#historialSeguimiento').val().trim() || '',
                    resultados_obtenidos: $('#resultadosObtenidos').val().trim() || '', // MANTENER CON 'S' para que sysunag lo mapee correctamente
                    recomendaciones: $('#recomendaciones').val().trim() || '',
                    criterios_cumplidos: $('input[name="criterios_cumplidos"]:checked').val() === 'true'
                },
                
                _token: $('meta[name="csrf-token"]').attr('content')
            };
            
            // Enviar datos usando AJAX de jQuery
            const response = await $.ajax({
                url: `/psicologia/citas/${formData.id_cita}/evaluacion`,
                method: 'POST',
                data: JSON.stringify(formData),
                contentType: 'application/json',
                dataType: 'json'
            });
            
            if (response.estatus === true) {
                await Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    html: response.mensaje || 'Evaluación guardada correctamente',
                    confirmButtonText: 'Aceptar'
                });
                
                // Redirigir al calendario
                window.location.href = "{{ route('calendario_citas') }}"; // Ajustar ruta según tu aplicación
            } else {
                throw new Error(response.mensaje || 'Error al guardar la evaluación');
            }
            
        } catch (error) {
            console.error('Error:', error);
            let errorMessage = "Error desconocido";
            
            if (error.responseJSON) {
                errorMessage = error.responseJSON.mensaje ||
                            error.responseJSON.msgError ||
                            error.responseJSON.message ||
                            "Error en el servidor";
            } else if (error.message) {
                errorMessage = error.message;
            }
            
            await Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage,
                confirmButtonText: 'Entendido'
            });
            
        } finally {
            // Restaurar botón
            $btn.prop("disabled", false).html(textoOriginal);
        }
    }

    // ==================== FUNCIONES DE UTILIDAD ====================
    function mostrarErrorValidacion(mensaje) {
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: mensaje
        });
    }

    function mostrarError(mensaje) {
        const loadingIndicator = document.getElementById('loadingIndicator');
        if (loadingIndicator) {
            loadingIndicator.innerHTML = `
                <div class="alert alert-danger border-0 shadow-sm">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div><strong>Error:</strong> ${mensaje}</div>
                    </div>
                </div>`;
        } else {
            Swal.fire('Error', mensaje, 'error');
        }
    }

    // ==================== FUNCIONES DE VER HISTORIAL - VERSIÓN MEJORADA ====================
    const btnVerHistorial = document.getElementById('btnVerHistorial');

    // Configuración de idioma para DataTables
    var languageOptionsDatatables = {
        "decimal": "",
        "emptyTable": "Datos no disponibles",
        "info": "Mostrando desde _START_ a _END_ de _TOTAL_ registros",
        "infoEmpty": "Mostrando desde 0 a 0 de 0 registros",
        "infoFiltered": "(Filtrado de _MAX_ registros totales)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ registros",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        },
        "aria": {
            "sortAscending": ": activar ordenamiento por columna ascendente",
            "sortDescending": ": activar ordenamiento por columna descendente"
        }
    };

    // Verificar si el botón existe
    if (btnVerHistorial) {
        btnVerHistorial.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Inicializar el modal cada vez que se hace click
            const modalHistorial = new bootstrap.Modal(document.getElementById('modalHistorialClinico'));
            
            // Mostrar el modal inmediatamente
            modalHistorial.show();
            
            // Luego cargar los datos
            cargarHistorialClinico().catch(error => {
                console.error('Error al cargar historial:', error);
                mostrarErrorModal('No se pudo cargar el historial. Intente nuevamente.');
            });
        });
    }

    /**
     * Función mejorada para cargar el historial clínico
     */
    async function cargarHistorialClinico() {
        const loadingHistorial = document.getElementById('loadingHistorial');
        const contenidoHistorial = document.getElementById('contenidoHistorial');
        
        // Verificar elementos requeridos
        if (!loadingHistorial || !contenidoHistorial) {
            console.error('Elementos del modal no encontrados');
            mostrarErrorModal('Error en la interfaz del modal');
            return;
        }
        
        // Obtener número de registro
        const numeroRegistroElement = document.getElementById('numeroRegistroAsignado');
        if (!numeroRegistroElement) {
            console.error('Campo numeroRegistroAsignado no encontrado');
            mostrarErrorModal('No se encontró el número de registro del estudiante');
            return;
        }
        
        const numeroRegistro = numeroRegistroElement.value?.trim();
        if (!numeroRegistro) {
            mostrarErrorModal('Número de registro no disponible. Recargue la página.');
            return;
        }
        
        // Mostrar loading y ocultar contenido
        loadingHistorial.style.display = 'block';
        contenidoHistorial.style.display = 'none';
        
        try {
            const response = await fetch(`/psicologia/historial/${numeroRegistro}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });
            
            if (!response.ok) {
                const errorText = await response.text();
                console.error('Error de respuesta:', response.status, errorText);
                throw new Error(`Error del servidor (${response.status}). Contacte al administrador.`);
            }
            
            const data = await response.json();
            console.log('Datos recibidos:', data);
            
            loadingHistorial.style.display = 'none';
            
            if (data.estatus === true) {
                llenarTablaHistorial(data.historial);
                contenidoHistorial.style.display = 'block';
            } else {
                throw new Error(data.mensaje || 'No se pudo obtener el historial');
            }
            
        } catch (error) {
            loadingHistorial.style.display = 'none';
            console.error('Error al cargar historial:', error);
            
            let mensajeError = 'Error al cargar el historial clínico';
            if (error.message.includes('Failed to fetch')) {
                mensajeError = 'Error de conexión. Verifique su internet.';
            } else if (error.message) {
                mensajeError = error.message;
            }
            
            mostrarErrorModal(mensajeError);
            throw error;
        }
    }

    /**
     * Función mejorada para llenar la tabla de historial con estilos aplicados
     * @param {Array} historial - Array con los datos del historial
     */
    function llenarTablaHistorial(historial) {
        const tbody = document.getElementById('cuerpoTablaHistorial');
        if (!tbody) {
            console.error('Elemento cuerpoTablaHistorial no encontrado');
            return;
        }
        
        // Destruir DataTable existente si ya está inicializado
        if ($.fn.DataTable.isDataTable('#tablaHistorial')) {
            $('#tablaHistorial').DataTable().destroy();
        }
        
        // Limpiar contenido previo
        tbody.innerHTML = '';
        
        // Verificar si hay datos
        if (!historial || !Array.isArray(historial) || historial.length === 0) {
            tbody.innerHTML = `
                <tr style="color: black; background-color: buttonhighlight; font-size: large;">
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="fas fa-info-circle fs-1 text-success mb-3 d-block"></i>
                        <h5 class="text-muted">No se encontraron registros</h5>
                        <p class="mb-0">No hay historial clínico disponible para este paciente</p>
                    </td>
                </tr>`;
            return;
        }
        
        // Llenar tabla con datos
        historial.forEach((registro, index) => {
            try {
                const fila = document.createElement('tr');
                fila.style.color = 'black';
                fila.style.backgroundColor = 'buttonhighlight';
                fila.style.fontSize = 'large';
                
                fila.innerHTML = `
                    <td style="text-align: center; vertical-align: middle;">
                        ${registro.id_cita || 'N/A'}
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        ${registro.numero_registro_cita || 'N/A'}
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        ${registro.numero_registro_asignado || 'N/A'}
                    </td>
                    <td style="text-align: left; vertical-align: middle;">
                        ${registro.nombre_estudiante || registro.Nombre_Estudiante || 'N/A'}
                    </td>
                    <td style="text-align: left; vertical-align: middle;">
                        ${registro.nombre_profesional || 'No asignado'}
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        ${formatearFecha(registro.fecha_evaluacion)}
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        <button type="button" class="btn btn-outline-success btn-sm" 
                                onclick="verDetalleCita(${registro.id_cita})" 
                                title="Ver detalles de la cita">
                            Ver
                        </button>
                    </td>`;
                
                tbody.appendChild(fila);
            } catch (error) {
                console.error(`Error al procesar registro ${index}:`, error, registro);
            }
        });
        
        // Inicializar DataTable con configuración mejorada
        $('#tablaHistorial').DataTable({
            language: languageOptionsDatatables,
            responsive: true,
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
            order: [[5, 'desc']], // Ordenar por fecha descendente
            columnDefs: [
                { orderable: false, targets: [6] }, // Desactivar ordenamiento en columna de acciones
                { width: "8%", targets: [0] }, // ID Cita
                { width: "12%", targets: [1] }, // Número de Cita
                { width: "12%", targets: [2] }, // Número de Registro
                { width: "25%", targets: [3] }, // Nombre Completo
                { width: "25%", targets: [4] }, // Profesional
                { width: "13%", targets: [5] }, // Fecha
                { width: "5%", targets: [6] } // Acciones
            ],
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            drawCallback: function() {
                // Aplicar estilos a las filas después de cada redibujado
                $('#tablaHistorial tbody tr').each(function() {
                    $(this).css({
                        'color': 'black',
                        'background-color': 'buttonhighlight',
                        'font-size': 'large'
                    });
                });
            }
        });
    }

   /**
 * Función para ver detalles de una cita específica
 * @param {number} idCita - ID de la cita
 */
function verDetalleCita(idCita) {
    console.log('Ver detalle de cita ID:', idCita);
    
    // Validar que el ID de cita sea válido
    if (!idCita || idCita === '' || isNaN(idCita)) {
        alert('ID de cita no válido');
        return;
    }
    
    // Abrir en nueva pestaña
    window.open(`/psicologia/estudiante-historial/${idCita}/1`, '_blank');
}
    // ==================== FUNCIONES AUXILIARES PARA HISTORIAL ====================

    /**
     * Formatea una fecha al formato deseado
     * @param {string} fecha - Fecha en formato ISO o timestamp
     * @returns {string} - Fecha formateada
     */
    function formatearFecha(fecha) {
        try {
            if (!fecha) return 'N/A';
            
            const fechaObj = new Date(fecha);
            
            // Verificar si la fecha es válida
            if (isNaN(fechaObj.getTime())) {
                return 'Fecha inválida';
            }
            
            // Formatear fecha como DD/MM/YYYY HH:MM
            const dia = fechaObj.getDate().toString().padStart(2, '0');
            const mes = (fechaObj.getMonth() + 1).toString().padStart(2, '0');
            const anio = fechaObj.getFullYear();
            const horas = fechaObj.getHours().toString().padStart(2, '0');
            const minutos = fechaObj.getMinutes().toString().padStart(2, '0');
            
            return `${dia}/${mes}/${anio} ${horas}:${minutos}`;
        } catch (error) {
            console.error('Error al formatear fecha:', error);
            return 'Error en fecha';
        }
    }

    /**
     * Muestra un mensaje de error en modal
     * @param {string} mensaje - Mensaje de error a mostrar
     */
    function mostrarErrorModal(mensaje) {
        try {
            // Ocultar el loading si existe
            const loadingHistorial = document.getElementById('loadingHistorial');
            if (loadingHistorial) {
                loadingHistorial.style.display = 'none';
            }
            
            // Mostrar error en el contenido del modal
            const contenidoHistorial = document.getElementById('contenidoHistorial');
            if (contenidoHistorial) {
                contenidoHistorial.style.display = 'block';
                contenidoHistorial.innerHTML = `
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div>
                            <strong>Error:</strong> ${mensaje}
                        </div>
                    </div>
                    <div class="text-center py-3">
                        <button type="button" class="btn btn-primary" onclick="reintentar()">
                            <i class="fas fa-redo me-1"></i>
                            Reintentar
                        </button>
                    </div>
                `;
            } else {
                alert(`Error: ${mensaje}`);
            }
        } catch (error) {
            console.error('Error al mostrar modal de error:', error);
            alert(`Error: ${mensaje}`);
        }
    }

    /**
     * Función para reintentar la carga del historial
     */
    function reintentar() {
        cargarHistorialClinico().catch(error => {
            console.error('Error al reintentar:', error);
            mostrarErrorModal('No se pudo cargar el historial. Verifique su conexión.');
        });
    }

    /**
     * Función para mostrar errores generales
     * @param {string} mensaje - Mensaje de error
     */
    function mostrarError(mensaje) {
        console.error('Error:', mensaje);
        
        // Buscar un contenedor de alertas existente
        let alertContainer = document.getElementById('alertContainer');
        if (!alertContainer) {
            // Crear contenedor si no existe
            alertContainer = document.createElement('div');
            alertContainer.id = 'alertContainer';
            alertContainer.className = 'position-fixed';
            alertContainer.style.cssText = 'top: 20px; right: 20px; z-index: 9999; max-width: 400px;';
            document.body.appendChild(alertContainer);
        }
        
        // Crear alerta
        const alert = document.createElement('div');
        alert.className = 'alert alert-danger alert-dismissible fade show';
        alert.innerHTML = `
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Error:</strong> ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        alertContainer.appendChild(alert);
        
        // Auto-remover después de 5 segundos
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }
</script>
@endpush
