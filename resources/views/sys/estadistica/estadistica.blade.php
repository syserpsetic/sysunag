@extends('layout.master2')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')

<style>
/* ══════════════════════════════════════════════════════
   TOKENS — MANUAL DE IMAGEN CORPORATIVA UNAG
   Primarios: Verde #1BA333 · Amarillo #FFCC00 · Azul #203B76
   Secundarios: Verde oscuro #135423 · Café #5B3700 · Celeste #0094E9
══════════════════════════════════════════════════════ */
:root {
  --unag-verde:     #1BA333;
  --unag-verde-dk:  #135423;
  --unag-amarillo:  #FFCC00;
  --unag-azul:      #203B76;
  --unag-celeste:   #0094E9;
  --unag-cafe:      #5B3700;
  --unag-bg:        #f4f7f4;
  --unag-surface:   #ffffff;
  --unag-s2:        #eef4ee;
  --unag-border:    #d0e4d0;
  --unag-border-dk: #aacaaa;
  --unag-text:      #1a2b1a;
  --unag-text-dim:  #3d5c3d;
  --unag-muted:     #6b8a6b;
  --unag-shadow-sm: 0 2px 8px rgba(32,59,118,0.08);
  --unag-shadow-md: 0 4px 20px rgba(32,59,118,0.13);
}

/* ── PAGE BACKGROUND ────────────────────────────────── */
body,
.main-panel,
.content-wrapper {
  background-color: var(--unag-bg) !important;
}

/* ── HEADER UNAG ────────────────────────────────────── */
.unag-header {
  background: var(--unag-surface);
  border-bottom: 3px solid var(--unag-verde) !important;
  padding: 0 clamp(12px,4vw,40px);
  display: flex;
  align-items: center;
  gap: 16px;
  min-height: 66px;
  box-shadow: var(--unag-shadow-md);
  flex-wrap: wrap;
  position: sticky;
  top: 0;
  z-index: 100;
}
.unag-header-logo {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-shrink: 0;
}
.unag-header-logo img { width: 46px; height: auto; }
.unag-brand { display: flex; flex-direction: column; gap: 1px; }
.unag-brand-name {
  font-family: 'Montserrat', 'Segoe UI', sans-serif;
  font-weight: 800;
  font-size: 14px;
  color: var(--unag-azul) !important;
  letter-spacing: -.01em;
}
.unag-brand-unit {
  font-family: 'Montserrat', 'Segoe UI', sans-serif;
  font-size: 10px;
  color: var(--unag-verde) !important;
  letter-spacing: .12em;
  text-transform: uppercase;
  font-weight: 700;
}
.unag-header-sep {
  width: 1px;
  height: 34px;
  background: var(--unag-border);
  flex-shrink: 0;
}
.unag-header-title { flex: 1; min-width: 0; }
.unag-header-eyebrow {
  font-family: 'Montserrat', 'Segoe UI', sans-serif;
  font-size: 9px;
  letter-spacing: .2em;
  color: var(--unag-verde) !important;
  text-transform: uppercase;
  font-weight: 700;
  margin-bottom: 2px;
}
.unag-header-main {
  font-family: 'Montserrat', 'Segoe UI', sans-serif;
  font-size: clamp(13px, 1.8vw, 18px);
  font-weight: 800;
  color: var(--unag-azul) !important;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Onda decorativa superior */
.unag-wave-top {
  width: 100%;
  height: 70px;
  overflow: hidden;
  background: var(--unag-surface);
  position: relative;
  flex-shrink: 0;
}
.unag-wave-top svg {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
}
.unag-wave-deco {
  position: absolute;
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: var(--unag-amarillo);
  top: 8px;
  right: 48px;
}

/* ── PAGE TITLE BLOCK ───────────────────────────────── */
.unag-title-block {
  margin-bottom: 24px;
  animation: unagFadeUp .4s ease both;
}
.unag-page-label {
  display: inline-flex;
  align-items: center;
  background: var(--unag-verde) !important;
  color: #fff !important;
  padding: 4px 14px;
  border-radius: 4px;
  font-family: 'Montserrat', 'Segoe UI', sans-serif;
  font-size: 9px;
  letter-spacing: .2em;
  text-transform: uppercase;
  font-weight: 700;
  margin-bottom: 8px;
}
.unag-title-block h2 {
  font-family: 'Montserrat', 'Segoe UI', sans-serif;
  font-size: clamp(22px, 3vw, 36px);
  font-weight: 900;
  letter-spacing: -.02em;
  color: var(--unag-azul) !important;
  margin-bottom: 4px;
}
.unag-title-block h2 span { color: var(--unag-verde) !important; }
.unag-eyebrow {
  font-family: 'Montserrat', 'Segoe UI', sans-serif;
  font-size: 9px;
  letter-spacing: .2em;
  color: var(--unag-verde) !important;
  text-transform: uppercase;
  font-weight: 700;
  margin-bottom: 2px;
  display: block;
}

/* ── SECTION HEADING ────────────────────────────────── */
.unag-sh {
  display: flex;
  align-items: center;
  gap: 10px;
  margin: 24px 0 16px;
}
.unag-sh-bar {
  width: 4px;
  height: 20px;
  background: var(--unag-verde) !important;
  border-radius: 2px;
  flex-shrink: 0;
}
.unag-sh-txt {
  font-family: 'Montserrat', 'Segoe UI', sans-serif;
  font-size: 10px;
  letter-spacing: .18em;
  text-transform: uppercase;
  color: var(--unag-azul);
  font-weight: 800;
}
.unag-sh-line {
  flex: 1;
  height: 1px;
  background: var(--unag-border);
}

/* ── CARDS — override Bootstrap ─────────────────────── */
.card {
  border: 1px solid var(--unag-border) !important;
  border-top: 3px solid var(--unag-verde) !important;
  border-radius: 10px !important;
  box-shadow: var(--unag-shadow-sm) !important;
  background: var(--unag-surface) !important;
  transition: box-shadow .2s, transform .2s;
  animation: unagFadeUp .45s ease both;
  overflow: hidden;
}
.card:hover {
  box-shadow: var(--unag-shadow-md) !important;
  transform: translateY(-1px);
}
.card-body {
  padding: 20px 22px !important;
}
.card-title {
  font-family: 'Montserrat', 'Segoe UI', sans-serif !important;
  font-weight: 800 !important;
  font-size: 14px !important;
  color: var(--unag-azul) !important;
  letter-spacing: -.01em;
}

/* ── NAV TABS ────────────────────────────────────────── */
.nav-tabs {
  border-bottom: 2px solid var(--unag-border) !important;
  gap: 2px;
  flex-wrap: wrap;
}
.nav-tabs .nav-link {
  font-family: 'Montserrat', 'Segoe UI', sans-serif !important;
  font-size: 12px !important;
  font-weight: 700 !important;
  color: var(--unag-muted) !important;
  border: 1px solid transparent !important;
  border-radius: 7px 7px 0 0 !important;
  padding: 8px 18px !important;
  transition: all .15s;
  letter-spacing: .02em;
}
.nav-tabs .nav-link:hover {
  color: var(--unag-verde) !important;
  background: var(--unag-s2) !important;
  border-color: var(--unag-border) var(--unag-border) transparent !important;
}
.nav-tabs .nav-link.active {
  background: var(--unag-verde) !important;
  color: #fff !important;
  border-color: var(--unag-verde) !important;
  box-shadow: 0 2px 8px rgba(27,163,51,.3);
}
.tab-content.border {
  border-color: var(--unag-border) !important;
  border-radius: 0 0 8px 8px !important;
  background: var(--unag-surface);
}

/* ── FOOTER ──────────────────────────────────────────── */
.unag-footer-wave { margin-top: 40px; }
.unag-footer-wave svg { display: block; width: 100%; }
.unag-footer-bar {
  background: var(--unag-verde);
  padding: 18px clamp(12px,4vw,40px);
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 12px;
}
.unag-footer-name {
  font-family: 'Montserrat', 'Segoe UI', sans-serif;
  font-weight: 800;
  font-size: 13px;
  color: #fff !important;
}
.unag-footer-sub {
  font-size: 11px;
  color: rgba(255,255,255,.75) !important;
  margin-top: 2px;
}
.unag-footer-bar img {
  height: 50px;
  filter: brightness(0) invert(1);
  opacity: .9;
}

/* ── CHART CONTAINER ─────────────────────────────────── */
[id^="chartdiv_"],
[id^="apexRadialBar_"] {
  border-radius: 8px;
  overflow: hidden;
}

@keyframes unagFadeUp {
  from { opacity: 0; transform: translateY(12px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* ── RESPONSIVE ──────────────────────────────────────── */
@media (max-width: 768px) {
  .unag-header-sep,
  .unag-header-title { display: none; }
  .unag-brand-name   { font-size: 12px; }
  .card-body         { padding: 14px !important; }
  .nav-tabs .nav-link { padding: 6px 12px !important; font-size: 11px !important; }
  [id^="chartdiv_"]  { height: 320px !important; }
}
@media (max-width: 480px) {
  .unag-wave-deco    { display: none; }
  .nav-tabs .nav-link { padding: 5px 10px !important; font-size: 10px !important; }
  [id^="chartdiv_"]  { height: 260px !important; }
}
</style>

{{-- ══ HEADER UNAG ══ --}}
<div class="unag-header">
  <div class="unag-header-logo">
    <img src="{{ asset('assets/images/escudo.png') }}" alt="Escudo UNAG">
    <div class="unag-brand">
      <div class="unag-brand-name">Universidad Nacional de Agricultura</div>
      <div class="unag-brand-unit">SETIC · Análisis Institucional</div>
    </div>
  </div>
  <div class="unag-header-sep"></div>
  <div class="unag-header-title">
    <div class="unag-header-eyebrow">Análisis Académico · UNAG</div>
    <div class="unag-header-main">Matrícula y Atención Clínica</div>
  </div>
</div>

{{-- Onda decorativa superior --}}
<div class="unag-wave-top">
  <svg viewBox="0 0 1440 70" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
    <path d="M0,22 C200,58 450,4 720,34 C990,62 1250,9 1440,28 L1440,70 L0,70 Z" fill="#203B76" opacity="0.10"/>
    <path d="M0,42 C320,16 640,58 960,36 C1150,22 1320,48 1440,38 L1440,70 L0,70 Z" fill="#1BA333" opacity="0.13"/>
    <path d="M0,54 C450,40 850,62 1440,46" stroke="#1BA333" stroke-width="1.5" fill="none" opacity="0.4"/>
  </svg>
  <div class="unag-wave-deco"></div>
</div>

{{-- ══ CONTAINER ══ --}}
<div class="container-fluid px-4">

  {{-- Title block --}}
  <div class="unag-title-block">
    <div class="unag-page-label">Análisis Académico · UNAG</div>
    <h2>Dashboard — <span>Análisis</span> Estadístico</h2>
    <span class="unag-eyebrow">Secretaría de Tecnología de la Información y Comunicaciones (SETIC)</span>
  </div>

  {{-- ── SECCIÓN 1: MATRÍCULA ── --}}
  <div class="unag-sh">
    <div class="unag-sh-bar"></div>
    <div class="unag-sh-txt">Estudiantes Matriculados por Año</div>
    <div class="unag-sh-line"></div>
  </div>

  <div class="row g-3 mb-3">
    <div class="col-xl-12 stretch-card">
      <div class="card w-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="card-title mb-0">
              <i class="icon-lg pb-3px" data-feather="book"></i>
              Estudiantes Matriculados Por Año
            </h6>
            <img src="{{ asset('assets/images/escudo.png') }}" alt="UNAG" style="height:52px; opacity:.85;">
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
            <div class="tab-pane fade show active" id="home"     role="tabpanel" aria-labelledby="home-tab">    <div id="chartdiv_2021" style="width:100%; height:500px;"></div></div>
            <div class="tab-pane fade"            id="profile"   role="tabpanel" aria-labelledby="profile-tab"> <div id="chartdiv_2022" style="width:100%; height:500px;"></div></div>
            <div class="tab-pane fade"            id="pestana3"  role="tabpanel" aria-labelledby="pestana3-tab"><div id="chartdiv_2023" style="width:100%; height:500px;"></div></div>
            <div class="tab-pane fade"            id="contact"   role="tabpanel" aria-labelledby="contact-tab"> <div id="chartdiv_2024" style="width:100%; height:500px;"></div></div>
            <div class="tab-pane fade"            id="disabled"  role="tabpanel" aria-labelledby="disabled-tab"><div id="chartdiv_2025" style="width:100%; height:500px;"></div></div>
          </div>

        </div>
      </div>
    </div>
  </div>

  {{-- ── SECCIÓN 2: ATENCIONES CLÍNICAS ── --}}
  <div class="unag-sh">
    <div class="unag-sh-bar"></div>
    <div class="unag-sh-txt">Atenciones Anuales en Clínicas</div>
    <div class="unag-sh-line"></div>
  </div>

  <div class="row g-3 mb-4">

    <div class="col-xl-4 col-md-6 col-12 stretch-card">
      <div class="card w-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="card-title mb-0">
              <i class="icon-lg pb-3px" data-feather="activity"></i>
              Clínica Médica
            </h6>
            <img src="{{ asset('assets/images/escudo.png') }}" alt="UNAG" style="height:48px; opacity:.85;">
          </div>
          <div id="apexRadialBar_conteo_atenciones_clinica_medica"></div>
        </div>
      </div>
    </div>

    <div class="col-xl-4 col-md-6 col-12 stretch-card">
      <div class="card w-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="card-title mb-0">
              <i class="icon-lg pb-3px" data-feather="activity"></i>
              Clínica Odontológica
            </h6>
            <img src="{{ asset('assets/images/escudo.png') }}" alt="UNAG" style="height:48px; opacity:.85;">
          </div>
          <div id="apexRadialBar_conteo_atenciones_clinica_adontologia"></div>
        </div>
      </div>
    </div>

    <div class="col-xl-4 col-md-6 col-12 stretch-card">
      <div class="card w-100">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="card-title mb-0">
              <i class="icon-lg pb-3px" data-feather="activity"></i>
              Clínica Nutricionista
            </h6>
            <img src="{{ asset('assets/images/escudo.png') }}" alt="UNAG" style="height:48px; opacity:.85;">
          </div>
          <div id="apexRadialBar_conteo_atenciones_clinica_nutricionista"></div>
        </div>
      </div>
    </div>

  </div>{{-- /row clínicas --}}



</div>{{-- /container-fluid --}}

  {{-- ══ FOOTER WAVE ══ --}}
  <div class="unag-footer-wave">
    <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:block;background:var(--unag-bg)">
      <path d="M0,18 C320,52 660,4 980,36 C1160,54 1320,14 1440,28 L1440,60 L0,60 Z" fill="#1BA333"/>
      <path d="M0,34 C420,14 760,52 1100,30 C1270,18 1380,42 1440,48 L1440,60 L0,60 Z" fill="#135423" opacity="0.45"/>
      <path d="M0,50 C440,38 860,58 1440,44" stroke="white" stroke-width="1.5" fill="none" opacity="0.35"/>
    </svg>
    <div class="unag-footer-bar">
      <div>
        <div class="unag-footer-name">Universidad Nacional de Agricultura — UNAG</div>
        <div class="unag-footer-sub">Secretaría de Tecnología de la Información y Comunicaciones (SETIC) · Dashboard Analítico · Matrícula y Atención · 2025</div>
      </div>
      <img  src="https://setic.unag.edu.hn/img/logo-setic-blanco.png" alt="SETIC UNAG">
    </div>
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
  $(document).ready(function () {

    $.ajaxSetup({
      headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") }
    });

    /* ── Colores institucionales UNAG para ApexCharts ── */
    var colors = {
      primary:    "#1BA333",   /* verde UNAG */
      secondary:  "#203B76",   /* azul UNAG  */
      warning:    "#FFCC00",   /* amarillo UNAG */
      success:    "#135423",   /* verde oscuro UNAG */
      info:       "#0094E9",   /* celeste UNAG */
      danger:     "#c03030",
      muted:      "#6b8a6b",
      gridBorder: "rgba(27,163,51,0.12)",
      bodyColor:  "#1a2b1a",
      cardBg:     "#ffffff",
    };

    var fontFamily = "'Montserrat', 'Segoe UI', sans-serif";

    /* ── Función helper para opciones base de barras ── */
    function barOptions(seriesData, categories, title) {
      return {
        subtitle: {
          text: 'TOTAL: ' + seriesData.reduce(function(a,b){ return a+b; }, 0).toLocaleString('es'),
          align: 'center',
          margin: 10,
          style: { fontSize: '12px', fontWeight: '700', fontFamily: fontFamily, color: colors.secondary }
        },
        chart: {
          type: 'bar',
          height: 320,
          parentHeightOffset: 0,
          foreColor: colors.bodyColor,
          background: colors.cardBg,
          fontFamily: fontFamily,
          toolbar: { show: false },
          animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 600
          }
        },
        theme: { mode: 'light' },
        tooltip: {
          theme: 'light',
          style: { fontFamily: fontFamily }
        },
        colors: [colors.primary],
        grid: {
          padding: { bottom: -4 },
          borderColor: colors.gridBorder,
          xaxis: { lines: { show: true } }
        },
        series: [{ name: 'Atenciones', data: seriesData }],
        xaxis: {
          categories: categories,
          axisBorder: { color: colors.gridBorder },
          axisTicks:  { color: colors.gridBorder },
          labels: { style: { fontFamily: fontFamily, fontWeight: '700', colors: colors.muted } }
        },
        yaxis: {
          labels: { style: { fontFamily: fontFamily, fontWeight: '600', colors: colors.muted } }
        },
        legend: {
          show: true,
          position: 'top',
          horizontalAlign: 'center',
          fontFamily: fontFamily,
          fontWeight: '700',
          labels: { colors: colors.bodyColor },
          itemMargin: { horizontal: 8, vertical: 0 }
        },
        stroke: { width: 0 },
        plotOptions: {
          bar: {
            borderRadius: 5,
            columnWidth: '55%',
            distributed: false,
            dataLabels: { position: 'top' }
          }
        },
        dataLabels: {
          enabled: true,
          offsetY: -20,
          style: { fontSize: '11px', fontFamily: fontFamily, fontWeight: '700', colors: [colors.secondary] }
        }
      };
    }

    /* ── Clínica Médica ── */
    if ($('#apexRadialBar_conteo_atenciones_clinica_medica').length) {
      var chart1 = new ApexCharts(
        document.querySelector("#apexRadialBar_conteo_atenciones_clinica_medica"),
        barOptions([401, 3726, 5423, 4576, 45], [2022, 2023, 2024, 2025, 2026])
      );
      chart1.render();
    }

    /* ── Clínica Odontológica ── */
    if ($('#apexRadialBar_conteo_atenciones_clinica_adontologia').length) {
      var chart2 = new ApexCharts(
        document.querySelector("#apexRadialBar_conteo_atenciones_clinica_adontologia"),
        barOptions([32, 13], [2025, 2026])
      );
      chart2.render();
    }

    /* ── Clínica Nutricionista ── */
    if ($('#apexRadialBar_conteo_atenciones_clinica_nutricionista').length) {
      var chart3 = new ApexCharts(
        document.querySelector("#apexRadialBar_conteo_atenciones_clinica_nutricionista"),
        barOptions([261, 27], [2025, 2026])
      );
      chart3.render();
    }

  }); /* end ready */
  </script>
@endpush