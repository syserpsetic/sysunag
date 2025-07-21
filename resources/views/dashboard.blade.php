@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/animate-css/animate.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div
  class="d-flex justify-content-center align-items-center"
  style="
    min-height: 100vh;
    background-image:
      radial-gradient(circle at center, rgba(255,255,255,0.6) 0%, rgba(240,240,240,0.95) 100%),
      url('{{ asset('assets/images/fondo_blanco.jpg') }}');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-blend-mode: multiply;
    padding: 2rem;"
>
  <div class="text-center bg-white bg-opacity-75 p-4 p-md-5 rounded shadow" style="max-width: 600px; width: 100%;">
    
    <!-- Logo -->
    <img src="{{ asset('assets/images/escudo.png') }}" class="mb-3" alt="Logo UNAG" style="width: 70px;">

    <!-- Título principal -->
    <h2 class="fw-bold text-primary mb-3" style="font-size: 1.8rem;">
      Bienvenido al Sistema <p class="text-verdeOscuro"><strong>SYS UNAG</strong></p>
    </h2>

    <!-- Subtítulo -->
    <p class="text-dark mb-3" style="font-size: 1rem;">
      Este sistema es una herramienta integral de apoyo para la comunidad universitaria de la Universidad Nacional de Agricultura.
    </p>

    <!-- Texto institucional -->
    <p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.5;">
      Desde aquí puedes acceder a información relevante, servicios digitales, gestiones académicas y administrativas. Nuestro objetivo es fortalecer la comunicación y facilitar el vínculo entre todos los sectores que forman parte de nuestra universidad.
    </p>

    <!-- Mensaje destacado -->
    <div class="mt-4 bg-verdeClaro rounded p-3 shadow-sm">
      <p class="text-dark fw-normal mb-0" style="font-size: 0.85rem;">
        Gracias por confiar en el compromiso y desarrollo de la UNAG.
      </p>
    </div>
  <br>
    <img src="{{ asset('assets/images/logo_setic_new.png') }}" class="mb-3" alt="Logo SETIC" style="width: 140px;">
  </div>
</div>
@endsection

@push('custom-scripts')
  <script>
    // Aquí podrías añadir animaciones suaves si lo deseas
  </script>
@endpush
