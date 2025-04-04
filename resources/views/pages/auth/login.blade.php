@extends('layout.login-layout')

@section('content')
    <div id="loading" class="lds-ellipsis">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>

    <div class="hojas-container">
        <img id="hoja-01" src="{{ asset('/assets/images/login/hoja-cayendo-unag.png') }}" alt="">
        <img id="hoja-02" src="{{ asset('/assets/images/login/hoja-cayendo-unag.png') }}" alt="">
        <img id="hoja-03" src="{{ asset('/assets/images/login/hoja-cayendo-unag.png') }}" alt="">
    </div>

    <div class="overlay"></div>

    <section id="fondo-imagenes">
        <div class="uk-position-relative uk-visible-toggle uk-light uk-slideshow" tabindex="-1"
            data-uk-slideshow="animation: scale; autoplay: true">
            <ul class="uk-slideshow-items" data-uk-height-viewport="" style="min-height: calc(100vh);">
                <li tabindex="-1" class="">
                    <div
                        class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                        <img src="{{ asset('/assets/images/login/login-bg-01.jpg') }}" autoplay muted loop playsinline
                            uk-cover />
                    </div>
                </li>
                <li tabindex="-1" class="">
                    <div class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-top-right">
                        <img src="{{ asset('/assets/images/login/login-bg-06.jpg') }}" autoplay muted loop playsinline
                            uk-cover />
                    </div>
                </li>
                <li tabindex="-1" class="">
                    <div
                        class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-left">
                        <img src="{{ asset('/assets/images/login/login-bg-03.jpg') }}" autoplay muted loop playsinline
                            uk-cover />
                    </div>
                </li>
                <li tabindex="-1" class="">
                    <div
                        class="uk-position-cover uk-animation-kenburns uk-animation-reverse uk-transform-origin-center-right">
                        <img src="{{ asset('/assets/images/login/login-bg-07.jpg') }}" autoplay muted loop playsinline
                            uk-cover />
                    </div>
                </li>
            </ul>
        </div>
    </section>

    <div class="content uk-padding">

        <div class="uk-position-small uk-position-top-right">
            <a id="btn-portal" href="https://portal.unag.edu.hn" class="uk-text-small uk-icon-button blob white"
                uk-icon="home" target="_blank"></a>
        </div>

        <div class="uk-position-small uk-position-bottom-left uk-visible@l"">
            <img id="logo_setic" class="uk-transition-scale-up uk-transition-opaque" src="{{ asset('/images/setic.svg') }}"
                alt="">
        </div>

        <div class="uk-magin-top-large uk-position-top">
            <img id="logo_unag" class="uk-transition-scale-up uk-transition-opaque"
                src="{{ asset('/assets/images/unag-oficial-blanco.png') }}" alt="">
        </div>

        <br>

        <div class="card-login">


            <div class="uk-flex uk-flex-center uk-flex-middle uk-margin-medium-top">
                <div class="icon-container">
                    <lord-icon src="https://cdn.lordicon.com/kdduutaw.json" trigger="loop" state="hover-looking-around"
                        colors="primary:#ffffff,secondary:#ffffff" style="width:60px;height:60px">
                    </lord-icon>
                </div>
            </div>



            <p class="txt-blanco">Ingrese sus credenciales:</p>

            <div
                class="uk-width-large uk-padding uk-margin-remove-top uk-padding-remove-top uk-padding-remove-bottom uk-animation-slide-top-medium">
                <div class="uk-margin">
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: user"></span>
                        <input id="input-usuario" class="uk-input " placeholder="Usuario" type="text">
                    </div>
                </div>

                <div class="uk-margin">
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: lock"></span>
                        <input id="input-password" type="password" class="uk-input "
                            placeholder="Contraseña">
                    </div>
                </div>
                {{-- <div class="uk-flex uk-flex-between">
                <label class="txt-recuerdame"><input class="uk-checkbox uk-margin-remove-left" type="checkbox"> Recuérdame</label>
                <label class="uk-toggle txt-olvide-contrasenia"><a href="{{url('/reiniciar-contraseña')}}" style="" class="uk-margin-remove-top uk-link-reset">¡Olvidé mi
                        contraseña!</a></label>
            </div> --}}
            </div>

            <button
                id="btn-ingresar"class="uk-button uk-button-primary uk-text-capitalize uk-margin-top uk-animation-slide-top-medium"><span
                    uk-icon="icon: sign-in; ratio: 1"></span> &nbsp; Ingresar</button>


            <br>

            {{-- <div>
            <p class="uk-text-small uk-animation-slide-top-medium uk-margin-remove-top">- O Ingresar con -</p>
            <button id="google"
                class="uk-button uk-button-secondary uk-animation-slide-top-medium uk-margin-remove-top">Google</button>
        </div> --}}
        </div>


    </div>



    {{-- <div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto">
      <div class="card">
        <div class="row">
          <div class="col-md-4 pe-md-0">
            <div class="auth-side-wrapper" style="background-image: url({{ url(asset('/assets/images/favicon.ico')) }})">

            </div>
          </div>
          <div class="col-md-8 ps-md-0">
            <div class="auth-form-wrapper px-4 py-5">
              <a href="#" class="noble-ui-logo d-block mb-2">SYS <span>UNAG</span></a>
              <h5 class="text-muted fw-normal mb-4">¡BIENVENIDOS! INICIA SESIÓN PARA INGRESAR</h5>
              <form class="forms-sample">
                <div class="mb-3">
                  <label for="userEmail" class="form-label">Usuario o Correo Electrónico</label>
                  <input type="email" class="form-control" id="userEmail" placeholder="Escribe tu usuario o correo electrónico">
                </div>
                <div class="mb-3">
                  <label for="userPassword" class="form-label">Contraseña</label>
                  <input type="password" class="form-control" id="userPassword" autocomplete="current-password" placeholder="Escribe tu contraseña">
                </div>
                <!-- <div class="form-check mb-3">
                  <input type="checkbox" class="form-check-input" id="authCheck">
                  <label class="form-check-label" for="authCheck">
                    Remember me
                  </label>
                </div> -->
                <div>
                  <a href="{{ url('/') }}" class="btn btn-primary me-2 mb-2 mb-md-0">Ingresar</a>
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

</div> --}}
@endsection
