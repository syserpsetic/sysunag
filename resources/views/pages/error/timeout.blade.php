@extends('layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto d-flex flex-column align-items-center">
      <img src="{{ url('assets/images/escudo.png') }}" class="img-fluid mb-2" alt="Timeout">
      <h1 class="fw-bolder mb-22 mt-2 tx-70 text-muted">Tiempo de espera expiró</h1>
      <h4 class="mb-2">Error de conexión</h4>
      <h6 class="text-muted mb-3 text-center">
        No se pudo establecer comunicación con el servidor. <br>
        Por favor, verifica tu conexión o intenta nuevamente más tarde.
      </h6>
      <a href="{{ url('/') }}">Volver al inicio</a>
    </div>
  </div>

</div>
@endsection
