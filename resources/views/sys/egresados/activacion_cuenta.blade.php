@extends('layout.login-layout')

@push('css')
    <style>
        .bg-green {
            background-color: #1ba333;
            color: white !important;
        }

        .bg-dark-green{
          background-color: #135423;
        }

        a.uk-link-reset {
            color: white !important;
            position: relative;
            overflow: hidden;
            transition: color 0.3s ease;
        }

        a.uk-link-reset.bg-green::before {
            content: 'Egresados →';
            text-align: center;
            line-height: 54px;
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #ffcc00;
            transform: translateY(100%);
            transition: transform 0.4s ease;
            z-index: 2;
            
        }
        a.uk-link-reset.bg-dark-green::before {
            content: 'Solicitud de Reingreso →';
            text-align: center;
            line-height: 54px;
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #ffcc00;
            transform: translateY(100%);
            transition: transform 0.4s ease;
            z-index: 2;
            
        }

        a.uk-link-reset:hover::before {
            transform: translateY(0);
        }
        
        a.uk-link-reset:hover {
            color: #333 !important;
        }

        a.uk-link-reset img{
            filter: brightness(0) invert(1);
        }


    </style>
@endpush

@section('content')
<div id="loading" class="lds-ellipsis">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
</div>

<div class="hojas-container">
    <img id="hoja-01" src="{{ asset('/assets/images/login/hoja-cayendo-unag.png') }}" alt="" />
    <img id="hoja-02" src="{{ asset('/assets/images/login/hoja-cayendo-unag.png') }}" alt="" />
    <img id="hoja-03" src="{{ asset('/assets/images/login/hoja-cayendo-unag.png') }}" alt="" />
</div>

<div class="overlay"></div>

<section id="fondo-imagenes">
    <div
        class="uk-position-relative uk-visible-toggle uk-light uk-slideshow"
        tabindex="-1"
        data-uk-slideshow="animation: scale; autoplay: true"
    >
        <ul class="uk-slideshow-items" data-uk-height-viewport="" style="min-height: calc(100vh)">
            <li tabindex="-1" class="">
                <div
                    class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left"
                >
                    <img
                        src="{{ asset('/assets/images/login/login-bg-01.jpg') }}"
                        autoplay
                        muted
                        loop
                        playsinline
                        uk-cover
                    />
                </div>
            </li>
            <li tabindex="-1" class="">
                <div class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-top-right">
                    <img
                        src="{{ asset('/assets/images/login/login-bg-06.jpg') }}"
                        autoplay
                        muted
                        loop
                        playsinline
                        uk-cover
                    />
                </div>
            </li>
            <li tabindex="-1" class="">
                <div
                    class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left"
                >
                    <img
                        src="{{ asset('/assets/images/login/login-bg-03.jpg') }}"
                        autoplay
                        muted
                        loop
                        playsinline
                        uk-cover
                    />
                </div>
            </li>
            <li tabindex="-1" class="">
                <div
                    class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-right"
                >
                    <img
                        src="{{ asset('/assets/images/login/login-bg-07.jpg') }}"
                        autoplay
                        muted
                        loop
                        playsinline
                        uk-cover
                    />
                </div>
            </li>
        </ul>
    </div>
</section>

<div class="content uk-padding">
    <div class="uk-position-small uk-position-top-left btn-portal-container">
        <a
            id="btn-portal"
            href="{{ route('login') }}"
            class="uk-text-small uk-icon-button blob white"
            uk-icon="home"
        ></a>
    </div>

    <div class="uk-position-top uk-margin-large-top uk-margin-remove@m">
        <img
            id="logo_unag"
            class="uk-transition-scale-up uk-transition-opaque"
            src="{{ asset('/assets/images/unag-oficial-blanco.png') }}"
            alt=""
        />
    </div>

    <div class="uk-position-top-right uk-flex uk-flex-row">
        <a class="bg-green uk-padding-small uk-link-reset" href="{{ route('login_egresados') }}">
            <img src="{{ asset('/assets/images/svg/school.svg') }}" alt="" /> Egresados
        </a>
        <a class="bg-dark-green uk-padding-small uk-link-reset" href="{{ route('error') }}">
            <img src="{{ asset('/assets/images/svg/checklist.svg') }}" alt="" /> Solicitud de Reingreso
        </a>
    </div>

    <br />

    <div class="card-login">
        <div class="uk-flex uk-flex-center uk-flex-middle uk-margin-medium-top">
            <!-- <div class="icon-container">
                    <lord-icon src="https://cdn.lordicon.com/kdduutaw.json" trigger="loop" state="hover-looking-around"
                        colors="primary:#ffffff,secondary:#ffffff" style="width:60px;height:60px">
                    </lord-icon>
                </div> -->
        </div>

        <br /><br /><br />
        <!-- <h2 class="txt-blanco">ACTIVAR CUENTA</h2> -->
        <p class="txt-blanco">Complete los campos obligatorios:</p>
        <form
            class="forms-sample"
            method="POST"
            action="{{ route('activacion_cuenta_enviar') }}"
        >
            @csrf

            <div class="uk-container uk-container-small">

         
                <div class="uk-grid-small uk-child-width-1-2@m uk-width-3-4@m uk-margin-auto uk-animation-slide-top-medium" uk-grid>

                    <div>
                        <div class="uk-margin-small">
                            <small class="txt-blanco text-left">Nombre Completo</small>
                            <div class="uk-inline uk-width-1-1">
                                <span class="uk-form-icon" uk-icon="icon: user"></span>
                                <input
                                    id="nombre_completo"
                                    class="uk-input uk-width-1-1"
                                    name="nombre_completo"
                                    placeholder="Obligatorio"
                                    type="text"
                                    required
                                />
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="uk-margin-small">
                            <small class="txt-blanco text-left">Correo Electrónico Personal</small>
                            <div class="uk-inline uk-width-1-1">
                                <span class="uk-form-icon" uk-icon="icon: mail"></span>
                                <input
                                    id="correo"
                                    class="uk-input uk-width-1-1"
                                    name="correo"
                                    placeholder="Obligatorio"
                                    type="email"
                                    required
                                />
                            </div>
                        </div>
                    </div>

                </div>

        
                <div class="uk-grid-small uk-child-width-1-3@m uk-width-3-4@m uk-margin-auto uk-animation-slide-top-medium" uk-grid>

                    <div>
                        <div class="uk-margin-small">
                            <small class="txt-blanco text-left">Teléfono</small>
                            <div class="uk-inline uk-width-1-1">
                                <span class="uk-form-icon" uk-icon="icon: receiver"></span>
                                <input
                                    id="input-telefono"
                                    class="uk-input uk-width-1-1"
                                    name="telefono"
                                    placeholder="Obligatorio"
                                    type="number"
                                    required
                                />
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="uk-margin-small">
                            <small class="txt-blanco text-left">Número de Registro</small>
                            <div class="uk-inline uk-width-1-1">
                                <span class="uk-form-icon" uk-icon="icon: hashtag"></span>
                                <input
                                    id="numero_registro"
                                    class="uk-input uk-width-1-1"
                                    name="numero_registro"
                                    placeholder="Opcional"
                                    type="text"
                                />
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="uk-margin-small">
                            <small class="txt-blanco text-left">Número de Identidad</small>
                            <div class="uk-inline uk-width-1-1">
                                <span class="uk-form-icon" uk-icon="icon: credit-card"></span>
                                <input
                                    id="numero_identidad"
                                    class="uk-input uk-width-1-1"
                                    name="numero_identidad"
                                    placeholder="Obligatorio"
                                    type="number"
                                    required
                                />
                            </div>
                        </div>
                    </div>

                </div>

            </div>


            <div class="uk-grid-small uk-child-width-1-2@m uk-width-3-4@m uk-margin-auto uk-animation-slide-top-medium" uk-grid>

                <div class="uk-width-3-4@m uk-margin-auto uk-margin-small-top uk-animation-slide-top-medium">
                    
                    <div class="uk-margin-small">
                        <small class="txt-blanco text-left">Redacte su solicitud</small>
                        <textarea
                            class="uk-textarea uk-width-1-1"
                            name="descripcion"
                            placeholder="Obligatorio"
                            rows="3"
                            style="border-radius: 20px;"
                            required></textarea>
                    </div>

                </div>

            </div>



            <button
                type="submit"
                class="uk-button uk-button-primary uk-text-capitalize uk-margin-top uk-animation-slide-top-medium"
                id="btnEnviar"
            >
                <span uk-icon="icon: forward; ratio: 1"></span> &nbsp; Enviar
            </button>
            <br /><br />
            <small class="txt-blanco">
                @if(session('success'))
                    <strong>{{ session('success') }}</strong>
                @endif
            </small>

            <div class="uk-margin-large-top uk-text-center">
                <a href="https://setic.unag.edu.hn" target="_blank">
                    <img
                        id="logo_unag"
                        class="uk-transition-scale-up uk-transition-opaque"
                        src="{{ asset('/assets/images/logo_setic_blanco.png') }}"
                        alt=""
                    />
                </a>
            </div>
        </form>
    </div>

    {{--
    <div class="page-content d-flex align-items-center justify-content-center">
        <div class="row w-100 mx-0 auth-page">
            <div class="col-md-8 col-xl-6 mx-auto">
                <div class="card">
                    <div class="row">
                        <div class="col-md-4 pe-md-0">
                            <div
                                class="auth-side-wrapper"
                                style="background-image: url({{ url(asset('/assets/images/favicon.ico')) }})"
                            ></div>
                        </div>
                        <div class="col-md-8 ps-md-0">
                            <div class="auth-form-wrapper px-4 py-5">
                                <a href="#" class="noble-ui-logo d-block mb-2">SYS <span>UNAG</span></a>
                                <h5 class="text-muted fw-normal mb-4">¡BIENVENIDOS! INICIA SESIÓN PARA INGRESAR</h5>
                                <form class="forms-sample" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="userEmail" class="form-label">Usuario o Correo Electrónico</label>
                                        <input
                                            required
                                            type="text"
                                            class="form-control"
                                            name="email"
                                            id="userEmail"
                                            placeholder="Escribe tu usuario o correo electrónico"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="userPassword" class="form-label">Contraseña</label>
                                        <input
                                            required
                                            type="password"
                                            class="form-control"
                                            name="password"
                                            id="userPassword"
                                            autocomplete="current-password"
                                            placeholder="Escribe tu contraseña"
                                        />
                                    </div>
                                    <!-- <div class="form-check mb-3">
                  <input type="checkbox" class="form-check-input" id="authCheck">
                  <label class="form-check-label" for="authCheck">
                    Remember me
                  </label>
                </div> -->
                                    <div>
                                        <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0">
                                            Ingresar
                                        </button>
                                        <!-- <button type="button" class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="twitter"></i>
                    Login with twitter
                  </button> -->
                                    </div>
                                    <!-- <a href="{{ url('/auth/register') }}" class="d-block mt-3 text-muted">Not a user? Sign up</a> -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    --}}
</div>

@endsection
@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush
@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const btn = document.getElementById('btnEnviar');

    btn.addEventListener('click', function() {
        // Cambiar el contenido por un spinner de UIkit
        btn.innerHTML = '<span uk-spinner="ratio: 1"></span> Enviando...';
        btn.disabled = true; // Deshabilitar mientras se "procesa"

        // Simular un tiempo de espera (ej. envío de formulario)
        setTimeout(() => {
            btn.innerHTML = '<span uk-icon="icon: check; ratio: 1"></span> Enviado';
        }, 3000); // 3 segundos de simulación
    });

    });

  </script>
@endpush