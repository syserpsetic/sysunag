@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<style>
    .file-upload {
      border: 2px dashed #ccc;
      border-radius: 10px;
      padding: 20px;
      text-align: center;
      cursor: pointer;
      transition: 0.2s;
    }
    .file-upload:hover {
      background-color: #f9f9f9;
    }
    .file-list {
      margin-top: 15px;
    }
    .file-item {
      background: #f2f2f2;
      border-radius: 6px;
      padding: 8px 12px;
      margin-bottom: 5px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 14px;
    }
    .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }
    table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control::before {
        position: relative !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        vertical-align: middle !important;
        top: auto !important;
        left: auto !important;
        margin: 0 8px 0 0 !important; 
        box-shadow: none !important;
    }
    .tooltip-inner {
        color: #ffffff !important;
    }
</style>

@php 
    $esta_graduado = (isset($graduado) && $graduado != null);
@endphp

<input type="hidden" id="sys_id_proceso_graduacion" value="{{ $id_proceso_graduacion ?? '' }}">

<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="position-relative">
                <figure class="overflow-hidden mb-0 d-flex justify-content-center">
                    <img src="https://portal.unag.edu.hn/wp-content/uploads/2020/07/encabezado-rrnn.jpg" class="rounded-top" alt="profile cover" />
                </figure>
                <div class="d-flex justify-content-between align-items-center position-absolute top-90 w-100 px-2 px-md-4 mt-n4">
                    <div>
                        <img
                            class="wd-70 rounded-circle"
                            src="{{ asset('/matricula/documentos/fotos/')}}/{{$user['foto'] ?? ''}}"
                            alt="profile"
                            onerror="this.onerror=null; this.src='{{ url(asset('/assets/images/user2-403d6e88.png')) }}';"
                        />
                        <span class="h4 ms-3 text-white"><b>{{$user['nombre_completo'] ?? 'ESTUDIANTE'}}</b></span>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center p-3 rounded-bottom">
                <ul class="d-flex align-items-center m-0 p-0">
                    <li class="d-flex align-items-center">
                        <i class="me-1 icon-md" data-feather="corner-up-left"></i>
                        @php
                            $ruta_anterior = url()->previous();
                            
                            $ruta_regreso = url('secretariageneral/solicitudEstudiante');

                            if (str_contains($ruta_anterior, 'procesoGraduacion')) {
                                $ruta_regreso = url('secretariageneral/procesoGraduacion/' . ($id_proceso_graduacion ?? '') . '/estudiantes');
                            }
                        @endphp
                        
                        <a class="pt-1px d-none d-md-block text-body" id="btn_volver_estudiantes" href="{{ $ruta_regreso }}" data-toggle="tooltip" data-placement="top" title="Regresar">
                         Regresar
                        </a>
                    </li>
                    <li class="ms-3 ps-3 border-start d-flex align-items-center active">
                        <i class="me-1 icon-md text-primary" data-feather="columns"></i>
                        <a class="pt-1px d-none d-md-block text-primary" href="#">Perfil del Estudiante</a>
                    </li>
                    <li class="ms-3 ps-3 border-start d-flex align-items-center">
                        <i class="me-1 icon-md" data-feather="user"></i>
                        <a class="pt-1px d-none d-md-block text-body" href="#">About</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row profile-body">
    <div class="d-none d-md-block col-md-4 col-xl-2 left-wrapper">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="card-title mb-0">Detalles Del Estudiante</h6>
                </div>
                <p>{{$user['nombre_completo'] ?? ''}}</p>
                <div class="mt-3">
                    <label class="tx-11 fw-bolder mb-0 text-uppercase">NÚMERO DE REGISTRO:</label>
                    <p class="text-muted">{{$user['numero_registro_asignado'] ?? ''}}</p>
                </div>
                <div class="mt-3">
                    <label class="tx-11 fw-bolder mb-0 text-uppercase">NÚMERO DE IDENTIDAD:</label>
                    <p class="text-muted">{{$user['identidad_estudiante'] ?? ''}}</p>
                </div>
                <div class="mt-3">
                    <label class="tx-11 fw-bolder mb-0 text-uppercase">CORREO ELECTRÓNICO:</label>
                    <p class="text-muted">{{$user['email'] ?? ''}}</p>
                </div>
                <div class="mt-3">
                    <label class="tx-11 fw-bolder mb-0 text-uppercase">TELEFONO:</label>
                    <p class="text-muted">{{$user['telefono_estudiante'] ?? ''}}</p>
                </div>
                 <div class="mt-3">
                    <label class="tx-11 fw-bolder mb-0 text-uppercase">ID CARRERA:</label>
                    <p class="text-muted">{{$user['id_carrera'] ?? ''}}</p>
                </div>
                 <div class="mt-3">
                    <label class="tx-11 fw-bolder mb-0 text-uppercase">CARRERA:</label>
                    <p class="text-muted">{{$user['descripcion'] ?? ''}}</p>
                </div>
                <div class="mt-3">
                    <label class="tx-11 fw-bolder mb-0 text-uppercase">SECCION:</label>
                    <p class="text-muted">{{$user['etiqueta_seccion'] ?? ''}}</p>
                </div>
                <div class="mt-3">
                    <label class="tx-11 fw-bolder mb-0 text-uppercase">PERIODO:</label>
                    <p class="text-muted">{{$user['periodo_academico'] ?? ''}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-xl-8 middle-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="col-12 col-md-12 col-xl-12">
                    <div class="card border-secondary">
                        <div class="card-header bg-azul text-white d-flex justify-content-between align-items-center">
                            <h5 class="text-white mb-0"><i class="text-white icon-lg pb-3px" data-feather="list"></i> Expediente: Documentos de Validación</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="jambo_table table table-hover dt-responsive nowrap" id="tbl_documentos_perfil" border="1" style="width: 100%;">
                                    <thead class="bg-primary text-white">
                                        <tr class="headings">
                                            <th scope="col" class="text-white text-center all" style="width: 160px;">Acción</th>
                                            <th scope="col" class="text-white">Documento</th>
                                            <th scope="col" class="text-white">Observación</th>
                                            <th scope="col" class="text-white text-center">Validado / Modificado Por</th>
                                            <th scope="col" class="text-white text-center">Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($documentos) && count($documentos) > 0)
                                            @php
                                                // ORDENAR LOS DOCUMENTOS PARA QUE EL ID 1 SIEMPRE SEA EL PRIMERO
                                                $documentos_ordenados = collect($documentos)->sortBy(function($documento_orden) {
                                                    return $documento_orden['id_documento'] == 1 ? 0 : 1;
                                                })->all();
                                            @endphp

                                            @foreach ($documentos_ordenados as $documento_actual)
                                            <tr style="font-size: small;">
                                                <td class="text-center align-middle">
                                                    <div class="d-inline-flex align-items-center text-nowrap gap-2">
                                                        
                                                        @php
                                                            // SACAMOS LA VARIABLE DEL IF DE PERMISOS PARA QUE NO DE ERROR DE UNDEFINED A LOS ESTUDIANTES
                                                            $es_documento_automatico = in_array($documento_actual['id_documento'], [6, 7, 10]);
                                                        @endphp

                                                        @if(in_array('secretaria_general_validar_documento', $scopes))
                                                            @php
                                                                $permiso_del_documento = $documento_actual['nombre_permiso_requerido'] ?? null;
                                                                $falta_permiso_especifico = $permiso_del_documento && !in_array($permiso_del_documento, $scopes);
                                                                
                                                                $debe_bloquear_checkbox = $es_documento_automatico || $esta_graduado || $falta_permiso_especifico;
                                                            @endphp
                                                            
                                                            <div class="form-check form-switch mb-0" data-bs-toggle="tooltip" title="Validar / Cancelar">
                                                                <input class="form-check-input chk_validar" type="checkbox" style="cursor: pointer; width: 2.5em; height: 1.25em;" 
                                                                    data-id_doc="{{$documento_actual['id_documento']}}" 
                                                                    data-id_sol="{{$id_solicitud ?? ''}}"
                                                                    {{ (isset($documento_actual['es_completado']) && $documento_actual['es_completado'] == 1) ? 'checked' : '' }}
                                                                    {{ $debe_bloquear_checkbox ? 'disabled' : '' }}>
                                                            </div>
                                                        @endif

                                                        @php
                                                            $archivos_json = isset($documento_actual['archivos']) && $documento_actual['archivos'] != 'null' ? $documento_actual['archivos'] : '[]';
                                                            $lista_archivos = json_decode($archivos_json, true);
                                                            $cant_archivos = is_array($lista_archivos) ? count($lista_archivos) : 0;
                                                        @endphp

                                                        {{-- LÓGICA DEL BOTÓN ARCHIVOS / IMPRIMIR REPORTE --}}
                                                        @if($es_documento_automatico)
                                                            @if(in_array('secretaria_general_imprimir_solvencia', $scopes))
                                                                @if($documento_actual['id_documento'] == 10)
                                                                    <a href="{{ url('/secretariageneral/estudiantes/perfil/reporte/' . $user['numero_registro_asignado']) }}" target="_blank" class="btn btn-success btn-xs d-inline-flex align-items-center" style="padding: 4px 10px; white-space:nowrap;" data-bs-toggle="tooltip" title="Imprimir Reporte">
                                                                        <i data-feather="printer" style="width: 14px; height: 14px; margin-right: 4px;"></i> Imprimir
                                                                    </a>
                                                                @elseif($documento_actual['id_documento'] == 6) 
                                                                    <a href="{{ url('/secretariageneral/estudiantes/perfil/reporteregistro/' . $user['numero_registro_asignado']) }}" target="_blank" class="btn btn-success btn-xs d-inline-flex align-items-center" style="padding: 4px 10px; white-space:nowrap;" data-bs-toggle="tooltip" title="Imprimir Solvencia Registro">
                                                                        <i data-feather="printer" style="width: 14px; height: 14px; margin-right: 4px;"></i> Imprimir
                                                                </a>
                                                                @elseif($documento_actual['id_documento'] == 7) 
                                                                    <a href="{{ url('/secretariageneral/estudiantes/perfil/reportearchivo/' . $user['numero_registro_asignado']) }}" target="_blank" class="btn btn-success btn-xs d-inline-flex align-items-center" style="padding: 4px 10px; white-space:nowrap;" data-bs-toggle="tooltip" title="Imprimir Solvencia Archivo">
                                                                        <i data-feather="printer" style="width: 14px; height: 14px; margin-right: 4px;"></i> Imprimir
                                                                    </a>
                                                                @endif
                                                           @else
                                                                {{-- RELLENO INVISIBLE PARA MANTENER LA ESTÉTICA EXACTA --}}
                                                                <button type="button" class="btn btn-secondary btn-xs d-inline-flex align-items-center" style="padding: 4px 10px; visibility: hidden;">
                                                                    <i data-feather="folder" style="width: 14px; height: 14px; margin-right: 4px;"></i> Archivos
                                                                </button>
                                                            @endif
                                                        @else
                                                            @if(isset($documento_actual['es_completado']) && $documento_actual['es_completado'] == 1)
                                                                <button type="button" class="btn btn-warning btn-xs btn_abrir_modal d-inline-flex align-items-center" style="padding: 4px 10px;"
                                                                    data-bs-toggle="tooltip"
                                                                    data-id_doc="{{$documento_actual['id_documento']}}"
                                                                    data-id_sol="{{$id_solicitud ?? ''}}"
                                                                    data-id_val="{{$documento_actual['id_validacion'] ?? ''}}"
                                                                    data-archivos='{{$archivos_json}}'
                                                                    data-nombre="{{$documento_actual['nombre']}}"
                                                                    data-obs="{{$documento_actual['observacion'] ?? ''}}"
                                                                    data-estado="1" title="Ver / Editar Archivos">
                                                                    <i data-feather="folder" style="width: 14px; height: 14px; margin-right: 4px;"></i> Archivos
                                                                </button>
                                                            @else
                                                                <button type="button" class="btn btn-secondary btn-xs btn_abrir_modal d-inline-flex align-items-center" style="padding: 4px 10px;"
                                                                    data-bs-toggle="tooltip"
                                                                    data-id_doc="{{$documento_actual['id_documento']}}"
                                                                    data-id_sol="{{$id_solicitud ?? ''}}"
                                                                    data-id_val="{{$documento_actual['id_validacion'] ?? ''}}"
                                                                    data-archivos='{{$archivos_json}}' 
                                                                    data-nombre="{{$documento_actual['nombre']}}"
                                                                    data-obs="{{$documento_actual['observacion'] ?? ''}}"
                                                                    data-estado="0" title="Ver / Añadir Archivos">
                                                                    <i data-feather="folder" style="width: 14px; height: 14px; margin-right: 4px;"></i> Archivos
                                                                </button>
                                                            @endif
                                                        @endif

                                                        @if($documento_actual['id_documento'] == 1)
                                                            <a href="{{ asset('documentos/CONSTANCIADEVERIFICACIONDENOMBRE.pdf') }}" download="CONSTANCIA_DE_VERIFICACION_DE_NOMBRE.pdf" class="btn btn-primary btn-xs ms-1 d-inline-flex align-items-center" style="padding: 4px 10px;" data-bs-toggle="tooltip" title="Descargar Constancia">
                                                                <i data-feather="download" style="width: 14px; height: 14px;"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                                
                                                <td scope="row" class="align-middle">
                                                    {{-- ESTILO EN NEGRITA, LETRA MÁS PEQUEÑA (tx-11) --}}
                                                    <span class="tx-11 fw-bolder text-uppercase text-dark">{{$documento_actual['nombre']}}</span>
                                                    @if($cant_archivos > 0)
                                                        <br><span class="badge bg-primary mt-1" style="font-size: 10px; color: #ffffff !important;">
                                                            <i data-feather="paperclip" style="width: 12px; height: 12px; color: #ffffff !important;"></i> <span style="color: #ffffff !important;">{{ $cant_archivos }} Archivo(s)</span>
                                                        </span>
                                                    @endif
                                                </td>

                                                <td scope="row" class="align-middle text-wrap" style="max-width: 350px;">
                                                    @php
                                                        $observacion_texto = (isset($documento_actual['observacion']) && $documento_actual['observacion'] !== 'null' && $documento_actual['observacion'] !== 'undefined' && trim($documento_actual['observacion']) !== '') ? trim($documento_actual['observacion']) : '';
                                                        $palabras = array_filter(explode(' ', $observacion_texto));
                                                        $es_larga = count($palabras) > 3;
                                                        $observacion_corta = $es_larga ? implode(' ', array_slice($palabras, 0, 3)) . '...' : $observacion_texto;
                                                    @endphp
                                                    
                                                    <span>{{ $observacion_corta }}</span>
                                                    @if($es_larga)
                                                        <button type="button" class="btn btn-link p-0 ms-1 btn_ver_observacion text-decoration-none fw-bold" 
                                                           data-bs-toggle="modal" data-bs-target="#modal_ver_observacion" 
                                                           data-obs="{{ htmlspecialchars($observacion_texto, ENT_QUOTES) }}" 
                                                           style="font-size: 0.85em; vertical-align: baseline;" data-bs-toggle="tooltip" title="Ver observación completa">
                                                            <i data-feather="eye" style="width: 14px; height: 14px; margin-bottom: 2px; margin-right: 2px;"></i>Ver más
                                                        </button>
                                                    @endif
                                                </td>

                                                <td scope="row" class="align-middle text-center">
                                                    @if(isset($documento_actual['username_valido']) && $documento_actual['username_valido'] !== 'null' && trim($documento_actual['username_valido']) !== '')
                                                        @php
                                                            $estado_etiqueta = (isset($documento_actual['es_completado']) && $documento_actual['es_completado'] == 1) ? 'VALIDADO POR:' : 'MODIFICADO POR:';
                                                        @endphp
                                                        {{-- ESTILO EN NEGRITA FUERTE DE LA IMAGEN --}}
                                                        <span class="tx-11 fw-bolder mb-1 text-uppercase text-dark d-block">{{ $estado_etiqueta }}</span>
                                                        
                                                        @if(in_array($documento_actual['id_documento'], [6, 7, 10]) || $documento_actual['username_valido'] == 'automatico' || $documento_actual['username_valido'] == 'SISTEMA' || (isset($documento_actual['name']) && $documento_actual['name'] == 'SISTEMA AUTOMÁTICO'))
                                                            <span class="badge bg-success text-white">AUTOMÁTICA</span>
                                                        @elseif($documento_actual['username_valido'] == ($user['numero_registro_asignado'] ?? ''))
                                                            <span class="badge bg-light text-dark border">{{ $user['nombre_completo'] ?? $documento_actual['username_valido'] }}</span>
                                                        @else
                                                            <span class="badge bg-light text-dark border">{{ $documento_actual['name'] ?? $documento_actual['username_valido'] }}</span>
                                                        @endif
                                                    @endif
                                                </td>

                                                <td scope="row" class="align-middle text-center">
                                                    @php
                                                        $fecha_formateada = '';
                                                        if(isset($documento_actual['validado']) && $documento_actual['validado'] !== 'null' && trim($documento_actual['validado']) !== '') {
                                                            try {
                                                                $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                                                                $ts = strtotime($documento_actual['validado']);
                                                                $dia = date('j', $ts);
                                                                $mes = $meses[date('n', $ts) - 1];
                                                                $anio = date('Y', $ts);
                                                                $fecha_formateada = $dia . ' de ' . $mes . ' de ' . $anio;
                                                            } catch(\Exception $excepcion) {
                                                                $fecha_formateada = $documento_actual['validado'];
                                                            }
                                                        }
                                                    @endphp
                                                    {{ $fecha_formateada }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="d-none d-xl-block col-xl-2">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card rounded">
                    <div class="card-body">
                        
                        <h6 class="card-title mb-2 text-center fw-bold">LISTA DE DOCUMENTOS</h6>
                        
                        @php
                            $validados_count = 0;
                            $revision_count = 0;
                            $pendientes_count = 0;
                            $total_count = isset($documentos) ? count($documentos) : 0;
                            
                            if($total_count > 0){
                                foreach($documentos as $documento_conteo){
                                    if(isset($documento_conteo['es_completado']) && $documento_conteo['es_completado'] == 1){
                                        $validados_count++;
                                    } else {
                                        $arch_json = isset($documento_conteo['archivos']) && $documento_conteo['archivos'] != 'null' ? $documento_conteo['archivos'] : '[]';
                                        $arr_arch = json_decode($arch_json, true);
                                        if(is_array($arr_arch) && count($arr_arch) > 0) {
                                            $revision_count++;
                                        } else {
                                            $pendientes_count++;
                                        }
                                    }
                                }
                            }
                        @endphp

                        <div class="d-flex align-items-center justify-content-center gap-1 mb-3">
                            <span class="badge bg-success text-white" id="badge_validados" data-bs-toggle="tooltip" title="Validados">{{ $validados_count }}</span>
                            <span class="text-muted" style="font-size: 11px;">|</span>
                            <span class="badge bg-warning text-dark" id="badge_revision" data-bs-toggle="tooltip" title="En Revisión (Archivos subidos)">{{ $revision_count }}</span>
                            <span class="text-muted" style="font-size: 11px;">|</span>
                            <span class="badge bg-danger text-white" id="badge_pendientes" data-bs-toggle="tooltip" title="Pendientes">{{ $pendientes_count }}</span>
                            <span class="text-muted" style="font-size: 11px;">|</span>
                            <span class="badge bg-light text-dark border" id="badge_total" data-bs-toggle="tooltip" title="Total Documentos">{{ $total_count }}</span>
                        </div>
                        <hr class="mt-0 mb-3">

                        <div id="resumen_documentos">
                        @if(isset($documentos) && count($documentos) > 0)
                            @php
                                // ORDENAR LOS DOCUMENTOS DEL SEMÁFORO PARA QUE EL ID 1 QUEDE DE PRIMERO
                                $documentos_resumen_ordenados = collect($documentos)->sortBy(function($documento_resumen_actual) {
                                    return $documento_resumen_actual['id_documento'] == 1 ? 0 : 1;
                                })->all();
                            @endphp
                            @foreach($documentos_resumen_ordenados as $fila_resumen)
                                @php
                                    $arch_j = isset($fila_resumen['archivos']) && $fila_resumen['archivos'] != 'null' ? $fila_resumen['archivos'] : '[]';
                                    $arr_a = json_decode($arch_j, true);
                                    $tiene_arch = (is_array($arr_a) && count($arr_a) > 0);
                                    
                                    $color_indicador = '#dc3545';
                                    if(isset($fila_resumen['es_completado']) && $fila_resumen['es_completado'] == 1){
                                        $color_indicador = '#198754';
                                    } else if ($tiene_arch) {
                                        $color_indicador = '#ffc107';
                                    }
                                @endphp
                                <div class="d-flex justify-content-between mb-2 pb-2 border-bottom" id="resumen_doc_{{$fila_resumen['id_documento']}}">
                                    <div class="d-flex align-items-start hover-pointer w-100">
                                        <div class="indicador-color mt-1 flex-shrink-0" style="width: 16px; height: 16px; border-radius: 50%; background-color: {{ $color_indicador }};"></div>
                                        <div class="ms-2 flex-grow-1">
                                            <p class="nombre-doc tx-11 fw-bolder text-uppercase text-dark mb-0" style="white-space: normal; word-break: break-word; line-height: 1.2;">{{$fila_resumen['nombre']}}</p>
                                            
                                            @if(isset($fila_resumen['es_completado']) && $fila_resumen['es_completado'] == 1)
                                                <p class="estado-doc tx-11 fw-bolder text-uppercase text-success mb-0 mt-1">VALIDADO</p>
                                            @else
                                                @if($tiene_arch)
                                                    <p class="estado-doc tx-11 fw-bolder text-uppercase text-warning mb-0 mt-1">EN REVISIÓN</p>
                                                @else
                                                    <p class="estado-doc tx-11 fw-bolder text-uppercase text-danger mb-0 mt-1">PENDIENTE A VALIDAR</p>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_validar_documento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white"><i data-feather="check-circle" class="icon-md me-2"></i>Archivos del Documento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <input type="hidden" id="mdl_id_doc">
                <input type="hidden" id="mdl_id_sol">
                <input type="hidden" id="mdl_nombre_oculto">

                <h6 class="text-primary mb-3" id="mdl_nombre_doc">Nombre del Documento</h6>
                
                @if(in_array('secretaria_general_escribir_observacion', $scopes))
                <div class="mb-3">
                    <label class="form-label fw-bold">Observación (Opcional):</label>
                    <textarea class="form-control" id="mdl_observacion" rows="3" placeholder="Escriba alguna nota o comentario..." {{ $esta_graduado ? 'disabled' : '' }}></textarea>
                </div>
                @endif

                @if(in_array('estudiante_adjuntar_archivos', $scopes) && !$esta_graduado)
                <div class="mb-3">
                    <label class="form-label fw-bold" id="lbl_adjuntar">Adjuntar Archivos Nuevos (Opcional):</label>
                    <div class="file-upload" id="fileUpload">
                        <p class="text-muted m-0"><i data-feather="upload-cloud" class="icon-lg mb-2"></i><br>Arrastra o haz clic para seleccionar archivos</p>
                        <input type="file" id="inputArchivos" multiple hidden>
                    </div>
                    <div id="fileList" class="file-list"></div>
                </div>
                @endif

                <div id="contenedor_archivos_existentes" class="mb-2 d-none">
                    <hr>
                    <label class="form-label fw-bold text-primary">Archivos Guardados en el Sistema:</label>
                    <div id="lista_archivos_existentes" class="mt-2"></div>
                </div>

            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                
                @if(!$esta_graduado && (in_array('secretaria_general_escribir_observacion', $scopes) || in_array('estudiante_adjuntar_archivos', $scopes)))
                    <button type="button" class="btn btn-primary btn-sm" id="btn_guardar_modal">Guardar Archivos/Notas</button>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_ver_observacion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">
                    <i data-feather="align-left" class="icon-md me-2 text-white"></i>Observación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p id="texto_observacion_completa" class="text-justify text-wrap" style="font-size: 14px; margin-bottom: 0;"></p>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=mzutkZDE"></script>
  <script type="text/javascript">

    var table = null; 
    var rowNumber = null;
    var btn_activo = true;
    var url_guardar_validacion = "{{url('/secretariageneral/estudiantes/documento/validar')}}"; 
    
    var esta_graduado_js = {{ $esta_graduado ? 'true' : 'false' }};
    var scopes_js = @json($scopes ?? []); 

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // INICIALIZACIÓN GENERAL DE LOS TOOLTIPS AL CARGAR LA PÁGINA
        $('[data-bs-toggle="tooltip"]').tooltip();

        table = $('#tbl_documentos_perfil').DataTable({
                responsive: true, 
                // APAGAR EL ORDENAMIENTO INICIAL PARA RESPETAR EL ORDEN DEL BACKEND
                "order": [], 
                columnDefs: [
                    {
                        className: 'dtr-control',
                        orderable: false,
                        responsivePriority: 1, 
                        targets: 0
                    }
                ],
                "aLengthMenu": [
                    [10, 30, 50, 100,-1],
                    [10, 30, 50, 100,"Todo"]
                ],
                "iDisplayLength": 30,
                language: {
                    processing:     "Procesando...",
                    search:         "Buscar:",
                    lengthMenu:     "Mostrar _MENU_ registros",
                    info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    infoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    infoFiltered:   "(filtrado de un total de _MAX_ registros)",
                    infoPostFix:    "",
                    loadingRecords: "Cargando...",
                    zeroRecords:    "No se encontraron resultados",
                    emptyTable:     "Ningún dato disponible en esta tabla",
                    paginate: {
                        first:      "Primero",
                        previous:   "Anterior",
                        next:       "Siguiente",
                        last:       "Último"
                    },
                    aria: {
                        sortAscending:  ": Activar para ordenar la columna de manera ascendente",
                        sortDescending: ": Activar para ordenar la columna de manera descendente"
                    }
                },
                // REINICIAR TOOLTIPS CADA VEZ QUE SE DIBUJA/PAGINA LA TABLA
                drawCallback: function(settings) {
                    $('[data-bs-toggle="tooltip"]').tooltip();
                }
        });

        $('#tbl_documentos_perfil').each(function() {
            var datatable = $(this);
            var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
            search_input.attr('placeholder', 'Buscar');
            search_input.removeClass('form-control-sm');
            var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
            length_sel.removeClass('form-control-sm');
        });

        $("#tbl_documentos_perfil tbody").on( "click", "tr", function () { 
            rowNumber = parseInt(table.row( this ).index()); 
            table.$('tr.selected').removeClass('selected'); 
            $(this).addClass('selected'); 
        });
    });

    $('#modal_ver_observacion').on('show.bs.modal', function (event) {
        var boton_que_abrio_el_modal = $(event.relatedTarget); 
        var texto_de_la_observacion = boton_que_abrio_el_modal.data('obs'); 
        var modal_actual = $(this);
        modal_actual.find('#texto_observacion_completa').text(texto_de_la_observacion);
    });
    
    $('#tbl_documentos_perfil').on('change', '.chk_validar', function () {
        if(esta_graduado_js) return; 

        var chk = $(this);
        var id_doc = chk.data('id_doc');
        var id_sol = chk.data('id_sol');
        var isChecked = chk.is(':checked');
        
        rowNumber = table.row(chk.closest('tr')).index();
        var nombre = table.row(rowNumber).data()[1].replace(/<\/?[^>]+(>|$)/g, ""); 
        
        $('#mdl_id_doc').val(id_doc);
        $('#mdl_id_sol').val(id_sol);
        $('#mdl_nombre_oculto').val(nombre);

        if(!id_sol || id_sol == ''){
            Toast.fire({ icon: 'error', title: 'No hay solicitud activa.'});
            chk.prop('checked', false);
            return;
        }

        if (isChecked) {
            if($('#mdl_observacion').length > 0) {
                $('#mdl_observacion').val(''); 
            }
            
            const formData = new FormData();
            formData.append('id_documento', id_doc);
            formData.append('id_solicitud', id_sol);
            formData.append('observacion', '');
            formData.append('tipo_accion', 'validar'); 

            guardar_validacion_documento(formData);

        } else {
            chk.prop('checked', true); 

            Swal.fire({
                title: '¿Cancelar Validación?',
                text: "Se removerá esta validación y todos sus archivos asociados.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    chk.prop('checked', false); 
                    
                    const formData = new FormData();
                    formData.append('id_documento', id_doc);
                    formData.append('id_solicitud', id_sol);
                    formData.append('tipo_accion', 'cancelar'); 

                    guardar_validacion_documento(formData);
                }
            });
        }
    });

    
    $('#tbl_documentos_perfil').on('click', '.btn_abrir_modal', function () {
        var btn = $(this);
        var id_doc = btn.data('id_doc');
        var id_sol = btn.data('id_sol');
        var id_val = btn.data('id_val');
        var nombre = btn.data('nombre');
        var obs = btn.data('obs');
        var estado = btn.data('estado'); 

        var json_archivos_raw = btn.attr('data-archivos');
        var arr_archivos = [];
        try {
            arr_archivos = JSON.parse(json_archivos_raw);
        } catch (e) {
            arr_archivos = (typeof json_archivos_raw === 'object') ? json_archivos_raw : [];
        }
        
        rowNumber = table.row(btn.closest('tr')).index();
        var tr = btn.closest('tr');

        if(!id_sol || id_sol == ''){
            Toast.fire({ icon: 'error', title: 'No hay solicitud activa para este estudiante.' });
            return;
        }

        if(!esta_graduado_js) {
            archivosSeleccionados = [];
            mostrarListaArchivos();
        }
        
        $('#mdl_id_doc').val(id_doc);
        $('#mdl_id_sol').val(id_sol);
        $('#mdl_nombre_doc').text(nombre);
        $('#mdl_nombre_oculto').val(nombre);
        
        if($('#mdl_observacion').length > 0) {
            var obs_limpia = (obs != null && obs !== 'null' && obs !== 'undefined') ? obs : '';
            $('#mdl_observacion').val(obs_limpia);
        }

        $('#lista_archivos_existentes').html('');
        var sys_id_proceso = $('#sys_id_proceso_graduacion').val();

        if (arr_archivos && arr_archivos.length > 0) {
            $('#contenedor_archivos_existentes').removeClass('d-none');
            
            var url_base_descarga = "{{ url('/secretariageneral/estudiantes/documento/descargar') }}";

            arr_archivos.forEach(function(archivo) {
                var url_descarga = url_base_descarga + "/" + sys_id_proceso + "/" + id_sol + "/" + id_val + "/" + encodeURIComponent(archivo.nombre);

                // AQUÍ AGREGAMOS LA VALIDACIÓN DEL PERMISO PARA EL BOTÓN DE ELIMINAR EN JS
                var btn_eliminar_html = (esta_graduado_js || !scopes_js.includes('estudiante_adjuntar_archivos')) ? '' : `<button type="button" class="btn btn-danger btn-xs text-white d-flex align-items-center" data-bs-toggle="tooltip" title="Eliminar archivo" onclick="eliminarArchivoExistente(${archivo.id}, this)"><i data-feather="trash-2" class="icon-sm"></i></button>`;

                $('#lista_archivos_existentes').append(`
                    <div class="d-flex justify-content-between align-items-center bg-light border rounded px-3 py-2 mb-2 w-100">
                        <div class="text-truncate me-2" style="flex: 1;" title="${archivo.nombre}">
                            <i data-feather="file" class="icon-sm me-1 text-secondary"></i>
                            <span class="small">${archivo.nombre}</span>
                        </div>
                        <div class="d-flex flex-nowrap" style="gap: 5px;">
                            <a href="${url_descarga}" download="${archivo.nombre}" class="btn btn-primary btn-xs text-white d-flex align-items-center" data-bs-toggle="tooltip" title="Descargar archivo">
                                <i data-feather="download" class="icon-sm me-1"></i> Descargar
                            </a>
                            ${btn_eliminar_html}
                        </div>
                    </div>
                `);
            });
            if(typeof feather !== 'undefined') { feather.replace(); }
            $('[data-bs-toggle="tooltip"]').tooltip();

        } else {
            $('#contenedor_archivos_existentes').addClass('d-none');
        }

        if(!esta_graduado_js){
            if (estado == 1) {
                $('#btn_guardar_modal').text('Actualizar Archivos/Notas');
            } else {
                $('#btn_guardar_modal').text('Guardar Archivos/Notas');
            }
        }

        $('#modal_validar_documento').modal('show');
    }); 

    window.eliminarArchivoExistente = function(id_archivo, btn_element) {
        // ESCONDER TOOLTIP ANTES DE ABRIR SWAL PARA EVITAR BUGS VISUALES
        $('.tooltip').tooltip('hide');
        
        Swal.fire({
            title: '¿Eliminar archivo?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar'
        }).then((result) => {
            if (result.isConfirmed) {
                espera('Eliminando...');
                $.ajax({
                    url: "{{ url('/secretariageneral/estudiantes/documento/archivo/eliminar') }}",
                    type: 'POST',
                    data: { id_archivo: id_archivo },
                    success: function(respuesta_servidor) {
                        Swal.close();
                        if(respuesta_servidor.estatus) {
                            Toast.fire({ icon: 'success', title: respuesta_servidor.msgSuccess });
                            $(btn_element).closest('.d-flex.w-100').remove();
                            
                            var id_doc = $('#mdl_id_doc').val();
                            var btn_principal = $('#tbl_documentos_perfil .btn_abrir_modal[data-id_doc="' + id_doc + '"]');
                            if(btn_principal.length > 0) {
                                var json_raw = btn_principal.attr('data-archivos');
                                var arr = JSON.parse(json_raw);
                                arr = arr.filter(a => a.id != id_archivo);
                                btn_principal.attr('data-archivos', JSON.stringify(arr));
                                
                                if(arr.length === 0) {
                                    $('#contenedor_archivos_existentes').addClass('d-none');
                                }
                            }
                        } else {
                            Swal.fire('Error', respuesta_servidor.msgError, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.close();
                        Swal.fire('Error de Conexión', 'No se pudo alcanzar la ruta en tu proyecto.', 'error');
                    }
                });
            }
        });
    }

    let archivosSeleccionados = [];

    $(document).on('click', '#fileUpload', function() {
        $('#inputArchivos')[0].click();
    });

    $(document).on('dragover', '#fileUpload', function(e) {
        e.preventDefault();
        $(this).css('background-color', '#eef');
    });

    $(document).on('dragleave', '#fileUpload', function() {
        $(this).css('background-color', '');
    });

    $(document).on('drop', '#fileUpload', function(e) {
        e.preventDefault();
        $(this).css('background-color', '');
        if(e.originalEvent.dataTransfer.files) {
            agregarArchivos(e.originalEvent.dataTransfer.files);
        }
    });

    $(document).on('change', '#inputArchivos', function(e) {
        if(e.target.files.length > 0) {
            agregarArchivos(e.target.files);
        }
    });

    function agregarArchivos(files) {
        for (const file of files) {
            if (!archivosSeleccionados.some(f => f.name === file.name)) { 
                archivosSeleccionados.push(file); 
            }
        }
        mostrarListaArchivos();
        $('#inputArchivos').val(''); 
    }

    function mostrarListaArchivos() {
        var $fileList = $('#fileList');
        
        if($fileList.length === 0) return; 

        $fileList.html('');
        archivosSeleccionados.forEach((file, index) => {
            const item = `
            <div class="file-item bg-light border rounded px-3 py-2 mb-2 d-flex justify-content-between align-items-center w-100">
              <div class="text-truncate me-2" style="flex: 1;" title="${file.name}">
                  <i data-feather="file" class="icon-sm me-1 text-secondary"></i>
                  <span class="ms-1">${file.name}</span> <span class="small text-muted">(${(file.size/1024).toFixed(1)} KB)</span>
              </div>
              <button type="button" class="btn btn-link text-danger text-decoration-none p-0 fw-bold" onclick="eliminarArchivo(${index})">&times;</button>
            </div>`;
            $fileList.append(item);
        });
        if(typeof feather !== 'undefined') { feather.replace(); }
    } 

    window.eliminarArchivo = function(index) {
        archivosSeleccionados.splice(index, 1);
        mostrarListaArchivos();
    }

    $(document).on("click", "#btn_guardar_modal", function () {
        if(btn_activo && !esta_graduado_js) {
            $('#modal_validar_documento').modal('hide');
            
            const formData = new FormData();
            archivosSeleccionados.forEach((file, i) => {
                formData.append('archivos[]', file, file.name);
            });
            
            formData.append('id_documento', $('#mdl_id_doc').val());
            formData.append('id_solicitud', $('#mdl_id_sol').val());
            
            var obs_enviar = '';
            if($('#mdl_observacion').length > 0) {
                obs_enviar = $('#mdl_observacion').val();
                if (obs_enviar === 'undefined' || obs_enviar === 'null' || !obs_enviar) {
                    obs_enviar = '';
                }
            }
            formData.append('observacion', obs_enviar);
            formData.append('tipo_accion', 'guardar_archivos');

            guardar_validacion_documento(formData);
        }
    });

    function guardar_validacion_documento(formData) {
        espera('Ejecutando acción...');
        btn_activo = false;

        $.ajax({
            type: "post",
            url: url_guardar_validacion,
            data: formData,
            processData: false, 
            contentType: false, 
            success: function (respuesta_api) {
                Swal.close();
                if (respuesta_api.estatus === false || respuesta_api.msgError != null) {
                    ToastLG.fire({
                        icon: 'error',
                        title: 'Error',
                        html: respuesta_api.msgError,
                        timer: 3000
                    });
                    btn_activo = true;
                } else {
                    ToastLG.fire({
                        icon: 'success',
                        title: 'Éxito',
                        html: respuesta_api.msgSuccess,
                        timer: 2000
                    });
                    
                    if(respuesta_api.id_proceso_graduacion) {
                        $('#sys_id_proceso_graduacion').val(respuesta_api.id_proceso_graduacion);
                    }

                    if(respuesta_api.documento_procesado) {
                        var documento_procesado = respuesta_api.documento_procesado;
                        var id_sol = formData.get('id_solicitud'); 
                        var celda_accion = '';

                        var string_archivos = documento_procesado.archivos && documento_procesado.archivos !== 'null' ? documento_procesado.archivos : '[]';
                        var count_archivos = 0;
                        try {
                            var json_parseado = JSON.parse(string_archivos);
                            count_archivos = json_parseado.length;
                        } catch(e) {}
                        
                        var badge_archivos = '';
                        if (count_archivos > 0) {
                            badge_archivos = `<br><span class="badge bg-primary mt-1" style="font-size: 10px; color: #ffffff !important;"><i data-feather="paperclip" style="width: 10px; height: 10px; color: #ffffff !important;"></i> <span class="ms-1" style="color: #ffffff !important;">${count_archivos} Archivo(s)</span></span>`;
                        }

                        var tiene_permiso_maestro = scopes_js.includes('secretaria_general_validar_documento');
                        var html_switch = '';

                        var es_documento_automatico_js = [6, 7, 10].includes(parseInt(documento_procesado.id_documento));

                        if (tiene_permiso_maestro) {
                            var permiso_requerido = documento_procesado.nombre_permiso_requerido;
                            var falta_permiso_especifico = (permiso_requerido && !scopes_js.includes(permiso_requerido));
                            var disabled_attr = (es_documento_automatico_js || esta_graduado_js || falta_permiso_especifico) ? 'disabled' : '';
                            var checked_attr = (documento_procesado.es_completado == 1) ? 'checked' : '';

                            html_switch = `
                                <div class="form-check form-switch mb-0" data-bs-toggle="tooltip" title="Validar / Cancelar">
                                    <input class="form-check-input chk_validar" style="cursor: pointer; width: 2.5em; height: 1.25em;" type="checkbox" ${checked_attr} ${disabled_attr} data-id_doc="${documento_procesado.id_documento}" data-id_sol="${id_sol}">
                                </div>
                            `;
                        }

                       // LÓGICA DE BOTÓN IMPRIMIR PARA DOCUMENTOS AUTOMÁTICOS EN JS
                        var boton_accion_principal = '';
                        if(es_documento_automatico_js) {
                            var num_registro_estudiante = "{{ $user['numero_registro_asignado'] ?? '' }}";
                            
                            // VALIDACIÓN DEL PERMISO DE IMPRIMIR EN JS
                            if(scopes_js.includes('secretaria_general_imprimir_solvencia')) {
                                if(documento_procesado.id_documento == 10) {
                                    var url_imprimir_admin = "{{ url('/secretariageneral/estudiantes/perfil/reporte') }}/" + num_registro_estudiante;
                                    boton_accion_principal = `
                                        <a href="${url_imprimir_admin}" target="_blank" class="btn btn-success btn-xs d-inline-flex align-items-center" style="padding: 4px 10px; white-space:nowrap;" data-bs-toggle="tooltip" title="Imprimir Reporte Admin">
                                            <i data-feather="printer" style="width: 14px; height: 14px; margin-right: 4px;"></i> Imprimir
                                        </a>
                                    `;
                                } else if(documento_procesado.id_documento == 6) { 
                                    var url_imprimir_registro = "{{ url('/secretariageneral/estudiantes/perfil/reporteregistro') }}/" + num_registro_estudiante;
                                    boton_accion_principal = `
                                        <a href="${url_imprimir_registro}" target="_blank" class="btn btn-success btn-xs d-inline-flex align-items-center" style="padding: 4px 10px; white-space:nowrap;" data-bs-toggle="tooltip" title="Imprimir Solvencia Registro">
                                            <i data-feather="printer" style="width: 14px; height: 14px; margin-right: 4px;"></i> Imprimir
                                        </a>
                                    `;
                                } else if(documento_procesado.id_documento == 7) {
                                    var url_imprimir_archivo = "{{ url('/secretariageneral/estudiantes/perfil/reportearchivo') }}/" + num_registro_estudiante;
                                    boton_accion_principal = `
                                        <a href="${url_imprimir_archivo}" target="_blank" class="btn btn-success btn-xs d-inline-flex align-items-center" style="padding: 4px 10px; white-space:nowrap;" data-bs-toggle="tooltip" title="Imprimir Solvencia Archivo">
                                            <i data-feather="printer" style="width: 14px; height: 14px; margin-right: 4px;"></i> Imprimir
                                        </a>
                                    `;
                                }
                            } else {
                               // RELLENO INVISIBLE PARA MANTENER LA ESTÉTICA EXACTA
                                boton_accion_principal = `
                                    <button type="button" class="btn btn-secondary btn-xs d-inline-flex align-items-center" style="padding: 4px 10px; visibility: hidden;">
                                        <i data-feather="folder" style="width: 14px; height: 14px; margin-right: 4px;"></i> Archivos
                                    </button>
                                `;
                            }
                        } else {
                            var btn_class = (documento_procesado.es_completado == 1) ? 'btn-warning' : 'btn-secondary';
                            var title_attr = (documento_procesado.es_completado == 1) ? 'Ver Archivos' : 'Ver / Añadir Archivos';
                            boton_accion_principal = `
                                <button type="button" class="btn ${btn_class} btn-xs btn_abrir_modal d-inline-flex align-items-center" style="padding: 4px 10px;" data-bs-toggle="tooltip" data-id_doc="${documento_procesado.id_documento}" data-id_sol="${id_sol}" data-id_val="${documento_procesado.id_validacion}" data-archivos='${string_archivos}' data-nombre="${documento_procesado.nombre}" data-obs="${documento_procesado.observacion || ''}" data-estado="${documento_procesado.es_completado}" title="${title_attr}">
                                    <i data-feather="folder" style="width: 14px; height: 14px; margin-right: 4px;"></i> Archivos
                                </button>
                            `;
                        }

                        var btn_constancia_js = '';
                        if (documento_procesado.id_documento == 1) {
                            btn_constancia_js = `<a href="{{ asset('documentos/CONSTANCIADEVERIFICACIONDENOMBRE.pdf') }}" download="CONSTANCIA_DE_VERIFICACION_DE_NOMBRE.pdf" class="btn btn-primary btn-xs ms-1 d-inline-flex align-items-center" style="padding: 4px 10px;" data-bs-toggle="tooltip" title="Descargar Constancia"><i data-feather="download" style="width: 14px; height: 14px;"></i></a>`;
                        }

                        celda_accion = `
                            <div class="d-inline-flex align-items-center text-nowrap gap-2">
                                ${html_switch}
                                ${boton_accion_principal}
                                ${btn_constancia_js}
                            </div>
                        `;

                        var col_obs = (documento_procesado.observacion != null && documento_procesado.observacion !== 'null' && documento_procesado.observacion !== 'undefined' && String(documento_procesado.observacion).trim() !== '') ? documento_procesado.observacion : '';
                        var palabras_js = col_obs.split(' ').filter(function(n) { return n != '' });
                        var obs_final = col_obs;
                        
                        if (palabras_js.length > 3) {
                            var extracto = palabras_js.slice(0, 3).join(' ') + '...';
                            var obs_escapada = col_obs.replace(/"/g, '&quot;'); 
                            obs_final = '<span>' + extracto + '</span> <button type="button" class="btn btn-link p-0 ms-1 btn_ver_observacion text-decoration-none fw-bold" data-bs-toggle="modal" data-bs-target="#modal_ver_observacion" data-bs-toggle="tooltip" data-obs="' + obs_escapada + '" style="font-size: 0.85em; vertical-align: baseline;" title="Ver observación completa"><i data-feather="eye" style="width: 14px; height: 14px; margin-bottom: 2px; margin-right: 2px;"></i>Ver más</button>';
                        }

                        var col_val = '';
                        if (documento_procesado.username_valido != null && documento_procesado.username_valido !== 'null' && documento_procesado.username_valido !== '') {
                            var num_registro = "{{ $user['numero_registro_asignado'] ?? '' }}";
                            var nombre_estudiante = "{{ $user['nombre_completo'] ?? '' }}";
                            
                            // ETIQUETA MODIFICADO/VALIDADO EN JAVASCRIPT CON NEGRITA (fw-bolder)
                            var estado_etiqueta_js = (documento_procesado.es_completado == 1) ? 'VALIDADO POR:' : 'MODIFICADO POR:';
                            col_val += '<span class="tx-11 fw-bolder mb-1 text-uppercase text-dark d-block">' + estado_etiqueta_js + '</span>';
                            
                            if (es_documento_automatico_js || documento_procesado.username_valido == 'automatico' || documento_procesado.username_valido == 'SISTEMA' || (documento_procesado.name && documento_procesado.name == 'SISTEMA AUTOMÁTICO')) {
                                col_val += '<span class="badge bg-success text-white">AUTOMÁTICA</span>';
                            } else if (documento_procesado.username_valido == num_registro) {
                                col_val += '<span class="badge bg-dark text-white">' + (nombre_estudiante || documento_procesado.username_valido) + '</span>';
                            } else {
                                var nombre_persona = (documento_procesado.name != null && documento_procesado.name !== 'null') ? documento_procesado.name : documento_procesado.username_valido;
                                col_val += '<span class="badge bg-light text-dark border">' + nombre_persona + '</span>';
                            }
                        }

                        var col_fecha_js = '';
                        if (documento_procesado.validado != null && documento_procesado.validado !== 'null' && documento_procesado.validado.trim() !== '') {
                            try {
                                var cleanDate = documento_procesado.validado.replace(' ', 'T');
                                var dateObj = new Date(cleanDate);
                                if (!isNaN(dateObj)) {
                                    var meses_es = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                                    var dia = dateObj.getDate();
                                    var mes = meses_es[dateObj.getMonth()];
                                    var anio = dateObj.getFullYear();
                                    col_fecha_js = dia + ' de ' + mes + ' de ' + anio;
                                } else {
                                    col_fecha_js = documento_procesado.validado; 
                                }
                            } catch(e) {
                                col_fecha_js = documento_procesado.validado;
                            }
                        }

                        // TEXTO DEL DOCUMENTO EN NEGRITA (fw-bolder) TX-11
                        var nuevaFilaDT = [
                            celda_accion,
                            '<div class="align-middle"><span class="tx-11 fw-bolder text-uppercase text-dark">' + documento_procesado.nombre + '</span>' + badge_archivos + '</div>',
                            '<div class="align-middle text-wrap" style="max-width: 350px;">' + obs_final + '</div>',
                            '<div class="text-center align-middle">' + col_val + '</div>',
                            '<div class="text-center align-middle">' + col_fecha_js + '</div>'
                        ];

                        table.row(rowNumber).data(nuevaFilaDT).draw(false);
                    }

                    if(respuesta_api.documentos_lista) {
                        $("#resumen_documentos").html('');
                        
                        var validados_js = 0;
                        var revision_js = 0;
                        var pendientes_js = 0;
                        var total_js = respuesta_api.documentos_lista.length;

                        // ORDENAR TAMBIÉN EN JAVASCRIPT PARA QUE EL ID 1 QUEDE PRIMERO
                        var lista_ordenada_js = respuesta_api.documentos_lista.sort(function(documento_a, documento_b) {
                            if(documento_a.id_documento == 1) return -1;
                            if(documento_b.id_documento == 1) return 1;
                            return 0;
                        });

                        for(var i = 0; i < total_js; i++) {
                            var documento_iteracion = lista_ordenada_js[i];
                            
                            var tiene_archivos = false;
                            try {
                                var pars = JSON.parse(documento_iteracion.archivos);
                                if(pars && pars.length > 0) tiene_archivos = true;
                            } catch(e){}

                            if(documento_iteracion.es_completado == 1){
                                validados_js++;
                            } else if(tiene_archivos) {
                                revision_js++;
                            } else {
                                pendientes_js++;
                            }

                            var color_indicador = '#dc3545';
                            var texto_estado = '<p class="estado-doc tx-11 fw-bolder text-uppercase text-danger mb-0 mt-1">PENDIENTE A VALIDAR</p>';

                            if(documento_iteracion.es_completado == 1) {
                                color_indicador = '#198754';
                                texto_estado = '<p class="estado-doc tx-11 fw-bolder text-uppercase text-success mb-0 mt-1">VALIDADO</p>';
                            } else if(tiene_archivos) {
                                color_indicador = '#ffc107';
                                texto_estado = '<p class="estado-doc tx-11 fw-bolder text-uppercase text-warning mb-0 mt-1">EN REVISIÓN</p>';
                            }

                            // CIRCULO 16px Y TEXTOS EN NEGRITA (fw-bolder) EN EL RESUMEN JS
                            $("#resumen_documentos").append(`
                                <div class="d-flex justify-content-between mb-2 pb-2 border-bottom" id="resumen_doc_${documento_iteracion.id_documento}">
                                    <div class="d-flex align-items-start hover-pointer w-100">
                                        <div class="indicador-color mt-1 flex-shrink-0" style="width: 16px; height: 16px; border-radius: 50%; background-color: ${color_indicador};"></div>
                                        <div class="ms-2 flex-grow-1">
                                            <p class="nombre-doc tx-11 fw-bolder text-uppercase text-dark mb-0" style="white-space: normal; word-break: break-word; line-height: 1.2;">${documento_iteracion.nombre}</p>
                                            ${texto_estado}
                                        </div>
                                    </div>
                                </div>
                            `);
                        }

                        $('#badge_validados').text(validados_js);
                        $('#badge_revision').text(revision_js);
                        $('#badge_pendientes').text(pendientes_js);
                        $('#badge_total').text(total_js);
                    }

                    if(typeof feather !== 'undefined') { feather.replace(); }
                    
                    // REINICIALIZAR TOOLTIPS DESPUES DEL AJAX
                    $('[data-bs-toggle="tooltip"]').tooltip();

                    btn_activo = true;
                }
            },
            error: function (xhr, status, error) {
                Swal.close();
                Swal.fire({ icon: 'error', title: 'Fallo de Conexión', text: 'Error contactando al servidor.' });
                btn_activo = true;
            },
        });
    }

    const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

    const ToastLG = Swal.mixin({
            showConfirmButton: false,
            timerProgressBar: true,
        });

    function espera(html){
        let timerInterval
        Swal.fire({
            imageUrl: "{{ url(asset('/assets/images/unag_loading.gif')) }}",
            title: '¡Espera!',
            html: html,
            timer: null,
            timerProgressBar: true,
            allowOutsideClick: false,
            didOpen: () => {
            Swal.showLoading()
            timerInterval = setInterval(() => {
                const content = Swal.getHtmlContainer()
                if (content) {
                const b = content.querySelector('b')
                if (b) {
                    b.textContent = Swal.getTimerLeft()
                }
                }
            }, 100)
            },
            willClose: () => {
            clearInterval(timerInterval)
            }
        }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
            console.log('I was closed by the timer')
            }
        })
    }

  </script>
@endpush