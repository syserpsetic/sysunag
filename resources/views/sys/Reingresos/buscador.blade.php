<!DOCTYPE html>
<html lang="es-MX">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="description" content="Sistema de Reingresos UNAG">
<meta name="author" content="SETIC UNAG">
<title>SYS UNAG - Buscador</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="shortcut icon" href="{{ asset('/favicon.png') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.19.2/dist/css/uikit.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="{{ asset('/css/login.css') }}" />
<link rel="stylesheet" href="{{ asset('/css/login-loading.css') }}" />
</head>

<body>
<div id="loading" class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>

<div class="hojas-container">
    <img id="hoja-01" src="{{ asset('/assets/images/login/hoja-cayendo-unag.png') }}" alt="">
    <img id="hoja-02" src="{{ asset('/assets/images/login/hoja-cayendo-unag.png') }}" alt="">
    <img id="hoja-03" src="{{ asset('/assets/images/login/hoja-cayendo-unag.png') }}" alt="">
</div>

<div class="overlay"></div>

<section id="fondo-imagenes">
    <div class="uk-position-relative uk-visible-toggle uk-light uk-slideshow" tabindex="-1" data-uk-slideshow="animation: scale; autoplay: true">
        <ul class="uk-slideshow-items" data-uk-height-viewport="" style="min-height: calc(100vh);">
            <li><div class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left"><img src="{{ asset('/assets/images/login/login-bg-01.jpg') }}" uk-cover /></div></li>
            <li><div class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-top-right"><img src="{{ asset('/assets/images/login/login-bg-06.jpg') }}" uk-cover /></div></li>
            <li><div class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left"><img src="{{ asset('/assets/images/login/login-bg-03.jpg') }}" uk-cover /></div></li>
            <li><div class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-right"><img src="{{ asset('/assets/images/login/login-bg-07.jpg') }}" uk-cover /></div></li>
        </ul>
    </div>
</section>

<div class="content uk-padding">
    <div class="uk-position-small uk-position-bottom-left uk-visible@l">
        <img id="logo_setic" class="uk-transition-scale-up uk-transition-opaque" src="{{ asset('/images/setic.svg') }}" alt="">
    </div>

    <div class="uk-magin-top-large uk-position-top">
        <img id="logo_unag" class="uk-transition-scale-up uk-transition-opaque" src="{{ asset('/assets/images/unag-oficial-blanco.png') }}" alt="">
    </div>
    <br>

    <div class="card-login">
        <div class="uk-flex uk-flex-center uk-flex-middle uk-margin-medium-top">
            <div class="icon-container">
                <lord-icon src="https://cdn.lordicon.com/kdduutaw.json" trigger="loop" state="hover-looking-around" colors="primary:#ffffff,secondary:#ffffff" style="width:60px;height:60px"></lord-icon>
            </div>
        </div>
        <p class="txt-blanco">Ingrese su Identidad:</p>
        <form class="forms-sample" method="GET">
            @csrf
            <div class="uk-width-large uk-padding uk-margin-remove-top uk-animation-slide-top-medium">
                <div class="uk-margin">
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: search"></span>
                        <input id="input-identidad" class="uk-input" name="identidad" placeholder="Identidad" type="text" required>
                    </div>
                </div>
            </div>

            <button type="button" id="btn-buscar" class="uk-button uk-button-primary uk-text-capitalize uk-margin-top uk-animation-slide-top-medium">
                <span uk-icon="icon: search; ratio: 1"></span> &nbsp; Buscar
            </button>

            <p id="mensaje-exito" class="mensaje-exito-custom uk-margin-small-top uk-text-bold uk-text-center" style="display: none;"></p>
            <p id="mensaje-error" class="mensaje-error-custom uk-margin-small-top uk-text-bold uk-text-center" style="display: none;"></p>
            <br>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/uikit@3.19.2/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.19.2/dist/js/uikit-icons.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('/js/login.js') }}"></script>
<script src="https://cdn.lordicon.com/lordicon.js"></script>

<script type="text/javascript">
$(document).ready(function () {
    const inputIdentidad = $('#input-identidad');
    const iconoInput = $('.uk-form-icon');
    let identidadEncontrada = '';

    // FUNCIÓN MODIFICADA: Ahora acepta identidad como parámetro
    const showSwal = function(type, identidadParam = null) {
        const options = { width: '400px', padding: '1rem', confirmButtonColor: '#d33' };

        switch (type) {
            case 'basic':
                Swal.fire({
                    ...options,
                    title: 'Campo Requerido',
                    text: 'Debe ingresar una identidad válida',
                    icon: 'warning',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#ffc107'
                });
                break;

            case 'graduado':
                Swal.fire({
                    ...options,
                    title: 'Estudiante Graduado',
                    text: 'El estudiante ya está graduado.',
                    icon: 'info',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#0dcaf0'
                }).then(() => window.location.href = "{{ url('/buscador/buscar') }}");
                break;

            case 'matriculado':
                Swal.fire({
                    ...options,
                    title: 'Estudiante Matriculado',
                    text: 'Ya está matriculado.',
                    icon: 'info',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#0dcaf0'
                }).then(() => window.location.href = "{{ url('/buscador/buscar') }}");
                break;

            case 'no-existe':
                Swal.fire({
                    ...options,
                    title: 'Estudiante No Encontrado',
                    text: 'Por favor acuda a las oficinas de coordinación académica.',
                    icon: 'question',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#0d6efd'
                }).then(() => window.location.href = "{{ url('/buscador/buscar') }}");
                break;

            case 'solicitud-en-proceso':
                // CORRECCIÓN CRÍTICA: Usar identidadParam en lugar de valorIdentidad
                Swal.fire({
                    ...options,
                    title: 'Solicitud en Proceso',
                    html: 'Ya tiene una solicitud en curso.<br><br>¿Desea ver el estado de su solicitud?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: '<span uk-icon="icon: eye"></span> Ver Proceso',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#6c757d',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // USAR identidadParam que se pasó como argumento
                        window.location.href = `/reingresos/trazabilidad?identidad=${encodeURIComponent(identidadParam)}`;
                    } else {
                        window.location.href = "{{ url('/buscador/buscar') }}";
                    }
                });
                break;

            case 'success':
                Swal.fire({
                    title: '¡Usuario Encontrado!',
                    text: 'Redirigiendo al formulario...',
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    width: '320px',
                    padding: '1rem'
                });
                break;
        }
    };

    $('#btn-buscar').on('click', function () {
        const valorIdentidad = inputIdentidad.val().trim();

        if (!/^[a-zA-Z0-9]+$/.test(valorIdentidad)) {
            showSwal('basic');
            inputIdentidad.addClass('uk-form-danger');
            iconoInput.attr('uk-icon', 'icon: warning');
            UIkit.icon(iconoInput);
            return;
        }

        inputIdentidad.removeClass('uk-form-danger uk-form-warning');
        iconoInput.attr('uk-icon', 'icon: search');

        fetch(`/buscador/buscar?identidad=${encodeURIComponent(valorIdentidad)}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log("Respuesta:", data);

            // Usamos data.estado para el switch
            switch (data.estado) {
                case 'graduado':
                    showSwal('graduado');
                    break;

                case 'matriculado':
                    showSwal('matriculado');
                    break;

                case 'sancionado':
                case 'ausente':
                    identidadEncontrada = valorIdentidad;
                    showSwal('success');
                    setTimeout(() => redirectToForm(), 3100);
                    break;

                case 'solicitud_en_proceso':
                    // CORRECCIÓN: Pasar valorIdentidad como segundo parámetro
                    showSwal('solicitud-en-proceso', valorIdentidad);
                    break;

                default:
                    showSwal('no-existe');
                    break;
            }
        })
        .catch(error => {
            console.error("Error en la solicitud:", error);
            showSwal('no-existe');
        });
    });

    function redirectToForm() {
        if (identidadEncontrada) {
            window.location.href = `/formulario/registro?identidad=${encodeURIComponent(identidadEncontrada)}`;
        }
    }

    inputIdentidad.on('input', function () {
        inputIdentidad.removeClass('uk-form-danger');
        iconoInput.attr('uk-icon', 'icon: search');
    });
});
</script>
</body>
</html>
