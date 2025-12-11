@extends('layout.master2')

@section('content')

<div class="row">
  <div class="col-xl-12 stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="card-title mb-0">
                <strong><i class="icon-lg pb-3px" data-feather="book"></i> Estudiantes Matriculados Por Año</strong>
            </h6>
            <img src="{{ asset('assets/images/escudo.png') }}" alt="icono" style="height: 60px;">
        </div>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><strong>2021</strong></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><strong>2022</strong></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pestana3-tab" data-bs-toggle="tab" href="#pestana3" role="tab" aria-controls="pestana3" aria-selected="false"><strong>2023</strong></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false"><strong>2024</strong></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="disabled-tab" data-bs-toggle="tab" href="#disabled" role="tab" aria-controls="disabled" aria-selected="false"><strong>2025</strong></a>
            </li>
        </ul>
        <div class="tab-content border border-top-0 p-3" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"><div id="chartdiv_2021" style="width:100%; height:500px;"></div></div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"><div id="chartdiv_2022" style="width:100%; height:500px;"></div></div>
            <div class="tab-pane fade" id="pestana3" role="tabpanel" aria-labelledby="pestana3-tab"><div id="chartdiv_2023" style="width:100%; height:500px;"></div></div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab"><div id="chartdiv_2024" style="width:100%; height:500px;"></div></div>
            <div class="tab-pane fade" id="disabled" role="tabpanel" aria-labelledby="disabled-tab"><div id="chartdiv_2025" style="width:100%; height:500px;"></div></div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
@push('custom-scripts')
    <script src="{{ asset('assets/js/amcharts/lib/5/index.js') }}"></script>
    <script src="{{ asset('assets/js/amcharts/lib/5/map.js') }}"></script>
    <script src="{{ asset('assets/js/amcharts/lib/5/geodata/hondurasHigh.js') }}"></script>
    <script src="{{ asset('assets/js/amcharts/lib/5/themes/Animated.js') }}"></script>
    <script src="{{ asset('assets/js/amcharts/lib/5/estadistica/matriculados_2021.js') }}"></script>
    <script src="{{ asset('assets/js/amcharts/lib/5/estadistica/matriculados_2022.js') }}"></script>
    <script src="{{ asset('assets/js/amcharts/lib/5/estadistica/matriculados_2023.js') }}"></script>
    <script src="{{ asset('assets/js/amcharts/lib/5/estadistica/matriculados_2024.js') }}"></script>
    <script src="{{ asset('assets/js/amcharts/lib/5/estadistica/matriculados_2025.js') }}"></script>

  <script type="text/javascript">
    var table = null; 

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        
   
}); 
    
  </script>
@endpush