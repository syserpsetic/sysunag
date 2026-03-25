<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Historial Académico — UNAG</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<link rel="shortcut icon" href="{{ asset('/favicon.png') }}">
<style>
/* ══════════════════════════════════════════════════════
   TOKENS — MANUAL DE IMAGEN CORPORATIVA UNAG
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
  /* Género */
  --fem:       #d4478a;   /* femenino — rosa institucional */
  --mas:       #0094E9;   /* masculino — celeste institucional */
  /* Notas */
  --nota-hi:   #1BA333;
  --nota-lo:   #c03030;
  --nota-med:  #d4870a;
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
  --gap:       16px;
  --pad-x:     clamp(12px,4vw,40px);
}
*, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
html { overflow-x:hidden; }
body { background:var(--bg); color:var(--text); font-family:'Open Sans',sans-serif; min-height:100vh; overflow-x:hidden; width:100%; }
img { max-width:100%; display:block; }
::-webkit-scrollbar { width:4px; height:4px; }
::-webkit-scrollbar-track { background:var(--s2); }
::-webkit-scrollbar-thumb { background:var(--border-dk); border-radius:2px; }

/* ── HEADER ─────────────────────────────────────────── */
header { background:var(--white); border-bottom:3px solid var(--verde); padding:0 var(--pad-x); display:flex; align-items:center; justify-content:space-between; gap:12px; min-height:64px; position:sticky; top:0; z-index:200; box-shadow:var(--shadow-md); flex-wrap:wrap; }
.header-left { display:flex; align-items:center; gap:12px; flex-shrink:0; }
.header-left img { width:44px; }
.hbrand { display:flex; flex-direction:column; gap:1px; }
.hbrand-name { font-family:'Montserrat',sans-serif; font-weight:800; font-size:14px; color:var(--azul); letter-spacing:-.01em; }
.hbrand-unit { font-family:'Montserrat',sans-serif; font-size:10px; color:var(--verde); letter-spacing:.12em; text-transform:uppercase; font-weight:700; }
.hsep { width:1px; height:34px; background:var(--border); flex-shrink:0; }
.htitle { flex:1; }
.heyebrow { font-family:'Montserrat',sans-serif; font-size:9px; letter-spacing:.2em; color:var(--verde); text-transform:uppercase; font-weight:700; margin-bottom:2px; }
.hmain { font-family:'Montserrat',sans-serif; font-size:clamp(13px,1.8vw,18px); font-weight:800; color:var(--azul); }
.header-right { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
.btn-dl { display:inline-flex; align-items:center; gap:6px; background:var(--verde); color:#fff; border:none; padding:7px 14px; border-radius:6px; font-size:11px; font-weight:700; font-family:'Montserrat',sans-serif; text-decoration:none; white-space:nowrap; transition:.2s; letter-spacing:.02em; }
.btn-dl:hover { background:var(--verde-dk); box-shadow:var(--shadow-md); }
.btn-dl.am { background:var(--amarillo); color:var(--azul); }
.btn-dl.am:hover { background:#e6b800; }
.btn-dl svg { width:13px; height:13px; }

/* ── ONDA SUPERIOR ──────────────────────────────────── */
.wave-top { width:100%; height:80px; overflow:hidden; background:var(--white); position:relative; }
.wave-top svg { position:absolute; inset:0; width:100%; height:100%; }
.deco-dot { position:absolute; width:50px; height:50px; border-radius:50%; background:var(--amarillo); top:10px; right:52px; }

/* ── FILTERS ────────────────────────────────────────── */
.filters { padding:12px var(--pad-x); background:var(--white); border-bottom:1px solid var(--border); display:flex; gap:10px; align-items:center; flex-wrap:wrap; box-shadow:var(--shadow-sm); }
.filter-label { font-family:'Montserrat',sans-serif; font-size:9px; color:var(--azul); text-transform:uppercase; letter-spacing:.14em; font-weight:700; white-space:nowrap; }
select { background:var(--s2); border:1.5px solid var(--border-dk); color:var(--text); padding:7px 28px 7px 12px; border-radius:8px; font-size:12px; font-family:'Montserrat',sans-serif; font-weight:600; appearance:none; cursor:pointer; min-width:140px; flex:1 1 140px; max-width:240px; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23203B76' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 10px center; transition:.2s; }
select:focus { outline:none; border-color:var(--verde); }
.btn-reset { padding:7px 14px; background:transparent; border:1.5px solid var(--border-dk); border-radius:8px; color:var(--muted); font-size:11px; cursor:pointer; font-family:'Montserrat',sans-serif; font-weight:700; white-space:nowrap; transition:.2s; }
.btn-reset:hover { border-color:var(--nota-lo); color:var(--nota-lo); }
.sex-pill { display:flex; align-items:center; gap:5px; padding:5px 12px; border-radius:100px; font-size:11px; font-weight:700; font-family:'Montserrat',sans-serif; border:1px solid; white-space:nowrap; }
.sex-pill.f { color:var(--fem); border-color:rgba(212,71,138,.3); background:rgba(212,71,138,.08); }
.sex-pill.m { color:var(--mas); border-color:rgba(0,148,233,.3); background:rgba(0,148,233,.08); }
.sex-dot { width:7px; height:7px; border-radius:50%; flex-shrink:0; }
.sex-dot.f { background:var(--fem); }
.sex-dot.m { background:var(--mas); }
.records-count { font-family:'Montserrat',sans-serif; font-size:11px; color:var(--muted); font-weight:600; white-space:nowrap; margin-left:auto; }
.records-count span { color:var(--verde); font-weight:800; }

/* ── CONTAINER ──────────────────────────────────────── */
.container { max-width:1440px; margin:0 auto; padding:20px var(--pad-x) 0; width:100%; }
.title-block { padding-bottom:4px; animation:fadeIn .4s ease both; }
.page-lbl { display:inline-flex; align-items:center; background:var(--verde); color:#fff; padding:4px 14px; border-radius:4px; font-family:'Montserrat',sans-serif; font-size:9px; letter-spacing:.2em; text-transform:uppercase; font-weight:700; margin-bottom:8px; }
.title-block h1 { font-family:'Montserrat',sans-serif; font-size:clamp(22px,3vw,36px); font-weight:900; letter-spacing:-.02em; color:var(--azul); }
.title-block h1 span { color:var(--verde); }
.title-block p { font-size:13px; color:var(--muted); margin-top:4px; }

/* ── MAIN LAYOUT ─────────────────────────────────────── */
.main { padding:20px var(--pad-x) 32px; display:flex; flex-direction:column; gap:var(--gap); width:100%; min-width:0; overflow-x:hidden; }

/* ── SECTION HEADING ────────────────────────────────── */
.sh { display:flex; align-items:center; gap:10px; margin:4px 0; }
.sh-bar { width:4px; height:20px; background:var(--verde); border-radius:2px; flex-shrink:0; }
.sh-txt { font-family:'Montserrat',sans-serif; font-size:10px; letter-spacing:.18em; text-transform:uppercase; color:var(--azul); font-weight:800; }
.sh-line { flex:1; height:1px; background:var(--border); }

/* ── KPI STRIP ──────────────────────────────────────── */
.kpi-strip { display:grid; grid-template-columns:repeat(6,1fr); gap:12px; }
.kpi-card { background:var(--white); border:1px solid var(--border); border-top:3px solid var(--verde); border-radius:10px; padding:16px 18px; position:relative; overflow:hidden; transition:.2s; box-shadow:var(--shadow-sm); animation:fadeIn .45s ease both; }
.kpi-card:hover { box-shadow:var(--shadow-md); transform:translateY(-2px); }
.kpi-card.az  { border-top-color:var(--azul); }
.kpi-card.am  { border-top-color:var(--amarillo); }
.kpi-card.vd  { border-top-color:var(--verde); }
.kpi-card.fem { border-top-color:var(--fem); }
.kpi-card.mas { border-top-color:var(--mas); }
.kpi-label { font-family:'Montserrat',sans-serif; font-size:9px; color:var(--muted); text-transform:uppercase; letter-spacing:.12em; font-weight:700; margin-bottom:6px; }
.kpi-value { font-family:'Montserrat',sans-serif; font-size:clamp(18px,2.5vw,26px); font-weight:900; line-height:1; }
.kpi-value.az  { color:var(--azul); }
.kpi-value.am  { color:var(--cafe); }
.kpi-value.vd  { color:var(--verde); }
.kpi-value.fem { color:var(--fem); }
.kpi-value.mas { color:var(--mas); }
.kpi-sub { font-size:10px; color:var(--muted); margin-top:5px; }
.kpi-card:nth-child(1){animation-delay:.04s}.kpi-card:nth-child(2){animation-delay:.08s}
.kpi-card:nth-child(3){animation-delay:.12s}.kpi-card:nth-child(4){animation-delay:.16s}
.kpi-card:nth-child(5){animation-delay:.20s}.kpi-card:nth-child(6){animation-delay:.24s}

/* ── GRID ROWS ──────────────────────────────────────── */
.row { display:grid; gap:var(--gap); width:100%; min-width:0; }
.row-2   { grid-template-columns:1fr 1fr; }
.row-3   { grid-template-columns:1fr 1fr 1fr; }
.row-1-2 { grid-template-columns:1fr 2fr; }
.row-2-1 { grid-template-columns:2fr 1fr; }

/* ── PANEL ──────────────────────────────────────────── */
.panel {
  background:var(--white); border:1px solid var(--border);
  border-top:3px solid var(--verde); border-radius:10px;
  padding:20px 22px; display:flex; flex-direction:column;
  gap:14px; box-shadow:var(--shadow-sm); transition:.2s;
  min-width:0;          /* evita que el panel expanda el grid */
  overflow:hidden;      /* contiene hijos que se desbordan */
}
.panel:hover { box-shadow:var(--shadow-md); }
.panel.az-top  { border-top-color:var(--azul); }
.panel.am-top  { border-top-color:var(--amarillo); }
.panel.fem-top { border-top-color:var(--fem); }
.panel-header { display:flex; align-items:flex-start; justify-content:space-between; gap:8px; flex-wrap:wrap; }
.panel-title { font-family:'Montserrat',sans-serif; font-weight:800; font-size:clamp(12px,1.5vw,14px); color:var(--azul); letter-spacing:-.01em; }
.panel-sub { font-size:11px; color:var(--muted); margin-top:3px; font-family:'Open Sans',sans-serif; }
.panel-badge { font-family:'Montserrat',sans-serif; font-size:9px; padding:3px 8px; border-radius:5px; flex-shrink:0; background:rgba(32,59,118,.10); color:var(--azul); border:1px solid rgba(32,59,118,.2); font-weight:700; text-transform:uppercase; letter-spacing:.08em; }
.chart-wrap { position:relative; min-height:0; width:100%; overflow:hidden; }
.chart-wrap canvas { width:100%!important; max-width:100%; display:block; }

/* ── TABLE — scroll horizontal contenido, nunca rompe layout ── */
.table-scroll {
  overflow-x:auto;
  -webkit-overflow-scrolling:touch;
  width:100%;
  /* fuerza que el scroll esté dentro del panel */
  display:block;
}
/* Indicador visual de scroll en móvil */
.table-scroll-hint {
  display:none;
  font-size:10px; color:var(--muted); font-family:'Montserrat',sans-serif;
  font-weight:600; padding:4px 0 8px;
  text-align:right; letter-spacing:.06em;
}
.rep-table {
  width:100%; border-collapse:collapse; font-size:12px;
  /* min-width relativo: tabla puede scrollear, no el contenedor padre */
  min-width:440px;
}
.rep-table th { font-family:'Montserrat',sans-serif; font-size:9px; text-transform:uppercase; letter-spacing:.12em; color:var(--azul); padding:9px 12px; border-bottom:2px solid var(--verde); text-align:left; font-weight:700; white-space:nowrap; background:var(--s2); position:sticky; top:0; }
.rep-table td { padding:9px 12px; border-bottom:1px solid var(--border); vertical-align:middle; font-family:'Open Sans',sans-serif; color:var(--text-dim); }
.rep-table tr:last-child td { border-bottom:none; }
.rep-table tr:hover td { background:#f7fdf7; }
.bar-inline { height:6px; border-radius:3px; background:var(--nota-lo); display:inline-block; opacity:.75; vertical-align:middle; }
.asig-name { overflow:hidden; text-overflow:ellipsis; white-space:nowrap; font-weight:600; color:var(--azul); max-width:min(180px, 30vw); }
.rep-count { font-family:'Montserrat',sans-serif; color:var(--nota-lo); font-weight:800; }
.carrera-tag { display:inline-block; padding:2px 7px; border-radius:4px; font-size:9px; font-family:'Montserrat',sans-serif; font-weight:700; background:rgba(32,59,118,.10); color:var(--azul); max-width:min(130px,25vw); overflow:hidden; text-overflow:ellipsis; white-space:nowrap; vertical-align:middle; }

/* ── GENDER GAP BARS ────────────────────────────────── */
.gender-gap { display:flex; flex-direction:column; gap:10px; overflow-y:auto; max-height:320px; padding-right:4px; }
.gap-row { display:flex; flex-direction:column; gap:4px; min-width:0; }
.gap-label { font-size:11px; color:var(--text-dim); overflow:hidden; text-overflow:ellipsis; white-space:nowrap; font-family:'Open Sans',sans-serif; }
.gap-bars { display:flex; gap:6px; align-items:center; min-width:0; }
.gap-bar-wrap { flex:1; height:8px; background:var(--s2); border-radius:4px; overflow:hidden; min-width:0; border:1px solid var(--border); }
.gap-bar { height:100%; border-radius:4px; transition:width .6s ease; }
.gap-bar.f { background:var(--fem); }
.gap-bar.m { background:var(--mas); }
.gap-val { font-family:'Montserrat',sans-serif; font-size:10px; font-weight:700; width:34px; text-align:right; flex-shrink:0; }
.gap-val.f { color:var(--fem); }
.gap-val.m { color:var(--mas); }

/* ── WAVE FOOTER ────────────────────────────────────── */
.wfooter { margin-top:32px; }
.wfooter svg { display:block; width:100%; }
.footer-bar { background:var(--verde); padding:18px var(--pad-x); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; }
.fn { font-family:'Montserrat',sans-serif; font-weight:800; font-size:13px; color:#fff; }
.fs { font-size:11px; color:rgba(255,255,255,.75); margin-top:2px; }
.footer-bar img { height:50px; filter:brightness(0) invert(1); opacity:.9; }

@keyframes fadeIn { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }

/* ══════════════════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════════════════ */

/* Tablet grande ≤ 1200px */
@media(max-width:1200px) {
  .kpi-strip { grid-template-columns:repeat(3,1fr); }
  .row-3     { grid-template-columns:1fr 1fr; }
  .row-2-1   { grid-template-columns:3fr 2fr; }
  .row-1-2   { grid-template-columns:2fr 3fr; }
}

/* Tablet ≤ 960px */
@media(max-width:960px) {
  .kpi-strip { grid-template-columns:repeat(3,1fr); }
  .row-2, .row-3, .row-2-1, .row-1-2 { grid-template-columns:1fr; }
  /* Cuando los paneles se apilan, reducir altura de charts */
  .chart-wrap[style*="height:340px"] { height:260px!important; }
  .chart-wrap[style*="height:280px"] { height:230px!important; }
  .chart-wrap[style*="height:260px"] { height:220px!important; }
  /* Mostrar pista de scroll en tabla */
  .table-scroll-hint { display:block; }
}

/* Tablet pequeño ≤ 768px */
@media(max-width:768px) {
  :root { --gap:12px; }
  header { min-height:unset; padding:10px var(--pad-x); flex-wrap:wrap; gap:8px; }
  .header-left { flex-wrap:wrap; }
  .hsep { display:none; }
  .htitle { display:none; }   /* Mostrado en title-block ya */
  .kpi-strip { grid-template-columns:repeat(2,1fr); gap:10px; }
  .kpi-sub { display:none; }
  /* Filtros en columnas de 2 */
  .filters { gap:8px; padding:10px var(--pad-x); }
  select { min-width:0; max-width:100%; flex:1 1 calc(50% - 4px); font-size:11px; }
  .filter-label { font-size:8px; }
  .records-count { margin-left:0; width:100%; order:99; }
  .sex-pill { font-size:10px; padding:4px 9px; }
  .panel { padding:14px 14px; }
  /* Charts más cortos en móvil */
  .chart-wrap[style*="height:340px"] { height:240px!important; }
  .chart-wrap[style*="height:280px"] { height:210px!important; }
  .chart-wrap[style*="height:260px"] { height:200px!important; }
  .gender-gap { max-height:260px; }
  /* Tabla: columna "Escala" se oculta en móvil para ganar espacio */
  .rep-table th:last-child,
  .rep-table td:last-child { display:none; }
  .asig-name { max-width:min(140px,40vw); }
  .carrera-tag { max-width:min(100px,28vw); }
}

/* Móvil ≤ 480px */
@media(max-width:480px) {
  :root { --gap:10px; }
  .kpi-strip { grid-template-columns:repeat(2,1fr); gap:8px; }
  .kpi-card  { padding:12px 12px; }
  .kpi-value { font-size:clamp(16px,5vw,22px); }
  /* Filtros: una columna */
  select { flex:1 1 100%; max-width:100%; }
  .btn-reset { width:100%; text-align:center; }
  .header-right .btn-dl:last-child { display:none; }
  .hbrand-name { font-size:12px; }
  .main { padding:14px var(--pad-x) 28px; }
  /* Charts muy compactos */
  .chart-wrap[style*="height:340px"] { height:200px!important; }
  .chart-wrap[style*="height:280px"] { height:180px!important; }
  .chart-wrap[style*="height:260px"] { height:170px!important; }
  /* Tabla: también ocultar carrera para ganar espacio extra */
  .rep-table th:nth-child(2),
  .rep-table td:nth-child(2) { display:none; }
  .panel-badge { display:none; }
  .deco-dot { display:none; }
}
</style>
</head>
<body>

<!-- HEADER -->
<header>
  <div class="header-left">
    <img src="https://sys.unag.edu.hn/assets/images/escudo.png" alt="UNAG" width="44">
    <div class="hbrand">
      <div class="hbrand-name">Universidad Nacional de Agricultura</div>
      <div class="hbrand-unit">SETIC · Análisis Institucional</div>
    </div>
    <div class="hsep"></div>
    <div class="htitle">
      <div class="heyebrow">Análisis Académico · UNAG</div>
      <div class="hmain">Historial Académico de Estudiantes</div>
    </div>
  </div>
  <div class="">
    <a class="btn-dl am" href="https://docs.google.com/spreadsheets/d/1-SmWPUwYXmOVEdcjU2Glp2DqPbO11IDc/edit?usp=sharing" target="_blank">
      <svg viewBox="0 0 16 16" fill="currentColor"><path d="M8 12l-4-4h2.5V4h3v4H12L8 12z"/><rect x="2" y="13" width="12" height="1.5" rx=".75"/></svg>Muestra Excel
    </a>
    <a class="btn-dl" href="https://drive.google.com/file/d/11DYVKAsvCNMerOCXuxs_LnTIqrkMJ0Sf/view?usp=sharing" target="_blank">
      <svg viewBox="0 0 16 16" fill="currentColor"><path d="M8 12l-4-4h2.5V4h3v4H12L8 12z"/><rect x="2" y="13" width="12" height="1.5" rx=".75"/></svg>Informe PDF
    </a>
  </div>
</header>

<!-- Onda decorativa superior -->
<div class="wave-top">
  <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
    <path d="M0,25 C200,65 450,5 720,38 C990,70 1250,10 1440,32 L1440,80 L0,80 Z" fill="#203B76" opacity="0.10"/>
    <path d="M0,48 C320,18 640,65 960,40 C1150,25 1320,54 1440,42 L1440,80 L0,80 Z" fill="#1BA333" opacity="0.13"/>
    <path d="M0,60 C450,44 850,70 1440,52" stroke="#1BA333" stroke-width="1.5" fill="none" opacity="0.4"/>
  </svg>
  <div class="deco-dot"></div>
</div>

<!-- CONTAINER -->
<div class="container">
  <div class="title-block">
    <div class="page-lbl">Análisis Académico · UNAG · 2024–2025</div>
    <h1>Dashboard — <span>Historial</span> Académico</h1>
    <div style="font-family:'Montserrat',sans-serif;font-size:9px;letter-spacing:.2em;color:var(--verde);text-transform:uppercase;font-weight:700;margin:4px 0;">
      Secretaría de Tecnología de la Información y Comunicaciones (SETIC)
    </div>
    <p>UNAG · Historiales Estudiantiles · Rendimiento por Carrera y Género</p>
     <p >Nota: Este análisis está hecho en base a una muestra de 256,565 registros de notas de 2024 y 2025 </p>
  </div>

  <!-- FILTERS -->
  <div class="filters">
    <span class="filter-label">Filtrar por</span>
    <select id="filterCarrera" onchange="applyFilters()"><option value="all">Todas las carreras</option></select>
    <select id="filterSexo" onchange="applyFilters()">
      <option value="all">Ambos sexos</option>
      <option value="F">Femenino</option>
      <option value="M">Masculino</option>
    </select>
    <select id="filterNivel" onchange="applyFilters()">
      <option value="all">Pregrado + Posgrado</option>
      <option value="pre">Solo Pregrado</option>
      <option value="pos">Solo Posgrado</option>
    </select>
    <button class="btn-reset" onclick="resetFilters()">↺ Resetear</button>
    <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
      <div class="sex-pill f"><div class="sex-dot f"></div>Femenino</div>
      <div class="sex-pill m"><div class="sex-dot m"></div>Masculino</div>
    </div>
    <div class="records-count">Mostrando <span id="recCount">256,565</span> registros</div>
  </div>

  <!-- MAIN -->
  <div class="main">

    <!-- SH KPIs -->
    <div class="sh"><div class="sh-bar"></div><div class="sh-txt">Indicadores Clave</div><div class="sh-line"></div></div>

    <div class="kpi-strip">
      <div class="kpi-card az">
        <div class="kpi-label">Total Registros</div>
        <div class="kpi-value az" id="kpi-registros">256,565</div>
        <div class="kpi-sub">Calificaciones registradas</div>
      </div>
      <div class="kpi-card az">
        <div class="kpi-label">Estudiantes</div>
        <div class="kpi-value az" id="kpi-estudiantes">3,984</div>
        <div class="kpi-sub">Matrículas únicas</div>
      </div>
      <div class="kpi-card am">
        <div class="kpi-label">Nota Promedio</div>
        <div class="kpi-value am" id="kpi-promedio">72.12</div>
        <div class="kpi-sub">Sobre 100 puntos</div>
      </div>
      <div class="kpi-card vd">
        <div class="kpi-label">Tasa Aprobación</div>
        <div class="kpi-value vd" id="kpi-aprobacion">92.1%</div>
        <div class="kpi-sub">Nota ≥ 60</div>
      </div>
      <div class="kpi-card fem">
        <div class="kpi-label">Estudiantes F</div>
        <div class="kpi-value fem" id="kpi-f">1,706</div>
        <div class="kpi-sub" id="kpi-f-pct">42.8% del total</div>
      </div>
      <div class="kpi-card mas">
        <div class="kpi-label">Estudiantes M</div>
        <div class="kpi-value mas" id="kpi-m">2,278</div>
        <div class="kpi-sub" id="kpi-m-pct">57.2% del total</div>
      </div>
    </div>

    <!-- SH ROW 1 -->
    <div class="sh"><div class="sh-bar"></div><div class="sh-txt">Rendimiento por Carrera</div><div class="sh-line"></div></div>

    <div class="row row-2-1">
      <div class="panel">
        <div class="panel-header">
          <div><div class="panel-title">Nota Promedio por Carrera y Sexo</div><div class="panel-sub">Comparativa F vs M — escala 0–100</div></div>
          <div class="panel-badge">Bar Chart</div>
        </div>
        <div class="chart-wrap" style="height:340px"><canvas id="chartBarCarrera"></canvas></div>
      </div>
      <div class="panel am-top">
        <div class="panel-header">
          <div><div class="panel-title">Distribución de Notas</div><div class="panel-sub">Rangos por sexo</div></div>
        </div>
        <div class="chart-wrap" style="height:340px"><canvas id="chartDistRangos"></canvas></div>
      </div>
    </div>

    <!-- SH ROW 2 -->
    <div class="sh"><div class="sh-bar"></div><div class="sh-txt">Aprobación · Género · Tendencia</div><div class="sh-line"></div></div>

    <div class="row row-3">
      <div class="panel">
        <div class="panel-header">
          <div><div class="panel-title">Tasa de Aprobación</div><div class="panel-sub">Por carrera y sexo (%)</div></div>
        </div>
        <div class="chart-wrap" style="height:280px"><canvas id="chartAprobacion"></canvas></div>
      </div>
      <div class="panel az-top">
        <div class="panel-header">
          <div><div class="panel-title">Composición por Género</div><div class="panel-sub">Estudiantes F vs M por carrera</div></div>
        </div>
        <div class="chart-wrap" style="height:280px"><canvas id="chartGenero"></canvas></div>
      </div>
      <div class="panel fem-top">
        <div class="panel-header">
          <div><div class="panel-title">Tendencia Temporal</div><div class="panel-sub">Promedio por período académico</div></div>
        </div>
        <div class="chart-wrap" style="height:280px"><canvas id="chartTrend"></canvas></div>
      </div>
    </div>

    <!-- SH ROW 3 -->
    <div class="sh"><div class="sh-bar"></div><div class="sh-txt">Brecha de Género · Reprobaciones</div><div class="sh-line"></div></div>

    <div class="row row-1-2">
      <div class="panel">
        <div class="panel-header">
          <div><div class="panel-title">Brecha de Género en Rendimiento</div><div class="panel-sub">Nota promedio F vs M por carrera</div></div>
        </div>
        <div class="gender-gap" id="gapContainer"></div>
      </div>
      <div class="panel">
        <div class="panel-header">
          <div><div class="panel-title">Asignaturas con Más Reprobaciones</div><div class="panel-sub">Top por carrera — nota &lt; 60</div></div>
        </div>
        <div class="table-scroll-hint">← desliza para ver más →</div>
        <div class="table-scroll" style="max-height:340px;">
          <table class="rep-table">
            <thead><tr><th>Asignatura</th><th>Carrera</th><th>Reprobaciones</th><th>Escala</th></tr></thead>
            <tbody id="repTablaBody"></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- SH ROW 4 -->
    <div class="sh"><div class="sh-bar"></div><div class="sh-txt">Suficiencias · Rendimiento Global</div><div class="sh-line"></div></div>

    <div class="row row-2">
      <div class="panel">
        <div class="panel-header">
          <div><div class="panel-title">Exámenes de Suficiencia por Carrera</div><div class="panel-sub">Distribución por sexo</div></div>
        </div>
        <div class="chart-wrap" style="height:260px"><canvas id="chartSuficiencias"></canvas></div>
      </div>
      <div class="panel az-top">
        <div class="panel-header">
          <div><div class="panel-title">Aprobación vs. Rendimiento Promedio</div><div class="panel-sub">Burbuja por carrera — tamaño = nº estudiantes</div></div>
        </div>
        <div class="chart-wrap" style="height:260px"><canvas id="chartBubble"></canvas></div>
      </div>
    </div>

  </div><!-- /main -->
</div><!-- /container -->

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
      <div class="fs">Secretaría de Tecnología de la Información y Comunicaciones (SETIC) · Dashboard Analítico · Historial Académico · <span id="footerDate" style="color:rgba(255,255,255,0.9)"></span></div>
    </div>
    <img src="https://setic.unag.edu.hn/img/logo-setic-blanco.png" alt="SETIC UNAG">
  </div>
</div>

<script>
/* ── CHART.JS DEFAULTS ───────────────────────────────── */
const CF = 'rgba(212,71,138,0.82)';   /* femenino */
const CM = 'rgba(0,148,233,0.82)';    /* masculino */
Chart.defaults.color = '#6b8a6b';
Chart.defaults.borderColor = 'rgba(27,163,51,0.08)';
Chart.defaults.font.family = "'Montserrat', sans-serif";
Chart.defaults.font.size = 11;
const TT = {
  backgroundColor:'#fff', borderWidth:1,
  titleColor:'#203B76', bodyColor:'#3d5c3d',
  titleFont:{family:"'Montserrat'",size:12,weight:'800'},
  bodyFont:{family:"'Montserrat'",size:10,weight:'600'},
  padding:10, cornerRadius:6
};

/* ── DATA ────────────────────────────────────────────── */
const RAW_AVG=[{"carrera":"Administración de Empresas Agropecuarias","sexo":"F","nota_avg":75.78},{"carrera":"Administración de Empresas Agropecuarias","sexo":"M","nota_avg":71.13},{"carrera":"Economía Social Agraria","sexo":"F","nota_avg":73.11},{"carrera":"Economía Social Agraria","sexo":"M","nota_avg":69.89},{"carrera":"Ingeniería Agronómica","sexo":"F","nota_avg":72.1},{"carrera":"Ingeniería Agronómica","sexo":"M","nota_avg":70.56},{"carrera":"Ing. en Agroexportación","sexo":"F","nota_avg":73.37},{"carrera":"Ing. en Agroexportación","sexo":"M","nota_avg":70.71},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"F","nota_avg":70.62},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"M","nota_avg":67.4},{"carrera":"Ing. Tecnología Alimentaria","sexo":"F","nota_avg":74.91},{"carrera":"Ing. Tecnología Alimentaria","sexo":"M","nota_avg":72.03},{"carrera":"Ingeniería en Zootecnia","sexo":"F","nota_avg":73.9},{"carrera":"Ingeniería en Zootecnia","sexo":"M","nota_avg":72.74},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"F","nota_avg":90.47},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"M","nota_avg":89.67},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"F","nota_avg":87.47},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"M","nota_avg":88.74},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"F","nota_avg":87.23},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"M","nota_avg":81.84},{"carrera":"Maestría en Suelos","sexo":"F","nota_avg":88.06},{"carrera":"Maestría en Suelos","sexo":"M","nota_avg":81.23},{"carrera":"Medicina Veterinaria","sexo":"F","nota_avg":77.36},{"carrera":"Medicina Veterinaria","sexo":"M","nota_avg":74.64}];
const RAW_APR=[{"carrera":"Administración de Empresas Agropecuarias","sexo":"F","tasa_apr":0.9389},{"carrera":"Administración de Empresas Agropecuarias","sexo":"M","tasa_apr":0.8596},{"carrera":"Economía Social Agraria","sexo":"F","tasa_apr":0.8959},{"carrera":"Economía Social Agraria","sexo":"M","tasa_apr":0.9021},{"carrera":"Ingeniería Agronómica","sexo":"F","tasa_apr":0.9316},{"carrera":"Ingeniería Agronómica","sexo":"M","tasa_apr":0.9127},{"carrera":"Ing. en Agroexportación","sexo":"F","tasa_apr":0.8824},{"carrera":"Ing. en Agroexportación","sexo":"M","tasa_apr":0.8674},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"F","tasa_apr":0.9181},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"M","tasa_apr":0.872},{"carrera":"Ing. Tecnología Alimentaria","sexo":"F","tasa_apr":0.9515},{"carrera":"Ing. Tecnología Alimentaria","sexo":"M","tasa_apr":0.9237},{"carrera":"Ingeniería en Zootecnia","sexo":"F","tasa_apr":0.9295},{"carrera":"Ingeniería en Zootecnia","sexo":"M","tasa_apr":0.9299},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"F","tasa_apr":1.0},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"M","tasa_apr":0.9851},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"F","tasa_apr":1.0},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"M","tasa_apr":0.9974},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"F","tasa_apr":0.9839},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"M","tasa_apr":0.9858},{"carrera":"Maestría en Suelos","sexo":"F","tasa_apr":1.0},{"carrera":"Maestría en Suelos","sexo":"M","tasa_apr":0.9302},{"carrera":"Medicina Veterinaria","sexo":"F","tasa_apr":0.9599},{"carrera":"Medicina Veterinaria","sexo":"M","tasa_apr":0.9385}];
const RAW_EST=[{"carrera":"Administración de Empresas Agropecuarias","sexo":"F","estudiantes":162},{"carrera":"Administración de Empresas Agropecuarias","sexo":"M","estudiantes":111},{"carrera":"Economía Social Agraria","sexo":"F","estudiantes":76},{"carrera":"Economía Social Agraria","sexo":"M","estudiantes":47},{"carrera":"Ingeniería Agronómica","sexo":"F","estudiantes":486},{"carrera":"Ingeniería Agronómica","sexo":"M","estudiantes":1208},{"carrera":"Ing. en Agroexportación","sexo":"F","estudiantes":45},{"carrera":"Ing. en Agroexportación","sexo":"M","estudiantes":53},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"F","estudiantes":188},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"M","estudiantes":202},{"carrera":"Ing. Tecnología Alimentaria","sexo":"F","estudiantes":281},{"carrera":"Ing. Tecnología Alimentaria","sexo":"M","estudiantes":198},{"carrera":"Ingeniería en Zootecnia","sexo":"F","estudiantes":176},{"carrera":"Ingeniería en Zootecnia","sexo":"M","estudiantes":243},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"F","estudiantes":8},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"M","estudiantes":13},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"F","estudiantes":12},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"M","estudiantes":26},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"F","estudiantes":13},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"M","estudiantes":17},{"carrera":"Maestría en Suelos","sexo":"F","estudiantes":4},{"carrera":"Maestría en Suelos","sexo":"M","estudiantes":14},{"carrera":"Medicina Veterinaria","sexo":"F","estudiantes":255},{"carrera":"Medicina Veterinaria","sexo":"M","estudiantes":146}];
const RAW_DIST=[{"carrera":"Administración de Empresas Agropecuarias","sexo":"F","rango":"<60","count":557},{"carrera":"Administración de Empresas Agropecuarias","sexo":"F","rango":"60-69","count":2270},{"carrera":"Administración de Empresas Agropecuarias","sexo":"F","rango":"70-79","count":2056},{"carrera":"Administración de Empresas Agropecuarias","sexo":"F","rango":"80-89","count":2259},{"carrera":"Administración de Empresas Agropecuarias","sexo":"F","rango":"90-100","count":1970},{"carrera":"Administración de Empresas Agropecuarias","sexo":"M","rango":"<60","count":757},{"carrera":"Administración de Empresas Agropecuarias","sexo":"M","rango":"60-69","count":1327},{"carrera":"Administración de Empresas Agropecuarias","sexo":"M","rango":"70-79","count":1293},{"carrera":"Administración de Empresas Agropecuarias","sexo":"M","rango":"80-89","count":1145},{"carrera":"Administración de Empresas Agropecuarias","sexo":"M","rango":"90-100","count":870},{"carrera":"Economía Social Agraria","sexo":"F","rango":"<60","count":479},{"carrera":"Economía Social Agraria","sexo":"F","rango":"60-69","count":1164},{"carrera":"Economía Social Agraria","sexo":"F","rango":"70-79","count":1115},{"carrera":"Economía Social Agraria","sexo":"F","rango":"80-89","count":1186},{"carrera":"Economía Social Agraria","sexo":"F","rango":"90-100","count":658},{"carrera":"Economía Social Agraria","sexo":"M","rango":"<60","count":293},{"carrera":"Economía Social Agraria","sexo":"M","rango":"60-69","count":999},{"carrera":"Economía Social Agraria","sexo":"M","rango":"70-79","count":904},{"carrera":"Economía Social Agraria","sexo":"M","rango":"80-89","count":602},{"carrera":"Economía Social Agraria","sexo":"M","rango":"90-100","count":194},{"carrera":"Ingeniería Agronómica","sexo":"F","rango":"<60","count":2287},{"carrera":"Ingeniería Agronómica","sexo":"F","rango":"60-69","count":11629},{"carrera":"Ingeniería Agronómica","sexo":"F","rango":"70-79","count":9160},{"carrera":"Ingeniería Agronómica","sexo":"F","rango":"80-89","count":7331},{"carrera":"Ingeniería Agronómica","sexo":"F","rango":"90-100","count":3045},{"carrera":"Ingeniería Agronómica","sexo":"M","rango":"<60","count":7282},{"carrera":"Ingeniería Agronómica","sexo":"M","rango":"60-69","count":31525},{"carrera":"Ingeniería Agronómica","sexo":"M","rango":"70-79","count":22439},{"carrera":"Ingeniería Agronómica","sexo":"M","rango":"80-89","count":16379},{"carrera":"Ingeniería Agronómica","sexo":"M","rango":"90-100","count":5743},{"carrera":"Ing. en Agroexportación","sexo":"F","rango":"<60","count":394},{"carrera":"Ing. en Agroexportación","sexo":"F","rango":"60-69","count":822},{"carrera":"Ing. en Agroexportación","sexo":"F","rango":"70-79","count":913},{"carrera":"Ing. en Agroexportación","sexo":"F","rango":"80-89","count":853},{"carrera":"Ing. en Agroexportación","sexo":"F","rango":"90-100","count":367},{"carrera":"Ing. en Agroexportación","sexo":"M","rango":"<60","count":470},{"carrera":"Ing. en Agroexportación","sexo":"M","rango":"60-69","count":1053},{"carrera":"Ing. en Agroexportación","sexo":"M","rango":"70-79","count":1035},{"carrera":"Ing. en Agroexportación","sexo":"M","rango":"80-89","count":708},{"carrera":"Ing. en Agroexportación","sexo":"M","rango":"90-100","count":279},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"F","rango":"<60","count":1073},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"F","rango":"60-69","count":4932},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"F","rango":"70-79","count":3564},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"F","rango":"80-89","count":2475},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"F","rango":"90-100","count":1051},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"M","rango":"<60","count":1679},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"M","rango":"60-69","count":5646},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"M","rango":"70-79","count":3186},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"M","rango":"80-89","count":1825},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"M","rango":"90-100","count":785},{"carrera":"Ing. Tecnología Alimentaria","sexo":"F","rango":"<60","count":984},{"carrera":"Ing. Tecnología Alimentaria","sexo":"F","rango":"60-69","count":5568},{"carrera":"Ing. Tecnología Alimentaria","sexo":"F","rango":"70-79","count":5986},{"carrera":"Ing. Tecnología Alimentaria","sexo":"F","rango":"80-89","count":5029},{"carrera":"Ing. Tecnología Alimentaria","sexo":"F","rango":"90-100","count":2705},{"carrera":"Ing. Tecnología Alimentaria","sexo":"M","rango":"<60","count":1015},{"carrera":"Ing. Tecnología Alimentaria","sexo":"M","rango":"60-69","count":4548},{"carrera":"Ing. Tecnología Alimentaria","sexo":"M","rango":"70-79","count":3521},{"carrera":"Ing. Tecnología Alimentaria","sexo":"M","rango":"80-89","count":2912},{"carrera":"Ing. Tecnología Alimentaria","sexo":"M","rango":"90-100","count":1308},{"carrera":"Ingeniería en Zootecnia","sexo":"F","rango":"<60","count":859},{"carrera":"Ingeniería en Zootecnia","sexo":"F","rango":"60-69","count":3638},{"carrera":"Ingeniería en Zootecnia","sexo":"F","rango":"70-79","count":3021},{"carrera":"Ingeniería en Zootecnia","sexo":"F","rango":"80-89","count":2878},{"carrera":"Ingeniería en Zootecnia","sexo":"F","rango":"90-100","count":1791},{"carrera":"Ingeniería en Zootecnia","sexo":"M","rango":"<60","count":1275},{"carrera":"Ingeniería en Zootecnia","sexo":"M","rango":"60-69","count":5887},{"carrera":"Ingeniería en Zootecnia","sexo":"M","rango":"70-79","count":4800},{"carrera":"Ingeniería en Zootecnia","sexo":"M","rango":"80-89","count":4093},{"carrera":"Ingeniería en Zootecnia","sexo":"M","rango":"90-100","count":2121},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"F","rango":"70-79","count":3},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"F","rango":"80-89","count":10},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"F","rango":"90-100","count":32},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"M","rango":"<60","count":1},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"M","rango":"70-79","count":6},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"M","rango":"80-89","count":12},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"M","rango":"90-100","count":48},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"F","rango":"60-69","count":6},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"F","rango":"70-79","count":31},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"F","rango":"80-89","count":87},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"F","rango":"90-100","count":133},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"M","rango":"<60","count":1},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"M","rango":"60-69","count":2},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"M","rango":"70-79","count":47},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"M","rango":"80-89","count":128},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"M","rango":"90-100","count":205},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"F","rango":"<60","count":2},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"F","rango":"70-79","count":6},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"F","rango":"80-89","count":57},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"F","rango":"90-100","count":59},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"M","rango":"<60","count":2},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"M","rango":"60-69","count":5},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"M","rango":"70-79","count":39},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"M","rango":"80-89","count":62},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"M","rango":"90-100","count":33},{"carrera":"Maestría en Suelos","sexo":"F","rango":"80-89","count":7},{"carrera":"Maestría en Suelos","sexo":"F","rango":"90-100","count":9},{"carrera":"Maestría en Suelos","sexo":"M","rango":"<60","count":3},{"carrera":"Maestría en Suelos","sexo":"M","rango":"60-69","count":5},{"carrera":"Maestría en Suelos","sexo":"M","rango":"70-79","count":6},{"carrera":"Maestría en Suelos","sexo":"M","rango":"80-89","count":15},{"carrera":"Maestría en Suelos","sexo":"M","rango":"90-100","count":14},{"carrera":"Medicina Veterinaria","sexo":"F","rango":"<60","count":512},{"carrera":"Medicina Veterinaria","sexo":"F","rango":"60-69","count":2634},{"carrera":"Medicina Veterinaria","sexo":"F","rango":"70-79","count":3535},{"carrera":"Medicina Veterinaria","sexo":"F","rango":"80-89","count":3704},{"carrera":"Medicina Veterinaria","sexo":"F","rango":"90-100","count":2394},{"carrera":"Medicina Veterinaria","sexo":"M","rango":"<60","count":415},{"carrera":"Medicina Veterinaria","sexo":"M","rango":"60-69","count":1687},{"carrera":"Medicina Veterinaria","sexo":"M","rango":"70-79","count":2017},{"carrera":"Medicina Veterinaria","sexo":"M","rango":"80-89","count":1772},{"carrera":"Medicina Veterinaria","sexo":"M","rango":"90-100","count":852}];
const RAW_TREND=[{"anio":2024,"periodo":1,"sexo":"F","nota":72.97},{"anio":2024,"periodo":1,"sexo":"M","nota":70.88},{"anio":2024,"periodo":2,"sexo":"F","nota":72.78},{"anio":2024,"periodo":2,"sexo":"M","nota":69.63},{"anio":2024,"periodo":3,"sexo":"F","nota":73.31},{"anio":2024,"periodo":3,"sexo":"M","nota":70.39},{"anio":2025,"periodo":1,"sexo":"F","nota":73.0},{"anio":2025,"periodo":1,"sexo":"M","nota":69.84},{"anio":2025,"periodo":2,"sexo":"F","nota":76.19},{"anio":2025,"periodo":2,"sexo":"M","nota":73.64},{"anio":2025,"periodo":3,"sexo":"F","nota":74.4},{"anio":2025,"periodo":3,"sexo":"M","nota":71.62}];
const RAW_REP=[{"carrera":"Ingeniería Agronómica","asignatura":"CALCULO I","rep":1068},{"carrera":"Ingeniería Agronómica","asignatura":"MATEMÁTICA GENERAL","rep":861},{"carrera":"Ingeniería Agronómica","asignatura":"GEOMETRÍA Y TRIGONOMETRÍA","rep":720},{"carrera":"Ingeniería Agronómica","asignatura":"ESPAÑOL","rep":680},{"carrera":"Ingeniería Agronómica","asignatura":"BIOLOGÍA","rep":608},{"carrera":"Ing. G.I. Recursos Naturales","asignatura":"MATEMÁTICA GENERAL","rep":448},{"carrera":"Ing. Tecnología Alimentaria","asignatura":"GEOMETRÍA Y TRIGONOMETRÍA","rep":315},{"carrera":"Ing. G.I. Recursos Naturales","asignatura":"QUÍMICA GENERAL","rep":282},{"carrera":"Ingeniería en Zootecnia","asignatura":"MATEMÁTICA GENERAL","rep":238},{"carrera":"Administración de Empresas Agropecuarias","asignatura":"BIOLOGÍA","rep":224},{"carrera":"Ing. G.I. Recursos Naturales","asignatura":"BIOLOGÍA","rep":224},{"carrera":"Ingeniería en Zootecnia","asignatura":"INGLÉS II","rep":216},{"carrera":"Ing. Tecnología Alimentaria","asignatura":"ESPAÑOL","rep":208},{"carrera":"Ing. Tecnología Alimentaria","asignatura":"BIOLOGÍA","rep":208},{"carrera":"Ing. G.I. Recursos Naturales","asignatura":"ESPAÑOL","rep":208},{"carrera":"Ingeniería en Zootecnia","asignatura":"CÁLCULO I","rep":192},{"carrera":"Administración de Empresas Agropecuarias","asignatura":"ESPAÑOL","rep":144},{"carrera":"Administración de Empresas Agropecuarias","asignatura":"MATEMÁTICA GENERAL","rep":140},{"carrera":"Economía Social Agraria","asignatura":"INGLÉS I","rep":136},{"carrera":"Ing. en Agroexportación","asignatura":"MATEMÁTICA GENERAL","rep":182},{"carrera":"Medicina Veterinaria","asignatura":"BIOLOGÍA","rep":96},{"carrera":"Medicina Veterinaria","asignatura":"INGLÉS III","rep":88},{"carrera":"Economía Social Agraria","asignatura":"MATEMÁTICA GENERAL","rep":112},{"carrera":"Ing. en Agroexportación","asignatura":"BIOLOGÍA","rep":112}];
const RAW_SUF=[{"carrera":"Ingeniería Agronómica","sexo":"F","suf":152},{"carrera":"Ingeniería Agronómica","sexo":"M","suf":576},{"carrera":"Ing. en Agroexportación","sexo":"F","suf":24},{"carrera":"Ing. en Agroexportación","sexo":"M","suf":32},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"F","suf":0},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"M","suf":24},{"carrera":"Ing. Tecnología Alimentaria","sexo":"F","suf":160},{"carrera":"Ing. Tecnología Alimentaria","sexo":"M","suf":104},{"carrera":"Ingeniería en Zootecnia","sexo":"F","suf":272},{"carrera":"Ingeniería en Zootecnia","sexo":"M","suf":216},{"carrera":"Medicina Veterinaria","sexo":"F","suf":680},{"carrera":"Medicina Veterinaria","sexo":"M","suf":192}];
const POSGRADOS=["Mtra. Ciencias Agroalimentarias","Mtra. G.P. Animal Sostenible","Mtra. RN y Prod. Sostenible","Maestría en Suelos"];

/* Paleta distribución de rangos — colores UNAG */
const RANGO_COLORS = [
  'rgba(192,48,48,0.85)',   /* <60     rojo */
  'rgba(212,135,10,0.85)',  /* 60-69   ámbar */
  'rgba(0,148,233,0.85)',   /* 70-79   celeste */
  'rgba(27,163,51,0.85)',   /* 80-89   verde */
  'rgba(19,84,35,0.85)',    /* 90-100  verde oscuro */
];

let charts={}, activeFilters={carrera:'all',sexo:'all',nivel:'all'};

window.addEventListener('DOMContentLoaded',()=>{
  document.getElementById('footerDate').textContent=new Date().toLocaleDateString('es-HN',{year:'numeric',month:'long'});
  populateCarreraFilter(); buildAll();
});

function populateCarreraFilter(){
  const sel=document.getElementById('filterCarrera');
  [...new Set(RAW_AVG.map(d=>d.carrera))].sort().forEach(c=>{const o=document.createElement('option');o.value=c;o.textContent=c;sel.appendChild(o);});
}
function applyFilters(){
  activeFilters.carrera=document.getElementById('filterCarrera').value;
  activeFilters.sexo=document.getElementById('filterSexo').value;
  activeFilters.nivel=document.getElementById('filterNivel').value;
  buildAll();
}
function resetFilters(){
  ['filterCarrera','filterSexo','filterNivel'].forEach(id=>document.getElementById(id).value='all');
  activeFilters={carrera:'all',sexo:'all',nivel:'all'}; buildAll();
}
function filterData(arr){
  return arr.filter(d=>{
    const cOk=activeFilters.carrera==='all'||d.carrera===activeFilters.carrera;
    const sOk=activeFilters.sexo==='all'||d.sexo===activeFilters.sexo||d.sexo_estudiante===activeFilters.sexo;
    const nOk=activeFilters.nivel==='all'||(activeFilters.nivel==='pre'&&!POSGRADOS.includes(d.carrera))||(activeFilters.nivel==='pos'&&POSGRADOS.includes(d.carrera));
    return cOk&&sOk&&nOk;
  });
}
function destroyChart(id){if(charts[id]){charts[id].destroy();delete charts[id];}}

function buildAll(){
  const avgF=filterData(RAW_AVG.filter(d=>d.sexo==='F')),avgM=filterData(RAW_AVG.filter(d=>d.sexo==='M'));
  const aprF=filterData(RAW_APR.filter(d=>d.sexo==='F')),aprM=filterData(RAW_APR.filter(d=>d.sexo==='M'));
  const estF=filterData(RAW_EST.filter(d=>d.sexo==='F')),estM=filterData(RAW_EST.filter(d=>d.sexo==='M'));
  updateKPIs(avgF,avgM,aprF,aprM,estF,estM);
  buildBarCarrera(avgF,avgM);buildDistRangos();buildAprobacion(aprF,aprM);
  buildGenero(estF,estM);buildTrend();buildGenderGap(avgF,avgM);
  buildRepTabla();buildSuficiencias();buildBubble(avgF,avgM,aprF,aprM,estF,estM);
}

function updateKPIs(avgF,avgM,aprF,aprM,estF,estM){
  const allAvg=[...avgF,...avgM],allApr=[...aprF,...aprM];
  const fEst=estF.reduce((s,d)=>s+d.estudiantes,0),mEst=estM.reduce((s,d)=>s+d.estudiantes,0),totalEst=fEst+mEst;
  const notaAvg=allAvg.length?(allAvg.reduce((s,d)=>s+d.nota_avg,0)/allAvg.length).toFixed(2):'—';
  const taApr=allApr.length?(allApr.reduce((s,d)=>s+d.tasa_apr,0)/allApr.length*100).toFixed(1)+'%':'—';
  const totalRec=filterData(RAW_DIST).reduce((s,d)=>s+d.count,0);
  document.getElementById('kpi-registros').textContent=totalRec.toLocaleString('es-HN');
  document.getElementById('kpi-estudiantes').textContent=totalEst.toLocaleString('es-HN');
  document.getElementById('kpi-promedio').textContent=notaAvg;
  document.getElementById('kpi-aprobacion').textContent=taApr;
  document.getElementById('kpi-f').textContent=fEst.toLocaleString('es-HN');
  document.getElementById('kpi-m').textContent=mEst.toLocaleString('es-HN');
  document.getElementById('kpi-f-pct').textContent=totalEst?(fEst/totalEst*100).toFixed(1)+'% del total':'';
  document.getElementById('kpi-m-pct').textContent=totalEst?(mEst/totalEst*100).toFixed(1)+'% del total':'';
  document.getElementById('recCount').textContent=totalRec.toLocaleString('es-HN');
}

function buildBarCarrera(avgF,avgM){
  const carreras=[...new Set([...avgF.map(d=>d.carrera),...avgM.map(d=>d.carrera)])];
  const fMap=Object.fromEntries(avgF.map(d=>[d.carrera,d.nota_avg]));
  const mMap=Object.fromEntries(avgM.map(d=>[d.carrera,d.nota_avg]));
  const short=c=>c.replace('Ingeniería','Ing.').replace('Administración de Empresas','Adm.').replace('Economía','Econ.').replace('Medicina','Med.');
  destroyChart('chartBarCarrera');
  charts['chartBarCarrera']=new Chart(document.getElementById('chartBarCarrera'),{
    type:'bar',
    data:{labels:carreras.map(short),datasets:[
      {label:'Femenino',data:carreras.map(c=>fMap[c]??null),backgroundColor:CF,borderColor:'rgba(212,71,138,1)',borderWidth:1,borderRadius:4},
      {label:'Masculino',data:carreras.map(c=>mMap[c]??null),backgroundColor:CM,borderColor:'rgba(0,148,233,1)',borderWidth:1,borderRadius:4}
    ]},
    options:{responsive:true,maintainAspectRatio:false,
      plugins:{legend:{position:'top',labels:{padding:14,usePointStyle:true,pointStyleWidth:10,color:'#3d5c3d',font:{weight:'600'}}},tooltip:{...TT,borderColor:'var(--verde)',callbacks:{label:ctx=>` ${ctx.dataset.label}: ${ctx.parsed.y?.toFixed(1)} pts`}}},
      scales:{x:{grid:{color:'rgba(27,163,51,0.06)'},ticks:{maxRotation:40,font:{size:9,weight:'600'},color:'#6b8a6b'}},y:{min:55,max:100,grid:{color:'rgba(27,163,51,0.08)'},ticks:{callback:v=>v+' pts',color:'#6b8a6b',font:{weight:'600'}}}}
    }
  });
}

function buildDistRangos(){
  const dist=filterData(RAW_DIST),rangos=['<60','60-69','70-79','80-89','90-100'];
  const totF={},totM={};
  rangos.forEach(r=>{totF[r]=0;totM[r]=0;});
  dist.forEach(d=>{if(d.sexo==='F')totF[d.rango]=(totF[d.rango]||0)+d.count;else if(d.sexo==='M')totM[d.rango]=(totM[d.rango]||0)+d.count;});
  const sumF=Object.values(totF).reduce((a,b)=>a+b,0),sumM=Object.values(totM).reduce((a,b)=>a+b,0);
  const dataSets=activeFilters.sexo==='F'?[{label:'Femenino',data:rangos.map(r=>sumF?+(totF[r]/sumF*100).toFixed(1):0),backgroundColor:RANGO_COLORS,borderRadius:4,borderWidth:0}]
    :activeFilters.sexo==='M'?[{label:'Masculino',data:rangos.map(r=>sumM?+(totM[r]/sumM*100).toFixed(1):0),backgroundColor:RANGO_COLORS,borderRadius:4,borderWidth:0}]
    :[{label:'Femenino',data:rangos.map(r=>sumF?+(totF[r]/sumF*100).toFixed(1):0),backgroundColor:RANGO_COLORS.map(c=>c.replace('0.85','0.4')),borderRadius:4,borderWidth:0},
      {label:'Masculino',data:rangos.map(r=>sumM?+(totM[r]/sumM*100).toFixed(1):0),backgroundColor:RANGO_COLORS,borderRadius:4,borderWidth:0}];
  destroyChart('chartDistRangos');
  charts['chartDistRangos']=new Chart(document.getElementById('chartDistRangos'),{
    type:'bar',data:{labels:rangos,datasets:dataSets},
    options:{responsive:true,maintainAspectRatio:false,
      plugins:{legend:{position:'top',labels:{padding:12,usePointStyle:true,color:'#3d5c3d',font:{weight:'600'}}},tooltip:{...TT,borderColor:'var(--verde)',callbacks:{label:ctx=>` ${ctx.dataset.label}: ${ctx.parsed.y}%`}}},
      scales:{x:{grid:{color:'rgba(27,163,51,0.06)'},ticks:{color:'#6b8a6b',font:{weight:'600'}}},y:{grid:{color:'rgba(27,163,51,0.08)'},ticks:{callback:v=>v+'%',color:'#6b8a6b',font:{weight:'600'}}}}
    }
  });
}

function buildAprobacion(aprF,aprM){
  const carreras=[...new Set([...aprF.map(d=>d.carrera),...aprM.map(d=>d.carrera)])];
  const fMap=Object.fromEntries(aprF.map(d=>[d.carrera,+(d.tasa_apr*100).toFixed(1)]));
  const mMap=Object.fromEntries(aprM.map(d=>[d.carrera,+(d.tasa_apr*100).toFixed(1)]));
  const short=c=>c.length>22?c.substring(0,20)+'…':c;
  destroyChart('chartAprobacion');
  charts['chartAprobacion']=new Chart(document.getElementById('chartAprobacion'),{
    type:'bar',
    data:{labels:carreras.map(short),datasets:[
      {label:'Femenino',data:carreras.map(c=>fMap[c]??null),backgroundColor:CF,borderRadius:3},
      {label:'Masculino',data:carreras.map(c=>mMap[c]??null),backgroundColor:CM,borderRadius:3}
    ]},
    options:{responsive:true,maintainAspectRatio:false,indexAxis:'y',
      plugins:{legend:{position:'top',labels:{padding:12,usePointStyle:true,color:'#3d5c3d',font:{weight:'600'}}},tooltip:{...TT,borderColor:'var(--verde)',callbacks:{label:ctx=>` ${ctx.dataset.label}: ${ctx.parsed.x}%`}}},
      scales:{x:{min:80,max:102,grid:{color:'rgba(27,163,51,0.06)'},ticks:{callback:v=>v+'%',color:'#6b8a6b',font:{weight:'600'}}},y:{grid:{color:'rgba(27,163,51,0.04)'},ticks:{font:{size:9,weight:'600'},color:'#3d5c3d'}}}
    }
  });
}

function buildGenero(estF,estM){
  const carreras=[...new Set([...estF.map(d=>d.carrera),...estM.map(d=>d.carrera)])];
  const fMap=Object.fromEntries(estF.map(d=>[d.carrera,d.estudiantes]));
  const mMap=Object.fromEntries(estM.map(d=>[d.carrera,d.estudiantes]));
  const short=c=>c.length>22?c.substring(0,20)+'…':c;
  destroyChart('chartGenero');
  charts['chartGenero']=new Chart(document.getElementById('chartGenero'),{
    type:'bar',
    data:{labels:carreras.map(short),datasets:[
      {label:'Femenino',data:carreras.map(c=>fMap[c]||0),backgroundColor:CF,borderRadius:3},
      {label:'Masculino',data:carreras.map(c=>mMap[c]||0),backgroundColor:CM,borderRadius:3}
    ]},
    options:{responsive:true,maintainAspectRatio:false,indexAxis:'y',
      plugins:{legend:{position:'top',labels:{padding:12,usePointStyle:true,color:'#3d5c3d',font:{weight:'600'}}},tooltip:{...TT,borderColor:'var(--verde)',callbacks:{label:ctx=>` ${ctx.dataset.label}: ${ctx.parsed.x} estudiantes`}}},
      scales:{x:{grid:{color:'rgba(27,163,51,0.06)'},ticks:{color:'#6b8a6b',font:{weight:'600'}}},y:{grid:{color:'rgba(27,163,51,0.04)'},ticks:{font:{size:9,weight:'600'},color:'#3d5c3d'}}}
    }
  });
}

function buildTrend(){
  const labels=['2024-P1','2024-P2','2024-P3','2025-P1','2025-P2','2025-P3'];
  const fData=RAW_TREND.filter(d=>d.sexo==='F').map(d=>d.nota);
  const mData=RAW_TREND.filter(d=>d.sexo==='M').map(d=>d.nota);
  destroyChart('chartTrend');
  charts['chartTrend']=new Chart(document.getElementById('chartTrend'),{
    type:'line',
    data:{labels,datasets:[
      {label:'Femenino',data:fData,borderColor:'rgb(212,71,138)',backgroundColor:'rgba(212,71,138,0.08)',tension:0.4,fill:true,pointRadius:5,pointHoverRadius:7,borderWidth:2},
      {label:'Masculino',data:mData,borderColor:'rgb(0,148,233)',backgroundColor:'rgba(0,148,233,0.08)',tension:0.4,fill:true,pointRadius:5,pointHoverRadius:7,borderWidth:2}
    ]},
    options:{responsive:true,maintainAspectRatio:false,
      plugins:{legend:{position:'top',labels:{padding:12,usePointStyle:true,color:'#3d5c3d',font:{weight:'600'}}},tooltip:{...TT,borderColor:'var(--verde)',callbacks:{label:ctx=>` ${ctx.dataset.label}: ${ctx.parsed.y} pts`}}},
      scales:{x:{grid:{color:'rgba(27,163,51,0.06)'},ticks:{color:'#6b8a6b',font:{weight:'600'}}},y:{min:68,max:78,grid:{color:'rgba(27,163,51,0.08)'},ticks:{callback:v=>v+' pts',color:'#6b8a6b',font:{weight:'600'}}}}
    }
  });
}

function buildGenderGap(avgF,avgM){
  const fMap=Object.fromEntries(avgF.map(d=>[d.carrera,d.nota_avg]));
  const mMap=Object.fromEntries(avgM.map(d=>[d.carrera,d.nota_avg]));
  const carreras=[...new Set([...avgF.map(d=>d.carrera),...avgM.map(d=>d.carrera)])];
  const container=document.getElementById('gapContainer'); container.innerHTML='';
  carreras.forEach(c=>{
    const f=fMap[c],m=mMap[c]; if(!f&&!m) return;
    const diff=f&&m?(f-m).toFixed(1):'—';
    const diffColor=parseFloat(diff)>0?'var(--fem)':'var(--mas)';
    const row=document.createElement('div'); row.className='gap-row';
    row.innerHTML=`
      <div class="gap-label" title="${c}">${c} <span style="color:${diffColor};font-size:10px;font-family:'Montserrat',sans-serif;font-weight:700">(Δ ${diff>0?'+'+diff:diff})</span></div>
      <div class="gap-bars">
        ${f!==undefined?`<div class="gap-bar-wrap"><div class="gap-bar f" style="width:${(f/100*100).toFixed(1)}%"></div></div><span class="gap-val f">${f}</span>`:'<div class="gap-bar-wrap"></div><span class="gap-val f">—</span>'}
        ${m!==undefined?`<div class="gap-bar-wrap"><div class="gap-bar m" style="width:${(m/100*100).toFixed(1)}%"></div></div><span class="gap-val m">${m}</span>`:'<div class="gap-bar-wrap"></div><span class="gap-val m">—</span>'}
      </div>`;
    container.appendChild(row);
  });
}

function buildRepTabla(){
  const data=activeFilters.carrera==='all'?RAW_REP:RAW_REP.filter(d=>d.carrera===activeFilters.carrera);
  const maxRep=Math.max(...data.map(d=>d.rep));
  const tbody=document.getElementById('repTablaBody'); tbody.innerHTML='';
  data.slice(0,20).forEach(d=>{
    const pct=(d.rep/maxRep*100).toFixed(1);
    const tr=document.createElement('tr');
    tr.innerHTML=`<td class="asig-name" title="${d.asignatura}">${d.asignatura}</td><td><span class="carrera-tag" title="${d.carrera}">${d.carrera}</span></td><td class="rep-count">${d.rep}</td><td><div class="bar-inline" style="width:${pct}px;max-width:80px"></div></td>`;
    tbody.appendChild(tr);
  });
}

function buildSuficiencias(){
  const suf=activeFilters.sexo==='all'?RAW_SUF:RAW_SUF.filter(d=>d.sexo===activeFilters.sexo);
  const carreras=[...new Set(suf.map(d=>d.carrera))];
  const fMap=Object.fromEntries(RAW_SUF.filter(d=>d.sexo==='F').map(d=>[d.carrera,d.suf]));
  const mMap=Object.fromEntries(RAW_SUF.filter(d=>d.sexo==='M').map(d=>[d.carrera,d.suf]));
  const short=c=>c.length>25?c.substring(0,23)+'…':c;
  destroyChart('chartSuficiencias');
  charts['chartSuficiencias']=new Chart(document.getElementById('chartSuficiencias'),{
    type:'bar',
    data:{labels:carreras.map(short),datasets:[
      {label:'Femenino',data:carreras.map(c=>fMap[c]||0),backgroundColor:CF,borderRadius:4},
      {label:'Masculino',data:carreras.map(c=>mMap[c]||0),backgroundColor:CM,borderRadius:4}
    ]},
    options:{responsive:true,maintainAspectRatio:false,
      plugins:{legend:{position:'top',labels:{padding:12,usePointStyle:true,color:'#3d5c3d',font:{weight:'600'}}},tooltip:{...TT,borderColor:'var(--verde)',callbacks:{label:ctx=>` ${ctx.dataset.label}: ${ctx.parsed.y} exámenes`}}},
      scales:{x:{grid:{color:'rgba(27,163,51,0.06)'},ticks:{maxRotation:35,font:{size:10,weight:'600'},color:'#6b8a6b'}},y:{grid:{color:'rgba(27,163,51,0.08)'},ticks:{color:'#6b8a6b',font:{weight:'600'}}}}
    }
  });
}

function buildBubble(avgF,avgM,aprF,aprM,estF,estM){
  const carreras=[...new Set(avgF.map(d=>d.carrera))];
  const fAvgMap=Object.fromEntries(avgF.map(d=>[d.carrera,d.nota_avg]));
  const mAvgMap=Object.fromEntries(avgM.map(d=>[d.carrera,d.nota_avg]));
  const fAprMap=Object.fromEntries(aprF.map(d=>[d.carrera,d.tasa_apr*100]));
  const mAprMap=Object.fromEntries(aprM.map(d=>[d.carrera,d.tasa_apr*100]));
  const fEstMap=Object.fromEntries(estF.map(d=>[d.carrera,d.estudiantes]));
  const mEstMap=Object.fromEntries(estM.map(d=>[d.carrera,d.estudiantes]));
  const maxEst=Math.max(...carreras.map(c=>(fEstMap[c]||0)+(mEstMap[c]||0)));
  const dataF=carreras.map(c=>({x:fAvgMap[c]||null,y:fAprMap[c]||null,r:Math.max(4,(fEstMap[c]||0)/maxEst*30),label:c})).filter(d=>d.x&&d.y);
  const dataM=carreras.map(c=>({x:mAvgMap[c]||null,y:mAprMap[c]||null,r:Math.max(4,(mEstMap[c]||0)/maxEst*30),label:c})).filter(d=>d.x&&d.y);
  destroyChart('chartBubble');
  charts['chartBubble']=new Chart(document.getElementById('chartBubble'),{
    type:'bubble',
    data:{datasets:[
      {label:'Femenino',data:dataF,backgroundColor:CF,borderColor:'rgba(212,71,138,0.8)',borderWidth:1},
      {label:'Masculino',data:dataM,backgroundColor:CM,borderColor:'rgba(0,148,233,0.8)',borderWidth:1}
    ]},
    options:{responsive:true,maintainAspectRatio:false,
      plugins:{legend:{position:'top',labels:{padding:12,usePointStyle:true,color:'#3d5c3d',font:{weight:'600'}}},tooltip:{...TT,borderColor:'var(--verde)',callbacks:{title:ctx=>ctx[0].raw.label,label:ctx=>[` Promedio: ${ctx.parsed.x?.toFixed(1)} pts`,` Aprobación: ${ctx.parsed.y?.toFixed(1)}%`]}}},
      scales:{x:{min:60,max:95,grid:{color:'rgba(27,163,51,0.06)'},ticks:{color:'#6b8a6b',font:{weight:'600'}},title:{display:true,text:'Nota Promedio',color:'#6b8a6b',font:{weight:'700'}}},y:{min:80,max:105,grid:{color:'rgba(27,163,51,0.08)'},ticks:{callback:v=>v+'%',color:'#6b8a6b',font:{weight:'600'}},title:{display:true,text:'Tasa Aprobación (%)',color:'#6b8a6b',font:{weight:'700'}}}}
    }
  });
}
</script>
</body>
</html>