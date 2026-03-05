@extends('layout.master2')

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
    <img src="{{ asset('assets/images/escudo.png') }}" class="mb-3" alt="Logo UNAG" style="width: 100px;">

    <!-- Título principal -->
    <h2 class="fw-bold text-primary mb-3" style="font-size: 1.8rem;">
      Bienvenido al Sistema <p class="text-verdeOscuro"><strong>SYS UNAG</strong></p>
    </h2>

    <!-- Subtítulo -->
    <p class="text-dark mb-3" style="font-size: 1rem;">
      Unidad de Análisis de Datos
    </p>

    <!-- Texto institucional -->
    
  

                       
                            <div class="row">
                                <div class="col-12 col-xl-12 col-sm-12 stretch-card">
                                    <div class="row flex-grow-1">

                                       
                                        <div class="col-md-6 grid-margin stretch-card">
                                            <div class="card border-info">
                                                <div class="card-header bg-primary">
                                                    <div class="d-flex justify-content-between align-items-baseline">
                                                        <h6 class="mb-0">                                                           
                                                                <strong class="text-white"><i data-feather="activity" class="me-2"></i> Matricula y Atención de Salud</strong>                                                           
                                                        </h6>
                                                       
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 col-md-12 col-xl-12">
                                                          <p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.5;">
                                                              Matrícula estudiantes por año y atenciones en clínica médica 
                                                          </p>
                                                            <div class="d-flex align-items-baseline">
                                                                <p class="text-info">
                                                                    <i data-feather="arrow-right-circle" class="icon-sm mb-1"></i>
                                                                    <a target="_blank" href="{{url('/estadistica')}}">Ver detalle</a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 grid-margin stretch-card">
                                            <div class="card border-info">
                                                <div class="card-header bg-primary">
                                                    <div class="d-flex justify-content-between align-items-baseline">
                                                        <h6 class="mb-0">                                                           
                                                                <strong class="text-white"><i data-feather="activity" class="me-2"></i> Titulación por Carrera</strong>                                                           
                                                        </h6>
                                                       
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 col-md-12 col-xl-12">
                                                            <p class="text-muted mb-0" style="font-size: 0.95rem; line-height: 1.5;">
                                                                Tiempo real de titulación por carrera
                                                            </p>
                                                            <div class="d-flex align-items-baseline">
                                                                <p class="text-info">
                                                                    <i data-feather="arrow-right-circle" class="icon-sm mb-1"></i>
                                                                    <a target="_blank" href="{{url('/titulacion')}}">Ver detalle</a>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>
                                </div>
                            </div>
                        





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
