<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Responsive Laravel Admin Dashboard Template based on Bootstrap 5">
    <meta name="author" content="NobleUI">
    <meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html,
    laravel, theme, front-end, ui kit, web">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SYS UNAG</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ url(asset('/assets/images/hoja-unag.png')) }}">

    <link href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" />
    @push('plugin-styles')
   <link href="{{ asset('assets/plugins/prismjs/prism.css') }}" rel="stylesheet" />
    @endpush
    @stack('plugin-styles')
    {{-- custom css --}}
    <link rel="stylesheet" href="{{ asset('/css/custom.css') }}" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

    @stack('style')
    </head>
    <body data-base-url="{{url('/')}}">
    <script src="{{ asset('assets/js/spinner.js') }}"></script>

    <img style="position: fixed; z-index:-10; object-fit:cover; width:100%" src="{{ asset('assets/images/fondo_blanco.jpg') }}" alt="">
    <div class="" id="app">
    <div class="">
    <div class="page-content">
    <div class="d-flex justify-content-center align-items-center" style="
    padding: 2rem;">

    <div class="bg-white p-4 p-md-5 rounded shadow" style="
    max-width: 700px;
    width: 100%;
    background-color: rgba(255, 255, 255, 0.95) !important;
    backdrop-filter: blur(5px);">
    <!-- Logo y Título Centrados -->
    <div class="text-center mb-4">
    <img src="{{ asset('assets/images/escudo.png') }}" class="mb-3" alt="Logo UNAG" style="width: 70px;">
    <h2 class="fw-bold text-primary mb-2" style="font-size: 1.8rem;">
    Trazabilidad
    </h2>
    <p class="text-verdeOscuro mb-0"><strong>SYS UNAG</strong></p>
    </div>
    <style>

        .timeline {
            max-width: 100%;
            padding-left: 50px;
            list-style: none;
            margin: 0 auto;
        }

        .timeline .event {
            position: relative;
            padding-left: 20px;
            margin-bottom: 30px;
        }

        .timeline .event:last-child {
            margin-bottom: 0;
        }

        .timeline .event:before {
        display: none !importan;
         }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7);
            }
            50% {
                transform: scale(1.1);
                box-shadow: 0 0 0 10px rgba(0, 123, 255, 0);
            }
        }

        .event-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-left: 4px solid #dee2e6;
            transition: all 0.3s ease;
        }

        .event-content:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
            transform: translateX(5px);
        }

        .event.completado .event-content {
            border-left-color: #28a745;
        }

        .event.en-proceso .event-content {
            border-left-color: #007bff;
        }

        .event.rechazado .event-content {
            border-left-color: #dc3545;
        }

        .fondo-container {
            background-image: radial-gradient(rgba(255,255,255,0.6) 0%, rgba(240,240,240,0.95) 200%),
                              url('{{ asset('assets/images/fondo_blanco.jpg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-blend-mode: multiply;
            min-height: 100vh;
            padding: 2rem 0;
        }


    </style>

          <div class="card mb-3 border">
                            <div class="card-body p-3">
                                <h6 class="card-title text-uppercase mb-3" style="font-size: 0.875rem; letter-spacing: 0.5px;">
                                    <i data-feather="info" style="width:14px;height:14px;"></i> Indicadores de Estado
                                </h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" class="btn btn-success btn-sm position-relative"
                                        data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top"
                                        data-bs-trigger="hover" data-bs-content="SOLICITUD FINALIZADA/FAVORABLE"
                                        style="width: 32px; height: 32px; padding: 0;">
                                        <i data-feather="check-circle" style="width:16px;height:16px;"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm position-relative"
                                        data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top"
                                        data-bs-trigger="hover" data-bs-content="SOLICITUD EN PROCESO"
                                        style="background-color: #203B76; color: white; width: 32px; height: 32px; padding: 0;">
                                        <i data-feather="loader" style="width:16px;height:16px;"></i>
                                    </button>

                                    <button type="button" class="btn btn-warning btn-sm position-relative"
                                        data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top"
                                        data-bs-trigger="hover" data-bs-content="EN ESPERA DE GESTION"
                                        style="width: 32px; height: 32px; padding: 0;">
                                        <i data-feather="alert-triangle" style="width:16px;height:16px;"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm position-relative"
                                        data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top"
                                        data-bs-trigger="hover" data-bs-content="ESTUDIANTE CON SALDO MORATORIO/INFAVORABLE"
                                        style="width: 32px; height: 32px; padding: 0;">
                                        <i data-feather="alert-octagon" style="width:16px;height:16px;"></i>
                                    </button>
                                     <button type="button" class="btn btn-info btn-sm position-relative"
                                        data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top"
                                        data-bs-trigger="hover" data-bs-content="INFORMATIVO"
                                        style="width: 32px; height: 32px; padding: 0;">
                                        <i data-feather="info" style="width:16px;height:16px;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
            @if(isset($error))
                            <div class="alert alert-warning text-center">
                                <i data-feather="alert-triangle" class="me-2"></i>
                                {{ $error }}
                            </div>

                            <div class="text-center mt-4">
                                <a href="/buscador/buscar" class="btn btn-primary">
                                    <i data-feather="arrow-left" class="me-1"></i> Volver al Buscador
                                </a>
                            </div>
                        @elseif(isset($trazabilidad) && !is_null($trazabilidad))
                             <?php
                                // Solo determinar si está abierto o cerrado
                                $saldoPendiente = $trazabilidad->saldo_pendiente ?? 0;
                                $estadoReal = 'Abierto';
                                $estadoClase = 'primary';

                                // Revisar si todas las evaluaciones están cerradas
                                if(isset($trazabilidad->historial_evaluaciones) && $trazabilidad->historial_evaluaciones) {
                                    $todasCerradas = true;

                                    foreach($trazabilidad->historial_evaluaciones as $eval) {
                                        if($eval->estado != 'Cerrado') {
                                            $todasCerradas = false;
                                            break;
                                        }
                                    }

                                    if($todasCerradas) {
                                        $estadoReal = 'Cerrado';
                                        $estadoClase = 'success';
                                    }
                                } else {
                                    // Si no hay evaluaciones aún, está abierto
                                    $estadoReal = 'Abierto';
                                    $estadoClase = 'primary';
                                }
                             ?>
                        <!-- Información General -->
                            <div class="card border-primary mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0 text-white">
                                        <i data-feather="user" class="me-2 text-white"></i>
                                        Información del Estudiante
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Nombre:</strong> {{ $trazabilidad->nombre_completo ?? 'N/A' }}</p>
                                            <p class="mb-2"><strong>Identidad:</strong> {{ $trazabilidad->identidad ?? 'N/A' }}</p>
                                            <p class="mb-0"><strong>Carrera:</strong> {{ $trazabilidad->carrera ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-2"><strong>Fecha de Solicitud:</strong>
                                                @if(isset($trazabilidad->fecha_solicitud))
                                                    {{ \Carbon\Carbon::parse($trazabilidad->fecha_solicitud)->format('d/m/Y H:i') }}
                                                @else
                                                    N/A
                                                @endif
                                            </p>
                                        <p class="mb-2">
                                                <strong>Estado:</strong>
                                                <span class="badge bg-{{ $estadoClase }} text-white">
                                                    {{ $estadoReal }}
                                                </span>
                                            </p>
                                            <p class="mb-2">
                                                <strong>Saldo Pendiente:</strong>
                                                @if($saldoPendiente > 0)
                                                    <span class="text-danger fw-bold">L. {{ number_format($saldoPendiente, 2) }}</span>
                                                @else
                                                    <span class="text-success fw-bold">L. 0.00</span>
                                                @endif
                                            </p>

                                            @if(isset($trazabilidad->periodo_academico) && $trazabilidad->periodo_academico)
                                                <p class="mb-0"><strong>Periodo Asignado:</strong> Periodo {{ $trazabilidad->periodo_academico }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    @if(isset($trazabilidad->tipo_beca) && $trazabilidad->tipo_beca)
                                        <hr>
                                        <div class="alert alert-info mb-0">
                                            <h6 class="alert-heading">
                                                <i data-feather="award" class="me-1"></i>
                                                Beca Asignada
                                            </h6>
                                            <p class="mb-1"><strong>Tipo:</strong> {{ $trazabilidad->tipo_beca }}</p>
                                            <p class="mb-1"><strong>Descripción:</strong> {{ $trazabilidad->descripcion_beca ?? 'N/A' }}</p>
                                            <p class="mb-0"><strong>Monto:</strong> L. {{ number_format($trazabilidad->monto_beca ?? 0, 2) }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Timeline de Proceso -->
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i data-feather="git-commit" class="me-2"></i>
                                        Historial del Proceso
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <ul class="timeline">
                                        <!-- Evento 1: Solicitud Recibida -->
                                        <li class="event completado">
                                            <div class="event-content">
                                                <h5 class="mb-2">
                                                    <i data-feather="file-plus" class="me-2"></i>
                                                    Solicitud Recibida
                                                </h5>
                                                <p class="mb-2 text-muted">
                                                    <i data-feather="calendar" class="me-1" style="width:16px;"></i>
                                                    @if(isset($trazabilidad->fecha_solicitud))
                                                        {{ \Carbon\Carbon::parse($trazabilidad->fecha_solicitud)->format('d/m/Y') }}
                                                        <i data-feather="clock" class="ms-3 me-1" style="width:16px;"></i>
                                                        {{ \Carbon\Carbon::parse($trazabilidad->fecha_solicitud)->format('h:i A') }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </p>
                                                <p class="mb-0">Su solicitud de reingreso ha sido registrada exitosamente en el sistema.</p>
                                            </div>
                                        </li>

                                        @if(isset($trazabilidad->historial_evaluaciones) && $trazabilidad->historial_evaluaciones && count($trazabilidad->historial_evaluaciones) > 0)
                                            @foreach($trazabilidad->historial_evaluaciones as $index => $evaluacion)
                                                <li class="event
                                                    @if($evaluacion->estado == 'Cerrado') completado
                                                    @elseif($evaluacion->resultado == 'Infavorable') rechazado
                                                    @else en-proceso
                                                    @endif">
                                                    <div class="event-content">
                                                        <h5 class="mb-2">
                                                            <i data-feather="@if($evaluacion->orden == 2) user-check @else shield @endif" class="me-2"></i>
                                                            Evaluación - {{ $evaluacion->nivel }}
                                                        </h5>
                                                        <p class="mb-2 text-muted">
                                                            <i data-feather="calendar" class="me-1" style="width:16px;"></i>
                                                            {{ \Carbon\Carbon::parse($evaluacion->fecha_evaluacion)->format('d/m/Y') }}
                                                            <i data-feather="clock" class="ms-3 me-1" style="width:16px;"></i>
                                                            {{ \Carbon\Carbon::parse($evaluacion->fecha_evaluacion)->format('h:i A') }}
                                                        </p>
                                                        <p class="mb-2">
                                                            <strong>Evaluado por:</strong> {{ $evaluacion->evaluador }}
                                                        </p>
                                                        <p class="mb-2">
                                                            <strong>Resultado:</strong>
                                                           <span class="badge text-white
                                                                @if($evaluacion->resultado == 'Favorable') bg-success
                                                                @elseif($evaluacion->resultado == 'Infavorable') bg-danger
                                                                @else bg-warning
                                                                @endif">
                                                                {{ $evaluacion->resultado }}
                                                            </span>
                                                        </p>
                                                        <div class="bg-light p-3 rounded">
                                                            <strong>Observaciones:</strong>
                                                            <p class="mb-0 mt-2">{{ $evaluacion->descripcion }}</p>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif

                                        <!-- Evento Final -->
                                        @if(isset($trazabilidad->fecha_aprobacion) && $trazabilidad->fecha_aprobacion)
                                            <li class="event completado">
                                                <div class="event-content">
                                                    <h5 class="mb-2">
                                                        <i data-feather="check-circle" class="me-2"></i>
                                                        Solicitud Finalizada
                                                    </h5>
                                                    <p class="mb-2 text-muted">
                                                        <i data-feather="calendar" class="me-1" style="width:16px;"></i>
                                                        {{ \Carbon\Carbon::parse($trazabilidad->fecha_aprobacion)->format('d/m/Y') }}
                                                        <i data-feather="clock" class="ms-3 me-1" style="width:16px;"></i>
                                                        {{ \Carbon\Carbon::parse($trazabilidad->fecha_aprobacion)->format('h:i A') }}
                                                    </p>
                                                    <p class="mb-2">
                                                        <strong>Aprobado por:</strong> {{ $trazabilidad->nombre_aprobador ?? 'Sistema' }}
                                                    </p>
                                                    @if(isset($trazabilidad->observacion_final) && $trazabilidad->observacion_final)
                                                        <div class="alert alert-success mb-0">
                                                            <strong>Observación Final:</strong>
                                                            <p class="mb-0 mt-2">{{ $trazabilidad->observacion_final }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </li>
                                        @elseif(isset($trazabilidad->id_estado_solicitud) && $trazabilidad->id_estado_solicitud != 2)
                                            <li class="event en-proceso">
                                                <div class="event-content">
                                                    <h5 class="mb-2">
                                                        <i data-feather="loader" class="me-2"></i>
                                                        En Espera de Aprobación Final
                                                    </h5>
                                                    <p class="mb-0">Su solicitud está siendo procesada.</p>
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <a href="/buscador/buscar" class="btn btn-primary btn-lg">
                                    <i data-feather="arrow-left" class="me-1"></i> Volver al Buscador
                                </a>
                            </div>
                        @endif

                        <!-- Logo SETIC -->
                        <div class="text-center mt-4">
                            <img src="{{ asset('assets/images/logo_setic_new.png') }}" class="mb-3" alt="Logo SETIC" style="width: 140px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('assets/plugins/feather-icons/feather.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Inicializar Feather Icons con validación
         document.addEventListener('DOMContentLoaded', function () {
        if (!window.feather) return;

        document.querySelectorAll('[data-feather]').forEach(el => {
            try {
                feather.replace();
            } catch (e) {
                el.remove();
            }
        });
        });
    </script>
    @push('plugin-scripts')
    <script src="{{ asset('assets/plugins/prismjs/prism.js') }}"></script>
    <script src="{{ asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    @endpush
    <script>
document.addEventListener('DOMContentLoaded', function () {
    var popoverTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="popover"]')
    );

    popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
});
</script>
    </body>
</html>
