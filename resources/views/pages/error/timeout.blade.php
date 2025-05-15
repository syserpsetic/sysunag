@extends('layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">
    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto d-flex flex-column align-items-center">
            <!-- Logo -->
            <img src="{{ url('assets/images/escudo.png') }}" class="img-fluid mb-2" alt="Timeout" />

            <!-- Mensaje principal -->
            <h1 class="fw-bolder mt-2 mb-3 tx-70 text-muted text-center">Tiempo de espera expiró</h1>
            <h4 class="mb-2 text-center">Problema de conexión</h4>
            <h6 class="text-muted mb-3 text-center">
                No pudimos conectar con el servidor en este momento.<br />
                Esto puede deberse a un problema temporal de red o mantenimiento.
            </h6>

            <!-- Cuenta regresiva -->
            <div class="bg-light rounded p-3 mt-3 text-center shadow-sm w-100">
                <h4 class="text-dark fw-bold mb-0" id="message">
                    Reintentando automáticamente en
                    <span id="counter" class="text-primary fw-bolder" style="font-size: 2rem;">60</span> segundos...
                </h4>
            </div>

            <br />

            <!-- Botones -->
            <button id="retryBtn" class="btn btn-primary mt-2">Intentar ahora</button>
            <a href="{{ url('/') }}" class="mt-2 d-block btn btn-link">Volver al inicio</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
  let seconds = 60;
  const counter = document.getElementById('counter');
  const message = document.getElementById('message');
  const retryBtn = document.getElementById('retryBtn');

  const showSpinner = () => {
    message.innerHTML = `
      <div class="d-flex align-items-center justify-content-center">
        <div class="spinner-border text-success me-2" role="status" style="width: 1.5rem; height: 1.5rem;">
          <span class="visually-hidden">Cargando...</span>
        </div>
        <span class="fw-bold text-success fs-4">Recargando...</span>
      </div>`;
  }

  const handleRetry = () => {
    retryBtn.disabled = true;
    retryBtn.innerHTML = `
      Reintentando...`;
    showSpinner();
    setTimeout(() => location.reload(), 1000);
  }

  const countdown = setInterval(() => {
    seconds--;
    if (seconds > 0) {
      counter.textContent = seconds;
    } else {
      clearInterval(countdown);
      handleRetry();
    }
  }, 1000);

  retryBtn.addEventListener('click', handleRetry);
</script>
@endsection
