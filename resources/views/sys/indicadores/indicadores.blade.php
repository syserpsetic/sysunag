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
        <h6 class="card-title">Conteo de Empleados</h6>
        <div id="apexRadialBar"></div>
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
    var conteo_empleados = {{$conteo_empleados['cantidad']}};
    var tipo = "{{$conteo_empleados['tipo']}}";
    var tipoLimpio = tipo.replace(/&quot;/g, '"');
    // Construir arreglo
    var tipo = JSON.parse("[" + tipoLimpio + "]");
    var table = null;

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        var colors = {
            primary: "#6571ff",
            secondary: "#7987a1",
            success: "#05a34a",
            info: "#66d1d1",
            warning: "#fbbc06",
            danger: "#ff3366",
            light: "#e9ecef",
            dark: "#060c17",
            muted: "#7987a1",
            gridBorder: "rgba(77, 138, 240, .15)",
            bodyColor: "#000",
            cardBg: "#fff",
        };

        var fontFamily = "'Roboto', Helvetica, sans-serif";
        if ($("#apexRadialBar").length) {
            var options = {
                chart: {
                    height: 300,
                    type: "radialBar",
                    parentHeightOffset: 0,
                    foreColor: colors.bodyColor,
                    background: colors.cardBg,
                    toolbar: {
                        show: false,
                    },
                },
                theme: {
                    mode: "light",
                },
                tooltip: {
                    theme: "light",
                },
                colors: [colors.primary, colors.warning, colors.danger, colors.info],
                fill: {},
                grid: {
                    padding: {
                        top: 10,
                    },
                },
                plotOptions: {
                    radialBar: {
                        dataLabels: {
                            name: { show: true },
                            value: {
                                show: true,
                                formatter: function (val) {
                                    return val; // <-- Esto quita el %
                                },
                            },
                            total: {
                                show: true,
                                label: "TOTAL",
                                fontSize: "14px",
                                fontFamily: fontFamily,
                                formatter: function (w) {
                                    // w.globals.seriesTotals es un array con cada valor de la serie
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                },
                            },
                        },
                        track: {
                            background: colors.gridBorder,
                            strokeWidth: "100%",
                            opacity: 1,
                            margin: 5,
                        },
                    },
                },
                series: conteo_empleados,
                labels: tipo[0],
                legend: {
                    show: true,
                    position: "top",
                    horizontalAlign: "center",
                    fontFamily: fontFamily,
                    itemMargin: {
                        horizontal: 8,
                        vertical: 0,
                    },
                },
            };

            var chart = new ApexCharts(document.querySelector("#apexRadialBar"), options);
            chart.render();
            var chartAreaBounds = chart.w.globals.dom.baseEl.querySelector(".apexcharts-inner").getBoundingClientRect();
        }
    });


  </script>
@endpush