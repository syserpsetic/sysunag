<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard de Titulación</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
 <link rel="shortcut icon" href="{{ asset('/favicon.png') }}">
<style>
  :root {
    --bg: #0b0f1a;
    --surface: #111827;
    --surface2: #1a2235;
    --border: #1e2d45;
    --accent: #00e5ff;
    --accent2: #ff6b35;
    --accent3: #7c3aed;
    --accent4: #10b981;
    --text: #e2e8f0;
    --text-muted: #64748b;
    --text-dim: #94a3b8;
    --glow: rgba(0,229,255,0.15);
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    background: var(--bg);
    color: var(--text);
    font-family: sans-serif;
    min-height: 100vh;
    overflow-x: hidden;
  }

  /* BACKGROUND GRID */
  body::before {
    content: '';
    position: fixed; inset: 0;
    background-image:
      linear-gradient(rgba(0,229,255,0.03) 1px, transparent 1px),
      linear-gradient(90deg, rgba(0,229,255,0.03) 1px, transparent 1px);
    background-size: 40px 40px;
    pointer-events: none;
    z-index: 0;
  }

  .container { max-width: 1400px; margin: 0 auto; padding: 24px 32px;  }

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
  .header-inner {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
  }
  .header-title { display: flex; flex-direction: column; gap: 4px; }
  .eyebrow {
    font-family: sans-serif;
    font-size: 11px;
    letter-spacing: 0.2em;
    color: #f0b429;
    text-transform: uppercase;
  }

  .logo { font-family:sans-serif; font-weight:800; font-size:18px; letter-spacing:-0.5px; }
  .badge { background:rgba(240,180,41,0.12); color:#f0b429; border:1px solid rgba(240,180,41,0.3); padding:3px 10px; border-radius:20px; font-size:11px; font-weight:500; }

  h1 {
    font-family: sans-serif;
    font-size: clamp(22px, 3vw, 36px);
    font-weight: 800;
    color: #fff;
    line-height: 1.1;
  }
 .header-meta { font-size:12px; color:var(--muted); dgap:24px;margin-left: auto;}


  /* KPI CARDS */
  .kpis {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 16px;
    margin-bottom: 32px;
  }
  .kpi {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 20px;
    position: relative;
    overflow: hidden;
    transition: border-color 0.2s, transform 0.2s;
  }
  .kpi:hover { border-color: var(--accent); transform: translateY(-2px); }
  .kpi::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--accent), transparent);
  }
  .kpi.orange::after { background: linear-gradient(90deg, var(--accent2), transparent); }
  .kpi.purple::after { background: linear-gradient(90deg, var(--accent3), transparent); }
  .kpi.green::after  { background: linear-gradient(90deg, var(--accent4), transparent); }

  .kpi-label { font-size: 10px; letter-spacing: 0.15em; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; }
  .kpi-value { font-family: 'Syne', sans-serif; font-size: 32px; font-weight: 800; color: #fff; line-height: 1; }
  .kpi-value.cyan  { color: var(--accent); }
  .kpi-value.orange{ color: var(--accent2); }
  .kpi-value.purple{ color: #a78bfa; }
  .kpi-value.green { color: var(--accent4); }
  .kpi-sub { font-size: 11px; color: var(--text-muted); margin-top: 6px; }

  /* FILTERS */
  .filters {
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
    margin-bottom: 28px;
    padding: 16px 20px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
  }
  .filter-label { font-size: 10px; letter-spacing: 0.15em; color: var(--text-muted); text-transform: uppercase; }
  .filter-group { display: flex; gap: 8px; flex-wrap: wrap; }
  .filter-btn {
    background: transparent;
    border: 1px solid var(--border);
    color: var(--text-dim);
    padding: 6px 14px;
    border-radius: 6px;
    font-family: 'DM Mono', monospace;
    font-size: 11px;
    cursor: pointer;
    transition: all 0.15s;
    letter-spacing: 0.05em;
  }
  .filter-btn:hover { border-color: var(--accent); color: var(--accent); }
  .filter-btn.active { background: var(--accent); border-color: var(--accent); color: #000; font-weight: 500; }
  .filter-divider { width: 1px; height: 24px; background: var(--border); }

  select {
    background: var(--surface2);
    border: 1px solid var(--border);
    color: var(--text);
    padding: 6px 28px 6px 12px;
    border-radius: 6px;
    font-family: 'DM Mono', monospace;
    font-size: 11px;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    transition: border-color 0.15s;
  }
  select:focus { outline: none; border-color: var(--accent); }

  /* GRID LAYOUT */
  .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
  .grid-3 { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px; }
  @media (max-width: 900px) { .grid-2, .grid-3 { grid-template-columns: 1fr; } }

  /* CHART PANELS */
  .panel {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 24px;
    position: relative;
    transition: border-color 0.2s;
  }
  .panel:hover { border-color: rgba(0,229,255,0.3); }
  .panel-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 20px;
    gap: 12px;
  }
  .panel-title-block { flex: 1; }
  .panel-eyebrow { font-size: 9px; letter-spacing: 0.2em; color: var(--accent); text-transform: uppercase; margin-bottom: 4px; }
  .panel-title { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700; color: #fff; }
  .panel-sub { font-size: 10px; color: var(--text-muted); margin-top: 3px; }
  .chart-wrap { position: relative; }

  /* TABLE */
  .table-panel {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 20px;
  }
  .table-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px 16px;
    border-bottom: 1px solid var(--border);
  }
  .table-title { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700; color: #fff; }
  .table-wrap { overflow-x: auto; }

  table { width: 100%; border-collapse: collapse; }
  thead tr { background: var(--surface2); }
  th {
    padding: 12px 20px;
    text-align: left;
    font-size: 9px;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--text-muted);
    font-weight: 500;
    white-space: nowrap;
  }
  td {
    padding: 14px 20px;
    font-size: 12px;
    border-bottom: 1px solid var(--border);
    color: var(--text-dim);
  }
  tr:last-child td { border-bottom: none; }
  tr:hover td { background: var(--surface2); color: var(--text); }
  .td-career { font-weight: 500; color: var(--text); max-width: 260px; }
  .td-num { font-family: 'DM Mono', monospace; text-align: right; }
  .td-avg { font-weight: 600; color: var(--accent); text-align: right; }
  .td-official { color: var(--text-muted); text-align: right; }

  /* BAR INLINE */
  .bar-cell { display: flex; align-items: center; gap: 8px; min-width: 140px; }
  .bar-track { flex: 1; height: 4px; background: var(--border); border-radius: 2px; overflow: hidden; }
  .bar-fill { height: 100%; border-radius: 2px; transition: width 0.5s ease; }
  .bar-label { font-size: 11px; font-family: 'DM Mono', monospace; color: var(--text-dim); min-width: 32px; text-align: right; }

  /* BADGE */
  .badge {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 9px;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    font-weight: 600;
  }
  .badge-warn { background: rgba(255,107,53,0.15); color: var(--accent2); border: 1px solid rgba(255,107,53,0.3); }
  .badge-ok   { background: rgba(16,185,129,0.15); color: var(--accent4); border: 1px solid rgba(16,185,129,0.3); }
  .badge-info { background: rgba(0,229,255,0.1); color: var(--accent); border: 1px solid rgba(0,229,255,0.2); }

  /* FOOTER */
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
  footer span { color: var(--accent); }

  /* TOOLTIP custom */
  .tooltip-box {
    position: absolute;
    background: #1a2235ee;
    border: 1px solid var(--accent);
    border-radius: 8px;
    padding: 10px 14px;
    pointer-events: none;
    font-size: 11px;
    z-index: 100;
    min-width: 160px;
    backdrop-filter: blur(8px);
  }

  /* HIGHLIGHT CARD */
  .highlight-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 12px;
    margin-bottom: 20px;
  }
  .highlight {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .highlight-icon {
    width: 36px; height: 36px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
  }
  .highlight-icon.cyan   { background: rgba(0,229,255,0.1); }
  .highlight-icon.orange { background: rgba(255,107,53,0.1); }
  .highlight-icon.green  { background: rgba(16,185,129,0.1); }
  .highlight-icon.purple { background: rgba(124,58,237,0.1); }
  .highlight-content { flex: 1; }
  .highlight-name { font-size: 10px; color: var(--text-muted); letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 3px; }
  .highlight-val  { font-family: 'Syne', sans-serif; font-size: 18px; font-weight: 800; color: #fff; }
  .highlight-desc { font-size: 10px; color: var(--text-muted); margin-top: 2px; }
  .logo span { color:#f0b429; }
  .descarga { background:rgba(240,180,41,0.12); color:#f0b429; border:1px solid rgba(240,180,41,0.3); padding:3px 10px; border-radius:20px; font-size:11px; font-weight:500; }
  .title-block p { font-size:13px; color:#64748b; margin-top:4px; }
  .animate-in { animation:fadeUp .4s ease both; }
  .title-block span { color:#f0b429; }
  .registros { font-size:12px; float:right }
</style>

<header>
   <div class="logo">
        <img src="https://sys.unag.edu.hn/assets/images/escudo.png" style="width: 40px;" alt="unag">
    </div>
    <div class="logo">
        TITULACIÓN <span>POR CARRERA</span>  
    </div>
    <div class="header-meta">
        <a style="text-decoration: none;" href="https://drive.google.com/file/d/1QzpB6Pb-ZrkdLN6CzJHtqHHV8l1tkryV/view?usp=sharing" target="_blank" rel="titulacion"><span class="descarga">Descargar Muestra en EXCEL</span></a>     
        <a style="text-decoration: none;" href="https://drive.google.com/file/d/1qwu-0t1HoLaxfgPcarvgmC0tfT9zIMvs/view?usp=sharing" target="_blank" rel="titulacion"><span class="descarga"> Descargar Analisis en PDF</span></a>   
    </div>
  </header>

<div class="container">

     <div  class="title-block animate-in">     
        <div class="eyebrow">Análisis Académico · Universidad Nacional de Agricultura (UNAG)</div> 
        <h1>Dashboard — Tiempo de Titulación</h1>
        <div class="eyebrow">Unidad de Análisis · Secretaria de Tecnología de la Información y Comunicaciones (SETIC)</div>
        <p>Tiempo real de titulación por carrera</p>         
           
        <div class="registros">Registros analizados: <span id="total-count">—</span></div><br>
        <div class="registros">Cohortes: <span>2016 – 2022</span></div><br>
        <div class="registros">Última actualización: <span>2025</span></div><br>
        <div class="registros">Fuente: <span>SETIC - UNAG</span></div><br>
    </div>


  <!-- KPIs -->
  <div class="kpis">
    <div class="kpi">
      <div class="kpi-label">Muestra Graduados</div>
      <div class="kpi-value cyan" id="kpi-total">2,151</div>
      <div class="kpi-sub">Registros en dataset</div>
    </div>
    <div class="kpi orange">
      <div class="kpi-label">Promedio global</div>
      <div class="kpi-value orange" id="kpi-avg">—</div>
      <div class="kpi-sub">Años reales de estudio</div>
    </div>
    <div class="kpi purple">
      <div class="kpi-label">Máx. rezago</div>
      <div class="kpi-value purple" id="kpi-max">—</div>
      <div class="kpi-sub">Años sobre duración oficial</div>
    </div>
    <div class="kpi green">
      <div class="kpi-label">Graduados a tiempo</div>
      <div class="kpi-value green" id="kpi-ontime">—</div>
      <div class="kpi-sub">En duración oficial</div>
    </div>
    <div class="kpi">
      <div class="kpi-label">Carreras analizadas</div>
      <div class="kpi-value" style="color:#fff">9</div>
      <div class="kpi-sub">Programas académicos</div>
    </div>
    <div class="kpi">
      <div class="kpi-label">Cohortes</div>
      <div class="kpi-value" style="color:#fff">6</div>
      <div class="kpi-sub">Años de ingreso</div>
    </div>
  </div>

  <!-- HIGHLIGHTS -->
  <div class="highlight-row" id="highlights"></div>

  <!-- FILTERS -->
  <div class="filters">
    <div class="filter-label">Año ingreso</div>
    <div class="filter-group" id="year-filters"></div>
    <div class="filter-divider"></div>
    <div class="filter-label">Carrera</div>
    <select id="career-select">
      <option value="">Todas las carreras</option>
    </select>
  </div>

  <!-- CHARTS ROW 1 -->
  <div class="grid-2">
    <div class="panel">
      <div class="panel-header">
        <div class="panel-title-block">
          <div class="panel-eyebrow">Comparativa</div>
          <div class="panel-title">Promedio Real vs Duración Oficial</div>
          <div class="panel-sub">Años promedio de estudio por carrera</div>
        </div>
      </div>
      <div class="chart-wrap" style="height:300px">
        <canvas id="chart-compare"></canvas>
      </div>
    </div>
    <div class="panel">
      <div class="panel-header">
        <div class="panel-title-block">
          <div class="panel-eyebrow">Distribución</div>
          <div class="panel-title">Rezago por Carrera</div>
          <div class="panel-sub">Años adicionales sobre duración oficial</div>
        </div>
      </div>
      <div class="chart-wrap" style="height:300px">
        <canvas id="chart-delay"></canvas>
      </div>
    </div>
  </div>

  <!-- CHARTS ROW 2 -->
  <div class="grid-3">
    <div class="panel">
      <div class="panel-header">
        <div class="panel-title-block">
          <div class="panel-eyebrow">Tendencia temporal</div>
          <div class="panel-title">Evolución del Promedio por Año de Ingreso</div>
          <div class="panel-sub">¿Los estudiantes recientes tardan menos?</div>
        </div>
      </div>
      <div class="chart-wrap" style="height:270px">
        <canvas id="chart-trend"></canvas>
      </div>
    </div>
    <div class="panel">
      <div class="panel-header">
        <div class="panel-title-block">
          <div class="panel-eyebrow">Dispersión</div>
          <div class="panel-title">Distribución por Años</div>
          <div class="panel-sub">Concentración de graduados</div>
        </div>
      </div>
      <div class="chart-wrap" style="height:270px">
        <canvas id="chart-dist"></canvas>
      </div>
    </div>
  </div>

  <!-- HEAT MAP ROW -->
  <div class="panel" style="margin-bottom:20px">
    <div class="panel-header">
      <div class="panel-title-block">
        <div class="panel-eyebrow">Mapa de calor</div>
        <div class="panel-title">Promedio de Años por Carrera × Cohorte</div>
        <div class="panel-sub">Más rojo = más años. Más verde = graduación más rápida</div>
      </div>
    </div>
    <div id="heatmap" style="overflow-x:auto;"></div>
  </div>

  <!-- DETAILED TABLE -->
  <div class="table-panel">
    <div class="table-header">
      <div class="table-title">Detalle por Carrera</div>
      <div class="badge badge-info">Interactivo</div>
    </div>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Carrera</th>
            <th style="text-align:right">N° Graduados</th>
            <th style="text-align:right">Duración Oficial</th>
            <th style="text-align:right">Promedio Real</th>
            <th style="text-align:right">Rezago</th>
            <th style="min-width:180px">Tiempo Real</th>
            <th style="text-align:right">A Tiempo</th>
            <th style="text-align:right">Estado</th>
          </tr>
        </thead>
        <tbody id="table-body"></tbody>
      </table>
    </div>
  </div>

  <footer>
    <div>Dashboard Analítico · Tiempo de Titulación</div>
    <div> <img src="https://setic.unag.edu.hn/img/logo-setic-blanco.png" style="width: 200px;" alt="setic"> </div>
  </footer>

</div>

<script>
// ─── RAW DATA ─────────────────────────────────────────────────────────────────
const RAW = [
  {id:"16-0015",carrera:"Tecnología Alimentaria",anio_ingreso:2016,anio_graduacion:2020,mes:"DICIEMBRE",duracion:4,anios:4},
  {id:"16-0080",carrera:"Tecnología Alimentaria",anio_ingreso:2016,anio_graduacion:2021,mes:"JUNIO",duracion:4,anios:5},
  {id:"16-0429",carrera:"Tecnología Alimentaria",anio_ingreso:2016,anio_graduacion:2020,mes:"AGOSTO",duracion:4,anios:4},
  {id:"16-0293",carrera:"Tecnología Alimentaria",anio_ingreso:2016,anio_graduacion:2020,mes:"OCTUBRE",duracion:4,anios:4},
  {id:"16-0205",carrera:"Tecnología Alimentaria",anio_ingreso:2016,anio_graduacion:2023,mes:"SEPTIEMBRE",duracion:4,anios:7},
  {id:"16-0213",carrera:"Tecnología Alimentaria",anio_ingreso:2016,anio_graduacion:2023,mes:"SEPTIEMBRE",duracion:4,anios:7},
];

// ─── FULL AGGREGATED DATA (from analysis) ────────────────────────────────────
const CAREERS = [
  { carrera:"Administración de Empresas Agropecuarias", duracion:4, total:56, avg:4.57, min:4, max:9,
    dist:{4:38,5:10,6:5,7:1,8:1,9:1},
    byYear:{2016:{avg:6.08,n:12},2018:{avg:6,n:1},2019:{avg:5,n:5},2021:{avg:4,n:31},2022:{avg:4,n:7}} },
  { carrera:"Economía Social Agraria", duracion:4, total:3, avg:4.00, min:4, max:4,
    dist:{4:3},
    byYear:{2021:{avg:4,n:3}} },
  { carrera:"Ingeniería Agronómica", duracion:4, total:1415, avg:4.27, min:4, max:8,
    dist:{4:1014,"4.3":152,5:182,6:50,7:15,8:2},
    byYear:{2016:{avg:4.42,n:624},2018:{avg:4.12,n:357},2019:{avg:4.08,n:208},2020:{avg:4.31,n:116},2021:{avg:4.19,n:110}} },
  { carrera:"Ing. Gestión Integral Rec. Naturales", duracion:4, total:71, avg:4.32, min:4, max:5,
    dist:{4:19,"4.3":42,5:10},
    byYear:{2019:{avg:4.15,n:20},2020:{avg:4.43,n:34},2021:{avg:4.3,n:17}} },
  { carrera:"Ingeniería en Tecnología Alimentaria", duracion:4, total:153, avg:4.47, min:4, max:7,
    dist:{4:2,"4.3":122,5:24,6:4,7:1},
    byYear:{2018:{avg:7,n:1},2019:{avg:4.65,n:48},2020:{avg:4.4,n:61},2021:{avg:4.3,n:43}} },
  { carrera:"Ingeniería en Zootecnia", duracion:4, total:66, avg:4.02, min:4, max:5,
    dist:{4:65,5:1},
    byYear:{2020:{avg:5,n:1},2021:{avg:4,n:35},2022:{avg:4,n:30}} },
  { carrera:"Medicina Veterinaria", duracion:5.6, total:45, avg:5.65, min:5.6, max:6,
    dist:{"5.6":39,6:6},
    byYear:{2019:{avg:5.76,n:15},2020:{avg:5.6,n:30}} },
  { carrera:"Recursos Naturales y Ambiente", duracion:4, total:125, avg:4.35, min:4, max:9,
    dist:{4:100,5:15,6:6,8:3,9:1},
    byYear:{2016:{avg:4.37,n:115},2018:{avg:4.1,n:10}} },
  { carrera:"Tecnología Alimentaria", duracion:4, total:217, avg:4.40, min:4, max:9,
    dist:{4:168,5:25,6:15,7:6,8:2,9:1},
    byYear:{2016:{avg:4.44,n:183},2018:{avg:4.18,n:34}} },
];

const YEAR_AVG = {2016:4.44, 2018:4.14, 2019:4.28, 2020:4.51, 2021:4.16, 2022:4.0};
const ALL_YEARS = [2016,2018,2019,2020,2021,2022];

// ─── STATE ────────────────────────────────────────────────────────────────────
let activeYears = new Set(ALL_YEARS);
let activeCareer = '';
let charts = {};

// ─── HELPERS ──────────────────────────────────────────────────────────────────
const fmt = v => Number(v).toFixed(2);
const fmtShort = v => Number(v).toFixed(1);

function getFiltered() {
  let data = CAREERS;
  if (activeCareer) data = data.filter(c => c.carrera === activeCareer);
  return data;
}

function getMaxDist() {
  return Math.max(...CAREERS.flatMap(c=>Object.values(c.dist)));
}

const PALETTE = [
  '#00e5ff','#ff6b35','#7c3aed','#10b981',
  '#f59e0b','#ef4444','#06b6d4','#84cc16','#ec4899'
];

// ─── INIT FILTERS ─────────────────────────────────────────────────────────────
function initFilters() {
  const yf = document.getElementById('year-filters');
  // All button
  const all = document.createElement('button');
  all.className = 'filter-btn active'; all.textContent = 'Todos';
  all.dataset.year = 'all';
  all.onclick = () => {
    activeYears = new Set(ALL_YEARS);
    document.querySelectorAll('#year-filters .filter-btn').forEach(b => {
      b.classList.toggle('active', b.dataset.year === 'all');
    });
    render();
  };
  yf.appendChild(all);

  ALL_YEARS.forEach(y => {
    const btn = document.createElement('button');
    btn.className = 'filter-btn'; btn.textContent = y;
    btn.dataset.year = y;
    btn.onclick = () => {
      const allBtn = yf.querySelector('[data-year="all"]');
      allBtn.classList.remove('active');
      if (activeYears.has(y)) { activeYears.delete(y); btn.classList.remove('active'); }
      else { activeYears.add(y); btn.classList.add('active'); }
      if (activeYears.size === ALL_YEARS.length) { allBtn.classList.add('active'); }
      if (activeYears.size === 0) { activeYears = new Set(ALL_YEARS); allBtn.classList.add('active'); document.querySelectorAll('#year-filters .filter-btn').forEach(b => b.classList.remove('active')); allBtn.classList.add('active'); }
      render();
    };
    yf.appendChild(btn);
  });

  const cs = document.getElementById('career-select');
  CAREERS.forEach(c => {
    const o = document.createElement('option');
    o.value = c.carrera; o.textContent = c.carrera;
    cs.appendChild(o);
  });
  cs.onchange = () => { activeCareer = cs.value; render(); };
}

// ─── RENDER KPIs ──────────────────────────────────────────────────────────────
function renderKPIs() {
  const data = getFiltered();
  const total = data.reduce((s,c)=>s+c.total,0);
  const avgAll = data.reduce((s,c)=>s+c.avg*c.total,0)/total;
  const maxRezago = Math.max(...data.map(c=>c.avg - c.duracion));
  const ontime = data.reduce((s,c)=>s+(c.dist[c.duracion]||c.dist[String(c.duracion)]||0),0);
  const pct = Math.round(ontime/total*100);

  document.getElementById('total-count').textContent = total.toLocaleString('es');
  document.getElementById('kpi-total').textContent = total.toLocaleString('es');
  document.getElementById('kpi-avg').textContent = fmt(avgAll)+'a';
  document.getElementById('kpi-max').textContent = '+'+fmtShort(maxRezago)+'a';
  document.getElementById('kpi-ontime').textContent = pct+'%';
}

// ─── HIGHLIGHTS ───────────────────────────────────────────────────────────────
function renderHighlights() {
  const data = getFiltered();
  const sorted = [...data].sort((a,b)=>a.avg-b.avg);
  const fastest = sorted[0];
  const slowest = sorted[sorted.length-1];
  const mostRezago = [...data].sort((a,b)=>(b.avg-b.duracion)-(a.avg-a.duracion))[0];

  const h = document.getElementById('highlights');
  h.innerHTML = `
    <div class="highlight">
      <div class="highlight-icon green">🏆</div>
      <div class="highlight-content">
        <div class="highlight-name">Más rápida</div>
        <div class="highlight-val">${fmtShort(fastest.avg)} años</div>
        <div class="highlight-desc">${fastest.carrera}</div>
      </div>
    </div>
    <div class="highlight">
      <div class="highlight-icon orange">⏳</div>
      <div class="highlight-content">
        <div class="highlight-name">Mayor duración</div>
        <div class="highlight-val">${fmtShort(slowest.avg)} años</div>
        <div class="highlight-desc">${slowest.carrera}</div>
      </div>
    </div>
    <div class="highlight">
      <div class="highlight-icon purple">📊</div>
      <div class="highlight-content">
        <div class="highlight-name">Mayor rezago</div>
        <div class="highlight-val">+${fmtShort(mostRezago.avg - mostRezago.duracion)} años</div>
        <div class="highlight-desc">${mostRezago.carrera}</div>
      </div>
    </div>
    <div class="highlight">
      <div class="highlight-icon cyan">📅</div>
      <div class="highlight-content">
        <div class="highlight-name">Mejor cohorte</div>
        <div class="highlight-val">${Object.entries(YEAR_AVG).sort((a,b)=>a[1]-b[1])[0][0]}</div>
        <div class="highlight-desc">${fmtShort(Object.entries(YEAR_AVG).sort((a,b)=>a[1]-b[1])[0][1])} años promedio</div>
      </div>
    </div>
  `;
}

// ─── CHART: COMPARE ───────────────────────────────────────────────────────────
function renderCompare() {
  const data = getFiltered();
  const labels = data.map(c => c.carrera.replace('Ingeniería en ','Ing. ').replace('Administración de ','Adm. '));
  const real = data.map(c => c.avg);
  const ofic = data.map(c => c.duracion);

  if (charts.compare) charts.compare.destroy();
  charts.compare = new Chart(document.getElementById('chart-compare'), {
    type: 'bar',
    data: {
      labels,
      datasets: [
        { label: 'Promedio Real', data: real, backgroundColor: 'rgba(0,229,255,0.7)', borderColor: '#00e5ff', borderWidth: 1, borderRadius: 4 },
        { label: 'Duración Oficial', data: ofic, backgroundColor: 'rgba(255,107,53,0.3)', borderColor: '#ff6b35', borderWidth: 1, borderRadius: 4, borderDash: [4,2] },
      ]
    },
    options: {
      responsive: true, maintainAspectRatio: false,
      plugins: { legend: { labels: { color: '#94a3b8', font: { family: 'DM Mono', size: 10 } } }, tooltip: { backgroundColor: '#1a2235', borderColor: '#00e5ff', borderWidth: 1, titleColor: '#fff', bodyColor: '#94a3b8', titleFont: { family: 'Syne', size: 12, weight: '700' }, bodyFont: { family: 'DM Mono', size: 10 } } },
      scales: {
        x: { ticks: { color: '#64748b', font: { family: 'DM Mono', size: 9 }, maxRotation: 40 }, grid: { color: 'rgba(255,255,255,0.03)' } },
        y: { ticks: { color: '#64748b', font: { family: 'DM Mono', size: 10 } }, grid: { color: 'rgba(255,255,255,0.05)' }, min: 0 }
      }
    }
  });
}

// ─── CHART: DELAY ─────────────────────────────────────────────────────────────
function renderDelay() {
  const data = getFiltered().filter(c=>c.avg-c.duracion > 0).sort((a,b)=>(b.avg-b.duracion)-(a.avg-a.duracion));
  const labels = data.map(c => c.carrera.replace('Ingeniería en ','Ing. ').replace('Administración de ','Adm. '));
  const delays = data.map(c => +(c.avg - c.duracion).toFixed(2));
  const colors = delays.map(d => d > 1.5 ? 'rgba(239,68,68,0.7)' : d > 0.5 ? 'rgba(255,107,53,0.7)' : 'rgba(245,158,11,0.7)');

  if (charts.delay) charts.delay.destroy();
  charts.delay = new Chart(document.getElementById('chart-delay'), {
    type: 'bar',
    data: { labels, datasets: [{ label: 'Rezago (años)', data: delays, backgroundColor: colors, borderRadius: 4, borderSkipped: false }] },
    options: {
      indexAxis: 'y',
      responsive: true, maintainAspectRatio: false,
      plugins: { legend: { display: false }, tooltip: { backgroundColor: '#1a2235', borderColor: '#ff6b35', borderWidth: 1, titleColor: '#fff', bodyColor: '#94a3b8', callbacks: { label: (ctx) => ` +${ctx.raw} años sobre la duración oficial` } } },
      scales: {
        x: { ticks: { color: '#64748b', font: { family: 'DM Mono', size: 10 } }, grid: { color: 'rgba(255,255,255,0.05)' } },
        y: { ticks: { color: '#94a3b8', font: { family: 'DM Mono', size: 9 } }, grid: { color: 'rgba(255,255,255,0.02)' } }
      }
    }
  });
}

// ─── CHART: TREND ─────────────────────────────────────────────────────────────
function renderTrend() {
  const years = [...activeYears].sort();

  // Build per-career + global trend
  const datasets = [];
  const filteredCareers = getFiltered().filter(c => Object.keys(c.byYear).length > 1);

  filteredCareers.forEach((c, i) => {
    const points = years.map(y => c.byYear[y] ? c.byYear[y].avg : null);
    datasets.push({
      label: c.carrera.replace('Ingeniería en ','Ing. ').replace('Ingeniería ','Ing. ').replace('Administración de ','Adm. '),
      data: points,
      borderColor: PALETTE[i % PALETTE.length],
      backgroundColor: 'transparent',
      tension: 0.4, borderWidth: 2,
      pointRadius: 4, pointHoverRadius: 6,
      spanGaps: true
    });
  });

  // Global line
  const globalPts = years.map(y => activeYears.has(y) ? YEAR_AVG[y] : null);
  datasets.push({
    label: '— Global',
    data: globalPts,
    borderColor: '#fff',
    backgroundColor: 'transparent',
    tension: 0.4, borderWidth: 2, borderDash: [6,3],
    pointRadius: 3, spanGaps: true
  });

  if (charts.trend) charts.trend.destroy();
  charts.trend = new Chart(document.getElementById('chart-trend'), {
    type: 'line',
    data: { labels: years, datasets },
    options: {
      responsive: true, maintainAspectRatio: false,
      plugins: { legend: { labels: { color: '#64748b', font: { family: 'DM Mono', size: 9 }, boxWidth: 14 } }, tooltip: { backgroundColor: '#1a2235', borderColor: '#00e5ff', borderWidth: 1, titleColor: '#fff', bodyColor: '#94a3b8' } },
      scales: {
        x: { ticks: { color: '#64748b', font: { family: 'DM Mono', size: 10 } }, grid: { color: 'rgba(255,255,255,0.03)' } },
        y: { ticks: { color: '#64748b', font: { family: 'DM Mono', size: 10 } }, grid: { color: 'rgba(255,255,255,0.05)' }, min: 3.5 }
      }
    }
  });
}

// ─── CHART: DISTRIBUTION ──────────────────────────────────────────────────────
function renderDist() {
  const allDist = {};
  getFiltered().forEach(c => {
    Object.entries(c.dist).forEach(([k,v]) => {
      allDist[k] = (allDist[k]||0)+v;
    });
  });
  const sorted = Object.entries(allDist).sort((a,b)=>+a[0]-(+b[0]));
  const labels = sorted.map(e=>e[0]+'a');
  const vals = sorted.map(e=>e[1]);
  const total = vals.reduce((a,b)=>a+b,0);
  const pcts = vals.map(v=>+(v/total*100).toFixed(1));

  const colors = sorted.map(([k]) => {
    const numK = +k;
    if (numK <= 4.3) return 'rgba(16,185,129,0.7)';
    if (numK <= 5) return 'rgba(245,158,11,0.7)';
    return 'rgba(239,68,68,0.7)';
  });

  if (charts.dist) charts.dist.destroy();
  charts.dist = new Chart(document.getElementById('chart-dist'), {
    type: 'doughnut',
    data: { labels, datasets: [{ data: pcts, backgroundColor: colors, borderColor: '#111827', borderWidth: 2 }] },
    options: {
      responsive: true, maintainAspectRatio: false,
      plugins: {
        legend: { position: 'bottom', labels: { color: '#94a3b8', font: { family: 'DM Mono', size: 10 }, padding: 12, boxWidth: 12 } },
        tooltip: { backgroundColor: '#1a2235', borderColor: '#00e5ff', borderWidth: 1, titleColor: '#fff', bodyColor: '#94a3b8', callbacks: { label: (ctx) => ` ${ctx.label}: ${ctx.raw}% de graduados` } }
      },
      cutout: '60%'
    }
  });
}

// ─── HEATMAP ──────────────────────────────────────────────────────────────────
function renderHeatmap() {
  const data = getFiltered();
  const years = [...activeYears].sort();

  let html = '<table style="width:100%;border-collapse:collapse;font-size:11px;font-family:DM Mono,monospace;">';
  // header
  html += '<thead><tr><th style="padding:10px 16px;text-align:left;color:#64748b;font-size:9px;letter-spacing:0.15em;text-transform:uppercase;font-weight:500;background:#1a2235;border-bottom:1px solid #1e2d45;">Carrera</th>';
  years.forEach(y => {
    html += `<th style="padding:10px 12px;text-align:center;color:#64748b;font-size:9px;letter-spacing:0.15em;text-transform:uppercase;font-weight:500;background:#1a2235;border-bottom:1px solid #1e2d45;">${y}</th>`;
  });
  html += '<th style="padding:10px 12px;text-align:center;color:#00e5ff;font-size:9px;letter-spacing:0.15em;text-transform:uppercase;font-weight:500;background:#1a2235;border-bottom:1px solid #1e2d45;">GLOBAL</th></tr></thead><tbody>';

  const allVals = data.flatMap(c => Object.values(c.byYear).map(v=>v.avg));
  const minV = Math.min(...allVals);
  const maxV = Math.max(...allVals);

  function heatColor(v) {
    const t = (v - minV) / (maxV - minV);
    // green → yellow → red
    if (t < 0.5) {
      const r = Math.round(16 + (245-16)*t*2);
      const g = Math.round(185 + (158-185)*t*2);
      const b = Math.round(129 + (11-129)*t*2);
      return `rgb(${r},${g},${b})`;
    } else {
      const t2 = (t-0.5)*2;
      const r = Math.round(245 + (239-245)*t2);
      const g = Math.round(158 + (68-158)*t2);
      const b = Math.round(11 + (68-11)*t2);
      return `rgb(${r},${g},${b})`;
    }
  }

  data.forEach(c => {
    html += `<tr>`;
    html += `<td style="padding:10px 16px;color:#e2e8f0;border-bottom:1px solid #1e2d45;font-weight:500;max-width:220px;">${c.carrera}</td>`;
    years.forEach(y => {
      const entry = c.byYear[y];
      if (entry) {
        const color = heatColor(entry.avg);
        const contrast = entry.avg > (minV+maxV)/2 ? '#000' : '#000';
        html += `<td style="padding:10px 12px;text-align:center;border-bottom:1px solid #1e2d45;"><div style="display:inline-block;background:${color};color:#000;padding:4px 10px;border-radius:5px;font-weight:600;font-size:11px;">${fmtShort(entry.avg)}a<br><span style="font-size:9px;opacity:0.7">n=${entry.n}</span></div></td>`;
      } else {
        html += `<td style="padding:10px 12px;text-align:center;border-bottom:1px solid #1e2d45;color:#1e2d45;">—</td>`;
      }
    });
    const globalColor = heatColor(c.avg);
    html += `<td style="padding:10px 12px;text-align:center;border-bottom:1px solid #1e2d45;"><div style="display:inline-block;background:${globalColor};color:#000;padding:4px 10px;border-radius:5px;font-weight:700;font-size:11px;">${fmtShort(c.avg)}a</div></td>`;
    html += `</tr>`;
  });

  html += '</tbody></table>';
  document.getElementById('heatmap').innerHTML = html;
}

// ─── TABLE ────────────────────────────────────────────────────────────────────
function renderTable() {
  const data = getFiltered().sort((a,b)=>b.avg-a.avg);
  const maxAvg = Math.max(...CAREERS.map(c=>c.avg));
  const tb = document.getElementById('table-body');
  tb.innerHTML = '';

  data.forEach((c,i) => {
    const rezago = +(c.avg - c.duracion).toFixed(2);
    const ontime = c.dist[c.duracion] || c.dist[String(c.duracion)] || 0;
    const pct = Math.round(ontime/c.total*100);
    const barW = Math.round(c.avg/maxAvg*100);
    const barColor = rezago > 1.5 ? '#ef4444' : rezago > 0.5 ? '#ff6b35' : '#10b981';
    const badge = rezago > 1.5 ? '<span class="badge badge-warn">Rezago alto</span>' :
                  rezago > 0.2 ? '<span class="badge badge-warn">Rezago leve</span>' :
                                 '<span class="badge badge-ok">A tiempo</span>';

    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td class="td-career">${c.carrera}</td>
      <td class="td-num">${c.total.toLocaleString('es')}</td>
      <td class="td-official">${c.duracion}a</td>
      <td class="td-avg">${fmt(c.avg)}a</td>
      <td class="td-num" style="color:${barColor}">${rezago > 0 ? '+' : ''}${fmt(rezago)}a</td>
      <td>
        <div class="bar-cell">
          <div class="bar-track"><div class="bar-fill" style="width:${barW}%;background:${barColor}"></div></div>
          <div class="bar-label">${fmtShort(c.avg)}a</div>
        </div>
      </td>
      <td class="td-num" style="color:${pct>70?'#10b981':'#ff6b35'}">${pct}%</td>
      <td>${badge}</td>
    `;
    tb.appendChild(tr);
  });
}

// ─── MAIN RENDER ──────────────────────────────────────────────────────────────
function render() {
  renderKPIs();
  renderHighlights();
  renderCompare();
  renderDelay();
  renderTrend();
  renderDist();
  renderHeatmap();
  renderTable();
}

// ─── BOOT ─────────────────────────────────────────────────────────────────────
initFilters();
render();

// Set default chart.js global styles
Chart.defaults.color = '#94a3b8';
Chart.defaults.borderColor = 'rgba(255,255,255,0.05)';
Chart.defaults.font.family = 'DM Mono';
</script>
</body>
</html>



