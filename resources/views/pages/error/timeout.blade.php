@extends('layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">
  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto d-flex flex-column align-items-center">

      <!-- Logo -->
      <img src="{{ url('assets/images/escudo.png') }}" class="img-fluid mb-2" alt="Timeout">

      <!-- Mensaje principal -->
      <h1 class="fw-bolder mt-2 mb-3 tx-70 text-muted text-center">Tiempo de espera expiró</h1>
      <h4 class="mb-2 text-center">Problema de conexión</h4>
      <h6 class="text-muted mb-3 text-center">
        No pudimos conectar con el servidor en este momento.<br>
        Esto puede deberse a un problema temporal de red o mantenimiento.
      </h6>

      <!-- Cuenta regresiva -->
      <div class="bg-light rounded p-3 mt-3 text-center shadow-sm w-100">
        <h4 class="text-dark fw-bold mb-0" id="message">
            Reintentando automáticamente en 
            <span id="counter" class="text-primary fw-bolder" style="font-size: 2rem;">60</span> segundos...
        </h4>
      </div>

      <br>

      <!-- Botones -->
      <button onclick="location.reload()" class="btn btn-primary mt-2">Intentar ahora</button>
      <a href="{{ url('/') }}" class="mt-2 d-block">Volver al inicio</a>

    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  let seconds = 60;
  const counter = document.getElementById('counter');
  const message = document.getElementById('message');

  const countdown = setInterval(() => {
    seconds--;
    if (seconds > 0) {
      counter.textContent = seconds;
    } else {
      clearInterval(countdown);
      message.innerHTML = '<span class="fw-bold text-success">Recargando...</span>';
      location.reload();
    }
  }, 1000);
</script>
@endsection
