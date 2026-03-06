<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard de Retención Estudiantil</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="shortcut icon" href="{{ asset('/favicon.png') }}">
<style>
  :root {
    --bg: #0d0f14;
    --accent: #f0b429;
    --surface: #141720;
    --surface2: #1c2030;
    --border: #252a3a;
    --accent-int: #4ade80;
    --accent-ext: #fb923c;
    --accent-grad: #60a5fa;
    --accent-drop: #f87171;
    --text: #e2e8f0;
    --muted: #64748b;
    --highlight: #f1f5f9;
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    background: var(--bg);
    color: var(--text);
    font-family: sans-serif;
    min-height: 100vh;
    padding: 0;
  }

  /* HEADER */
  header {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
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
  .descarga { background:rgba(240,180,41,0.12); color:#f0b429; border:1px solid rgba(240,180,41,0.3); padding:3px 10px; border-radius:20px; font-size:11px; font-weight:500; }

  .logo { font-family:sans-serif; font-weight:800; font-size:18px; letter-spacing:-0.5px; }
  .logo span { color:var(--accent); }
    .eyebrow {
    font-family: sans-serif;
    font-size: 11px;
    letter-spacing: 0.2em;
    color: var(--accent);
    text-transform: uppercase;
    
  }
  .title-block { margin-bottom:20px; }
  .title-block h1 { font-family:sans-serif; ont-size: clamp(22px, 3vw, 36px); font-weight:800; letter-spacing:-0.5px; }
  .title-block p {
    font-size: 13px;
    color: var(--muted);
    margin-top: 4px;
}
  .logo-area h1 {
    font-family: sans-serif;
    font-size: 1.35rem;
    color: var(--highlight);
    letter-spacing: -0.02em;
  }
  .logo-area p {
    font-size: 0.68rem;
    color: var(--muted);
    margin-top: 2px;
    text-transform: uppercase;
    letter-spacing: 0.12em;
  }
  .badge-row {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-left: auto;
  }
  .badge {
    display: flex;
    align-items: center;
    gap: 6px;
    background: var(--surface2);
    border: 1px solid var(--border);
    border-radius: 6px;
    padding: 6px 12px;
    font-size: 0.7rem;
    color: var(--muted);
  }
  .badge strong { color: var(--highlight); font-size: 0.85rem; }
  .dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
  .dot-int { background: var(--accent-int); }
  .dot-ext { background: var(--accent-ext); }

  /* FILTERS */
  .filters {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 12px 32px;
    display: flex;
    gap: 14px;
    align-items: center;
    flex-wrap: wrap;
    justify-content: center;
  }
  .filter-label { font-size: 0.65rem; color: var(--muted); text-transform: uppercase; letter-spacing: 0.1em; }
  select {
    background: var(--surface2);
    color: var(--text);
    border: 1px solid var(--border);
    border-radius: 6px;
    padding: 6px 10px;
    font-family: 'DM Mono', monospace;
    font-size: 0.72rem;
    cursor: pointer;
    outline: none;
    transition: border-color 0.2s;
  }
  select:hover, select:focus { border-color: var(--accent-int); }
  .filter-group { display: flex; align-items: center; gap: 8px; }
  .active-filter {
    background: rgba(74, 222, 128, 0.08);
    border: 1px solid rgba(74,222,128,0.25);
    color: var(--accent-int);
    border-radius: 20px;
    padding: 4px 10px;
    font-size: 0.65rem;
    cursor: pointer;
    transition: all 0.2s;
    display: none;
  }
  .active-filter:hover { background: rgba(74,222,128,0.15); }

  /* MAIN GRID */
  main {
    padding: 24px 32px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-template-rows: auto;
    gap: 16px;
  }

  /* CARDS */
  .card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 20px;
    transition: border-color 0.25s;
  }
  .card:hover { border-color: #2e3650; }
  .card-title {
    font-size: 0.62rem;
    color: var(--muted);
    text-transform: uppercase;
    letter-spacing: 0.12em;
    margin-bottom: 8px;
  }
  .card-value {
    font-family: 'DM Serif Display', serif;
    font-size: 2.2rem;
    color: var(--highlight);
    line-height: 1;
  }
  .card-sub { font-size: 0.7rem; color: var(--muted); margin-top: 5px; }

  /* KPI row */
  .kpi-green .card-value { color: var(--accent-int); }
  .kpi-orange .card-value { color: var(--accent-ext); }
  .kpi-red .card-value { color: var(--accent-drop); }
  .kpi-blue .card-value { color: var(--accent-grad); }

  /* Retention compare bar */
  .compare-card { grid-column: span 2; }
  .retention-bar-wrap {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 12px;
  }
  .ret-row {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .ret-label { font-size: 0.7rem; color: var(--muted); width: 80px; flex-shrink: 0; }
  .ret-track { flex: 1; background: var(--surface2); border-radius: 4px; height: 28px; overflow: hidden; }
  .ret-fill {
    height: 100%;
    display: flex;
    align-items: center;
    padding: 0 10px;
    font-size: 0.7rem;
    font-weight: 500;
    border-radius: 4px;
    transition: width 0.8s cubic-bezier(.4,0,.2,1);
    white-space: nowrap;
  }
  .ret-int { background: rgba(74,222,128,0.2); border: 1px solid rgba(74,222,128,0.4); color: var(--accent-int); }
  .ret-ext { background: rgba(251,146,60,0.2); border: 1px solid rgba(251,146,60,0.4); color: var(--accent-ext); }

  /* Chart cards */
  .chart-card { grid-column: span 2; }
  .chart-card canvas { max-height: 220px; }
  .chart-full { grid-column: span 4; }
  .chart-full canvas { max-height: 260px; }
  .chart-3 { grid-column: span 3; }
  .chart-3 canvas { max-height: 240px; }
  .chart-1 { grid-column: span 1; }

  /* Funnel */
  .funnel-card { grid-column: span 1; }
  .funnel-rows { margin-top: 14px; display: flex; flex-direction: column; gap: 8px; }
  .funnel-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
  }
  .funnel-bar-bg {
    flex: 1;
    background: var(--surface2);
    border-radius: 3px;
    height: 20px;
    overflow: hidden;
  }
  .funnel-bar-fill {
    height: 100%;
    border-radius: 3px;
    transition: width 0.8s cubic-bezier(.4,0,.2,1);
    display: flex;
    align-items: center;
    padding-left: 8px;
    font-size: 0.65rem;
  }
  .funnel-name { font-size: 0.65rem; color: var(--muted); width: 72px; flex-shrink: 0; text-align: right; }
  .funnel-pct { font-size: 0.7rem; color: var(--highlight); width: 36px; text-align: right; flex-shrink: 0; }

  /* Table */
  .table-card { grid-column: span 4; }
  .data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.7rem;
    margin-top: 12px;
  }
  .data-table th {
    text-align: left;
    color: var(--muted);
    font-size: 0.6rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    border-bottom: 1px solid var(--border);
    padding: 6px 10px;
    cursor: pointer;
    user-select: none;
  }
  .data-table th:hover { color: var(--text); }
  .data-table td {
    padding: 8px 10px;
    border-bottom: 1px solid rgba(37,42,58,0.5);
    color: var(--text);
  }
  .data-table tr:last-child td { border-bottom: none; }
  .data-table tr:hover td { background: var(--surface2); }
  .pill {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 0.65rem;
  }
  .pill-int { background: rgba(74,222,128,0.12); color: var(--accent-int); border: 1px solid rgba(74,222,128,0.25); }
  .pill-ext { background: rgba(251,146,60,0.12); color: var(--accent-ext); border: 1px solid rgba(251,146,60,0.25); }
  .bar-cell { display: flex; align-items: center; gap: 8px; }
  .mini-bar { flex: 1; height: 8px; background: var(--surface2); border-radius: 2px; overflow: hidden; max-width: 80px; }
  .mini-fill { height: 100%; border-radius: 2px; }

  /* Section header */
  .section-head {
    grid-column: span 4;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 6px 0 0;
  }
  .section-head h2 {
    font-family: 'DM Serif Display', serif;
    font-size: 1rem;
    color: var(--text);
  }
  .section-head .line { flex: 1; height: 1px; background: var(--border); }

  /* Tooltip override */
  .chartjs-tooltip { pointer-events: none; }

  /* Responsive */
  @media(max-width: 900px) {
    main { grid-template-columns: repeat(2, 1fr); padding: 16px; }
    .chart-full, .table-card, .section-head { grid-column: span 2; }
    .chart-card, .compare-card, .chart-3 { grid-column: span 2; }
    .chart-1, .funnel-card { grid-column: span 2; }
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
</style>
</head>
<body>

<header>
  <div class="logo">
    <img src="https://sys.unag.edu.hn/assets/images/escudo.png" style="width: 40px;" alt="unag">
  </div>
  <div class="logo">
    RETENCIÓN <span>ESTUDIANTIL</span>  
  </div>
  <div class="badge-row">
     <a style="text-decoration: none;" href="https://drive.google.com/file/d/1OwE0PhI7elSmGg4An5gLfieRWj2OXWaN/view?usp=sharing" target="_blank" rel="titulacion"><span class="descarga">Descargar Muestra en EXCEL</span></a>     
     <a style="text-decoration: none;" href="https://drive.google.com/file/d/1_T3aF9UMMueamFTu8hfX-2wLGiqKpwfm/view?usp=sharing" target="_blank" rel="titulacion"><span class="descarga"> Descargar Analisis en PDF</span></a>   

  </div>
</header>

<div class="container"> 
  <div class="title-block animate-in">     
    <div class="eyebrow">Análisis Académico · Universidad Nacional de Agricultura (UNAG)</div> 
    <h1>Dashboard — Análisis de Retención</h1>
    <div class="eyebrow">Unidad de Análisis · Secretaria de Tecnología de la Información y Comunicaciones (SETIC)</div>
    <p>Análisis por Ubicación · Internado vs Externado</p>
  </div>
<div class="filters">
  <span class="filter-label">Filtros</span><br>
  <div class="filter-group">
    <label class="filter-label">Año ingreso</label>
    <select id="flt-year">
      <option value="all">Todos los años</option>
    </select>
  </div>
  <div class="filter-group">
    <label class="filter-label">Carrera</label>
    <select id="flt-career">
      <option value="all">Todas las carreras</option>
    </select>
  </div>
  <div class="filter-group">
    <label class="filter-label">Ubicación</label>
    <select id="flt-ubi">
      <option value="all">Todas</option>
      <option value="internado">Internado</option>
      <option value="externado">Externado</option>
    </select>
  </div>
  <span id="clear-btn" class="active-filter" onclick="clearFilters()">✕ Limpiar filtros</span>
    <div >
    <div class="badge"><span class="dot dot-int"></span> Internado <strong id="hdr-int">—</strong></div>
    <div class="badge"><span class="dot dot-ext"></span> Externado <strong id="hdr-ext">—</strong></div>
    <div class="badge">Muestra de <strong id="hdr-total">—</strong></div>
  </div>
</div>

<main>
  <!-- KPIs -->
  <div class="card" id="kpi-total">
    <div class="card-title">Total Estudiantes</div>
    <div class="card-value" id="kv-total">—</div>
    <div class="card-sub" id="ks-total">en dataset filtrado</div>
  </div>
  <div class="card kpi-green" id="kpi-active">
    <div class="card-title">Activos (Matriculados)</div>
    <div class="card-value" id="kv-active">—</div>
    <div class="card-sub" id="ks-active">tienen matrícula actual</div>
  </div>
  <div class="card kpi-blue" id="kpi-grad">
    <div class="card-title">Graduados</div>
    <div class="card-value" id="kv-grad">—</div>
    <div class="card-sub" id="ks-grad">completaron carrera</div>
  </div>
  <div class="card kpi-red" id="kpi-drop">
    <div class="card-title">Desertores</div>
    <div class="card-value" id="kv-drop">—</div>
    <div class="card-sub" id="ks-drop">sin matrícula, no graduados</div>
  </div>

  <!-- Section 1 -->
  <div class="section-head"><div class="line"></div><h2>Análisis de Retención</h2><div class="line"></div></div>

  <!-- Retention compare -->
  <div class="card compare-card">
    <div class="card-title">Tasa de Retención: Internado vs Externado</div>
    <div class="retention-bar-wrap" id="ret-bars">
      <div class="ret-row">
        <div class="ret-label">Internado</div>
        <div class="ret-track"><div class="ret-fill ret-int" id="rbar-int" style="width:0%">—</div></div>
      </div>
      <div class="ret-row">
        <div class="ret-label">Externado</div>
        <div class="ret-track"><div class="ret-fill ret-ext" id="rbar-ext" style="width:0%">—</div></div>
      </div>
    </div>
    <div style="margin-top:14px; font-size:0.65rem; color:var(--muted);" id="ret-note">
      Retención = Activos + Graduados / Total
    </div>
  </div>

  <!-- Donut chart -->
  <div class="card chart-card">
    <div class="card-title">Distribución por Estado Académico</div>
    <canvas id="chart-donut"></canvas>
  </div>

  <!-- Bar chart year -->
  <div class="card chart-full">
    <div class="card-title">Retención por Año de Ingreso — Internado vs Externado (%)</div>
    <canvas id="chart-year"></canvas>
  </div>

  <!-- Section 2 -->
  <div class="section-head"><div class="line"></div><h2>Por Carrera</h2><div class="line"></div></div>

  <div class="card chart-3">
    <div class="card-title">Distribución Internado / Externado por Carrera</div>
    <canvas id="chart-career-bar"></canvas>
  </div>

  <div class="card funnel-card">
    <div class="card-title">Retención por Carrera</div>
    <div class="funnel-rows" id="funnel-rows"></div>
  </div>

  <!-- Table -->
  <div class="section-head"><div class="line"></div><h2>Tabla Detallada</h2><div class="line"></div></div>
  <div class="card table-card">
    <div class="card-title">Resumen por Carrera y Ubicación</div>
    <table class="data-table" id="detail-table">
      <thead>
        <tr>
          <th>Carrera</th>
          <th>Ubicación</th>
          <th>Total</th>
          <th>Activos</th>
          <th>Graduados</th>
          <th>Desertores</th>
          <th>% Retención</th>
          <th>% Deserción</th>
        </tr>
      </thead>
      <tbody id="table-body"></tbody>
    </table>
  </div>

</main>
<footer>
    <div>Dashboard Analítico · Retención Estudiantil</div>
    <div> <img src="https://setic.unag.edu.hn/img/logo-setic-blanco.png" style="width: 200px;" alt="setic"> </div>
  </footer>
</div>

<script>
// ===================== DATA =====================
const RAW_DATA = [
{"id":"SE09152","anio":"2019","periodo":"1","id_carrera":"AEA-2019","carrera":"Administración de Empresas Agropecuarias","graduado":"no","ubicacion":"externado","matricula":"si"},
{"id":"SE16049","anio":"2019","periodo":"1","id_carrera":"AEA-2019","carrera":"Administración de Empresas Agropecuarias","graduado":"no","ubicacion":"externado","matricula":"si"},
{"id":"18A0489","anio":"2019","periodo":"1","id_carrera":"IA-310101","carrera":"Ingeniería Agronómica","graduado":"no","ubicacion":"internado","matricula":"si"},
{"id":"19A0260","anio":"2019","periodo":"1","id_carrera":"IA-310101","carrera":"Ingeniería Agronómica","graduado":"si","ubicacion":"internado","matricula":"no"},
{"id":"SE14112","anio":"2019","periodo":"1","id_carrera":"AEA-2019","carrera":"Administración de Empresas Agropecuarias","graduado":"no","ubicacion":"externado","matricula":"no"},
{"id":"18A0179","anio":"2019","periodo":"1","id_carrera":"IA-310101","carrera":"Ingeniería Agronómica","graduado":"no","ubicacion":"internado","matricula":"no"}
];

// Full aggregated stats computed from Python analysis
const FULL_STATS = {
  byUbi: {
    internado: {total:4545, graduated:233, active:3105, dropout:1207},
    externado: {total:756, graduated:29, active:431, dropout:296}
  },
  byYear: {
    "2019": {internado:{total:3,graduated:1,active:1,dropout:1}, externado:{total:3,graduated:0,active:2,dropout:1}},
    "2021": {internado:{total:565,graduated:202,active:110,dropout:253}, externado:{total:79,graduated:22,active:15,dropout:42}},
    "2022": {internado:{total:659,graduated:30,active:422,dropout:207}, externado:{total:63,graduated:7,active:30,dropout:26}},
    "2023": {internado:{total:732,graduated:0,active:425,dropout:307}, externado:{total:154,graduated:0,active:80,dropout:74}},
    "2024": {internado:{total:922,graduated:0,active:632,dropout:290}, externado:{total:147,graduated:0,active:65,dropout:82}},
    "2025": {internado:{total:770,graduated:0,active:631,dropout:139}, externado:{total:151,graduated:0,active:95,dropout:56}},
    "2026": {internado:{total:894,graduated:0,active:884,dropout:10}, externado:{total:159,graduated:0,active:144,dropout:15}}
  },
  byCareer: {
    "Administración de Empresas Agropecuarias": {
      externado:{total:479,graduated:26,active:236,dropout:217},
      internado:{total:5,graduated:0,active:4,dropout:1}
    },
    "Ingeniería Agronómica": {
      internado:{total:2282,graduated:110,active:1618,dropout:554},
      externado:{total:42,graduated:0,active:42,dropout:0}
    },
    "Medicina Veterinaria": {
      internado:{total:471,graduated:0,active:318,dropout:153},
      externado:{total:9,graduated:0,active:9,dropout:0}
    },
    "Ingeniería en Gestión Integral de los Recursos Naturales": {
      internado:{total:499,graduated:17,active:295,dropout:187},
      externado:{total:8,graduated:0,active:8,dropout:0}
    },
    "Ingeniería en Zootecnia": {
      internado:{total:580,graduated:63,active:401,dropout:116},
      externado:{total:21,graduated:0,active:20,dropout:1}
    },
    "Ingeniería en Tecnología Alimentaria": {
      internado:{total:553,graduated:43,active:379,dropout:131},
      externado:{total:3,graduated:0,active:3,dropout:0}
    },
    "Economía Social Agraria": {
      externado:{total:194,graduated:3,active:113,dropout:78}
    },
    "Ingeniería en Agroexportación": {
      internado:{total:155,graduated:0,active:90,dropout:65}
    }
  },
  avgSemesters: {internado:4.03, externado:2.99},
  total: 5301
};

// ===================== FILTERS =====================
let activeYear = 'all';
let activeCareer = 'all';
let activeUbi = 'all';

function initFilters() {
  const yearSel = document.getElementById('flt-year');
  Object.keys(FULL_STATS.byYear).sort().forEach(y => {
    const o = document.createElement('option');
    o.value = y; o.textContent = y;
    yearSel.appendChild(o);
  });
  const careerSel = document.getElementById('flt-career');
  Object.keys(FULL_STATS.byCareer).sort().forEach(c => {
    const o = document.createElement('option');
    o.value = c; o.textContent = c;
    careerSel.appendChild(o);
  });
  yearSel.addEventListener('change', () => { activeYear = yearSel.value; updateAll(); });
  careerSel.addEventListener('change', () => { activeCareer = careerSel.value; updateAll(); });
  document.getElementById('flt-ubi').addEventListener('change', e => { activeUbi = e.target.value; updateAll(); });
}

function clearFilters() {
  activeYear = 'all'; activeCareer = 'all'; activeUbi = 'all';
  document.getElementById('flt-year').value = 'all';
  document.getElementById('flt-career').value = 'all';
  document.getElementById('flt-ubi').value = 'all';
  updateAll();
}

// ===================== COMPUTE FILTERED STATS =====================
function computeFiltered() {
  // Build a combined stats object respecting filters
  let result = {
    int: {total:0, graduated:0, active:0, dropout:0},
    ext: {total:0, graduated:0, active:0, dropout:0},
  };

  const yearsToUse = activeYear === 'all' ? Object.keys(FULL_STATS.byYear) : [activeYear];
  const careersToUse = activeCareer === 'all' ? Object.keys(FULL_STATS.byCareer) : [activeCareer];

  // For year+ubi aggregation
  let yearData = {};
  yearsToUse.forEach(y => {
    const yd = FULL_STATS.byYear[y];
    if (!yd) return;
    yearData[y] = {};
    ['internado','externado'].forEach(u => {
      if (!yd[u]) return;
      if (activeUbi !== 'all' && u !== activeUbi) return;
      // career filter via byCareer
      if (activeCareer !== 'all') {
        const cd = FULL_STATS.byCareer[activeCareer];
        if (!cd || !cd[u]) { yearData[y][u] = {total:0,graduated:0,active:0,dropout:0}; return; }
        // We don't have year+career+ubi, so we just use career+ubi data
        // and the year chart will show career totals (approximation)
        yearData[y][u] = cd[u];
      } else {
        yearData[y][u] = yd[u];
      }
    });
  });

  // Career data
  let careerData = {};
  careersToUse.forEach(c => {
    const cd = FULL_STATS.byCareer[c];
    if (!cd) return;
    careerData[c] = {};
    ['internado','externado'].forEach(u => {
      if (!cd[u]) return;
      if (activeUbi !== 'all' && u !== activeUbi) return;
      careerData[c][u] = cd[u];
    });
  });

  // Totals
  careersToUse.forEach(c => {
    const cd = FULL_STATS.byCareer[c];
    if (!cd) return;
    ['internado','externado'].forEach(u => {
      if (!cd[u]) return;
      if (activeUbi !== 'all' && u !== activeUbi) return;
      if (u === 'internado') {
        result.int.total += cd[u].total;
        result.int.graduated += cd[u].graduated;
        result.int.active += cd[u].active;
        result.int.dropout += cd[u].dropout;
      } else {
        result.ext.total += cd[u].total;
        result.ext.graduated += cd[u].graduated;
        result.ext.active += cd[u].active;
        result.ext.dropout += cd[u].dropout;
      }
    });
  });

  // Year filter override: if year is filtered, recompute from yearData
  if (activeYear !== 'all') {
    result.int = {total:0,graduated:0,active:0,dropout:0};
    result.ext = {total:0,graduated:0,active:0,dropout:0};
    const yd = FULL_STATS.byYear[activeYear];
    if (yd) {
      if ((activeUbi === 'all' || activeUbi === 'internado') && yd.internado) {
        Object.keys(result.int).forEach(k => result.int[k] += yd.internado[k]||0);
      }
      if ((activeUbi === 'all' || activeUbi === 'externado') && yd.externado) {
        Object.keys(result.ext).forEach(k => result.ext[k] += yd.externado[k]||0);
      }
    }
  }

  return { totals: result, yearData, careerData };
}

// ===================== UPDATE ALL =====================
let charts = {};

function pct(n,d) { return d===0 ? 0 : Math.round((n/d)*100); }
function fmt(n) { return n.toLocaleString('es'); }

function updateAll() {
  const hasFilter = activeYear!=='all' || activeCareer!=='all' || activeUbi!=='all';
  document.getElementById('clear-btn').style.display = hasFilter ? 'inline-block' : 'none';

  const {totals, yearData, careerData} = computeFiltered();
  const {int, ext} = totals;
  const totalStudents = int.total + ext.total;
  const totalActive = int.active + ext.active;
  const totalGrad = int.graduated + ext.graduated;
  const totalDrop = int.dropout + ext.dropout;

  // Header
  document.getElementById('hdr-int').textContent = fmt(int.total);
  document.getElementById('hdr-ext').textContent = fmt(ext.total);
  document.getElementById('hdr-total').textContent = fmt(totalStudents);

  // KPIs
  document.getElementById('kv-total').textContent = fmt(totalStudents);
  document.getElementById('kv-active').textContent = fmt(totalActive) + ' (' + pct(totalActive,totalStudents)+'%)';
  document.getElementById('kv-grad').textContent = fmt(totalGrad) + ' (' + pct(totalGrad,totalStudents)+'%)';
  document.getElementById('kv-drop').textContent = fmt(totalDrop) + ' (' + pct(totalDrop,totalStudents)+'%)';

  // Retention bars
  const retInt = pct(int.active + int.graduated, int.total);
  const retExt = pct(ext.active + ext.graduated, ext.total);
  document.getElementById('rbar-int').style.width = retInt+'%';
  document.getElementById('rbar-int').textContent = 'Internado: '+retInt+'% ('+fmt(int.active+int.graduated)+'/'+fmt(int.total)+')';
  document.getElementById('rbar-ext').style.width = retExt+'%';
  document.getElementById('rbar-ext').textContent = 'Externado: '+retExt+'% ('+fmt(ext.active+ext.graduated)+'/'+fmt(ext.total)+')';

  // Note
  const diff = retInt - retExt;
  document.getElementById('ret-note').innerHTML = 
    `Retención = (Activos + Graduados) / Total &nbsp;·&nbsp; <span style="color:${diff>0?'var(--accent-int)':'var(--accent-drop)'}">Internado ${diff>0?'+'+diff:diff} pp vs Externado</span>`;

  // Donut
  updateDonut(int, ext);

  // Year bar
  updateYearBar(yearData);

  // Career bar
  updateCareerBar(careerData);

  // Funnel
  updateFunnel(careerData);

  // Table
  updateTable(careerData);
}

// ============ CHARTS ============
const COLORS = {
  int_active: 'rgba(74,222,128,0.8)',
  int_grad: 'rgba(96,165,250,0.8)',
  int_drop: 'rgba(248,113,113,0.6)',
  ext_active: 'rgba(251,146,60,0.8)',
  ext_grad: 'rgba(167,139,250,0.8)',
  ext_drop: 'rgba(248,113,113,0.35)',
};

function updateDonut(int, ext) {
  const ctx = document.getElementById('chart-donut');
  if (charts.donut) charts.donut.destroy();
  
  const intTotal = int.total;
  const extTotal = ext.total;
  const data = activeUbi === 'all' ? [
    int.active, int.graduated, int.dropout,
    ext.active, ext.graduated, ext.dropout
  ] : activeUbi === 'internado' ? [
    int.active, int.graduated, int.dropout
  ] : [
    ext.active, ext.graduated, ext.dropout
  ];
  
  const labels = activeUbi === 'all' ? [
    'Activos Internado','Graduados Internado','Desertores Internado',
    'Activos Externado','Graduados Externado','Desertores Externado'
  ] : activeUbi === 'internado' ? [
    'Activos','Graduados','Desertores'
  ] : ['Activos','Graduados','Desertores'];

  const colors = activeUbi === 'all' ? [
    COLORS.int_active, COLORS.int_grad, COLORS.int_drop,
    COLORS.ext_active, COLORS.ext_grad, COLORS.ext_drop
  ] : ['rgba(74,222,128,0.8)','rgba(96,165,250,0.8)','rgba(248,113,113,0.7)'];

  charts.donut = new Chart(ctx, {
    type: 'doughnut',
    data: { labels, datasets: [{ data, backgroundColor: colors, borderWidth: 2, borderColor: '#141720' }] },
    options: {
      responsive: true, maintainAspectRatio: true, cutout: '65%',
      plugins: {
        legend: { position: 'right', labels: { color: '#94a3b8', font: { size: 10, family: 'DM Mono' }, boxWidth: 12, padding: 10 } },
        tooltip: { callbacks: { label: ctx => ` ${ctx.label}: ${fmt(ctx.raw)} (${pct(ctx.raw, data.reduce((a,b)=>a+b,0))}%)` } }
      }
    }
  });
}

function updateYearBar(yearData) {
  const ctx = document.getElementById('chart-year');
  if (charts.year) charts.year.destroy();
  
  const years = Object.keys(yearData).sort();
  const intRet = [], extRet = [], intDrop = [], extDrop = [];
  years.forEach(y => {
    const yd = yearData[y];
    const i = yd.internado || {total:0,graduated:0,active:0,dropout:0};
    const e = yd.externado || {total:0,graduated:0,active:0,dropout:0};
    intRet.push(pct(i.active+i.graduated, i.total));
    extRet.push(pct(e.active+e.graduated, e.total));
    intDrop.push(pct(i.dropout, i.total));
    extDrop.push(pct(e.dropout, e.total));
  });

  const datasets = [];
  if (activeUbi !== 'externado') {
    datasets.push({ label: 'Retención Internado', data: intRet, backgroundColor: 'rgba(74,222,128,0.7)', borderColor: '#4ade80', borderWidth: 1, borderRadius: 4 });
  }
  if (activeUbi !== 'internado') {
    datasets.push({ label: 'Retención Externado', data: extRet, backgroundColor: 'rgba(251,146,60,0.7)', borderColor: '#fb923c', borderWidth: 1, borderRadius: 4 });
  }

  charts.year = new Chart(ctx, {
    type: 'bar',
    data: { labels: years, datasets },
    options: {
      responsive: true, maintainAspectRatio: true,
      scales: {
        x: { ticks: { color: '#64748b', font: { size: 10 } }, grid: { color: 'rgba(37,42,58,0.5)' } },
        y: { ticks: { color: '#64748b', font: { size: 10 }, callback: v => v+'%' }, grid: { color: 'rgba(37,42,58,0.5)' }, max: 100 }
      },
      plugins: {
        legend: { labels: { color: '#94a3b8', font: { size: 10, family: 'DM Mono' }, boxWidth: 12 } },
        tooltip: { callbacks: { label: ctx => ` ${ctx.dataset.label}: ${ctx.raw}%` } }
      }
    }
  });
}

function shortCareer(name) {
  const m = {
    'Administración de Empresas Agropecuarias': 'Admin. Emp. Agrop.',
    'Ingeniería Agronómica': 'Ing. Agronómica',
    'Medicina Veterinaria': 'Med. Veterinaria',
    'Ingeniería en Gestión Integral de los Recursos Naturales': 'Ing. Gestión IRNR',
    'Ingeniería en Zootecnia': 'Ing. Zootecnia',
    'Ingeniería en Tecnología Alimentaria': 'Ing. Tec. Aliment.',
    'Economía Social Agraria': 'Econ. Social Agraria',
    'Ingeniería en Agroexportación': 'Ing. Agroexport.',
  };
  return m[name] || name;
}

function updateCareerBar(careerData) {
  const ctx = document.getElementById('chart-career-bar');
  if (charts.careerBar) charts.careerBar.destroy();
  
  const careers = Object.keys(careerData).sort();
  const intTotals = [], extTotals = [];
  careers.forEach(c => {
    const i = careerData[c].internado || {total:0};
    const e = careerData[c].externado || {total:0};
    intTotals.push(i.total);
    extTotals.push(e.total);
  });

  const datasets = [];
  if (activeUbi !== 'externado') datasets.push({ label: 'Internado', data: intTotals, backgroundColor: 'rgba(74,222,128,0.7)', borderRadius: 4 });
  if (activeUbi !== 'internado') datasets.push({ label: 'Externado', data: extTotals, backgroundColor: 'rgba(251,146,60,0.7)', borderRadius: 4 });

  charts.careerBar = new Chart(ctx, {
    type: 'bar',
    data: { labels: careers.map(shortCareer), datasets },
    options: {
      indexAxis: 'y', responsive: true, maintainAspectRatio: true,
      scales: {
        x: { stacked: false, ticks: { color: '#64748b', font:{size:10} }, grid: { color: 'rgba(37,42,58,0.5)' } },
        y: { ticks: { color: '#94a3b8', font:{size:10} }, grid: { display: false } }
      },
      plugins: {
        legend: { labels: { color: '#94a3b8', font:{size:10, family:'DM Mono'}, boxWidth:12 } },
        tooltip: { callbacks: { label: ctx => ` ${ctx.dataset.label}: ${fmt(ctx.raw)} estudiantes` } }
      }
    }
  });
}

function updateFunnel(careerData) {
  const container = document.getElementById('funnel-rows');
  const careers = Object.keys(careerData);
  const retByCareer = careers.map(c => {
    const i = careerData[c].internado || {total:0,graduated:0,active:0,dropout:0};
    const e = careerData[c].externado || {total:0,graduated:0,active:0,dropout:0};
    const tot = i.total + e.total;
    const ret = i.active + i.graduated + e.active + e.graduated;
    return { name: shortCareer(c), pct: pct(ret, tot), tot };
  }).filter(x => x.tot > 0).sort((a,b) => b.pct - a.pct);

  const maxPct = Math.max(...retByCareer.map(x => x.pct));

  container.innerHTML = retByCareer.map(r => {
    const color = r.pct >= 80 ? '#4ade80' : r.pct >= 60 ? '#fb923c' : '#f87171';
    return `<div class="funnel-item">
      <div class="funnel-name">${r.name}</div>
      <div class="funnel-bar-bg">
        <div class="funnel-bar-fill" style="width:${(r.pct/100)*100}%;background:${color}22;border-right:2px solid ${color};"></div>
      </div>
      <div class="funnel-pct" style="color:${color}">${r.pct}%</div>
    </div>`;
  }).join('');
}

function updateTable(careerData) {
  const tbody = document.getElementById('table-body');
  const rows = [];
  Object.keys(careerData).sort().forEach(c => {
    ['internado','externado'].forEach(u => {
      const d = careerData[c][u];
      if (!d || d.total === 0) return;
      const ret = pct(d.active + d.graduated, d.total);
      const drop = pct(d.dropout, d.total);
      rows.push({career: c, ubi: u, total: d.total, active: d.active, graduated: d.graduated, dropout: d.dropout, ret, drop});
    });
  });
  rows.sort((a,b) => b.ret - a.ret);

  tbody.innerHTML = rows.map(r => {
    const retColor = r.ret >= 80 ? '#4ade80' : r.ret >= 60 ? '#fb923c' : '#f87171';
    const dropColor = r.drop <= 20 ? '#4ade80' : r.drop <= 40 ? '#fb923c' : '#f87171';
    return `<tr>
      <td>${r.career}</td>
      <td><span class="pill pill-${r.ubi}">${r.ubi}</span></td>
      <td>${fmt(r.total)}</td>
      <td>${fmt(r.active)} <span style="color:var(--muted);font-size:0.65rem">(${pct(r.active,r.total)}%)</span></td>
      <td>${fmt(r.graduated)} <span style="color:var(--muted);font-size:0.65rem">(${pct(r.graduated,r.total)}%)</span></td>
      <td>${fmt(r.dropout)} <span style="color:var(--muted);font-size:0.65rem">(${pct(r.dropout,r.total)}%)</span></td>
      <td><div class="bar-cell"><div class="mini-bar"><div class="mini-fill" style="width:${r.ret}%;background:${retColor}"></div></div><span style="color:${retColor}">${r.ret}%</span></div></td>
      <td><div class="bar-cell"><div class="mini-bar"><div class="mini-fill" style="width:${r.drop}%;background:${dropColor}"></div></div><span style="color:${dropColor}">${r.drop}%</span></div></td>
    </tr>`;
  }).join('');
}

// ===================== INIT =====================
initFilters();
updateAll();
</script>
</body>
</html>