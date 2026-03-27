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

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
<!-- End fonts -->
<!-- CSRF Token -->
<meta name="_token" content="{{ csrf_token() }}">
<link rel="shortcut icon" href="{{ url(asset('/assets/images/hoja-unag.png')) }}">
<!-- plugin css -->
<link href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" />
<!-- end plugin css -->

@stack('plugin-styles')
{{-- custom css --}}
<link rel="stylesheet" href="{{ asset('/css/custom.css') }}" />
<!-- common css -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
<!-- end common css -->
@stack('style')
</head>
<body data-base-url="{{url('/')}}">
<script src="{{ asset('assets/js/spinner.js') }}"></script>

<div class="" id="app">
<div class="">
<div class="page-content">
<div class="d-flex justify-content-center align-items-center" style="
background-image: radial-gradient(circle at center, rgba(255,255,255,0.6) 0%, rgba(240,240,240,0.95) 100%),
url('{{ asset('assets/images/fondo_blanco.jpg') }}');
background-size: cover;
background-repeat: no-repeat;
background-position: center;
background-blend-mode: multiply;
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
Solicitud de Reingreso
</h2>
<p class="text-verdeOscuro mb-0"><strong>SYS UNAG</strong></p>
</div>

@if($tiene_solicitud_abierta)
<!-- Alerta para solicitud existente -->
<div class="alert alert-warning text-center mb-4">
<h5 class="alert-heading">¡Atención!</h5>
<p class="mb-3">Ya cuenta con una solicitud de reingreso en proceso. No puede enviar otra solicitud hasta que la actual esté
cerrada.</p>
<button class="btn btn-primary btn-sm" onclick="showSwal('title-and-text')">Ver Detalles</button>
</div>
<div class="text-center">
<a href="/buscador/buscar" class="btn btn-secondary btn-lg">
<i class="bi bi-arrow-left"></i> Volver al Buscador
</a>
</div>

@else
<!-- Formulario de Reingreso Centrado -->
<div class="container-fluid">
<div class="card border-0 shadow-sm">
<div class="card-body p-4">
<h4 class="card-title text-center mb-3">Datos del Solicitante</h4>
<p class="text-muted text-center mb-4">Complete todos los campos obligatorios marcados con <span class="text-danger">*</span></p>
<form id="reingresoForm">
@csrf
<input type="hidden" name="identidad" value="{{ $identidad }}">
<!-- Datos alineados a la izquierda con interlineado 1.5 -->
<div style="line-height: 1.5; max-width: 500px; margin: 0 auto;">

<div class="row g-3 mb-3">
<div class="col-md-12">
<label for="identidad_display" class="form-label">Identidad <span class="text-danger">*</span></label>
<input type="text" class="form-control" id="identidad_display" value="{{ $identidad }}" disabled>
</div>
</div>
<div class="row g-3 mb-3">
<div class="col-md-6">
<label for="primer_nombre" class="form-label">Primer Nombre <span class="text-danger">*</span></label>
<input id="primer_nombre" class="form-control" name="primer_nombre" type="text" value="{{
$persona['primer_nombre'] ??  '' }}">
</div>
<div class="col-md-6">
<label for="segundo_nombre" class="form-label">Segundo Nombre </label>
<input id="segundo_nombre" class="form-control" name="segundo_nombre" type="text" value="{{
$persona['segundo_nombre'] ?? '' }}">
</div>
</div>
<div class="row g-3 mb-3">
<div class="col-md-6">
<label for="primer_apellido" class="form-label">Primer Apellido <span class="text-danger">*</span></label>
<input id="primer_apellido" class="form-control" name="primer_apellido" type="text" value="{{
$persona['primer_apellido'] ?? '' }}">
</div>
<div class="col-md-6">
<label for="segundo_apellido" class="form-label">Segundo Apellido</label>
<input id="segundo_apellido" class="form-control" name="segundo_apellido" type="text" value="{{
$persona['segundo_apellido'] ?? '' }}">
</div>

</div>
<div class="row g-3 mb-3">
<div class="col-md-6">
<label for="telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
<input id="telefono" class="form-control" name="telefono" type="text"  pattern="\d{8}" minlength="8" value="{{ $persona['telefono'] ?? '' }}">
</div>
<div class="col-md-6">
<label for="correo" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
<input id="correo" class="form-control" name="correo" type="email" value="{{ $persona['correo'] ?? '' }}">
</div>
</div>
</div>
<!-- Botones centrados -->

<div class="text-center mt-4">
<button class="btn btn-primary btn-lg px-4" type="submit" id="btn-enviar">Enviar Solicitud</button>
<a href="/buscador/buscar" class="btn btn-secondary btn-lg px-4 ms-3">
<i class="bi bi-arrow-left"></i> Volver
</a>
</div>
<!-- Loading Spinner -->
<div id="loading" class="text-center mt-3" style="display: none;">
<div class="spinner-border text-primary" role="status">
<span class="visually-hidden">Cargando...</span>
</div>
<p class="mt-2">Enviando solicitud...</p>
</div>
</form>

</div>
</div>
</div>
@endif
<!-- Logo SETIC centrado -->
<div class="text-center mt-4">
<img src="{{ asset('assets/images/logo_setic_new.png') }}" class="mb-3" alt="Logo SETIC" style="width: 140px;">
</div>
</div>
</div>
</div>
@include('layout.footer')
</div>
</div>

<!-- base js - IMPORTANTE: jQuery debe cargarse antes que las validaciones -->
<script src="{{ asset('js/app.js') }}"></script>
<!-- Cargar jQuery explícitamente si no está en app.js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/plugins/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<!-- plugin js -->
<script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/typeahead-js/typeahead.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
<script src="{{ asset('assets/plugins/dropzone/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<!-- end plugin js -->
<!-- common js -->
<script src="{{ asset('assets/js/template.js') }}"></script>
<!-- end common js -->

<!-- Custom scripts -->
<script src="{{ asset('assets/js/form-validation.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-maxlength.js') }}"></script>
<script src="{{ asset('assets/js/inputmask.js') }}"></script>
<script src="{{ asset('assets/js/select2.js') }}"></script>
<script src="{{ asset('assets/js/typeahead.js') }}"></script>
<script src="{{ asset('assets/js/tags-input.js') }}"></script>
<script src="{{ asset('assets/js/dropzone.js') }}"></script>
<script src="{{ asset('assets/js/dropify.js') }}"></script>


<script>
// Verificar que jQuery está cargado
if (typeof jQuery === 'undefined') {
    console.error('jQuery no está cargado');
}

$(document).ready(function() {
    console.log('Document ready - jQuery cargado correctamente');



    // Configuración de SweetAlert2 para diferentes tipos de alertas
    window.showSwal = function(type) {
        console.log('showSwal llamado con tipo:', type);
        switch(type) {
            case 'basic':
                Swal.fire({
                    title: 'Campo Requerido',
                    text: 'Debe llenar todos los campos obligatorios',
                    icon: 'warning',
                    confirmButtonText: 'Entendido',
                    width: '350px',
                    padding: '1rem'
                });
                break;
            case 'title-and-text':
                Swal.fire({
                    title: '¡Atención!',
                    text: 'Ya cuenta con una solicitud de reingreso en proceso. No puede enviar otra solicitud hasta que la actual esté cerrada.',
                    icon: 'warning',
                    confirmButtonText: 'Entendido',
                    width: '400px',
                    padding: '1rem'
                });
                break;
            case 'message-with-auto-close':
                Swal.fire({
                    title: '¡Enviado Correctamente!',
                    text: 'Su solicitud de reingreso ha sido procesada. Recibirá una respuesta pronto.',
                    icon: 'success',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    width: '400px',
                    padding: '1rem'
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        window.location.href = '/buscador/buscar';
                    }
                });
                break;
        }
    };

    // Configurar validación del formulario
    const form = $('#reingresoForm');
    const btnEnviar = $('#btn-enviar');
    const loading = $('#loading');

    console.log('Formulario encontrado:', form.length > 0);

    if (form.length > 0) {

        // Configurar jQuery Validation
        form.validate({
            rules: {
                primer_nombre: {
                    required: true,
                    maxlength: 100,
                },
                segundo_nombre: {
                    maxlength: 100,
                },

                primer_apellido: {
                    required: true,
                    maxlength: 100,
                },
                 segundo_apellido: {
                    maxlength: 100,
                },

                telefono: {
                    required: true,
                    minlength: 8,
                    digits: true
                },
                correo: {
                    required: true,
                    email: true
                }
            },
            messages: {
                primer_nombre: {
                    required: "El primer nombre es obligatorio",
                    minlength: "Debe tener al menos 3 caracteres"
                },
                primer_apellido: {
                    required: "El primer apellido es obligatorio",
                    minlength: "Debe tener al menos 3 caracteres"
                },
                telefono: {
                    required: "El teléfono es obligatorio",
                    minlength: "Debe tener al menos 8 dígitos"
                },
                correo: {
                    required: "El correo electrónico es obligatorio",
                    email: "Ingrese un correo electrónico válido"
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.col-md-6, .col-md-12').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                console.log('Submit handler ejecutado');
                enviarFormulario();
                return false; // Prevenir envío normal del formulario
            },
            invalidHandler: function(event, validator) {
                console.log('Formulario inválido');
                // Mostrar alerta cuando hay campos inválidos
                showSwal('basic');
            }
        });

        function enviarFormulario() {
            console.log('Enviando formulario...');

            // Mostrar loading
            btnEnviar.hide();
            loading.show();

            // Obtener datos del formulario
            const formData = new FormData(form[0]);

            // Log de datos que se van a enviar
            for (let [key, value] of formData.entries()) {
                console.log(key + ': ' + value);
            }

            // Enviar solicitud
            fetch('/formulario/guardar', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                console.log('Respuesta recibida:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Datos de respuesta:', data);
                if (data.success) {
                    // Mostrar mensaje de éxito con auto-close
                    showSwal('message-with-auto-close');
                } else {
                    // Mostrar errores
                    if (data.mensaje && data.mensaje.includes('solicitud de reingreso en proceso')) {
                        showSwal('title-and-text');
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.mensaje || 'Error al procesar la solicitud',
                            icon: 'error',
                            confirmButtonText: 'Intentar de nuevo',
                            width: '400px',
                            padding: '1rem'
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error de Conexión',
                    text: 'No se pudo conectar con el servidor. Intente nuevamente.',
                    icon: 'error',
                    confirmButtonText: 'Intentar de nuevo',
                    width: '400px',
                    padding: '1rem'
                });
            })
            .finally(() => {
                btnEnviar.show();
                loading.hide();
            });
        }

        // Event listener adicional para debugging
        form.on('submit', function(e) {
            console.log('Form submit event triggered');
        });

        btnEnviar.on('click', function(e) {
            console.log('Botón enviar clickeado');
        });
    }
});
</script>

</body>
</html>
