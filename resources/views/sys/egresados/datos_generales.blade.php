@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-5 col-md-3 pe-0">
                <div class="nav nav-tabs nav-tabs-vertical" id="v-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-datos_generales-tab" data-bs-toggle="tab" href="#v-datos_generales" role="tab" aria-controls="v-datos_generales" aria-selected="true">Datos Generales</a>
                    <a class="nav-link" id="v-profile-tab" data-bs-toggle="tab" href="#v-profile" role="tab" aria-controls="v-profile" aria-selected="false">Datos Académicos</a>
                    <a class="nav-link" id="v-messages-tab" data-bs-toggle="tab" href="#v-messages" role="tab" aria-controls="v-messages" aria-selected="false">Messages</a>
                    <a class="nav-link" id="v-settings-tab" data-bs-toggle="tab" href="#v-settings" role="tab" aria-controls="v-settings" aria-selected="false">Settings</a>
                </div>
            </div>
            <div class="col-7 col-md-9 ps-0">
                <div class="tab-content tab-content-vertical border p-3" id="v-tabContent">
                    <div class="tab-pane fade show active" id="v-datos_generales" role="tabpanel" aria-labelledby="v-datos_generales-tab">
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
                                                    <option selected disabled>Seleccione un municipio</option>
                                                    @foreach($departamentos as $row)
                                                        <option @if($datos_generales['direccion_local_municipio'] == $row['id']) selected @endif value="{{$row['id']}}">{{$row['name']}}</option>
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
                    <div class="tab-pane fade" id="v-profile" role="tabpanel" aria-labelledby="v-profile-tab">
                        <h6 class="mb-1">Profile</h6>
                        <p>
                            Nulla est ullamco ut irure incididunt nulla Lorem Lorem minim irure officia enim reprehenderit. Magna duis labore cillum sint adipisicing exercitation ipsum. Nostrud ut anim non exercitation velit laboris fugiat
                            cupidatat. Commodo esse dolore fugiat sint velit ullamco magna consequat voluptate minim amet aliquip ipsum aute laboris nisi.
                        </p>
                    </div>
                    <div class="tab-pane fade" id="v-messages" role="tabpanel" aria-labelledby="v-messages-tab">
                        <h6 class="mb-1">Messages</h6>
                        <p>
                            Nulla est ullamco ut irure incididunt nulla Lorem Lorem minim irure officia enim reprehenderit. Magna duis labore cillum sint adipisicing exercitation ipsum. Nostrud ut anim non exercitation velit laboris fugiat
                            cupidatat. Commodo esse dolore fugiat sint velit ullamco magna consequat voluptate minim amet aliquip ipsum aute laboris nisi.
                        </p>
                    </div>
                    <div class="tab-pane fade" id="v-settings" role="tabpanel" aria-labelledby="v-settings-tab">
                        <h6 class="mb-1">Settings</h6>
                        <p>
                            Nulla est ullamco ut irure incididunt nulla Lorem Lorem minim irure officia enim reprehenderit. Magna duis labore cillum sint adipisicing exercitation ipsum. Nostrud ut anim non exercitation velit laboris fugiat
                            cupidatat. Commodo esse dolore fugiat sint velit ullamco magna consequat voluptate minim amet aliquip ipsum aute laboris nisi.
                        </p>
                    </div>
                </div>
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
@endpush
@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>
  <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=mzutkZDE"></script>
  <script type="text/javascript">
    var table = null; 
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
    var direccion_local_barrio_colonia = $("#direccion_local_barrio_colonia").val("{{$datos_generales['direccion_local_barrio_colonia']}}");
    var url_guardar_datos_generales = "{{url('/egresados/datos_generales/guardar')}}"; 
    var url_datos_generales_municipios = "{{url('/egresados/datos_generales/municipios')}}"; 
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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
                //alert("¡Formulario enviado!");
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
                Toast.fire({
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
        btn_activo = false;
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
                                value: item.id,
                                text: item.name
                            })
                        );
                    });
                }
                console.log(textMsg);
                Toast.fire({
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

  
    const Toast = Swal.mixin({
            //toast: true,
            //position: 'top-end',
            showConfirmButton: false,
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