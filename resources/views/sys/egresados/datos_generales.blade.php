@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/prismjs/prism.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/easymde/easymde.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<style>
.scroll-container {
    max-height: 600px; /* ajusta la altura según tu necesidad */
    overflow-y: auto;
    
}
</style>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-auto col-md-2 px-1">
                <div class="nav nav-tabs nav-tabs-vertical" id="v-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link" id="v-datos_generales-tab" data-bs-toggle="tab" href="#v-datos_generales" role="tab" aria-controls="v-datos_generales" aria-selected="true">Datos Generales</a>
                    <a class="nav-link" id="v-datos_academicos-tab" data-bs-toggle="tab" href="#v-profile" role="tab" aria-controls="v-profile" aria-selected="false">Datos Académicos</a>
                    <a class="nav-link" id="v-experiencia_laboral-tab" data-bs-toggle="tab" href="#v-messages" role="tab" aria-controls="v-messages" aria-selected="false">Experiencia Laboral</a>
                    <a class="nav-link" id="v-ofertas_empelos-tab" data-bs-toggle="tab" href="#v-settings" role="tab" aria-controls="v-settings" aria-selected="false">Ofertas de Empleo</a>
                </div>
            </div>
            <div class="col">
                <div class="tab-content tab-content-vertical border p-3" id="v-tabContent">
                    <div class="tab-pane fade" id="v-datos_generales" role="tabpanel" aria-labelledby="v-datos_generales-tab">
                        <div class="row">
                            <div class="col-lg-12 grid-margin stretch-card">
                                <form id="signupForm">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h1 class="">Datos Generales</h1>
                                            <p class="text-muted mb-3">Completa o actualiza tus datos generales de ser necesario.</p>
                                        </div>
                                        <hr />
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="primer_nombre_estudiante" class="form-label">Primer Nombre</label>
                                                <input value="{{$datos_generales['primer_nombre_estudiante']}}" id="primer_nombre_estudiante" class="form-control" name="primer_nombre_estudiante" type="text" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="segundo_nombre_estudiante" class="form-label">Segundo Nombre</label>
                                                <input value="{{$datos_generales['segundo_nombre_estudiante']}}" id="segundo_nombre_estudiante" class="form-control" name="segundo_nombre_estudiante" type="text" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="primer_apellido_estudiante" class="form-label">Primer Apellido</label>
                                                <input value="{{$datos_generales['primer_apellido_estudiante']}}" id="primer_apellido_estudiante" class="form-control" name="primer_apellido_estudiante" type="text" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="segundo_apellido_estudiante" class="form-label">Segundo Apellido</label>
                                                <input value="{{$datos_generales['segundo_apellido_estudiante']}}" id="segundo_apellido_estudiante" class="form-control" name="segundo_apellido_estudiante" type="text" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="correo_electronico" class="form-label">Correo Electrónico Personal</label>
                                                <input value="{{$datos_generales['correo_electronico']}}" id="correo_electronico" class="form-control mb-4 mb-md-0" name="correo_electronico" data-inputmask="'alias': 'email'" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="identidad_estudiante" class="form-label">Número de Identificación</label>
                                                <input value="{{$datos_generales['identidad_estudiante']}}" id="identidad_estudiante" type="text" class="form-control" name="identidad_estudiante" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="direccion_local_telefono" class="form-label">Número de Teléfono</label>
                                                <input value="{{$datos_generales['direccion_local_telefono']}}" id="direccion_local_telefono" type="text" class="form-control" name="direccion_local_telefono" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="fecha_nacimiento_estudiante" class="form-label">Fecha de Nacimiento</label>
                                                <input
                                                    value="{{$datos_generales['fecha_nacimiento_estudiante']}}"
                                                    id="fecha_nacimiento_estudiante"
                                                    type="text"
                                                    class="form-control mb-4 mb-md-0"
                                                    name="fecha_nacimiento_estudiante"
                                                    data-inputmask="'alias': 'datetime'"
                                                    data-inputmask-inputformat="yyyy/mm/dd"
                                                />
                                            </div>
                                        </div>
                                        <!-- <div class="mb-3">
                                                    <label for="ageSelect" class="form-label">Age</label>
                                                    <select class="form-select" name="age_select" id="ageSelect">
                                                        <option selected disabled>Select your age</option>
                                                        <option>12-18</option>
                                                        <option>18-22</option>
                                                        <option>22-30</option>
                                                        <option>30-60</option>
                                                        <option>Above 60</option>
                                                    </select>
                                                </div> -->
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Género</label>
                                                <div>
                                                    <div class="form-check form-check-inline">
                                                        <input @if($datos_generales['sexo_estudiante'] == 'M') checked @endif type="radio" value="M" class="form-check-input" name="gender_radio" id="gender1" />
                                                        <label class="form-check-label" for="gender1">
                                                            Masculino
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input @if($datos_generales['sexo_estudiante'] == 'F') checked @endif type="radio" value="F" class="form-check-input" name="gender_radio" id="gender2" />
                                                        <label class="form-check-label" for="gender2">
                                                            Femenino
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="departamento" class="form-label">Departamento</label>
                                                <select class="form-select" name="departamento" id="departamento">
                                                    <option selected disabled>Seleccione un departamento</option>
                                                    @foreach($departamentos as $row)
                                                        <option @if($datos_generales['direccion_local_municipio'] == $row['id_departamento']) selected @endif value="{{$row['id_departamento']}}">{{$row['descripcion_departamento']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="municipio" class="form-label">Municipio</label>
                                                <select class="form-select" name="municipio" id="municipio" disabled>
                                                    <option selected disabled>Seleccione un municipio</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="direccion_local_barrio_colonia" class="form-label">Dirección</label>
                                                <textarea class="form-control" value="{{$datos_generales['direccion_local_barrio_colonia']}}" id="direccion_local_barrio_colonia" name="direccion_local_barrio_colonia" maxlength="100" rows="3" placeholder="Escriba su dirección..."></textarea>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <!-- <label class="form-label">Skills</label>
                                                    <div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="checkbox" name="skill_check" class="form-check-input" id="checkInline1" />
                                                            <label class="form-check-label" for="checkInline1">
                                                                Angular
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="checkbox" name="skill_check" class="form-check-input" id="checkInline2" />
                                                            <label class="form-check-label" for="checkInline2">
                                                                ReactJs
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="checkbox" name="skill_check" class="form-check-input" id="checkInline3" />
                                                            <label class="form-check-label" for="checkInline3">
                                                                VueJs
                                                            </label>
                                                        </div>
                                                    </div> -->
                                        </div>
                                        <button class="btn btn-primary" type="submit"><i class="btn-icon-prepend" data-feather="save"></i> Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-profile" role="tabpanel" aria-labelledby="v-datos_academicos-tab">
                        <div class="row">
                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h1 class="">Datos Académicos</h1>
                                            <p class="text-muted mb-3">Completa o actualiza tus datos académicos.</p>
                                        </div>
                                        <div>
                                            @if(!empty($datos_academicos))
                                            <button type="button" class="btn btn-primary btn-icon btn_agregar_dato_academico" data-bs-toggle="modal" data-bs-target="#modal_agregar_datos_academicos">
                                                <i data-feather="plus"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </div>

                                    <hr />
                                    <div class="row scroll-container">
                                        <div class="col-md-12">
                                                    <div id="content">
                                                            @if(!empty($datos_academicos))
                                                                <ul class="timeline">
                                                                        @foreach($datos_academicos as $row)
                                                                        <li class="event" data-date="{{$row['fecha_inicio_formato']}} - {{$row['fecha_fin_formato']}}">
                                                                            <div class="dropdown">
                                                                                <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                    <h3 class="title">{{$row['nombre']}}</h3>
                                                                                    <p>{{$row['descripcion']}}</p>
                                                                                </a >
                                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                    <a class="dropdown-item" href="#"
                                                                                        data-bs-toggle="modal" 
                                                                                        data-bs-target=".modal_datos_academicos_ver_mas"
                                                                                        data-id="{{$row['id']}}"
                                                                                        data-nombre="{{$row['nombre']}}"
                                                                                        data-institucion="{{$row['institucion']}}"
                                                                                        data-pais="{{$row['pais']}}"
                                                                                        data-grado_academico="{{$row['grado_academico']}}"
                                                                                        data-fecha_inicio_formato="{{$row['fecha_inicio_formato']}}"
                                                                                        data-fecha_fin_formato="{{$row['fecha_fin_formato']}}"
                                                                                        data-descripcion="{{$row['descripcion']}}"
                                                                                    ><i data-feather="eye" class="icon-sm me-2"></i> Ver más</a>
                                                                                    <a class="dropdown-item btn_editar_datos_academicos" href="#"
                                                                                        data-bs-toggle="modal" 
                                                                                        data-bs-target=".modal_agregar_datos_academicos"
                                                                                        data-id="{{$row['id']}}"
                                                                                        data-nombre="{{$row['nombre']}}"
                                                                                        data-institucion="{{$row['institucion']}}"
                                                                                        data-id_pais="{{$row['id_pais']}}"
                                                                                        data-id_tipo_grado_academico="{{$row['id_tipo_grado_academico']}}"
                                                                                        data-fecha_inicio="{{$row['fecha_inicio']}}"
                                                                                        data-fecha_fin="{{$row['fecha_fin']}}"
                                                                                        data-descripcion="{{$row['descripcion']}}"
                                                                                    ><i data-feather="edit" class="icon-sm me-2"></i> Editar</a>
                                                                                    <a class="dropdown-item" href="#"
                                                                                        data-bs-toggle="modal" 
                                                                                        data-bs-target=".modal_eliminar"
                                                                                        data-id="{{$row['id']}}"
                                                                                        data-nombre="{{$row['nombre']}}"
                                                                                        data-descripcion="{{$row['descripcion']}}"
                                                                                    ><i data-feather="trash" class="icon-sm me-2"></i> Eliminar</a>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        @endforeach
                                                                </ul>
                                                            @else
                                                                <div class="page-content d-flex align-items-center justify-content-center">
                                <div class="row w-100 mx-0 auth-page">
                                    <div class="col-md-12 col-xl-12 mx-auto d-flex flex-column align-items-center">
                                        <!-- Logo -->
                                        <img src="{{ url('assets/images/escudo.png') }}" class="img-fluid mb-2" alt="Sitio en Construcción" />

                                        <!-- Mensaje principal -->
                                        <h2 class="fw-bolder mt-2 mb-3 tx-70 text-muted text-center">Actualmente no has agregado ningún dato académico.</h2>
                                        <h4 class="mb-2 text-center">Para agregar tu información académica haz clic en el siguiente botón:</h4>
                                       <button type="button" class="btn btn-primary btn_agregar_dato_academico" data-bs-toggle="modal" data-bs-target="#modal_agregar_datos_academicos">
                                                <i data-feather="plus"></i> Agregar Dato Académico
                                            </button>
                                    </div>
                                </div>
                            </div>
                                                            @endif
                                                    </div>
                                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v-messages" role="tabpanel" aria-labelledby="v-experiencia_laboral-tab">
                        <div class="col-md-12 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h1 class="">Esperiencia Laboral</h1>
                                            <p class="text-muted mb-3">Completa o actualiza tus datos académicos.</p>
                                        </div>
                                        <div>
                                            @if(!empty($experiencia_laboral))
                                            <button type="button" class="btn btn-primary btn-icon btn_agregar_experiencia_laboral" data-bs-toggle="modal" data-bs-target="#modal_agregar_experiencia_laboral">
                                                <i data-feather="plus"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </div>

                                    <hr />

                                    <div class="row scroll-container">
                                        <div class="col-md-12">
                                            @if(!empty($experiencia_laboral))
                                            <div class="card">
                                                <div class="card-body">
                                                    @foreach($experiencia_laboral as $row)
                                                    <div class="container-fluid d-flex justify-content-between">
                                                        <div class="col-lg-8 ps-0">
                                                            <a class="noble-ui-logo d-block mt-3 fw-bold">{{$row['puesto']}}</a>                 
                                                            <p class="mt-1 mb-1"><b>{{$row['empleador']}}</b> – {{$row['departamento']}}</p>
                                                            <p class="mb-1"><strong>Ubicación:</strong> {{$row['lugar']}}</p>
                                                            <p class="mb-1"><strong>Funciones principales:</strong></p>
                                                            <p class="mb-2">{!!$row['descripcion']!!}</p>
                                                        </div>
                                                        <div class="col-lg-3 pe-0">
                                                            {{--<h4 class="fw-bold text-uppercase text-end mt-4 mb-2">2020-02</h4>--}}
                                                            <h6 class="text-end mb-0">{{$row['fecha_inicio_formato']}} - {{$row['fecha_fin_formato']}} </h6>
                                                            <div class="text-end">
                                                                <button type="button" class="btn btn-inverse-light btn-xs btn-icon btn_editar_esperiencia_laboral"
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target=".modal_agregar_experiencia_laboral"
                                                                    data-id="{{$row['id']}}"
                                                                    data-puesto="{{$row['puesto']}}"
                                                                    data-empleador="{{$row['empleador']}}"
                                                                    data-departamento="{{$row['departamento']}}"
                                                                    data-lugar="{{$row['lugar']}}"
                                                                    data-fecha_inicio="{{$row['fecha_inicio']}}"
                                                                    data-fecha_fin="{{$row['fecha_fin']}}"
                                                                    data-descripcion="{{$row['descripcion']}}">
                                                                    <i data-feather="edit"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-inverse-light btn-xs btn-icon btn_eliminar_esperiencia_laboral"
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target=".modal_eliminar_experiencia_laboral"
                                                                    data-id="{{$row['id']}}"
                                                                    data-puesto="{{$row['puesto']}}"
                                                                    data-empleador="{{$row['empleador']}}"
                                                                    data-departamento="{{$row['departamento']}}"
                                                                    data-lugar="{{$row['lugar']}}"
                                                                    data-fecha_inicio="{{$row['fecha_inicio']}}"
                                                                    data-fecha_fin="{{$row['fecha_fin']}}"
                                                                    data-descripcion="{{$row['descripcion']}}">
                                                                    <i data-feather="trash"></i>
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @else
                                                                <div class="page-content d-flex align-items-center justify-content-center">
                                <div class="row w-100 mx-0 auth-page">
                                    <div class="col-md-12 col-xl-12 mx-auto d-flex flex-column align-items-center">
                                        <!-- Logo -->
                                        <img src="{{ url('assets/images/escudo.png') }}" class="img-fluid mb-2" alt="Sitio en Construcción" />

                                        <!-- Mensaje principal -->
                                        <h2 class="fw-bolder mt-2 mb-3 tx-70 text-muted text-center">Actualmente no has agregado ninguna experiencia laboral.</h2>
                                        <h4 class="mb-2 text-center">Para agregar tu información laboral haz clic en el siguiente botón:</h4>
                                       <button type="button" class="btn btn-primary btn_agregar_dato_academico" data-bs-toggle="modal" data-bs-target="#modal_agregar_experiencia_laboral">
                                                <i data-feather="plus"></i> Agregar Experiencia Laboral
                                            </button>
                                    </div>
                                </div>
                            </div>
                                                            @endif
                                        </div>
                                    </div>
                    </div>
                    <div class="tab-pane fade" id="v-settings" role="tabpanel" aria-labelledby="v-ofertas_empelos-tab">
                        <p>
                           <div class="page-content d-flex align-items-center justify-content-center">
                                <div class="row w-100 mx-0 auth-page">
                                    <div class="col-md-8 col-xl-6 mx-auto d-flex flex-column align-items-center">
                                        <!-- Logo -->
                                        <img src="{{ url('assets/images/escudo.png') }}" class="img-fluid mb-2" alt="Sitio en Construcción" />

                                        <!-- Mensaje principal -->
                                        <h1 class="fw-bolder mt-2 mb-3 tx-70 text-muted text-center">¡Sitio en construcción!</h1>
                                        <h4 class="mb-2 text-center">Estamos trabajando para mejorar</h4>
                                        <h6 class="text-muted mb-3 text-center">
                                            Nuestro sitio web está siendo actualizado.<br />
                                            Pronto estará disponible nuevamente.
                                        </h6>

                                        <!-- Icono o animación opcional -->
                                        <div class="bg-light rounded p-3 mt-3 text-center shadow-sm w-100">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <div class="spinner-border text-warning me-2" role="status" style="width: 1.5rem; height: 1.5rem;">
                                                    <span class="visually-hidden">Cargando...</span>
                                                </div>
                                                <span class="fw-bold text-warning fs-4">Trabajando en ello...</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example modal_agregar_datos_academicos" id="modal_agregar_datos_academicos" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h6 class="modal-title h6 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="book"></i> Registrar Datos Académicos</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="modal_agregar_datos_academicos_grado_academico" class="form-label">Grado Académico</label>
                                        <select class="form-select" id="modal_agregar_datos_academicos_grado_academico">
                                            <option selected disabled>Seleccione un grado académico</option>
                                            @foreach($tipos_grados_academicos as $row)
                                            <option value="{{$row['id']}}">{{$row['nombre']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="modal_agregar_datos_academicos_formacion" class="form-label">Formación</label>
                                        <input id="modal_agregar_datos_academicos_formacion" class="form-control" type="text" placeholder="Escriba aquí la formación"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="modal_agregar_datos_academicos_institucion" class="form-label">Institución</label>
                                        <input id="modal_agregar_datos_academicos_institucion" class="form-control" type="text" placeholder="Escriba aquí la institución"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="modal_agregar_datos_academicos_pais" class="form-label">País</label>
                                        <select class="form-select" id="modal_agregar_datos_academicos_pais">
                                            <option selected disabled>Seleccione un país</option>
                                            @foreach($paises as $row)
                                            <option value="{{$row['id_pais']}}">{{$row['nombre']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="modal_agregar_datos_academicos_fecha_inicio" class="form-label">Fecha de Inicio</label>
                                        <input
                                            id="modal_agregar_datos_academicos_fecha_inicio"
                                            type="month"
                                            class="form-control mb-4 mb-md-0"
                                            data-inputmask="'alias': 'datetime'"
                                            data-inputmask-inputformat="yyyy/mm/dd"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label for="modal_agregar_datos_academicos_fecha_fin" class="form-label mb-0">
                                                Fecha de Fin
                                            </label>
                                            <div class="form-check form-switch m-0">
                                                <input type="checkbox" class="form-check-input" id="formSwitch1" />
                                                <label class="form-check-label" for="formSwitch1">Presente</label>
                                            </div>
                                        </div>
                                        <input
                                            id="modal_agregar_datos_academicos_fecha_fin"
                                            type="month"
                                            class="form-control mb-4 mb-md-0"
                                            data-inputmask="'alias': 'datetime'"
                                            data-inputmask-inputformat="yyyy/mm/dd"
                                        />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="modal_agregar_datos_academicos_descripcion" class="form-label">Descripción</label>
                                        <textarea
                                            class="form-control"
                                            id="modal_agregar_datos_academicos_descripcion"
                                            maxlength="100"
                                            rows="4"
                                            placeholder="Escriba aquí..."
                                        ></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-secondary">
                <button type="button" class="btn btn-danger btn-xs" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-xs" id="btn_guardar_datos_academicos">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example modal_agregar_experiencia_laboral" id="modal_agregar_experiencia_laboral" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h6 class="modal-title h6 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="briefcase"></i> Registrar Experiencia Laboral</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="modal_agregar_experiencia_laboral_puesto" class="form-label">Puesto</label>
                                        <input id="modal_agregar_experiencia_laboral_puesto" class="form-control" type="text" placeholder="Escriba aquí la el puesto"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="modal_agregar_experiencia_laboral_empleador" class="form-label">Empleador</label>
                                        <input id="modal_agregar_experiencia_laboral_empleador" class="form-control" type="text" placeholder="Escriba aquí el empleador"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="modal_agregar_experiencia_laboral_departamento" class="form-label">Departamento</label>
                                        <input id="modal_agregar_experiencia_laboral_departamento" class="form-control" type="text" placeholder="Escriba aquí el departamento"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="modal_agregar_experiencia_laboral_lugar" class="form-label">Lugar</label>
                                        <input id="modal_agregar_experiencia_laboral_lugar" class="form-control" type="text" placeholder="Escriba aquí el lugar"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="modal_agregar_experiencia_laboral_fecha_inicio" class="form-label">Fecha de Inicio</label>
                                        <input
                                            id="modal_agregar_experiencia_laboral_fecha_inicio"
                                            type="month"
                                            class="form-control mb-4 mb-md-0"
                                            data-inputmask="'alias': 'datetime'"
                                            data-inputmask-inputformat="yyyy/mm/dd"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label for="modal_agregar_experiencia_laboral_fecha_fin" class="form-label mb-0">
                                                Fecha de Fin
                                            </label>
                                            <div class="form-check form-switch m-0">
                                                <input type="checkbox" class="form-check-input" id="formSwitch1_experiencia_laboral" />
                                                <label class="form-check-label" for="formSwitch1_experiencia_laboral">Presente</label>
                                            </div>
                                        </div>
                                        <input
                                            id="modal_agregar_experiencia_laboral_fecha_fin"
                                            type="month"
                                            class="form-control mb-4 mb-md-0"
                                            data-inputmask="'alias': 'datetime'"
                                            data-inputmask-inputformat="yyyy/mm/dd"
                                        />
                                    </div>
                                </div>

                                <!-- <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="modal_agregar_experiencia_laboral_descripcion" class="form-label">Descripción</label>
                                        <textarea
                                            class="form-control"
                                            id="modal_agregar_experiencia_laboral_descripcion"
                                            maxlength="100"
                                            rows="4"
                                            placeholder="Escriba aquí..."
                                        ></textarea>
                                    </div>
                                </div> -->
                                <div class="col-md-12">
                                    <label for="modal_agregar_experiencia_laboral_descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control" name="tinymce" id="modal_agregar_experiencia_laboral_descripcion" maxlength="100"
                                            rows="4"
                                            placeholder="Escriba aquí..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-secondary">
                <button type="button" class="btn btn-danger btn-xs" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-xs" id="btn_guardar_experiencia_laboral">Guardar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal_eliminar" id="modal_eliminar" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title h4 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="x"></i> Eliminar Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="row">
                            <center>
                                <i class="btn-icon-prepend text-warning" data-feather="alert-circle" style="width: 90px; height: 90px;"></i>
                                <br><br>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <h4><label class="form-label"><strong>¿Realmente deseas eliminar este registro?</strong></label></h4>
                                        <br>
                                        <h5><label class="form-label" id="modal_eliminar_informacion_datos_academicos"></label></h5>
                                        <br>
                                        <p class="fw-normal">Este proceso no se puede revertir</p>
                                    </div>
                                </div>
                            </center>
                        </div>
                        <!-- Row -->
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-secondary">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-sm" id="btn_eliminar_dato_academico">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal_eliminar_experiencia_laboral" id="modal_eliminar_experiencia_laboral" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title h4 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="x"></i> Eliminar Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="row">
                            <center>
                                <i class="btn-icon-prepend text-warning" data-feather="alert-circle" style="width: 90px; height: 90px;"></i>
                                <br><br>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <h4><label class="form-label"><strong>¿Realmente deseas eliminar este registro?</strong></label></h4>
                                        <br>
                                        <h5><label class="form-label" id="modal_eliminar_informacion_experiencia_laboral"></label></h5>
                                        <br>
                                        <p class="fw-normal">Este proceso no se puede revertir</p>
                                    </div>
                                </div>
                            </center>
                        </div>
                        <!-- Row -->
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-secondary">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-sm" id="btn_eliminar_experiencia_laboral">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal_datos_academicos_ver_mas" id="modal_datos_academicos_ver_mas" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="row">
                            <center>
                                <div class="row">
                                    <div class="col-md-12"> 
                                        <div class="row">
                                            <div class="col-md-12 stretch-card grid-margin grid-margin-md-0">
                                                <div class="card">
                                                    <div class="card-body">
                                                    <h4 class="text-center mt-3 mb-4" id="modal_ver_mas_grado_academico">Basic</h4>
                                                    <i data-feather="book" class="text-primary icon-xxl d-block mx-auto my-3"></i>
                                                    <h1 class="text-center" id="modal_ver_mas_formacion">$40</h1>
                                                    <p class="text-muted text-center mb-4 fw-light" id="modal_ver_mas_institucion_pais">per month</p>
                                                    <h5 class="text-primary text-center mb-4" id="modal_ver_mas_fecha_inicio_fecha_fin">Up to 25 units</h5>
                                                    <table class="mx-auto">
                                                        <tr>
                                                            <td><i data-feather="chevrons-right" class="icon-md text-primary me-2"></i></td>
                                                            <td><p id="modal_ver_mas_descripcion">Accounting dashboard</p></td>
                                                        </tr>
                                                    </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div
                            </center>
                        </div>
                        <!-- Row -->
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-secondary">
                <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('plugin-scripts')
<script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/prismjs/prism.js') }}"></script>
  <script src="{{ asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/easymde/easymde.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/ace-builds/ace.js') }}"></script>
  <script src="{{ asset('assets/plugins/ace-builds/theme-chaos.js') }}"></script>
@endpush
@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>
  <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
  <script src="{{ asset('assets/js/tinymce.js') }}"></script>
  <script src="{{ asset('assets/js/easymde.js') }}"></script>
  <script src="{{ asset('assets/js/ace.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=mzutkZDE"></script>
  <script type="text/javascript">
    var table = null; 
    var accion = null;
    var btn_activo = true;
    var numero_registro_asignado = "{{$datos_generales['numero_registro_asignado']}}";
    //inicia datos generales
    var id = "{{$datos_generales['id_ficha_estudiante']}}";
    var primer_nombre_estudiante = $("#primer_nombre_estudiante").val();
    var segundo_nombre_estudiante = $("#segundo_nombre_estudiante").val();
    var primer_apellido_estudiante = $("#primer_apellido_estudiante").val();
    var segundo_apellido_estudiante = $("#segundo_apellido_estudiante").val();
    var correo_electronico = $("#correo_electronico").val();
    var identidad_estudiante = $("#identidad_estudiante").val();
    var direccion_local_telefono = $("#direccion_local_telefono").val();
    var fecha_nacimiento_estudiante = $("#fecha_nacimiento_estudiante").val();
    var gender_radio = $('input[name="gender_radio"]:checked').val();
    var departamento = null;
    var municipio = null;
    var direccion_local_barrio_colonia = null;
    //finaliza datos generales
    //inicia datos academicos
    var id_datos_academicos = null;
    var formacion = null;
    var institucion = null;
    var id_pais = null;
    var id_grado_cademico = null;
    var fecha_inicio = null;
    var fecha_fin = null;
    var descripcion = null;
    //finaliza datos academicos
    //inicia experiencia laboral
    var id_experiencia_laboaral = null;
    var puesto = null;
    var departamento = null;
    var lugar = null;
    var fecha_inicio_experiencia_laboaral = null;
    var fecha_fin_experiencia_laboaral = null;
    var descripcion_experiencia_laboaral = null;
    //finaliza experiencia laboral
    var url_guardar_datos_generales = "{{url('/egresados/datos_generales/guardar')}}"; 
    var url_guardar_datos_academicos = "{{url('/egresados/datos_academicos/guardar')}}"; 
    var url_guardar_esperiencia_laboral = "{{url('/egresados/esperiencia_laboral/guardar')}}"; 
    var url_datos_generales_municipios = "{{url('/egresados/datos_generales/municipios')}}"; 
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#v-datos_generales-tab").on("click", function () {
           localStorage.setItem("tab","#v-datos_generales-tab");
        });

        $("#v-datos_academicos-tab").on("click", function () {
           localStorage.setItem("tab","#v-datos_academicos-tab");
        });

        $("#v-experiencia_laboral-tab").on("click", function () {
           localStorage.setItem("tab","#v-experiencia_laboral-tab");
        });

        $("#v-ofertas_empelos-tab").on("click", function () {
           localStorage.setItem("tab","#v-ofertas_empelos-tab");
        });

        const tab_active = localStorage.getItem("tab");
        var tabEl = document.querySelector(tab_active == null ? "#v-datos_generales-tab" : tab_active);
        var tab = new bootstrap.Tab(tabEl);
        tab.show();


        if({{$datos_generales['direccion_local_departamento']}} != null){
            departamento = {{$datos_generales['direccion_local_departamento']}};
            cargar_municipios();
        }
        
        $("#departamento").val({{$datos_generales['direccion_local_departamento']}});
        $("#direccion_local_barrio_colonia").val("{{$datos_generales['direccion_local_barrio_colonia']}}");

        $.validator.setDefaults({
            submitHandler: function() {
                primer_nombre_estudiante = $("#primer_nombre_estudiante").val();
                segundo_nombre_estudiante = $("#segundo_nombre_estudiante").val();
                primer_apellido_estudiante = $("#primer_apellido_estudiante").val();
                segundo_apellido_estudiante = $("#segundo_apellido_estudiante").val();
                correo_electronico = $("#correo_electronico").val();
                identidad_estudiante = $("#identidad_estudiante").val();
                direccion_local_telefono = $("#direccion_local_telefono").val();
                fecha_nacimiento_estudiante = $("#fecha_nacimiento_estudiante").val();
                gender_radio = $('input[name="gender_radio"]:checked').val();
                departamento = $('#departamento').val();
                municipio = $('#municipio').val();
                direccion_local_barrio_colonia = $("#direccion_local_barrio_colonia").val();
                guardar_datos_generales();
                //alert(departamento);
                //$('#signupForm').submit();
        }
});

    $(function() {
        $("#signupForm").validate({
            rules: {
                primer_nombre_estudiante: {
                    required: true
                },
                segundo_nombre_estudiante: {
                    required: true
                },
                primer_apellido_estudiante: {
                    required: true
                },
                segundo_apellido_estudiante: {
                    required: true
                },
                correo_electronico: {
                    required: true,
                    email: true
                },
                identidad_estudiante: {
                    required: true
                },
                direccion_local_telefono: {
                    required: true
                },
                fecha_nacimiento_estudiante: {
                    required: true
                },
                gender_radio: {
                    required: true
                },
                departamento: {
                    required: true
                },
                municipio: {
                    required: true
                },
                direccion_local_barrio_colonia: {
                    required: true
                },
                // skill_check: {
                //     required: true
                // },
                // terms_agree: "required"
            },
            messages: {
                primer_nombre_estudiante: {
                    required: "Por favor, ingrese su primer nombre"
                },
                segundo_nombre_estudiante: {
                    required: "Por favor, ingrese su segundo nombre"
                },
                primer_apellido_estudiante: {
                    required: "Por favor, ingrese su primer apellido"
                },
                segundo_apellido_estudiante: {
                    required: "Por favor, ingrese su segundo apellido"
                },
                correo_electronico: "Por favor, ingrese un correo electrónico válido",
                identidad_estudiante: {
                    required: "Por favor, ingrese su número de identificación"
                },
                direccion_local_telefono: {
                    required: "Por favor, ingrese su número de teléfono"
                },
                fecha_nacimiento_estudiante: "Por favor, ingrese su fecha de nacimiento",
                gender_radio: "Por favor, seleccione su género",
                departamento: {
                    required: "Por favor, seleccione un departamento"
                },
                municipio: {
                    required: "Por favor, seleccione un municipio"
                },
                direccion_local_barrio_colonia: {
                    required: "Por favor, ingrese su dirección"
                },
                // skill_check: "Por favor, seleccione al menos una habilidad",
                // terms_agree: "Debe aceptar los términos y condiciones"
            },
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");

                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                }
                else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
                    error.insertAfter(element.parent().parent());
                }
                else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                    error.appendTo(element.parent().parent());
                }
                else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element, errorClass) {
                if ($(element).prop('type') != 'checkbox' && $(element).prop('type') != 'radio') {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                }
            },
            unhighlight: function(element, errorClass) {
                if ($(element).prop('type') != 'checkbox' && $(element).prop('type') != 'radio') {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                }
            }
        });

         $('#formSwitch1').change(function() {
            $('#modal_agregar_datos_academicos_fecha_fin').prop('disabled', this.checked);
            fecha_fin = null;
            $("#modal_agregar_datos_academicos_fecha_fin").val(null);
        });

        $('#formSwitch1_experiencia_laboral').change(function() {
            $('#modal_agregar_experiencia_laboral_fecha_fin').prop('disabled', this.checked);
            fecha_fin_experiencia_laboaral = null;
            $("#modal_agregar_experiencia_laboral_fecha_fin").val(null);
        });
    });

    $(function() {
                'use strict';

                //Tinymce editor
                if ($("#modal_agregar_experiencia_laboral_descripcion").length) {
                    tinymce.init({
                    selector: '#modal_agregar_experiencia_laboral_descripcion',
                    height: 250,
                    menubar: false,
                    default_text_color: 'red',
                    plugins: 'advlist autolink lists link image charmap preview anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen',
                    toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
                    //toolbar2: 'forecolor backcolor emoticons',
                    image_advtab: true,
                    templates: [{
                        title: 'Test template 1',
                        content: 'Test 1'
                        },
                        // {
                        // title: 'Test template 2',
                        // content: 'Test 2'
                        // }
                    ],
                    content_css: []
                    });
                }
                
            });

    $(".btn_editar_datos_academicos, .btn_editar_esperiencia_laboral").on("click", function () {
        accion = 2;
    })

    $(".btn_agregar_dato_academico, .btn_agregar_experiencia_laboral").on("click", function () {
        accion = 1;
    })

    $("#modal_datos_academicos_ver_mas").on("show.bs.modal", function (e) {
        $('#formSwitch1').prop('checked', false);
        $('#modal_agregar_datos_academicos_fecha_fin').prop('disabled', false);
        var triggerLink = $(e.relatedTarget);
        id_datos_academicos = triggerLink.data("id");
        formacion = triggerLink.data("nombre");
        institucion = triggerLink.data("institucion");
        pais = triggerLink.data("pais");
        grado_academico = triggerLink.data("grado_academico");
        fecha_inicio_formato = triggerLink.data("fecha_inicio_formato");
        fecha_fin_formato = triggerLink.data("fecha_fin_formato");
        descripcion = triggerLink.data("descripcion");
        $("#modal_ver_mas_grado_academico").html(grado_academico);
        $("#modal_ver_mas_formacion").html(formacion);
        $("#modal_ver_mas_institucion_pais").html(institucion+' - '+pais);
        $("#modal_ver_mas_fecha_inicio_fecha_fin").html(fecha_inicio_formato+' - '+fecha_fin_formato);
        $("#modal_ver_mas_descripcion").html(descripcion);
    });

    $("#modal_agregar_experiencia_laboral").on("show.bs.modal", function (e) {
        $('#formSwitch1_experiencia_laboral').prop('checked', false);
        $('#modal_agregar_experiencia_laboral_fecha_fin').prop('disabled', false);
        var triggerLink = $(e.relatedTarget);
        id_experiencia_laboaral = triggerLink.data("id");
        puesto = triggerLink.data("puesto");
        empleador = triggerLink.data("empleador");
        departamento = triggerLink.data("departamento");
        lugar = triggerLink.data("lugar");
        fecha_inicio_experiencia_laboaral = triggerLink.data("fecha_inicio");
        fecha_fin_experiencia_laboaral = triggerLink.data("fecha_fin");
        descripcion_experiencia_laboaral = triggerLink.data("descripcion");
        $("#modal_agregar_experiencia_laboral_puesto").val(puesto);
        $("#modal_agregar_experiencia_laboral_empleador").val(empleador);
        $("#modal_agregar_experiencia_laboral_departamento").val(departamento);
        $("#modal_agregar_experiencia_laboral_lugar").val(lugar);
        $("#modal_agregar_experiencia_laboral_fecha_inicio").val(fecha_inicio_experiencia_laboaral);
        $("#modal_agregar_experiencia_laboral_fecha_fin").val(fecha_fin_experiencia_laboaral);
        //$("#modal_agregar_experiencia_laboral_descripcion").val(descripcion);
        tinymce.get('modal_agregar_experiencia_laboral_descripcion').setContent(descripcion_experiencia_laboaral || '');
        if(fecha_fin_experiencia_laboaral == null || fecha_fin_experiencia_laboaral == ''){
            $('#formSwitch1_experiencia_laboral').prop('checked', true);
            $('#modal_agregar_experiencia_laboral_fecha_fin').prop('disabled', true);
        }
    });

    $("#modal_agregar_datos_academicos").on("show.bs.modal", function (e) {
        $('#formSwitch1').prop('checked', false);
        $('#modal_agregar_datos_academicos_fecha_fin').prop('disabled', false);
        var triggerLink = $(e.relatedTarget);
        id_datos_academicos = triggerLink.data("id");
        formacion = triggerLink.data("nombre");
        institucion = triggerLink.data("institucion");
        id_pais = triggerLink.data("id_pais");
        id_tipo_grado_academico = triggerLink.data("id_tipo_grado_academico");
        fecha_inicio = triggerLink.data("fecha_inicio");
        fecha_fin = triggerLink.data("fecha_fin");
        descripcion = triggerLink.data("descripcion");
        $("#modal_agregar_datos_academicos_formacion").val(formacion);
        $("#modal_agregar_datos_academicos_institucion").val(institucion);
        $("#modal_agregar_datos_academicos_pais").val(id_pais);
        $("#modal_agregar_datos_academicos_grado_academico").val(id_tipo_grado_academico);
        $("#modal_agregar_datos_academicos_fecha_inicio").val(fecha_inicio);
        $("#modal_agregar_datos_academicos_fecha_fin").val(fecha_fin);
        $("#modal_agregar_datos_academicos_descripcion").val(descripcion);
        if(fecha_fin == null || fecha_fin == ''){
            $('#formSwitch1').prop('checked', true);
            $('#modal_agregar_datos_academicos_fecha_fin').prop('disabled', true);
        }
    });

    $("#btn_guardar_datos_academicos").on("click", function () {
        formacion = $("#modal_agregar_datos_academicos_formacion").val();
        institucion = $("#modal_agregar_datos_academicos_institucion").val();
        id_pais = $("#modal_agregar_datos_academicos_pais").val();
        id_grado_cademico = $("#modal_agregar_datos_academicos_grado_academico").val();
        fecha_inicio = $("#modal_agregar_datos_academicos_fecha_inicio").val();
        fecha_fin = $("#modal_agregar_datos_academicos_fecha_fin").val();
        descripcion = $("#modal_agregar_datos_academicos_descripcion").val();
     
            if(formacion == null || formacion == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Valor requerido para Formación.'
                })
                return true;
            }

            if(institucion == null || institucion == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Valor requerido para Institución.'
                })
                return true;
            }

            if(id_pais == null || id_pais == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Valor requerido para País.'
                })
                return true;
            }

            if(id_grado_cademico == null || id_grado_cademico == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Valor requerido para Grado Académico.'
                })
                return true;
            }

            if(fecha_inicio == null || fecha_inicio == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Valor requerido para Fecha de Inicio.'
                })
                return true;
            }

            if (!$('#formSwitch1').is(':checked')) {
                if(fecha_fin == null || fecha_fin == ''){
                    Toast.fire({
                        icon: 'error',
                        title: 'Valor requerido para Fecha de Fin.'
                    })
                    return true;
                }
            }

            if(descripcion == null || descripcion == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Valor requerido para Descripción.'
                })
                return true;
            }

            // ToastLG.fire({
            //         icon: "warning",
            //         title: '!Funcionalidad en construcción!',
            //         html: 'Estamos trabajando para mejorar',
            //         timer: 3000
            //     })
            
            if(btn_activo){
                guardar_datos_academicos();
            }
            

    });

    $("#btn_guardar_experiencia_laboral").on("click", function () {
        puesto = $("#modal_agregar_experiencia_laboral_puesto").val();
        empleador = $("#modal_agregar_experiencia_laboral_empleador").val();
        departamento = $("#modal_agregar_experiencia_laboral_departamento").val();
        lugar = $("#modal_agregar_experiencia_laboral_lugar").val();
        fecha_inicio_experiencia_laboaral = $("#modal_agregar_experiencia_laboral_fecha_inicio").val();
        fecha_fin_experiencia_laboaral = $("#modal_agregar_experiencia_laboral_fecha_fin").val();
        descripcion_experiencia_laboaral = tinymce.get('modal_agregar_experiencia_laboral_descripcion').getContent();
     
            if(puesto == null || puesto == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Valor requerido para Puesto.'
                })
                return true;
            }

            if(empleador == null || empleador == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Valor requerido para Empleador.'
                })
                return true;
            }

            if(departamento == null || departamento == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Valor requerido para Departamento.'
                })
                return true;
            }

            if(lugar == null || lugar == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Valor requerido para Lugar.'
                })
                return true;
            }

            if(fecha_inicio_experiencia_laboaral == null || fecha_inicio_experiencia_laboaral == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Valor requerido para Fecha de Inicio.'
                })
                return true;
            }

            if (!$('#formSwitch1_experiencia_laboral').is(':checked')) {
                if(fecha_fin_experiencia_laboaral == null || fecha_fin_experiencia_laboaral == ''){
                    Toast.fire({
                        icon: 'error',
                        title: 'Valor requerido para Fecha de Fin.'
                    })
                    return true;
                }
            }

            if(descripcion_experiencia_laboaral == null || descripcion_experiencia_laboaral == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Valor requerido para Descripción.'
                })
                return true;
            }
            
            if(btn_activo){
                guardar_esperiencia_laboral();
            }
            

    });

        $("#modal_eliminar").on("show.bs.modal", function (e) {
            accion = 3;
            var triggerLink = $(e.relatedTarget);
            id_datos_academicos = triggerLink.data("id");
            formacion = triggerLink.data("nombre");
            descripcion = triggerLink.data("descripcion");
            $("#modal_eliminar_informacion_datos_academicos").html(formacion);
        });

        $("#modal_eliminar_experiencia_laboral").on("show.bs.modal", function (e) {
            accion = 3;
            var triggerLink = $(e.relatedTarget);
            id_experiencia_laboaral = triggerLink.data("id");
            puesto = triggerLink.data("puesto");
            empleador = triggerLink.data("empleador");
            departamento = triggerLink.data("departamento");
            lugar = triggerLink.data("lugar");
            fecha_inicio_experiencia_laboaral = triggerLink.data("fecha_inicio");
            fecha_fin_experiencia_laboaral = triggerLink.data("fecha_fin");
            descripcion_experiencia_laboaral = triggerLink.data("descripcion");
            $("#modal_eliminar_informacion_experiencia_laboral").html(puesto);
        });

        $(".modal-footer").on("click", "#btn_eliminar_dato_academico", function () { 
            if(btn_activo){
                guardar_datos_academicos(); 
            }
        }); 

        $(".modal-footer").on("click", "#btn_eliminar_experiencia_laboral", function () { 
            if(btn_activo){
                guardar_esperiencia_laboral(); 
            }
        });

    });

        $('#departamento').change(function() {
            departamento = $(this).val();
            cargar_municipios();
            console.log('Seleccionaste: ' + departamento);
        });

    function guardar_datos_generales() {
        espera('Tu información se esta guardando...');
        btn_activo = false;
        //console.log(hora_inicio);
        $.ajax({
            type: "post",
            url: url_guardar_datos_generales,
            data: {
                id: id,
                primer_nombre_estudiante : primer_nombre_estudiante,
                segundo_nombre_estudiante : segundo_nombre_estudiante,
                primer_apellido_estudiante : primer_apellido_estudiante,
                segundo_apellido_estudiante : segundo_apellido_estudiante,
                correo_electronico : correo_electronico,
                identidad_estudiante : identidad_estudiante,
                direccion_local_telefono : direccion_local_telefono,
                fecha_nacimiento_estudiante : fecha_nacimiento_estudiante,
                gender_radio : gender_radio,
                departamento : departamento,
                municipio : municipio,
                direccion_local_barrio_colonia : direccion_local_barrio_colonia 
            },
            success: function (data) {
                if (data.msgError != null) {
                    titleMsg = "Error al Guardar";
                    textMsg = data.msgError;
                    typeMsg = "error";
                    timer = null;
                    btn_activo = true;
                } else {
                    titleMsg = "Datos Guardados";
                    textMsg = data.msgSuccess;
                    typeMsg = "success";
                    timer = 3000;
                }
                console.log(textMsg);
                ToastLG.fire({
                    icon: typeMsg,
                    title: titleMsg,
                    html: textMsg,
                    timer: timer
                })
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            },
        });
    }

    function guardar_datos_academicos() {
        espera('Tu información se esta guardando...');
        btn_activo = false;
        //console.log(hora_inicio);
        $.ajax({
            type: "post",
            url: url_guardar_datos_academicos,
            data: {
                accion : accion,
                id : id_datos_academicos,
                numero_registro_asignado : numero_registro_asignado,
                formacion : formacion,
                institucion : institucion,
                id_pais : id_pais,
                id_grado_cademico : id_grado_cademico,
                fecha_inicio : fecha_inicio,
                fecha_fin : fecha_fin,
                descripcion : descripcion
            },
            success: function (data) {
                if (data.msgError != null) {
                    titleMsg = "Error al Guardar";
                    textMsg = data.msgError;
                    typeMsg = "error";
                    timer = null;
                    btn_activo = true;
                } else {
                    titleMsg = "Datos Guardados";
                    textMsg = data.msgSuccess;
                    typeMsg = "success";
                    timer = 3000;
                    location.reload();
                }
                console.log(textMsg);
                ToastLG.fire({
                    icon: typeMsg,
                    title: titleMsg,
                    html: textMsg,
                    timer: timer
                })

            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            },
        });
    }

    function guardar_esperiencia_laboral() {
        espera('Tu información se esta guardando...');
        btn_activo = false;
        //console.log(hora_inicio);
        $.ajax({
            type: "post",
            url: url_guardar_esperiencia_laboral,
            data: {
                accion : accion,
                id : id_experiencia_laboaral,
                numero_registro_asignado : numero_registro_asignado,
                puesto : puesto,
                empleador : empleador,
                departamento : departamento,
                lugar : lugar,
                fecha_inicio_experiencia_laboaral : fecha_inicio_experiencia_laboaral,
                fecha_fin_experiencia_laboaral : fecha_fin_experiencia_laboaral,
                descripcion_experiencia_laboaral : descripcion_experiencia_laboaral
            },
            success: function (data) {
                if (data.msgError != null) {
                    titleMsg = "Error al Guardar";
                    textMsg = data.msgError;
                    typeMsg = "error";
                    timer = null;
                    btn_activo = true;
                } else {
                    titleMsg = "Datos Guardados";
                    textMsg = data.msgSuccess;
                    typeMsg = "success";
                    timer = 3000;
                    location.reload();
                }
                console.log(textMsg);
                ToastLG.fire({
                    icon: typeMsg,
                    title: titleMsg,
                    html: textMsg,
                    timer: timer
                })

            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            },
        });
    }

    function cargar_municipios() {
        espera('Cargado municipios...');
        //console.log(hora_inicio);
        $.ajax({
            type: "post",
            url: url_datos_generales_municipios,
            data: {
                departamento : departamento
            },
            success: function (data) {
                if (data.msgError != null) {
                    titleMsg = "Error al Cargar";
                    textMsg = data.msgError;
                    typeMsg = "error";
                    timer = null;
                    btn_activo = true;
                } else {
                    titleMsg = "Datos Cargados";
                    textMsg = data.msgSuccess;
                    typeMsg = "success";
                    timer = 1000;

                    $('#municipio').empty();
                    $('#municipio').prop('disabled', false);

                    $.each(data.municipios, function(index, item) {
                        $('#municipio').append(
                            $('<option>', {
                                value: item.id_municipio,
                                text: item.descripcion_municipio
                            })
                        );
                    });
            
                $("#municipio").val({{$datos_generales['direccion_local_municipio']}});
            

                }
                console.log(textMsg);
                ToastLG.fire({
                    icon: typeMsg,
                    title: titleMsg,
                    html: textMsg,
                    timer: timer
                })
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            },
        });
    }

  
    const ToastLG = Swal.mixin({
            //toast: true,
            //position: 'top-end',
            showConfirmButton: false,
            timerProgressBar: true,
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

    function espera(html){
        let timerInterval
        Swal.fire({
            icon: 'warning',
            title: '¡Espera!',
            html: html,
            timer: null,
            timerProgressBar: true,
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
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
            console.log('I was closed by the timer')
            }
        })
    }
    

  </script>
@endpush