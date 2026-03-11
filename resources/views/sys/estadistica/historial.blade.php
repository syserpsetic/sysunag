<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Historial Académico — UNAG</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Mono:wght@400;500&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="shortcut icon" href="{{ asset('/favicon.png') }}">
<style>
/* ══ TOKENS ══ */
:root {
  --bg:           #0b0f1a;
  --surface:      #111827;
  --surface2:     #1a2236;
  --border:       #1f2d45;
  --accent-f:     #f472b6;
  --accent-m:     #38bdf8;
  --accent-gold:  #fbbf24;
  --accent-green: #34d399;
  --accent-red:   #f87171;
  --text:         #e2e8f0;
  --text-muted:   #64748b;
  --text-dim:     #94a3b8;
  --radius:       12px;
  --gap:          16px;
  --pad-x:        clamp(12px, 4vw, 40px);
}

/* ══ RESET ══ */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body {
  background: var(--bg);
  color: var(--text);
  font-family: sans-serif;
  min-height: 100vh;
  overflow-x: hidden;
  -webkit-text-size-adjust: 100%;
}
img { max-width: 100%; display: block; }

/* ══ SCROLLBAR ══ */
::-webkit-scrollbar { width: 4px; height: 4px; }
::-webkit-scrollbar-track { background: var(--surface2); }
::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }

/* ══════════════════════════════════════
   HEADER
══════════════════════════════════════ */
.header {
  background: linear-gradient(135deg,#0b0f1a 0%,#111827 60%,#0f172a 100%);
  border-bottom: 1px solid var(--border);
  padding: 0 var(--pad-x);
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 12px;
  min-height: 58px;
  position: sticky;
  top: 0;
  z-index: 100;
  backdrop-filter: blur(12px);
  flex-wrap: wrap;
}
.header-left { display: flex; align-items: center; gap: 12px; flex-shrink: 0; }
.logo-badge img { width: 40px; height: auto; }
.header-title {
  font-family:sans-serif; font-weight:800; font-size:18px; letter-spacing:-0.5px;
}
.header-title span { color: #f0b429; }
.header-right {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-wrap: wrap;
}
.descarga {
  background: rgba(240,180,41,0.12);
  color: #f0b429;
  border: 1px solid rgba(240,180,41,0.3);
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 500;
  white-space: nowrap;
  transition: background .2s;
}
.descarga:hover { background: rgba(240,180,41,0.22); }

/* ══════════════════════════════════════
   TITLE BLOCK
══════════════════════════════════════ */
.container { max-width: 1440px; margin: 0 auto; padding: 20px var(--pad-x) 0; }
.title-block { padding-bottom: 4px; }
.eyebrow {
  font-family: sans-serif;
  font-size: clamp(9px, 1.5vw, 11px);
  letter-spacing: 0.15em;
  color: #f0b429;
  text-transform: uppercase;
  line-height: 1.6;
}
.title-block h1 {
 font-family:sans-serif; ont-size: clamp(22px, 3vw, 36px); font-weight:800; letter-spacing:-0.5px;
}
.title-block p { font-size: 13px; color: var(--text-muted); margin-top: 2px; }

/* ══════════════════════════════════════
   FILTERS
══════════════════════════════════════ */
.filters {
  padding: 12px var(--pad-x);
  background: var(--surface);
  border-bottom: 1px solid var(--border);
  display: flex;
  gap: 10px;
  align-items: center;
  flex-wrap: wrap;
}
.filter-label {
  font-size: 11px;
  color: var(--text-muted);
  font-family: sans-serif;
  text-transform: uppercase;
  letter-spacing: 0.8px;
  white-space: nowrap;
}
select {
  background: var(--surface2);
  border: 1px solid var(--border);
  color: var(--text);
  padding: 7px 28px 7px 12px;
  border-radius: 8px;
  font-size: 13px;
  font-family: 'DM Sans', sans-serif;
  appearance: none;
  cursor: pointer;
  min-width: 140px;
  flex: 1 1 140px;
  max-width: 240px;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 10px center;
  transition: border-color .2s;
}
select:focus { outline: none; border-color: var(--accent-m); }
.btn-reset {
  padding: 7px 14px;
  background: transparent;
  border: 1px solid var(--border);
  border-radius: 8px;
  color: var(--text-muted);
  font-size: 12px;
  cursor: pointer;
  font-family: 'DM Mono', monospace;
  white-space: nowrap;
  transition: all .2s;
}
.btn-reset:hover { border-color: var(--accent-red); color: var(--accent-red); }
.filters-pills { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
.sex-pill {
  display: flex; align-items: center; gap: 5px;
  padding: 5px 12px; border-radius: 100px;
  font-size: 11px; font-weight: 500;
  font-family: 'DM Mono', monospace;
  border: 1px solid; white-space: nowrap;
}
.sex-pill.f { color: var(--accent-f); border-color: rgba(244,114,182,0.3); background: rgba(244,114,182,0.08); }
.sex-pill.m { color: var(--accent-m); border-color: rgba(56,189,248,0.3); background: rgba(56,189,248,0.08); }
.sex-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
.sex-dot.f { background: var(--accent-f); }
.sex-dot.m { background: var(--accent-m); }
.records-count {
  font-family: 'DM Mono', monospace;
  font-size: 11px;
  color: var(--text-muted);
  white-space: nowrap;
  margin-left: auto;
}
.records-count span { color: var(--accent-gold); font-weight: 500; }

/* ══════════════════════════════════════
   MAIN LAYOUT
══════════════════════════════════════ */
.main {
  padding: 20px var(--pad-x) 32px;
  display: flex;
  flex-direction: column;
  gap: var(--gap);
}

/* ══════════════════════════════════════
   KPI STRIP
══════════════════════════════════════ */
.kpi-strip {
  display: grid;
  grid-template-columns: repeat(6, 1fr);
  gap: 12px;
}
.kpi-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 16px 18px;
  position: relative;
  overflow: hidden;
  transition: border-color .2s, transform .2s;
}
.kpi-card:hover { border-color: rgba(56,189,248,0.3); transform: translateY(-2px); }
.kpi-card::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0; height: 2px;
}
.kpi-card.blue::before  { background: linear-gradient(90deg,var(--accent-m),transparent); }
.kpi-card.pink::before  { background: linear-gradient(90deg,var(--accent-f),transparent); }
.kpi-card.gold::before  { background: linear-gradient(90deg,var(--accent-gold),transparent); }
.kpi-card.green::before { background: linear-gradient(90deg,var(--accent-green),transparent); }
.kpi-label {
  font-size: 10px; color: var(--text-muted);
  text-transform: uppercase; letter-spacing: 0.8px;
  font-family: 'DM Mono', monospace; margin-bottom: 6px;
}
.kpi-value {
  font-family: 'Syne', sans-serif;
  font-size: clamp(20px, 2.5vw, 28px);
  font-weight: 800; line-height: 1;
}
.kpi-value.blue  { color: var(--accent-m); }
.kpi-value.pink  { color: var(--accent-f); }
.kpi-value.gold  { color: var(--accent-gold); }
.kpi-value.green { color: var(--accent-green); }
.kpi-sub { font-size: 10px; color: var(--text-muted); margin-top: 5px; }

/* ══════════════════════════════════════
   GRID ROWS
══════════════════════════════════════ */
.row { display: grid; gap: var(--gap); }
.row-2   { grid-template-columns: 1fr 1fr; }
.row-3   { grid-template-columns: 1fr 1fr 1fr; }
.row-1-2 { grid-template-columns: 1fr 2fr; }
.row-2-1 { grid-template-columns: 2fr 1fr; }

/* ══════════════════════════════════════
   PANEL
══════════════════════════════════════ */
.panel {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 14px;
  padding: 20px 22px;
  display: flex;
  flex-direction: column;
  gap: 14px;
  min-height: 0;
}
.panel-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 8px; }
.panel-title {
  font-family: 'Syne', sans-serif;
  font-weight: 700;
  font-size: clamp(12px, 1.5vw, 14px);
  letter-spacing: -0.2px;
}
.panel-sub { font-size: 11px; color: var(--text-muted); margin-top: 3px; font-family: 'DM Mono', monospace; }
.panel-badge {
  font-family: 'DM Mono', monospace; font-size: 10px;
  padding: 3px 8px; border-radius: 6px; flex-shrink: 0;
  background: rgba(56,189,248,0.1); color: var(--accent-m);
  border: 1px solid rgba(56,189,248,0.2);
}
.chart-wrap { position: relative; min-height: 0; width: 100%; }
.chart-wrap canvas { width: 100% !important; }

/* ══════════════════════════════════════
   TABLE
══════════════════════════════════════ */
.table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }
.rep-table { width: 100%; border-collapse: collapse; font-size: 12px; min-width: 360px; }
.rep-table th {
  font-family: 'DM Mono', monospace; font-size: 10px;
  text-transform: uppercase; letter-spacing: 0.6px;
  color: var(--text-muted); padding: 6px 8px;
  border-bottom: 1px solid var(--border);
  text-align: left; font-weight: 500; white-space: nowrap;
}
.rep-table td { padding: 7px 8px; border-bottom: 1px solid rgba(31,45,69,0.5); vertical-align: middle; }
.rep-table tr:last-child td { border-bottom: none; }
.rep-table tr:hover td { background: rgba(56,189,248,0.04); }
.bar-inline { height: 6px; border-radius: 3px; background: var(--accent-red); display: inline-block; opacity: 0.75; }
.asig-name { max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: var(--text-dim); }
.rep-count { font-family: 'DM Mono', monospace; color: var(--accent-red); font-weight: 500; }
.carrera-tag {
  display: inline-block; padding: 2px 6px; border-radius: 4px;
  font-size: 9px; font-family: 'DM Mono', monospace;
  background: rgba(56,189,248,0.1); color: var(--accent-m);
  max-width: 130px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}

/* ══════════════════════════════════════
   GENDER GAP BARS
══════════════════════════════════════ */
.gender-gap { display: flex; flex-direction: column; gap: 10px; overflow-y: auto; max-height: 320px; }
.gap-row { display: flex; flex-direction: column; gap: 4px; }
.gap-label {
  font-size: 11px; color: var(--text-dim);
  overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
.gap-bars { display: flex; gap: 6px; align-items: center; }
.gap-bar-wrap { flex: 1; height: 8px; background: var(--surface2); border-radius: 4px; overflow: hidden; min-width: 0; }
.gap-bar { height: 100%; border-radius: 4px; transition: width .6s ease; }
.gap-bar.f { background: var(--accent-f); }
.gap-bar.m { background: var(--accent-m); }
.gap-val { font-family: 'DM Mono', monospace; font-size: 10px; width: 34px; text-align: right; flex-shrink: 0; }
.gap-val.f { color: var(--accent-f); }
.gap-val.m { color: var(--accent-m); }

/* ══════════════════════════════════════
   FOOTER
══════════════════════════════════════ */
footer {
  border-top: 1px solid var(--border);
  padding: 20px var(--pad-x);
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 8px;
  font-size: 10px;
  color: var(--text-muted);
  letter-spacing: 0.08em;
}

/* ══════════════════════════════════════
   ANIMATIONS
══════════════════════════════════════ */
@keyframes fadeIn { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }
.kpi-card { animation: fadeIn .4s ease both; }
.kpi-card:nth-child(1){ animation-delay:.04s; }
.kpi-card:nth-child(2){ animation-delay:.08s; }
.kpi-card:nth-child(3){ animation-delay:.12s; }
.kpi-card:nth-child(4){ animation-delay:.16s; }
.kpi-card:nth-child(5){ animation-delay:.20s; }
.kpi-card:nth-child(6){ animation-delay:.24s; }

/* ══════════════════════════════════════
   RESPONSIVE — TABLET  ≤1100px
══════════════════════════════════════ */
@media (max-width: 1100px) {
  .kpi-strip        { grid-template-columns: repeat(3, 1fr); }
  .row-3            { grid-template-columns: 1fr 1fr; }
  .row-2-1,
  .row-1-2          { grid-template-columns: 1fr; }
  .row-2            { grid-template-columns: 1fr 1fr; }
}

/* ══════════════════════════════════════
   RESPONSIVE — SMALL TABLET  ≤768px
══════════════════════════════════════ */
@media (max-width: 768px) {
  :root { --gap: 12px; }

  /* Header: stack on very small */
  .header { min-height: unset; padding: 10px var(--pad-x); gap: 8px; }
  .header-title { font-size: 15px; }
  .header-right { gap: 6px; }
  .descarga { font-size: 10px; padding: 3px 8px; }

  /* KPIs: 2 columns */
  .kpi-strip { grid-template-columns: repeat(2, 1fr); gap: 10px; }
  .kpi-value { font-size: 24px; }

  /* Grids: full single col */
  .row-2,
  .row-3,
  .row-2-1,
  .row-1-2 { grid-template-columns: 1fr; }

  /* Filters: stack nicely */
  .filters { gap: 8px; padding: 10px var(--pad-x); }
  select { min-width: 0; max-width: 100%; flex: 1 1 calc(50% - 4px); }
  .filter-label { width: 100%; }
  .records-count { margin-left: 0; width: 100%; order: 10; }
  .filters-pills { width: 100%; order: 11; }

  /* Chart heights: shorter on mobile */
  [style*="height:340px"] { height: 260px !important; }
  [style*="height:280px"] { height: 240px !important; }
  [style*="height:260px"] { height: 220px !important; }

  /* Panel padding */
  .panel { padding: 14px 14px; }

  /* Gap bars: allow wrap */
  .gap-label { white-space: normal; font-size: 10px; }
  .gender-gap { max-height: 260px; }
}

/* ══════════════════════════════════════
   RESPONSIVE — MOBILE  ≤480px
══════════════════════════════════════ */
@media (max-width: 480px) {
  :root { --gap: 10px; }

  /* KPIs: 2 columns, compact */
  .kpi-strip { grid-template-columns: repeat(2, 1fr); gap: 8px; }
  .kpi-card { padding: 12px 14px; }
  .kpi-value { font-size: 20px; }
  .kpi-sub  { display: none; } /* save space */

  /* Header: hide subtitle */
  .header-sub { display: none; }

  /* Selects full width */
  select { flex: 1 1 100%; max-width: 100%; }

  /* Titles */
  .title-block h1 { font-size: 18px; }

  /* Charts compact */
  [style*="height:340px"] { height: 220px !important; }
  [style*="height:280px"] { height: 200px !important; }
  [style*="height:260px"] { height: 190px !important; }

  /* Panel badge: hide on small */
  .panel-badge { display: none; }
}
</style>
</head>
<body>

<!-- ─── HEADER ─── -->
<div class="header">
  <div class="header-left">
    <div class="logo-badge">
      <img src="https://sys.unag.edu.hn/assets/images/escudo.png" width="36" alt="UNAG">
    </div>
    <div>
      <div class="header-title">HISTORIAL <span>ACADÉMICO</span></div>
    </div>
  </div>
  <div class="header-right">
    <a style="text-decoration:none;" href="https://docs.google.com/spreadsheets/d/1-SmWPUwYXmOVEdcjU2Glp2DqPbO11IDc/edit?usp=sharing&ouid=107873820056887281186&rtpof=true&sd=true" target="_blank">
      <span class="descarga">Descargar Muestra Excel</span>
    </a>
    <a style="text-decoration:none;" href="https://drive.google.com/file/d/11DYVKAsvCNMerOCXuxs_LnTIqrkMJ0Sf/view?usp=sharing" target="_blank">
      <span class="descarga">Descargar Análisis PDF</span>
    </a>
  </div>
</div>

<!-- ─── CONTAINER ─── -->
<div class="container">
  <div class="title-block">
    <div class="eyebrow">Análisis Académico · Universidad Nacional de Agricultura (UNAG)</div>
    <h1>Dashboard — Historial Académico de Estudiantes</h1>
    <div class="eyebrow">Unidad de Análisis · Secretaría de Tecnología de la Información y Comunicaciones (SETIC)</div>
    <p style="color:#64748b;margin-top:4px;">UNAG · Historiales Estudiantiles · 2024–2025</p>
    <br>
  </div>

  <!-- ─── FILTERS ─── -->
  <div class="filters">
    <span class="filter-label">Filtrar por</span>
    <select id="filterCarrera" onchange="applyFilters()">
      <option value="all">Todas las carreras</option>
    </select>
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
    <div class="filters-pills">
      <div class="sex-pill f"><div class="sex-dot f"></div>Femenino</div>
      <div class="sex-pill m"><div class="sex-dot m"></div>Masculino</div>
    </div>
    <div class="records-count">Mostrando <span id="recCount">256,565</span> registros</div>
  </div>

  <!-- ─── MAIN ─── -->
  <div class="main">

    <!-- KPIs -->
    <div class="kpi-strip">
      <div class="kpi-card blue">
        <div class="kpi-label">Total Registros</div>
        <div class="kpi-value blue" id="kpi-registros">256,565</div>
        <div class="kpi-sub">Calificaciones registradas</div>
      </div>
      <div class="kpi-card blue">
        <div class="kpi-label">Estudiantes</div>
        <div class="kpi-value blue" id="kpi-estudiantes">3,984</div>
        <div class="kpi-sub">Matrículas únicas</div>
      </div>
      <div class="kpi-card gold">
        <div class="kpi-label">Nota Promedio</div>
        <div class="kpi-value gold" id="kpi-promedio">72.12</div>
        <div class="kpi-sub">Sobre 100 puntos</div>
      </div>
      <div class="kpi-card green">
        <div class="kpi-label">Tasa Aprobación</div>
        <div class="kpi-value green" id="kpi-aprobacion">92.1%</div>
        <div class="kpi-sub">Nota ≥ 60</div>
      </div>
      <div class="kpi-card pink">
        <div class="kpi-label">Estudiantes F</div>
        <div class="kpi-value pink" id="kpi-f">1,706</div>
        <div class="kpi-sub" id="kpi-f-pct">42.8% del total</div>
      </div>
      <div class="kpi-card blue">
        <div class="kpi-label">Estudiantes M</div>
        <div class="kpi-value blue" id="kpi-m">2,278</div>
        <div class="kpi-sub" id="kpi-m-pct">57.2% del total</div>
      </div>
    </div>

    <!-- ROW 1: Nota promedio + Distribución rangos -->
    <div class="row row-2-1">
      <div class="panel">
        <div class="panel-header">
          <div>
            <div class="panel-title">Nota Promedio por Carrera y Sexo</div>
            <div class="panel-sub">Comparativa F vs M — escala 0–100</div>
          </div>
          <div class="panel-badge">Bar Chart</div>
        </div>
        <div class="chart-wrap" style="height:340px">
          <canvas id="chartBarCarrera"></canvas>
        </div>
      </div>
      <div class="panel">
        <div class="panel-header">
          <div>
            <div class="panel-title">Distribución de Notas</div>
            <div class="panel-sub">Rangos por sexo</div>
          </div>
        </div>
        <div class="chart-wrap" style="height:340px">
          <canvas id="chartDistRangos"></canvas>
        </div>
      </div>
    </div>

    <!-- ROW 2: Aprobación + Género + Tendencia -->
    <div class="row row-3">
      <div class="panel">
        <div class="panel-header">
          <div>
            <div class="panel-title">Tasa de Aprobación</div>
            <div class="panel-sub">Por carrera y sexo (%)</div>
          </div>
        </div>
        <div class="chart-wrap" style="height:280px">
          <canvas id="chartAprobacion"></canvas>
        </div>
      </div>
      <div class="panel">
        <div class="panel-header">
          <div>
            <div class="panel-title">Composición por Género</div>
            <div class="panel-sub">Estudiantes F vs M por carrera</div>
          </div>
        </div>
        <div class="chart-wrap" style="height:280px">
          <canvas id="chartGenero"></canvas>
        </div>
      </div>
      <div class="panel">
        <div class="panel-header">
          <div>
            <div class="panel-title">Tendencia Temporal</div>
            <div class="panel-sub">Promedio por período académico</div>
          </div>
        </div>
        <div class="chart-wrap" style="height:280px">
          <canvas id="chartTrend"></canvas>
        </div>
      </div>
    </div>

    <!-- ROW 3: Brecha género + Top reprobadas -->
    <div class="row row-1-2">
      <div class="panel">
        <div class="panel-header">
          <div>
            <div class="panel-title">Brecha de Género en Rendimiento</div>
            <div class="panel-sub">Nota promedio F vs M por carrera</div>
          </div>
        </div>
        <div class="gender-gap" id="gapContainer"></div>
      </div>
      <div class="panel">
        <div class="panel-header">
          <div>
            <div class="panel-title">Asignaturas con Más Reprobaciones</div>
            <div class="panel-sub">Top 5 por carrera — nota &lt; 60</div>
          </div>
        </div>
        <div class="table-scroll" style="max-height:340px;">
          <table class="rep-table">
            <thead>
              <tr>
                <th>Asignatura</th>
                <th>Carrera</th>
                <th>Reprobaciones</th>
                <th>Escala</th>
              </tr>
            </thead>
            <tbody id="repTablaBody"></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- ROW 4: Suficiencias + Burbuja -->
    <div class="row row-2">
      <div class="panel">
        <div class="panel-header">
          <div>
            <div class="panel-title">Exámenes de Suficiencia por Carrera</div>
            <div class="panel-sub">Distribución por sexo</div>
          </div>
        </div>
        <div class="chart-wrap" style="height:260px">
          <canvas id="chartSuficiencias"></canvas>
        </div>
      </div>
      <div class="panel">
        <div class="panel-header">
          <div>
            <div class="panel-title">Aprobación vs. Rendimiento Promedio</div>
            <div class="panel-sub">Burbuja por carrera — tamaño = nº estudiantes</div>
          </div>
        </div>
        <div class="chart-wrap" style="height:260px">
          <canvas id="chartBubble"></canvas>
        </div>
      </div>
    </div>

  </div><!-- /main -->

  <footer>
    <span>Dashboard Analítico · Historial Académico, muestra a <span id="footerDate"></span></span>
    <div> <img src="https://setic.unag.edu.hn/img/logo-setic-blanco.png" style="width: 200px;" alt="setic"> </div>
  </footer>

</div><!-- /container -->

<script>
/* ══ DATA ══ */
const RAW_AVG = [{"carrera":"Administración de Empresas Agropecuarias","sexo":"F","nota_avg":75.78},{"carrera":"Administración de Empresas Agropecuarias","sexo":"M","nota_avg":71.13},{"carrera":"Economía Social Agraria","sexo":"F","nota_avg":73.11},{"carrera":"Economía Social Agraria","sexo":"M","nota_avg":69.89},{"carrera":"Ingeniería Agronómica","sexo":"F","nota_avg":72.1},{"carrera":"Ingeniería Agronómica","sexo":"M","nota_avg":70.56},{"carrera":"Ing. en Agroexportación","sexo":"F","nota_avg":73.37},{"carrera":"Ing. en Agroexportación","sexo":"M","nota_avg":70.71},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"F","nota_avg":70.62},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"M","nota_avg":67.4},{"carrera":"Ing. Tecnología Alimentaria","sexo":"F","nota_avg":74.91},{"carrera":"Ing. Tecnología Alimentaria","sexo":"M","nota_avg":72.03},{"carrera":"Ingeniería en Zootecnia","sexo":"F","nota_avg":73.9},{"carrera":"Ingeniería en Zootecnia","sexo":"M","nota_avg":72.74},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"F","nota_avg":90.47},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"M","nota_avg":89.67},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"F","nota_avg":87.47},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"M","nota_avg":88.74},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"F","nota_avg":87.23},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"M","nota_avg":81.84},{"carrera":"Maestría en Suelos","sexo":"F","nota_avg":88.06},{"carrera":"Maestría en Suelos","sexo":"M","nota_avg":81.23},{"carrera":"Medicina Veterinaria","sexo":"F","nota_avg":77.36},{"carrera":"Medicina Veterinaria","sexo":"M","nota_avg":74.64}];
const RAW_APR = [{"carrera":"Administración de Empresas Agropecuarias","sexo":"F","tasa_apr":0.9389},{"carrera":"Administración de Empresas Agropecuarias","sexo":"M","tasa_apr":0.8596},{"carrera":"Economía Social Agraria","sexo":"F","tasa_apr":0.8959},{"carrera":"Economía Social Agraria","sexo":"M","tasa_apr":0.9021},{"carrera":"Ingeniería Agronómica","sexo":"F","tasa_apr":0.9316},{"carrera":"Ingeniería Agronómica","sexo":"M","tasa_apr":0.9127},{"carrera":"Ing. en Agroexportación","sexo":"F","tasa_apr":0.8824},{"carrera":"Ing. en Agroexportación","sexo":"M","tasa_apr":0.8674},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"F","tasa_apr":0.9181},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"M","tasa_apr":0.872},{"carrera":"Ing. Tecnología Alimentaria","sexo":"F","tasa_apr":0.9515},{"carrera":"Ing. Tecnología Alimentaria","sexo":"M","tasa_apr":0.9237},{"carrera":"Ingeniería en Zootecnia","sexo":"F","tasa_apr":0.9295},{"carrera":"Ingeniería en Zootecnia","sexo":"M","tasa_apr":0.9299},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"F","tasa_apr":1.0},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"M","tasa_apr":0.9851},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"F","tasa_apr":1.0},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"M","tasa_apr":0.9974},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"F","tasa_apr":0.9839},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"M","tasa_apr":0.9858},{"carrera":"Maestría en Suelos","sexo":"F","tasa_apr":1.0},{"carrera":"Maestría en Suelos","sexo":"M","tasa_apr":0.9302},{"carrera":"Medicina Veterinaria","sexo":"F","tasa_apr":0.9599},{"carrera":"Medicina Veterinaria","sexo":"M","tasa_apr":0.9385}];
const RAW_EST = [{"carrera":"Administración de Empresas Agropecuarias","sexo":"F","estudiantes":162},{"carrera":"Administración de Empresas Agropecuarias","sexo":"M","estudiantes":111},{"carrera":"Economía Social Agraria","sexo":"F","estudiantes":76},{"carrera":"Economía Social Agraria","sexo":"M","estudiantes":47},{"carrera":"Ingeniería Agronómica","sexo":"F","estudiantes":486},{"carrera":"Ingeniería Agronómica","sexo":"M","estudiantes":1208},{"carrera":"Ing. en Agroexportación","sexo":"F","estudiantes":45},{"carrera":"Ing. en Agroexportación","sexo":"M","estudiantes":53},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"F","estudiantes":188},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"M","estudiantes":202},{"carrera":"Ing. Tecnología Alimentaria","sexo":"F","estudiantes":281},{"carrera":"Ing. Tecnología Alimentaria","sexo":"M","estudiantes":198},{"carrera":"Ingeniería en Zootecnia","sexo":"F","estudiantes":176},{"carrera":"Ingeniería en Zootecnia","sexo":"M","estudiantes":243},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"F","estudiantes":8},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"M","estudiantes":13},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"F","estudiantes":12},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"M","estudiantes":26},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"F","estudiantes":13},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"M","estudiantes":17},{"carrera":"Maestría en Suelos","sexo":"F","estudiantes":4},{"carrera":"Maestría en Suelos","sexo":"M","estudiantes":14},{"carrera":"Medicina Veterinaria","sexo":"F","estudiantes":255},{"carrera":"Medicina Veterinaria","sexo":"M","estudiantes":146}];
const RAW_DIST = [{"carrera":"Administración de Empresas Agropecuarias","sexo":"F","rango":"<60","count":557},{"carrera":"Administración de Empresas Agropecuarias","sexo":"F","rango":"60-69","count":2270},{"carrera":"Administración de Empresas Agropecuarias","sexo":"F","rango":"70-79","count":2056},{"carrera":"Administración de Empresas Agropecuarias","sexo":"F","rango":"80-89","count":2259},{"carrera":"Administración de Empresas Agropecuarias","sexo":"F","rango":"90-100","count":1970},{"carrera":"Administración de Empresas Agropecuarias","sexo":"M","rango":"<60","count":757},{"carrera":"Administración de Empresas Agropecuarias","sexo":"M","rango":"60-69","count":1327},{"carrera":"Administración de Empresas Agropecuarias","sexo":"M","rango":"70-79","count":1293},{"carrera":"Administración de Empresas Agropecuarias","sexo":"M","rango":"80-89","count":1145},{"carrera":"Administración de Empresas Agropecuarias","sexo":"M","rango":"90-100","count":870},{"carrera":"Economía Social Agraria","sexo":"F","rango":"<60","count":479},{"carrera":"Economía Social Agraria","sexo":"F","rango":"60-69","count":1164},{"carrera":"Economía Social Agraria","sexo":"F","rango":"70-79","count":1115},{"carrera":"Economía Social Agraria","sexo":"F","rango":"80-89","count":1186},{"carrera":"Economía Social Agraria","sexo":"F","rango":"90-100","count":658},{"carrera":"Economía Social Agraria","sexo":"M","rango":"<60","count":293},{"carrera":"Economía Social Agraria","sexo":"M","rango":"60-69","count":999},{"carrera":"Economía Social Agraria","sexo":"M","rango":"70-79","count":904},{"carrera":"Economía Social Agraria","sexo":"M","rango":"80-89","count":602},{"carrera":"Economía Social Agraria","sexo":"M","rango":"90-100","count":194},{"carrera":"Ingeniería Agronómica","sexo":"F","rango":"<60","count":2287},{"carrera":"Ingeniería Agronómica","sexo":"F","rango":"60-69","count":11629},{"carrera":"Ingeniería Agronómica","sexo":"F","rango":"70-79","count":9160},{"carrera":"Ingeniería Agronómica","sexo":"F","rango":"80-89","count":7331},{"carrera":"Ingeniería Agronómica","sexo":"F","rango":"90-100","count":3045},{"carrera":"Ingeniería Agronómica","sexo":"M","rango":"<60","count":7282},{"carrera":"Ingeniería Agronómica","sexo":"M","rango":"60-69","count":31525},{"carrera":"Ingeniería Agronómica","sexo":"M","rango":"70-79","count":22439},{"carrera":"Ingeniería Agronómica","sexo":"M","rango":"80-89","count":16379},{"carrera":"Ingeniería Agronómica","sexo":"M","rango":"90-100","count":5743},{"carrera":"Ing. en Agroexportación","sexo":"F","rango":"<60","count":394},{"carrera":"Ing. en Agroexportación","sexo":"F","rango":"60-69","count":822},{"carrera":"Ing. en Agroexportación","sexo":"F","rango":"70-79","count":913},{"carrera":"Ing. en Agroexportación","sexo":"F","rango":"80-89","count":853},{"carrera":"Ing. en Agroexportación","sexo":"F","rango":"90-100","count":367},{"carrera":"Ing. en Agroexportación","sexo":"M","rango":"<60","count":470},{"carrera":"Ing. en Agroexportación","sexo":"M","rango":"60-69","count":1053},{"carrera":"Ing. en Agroexportación","sexo":"M","rango":"70-79","count":1035},{"carrera":"Ing. en Agroexportación","sexo":"M","rango":"80-89","count":708},{"carrera":"Ing. en Agroexportación","sexo":"M","rango":"90-100","count":279},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"F","rango":"<60","count":1073},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"F","rango":"60-69","count":4932},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"F","rango":"70-79","count":3564},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"F","rango":"80-89","count":2475},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"F","rango":"90-100","count":1051},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"M","rango":"<60","count":1679},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"M","rango":"60-69","count":5646},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"M","rango":"70-79","count":3186},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"M","rango":"80-89","count":1825},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"M","rango":"90-100","count":785},{"carrera":"Ing. Tecnología Alimentaria","sexo":"F","rango":"<60","count":984},{"carrera":"Ing. Tecnología Alimentaria","sexo":"F","rango":"60-69","count":5568},{"carrera":"Ing. Tecnología Alimentaria","sexo":"F","rango":"70-79","count":5986},{"carrera":"Ing. Tecnología Alimentaria","sexo":"F","rango":"80-89","count":5029},{"carrera":"Ing. Tecnología Alimentaria","sexo":"F","rango":"90-100","count":2705},{"carrera":"Ing. Tecnología Alimentaria","sexo":"M","rango":"<60","count":1015},{"carrera":"Ing. Tecnología Alimentaria","sexo":"M","rango":"60-69","count":4548},{"carrera":"Ing. Tecnología Alimentaria","sexo":"M","rango":"70-79","count":3521},{"carrera":"Ing. Tecnología Alimentaria","sexo":"M","rango":"80-89","count":2912},{"carrera":"Ing. Tecnología Alimentaria","sexo":"M","rango":"90-100","count":1308},{"carrera":"Ingeniería en Zootecnia","sexo":"F","rango":"<60","count":859},{"carrera":"Ingeniería en Zootecnia","sexo":"F","rango":"60-69","count":3638},{"carrera":"Ingeniería en Zootecnia","sexo":"F","rango":"70-79","count":3021},{"carrera":"Ingeniería en Zootecnia","sexo":"F","rango":"80-89","count":2878},{"carrera":"Ingeniería en Zootecnia","sexo":"F","rango":"90-100","count":1791},{"carrera":"Ingeniería en Zootecnia","sexo":"M","rango":"<60","count":1275},{"carrera":"Ingeniería en Zootecnia","sexo":"M","rango":"60-69","count":5887},{"carrera":"Ingeniería en Zootecnia","sexo":"M","rango":"70-79","count":4800},{"carrera":"Ingeniería en Zootecnia","sexo":"M","rango":"80-89","count":4093},{"carrera":"Ingeniería en Zootecnia","sexo":"M","rango":"90-100","count":2121},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"F","rango":"70-79","count":3},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"F","rango":"80-89","count":10},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"F","rango":"90-100","count":32},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"M","rango":"<60","count":1},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"M","rango":"70-79","count":6},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"M","rango":"80-89","count":12},{"carrera":"Mtra. Ciencias Agroalimentarias","sexo":"M","rango":"90-100","count":48},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"F","rango":"60-69","count":6},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"F","rango":"70-79","count":31},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"F","rango":"80-89","count":87},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"F","rango":"90-100","count":133},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"M","rango":"<60","count":1},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"M","rango":"60-69","count":2},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"M","rango":"70-79","count":47},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"M","rango":"80-89","count":128},{"carrera":"Mtra. G.P. Animal Sostenible","sexo":"M","rango":"90-100","count":205},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"F","rango":"<60","count":2},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"F","rango":"70-79","count":6},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"F","rango":"80-89","count":57},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"F","rango":"90-100","count":59},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"M","rango":"<60","count":2},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"M","rango":"60-69","count":5},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"M","rango":"70-79","count":39},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"M","rango":"80-89","count":62},{"carrera":"Mtra. RN y Prod. Sostenible","sexo":"M","rango":"90-100","count":33},{"carrera":"Maestría en Suelos","sexo":"F","rango":"80-89","count":7},{"carrera":"Maestría en Suelos","sexo":"F","rango":"90-100","count":9},{"carrera":"Maestría en Suelos","sexo":"M","rango":"<60","count":3},{"carrera":"Maestría en Suelos","sexo":"M","rango":"60-69","count":5},{"carrera":"Maestría en Suelos","sexo":"M","rango":"70-79","count":6},{"carrera":"Maestría en Suelos","sexo":"M","rango":"80-89","count":15},{"carrera":"Maestría en Suelos","sexo":"M","rango":"90-100","count":14},{"carrera":"Medicina Veterinaria","sexo":"F","rango":"<60","count":512},{"carrera":"Medicina Veterinaria","sexo":"F","rango":"60-69","count":2634},{"carrera":"Medicina Veterinaria","sexo":"F","rango":"70-79","count":3535},{"carrera":"Medicina Veterinaria","sexo":"F","rango":"80-89","count":3704},{"carrera":"Medicina Veterinaria","sexo":"F","rango":"90-100","count":2394},{"carrera":"Medicina Veterinaria","sexo":"M","rango":"<60","count":415},{"carrera":"Medicina Veterinaria","sexo":"M","rango":"60-69","count":1687},{"carrera":"Medicina Veterinaria","sexo":"M","rango":"70-79","count":2017},{"carrera":"Medicina Veterinaria","sexo":"M","rango":"80-89","count":1772},{"carrera":"Medicina Veterinaria","sexo":"M","rango":"90-100","count":852}];
const RAW_TREND = [{"anio":2024,"periodo":1,"sexo":"F","nota":72.97},{"anio":2024,"periodo":1,"sexo":"M","nota":70.88},{"anio":2024,"periodo":2,"sexo":"F","nota":72.78},{"anio":2024,"periodo":2,"sexo":"M","nota":69.63},{"anio":2024,"periodo":3,"sexo":"F","nota":73.31},{"anio":2024,"periodo":3,"sexo":"M","nota":70.39},{"anio":2025,"periodo":1,"sexo":"F","nota":73.0},{"anio":2025,"periodo":1,"sexo":"M","nota":69.84},{"anio":2025,"periodo":2,"sexo":"F","nota":76.19},{"anio":2025,"periodo":2,"sexo":"M","nota":73.64},{"anio":2025,"periodo":3,"sexo":"F","nota":74.4},{"anio":2025,"periodo":3,"sexo":"M","nota":71.62}];
const RAW_REP = [{"carrera":"Ingeniería Agronómica","asignatura":"CALCULO I","rep":1068},{"carrera":"Ingeniería Agronómica","asignatura":"MATEMÁTICA GENERAL","rep":861},{"carrera":"Ingeniería Agronómica","asignatura":"GEOMETRÍA Y TRIGONOMETRÍA","rep":720},{"carrera":"Ingeniería Agronómica","asignatura":"ESPAÑOL","rep":680},{"carrera":"Ingeniería Agronómica","asignatura":"BIOLOGÍA","rep":608},{"carrera":"Ing. G.I. Recursos Naturales","asignatura":"MATEMÁTICA GENERAL","rep":448},{"carrera":"Ing. Tecnología Alimentaria","asignatura":"GEOMETRÍA Y TRIGONOMETRÍA","rep":315},{"carrera":"Ing. G.I. Recursos Naturales","asignatura":"QUÍMICA GENERAL","rep":282},{"carrera":"Ingeniería en Zootecnia","asignatura":"MATEMÁTICA GENERAL","rep":238},{"carrera":"Administración de Empresas Agropecuarias","asignatura":"BIOLOGÍA","rep":224},{"carrera":"Ing. G.I. Recursos Naturales","asignatura":"BIOLOGÍA","rep":224},{"carrera":"Ingeniería en Zootecnia","asignatura":"INGLÉS II","rep":216},{"carrera":"Ing. Tecnología Alimentaria","asignatura":"ESPAÑOL","rep":208},{"carrera":"Ing. Tecnología Alimentaria","asignatura":"BIOLOGÍA","rep":208},{"carrera":"Ing. G.I. Recursos Naturales","asignatura":"ESPAÑOL","rep":208},{"carrera":"Ingeniería en Zootecnia","asignatura":"CÁLCULO I","rep":192},{"carrera":"Administración de Empresas Agropecuarias","asignatura":"ESPAÑOL","rep":144},{"carrera":"Administración de Empresas Agropecuarias","asignatura":"MATEMÁTICA GENERAL","rep":140},{"carrera":"Economía Social Agraria","asignatura":"INGLÉS I","rep":136},{"carrera":"Ing. en Agroexportación","asignatura":"MATEMÁTICA GENERAL","rep":182},{"carrera":"Medicina Veterinaria","asignatura":"BIOLOGÍA","rep":96},{"carrera":"Medicina Veterinaria","asignatura":"INGLÉS III","rep":88},{"carrera":"Economía Social Agraria","asignatura":"MATEMÁTICA GENERAL","rep":112},{"carrera":"Ing. en Agroexportación","asignatura":"BIOLOGÍA","rep":112}];
const RAW_SUF = [{"carrera":"Ingeniería Agronómica","sexo":"F","suf":152},{"carrera":"Ingeniería Agronómica","sexo":"M","suf":576},{"carrera":"Ing. en Agroexportación","sexo":"F","suf":24},{"carrera":"Ing. en Agroexportación","sexo":"M","suf":32},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"F","suf":0},{"carrera":"Ing. G.I. Recursos Naturales","sexo":"M","suf":24},{"carrera":"Ing. Tecnología Alimentaria","sexo":"F","suf":160},{"carrera":"Ing. Tecnología Alimentaria","sexo":"M","suf":104},{"carrera":"Ingeniería en Zootecnia","sexo":"F","suf":272},{"carrera":"Ingeniería en Zootecnia","sexo":"M","suf":216},{"carrera":"Medicina Veterinaria","sexo":"F","suf":680},{"carrera":"Medicina Veterinaria","sexo":"M","suf":192}];
const POSGRADOS = ["Mtra. Ciencias Agroalimentarias","Mtra. G.P. Animal Sostenible","Mtra. RN y Prod. Sostenible","Maestría en Suelos"];

const CF = 'rgba(244,114,182,0.85)', CM = 'rgba(56,189,248,0.85)';
Chart.defaults.color = '#64748b';
Chart.defaults.font.family = "'DM Sans', sans-serif";
Chart.defaults.font.size = 11;
const TT = { backgroundColor:'rgba(17,24,39,0.95)', borderColor:'#1f2d45', borderWidth:1, titleFont:{family:"'DM Mono',monospace",size:11}, bodyFont:{family:"'DM Sans',sans-serif",size:12}, padding:10, cornerRadius:8 };

/* ── state ── */
let charts = {}, activeFilters = { carrera:'all', sexo:'all', nivel:'all' };

window.addEventListener('DOMContentLoaded', () => {
  document.getElementById('footerDate').textContent = new Date().toLocaleDateString('es-HN', {year:'numeric',month:'long'});
  populateCarreraFilter();
  buildAll();
});

function populateCarreraFilter() {
  const sel = document.getElementById('filterCarrera');
  [...new Set(RAW_AVG.map(d=>d.carrera))].sort().forEach(c => {
    const o = document.createElement('option');
    o.value = c; o.textContent = c; sel.appendChild(o);
  });
}
function applyFilters() {
  activeFilters.carrera = document.getElementById('filterCarrera').value;
  activeFilters.sexo    = document.getElementById('filterSexo').value;
  activeFilters.nivel   = document.getElementById('filterNivel').value;
  buildAll();
}
function resetFilters() {
  ['filterCarrera','filterSexo','filterNivel'].forEach(id => document.getElementById(id).value = 'all');
  activeFilters = { carrera:'all', sexo:'all', nivel:'all' };
  buildAll();
}
function filterData(arr) {
  return arr.filter(d => {
    const cOk = activeFilters.carrera === 'all' || d.carrera === activeFilters.carrera;
    const sOk = activeFilters.sexo === 'all' || d.sexo === activeFilters.sexo || d.sexo_estudiante === activeFilters.sexo;
    const nOk = activeFilters.nivel === 'all'
      || (activeFilters.nivel==='pre' && !POSGRADOS.includes(d.carrera))
      || (activeFilters.nivel==='pos' && POSGRADOS.includes(d.carrera));
    return cOk && sOk && nOk;
  });
}
function destroyChart(id) { if (charts[id]) { charts[id].destroy(); delete charts[id]; } }

/* ── build all ── */
function buildAll() {
  const avgF = filterData(RAW_AVG.filter(d=>d.sexo==='F')), avgM = filterData(RAW_AVG.filter(d=>d.sexo==='M'));
  const aprF = filterData(RAW_APR.filter(d=>d.sexo==='F')), aprM = filterData(RAW_APR.filter(d=>d.sexo==='M'));
  const estF = filterData(RAW_EST.filter(d=>d.sexo==='F')), estM = filterData(RAW_EST.filter(d=>d.sexo==='M'));
  updateKPIs(avgF,avgM,aprF,aprM,estF,estM);
  buildBarCarrera(avgF,avgM); buildDistRangos(); buildAprobacion(aprF,aprM);
  buildGenero(estF,estM); buildTrend(); buildGenderGap(avgF,avgM);
  buildRepTabla(); buildSuficiencias(); buildBubble(avgF,avgM,aprF,aprM,estF,estM);
}

function updateKPIs(avgF,avgM,aprF,aprM,estF,estM) {
  const allAvg=[...avgF,...avgM], allApr=[...aprF,...aprM];
  const fEst=estF.reduce((s,d)=>s+d.estudiantes,0), mEst=estM.reduce((s,d)=>s+d.estudiantes,0);
  const totalEst=fEst+mEst;
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

function buildBarCarrera(avgF,avgM) {
  const carreras=[...new Set([...avgF.map(d=>d.carrera),...avgM.map(d=>d.carrera)])];
  const fMap=Object.fromEntries(avgF.map(d=>[d.carrera,d.nota_avg]));
  const mMap=Object.fromEntries(avgM.map(d=>[d.carrera,d.nota_avg]));
  const short=c=>c.replace('Ingeniería','Ing.').replace('Administración de Empresas','Adm.').replace('Economía','Econ.').replace('MAESTRIA EN','Mtra.').replace('Medicina','Med.');
  destroyChart('chartBarCarrera');
  charts['chartBarCarrera']=new Chart(document.getElementById('chartBarCarrera'),{
    type:'bar',
    data:{ labels:carreras.map(short), datasets:[
      {label:'Femenino',data:carreras.map(c=>fMap[c]??null),backgroundColor:CF,borderColor:'rgba(244,114,182,1)',borderWidth:1,borderRadius:4},
      {label:'Masculino',data:carreras.map(c=>mMap[c]??null),backgroundColor:CM,borderColor:'rgba(56,189,248,1)',borderWidth:1,borderRadius:4}
    ]},
    options:{ responsive:true,maintainAspectRatio:false,
      plugins:{ legend:{position:'top',labels:{padding:14,usePointStyle:true,pointStyleWidth:10}}, tooltip:{...TT,callbacks:{label:ctx=>` ${ctx.dataset.label}: ${ctx.parsed.y?.toFixed(1)} pts`}} },
      scales:{ x:{grid:{color:'rgba(31,45,69,0.5)'},ticks:{maxRotation:40,font:{size:9}}}, y:{min:55,max:100,grid:{color:'rgba(31,45,69,0.5)'},ticks:{callback:v=>v+' pts'}} }
    }
  });
}

function buildDistRangos() {
  const dist=filterData(RAW_DIST), rangos=['<60','60-69','70-79','80-89','90-100'];
  const colors=['rgba(248,113,113,0.85)','rgba(251,191,36,0.85)','rgba(56,189,248,0.85)','rgba(52,211,153,0.85)','rgba(167,139,250,0.85)'];
  const totF={},totM={};
  rangos.forEach(r=>{totF[r]=0;totM[r]=0;});
  dist.forEach(d=>{ if(d.sexo==='F') totF[d.rango]=(totF[d.rango]||0)+d.count; else if(d.sexo==='M') totM[d.rango]=(totM[d.rango]||0)+d.count; });
  const sumF=Object.values(totF).reduce((a,b)=>a+b,0), sumM=Object.values(totM).reduce((a,b)=>a+b,0);
  const dataSets=activeFilters.sexo==='F'?[{label:'Femenino',data:rangos.map(r=>sumF?+(totF[r]/sumF*100).toFixed(1):0),backgroundColor:colors,borderRadius:4,borderWidth:0}]
    :activeFilters.sexo==='M'?[{label:'Masculino',data:rangos.map(r=>sumM?+(totM[r]/sumM*100).toFixed(1):0),backgroundColor:colors,borderRadius:4,borderWidth:0}]
    :[{label:'Femenino',data:rangos.map(r=>sumF?+(totF[r]/sumF*100).toFixed(1):0),backgroundColor:colors.map(c=>c.replace('0.85','0.5')),borderRadius:4,borderWidth:0},
      {label:'Masculino',data:rangos.map(r=>sumM?+(totM[r]/sumM*100).toFixed(1):0),backgroundColor:colors,borderRadius:4,borderWidth:0}];
  destroyChart('chartDistRangos');
  charts['chartDistRangos']=new Chart(document.getElementById('chartDistRangos'),{
    type:'bar', data:{labels:rangos,datasets:dataSets},
    options:{ responsive:true,maintainAspectRatio:false,
      plugins:{ legend:{position:'top',labels:{padding:12,usePointStyle:true}}, tooltip:{...TT,callbacks:{label:ctx=>` ${ctx.dataset.label}: ${ctx.parsed.y}%`}} },
      scales:{ x:{grid:{color:'rgba(31,45,69,0.5)'}}, y:{grid:{color:'rgba(31,45,69,0.5)'},ticks:{callback:v=>v+'%'}} }
    }
  });
}

function buildAprobacion(aprF,aprM) {
  const carreras=[...new Set([...aprF.map(d=>d.carrera),...aprM.map(d=>d.carrera)])];
  const fMap=Object.fromEntries(aprF.map(d=>[d.carrera,+(d.tasa_apr*100).toFixed(1)]));
  const mMap=Object.fromEntries(aprM.map(d=>[d.carrera,+(d.tasa_apr*100).toFixed(1)]));
  const short=c=>c.length>22?c.substring(0,20)+'…':c;
  destroyChart('chartAprobacion');
  charts['chartAprobacion']=new Chart(document.getElementById('chartAprobacion'),{
    type:'bar',
    data:{ labels:carreras.map(short), datasets:[
      {label:'Femenino',data:carreras.map(c=>fMap[c]??null),backgroundColor:CF,borderRadius:3},
      {label:'Masculino',data:carreras.map(c=>mMap[c]??null),backgroundColor:CM,borderRadius:3}
    ]},
    options:{ responsive:true,maintainAspectRatio:false,indexAxis:'y',
      plugins:{ legend:{position:'top',labels:{padding:12,usePointStyle:true}}, tooltip:{...TT,callbacks:{label:ctx=>` ${ctx.dataset.label}: ${ctx.parsed.x}%`}} },
      scales:{ x:{min:80,max:102,grid:{color:'rgba(31,45,69,0.5)'},ticks:{callback:v=>v+'%'}}, y:{grid:{color:'rgba(31,45,69,0.3)'},ticks:{font:{size:9}}} }
    }
  });
}

function buildGenero(estF,estM) {
  const carreras=[...new Set([...estF.map(d=>d.carrera),...estM.map(d=>d.carrera)])];
  const fMap=Object.fromEntries(estF.map(d=>[d.carrera,d.estudiantes]));
  const mMap=Object.fromEntries(estM.map(d=>[d.carrera,d.estudiantes]));
  const short=c=>c.length>22?c.substring(0,20)+'…':c;
  destroyChart('chartGenero');
  charts['chartGenero']=new Chart(document.getElementById('chartGenero'),{
    type:'bar',
    data:{ labels:carreras.map(short), datasets:[
      {label:'Femenino',data:carreras.map(c=>fMap[c]||0),backgroundColor:CF,borderRadius:3},
      {label:'Masculino',data:carreras.map(c=>mMap[c]||0),backgroundColor:CM,borderRadius:3}
    ]},
    options:{ responsive:true,maintainAspectRatio:false,indexAxis:'y',
      plugins:{ legend:{position:'top',labels:{padding:12,usePointStyle:true}}, tooltip:{...TT,callbacks:{label:ctx=>` ${ctx.dataset.label}: ${ctx.parsed.x} estudiantes`}} },
      scales:{ x:{grid:{color:'rgba(31,45,69,0.5)'}}, y:{grid:{color:'rgba(31,45,69,0.3)'},ticks:{font:{size:9}}} }
    }
  });
}

function buildTrend() {
  const labels=['2024-P1','2024-P2','2024-P3','2025-P1','2025-P2','2025-P3'];
  const fData=RAW_TREND.filter(d=>d.sexo==='F').map(d=>d.nota);
  const mData=RAW_TREND.filter(d=>d.sexo==='M').map(d=>d.nota);
  destroyChart('chartTrend');
  charts['chartTrend']=new Chart(document.getElementById('chartTrend'),{
    type:'line',
    data:{ labels, datasets:[
      {label:'Femenino',data:fData,borderColor:'rgb(244,114,182)',backgroundColor:'rgba(244,114,182,0.1)',tension:0.4,fill:true,pointRadius:5,pointHoverRadius:7},
      {label:'Masculino',data:mData,borderColor:'rgb(56,189,248)',backgroundColor:'rgba(56,189,248,0.1)',tension:0.4,fill:true,pointRadius:5,pointHoverRadius:7}
    ]},
    options:{ responsive:true,maintainAspectRatio:false,
      plugins:{ legend:{position:'top',labels:{padding:12,usePointStyle:true}}, tooltip:{...TT,callbacks:{label:ctx=>` ${ctx.dataset.label}: ${ctx.parsed.y} pts`}} },
      scales:{ x:{grid:{color:'rgba(31,45,69,0.5)'}}, y:{min:68,max:78,grid:{color:'rgba(31,45,69,0.5)'},ticks:{callback:v=>v+' pts'}} }
    }
  });
}

function buildGenderGap(avgF,avgM) {
  const fMap=Object.fromEntries(avgF.map(d=>[d.carrera,d.nota_avg]));
  const mMap=Object.fromEntries(avgM.map(d=>[d.carrera,d.nota_avg]));
  const carreras=[...new Set([...avgF.map(d=>d.carrera),...avgM.map(d=>d.carrera)])];
  const container=document.getElementById('gapContainer');
  container.innerHTML='';
  carreras.forEach(c=>{
    const f=fMap[c],m=mMap[c]; if(!f&&!m) return;
    const diff=f&&m?(f-m).toFixed(1):'—';
    const diffColor=parseFloat(diff)>0?'#f472b6':'#38bdf8';
    const row=document.createElement('div'); row.className='gap-row';
    row.innerHTML=`
      <div class="gap-label" title="${c}">${c} <span style="color:${diffColor};font-size:10px;font-family:'DM Mono',monospace">(Δ ${diff>0?'+'+diff:diff})</span></div>
      <div class="gap-bars">
        ${f!==undefined?`<div class="gap-bar-wrap"><div class="gap-bar f" style="width:${(f/100*100).toFixed(1)}%"></div></div><span class="gap-val f">${f}</span>`:'<div class="gap-bar-wrap"></div><span class="gap-val f">—</span>'}
        ${m!==undefined?`<div class="gap-bar-wrap"><div class="gap-bar m" style="width:${(m/100*100).toFixed(1)}%"></div></div><span class="gap-val m">${m}</span>`:'<div class="gap-bar-wrap"></div><span class="gap-val m">—</span>'}
      </div>`;
    container.appendChild(row);
  });
}

function buildRepTabla() {
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

function buildSuficiencias() {
  const suf=activeFilters.sexo==='all'?RAW_SUF:RAW_SUF.filter(d=>d.sexo===activeFilters.sexo);
  const carreras=[...new Set(suf.map(d=>d.carrera))];
  const fMap=Object.fromEntries(RAW_SUF.filter(d=>d.sexo==='F').map(d=>[d.carrera,d.suf]));
  const mMap=Object.fromEntries(RAW_SUF.filter(d=>d.sexo==='M').map(d=>[d.carrera,d.suf]));
  const short=c=>c.length>25?c.substring(0,23)+'…':c;
  destroyChart('chartSuficiencias');
  charts['chartSuficiencias']=new Chart(document.getElementById('chartSuficiencias'),{
    type:'bar',
    data:{ labels:carreras.map(short), datasets:[
      {label:'Femenino',data:carreras.map(c=>fMap[c]||0),backgroundColor:CF,borderRadius:4},
      {label:'Masculino',data:carreras.map(c=>mMap[c]||0),backgroundColor:CM,borderRadius:4}
    ]},
    options:{ responsive:true,maintainAspectRatio:false,
      plugins:{ legend:{position:'top',labels:{padding:12,usePointStyle:true}}, tooltip:{...TT,callbacks:{label:ctx=>` ${ctx.dataset.label}: ${ctx.parsed.y} exámenes`}} },
      scales:{ x:{grid:{color:'rgba(31,45,69,0.5)'},ticks:{maxRotation:35,font:{size:10}}}, y:{grid:{color:'rgba(31,45,69,0.5)'}} }
    }
  });
}

function buildBubble(avgF,avgM,aprF,aprM,estF,estM) {
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
    data:{ datasets:[
      {label:'Femenino',data:dataF,backgroundColor:CF,borderColor:'rgba(244,114,182,0.8)',borderWidth:1},
      {label:'Masculino',data:dataM,backgroundColor:CM,borderColor:'rgba(56,189,248,0.8)',borderWidth:1}
    ]},
    options:{ responsive:true,maintainAspectRatio:false,
      plugins:{ legend:{position:'top',labels:{padding:12,usePointStyle:true}}, tooltip:{...TT,callbacks:{title:ctx=>ctx[0].raw.label,label:ctx=>[` Promedio: ${ctx.parsed.x?.toFixed(1)} pts`,` Aprobación: ${ctx.parsed.y?.toFixed(1)}%`]}} },
      scales:{ x:{min:60,max:95,grid:{color:'rgba(31,45,69,0.5)'},title:{display:true,text:'Nota Promedio',color:'#64748b'}}, y:{min:80,max:105,grid:{color:'rgba(31,45,69,0.5)'},title:{display:true,text:'Tasa Aprobación (%)',color:'#64748b'},ticks:{callback:v=>v+'%'}} }
    }
  });
}
</script>
</body>
</html>