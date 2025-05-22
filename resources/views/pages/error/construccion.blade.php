@extends('layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">
    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto d-flex flex-column align-items-center">
            <!-- Logo -->
            <img src="{{ url('assets/images/escudo.png') }}" class="img-fluid mb-2" alt="Sitio en Construcción" />

            <!-- Mensaje principal -->
            <h1 class="fw-bolder mt-2 mb-3 tx-70 text-muted text-center">¡Sitio en construcción!</h1>
            <h4 class="mb-2 text-center">Estamos trabajando para mejorar</h4>
            <h6 class="text-muted mb-3 text-center">
                Nuestro sitio web está siendo actualizado.<br />
                Pronto estará disponible nuevamente.
            </h6>

            <!-- Icono o animación opcional -->
            <div class="bg-light rounded p-3 mt-3 text-center shadow-sm w-100">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="spinner-border text-warning me-2" role="status" style="width: 1.5rem; height: 1.5rem;">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <span class="fw-bold text-warning fs-4">Trabajando en ello...</span>
                </div>
            </div>

            <br />

            <!-- Enlace al inicio o contacto -->
            <a href="javascript:history.back()" class="mt-2 d-block btn btn-primary">Regresar</a>
        </div>
    </div>
</div>
@endsection
