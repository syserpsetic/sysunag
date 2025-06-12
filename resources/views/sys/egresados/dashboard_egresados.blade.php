@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<div class="page-content d-flex align-items-center justify-content-center p-0 m-0 h-100" 
      style="background-image: 
        radial-gradient(closest-side, rgba(255, 255, 255, 0.56) 60%, rgba(255, 255, 255, 0.6) 100%),
        url('{{ asset('assets/images/fondo_blanco.jpg') }}');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        background-blend-mode: multiply;
        min-height: 100vh;">
    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto d-flex flex-column align-items-center">
            <!-- Logo UNAG -->
            <img src="{{ url('assets/images/escudo.png') }}" class="img-fluid mb-2" alt="UNAG" />

            <!-- Mensaje principal -->
            <h1 class="fw-bolder mt-2 mb-3 tx-70 text-muted text-center">¡Bienvenido {{ Auth::user()->name }}!</h1>
            <h4 class="mb-2 text-center">Es un honor recibirte nuevamente</h4>
            <h6 class="text-muted mb-3 text-center">
                Nos complace darte la bienvenida a esta plataforma diseñada especialmente para ti.<br />
                Aquí podrás mantenerte informado, gestionar tus trámites y seguir vinculado con tu alma mater.
            </h6>

           <!-- Botones -->
            <a href="{{ url('/egresados/datos_generales') }}" class="btn btn-primary mt-2">Ir a actualizar mis datos</a>

            <br />
 <!-- Mensaje destacado -->
            <div class="bg-light rounded p-3 mt-2 text-center shadow-sm w-100">
                <h5 class="text-dark fw-bold mb-0">
                    Gracias por formar parte de la comunidad de egresados UNAG.
                </h5>
            </div>
            
        </div>
    </div>
</div>


@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush