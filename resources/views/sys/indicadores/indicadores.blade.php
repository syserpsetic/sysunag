@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')

<div class="row">
  <div class="col-xl-6 stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Empleados Nuevos del año {{$anio_actual['anio_actual']}}</h6>
        <div id="apexRadialBar_conteo_empleados_anio_actual"></div>
      </div>
    </div>
  </div>

  <div class="col-xl-6 stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Total de Empleados</h6>
        <div id="apexRadialBar_conteo_empleados_general"></div>
      </div>
    </div>
  </div>
</div>

@endsection
@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
@endpush
@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=mzutkZDE"></script>
  
   <!--  <script src="{{ asset('assets/js/amcharts/lib/5/index.js') }}"></script>
    <script src="{{ asset('assets/js/amcharts/lib/5/xy.js') }}"></script>
    <script src="{{ asset('assets/js/amcharts/lib/5/themes/Animated.js') }}"></script>
    <script src="{{ asset('assets/js/amcharts/lib/5/geodata/germanyLow.js') }}"></script>
    <script src="{{ asset('assets/js/amcharts/lib/5/fonts/notosans-sc.js') }}"></script>
    <script src="{{ asset('assets/js/amcharts/lib/5/locales/es_ES.js') }}"></script> -->
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

        //Inicia conteo_empleados_anio_actual
        var conteo_empleados_anio_actual = {{$conteo_empleados_anio_actual['cantidad']}};
        var tipo = "{{$conteo_empleados_anio_actual['tipo']}}";
        var tipoLimpio = tipo.replace(/&quot;/g, '"');
        var tipo = JSON.parse("[" + tipoLimpio + "]");
        if ($("#apexRadialBar_conteo_empleados_anio_actual").length) {
            var options = {
                annotations: {
                    position: 'front',
                    texts: [{
                        x: 20,
                        y: 20,
                        text: 'TOTAL: ' + conteo_empleados_anio_actual.reduce((a, b) => a + b, 0),
                        fontSize: '12px',
                        fontWeight: 'bold',
                        backgroundColor: '#fff'
                    }]
                },
                chart: {
                    height: 300,
                    type: "pie",
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
                colors: [colors.primary,colors.warning,colors.danger, colors.info],
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
                    colors: ['rgba(0,0,0,0)']
                },
                dataLabels: {
                    enabled: true
                },
                labels: tipo[0],
                series: conteo_empleados_anio_actual
                };
                
                var chart = new ApexCharts(document.querySelector("#apexRadialBar_conteo_empleados_anio_actual"), options);
                chart.render();  
        }
        //Finaliza conteo_empleados_anio_actual


        //Inicia conteo_empleados_general
        var conteo_empleados_general = {{$conteo_empleados_general['cantidad']}};
        var descripcion = "{{$conteo_empleados_general['descripcion']}}";
        var descripcionLimpio = descripcion.replace(/&quot;/g, '"');
        var descripcion = JSON.parse("[" + descripcionLimpio + "]");
        // Apex Bar chart start
        if ($('#apexRadialBar_conteo_empleados_general').length) {
            var options = {
            subtitle: {
                text: 'TOTAL: ' + conteo_empleados_general.reduce((a, b) => a + b, 0),
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
                name: 'Empleados',
                data: conteo_empleados_general
            }],
            xaxis: {
                categories: descripcion[0],
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
            
            var apexBarChart = new ApexCharts(document.querySelector("#apexRadialBar_conteo_empleados_general"), options);
            apexBarChart.render();
        }
        // Apex Bar chart end
        //Finaliza conteo_empleados_general
    });


  </script>
@endpush