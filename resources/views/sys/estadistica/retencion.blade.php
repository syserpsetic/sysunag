<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Retención Estudiantil — UNAG</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="shortcut icon" href="{{ asset('/favicon.png') }}">
<style>
/* ══════════════════════════════════════════════════════
   TOKENS OFICIALES — MANUAL DE IMAGEN CORPORATIVA UNAG
   Primarios: Verde #1BA333 · Amarillo #FFCC00 · Azul #203B76
   Secundarios: Verde oscuro #135423 · Café #5B3700 · Celeste #0094E9
══════════════════════════════════════════════════════ */
:root {
  --verde:     #1BA333;
  --verde-dk:  #135423;
  --amarillo:  #FFCC00;
  --azul:      #203B76;
  --celeste:   #0094E9;
  --cafe:      #5B3700;
  /* Semáforo retención */
  --int:       #1BA333;   /* internado → verde */
  --ext:       #d4870a;   /* externado → ámbar */
  --grad:      #0094E9;   /* graduados → celeste */
  --drop:      #c03030;   /* desertores → rojo */
  /* Superficies */
  --bg:        #f4f7f4;
  --white:     #ffffff;
  --s2:        #eef4ee;
  --border:    #d0e4d0;
  --border-dk: #aacaaa;
  --text:      #1a2b1a;
  --text-dim:  #3d5c3d;
  --muted:     #6b8a6b;
  --shadow-sm: 0 2px 8px rgba(32,59,118,0.08);
  --shadow-md: 0 4px 20px rgba(32,59,118,0.13);
}
* { box-sizing:border-box; margin:0; padding:0; }
body { background:var(--bg); color:var(--text); font-family:'Open Sans',sans-serif; min-height:100vh; }

/* ── HEADER ─────────────────────────────────────────── */
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
.hactions { display:flex; gap:8px; align-items:center; margin-left:auto; flex-wrap:wrap; }
.btn-dl { display:inline-flex; align-items:center; gap:6px; background:var(--verde); color:#fff; border:none; padding:7px 14px; border-radius:6px; font-size:11px; font-weight:700; font-family:'Montserrat',sans-serif; text-decoration:none; white-space:nowrap; transition:.2s; letter-spacing:.02em; }
.btn-dl:hover { background:var(--verde-dk); box-shadow:var(--shadow-md); }
.btn-dl.am { background:var(--amarillo); color:var(--azul); }
.btn-dl.am:hover { background:#e6b800; }
.btn-dl svg { width:13px; height:13px; }

/* ── ONDA SUPERIOR ──────────────────────────────────── */
.wave-top { width:100%; height:80px; overflow:hidden; background:var(--white); flex-shrink:0; position:relative; }
.wave-top svg { position:absolute; inset:0; width:100%; height:100%; }
.deco-dot { position:absolute; width:50px; height:50px; border-radius:50%; background:var(--amarillo); top:10px; right:52px; }

/* ── FILTERS ────────────────────────────────────────── */
.filters-bar { background:var(--white); border-bottom:1px solid var(--border); padding:12px 32px; display:flex; gap:14px; align-items:center; flex-wrap:wrap; box-shadow:var(--shadow-sm); }
.filter-label { font-family:'Montserrat',sans-serif; font-size:9px; color:var(--azul); text-transform:uppercase; letter-spacing:.14em; font-weight:700; }
select { background:var(--s2); color:var(--text); border:1.5px solid var(--border-dk); border-radius:7px; padding:6px 28px 6px 10px; font-family:'Montserrat',sans-serif; font-size:12px; font-weight:600; cursor:pointer; outline:none; transition:.2s; appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%23203B76'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 10px center; }
select:hover, select:focus { border-color:var(--verde); }
.fgroup { display:flex; align-items:center; gap:8px; }
.clear-btn { background:rgba(192,48,48,.08); border:1px solid rgba(192,48,48,.25); color:var(--drop); border-radius:20px; padding:4px 12px; font-size:9px; font-weight:700; font-family:'Montserrat',sans-serif; letter-spacing:.08em; cursor:pointer; transition:.2s; display:none; text-transform:uppercase; }
.clear-btn:hover { background:rgba(192,48,48,.15); }

/* Badges inline en filtros */
.fstat { display:flex; align-items:center; gap:6px; background:var(--s2); border:1px solid var(--border); border-radius:6px; padding:5px 12px; font-size:11px; color:var(--muted); font-family:'Montserrat',sans-serif; font-weight:600; }
.fstat strong { color:var(--azul); font-size:13px; font-weight:800; }
.dot { width:8px; height:8px; border-radius:50%; flex-shrink:0; }
.d-int { background:var(--int); }
.d-ext { background:var(--ext); }

/* ── CONTAINER ──────────────────────────────────────── */
.container { max-width:1440px; margin:0 auto; padding:24px 32px 0; }

/* Page header */
.page-header { margin-bottom:20px; animation:fadeUp .4s ease both; }
.plabel { display:inline-flex; align-items:center; background:var(--verde); color:#fff; padding:4px 14px; border-radius:4px; font-family:'Montserrat',sans-serif; font-size:9px; letter-spacing:.2em; text-transform:uppercase; font-weight:700; margin-bottom:10px; }
.ptitle { font-family:'Montserrat',sans-serif; font-size:clamp(22px,3.5vw,38px); font-weight:900; color:var(--azul); line-height:1.05; letter-spacing:-.02em; margin-bottom:6px; }
.ptitle span { color:var(--verde); }
.psubtitle { font-size:13px; color:var(--muted); line-height:1.5; }

/* ── SECTION HEADING ────────────────────────────────── */
.sh { display:flex; align-items:center; gap:10px; margin:24px 0 14px; }
.sh-bar { width:4px; height:20px; background:var(--verde); border-radius:2px; flex-shrink:0; }
.sh-txt { font-family:'Montserrat',sans-serif; font-size:10px; letter-spacing:.18em; text-transform:uppercase; color:var(--azul); font-weight:800; }
.sh-line { flex:1; height:1px; background:var(--border); }

/* ── MAIN GRID ──────────────────────────────────────── */
main { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; padding-bottom:24px; }

/* ── CARDS ──────────────────────────────────────────── */
.card { background:var(--white); border:1px solid var(--border); border-top:3px solid var(--verde); border-radius:10px; padding:20px; box-shadow:var(--shadow-sm); transition:.2s; animation:fadeUp .45s ease both; }
.card:hover { box-shadow:var(--shadow-md); }
.card.az  { border-top-color:var(--azul); }
.card.am  { border-top-color:var(--amarillo); }
.card.rd  { border-top-color:var(--drop); }
.card.ce  { border-top-color:var(--celeste); }
.card.gr  { border-top-color:var(--border-dk); }

.card-title { font-family:'Montserrat',sans-serif; font-size:9px; color:var(--muted); text-transform:uppercase; letter-spacing:.14em; font-weight:700; margin-bottom:8px; }
.card-value { font-family:'Montserrat',sans-serif; font-size:28px; font-weight:900; color:var(--azul); line-height:1; }
.card-sub { font-size:11px; color:var(--muted); margin-top:5px; }

.kpi-green .card-value { color:var(--int); }
.kpi-blue  .card-value { color:var(--celeste); }
.kpi-red   .card-value { color:var(--drop); }
.kpi-amber .card-value { color:var(--cafe); }

/* Span helpers */
.span2 { grid-column:span 2; }
.span3 { grid-column:span 3; }
.span4 { grid-column:span 4; }

/* ── RETENTION BARS ─────────────────────────────────── */
.ret-wrap { display:flex; flex-direction:column; gap:12px; margin-top:14px; }
.ret-row  { display:flex; align-items:center; gap:12px; }
.ret-lbl  { font-family:'Montserrat',sans-serif; font-size:11px; font-weight:700; color:var(--text-dim); width:84px; flex-shrink:0; }
.ret-track { flex:1; background:var(--s2); border-radius:5px; height:28px; overflow:hidden; border:1px solid var(--border); }
.ret-fill { height:100%; display:flex; align-items:center; padding:0 12px; font-size:11px; font-weight:700; font-family:'Montserrat',sans-serif; border-radius:5px; transition:width .8s cubic-bezier(.4,0,.2,1); white-space:nowrap; }
.rf-int { background:rgba(27,163,51,0.18); border:1px solid rgba(27,163,51,0.4); color:var(--verde-dk); }
.rf-ext { background:rgba(212,135,10,0.18); border:1px solid rgba(212,135,10,0.4); color:var(--cafe); }
.ret-note { margin-top:12px; font-size:11px; color:var(--muted); font-family:'Open Sans',sans-serif; }

/* ── FUNNEL ─────────────────────────────────────────── */
.funnel-rows { margin-top:12px; display:flex; flex-direction:column; gap:8px; }
.funnel-item { display:flex; align-items:center; justify-content:space-between; gap:8px; }
.funnel-name { font-size:10px; color:var(--muted); width:76px; flex-shrink:0; text-align:right; font-family:'Montserrat',sans-serif; font-weight:600; }
.funnel-bar-bg { flex:1; background:var(--s2); border-radius:4px; height:20px; overflow:hidden; border:1px solid var(--border); }
.funnel-bar-fill { height:100%; border-radius:4px; transition:width .8s cubic-bezier(.4,0,.2,1); display:flex; align-items:center; padding-left:8px; font-size:10px; font-weight:700; font-family:'Montserrat',sans-serif; }
.funnel-pct { font-size:11px; font-weight:800; font-family:'Montserrat',sans-serif; width:36px; text-align:right; flex-shrink:0; }

/* ── TABLE ──────────────────────────────────────────── */
.data-table { width:100%; border-collapse:collapse; font-size:12px; margin-top:12px; }
.data-table th { text-align:left; font-family:'Montserrat',sans-serif; font-size:9px; text-transform:uppercase; letter-spacing:.12em; color:var(--azul); font-weight:700; border-bottom:2px solid var(--verde); padding:10px 12px; cursor:pointer; user-select:none; background:var(--s2); }
.data-table th:hover { color:var(--verde); }
.data-table td { padding:9px 12px; border-bottom:1px solid var(--border); color:var(--text-dim); font-family:'Open Sans',sans-serif; }
.data-table tr:last-child td { border-bottom:none; }
.data-table tr:hover td { background:#f7fdf7; }

.pill { display:inline-block; padding:2px 9px; border-radius:20px; font-size:10px; font-weight:700; font-family:'Montserrat',sans-serif; }
.pill-int { background:rgba(27,163,51,.12); color:var(--verde-dk); border:1px solid rgba(27,163,51,.25); }
.pill-ext { background:rgba(212,135,10,.12); color:#a06b00; border:1px solid rgba(212,135,10,.25); }

.bar-cell { display:flex; align-items:center; gap:8px; }
.mini-bar { flex:1; height:8px; background:var(--s2); border-radius:3px; overflow:hidden; max-width:80px; border:1px solid var(--border); }
.mini-fill { height:100%; border-radius:3px; }

/* ── WAVE FOOTER ────────────────────────────────────── */
.wfooter { margin-top:48px; }
.wfooter svg { display:block; width:100%; }
.footer-bar { background:var(--verde); padding:18px 32px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; }
.fn { font-family:'Montserrat',sans-serif; font-weight:800; font-size:13px; color:#fff; }
.fs { font-size:11px; color:rgba(255,255,255,.75); margin-top:2px; }
.footer-bar img { height:50px; filter:brightness(0) invert(1); opacity:.9; }

@keyframes fadeUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
.card:nth-child(1){animation-delay:.05s}.card:nth-child(2){animation-delay:.10s}
.card:nth-child(3){animation-delay:.15s}.card:nth-child(4){animation-delay:.20s}

@media(max-width:900px){
  main{grid-template-columns:repeat(2,1fr); padding:0 16px 24px;}
  .span4,.span3{grid-column:span 2;}
  header{padding:0 16px;} .hactions .btn-dl:last-child{display:none;}
  .filters-bar{padding:12px 16px;}
   .htitle { display:none; }   /* Mostrado en title-block ya */
}
</style>
</head>
<body>

<!-- HEADER -->
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
      <div class="hmain">Retención Estudiantil — Internado vs Externado</div>
    </div>
    <div class="">
      <a class="btn-dl am" href="https://drive.google.com/file/d/1OwE0PhI7elSmGg4An5gLfieRWj2OXWaN/view?usp=sharing" target="_blank" rel="noopener">
        <svg viewBox="0 0 16 16" fill="currentColor"><path d="M8 12l-4-4h2.5V4h3v4H12L8 12z"/><rect x="2" y="13" width="12" height="1.5" rx=".75"/></svg>Muestra Excel
      </a>
      <a class="btn-dl" href="https://drive.google.com/file/d/1_T3aF9UMMueamFTu8hfX-2wLGiqKpwfm/view?usp=sharing" target="_blank" rel="noopener">
        <svg viewBox="0 0 16 16" fill="currentColor"><path d="M8 12l-4-4h2.5V4h3v4H12L8 12z"/><rect x="2" y="13" width="12" height="1.5" rx=".75"/></svg>Informe PDF
      </a>
    </div>
  </div>
</header>

<!-- Onda decorativa -->
<div class="wave-top">
  <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
    <path d="M0,25 C200,65 450,5 720,38 C990,70 1250,10 1440,32 L1440,80 L0,80 Z" fill="#203B76" opacity="0.10"/>
    <path d="M0,48 C320,18 640,65 960,40 C1150,25 1320,54 1440,42 L1440,80 L0,80 Z" fill="#1BA333" opacity="0.13"/>
    <path d="M0,60 C450,44 850,70 1440,52" stroke="#1BA333" stroke-width="1.5" fill="none" opacity="0.4"/>
  </svg>
  <div class="deco-dot"></div>
</div>

<!-- FILTERS BAR -->
<div class="filters-bar">
  <span class="filter-label">Filtros</span>
  <div class="fgroup">
    <label class="filter-label">Año ingreso</label>
    <select id="flt-year"><option value="all">Todos los años</option></select>
  </div>
  <div class="fgroup">
    <label class="filter-label">Carrera</label>
    <select id="flt-career"><option value="all">Todas las carreras</option></select>
  </div>
  <div class="fgroup">
    <label class="filter-label">Ubicación</label>
    <select id="flt-ubi">
      <option value="all">Todas</option>
      <option value="internado">Internado</option>
      <option value="externado">Externado</option>
    </select>
  </div>
  <span id="clear-btn" class="clear-btn" onclick="clearFilters()">✕ Limpiar filtros</span>
  <div style="margin-left:auto;display:flex;gap:8px;flex-wrap:wrap;">
    <div class="fstat"><span class="dot d-int"></span>Internado <strong id="hdr-int">—</strong></div>
    <div class="fstat"><span class="dot d-ext"></span>Externado <strong id="hdr-ext">—</strong></div>
    <div class="fstat">Total: <strong id="hdr-total">—</strong></div>
  </div>
</div>

<div class="container">
  <div class="page-header">
    <div class="plabel">Análisis por Ubicación · Cohortes 2019 – 2026</div>
    <h1 class="ptitle">Dashboard — <span>Retención</span> Estudiantil</h1>
    <p class="psubtitle">Comparación de permanencia, graduación y deserción entre estudiantes de internado y externado</p>
    <p class="psubtitle">Nota: Este análisis está hecho en base a una muestra de 5,301 registros de estudiantes </p>
  </div>
</div>

<div class="container" style="padding-top:0">
<main>

  <!-- ── KPIs ────────────────────────────────── -->
  <div class="card gr">
    <div class="card-title">Estudiantes</div>
    <div class="card-value" id="kv-total">—</div>
    <div class="card-sub" id="ks-total">en dataset filtrado</div>
  </div>
  <div class="card kpi-green">
    <div class="card-title">Activos </div>
    <div class="card-value" id="kv-active">—</div>
    <div class="card-sub" id="ks-active">tienen matrícula 2026 p1</div>
  </div>
  <div class="card ce">
    <div class="card-title">Graduados</div>
    <div class="card-value kpi-blue" id="kv-grad">—</div>
    <div class="card-sub" id="ks-grad">completaron carrera</div>
  </div>
  <div class="card rd">
    <div class="card-title">Desertores </div>
    <div class="card-value kpi-red" id="kv-drop">—</div>
    <div class="card-sub" id="ks-drop">sin matrícula 2026 p1, no graduados</div>
  </div>

  <!-- ── Section 1 ──────────────────────────── -->
  <div class="span4 sh"><div class="sh-bar"></div><div class="sh-txt">Análisis de Retención</div><div class="sh-line"></div></div>

  <!-- Retention compare -->
  <div class="card span2">
    <div class="card-title">Tasa de Retención: Internado vs Externado</div>
    <div class="ret-wrap">
      <div class="ret-row">
        <div class="ret-lbl">🏠 Internado</div>
        <div class="ret-track"><div class="ret-fill rf-int" id="rbar-int" style="width:0%">—</div></div>
      </div>
      <div class="ret-row">
        <div class="ret-lbl">🏙 Externado</div>
        <div class="ret-track"><div class="ret-fill rf-ext" id="rbar-ext" style="width:0%">—</div></div>
      </div>
    </div>
    <div class="ret-note" id="ret-note">Retención = (Activos + Graduados) / Total</div>
  </div>

  <!-- Donut -->
  <div class="card span2">
    <div class="card-title">Distribución por Estado Académico</div>
    <canvas id="chart-donut"></canvas>
  </div>

  <!-- Year bar -->
  <div class="card span4">
    <div class="card-title">Retención por Año de Ingreso — Internado vs Externado (%)</div>
    <canvas id="chart-year" style="max-height:260px"></canvas>
  </div>

  <!-- ── Section 2 ──────────────────────────── -->
  <div class="span4 sh"><div class="sh-bar"></div><div class="sh-txt">Por Carrera</div><div class="sh-line"></div></div>

  <div class="card span3">
    <div class="card-title">Distribución Internado / Externado por Carrera</div>
    <canvas id="chart-career-bar" style="max-height:240px"></canvas>
  </div>

  <div class="card">
    <div class="card-title">Retención por Carrera</div>
    <div class="funnel-rows" id="funnel-rows"></div>
  </div>

  <!-- ── Table ──────────────────────────────── -->
  <div class="span4 sh"><div class="sh-bar"></div><div class="sh-txt">Tabla Detallada</div><div class="sh-line"></div></div>
  <div class="card span4" style="padding-bottom:0">
    <div class="card-title" style="margin-bottom:0">Resumen por Carrera y Ubicación</div>
    <div style="overflow-x:auto">
      <table class="data-table" id="detail-table">
        <thead><tr>
          <th>Carrera</th><th>Ubicación</th><th>Total</th>
          <th>Activos</th><th>Graduados</th><th>Desertores</th>
          <th>% Retención</th><th>% Deserción</th>
        </tr></thead>
        <tbody id="table-body"></tbody>
      </table>
    </div>
  </div>

</main>
</div>

<!-- WAVE FOOTER -->
<div class="wfooter">
  <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:block;background:var(--bg)">
    <path d="M0,18 C320,52 660,4 980,36 C1160,54 1320,14 1440,28 L1440,60 L0,60 Z" fill="#1BA333"/>
    <path d="M0,34 C420,14 760,52 1100,30 C1270,18 1380,42 1440,48 L1440,60 L0,60 Z" fill="#135423" opacity="0.45"/>
    <path d="M0,50 C440,38 860,58 1440,44" stroke="white" stroke-width="1.5" fill="none" opacity="0.35"/>
  </svg>
  <div class="footer-bar">
    <div>
      <div class="fn">Universidad Nacional de Agricultura — UNAG</div>
      <div class="fs">Secretaría de Tecnología de la Información y Comunicaciones (SETIC) · Dashboard Analítico · Retención Estudiantil · 2025</div>
    </div>
    <img src="https://setic.unag.edu.hn/img/logo-setic-blanco.png" alt="SETIC UNAG">
  </div>
</div>

<script>
/* ── Chart.js defaults ────────────────────────────────── */
Chart.defaults.color = '#6b8a6b';
Chart.defaults.borderColor = 'rgba(27,163,51,0.08)';
Chart.defaults.font.family = "'Montserrat', sans-serif";

const TT = {
  backgroundColor:'#fff', borderWidth:1,
  titleColor:'#203B76', bodyColor:'#3d5c3d',
  titleFont:{family:"'Montserrat'",size:12,weight:'800'},
  bodyFont:{family:"'Montserrat'",size:10,weight:'600'},
  padding:10, cornerRadius:6
};

/* ── FULL STATS ────────────────────────────────────────── */
const FULL_STATS = {
  byUbi: {
    internado:{total:4545,graduated:233,active:3105,dropout:1207},
    externado:{total:756,graduated:29,active:431,dropout:296}
  },
  byYear: {
    "2019":{internado:{total:3,graduated:1,active:1,dropout:1},externado:{total:3,graduated:0,active:2,dropout:1}},
    "2021":{internado:{total:565,graduated:202,active:110,dropout:253},externado:{total:79,graduated:22,active:15,dropout:42}},
    "2022":{internado:{total:659,graduated:30,active:422,dropout:207},externado:{total:63,graduated:7,active:30,dropout:26}},
    "2023":{internado:{total:732,graduated:0,active:425,dropout:307},externado:{total:154,graduated:0,active:80,dropout:74}},
    "2024":{internado:{total:922,graduated:0,active:632,dropout:290},externado:{total:147,graduated:0,active:65,dropout:82}},
    "2025":{internado:{total:770,graduated:0,active:631,dropout:139},externado:{total:151,graduated:0,active:95,dropout:56}},
    "2026":{internado:{total:894,graduated:0,active:884,dropout:10},externado:{total:159,graduated:0,active:144,dropout:15}}
  },
  byCareer: {
    "Administración de Empresas Agropecuarias":{externado:{total:479,graduated:26,active:236,dropout:217},internado:{total:5,graduated:0,active:4,dropout:1}},
    "Ingeniería Agronómica":{internado:{total:2282,graduated:110,active:1618,dropout:554},externado:{total:42,graduated:0,active:42,dropout:0}},
    "Medicina Veterinaria":{internado:{total:471,graduated:0,active:318,dropout:153},externado:{total:9,graduated:0,active:9,dropout:0}},
    "Ingeniería en Gestión Integral de los Recursos Naturales":{internado:{total:499,graduated:17,active:295,dropout:187},externado:{total:8,graduated:0,active:8,dropout:0}},
    "Ingeniería en Zootecnia":{internado:{total:580,graduated:63,active:401,dropout:116},externado:{total:21,graduated:0,active:20,dropout:1}},
    "Ingeniería en Tecnología Alimentaria":{internado:{total:553,graduated:43,active:379,dropout:131},externado:{total:3,graduated:0,active:3,dropout:0}},
    "Economía Social Agraria":{externado:{total:194,graduated:3,active:113,dropout:78}},
    "Ingeniería en Agroexportación":{internado:{total:155,graduated:0,active:90,dropout:65}}
  }
};

let activeYear='all', activeCareer='all', activeUbi='all';

function initFilters(){
  const ys=document.getElementById('flt-year');
  Object.keys(FULL_STATS.byYear).sort().forEach(y=>{const o=document.createElement('option');o.value=y;o.textContent=y;ys.appendChild(o);});
  const cs=document.getElementById('flt-career');
  Object.keys(FULL_STATS.byCareer).sort().forEach(c=>{const o=document.createElement('option');o.value=c;o.textContent=c;cs.appendChild(o);});
  ys.addEventListener('change',()=>{activeYear=ys.value;updateAll();});
  cs.addEventListener('change',()=>{activeCareer=cs.value;updateAll();});
  document.getElementById('flt-ubi').addEventListener('change',e=>{activeUbi=e.target.value;updateAll();});
}

function clearFilters(){
  activeYear='all';activeCareer='all';activeUbi='all';
  document.getElementById('flt-year').value='all';
  document.getElementById('flt-career').value='all';
  document.getElementById('flt-ubi').value='all';
  updateAll();
}

function computeFiltered(){
  let result={int:{total:0,graduated:0,active:0,dropout:0},ext:{total:0,graduated:0,active:0,dropout:0}};
  const yearsToUse=activeYear==='all'?Object.keys(FULL_STATS.byYear):[activeYear];
  const careersToUse=activeCareer==='all'?Object.keys(FULL_STATS.byCareer):[activeCareer];
  let yearData={};
  yearsToUse.forEach(y=>{
    const yd=FULL_STATS.byYear[y];if(!yd)return;yearData[y]={};
    ['internado','externado'].forEach(u=>{
      if(!yd[u])return;if(activeUbi!=='all'&&u!==activeUbi)return;
      if(activeCareer!=='all'){const cd=FULL_STATS.byCareer[activeCareer];if(!cd||!cd[u]){yearData[y][u]={total:0,graduated:0,active:0,dropout:0};return;}yearData[y][u]=cd[u];}
      else{yearData[y][u]=yd[u];}
    });
  });
  let careerData={};
  careersToUse.forEach(c=>{
    const cd=FULL_STATS.byCareer[c];if(!cd)return;careerData[c]={};
    ['internado','externado'].forEach(u=>{if(!cd[u])return;if(activeUbi!=='all'&&u!==activeUbi)return;careerData[c][u]=cd[u];});
  });
  careersToUse.forEach(c=>{
    const cd=FULL_STATS.byCareer[c];if(!cd)return;
    ['internado','externado'].forEach(u=>{
      if(!cd[u])return;if(activeUbi!=='all'&&u!==activeUbi)return;
      const tgt=u==='internado'?result.int:result.ext;
      Object.keys(tgt).forEach(k=>tgt[k]+=cd[u][k]||0);
    });
  });
  if(activeYear!=='all'){
    result.int={total:0,graduated:0,active:0,dropout:0};result.ext={total:0,graduated:0,active:0,dropout:0};
    const yd=FULL_STATS.byYear[activeYear];
    if(yd){
      if((activeUbi==='all'||activeUbi==='internado')&&yd.internado)Object.keys(result.int).forEach(k=>result.int[k]+=yd.internado[k]||0);
      if((activeUbi==='all'||activeUbi==='externado')&&yd.externado)Object.keys(result.ext).forEach(k=>result.ext[k]+=yd.externado[k]||0);
    }
  }
  return{totals:result,yearData,careerData};
}

let charts={};
const pct=(n,d)=>d===0?0:Math.round((n/d)*100);
const fmt=n=>n.toLocaleString('es');

function semColor(v,inv=false){
  if(inv) return v<=20?'var(--int)':v<=40?'var(--ext)':'var(--drop)';
  return v>=80?'var(--int)':v>=60?'var(--ext)':'var(--drop)';
}

function updateAll(){
  const hasFilter=activeYear!=='all'||activeCareer!=='all'||activeUbi!=='all';
  document.getElementById('clear-btn').style.display=hasFilter?'inline-block':'none';
  const{totals,yearData,careerData}=computeFiltered();
  const{int,ext}=totals;
  const ts=int.total+ext.total, ta=int.active+ext.active, tg=int.graduated+ext.graduated, td=int.dropout+ext.dropout;

  document.getElementById('hdr-int').textContent=fmt(int.total);
  document.getElementById('hdr-ext').textContent=fmt(ext.total);
  document.getElementById('hdr-total').textContent=fmt(ts);

  document.getElementById('kv-total').textContent=fmt(ts);
  document.getElementById('ks-total').textContent='en dataset filtrado';
  document.getElementById('kv-active').textContent=fmt(ta)+' ('+pct(ta,ts)+'%)';
  document.getElementById('ks-active').textContent='tienen matrícula 2026 p1';
  document.getElementById('kv-grad').textContent=fmt(tg)+' ('+pct(tg,ts)+'%)';
  document.getElementById('ks-grad').textContent='completaron carrera';
  document.getElementById('kv-drop').textContent=fmt(td)+' ('+pct(td,ts)+'%)';
  document.getElementById('ks-drop').textContent='sin matrícula 2026 p1, no graduados';

  const ri=pct(int.active+int.graduated,int.total), re=pct(ext.active+ext.graduated,ext.total);
  document.getElementById('rbar-int').style.width=ri+'%';
  document.getElementById('rbar-int').textContent='Internado: '+ri+'% ('+fmt(int.active+int.graduated)+'/'+fmt(int.total)+')';
  document.getElementById('rbar-ext').style.width=re+'%';
  document.getElementById('rbar-ext').textContent='Externado: '+re+'% ('+fmt(ext.active+ext.graduated)+'/'+fmt(ext.total)+')';
  const diff=ri-re;
  document.getElementById('ret-note').innerHTML=`Retención = (Activos + Graduados) / Total &nbsp;·&nbsp; <strong style="color:${diff>0?'var(--int)':'var(--drop)'}">${diff>0?'Internado +'+diff+' pp':'Externado +'+(Math.abs(diff))+' pp'} ventaja</strong>`;

  updateDonut(int,ext);
  updateYearBar(yearData);
  updateCareerBar(careerData);
  updateFunnel(careerData);
  updateTable(careerData);
}

/* ── DONUT ──────────────────────────────────────────────── */
function updateDonut(int,ext){
  if(charts.donut)charts.donut.destroy();
  const isAll=activeUbi==='all';
  const data=isAll?[int.active,int.graduated,int.dropout,ext.active,ext.graduated,ext.dropout]
    :activeUbi==='internado'?[int.active,int.graduated,int.dropout]:[ext.active,ext.graduated,ext.dropout];
  const labels=isAll?['Activos Internado','Graduados Internado','Desertores Internado','Activos Externado','Graduados Externado','Desertores Externado']
    :['Activos','Graduados','Desertores'];
  const colors=isAll?['rgba(27,163,51,0.8)','rgba(0,148,233,0.8)','rgba(192,48,48,0.6)','rgba(212,135,10,0.8)','rgba(91,55,0,0.7)','rgba(192,48,48,0.35)']
    :['rgba(27,163,51,0.85)','rgba(0,148,233,0.85)','rgba(192,48,48,0.8)'];
  charts.donut=new Chart(document.getElementById('chart-donut'),{
    type:'doughnut',
    data:{labels,datasets:[{data,backgroundColor:colors,borderWidth:2,borderColor:'#fff'}]},
    options:{responsive:true,maintainAspectRatio:true,cutout:'62%',
      plugins:{
        legend:{position:'right',labels:{color:'#3d5c3d',font:{size:10,weight:'600'},boxWidth:12,padding:10}},
        tooltip:{...TT,borderColor:'var(--verde)',callbacks:{label:ctx=>` ${ctx.label}: ${fmt(ctx.raw)} (${pct(ctx.raw,data.reduce((a,b)=>a+b,0))}%)`}}
      }
    }
  });
}

/* ── YEAR BAR ───────────────────────────────────────────── */
function updateYearBar(yearData){
  if(charts.year)charts.year.destroy();
  const years=Object.keys(yearData).sort();
  const iR=[],eR=[];
  years.forEach(y=>{
    const yd=yearData[y];
    const i=yd.internado||{total:0,graduated:0,active:0,dropout:0};
    const e=yd.externado||{total:0,graduated:0,active:0,dropout:0};
    iR.push(pct(i.active+i.graduated,i.total));
    eR.push(pct(e.active+e.graduated,e.total));
  });
  const ds=[];
  if(activeUbi!=='externado')ds.push({label:'Retención Internado',data:iR,backgroundColor:'rgba(27,163,51,0.75)',borderColor:'#1BA333',borderWidth:1,borderRadius:5});
  if(activeUbi!=='internado')ds.push({label:'Retención Externado',data:eR,backgroundColor:'rgba(212,135,10,0.75)',borderColor:'#d4870a',borderWidth:1,borderRadius:5});
  charts.year=new Chart(document.getElementById('chart-year'),{
    type:'bar',data:{labels:years,datasets:ds},
    options:{responsive:true,maintainAspectRatio:true,
      scales:{
        x:{ticks:{color:'#6b8a6b',font:{size:10,weight:'600'}},grid:{color:'rgba(27,163,51,0.06)'}},
        y:{ticks:{color:'#6b8a6b',font:{size:10,weight:'600'},callback:v=>v+'%'},grid:{color:'rgba(27,163,51,0.08)'},max:100}
      },
      plugins:{
        legend:{labels:{color:'#3d5c3d',font:{size:10,weight:'600'},boxWidth:12}},
        tooltip:{...TT,borderColor:'var(--verde)',callbacks:{label:ctx=>` ${ctx.dataset.label}: ${ctx.raw}%`}}
      }
    }
  });
}

/* ── CAREER BAR ─────────────────────────────────────────── */
const shortC=name=>({
  'Administración de Empresas Agropecuarias':'Admin. Emp. Agrop.',
  'Ingeniería Agronómica':'Ing. Agronómica',
  'Medicina Veterinaria':'Med. Veterinaria',
  'Ingeniería en Gestión Integral de los Recursos Naturales':'Ing. Gestión IRNR',
  'Ingeniería en Zootecnia':'Ing. Zootecnia',
  'Ingeniería en Tecnología Alimentaria':'Ing. Tec. Aliment.',
  'Economía Social Agraria':'Econ. Social Agraria',
  'Ingeniería en Agroexportación':'Ing. Agroexport.',
}[name]||name);

function updateCareerBar(careerData){
  if(charts.careerBar)charts.careerBar.destroy();
  const cs=Object.keys(careerData).sort();
  const iT=[],eT=[];
  cs.forEach(c=>{const i=careerData[c].internado||{total:0};const e=careerData[c].externado||{total:0};iT.push(i.total);eT.push(e.total);});
  const ds=[];
  if(activeUbi!=='externado')ds.push({label:'Internado',data:iT,backgroundColor:'rgba(27,163,51,0.75)',borderColor:'#1BA333',borderWidth:1,borderRadius:4});
  if(activeUbi!=='internado')ds.push({label:'Externado',data:eT,backgroundColor:'rgba(212,135,10,0.75)',borderColor:'#d4870a',borderWidth:1,borderRadius:4});
  charts.careerBar=new Chart(document.getElementById('chart-career-bar'),{
    type:'bar',data:{labels:cs.map(shortC),datasets:ds},
    options:{indexAxis:'y',responsive:true,maintainAspectRatio:true,
      scales:{
        x:{ticks:{color:'#6b8a6b',font:{size:10,weight:'600'}},grid:{color:'rgba(27,163,51,0.06)'}},
        y:{ticks:{color:'#3d5c3d',font:{size:10,weight:'600'}},grid:{display:false}}
      },
      plugins:{
        legend:{labels:{color:'#3d5c3d',font:{size:10,weight:'600'},boxWidth:12}},
        tooltip:{...TT,borderColor:'var(--verde)',callbacks:{label:ctx=>` ${ctx.dataset.label}: ${fmt(ctx.raw)} estudiantes`}}
      }
    }
  });
}

/* ── FUNNEL ─────────────────────────────────────────────── */
function updateFunnel(careerData){
  const container=document.getElementById('funnel-rows');
  const cs=Object.keys(careerData);
  const ret=cs.map(c=>{
    const i=careerData[c].internado||{total:0,graduated:0,active:0,dropout:0};
    const e=careerData[c].externado||{total:0,graduated:0,active:0,dropout:0};
    const tot=i.total+e.total, r=i.active+i.graduated+e.active+e.graduated;
    return{name:shortC(c),pct:pct(r,tot),tot};
  }).filter(x=>x.tot>0).sort((a,b)=>b.pct-a.pct);
  container.innerHTML=ret.map(r=>{
    const col=r.pct>=80?'var(--int)':r.pct>=60?'var(--ext)':'var(--drop)';
    return `<div class="funnel-item">
      <div class="funnel-name">${r.name}</div>
      <div class="funnel-bar-bg"><div class="funnel-bar-fill" style="width:${r.pct}%;background:${col}20;border-right:2px solid ${col}"></div></div>
      <div class="funnel-pct" style="color:${col}">${r.pct}%</div>
    </div>`;
  }).join('');
}

/* ── TABLE ──────────────────────────────────────────────── */
function updateTable(careerData){
  const tbody=document.getElementById('table-body');
  const rows=[];
  Object.keys(careerData).sort().forEach(c=>{
    ['internado','externado'].forEach(u=>{
      const d=careerData[c][u];if(!d||d.total===0)return;
      const ret=pct(d.active+d.graduated,d.total),drop=pct(d.dropout,d.total);
      rows.push({career:c,ubi:u,total:d.total,active:d.active,graduated:d.graduated,dropout:d.dropout,ret,drop});
    });
  });
  rows.sort((a,b)=>b.ret-a.ret);
  tbody.innerHTML=rows.map(r=>{
    const retCol=semColor(r.ret), dropCol=semColor(r.drop,true);
    return `<tr>
      <td style="font-weight:600;color:var(--azul)">${r.career}</td>
      <td><span class="pill pill-${r.ubi}">${r.ubi}</span></td>
      <td style="font-family:'Montserrat',sans-serif;font-weight:700">${fmt(r.total)}</td>
      <td>${fmt(r.active)} <span style="color:var(--muted);font-size:10px">(${pct(r.active,r.total)}%)</span></td>
      <td>${fmt(r.graduated)} <span style="color:var(--muted);font-size:10px">(${pct(r.graduated,r.total)}%)</span></td>
      <td>${fmt(r.dropout)} <span style="color:var(--muted);font-size:10px">(${pct(r.dropout,r.total)}%)</span></td>
      <td><div class="bar-cell"><div class="mini-bar"><div class="mini-fill" style="width:${r.ret}%;background:${retCol}"></div></div><span style="color:${retCol};font-weight:800;font-family:'Montserrat',sans-serif">${r.ret}%</span></div></td>
      <td><div class="bar-cell"><div class="mini-bar"><div class="mini-fill" style="width:${r.drop}%;background:${dropCol}"></div></div><span style="color:${dropCol};font-weight:800;font-family:'Montserrat',sans-serif">${r.drop}%</span></div></td>
    </tr>`;
  }).join('');
}

initFilters();
updateAll();
</script>
</body>
</html>