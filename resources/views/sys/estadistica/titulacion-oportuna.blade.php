<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Titulación Oportuna — UNAG</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="shortcut icon" href="{{ asset('/favicon.png') }}">
<style>
/* ══════════════════════════════════════════════════════
   TOKENS OFICIALES — MANUAL DE IMAGEN CORPORATIVA UNAG
   Primarios: Verde #1BA333 · Amarillo #FFCC00 · Azul #203B76
   Secundarios: Verde oscuro #135423 · Café #5B3700 · Celeste #0094E9
══════════════════════════════════════════════════════ */
:root {
  --verde:      #1BA333;
  --verde-dk:   #135423;
  --amarillo:   #FFCC00;
  --azul:       #203B76;
  --celeste:    #0094E9;
  --cafe:       #5B3700;
  --bg:         #f4f7f4;
  --white:      #ffffff;
  --s2:         #eef4ee;
  --border:     #d0e4d0;
  --border-dk:  #aacaaa;
  --text:       #1a2b1a;
  --text-dim:   #3d5c3d;
  --muted:      #6b8a6b;
  /* Semáforo */
  --ontime:  #1BA333;
  --extra1:  #d4870a;
  --extra2:  #c05a1a;
  --extra3:  #c03030;
  --nograd:  #aacaaa;
  --shadow-sm: 0 2px 8px rgba(32,59,118,0.08);
  --shadow-md: 0 4px 20px rgba(32,59,118,0.13);
}
* { margin:0; padding:0; box-sizing:border-box; }
body { background:var(--bg); color:var(--text); font-family:'Open Sans',sans-serif; min-height:100vh; }

/* HEADER */
header { background:var(--white); border-bottom:3px solid var(--verde); padding:0 32px; position:sticky; top:0; z-index:200; box-shadow:var(--shadow-md); }
.hi { display:flex; align-items:center; gap:18px; min-height:66px; max-width:1440px; margin:0 auto; flex-wrap:wrap; }
.hlogo { display:flex; align-items:center; gap:12px; text-decoration:none; flex-shrink:0; }
.hlogo img { width:46px; }
.hbrand { display:flex; flex-direction:column; gap:1px; }
.hbrand-name { font-family:'Montserrat',sans-serif; font-weight:800; font-size:14px; color:var(--azul); letter-spacing:-.01em; }
.hbrand-unit { font-family:'Montserrat',sans-serif; font-size:10px; color:var(--verde); letter-spacing:.12em; text-transform:uppercase; font-weight:700; }
.hsep { width:1px; height:34px; background:var(--border); flex-shrink:0; }
.htitle { flex:1; }
.heyebrow { font-family:'Montserrat',sans-serif; font-size:9px; letter-spacing:.2em; color:var(--verde); text-transform:uppercase; font-weight:700; margin-bottom:2px; }
.hmain { font-family:'Montserrat',sans-serif; font-size:clamp(13px,1.8vw,18px); font-weight:800; color:var(--azul); }
.hactions { display:flex; gap:8px; align-items:center; margin-left:auto; }
.btn-dl { display:inline-flex; align-items:center; gap:6px; background:var(--verde); color:#fff; border:none; padding:7px 14px; border-radius:6px; font-size:11px; font-weight:700; font-family:'Montserrat',sans-serif; text-decoration:none; white-space:nowrap; transition:.2s; letter-spacing:.02em; }
.btn-dl:hover { background:var(--verde-dk); box-shadow:var(--shadow-md); }
.btn-dl.am { background:var(--amarillo); color:var(--azul); }
.btn-dl.am:hover { background:#e6b800; }
.btn-dl svg { width:13px; height:13px; }

/* ONDA SUPERIOR */
.wave-top { width:100%; height:80px; overflow:hidden; background:var(--white); flex-shrink:0; position:relative; }
.wave-top svg { position:absolute; inset:0; width:100%; height:100%; }
.deco-dot { position:absolute; width:50px; height:50px; border-radius:50%; background:var(--amarillo); top:10px; right:52px; }

/* CONTAINER */
.container { max-width:1440px; margin:0 auto; padding:28px 32px 56px; }

/* PAGE HEADER */
.page-header { display:flex; align-items:flex-start; justify-content:space-between; gap:24px; margin-bottom:24px; flex-wrap:wrap; animation:fadeUp .4s ease both; }
.plabel { display:inline-flex; align-items:center; background:var(--verde); color:#fff; padding:4px 14px; border-radius:4px; font-family:'Montserrat',sans-serif; font-size:9px; letter-spacing:.2em; text-transform:uppercase; font-weight:700; margin-bottom:10px; }
.ptitle { font-family:'Montserrat',sans-serif; font-size:clamp(22px,3.5vw,38px); font-weight:900; color:var(--azul); line-height:1.05; letter-spacing:-.02em; margin-bottom:8px; }
.ptitle span { color:var(--verde); }
.psubtitle { font-size:13px; color:var(--muted); line-height:1.5;  }

/* NOTE BAR */
.note-bar { background:rgba(0,148,233,0.06); border:1px solid rgba(0,148,233,0.2); border-left:4px solid var(--celeste); border-radius:8px; padding:10px 16px; font-size:12px; color:var(--azul); margin-bottom:20px; display:flex; align-items:center; gap:8px; font-family:'Open Sans',sans-serif; animation:fadeUp .4s ease both; }
.note-bar strong { color:var(--azul); font-weight:700; }

/* SECTION HEADING */
.sh { display:flex; align-items:center; gap:10px; margin:28px 0 14px; }
.sh-bar { width:4px; height:20px; background:var(--verde); border-radius:2px; flex-shrink:0; }
.sh-txt { font-family:'Montserrat',sans-serif; font-size:10px; letter-spacing:.18em; text-transform:uppercase; color:var(--azul); font-weight:800; }
.sh-line { flex:1; height:1px; background:var(--border); }

/* FILTERS */
.filters { background:var(--white); border:1px solid var(--border); border-radius:10px; padding:14px 20px; display:flex; gap:20px; align-items:center; flex-wrap:wrap; margin-bottom:20px; box-shadow:var(--shadow-sm); animation:fadeUp .4s ease both; }
.filter-group { display:flex; flex-direction:column; gap:4px; }
.filter-label { font-family:'Montserrat',sans-serif; font-size:9px; text-transform:uppercase; letter-spacing:.16em; color:var(--azul); font-weight:700; }
select { background:var(--s2); border:1.5px solid var(--border-dk); color:var(--text); padding:7px 32px 7px 12px; border-radius:8px; font-family:'Montserrat',sans-serif; font-size:12px; font-weight:600; cursor:pointer; outline:none; appearance:none; min-width:180px; transition:.2s; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%23203B76'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 10px center; }
select:hover { border-color:var(--verde); }
select:focus { outline:none; border-color:var(--verde); }
.filter-divider { width:1px; height:36px; background:var(--border); }

/* LEYENDA */
.legend { display:flex; gap:14px; flex-wrap:wrap; }
.legend-item { display:flex; align-items:center; gap:6px; font-size:11px; color:var(--muted); font-family:'Montserrat',sans-serif; font-weight:600; }
.legend-dot { width:10px; height:10px; border-radius:3px; flex-shrink:0; }

/* KPI GRID */
.kpi-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:20px; }
.kpi-card { background:var(--white); border:1px solid var(--border); border-top:4px solid var(--verde); border-radius:10px; padding:20px 22px; position:relative; overflow:hidden; transition:.2s; box-shadow:var(--shadow-sm); animation:fadeUp .45s ease both; }
.kpi-card:hover { transform:translateY(-2px); box-shadow:var(--shadow-md); }
.kpi-card.green { border-top-color:var(--verde); }
.kpi-card.yellow { border-top-color:var(--amarillo); }
.kpi-card.orange { border-top-color:var(--extra2); }
.kpi-card.blue   { border-top-color:var(--azul); }
.kpi-card::after { content:attr(data-icon); position:absolute; right:14px; bottom:10px; font-size:36px; opacity:.07; pointer-events:none; }
.kpi-label { font-family:'Montserrat',sans-serif; font-size:9px; text-transform:uppercase; letter-spacing:.16em; color:var(--muted); font-weight:700; margin-bottom:10px; }
.kpi-value { font-family:'Montserrat',sans-serif; font-size:32px; font-weight:900; line-height:1; margin-bottom:6px; }
.kpi-sub { font-size:11px; color:var(--muted); line-height:1.4; }
.kpi-card.green .kpi-value { color:var(--verde); }
.kpi-card.yellow .kpi-value { color:var(--cafe); }
.kpi-card.orange .kpi-value { color:var(--extra2); }
.kpi-card.blue   .kpi-value { color:var(--azul); }
.kpi-card:nth-child(1){animation-delay:.05s}.kpi-card:nth-child(2){animation-delay:.10s}
.kpi-card:nth-child(3){animation-delay:.15s}.kpi-card:nth-child(4){animation-delay:.20s}

/* PANEL LAYOUTS */
.panel-grid   { display:grid; grid-template-columns:1.8fr 1fr; gap:18px; margin-bottom:18px; }
.panel-grid-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:18px; margin-bottom:18px; }
.panel-full   { margin-bottom:18px; }
.panel { background:var(--white); border:1px solid var(--border); border-top:3px solid var(--verde); border-radius:10px; overflow:hidden; box-shadow:var(--shadow-sm); transition:.2s; animation:fadeUp .45s ease both; }
.panel:hover { box-shadow:var(--shadow-md); }
.panel.az-top { border-top-color:var(--azul); }
.panel.am-top { border-top-color:var(--amarillo); }
.panel-header { padding:16px 22px 12px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; background:var(--s2); }
.panel-title { font-family:'Montserrat',sans-serif; font-size:14px; font-weight:800; color:var(--azul); letter-spacing:-.01em; }
.panel-subtitle { font-size:11px; color:var(--muted); margin-top:2px; font-family:'Open Sans',sans-serif; }
.panel-body { padding:20px 22px; }

/* STACKED BARS */
.stacked-bar-container { display:flex; flex-direction:column; gap:10px; }
.bar-row { display:flex; align-items:center; gap:12px; }
.bar-label { font-size:11px; color:var(--text-dim); width:140px; flex-shrink:0; text-align:right; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-family:'Montserrat',sans-serif; font-weight:600; }
.bar-track { flex:1; height:24px; border-radius:5px; overflow:hidden; display:flex; background:var(--s2); }
.bar-segment { height:100%; transition:width .6s cubic-bezier(.4,0,.2,1); cursor:pointer; }
.bar-segment:hover { filter:brightness(1.12); }
.bar-total { font-size:11px; color:var(--muted); width:52px; text-align:right; font-family:'Montserrat',sans-serif; font-weight:700; }

/* FUNNEL */
.funnel { display:flex; flex-direction:column; gap:8px; }
.funnel-bar { height:26px; border-radius:5px; display:flex; align-items:center; padding:0 10px; }
.funnel-bar span { font-size:10px; font-weight:700; white-space:nowrap; font-family:'Montserrat',sans-serif; }

/* DONUT */
.donut-wrap { display:flex; align-items:center; gap:20px; }
.donut-labels { display:flex; flex-direction:column; gap:9px; flex:1; }
.donut-label-row { display:flex; align-items:center; gap:8px; font-size:12px; }

/* COHORT TABLE */
.cohort-table { width:100%; border-collapse:collapse; font-size:12px; }
.cohort-table th { text-align:left; font-family:'Montserrat',sans-serif; font-size:9px; text-transform:uppercase; letter-spacing:.12em; color:var(--azul); font-weight:700; padding:10px 14px; border-bottom:2px solid var(--verde); background:var(--s2); }
.cohort-table td { padding:10px 14px; border-bottom:1px solid var(--border); vertical-align:middle; font-family:'Open Sans',sans-serif; }
.cohort-table tr:last-child td { border-bottom:none; }
.cohort-table tr:hover td { background:#f7fdf7; }
.chip { display:inline-block; padding:2px 8px; border-radius:4px; font-size:10px; font-weight:700; font-family:'Montserrat',sans-serif; }
.chip-green  { background:rgba(27,163,51,.12); color:var(--verde-dk); border:1px solid rgba(27,163,51,.25); }
.chip-yellow { background:rgba(212,135,10,.12); color:#a06b00; border:1px solid rgba(212,135,10,.25); }
.chip-orange { background:rgba(192,90,26,.12); color:var(--extra2); border:1px solid rgba(192,90,26,.25); }

/* TOOLTIP */
#tooltip { position:fixed; background:var(--white); border:1px solid var(--border); border-left:3px solid var(--verde); border-radius:8px; padding:10px 14px; font-size:12px; pointer-events:none; opacity:0; transition:opacity .15s; z-index:1000; min-width:200px; box-shadow:var(--shadow-md); }
#tooltip .tt-title { font-family:'Montserrat',sans-serif; font-weight:800; margin-bottom:7px; font-size:12px; color:var(--azul); }
#tooltip .tt-row { display:flex; justify-content:space-between; gap:16px; margin:3px 0; }
#tooltip .tt-key { color:var(--muted); font-size:11px; }
#tooltip .tt-val { font-weight:700; font-size:11px; font-family:'Montserrat',sans-serif; }

/* WAVE FOOTER */
.wfooter { margin-top:48px; }
.wfooter svg { display:block; width:100%; }
.footer-bar { background:var(--verde); padding:18px 32px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; }
.fn { font-family:'Montserrat',sans-serif; font-weight:800; font-size:13px; color:#fff; }
.fs { font-size:11px; color:rgba(255,255,255,.75); margin-top:2px; }
.footer-bar img { height:50px; filter:brightness(0) invert(1); opacity:.9; }

/* BADGE INFO */
.badge-info { display:inline-block; padding:3px 9px; border-radius:4px; font-size:9px; letter-spacing:.08em; text-transform:uppercase; font-weight:700; font-family:'Montserrat',sans-serif; background:rgba(32,59,118,.10); color:var(--azul); border:1px solid rgba(32,59,118,.25); }

@keyframes fadeUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
@media(max-width:1100px){ .kpi-grid{grid-template-columns:repeat(2,1fr)} .panel-grid{grid-template-columns:1fr} .panel-grid-3{grid-template-columns:1fr 1fr} }
@media(max-width:720px){ .container{padding:16px} .panel-grid-3{grid-template-columns:1fr} .kpi-grid{grid-template-columns:1fr 1fr} .hactions .btn-dl:last-child{display:none}  .htitle { display:none; }   /* Mostrado en title-block ya */}
</style>
</head>
<body>

<header>
  <div class="hi">
    <a class="hlogo" href="#"><img src="https://sys.unag.edu.hn/assets/images/escudo.png" alt="Escudo UNAG"></a>
    <div class="hbrand">
      <div class="hbrand-name">Universidad Nacional de Agricultura</div>
      <div class="hbrand-unit">SETIC · Análisis Institucional</div>
    </div>
    <div class="hsep"></div>
    <div class="htitle">
      <div class="heyebrow">Análisis Académico · UNAG</div>
      <div class="hmain">Eficiencia de Titulación Oportuna</div>
    </div>
    <div class="">
      <a class="btn-dl am" href="https://drive.google.com/file/d/1FfGcXCFLVw3O-KiQY9fe8V7lrZPKjh06/view?usp=sharing" target="_blank" rel="noopener">
        <svg viewBox="0 0 16 16" fill="currentColor"><path d="M8 12l-4-4h2.5V4h3v4H12L8 12z"/><rect x="2" y="13" width="12" height="1.5" rx=".75"/></svg>Muestra Excel
      </a>
      <a class="btn-dl" href="https://drive.google.com/file/d/18CXw0QC1J_13FRCo7FkHRXPaT1KgWTw1/view?usp=sharing" target="_blank" rel="noopener">
        <svg viewBox="0 0 16 16" fill="currentColor"><path d="M8 12l-4-4h2.5V4h3v4H12L8 12z"/><rect x="2" y="13" width="12" height="1.5" rx=".75"/></svg>Informe PDF
      </a>
    </div>
  </div>
</header>

<!-- Onda decorativa superior — estilo manual de marca UNAG -->
<div class="wave-top">
  <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
    <path d="M0,25 C200,65 450,5 720,38 C990,70 1250,10 1440,32 L1440,80 L0,80 Z" fill="#203B76" opacity="0.10"/>
    <path d="M0,48 C320,18 640,65 960,40 C1150,25 1320,54 1440,42 L1440,80 L0,80 Z" fill="#1BA333" opacity="0.13"/>
    <path d="M0,60 C450,44 850,70 1440,52" stroke="#1BA333" stroke-width="1.5" fill="none" opacity="0.4"/>
  </svg>
  <div class="deco-dot"></div>
</div>

<div id="tooltip"></div>
<div class="container">

  <!-- Page Header -->
  <div class="page-header">
    <div>
      <div class="plabel">Cohortes 2016 – 2022 · Seguimiento de Egreso</div>
      <h1 class="ptitle">Dashboard — <span>Titulación</span> Oportuna</h1>
      <p class="psubtitle">Medición de cuántos estudiantes se gradúan dentro del tiempo establecido por el plan de estudios</p>
      <p class="psubtitle">Nota: Este análisis está hecho en base a una muestra de 4,792 registros de estudiantes que ingresaron del 2016 al 2022</p>
    </div>
  </div>

  <div class="note-bar">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    Análisis restringido a cohortes <strong>2016 – 2022</strong>: únicos años de ingreso con tiempo suficiente para haber completado el plan de estudios al momento del análisis.
  </div>

  <!-- Filters -->
  <div class="filters">
    <div class="filter-group">
      <span class="filter-label">Carrera</span>
      <select id="filterCarrera" onchange="update()"><option value="all">Todas las carreras</option></select>
    </div>
    <div class="filter-divider"></div>
    <div class="filter-group">
      <span class="filter-label">Año de ingreso</span>
      <select id="filterIngreso" onchange="update()"><option value="all">Todos (2016–2022)</option></select>
    </div>
    <div style="margin-left:auto">
      <div class="legend">
        <div class="legend-item"><div class="legend-dot" style="background:var(--ontime)"></div>A tiempo</div>
        <div class="legend-item"><div class="legend-dot" style="background:var(--extra1)"></div>+1 año</div>
        <div class="legend-item"><div class="legend-dot" style="background:var(--extra2)"></div>+2 años</div>
        <div class="legend-item"><div class="legend-dot" style="background:var(--extra3)"></div>+3 o más</div>
        <div class="legend-item"><div class="legend-dot" style="background:var(--nograd);border:1px solid var(--border-dk)"></div>Sin graduarse</div>
      </div>
    </div>
  </div>

  <!-- KPIs -->
  <div class="sh"><div class="sh-bar"></div><div class="sh-txt">Indicadores Clave</div><div class="sh-line"></div></div>
  <div class="kpi-grid">
    <div class="kpi-card green" data-icon="🎓">
      <div class="kpi-label">Graduados a tiempo</div>
      <div class="kpi-value" id="kpi1">—</div>
      <div class="kpi-sub" id="kpi1s">dentro del plan de estudios</div>
    </div>
    <div class="kpi-card yellow" data-icon="📊">
      <div class="kpi-label">Tasa de graduación</div>
      <div class="kpi-value" id="kpi2">—</div>
      <div class="kpi-sub" id="kpi2s">sobre total ingresantes</div>
    </div>
    <div class="kpi-card orange" data-icon="⏳">
      <div class="kpi-label">Graduados tardíos</div>
      <div class="kpi-value" id="kpi3">—</div>
      <div class="kpi-sub" id="kpi3s">superaron el tiempo plan</div>
    </div>
    <div class="kpi-card blue" data-icon="📋">
      <div class="kpi-label">Sin graduarse</div>
      <div class="kpi-value" id="kpi4">—</div>
      <div class="kpi-sub" id="kpi4s">no registran egreso</div>
    </div>
  </div>

  <!-- Barras + Donut -->
  <div class="sh"><div class="sh-bar"></div><div class="sh-txt">Distribución por Carrera</div><div class="sh-line"></div></div>
  <div class="panel-grid">
    <div class="panel">
      <div class="panel-header">
        <div>
          <div class="panel-title">Titulación oportuna por carrera</div>
          <div class="panel-subtitle">Distribución a tiempo / tardíos / sin graduarse sobre total ingresantes</div>
        </div>
      </div>
      <div class="panel-body">
        <div class="stacked-bar-container" id="barByCarrera"></div>
      </div>
    </div>
    <div class="panel az-top">
      <div class="panel-header">
        <div>
          <div class="panel-title">Distribución de graduados</div>
          <div class="panel-subtitle">Por tiempo de permanencia</div>
        </div>
      </div>
      <div class="panel-body">
        <div class="donut-wrap">
          <canvas id="donutChart" width="140" height="140"></canvas>
          <div class="donut-labels" id="donutLabels"></div>
        </div>
        <hr style="border:none;border-top:1px solid var(--border);margin:16px 0">
        <div class="funnel" id="funnelChart"></div>
      </div>
    </div>
  </div>

  <!-- Cohort Table -->
  <div class="sh"><div class="sh-bar"></div><div class="sh-txt">Análisis por Cohorte de Ingreso</div><div class="sh-line"></div></div>
  <div class="panel panel-full">
    <div class="panel-header">
      <div>
        <div class="panel-title">Seguimiento generacional 2016 – 2022</div>
        <div class="panel-subtitle">Titulación oportuna por año de ingreso</div>
      </div>
      <span class="badge-info">Interactivo</span>
    </div>
    <div class="panel-body" style="padding:0">
      <div style="overflow-x:auto">
        <table class="cohort-table">
          <thead>
            <tr>
              <th>Cohorte</th><th>Ingresantes</th><th>Graduados</th>
              <th>% Graduación</th><th>A tiempo</th><th>+1 año</th>
              <th>+2 años</th><th>+3 o más</th><th>Sin graduarse</th>
              <th>Distribución visual</th>
            </tr>
          </thead>
          <tbody id="cohortBody"></tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Bottom 3 panels -->
  <div class="sh"><div class="sh-bar"></div><div class="sh-txt">Análisis Estadístico</div><div class="sh-line"></div></div>
  <div class="panel-grid-3">
    <div class="panel">
      <div class="panel-header">
        <div class="panel-title">Histograma de años cursados</div>
        <div class="panel-subtitle">Solo graduados</div>
      </div>
      <div class="panel-body">
        <div id="histogram" style="height:180px;display:flex;align-items:flex-end;gap:6px;"></div>
        <div style="margin-top:10px;display:flex;gap:6px;justify-content:center;" id="histLabels"></div>
      </div>
    </div>
    <div class="panel am-top">
      <div class="panel-header">
        <div class="panel-title">Promedio años cursados</div>
        <div class="panel-subtitle">vs. duración del plan (línea de referencia)</div>
      </div>
      <div class="panel-body">
        <div id="avgChart" style="display:flex;flex-direction:column;gap:10px;"></div>
      </div>
    </div>
    <div class="panel">
      <div class="panel-header">
        <div class="panel-title">Tasa de graduación</div>
        <div class="panel-subtitle">Por carrera, ranking descendente</div>
      </div>
      <div class="panel-body">
        <div id="rateChart" style="display:flex;flex-direction:column;gap:10px;"></div>
      </div>
    </div>
  </div>

</div>

<!-- Onda footer estilo manual UNAG -->
<div class="wfooter">
  <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:block;background:var(--bg)">
    <path d="M0,18 C320,52 660,4 980,36 C1160,54 1320,14 1440,28 L1440,60 L0,60 Z" fill="#1BA333"/>
    <path d="M0,34 C420,14 760,52 1100,30 C1270,18 1380,42 1440,48 L1440,60 L0,60 Z" fill="#135423" opacity="0.45"/>
    <path d="M0,50 C440,38 860,58 1440,44" stroke="white" stroke-width="1.5" fill="none" opacity="0.35"/>
  </svg>
  <div class="footer-bar">
    <div>
      <div class="fn">Universidad Nacional de Agricultura — UNAG</div>
      <div class="fs">Secretaría de Tecnología de la Información y Comunicaciones (SETIC) · Dashboard Analítico · Titulación Oportuna · 2025</div>
    </div>
    <img src="https://setic.unag.edu.hn/img/logo-setic-blanco.png" alt="SETIC UNAG">
  </div>
</div>

<script>
const CARRERA_DATA = {
  "Administración de Empresas Agropecuarias": {total:236,  grad:56,  dist:{3:7,4:31,5:10,6:5,7:1,8:1,9:1}, dur:4},
  "Economía Social Agraria":                  {total:23,   grad:3,   dist:{4:3},                             dur:4},
  "Ingeniería Agronómica":                    {total:2843, grad:1415,dist:{3:306,4:860,5:182,6:50,7:15,8:2},dur:4.3},
  "Ingeniería en Agroexportación":            {total:45,   grad:0,   dist:{},                                dur:4.3},
  "Ingeniería en Gestión Integral de los Recursos Naturales":{total:299,grad:71,dist:{4:61,5:10},            dur:4.3},
  "Ingeniería en Tecnología Alimentaria":     {total:383,  grad:153, dist:{4:124,5:24,6:4,7:1},             dur:4.3},
  "Ingeniería en Zootecnia":                  {total:161,  grad:66,  dist:{3:30,4:35,5:1},                  dur:4},
  "Medicina Veterinaria":                     {total:278,  grad:45,  dist:{5:39,6:6},                       dur:5.6},
  "Recursos Naturales y Ambiente":            {total:204,  grad:125, dist:{3:5,4:95,5:15,6:6,8:3,9:1},     dur:4},
  "Tecnología Alimentaria":                   {total:320,  grad:217, dist:{4:168,5:25,6:15,7:6,8:2,9:1},   dur:4},
};

const COHORT_DATA = {
  2016:{total:1277,grad:934,ontime:665,extra1:171,extra2:67,extra3:31},
  2018:{total:834, grad:403,ontime:358,extra1:37, extra2:5, extra3:3},
  2019:{total:555, grad:296,ontime:251,extra1:37, extra2:8, extra3:0},
  2020:{total:460, grad:242,ontime:214,extra1:28, extra2:0, extra3:0},
  2021:{total:937, grad:239,ontime:239,extra1:0,  extra2:0, extra3:0},
  2022:{total:729, grad:37, ontime:37, extra1:0,  extra2:0, extra3:0},
};

/* Colores UNAG adaptados a semáforo */
const C = {
  ontime: '#1BA333',
  extra1: '#d4870a',
  extra2: '#c05a1a',
  extra3: '#c03030',
  nograd: '#aacaaa'
};

/* Init selects */
const selC=document.getElementById('filterCarrera'), selY=document.getElementById('filterIngreso');
Object.keys(CARRERA_DATA).forEach(n=>{const o=document.createElement('option');o.value=n;o.textContent=n;selC.appendChild(o);});
Object.keys(COHORT_DATA).forEach(y=>{const o=document.createElement('option');o.value=y;o.textContent=y;selY.appendChild(o);});

/* Tooltip */
const tip=document.getElementById('tooltip');
function showTip(e,title,rows){
  tip.innerHTML=`<div class="tt-title">${title}</div>`+rows.map(([k,v,c])=>`<div class="tt-row"><span class="tt-key">${k}</span><span class="tt-val" style="color:${c||'var(--azul)'}">${v}</span></div>`).join('');
  tip.style.opacity=1;
}
document.addEventListener('mousemove',e=>{tip.style.left=Math.min(e.clientX+14,window.innerWidth-220)+'px';tip.style.top=(e.clientY-10)+'px';});
function hideTip(){tip.style.opacity=0;}

function breakdown(d){
  let on=0,e1=0,e2=0,e3=0;
  for(const yr in d.dist){const ex=parseFloat(yr)-d.dur,n=d.dist[yr];if(ex<=0)on+=n;else if(ex<=1)e1+=n;else if(ex<=2)e2+=n;else e3+=n;}
  return{ontime:on,extra1:e1,extra2:e2,extra3:e3,nograd:d.total-d.grad};
}

function getFiltered(){
  const fc=selC.value,fy=selY.value;
  return{
    cData:fc==='all'?{...CARRERA_DATA}:{[fc]:CARRERA_DATA[fc]},
    cohData:fy==='all'?{...COHORT_DATA}:{[fy]:COHORT_DATA[fy]}
  };
}

function aggregate(cData){
  let total=0,grad=0,ontime=0,extra1=0,extra2=0,extra3=0;
  const hist={};
  for(const k in cData){
    const d=cData[k],b=breakdown(d);
    total+=d.total;grad+=d.grad;ontime+=b.ontime;extra1+=b.extra1;extra2+=b.extra2;extra3+=b.extra3;
    for(const yr in d.dist)hist[yr]=(hist[yr]||0)+d.dist[yr];
  }
  return{total,grad,ontime,extra1,extra2,extra3,nograd:total-grad,hist};
}

function renderKPIs(a){
  document.getElementById('kpi1').textContent=a.total>0?(a.ontime/a.total*100).toFixed(1)+'%':'—';
  document.getElementById('kpi1s').textContent=`${a.ontime.toLocaleString()} de ${a.total.toLocaleString()} ingresantes`;
  document.getElementById('kpi2').textContent=a.total>0?(a.grad/a.total*100).toFixed(1)+'%':'—';
  document.getElementById('kpi2s').textContent=`${a.grad.toLocaleString()} egresados registrados`;
  const late=a.extra1+a.extra2+a.extra3;
  document.getElementById('kpi3').textContent=late.toLocaleString();
  document.getElementById('kpi3s').textContent=`${a.grad>0?(late/a.grad*100).toFixed(1):'0'}% de los graduados`;
  document.getElementById('kpi4').textContent=a.nograd.toLocaleString();
  document.getElementById('kpi4s').textContent=`${a.total>0?(a.nograd/a.total*100).toFixed(1):'0'}% del total`;
}

function renderBars(cData){
  const el=document.getElementById('barByCarrera');el.innerHTML='';
  const entries=Object.entries(cData).filter(([,d])=>d.total>0);
  entries.sort((a,b)=>(b[1].grad/b[1].total)-(a[1].grad/a[1].total));
  for(const [name,d] of entries){
    const b=breakdown(d),T=d.total;
    const segs=[[b.ontime/T*100,C.ontime,'A tiempo',b.ontime],[b.extra1/T*100,C.extra1,'+1 año',b.extra1],[b.extra2/T*100,C.extra2,'+2 años',b.extra2],[b.extra3/T*100,C.extra3,'+3 o más',b.extra3],[b.nograd/T*100,C.nograd,'Sin graduarse',b.nograd]];
    const short=name.replace('Ingeniería en ','Ing. ').replace('Ingeniería ','Ing. ').replace('Administración de Empresas Agropecuarias','Admón. Agropec.').replace('Recursos Naturales y Ambiente','Rec. Naturales');
    const row=document.createElement('div');row.className='bar-row';
    row.innerHTML=`<div class="bar-label" title="${name}">${short}</div><div class="bar-track"></div><div class="bar-total">${T.toLocaleString()}</div>`;
    el.appendChild(row);
    const track=row.querySelector('.bar-track');
    segs.forEach(([pct,color,label,count])=>{
      if(pct<=0)return;
      const seg=document.createElement('div');seg.className='bar-segment';seg.style.width=pct+'%';seg.style.background=color;
      seg.addEventListener('mouseenter',e=>showTip(e,name,[['Categoría',label,color],['Cantidad',count.toLocaleString()],['% del total',pct.toFixed(1)+'%'],['Ingresantes',T.toLocaleString()]]));
      seg.addEventListener('mouseleave',hideTip);
      track.appendChild(seg);
    });
  }
}

function renderDonut(a){
  const segs=[{val:a.ontime,color:C.ontime,label:'A tiempo'},{val:a.extra1,color:C.extra1,label:'+1 año'},{val:a.extra2,color:C.extra2,label:'+2 años'},{val:a.extra3,color:C.extra3,label:'+3 o más'},{val:a.nograd,color:C.nograd,label:'Sin graduarse'}];
  const sum=segs.reduce((s,x)=>s+x.val,0);
  const cv=document.getElementById('donutChart'),ctx=cv.getContext('2d');
  ctx.clearRect(0,0,140,140);
  let st=-Math.PI/2;
  segs.forEach(s=>{if(!s.val)return;const ang=(s.val/sum)*2*Math.PI;ctx.beginPath();ctx.moveTo(70,70);ctx.arc(70,70,60,st,st+ang);ctx.closePath();ctx.fillStyle=s.color;ctx.fill();st+=ang;});
  ctx.beginPath();ctx.arc(70,70,40,0,2*Math.PI);ctx.fillStyle='#ffffff';ctx.fill();
  /* Borde circular interior sutil */
  ctx.beginPath();ctx.arc(70,70,40,0,2*Math.PI);ctx.strokeStyle='var(--border)';ctx.lineWidth=1;ctx.stroke();
  ctx.fillStyle='#203B76';ctx.font='bold 17px Montserrat,sans-serif';ctx.textAlign='center';
  ctx.fillText(sum>0?(a.grad/a.total*100).toFixed(0)+'%':'—',70,74);
  ctx.fillStyle='#6b8a6b';ctx.font='600 9px Montserrat,sans-serif';ctx.fillText('graduados',70,88);
  const labEl=document.getElementById('donutLabels');labEl.innerHTML='';
  segs.filter(s=>s.val>0).forEach(s=>{
    const pct=sum>0?(s.val/sum*100).toFixed(1):'0';
    labEl.innerHTML+=`<div class="donut-label-row"><div style="width:10px;height:10px;border-radius:3px;background:${s.color};flex-shrink:0"></div><span style="color:var(--muted);font-size:11px;flex:1;font-family:'Montserrat',sans-serif;font-weight:600">${s.label}</span><span style="font-weight:800;font-size:13px;color:${s.color};font-family:'Montserrat',sans-serif">${pct}%</span></div>`;
  });
}

function renderFunnel(a){
  const el=document.getElementById('funnelChart');el.innerHTML='';
  const steps=[
    {label:'Ingresantes totales',val:a.total,color:'#0094E9'},
    {label:'Se gradúan',val:a.grad,color:'#1BA333'},
    {label:'A tiempo (≤ plan)',val:a.ontime,color:'#1BA333'},
    {label:'Acumulado con +1 año',val:a.ontime+a.extra1,color:'#d4870a'},
    {label:'Acumulado con +2 años',val:a.ontime+a.extra1+a.extra2,color:'#c05a1a'},
  ];
  steps.forEach(s=>{
    const pct=a.total>0?(s.val/a.total*100):0;
    el.innerHTML+=`<div><div style="display:flex;justify-content:space-between;margin-bottom:3px"><span style="font-size:11px;color:var(--muted);font-family:'Montserrat',sans-serif;font-weight:600">${s.label}</span><span style="font-size:11px;font-weight:800;color:${s.color};font-family:'Montserrat',sans-serif">${s.val.toLocaleString()}</span></div><div class="funnel-bar" style="width:${Math.max(pct,1)}%;background:${s.color}15;border-left:3px solid ${s.color}"><span style="color:${s.color}">${pct.toFixed(1)}%</span></div></div>`;
  });
}

function renderCohortTable(cohData){
  const tbody=document.getElementById('cohortBody');tbody.innerHTML='';
  Object.entries(cohData).sort((a,b)=>a[0]-b[0]).forEach(([yr,d])=>{
    const ng=d.total-d.grad,T=d.total;
    const pG=T?(d.grad/T*100):0,pOn=T?(d.ontime/T*100):0;
    const p1=T?(d.extra1/T*100):0,p2=T?(d.extra2/T*100):0,p3=T?(d.extra3/T*100):0,pNG=T?(ng/T*100):0;
    const col=pG>=60?'var(--verde)':pG>=30?'var(--extra1)':'var(--extra2)';
    tbody.innerHTML+=`<tr>
      <td><strong style="font-family:'Montserrat',sans-serif;font-size:16px;font-weight:900;color:var(--azul)">${yr}</strong></td>
      <td style="font-family:'Montserrat',sans-serif;font-weight:700">${T.toLocaleString()}</td>
      <td style="font-family:'Montserrat',sans-serif;font-weight:700">${d.grad.toLocaleString()}</td>
      <td><div style="display:flex;align-items:center;gap:8px"><div style="height:6px;width:${Math.min(pG,60)}px;border-radius:3px;background:${col}"></div><span style="font-weight:800;color:${col};font-family:'Montserrat',sans-serif">${pG.toFixed(1)}%</span></div></td>
      <td><span class="chip chip-green">${d.ontime} (${pOn.toFixed(0)}%)</span></td>
      <td>${d.extra1>0?`<span class="chip chip-yellow">${d.extra1} (${p1.toFixed(0)}%)</span>`:'<span style="color:var(--muted)">—</span>'}</td>
      <td>${d.extra2>0?`<span class="chip chip-orange">${d.extra2} (${p2.toFixed(0)}%)</span>`:'<span style="color:var(--muted)">—</span>'}</td>
      <td>${d.extra3>0?`<span style="color:var(--extra3);font-weight:800;font-size:12px;font-family:'Montserrat',sans-serif">${d.extra3} (${p3.toFixed(0)}%)</span>`:'<span style="color:var(--muted)">—</span>'}</td>
      <td><span style="color:var(--muted);font-family:'Montserrat',sans-serif;font-weight:600">${ng.toLocaleString()} (${pNG.toFixed(0)}%)</span></td>
      <td><div style="display:flex;height:10px;border-radius:5px;overflow:hidden;width:130px;gap:1px">
        ${pOn>0?`<div style="width:${pOn}%;background:var(--ontime)"></div>`:''}
        ${p1>0?`<div style="width:${p1}%;background:var(--extra1)"></div>`:''}
        ${p2>0?`<div style="width:${p2}%;background:var(--extra2)"></div>`:''}
        ${p3>0?`<div style="width:${p3}%;background:var(--extra3)"></div>`:''}
        ${pNG>0?`<div style="width:${pNG}%;background:var(--nograd)"></div>`:''}
      </div></td>
    </tr>`;
  });
}

function renderHistogram(cData){
  const dist={};
  for(const k in cData)for(const yr in cData[k].dist)dist[yr]=(dist[yr]||0)+cData[k].dist[yr];
  const el=document.getElementById('histogram'),labEl=document.getElementById('histLabels');
  el.innerHTML='';labEl.innerHTML='';
  if(!Object.keys(dist).length){el.innerHTML='<div style="text-align:center;padding:32px;color:var(--muted);font-size:13px">Sin datos</div>';return;}
  const sorted=Object.entries(dist).sort((a,b)=>+a[0]-+b[0]);
  const maxV=Math.max(...sorted.map(s=>s[1]));
  sorted.forEach(([yr,cnt])=>{
    const h=Math.max((cnt/maxV)*160,4);
    const over=parseFloat(yr)>4.3;
    const col=over?'var(--extra1)':'var(--verde)';
    const hcol=over?'var(--extra2)':'var(--verde-dk)';
    const col2=document.createElement('div');
    col2.style.cssText='flex:1;display:flex;flex-direction:column;align-items:center;gap:4px;cursor:pointer;';
    col2.innerHTML=`<span style="font-size:9px;color:var(--muted);font-family:'Montserrat',sans-serif;font-weight:700">${cnt}</span><div style="width:100%;height:${h}px;background:${col};border-radius:4px 4px 0 0;transition:.3s"></div>`;
    col2.addEventListener('mouseenter',e=>{col2.querySelector('div').style.background=hcol;showTip(e,`Año ${yr} de cursado`,[['Graduados',cnt.toLocaleString(),'var(--azul)'],['Proporción',(cnt/maxV*100).toFixed(0)+'% del máximo']]);});
    col2.addEventListener('mouseleave',()=>{col2.querySelector('div').style.background=col;hideTip();});
    el.appendChild(col2);
    labEl.innerHTML+=`<span style="flex:1;text-align:center;font-size:9px;color:var(--muted);font-family:'Montserrat',sans-serif;font-weight:600">${yr}a</span>`;
  });
}

function renderAvgChart(cData){
  const el=document.getElementById('avgChart');el.innerHTML='';
  const entries=Object.entries(cData).filter(([,d])=>d.grad>0);
  if(!entries.length){el.innerHTML='<div style="text-align:center;padding:32px;color:var(--muted);font-size:13px">Sin datos</div>';return;}
  const avgs=entries.map(([name,d])=>{let s=0,c=0;for(const yr in d.dist){s+=parseFloat(yr)*d.dist[yr];c+=d.dist[yr];}return{name,avg:c?s/c:0,dur:d.dur};}).sort((a,b)=>a.avg-b.avg);
  const maxA=Math.max(...avgs.map(a=>a.avg));
  avgs.forEach(({name,avg,dur})=>{
    const short=name.replace('Ingeniería en ','').replace('Ingeniería ','Ing. ').replace('Administración de Empresas Agropecuarias','Admón. Agropec.').replace('Recursos Naturales y Ambiente','Rec. Naturales');
    const over=avg>dur,color=over?'var(--extra2)':'var(--verde)';
    el.innerHTML+=`<div><div style="display:flex;justify-content:space-between;margin-bottom:3px"><span style="font-size:10px;color:var(--muted);font-family:'Montserrat',sans-serif;font-weight:600">${short}</span><span style="font-size:11px;font-weight:800;color:${color};font-family:'Montserrat',sans-serif">${avg.toFixed(2)}a <span style="color:var(--muted);font-weight:500;font-size:10px">(plan: ${dur}a)</span></span></div><div style="height:10px;background:var(--s2);border-radius:5px;overflow:hidden;position:relative"><div style="height:100%;width:${(dur/maxA*100).toFixed(0)}%;background:rgba(27,163,51,0.15);position:absolute;border-right:2px dashed var(--verde)"></div><div style="height:100%;width:${(avg/maxA*100).toFixed(0)}%;background:${color};border-radius:5px;transition:.4s"></div></div></div>`;
  });
}

function renderRateChart(cData){
  const el=document.getElementById('rateChart');el.innerHTML='';
  Object.entries(cData).sort((a,b)=>(b[1].grad/b[1].total)-(a[1].grad/a[1].total)).forEach(([name,d])=>{
    const rate=d.total?(d.grad/d.total*100):0;
    const short=name.replace('Ingeniería en ','').replace('Ingeniería ','Ing. ').replace('Administración de Empresas Agropecuarias','Admón. Agropec.').replace('Recursos Naturales y Ambiente','Rec. Naturales');
    const color=rate>=60?'var(--verde)':rate>=30?'var(--extra1)':'var(--extra2)';
    el.innerHTML+=`<div><div style="display:flex;justify-content:space-between;margin-bottom:3px"><span style="font-size:10px;color:var(--muted);font-family:'Montserrat',sans-serif;font-weight:600">${short}</span><span style="font-size:11px;font-weight:800;color:${color};font-family:'Montserrat',sans-serif">${rate.toFixed(1)}%</span></div><div style="height:10px;background:var(--s2);border-radius:5px;overflow:hidden"><div style="height:100%;width:${rate.toFixed(0)}%;background:${color};border-radius:5px;transition:.4s"></div></div></div>`;
  });
}

function update(){
  const{cData,cohData}=getFiltered();
  const a=aggregate(cData);
  renderKPIs(a);renderBars(cData);renderDonut(a);renderFunnel(a);
  renderCohortTable(cohData);renderHistogram(cData);renderAvgChart(cData);renderRateChart(cData);
}

update();
</script>
</body>
</html>