@extends('layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

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
              <form class="forms-sample" method="POST" action="{{ route('login') }}">
              @csrf
                <div class="mb-3">
                  <label for="userEmail" class="form-label">Usuario o Correo Electrónico</label>
                  <input required type="text" class="form-control" name="email" id="userEmail" placeholder="Escribe tu usuario o correo electrónico">
                </div>
                <div class="mb-3">
                  <label for="userPassword" class="form-label">Contraseña</label>
                  <input required type="password" class="form-control" name="password" id="userPassword" autocomplete="current-password" placeholder="Escribe tu contraseña">
                </div>
                <!-- <div class="form-check mb-3">
                  <input type="checkbox" class="form-check-input" id="authCheck">
                  <label class="form-check-label" for="authCheck">
                    Remember me
                  </label>
                </div> -->
                <div>
                  <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0">Ingresar</button>
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
@endsection