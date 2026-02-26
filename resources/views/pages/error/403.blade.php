@extends('layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto d-flex flex-column align-items-center">
      <img src="{{ url('assets/images/escudo.png') }}" class="img-fluid mb-2" alt="403">
      <h1 class="fw-bolder mb-22 mt-2 tx-80 text-muted">403</h1>
      <h4 class="mb-2">Acceso denegado</h4>
      <h6 class="text-muted mb-3 text-center">Lo sentimos, no tienes permiso para acceder a esta página.</h6>
      <a onclick="history.back()" class="btn btn-primary">
        Regresar
      </a>
    </div>
  </div>

</div>
@endsection
