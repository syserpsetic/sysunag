@extends('layout.master2')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')

<style>
 
      header {
    background:white;
    border-bottom: 1px solid #f1f5f9;
    padding: 0px 32px;
    display: flex;
    align-items: center;   
    gap: 16px;
    flex-wrap: wrap;
    position: sticky;
    top: 0;
    z-index: 100;    
  }
   .container { max-width:1440px; margin:0 auto; padding:24px 32px; }
  .logo { font-family:sans-serif; font-weight:800; font-size:18px; letter-spacing:-0.5px;}
  .logo span { color:#f0b429 !important; }
   .badge-row {
    font-size:12px; color:var(--muted); dgap:24px;margin-left: auto;
  }
      footer {
    border-top: 1px solid var(--border);
    padding: 20px 0;
    margin-top: 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 10px;
    color: var(--text-muted);
    letter-spacing: 0.08em;
}
   .eyebrow {
    font-family: sans-serif;
    font-size: 11px;
    letter-spacing: 0.2em;
    color: #f0b429 !important;
    text-transform: uppercase;
    font-weight:700;
  }
  .title-block { margin-bottom:20px; }
  .title-block h2 { font-family:sans-serif; ont-size: clamp(22px, 3vw, 36px); font-weight:800; letter-spacing:-0.5px; }
</style>

<header>
  <div class="logo">
    <img src="https://sys.unag.edu.hn/assets/images/escudo.png" style="width: 40px;" alt="unag">
  </div>
  <div  class="logo">
    MATRÍCULA <span>Y ATENCIÓN</span>  
  </div>
 
</header>
<div class="container">
     <div class="title-block animate-in">     
        <div class="eyebrow">Análisis Académico · Universidad Nacional de Agricultura (UNAG)</div> 
        <h2>Dashboard — Análisis Estadístico</h2>
        <div class="eyebrow">Unidad de Análisis · Secretaria de Tecnología de la Información y Comunicaciones (SETIC)</div>
        
    </div>
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
<br>
<div class="row">
    <div class="col-xl-4 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">
                        <strong><i class="icon-lg pb-3px" data-feather="activity"></i> Atenciones Anuales En Clínica Médica</strong>
                    </h6>
                    <img src="{{ asset('assets/images/escudo.png') }}" alt="icono" style="height: 60px;">
                </div>
                <div id="apexRadialBar_conteo_atenciones_clinica_medica"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 stretch-card">
        <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">
                        <strong><i class="icon-lg pb-3px" data-feather="activity"></i> Atenciones Anuales En Clínica Odontológica</strong>
                    </h6>
                    <img src="{{ asset('assets/images/escudo.png') }}" alt="icono" style="height: 60px;">
                </div>
            <div id="apexRadialBar_conteo_atenciones_clinica_adontologia"></div>
        </div>
        </div>
    </div>
    <div class="col-xl-4 stretch-card">
        <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">
                        <strong><i class="icon-lg pb-3px" data-feather="activity"></i> Atenciones Anuales En Clínica Nutricionista</strong>
                    </h6>
                    <img src="{{ asset('assets/images/escudo.png') }}" alt="icono" style="height: 60px;">
                </div>
            <div id="apexRadialBar_conteo_atenciones_clinica_nutricionista"></div>
        </div>
        </div>
    </div>
    <footer>
    <div>Dashboard Analítico · Matrícula y Atención</div>
    <div> <img src="https://sys.unag.edu.hn/assets/images/logo_setic_new.png" style="width: 200px;" alt="setic"> </div>
  </div>
  </footer>
</div>
@endsection
@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
@endpush
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

         var colors = {
            // primary: "#6571ff",
            primary: "#1ba333",
            secondary: "#7987a1",
            success: "#05a34a",
            info: "#66d1d1",
            // warning: "#fbbc06",
            warning: "#ffcc00",
            danger: "#ff3366",
            light: "#e9ecef",
            dark: "#060c17",
            muted: "#7987a1",
            gridBorder: "rgba(77, 138, 240, .15)",
            bodyColor: "#000",
            cardBg: "#fff",
        };

        

        var fontFamily = "'Roboto', Helvetica, sans-serif";
        
   //Inicia conteo_atenciones_clinica_medica
        var conteo_atenciones_clinica_medica = [401, 3726, 5423, 4576, 45];
        var descripcion = [2022, 2023, 2024, 2025, 2026];
        // Apex Bar chart start
        if ($('#apexRadialBar_conteo_atenciones_clinica_medica').length) {
            var options = {
            subtitle: {
                text: 'TOTAL: ' + conteo_atenciones_clinica_medica.reduce((a, b) => a + b, 0),
                align: 'center',
                margin: 10,
                style: {
                    fontSize: '12px',
                    fontWeight: 'bold',
                    color: colors.bodyColor
                }
            },
            chart: {
                type: 'bar',
                height: '320',
                parentHeightOffset: 0,
                foreColor: colors.bodyColor,
                background: colors.cardBg,
                toolbar: {
                show: false
                },
            },
            theme: {
                mode: 'light'
            },
            tooltip: {
                theme: 'light'
            },
            colors: [colors.primary],    
            grid: {
                padding: {
                bottom: -4
                },
                borderColor: colors.gridBorder,
                xaxis: {
                lines: {
                    show: true
                }
                }
            },
            series: [{
                name: 'Atenciones',
                data: conteo_atenciones_clinica_medica
            }],
            xaxis: {
                categories: descripcion,
                axisBorder: {
                color: colors.gridBorder,
                },
                axisTicks: {
                color: colors.gridBorder,
                },
            },
            legend: {
                show: true,
                position: "top",
                horizontalAlign: 'center',
                fontFamily: fontFamily,
                itemMargin: {
                horizontal: 8,
                vertical: 0
                },
            },
            stroke: {
                width: 0
            },
            plotOptions: {
                bar: {
                borderRadius: 4
                }
            }
            }
            
            var apexBarChart = new ApexCharts(document.querySelector("#apexRadialBar_conteo_atenciones_clinica_medica"), options);
            apexBarChart.render();
        }
        // Apex Bar chart end
        //Finaliza conteo_atenciones_clinica_medica



        //Inicia conteo_atenciones_clinica_odontologica
        var conteo_atenciones_clinica_odontologica = [32, 13];
        var descripcion_clinica_odontologica = [2025, 2026];
        // Apex Bar chart start
        if ($('#apexRadialBar_conteo_atenciones_clinica_adontologia').length) {
            var options = {
            subtitle: {
                text: 'TOTAL: ' + conteo_atenciones_clinica_odontologica.reduce((a, b) => a + b, 0),
                align: 'center',
                margin: 10,
                style: {
                    fontSize: '12px',
                    fontWeight: 'bold',
                    color: colors.bodyColor
                }
            },
            chart: {
                type: 'bar',
                height: '320',
                parentHeightOffset: 0,
                foreColor: colors.bodyColor,
                background: colors.cardBg,
                toolbar: {
                show: false
                },
            },
            theme: {
                mode: 'light'
            },
            tooltip: {
                theme: 'light'
            },
            colors: [colors.primary],    
            grid: {
                padding: {
                bottom: -4
                },
                borderColor: colors.gridBorder,
                xaxis: {
                lines: {
                    show: true
                }
                }
            },
            series: [{
                name: 'Atenciones',
                data: conteo_atenciones_clinica_odontologica
            }],
            xaxis: {
                categories: descripcion_clinica_odontologica,
                axisBorder: {
                color: colors.gridBorder,
                },
                axisTicks: {
                color: colors.gridBorder,
                },
            },
            legend: {
                show: true,
                position: "top",
                horizontalAlign: 'center',
                fontFamily: fontFamily,
                itemMargin: {
                horizontal: 8,
                vertical: 0
                },
            },
            stroke: {
                width: 0
            },
            plotOptions: {
                bar: {
                borderRadius: 4
                }
            }
            }
            
            var apexBarChart = new ApexCharts(document.querySelector("#apexRadialBar_conteo_atenciones_clinica_adontologia"), options);
            apexBarChart.render();
        }
        // Apex Bar chart end
        //Finaliza conteo_atenciones_clinica_odontologica


        //Inicia conteo_atenciones_clinica_nutricionista
        var conteo_atenciones_clinica_nutricionista = [261, 27];
        var descripcion_clinica_nutricionista = [2025, 2026];
        // Apex Bar chart start
        if ($('#apexRadialBar_conteo_atenciones_clinica_nutricionista').length) {
            var options = {
            subtitle: {
                text: 'TOTAL: ' + conteo_atenciones_clinica_nutricionista.reduce((a, b) => a + b, 0),
                align: 'center',
                margin: 10,
                style: {
                    fontSize: '12px',
                    fontWeight: 'bold',
                    color: colors.bodyColor
                }
            },
            chart: {
                type: 'bar',
                height: '320',
                parentHeightOffset: 0,
                foreColor: colors.bodyColor,
                background: colors.cardBg,
                toolbar: {
                show: false
                },
            },
            theme: {
                mode: 'light'
            },
            tooltip: {
                theme: 'light'
            },
            colors: [colors.primary],    
            grid: {
                padding: {
                bottom: -4
                },
                borderColor: colors.gridBorder,
                xaxis: {
                lines: {
                    show: true
                }
                }
            },
            series: [{
                name: 'Atenciones',
                data: conteo_atenciones_clinica_nutricionista
            }],
            xaxis: {
                categories: descripcion_clinica_nutricionista,
                axisBorder: {
                color: colors.gridBorder,
                },
                axisTicks: {
                color: colors.gridBorder,
                },
            },
            legend: {
                show: true,
                position: "top",
                horizontalAlign: 'center',
                fontFamily: fontFamily,
                itemMargin: {
                horizontal: 8,
                vertical: 0
                },
            },
            stroke: {
                width: 0
            },
            plotOptions: {
                bar: {
                borderRadius: 4
                }
            }
            }
            
            var apexBarChart = new ApexCharts(document.querySelector("#apexRadialBar_conteo_atenciones_clinica_nutricionista"), options);
            apexBarChart.render();
        }
        // Apex Bar chart end
        //Finaliza conteo_atenciones_clinica_nutricionista
}); 
    
  </script>
@endpush