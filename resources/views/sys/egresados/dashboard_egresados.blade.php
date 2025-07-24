@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/owl-carousel/assets/owl.carousel.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/owl-carousel/assets/owl.theme.default.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/animate-css/animate.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div
    class="page-content d-flex flex-column p-0 m-0 min-vh-100"
    style="background-image: 
        radial-gradient(closest-side, rgba(255, 255, 255, 0.56) 60%, rgba(255, 255, 255, 0.6) 100%),
        url('{{ asset('assets/images/fondo_blanco.jpg') }}');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        background-blend-mode: multiply;
        min-height: 100vh;"
>
    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">OFERTA ACADÉMICA DEL SED-UNAG</h6>
                    <div class="owl-carousel owl-theme owl-auto-play">
                        <!-- Otro slide -->
                         @foreach($sed_unag_oferta as $row)
                            <div class="item position-relative" style="height: 250px; overflow: hidden; border-radius: 8px;">
                                <img src="https://sed.unag.edu.hn/{{$row['imagen']}}" alt="Maestría 2" class="w-100 h-100" style="object-fit: cover;" />
                                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-3" style="background: rgba(0, 0, 0, 0.4);">
                                    <h5 class="text-amarillo mb-2 fs-6 fs-md-5 fs-lg-4">{{$row['nombre']}}</h5>
                                    <h4 class="text-white mb-2 fs-6 fs-md-5 fs-lg-4">{{$row['titulo']}}</h4>
                                    <a href="https://sed.unag.edu.hn/vista-detalle/{{$row['id']}}" target="_blank" class="btn btn-primary btn-sm fs-6 fs-md-6 fs-lg-5">MÁS INFORMACIÓN</a>
                                </div>
                            </div>
                        @endforeach
                        <!-- ... -->
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-xl-6 mx-auto d-flex flex-column align-items-center">
    <!-- Logo UNAG -->
    <img src="{{ url('assets/images/escudo.png') }}" class="img-fluid mb-2" alt="UNAG" style="max-width: 60px;" />

    <!-- Mensaje principal -->
    <h3 class="fw-semibold mt-1 mb-1 text-muted text-center" style="font-size: 1.4rem;">
        <b>¡{{ session('bienvenida') }} {{ Auth::user()->name }}!</b>
    </h3>

        <!-- Nuevo mensaje de título -->
    <p class="text-muted mb-2 text-center" style="font-size: 0.85rem;">
        {{ session('mensaje_egresado') }}
    </p>

    <h6 class="mb-1 text-center" style="font-size: 1rem;">Nos alegra tenerte de regreso</h6>

    <p class="text-muted mb-2 text-center" style="font-size: 0.85rem; line-height: 1.4;">
        Esta plataforma está diseñada para ti.<br />
        Infórmate, gestiona tus trámites y mantente vinculado a tu alma mater.
    </p>

    <!-- Botón -->
    <a href="{{ url('/egresados/datos_generales') }}" class="btn btn-primary btn-sm fs-6 fs-md-6 fs-lg-5 mt-2">Actualizar datos</a>

    <!-- Mensaje destacado -->
    <div class="bg-light rounded p-2 mt-3 text-center shadow-sm w-100 bg-verdeClaro">
        <p class="text-dark fw-normal mb-0" style="font-size: 0.85rem;">
            Gracias por formar parte de la comunidad UNAG.
        </p>
    </div>
</div>

    </div>
</div>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/carousel.js') }}"></script>
@endpush