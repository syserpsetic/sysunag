<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard · Tiempo de Titulación — UNAG</title>
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
  --verde:       #1BA333;
  --verde-dark:  #135423;
  --amarillo:    #FFCC00;
  --azul:        #203B76;
  --celeste:     #0094E9;
  --cafe:        #5B3700;
  --bg:          #f4f7f4;
  --white:       #ffffff;
  --surface2:    #eef4ee;
  --border:      #d0e4d0;
  --border-dk:   #aacaaa;
  --text:        #1a2b1a;
  --text-dim:    #3d5c3d;
  --text-muted:  #6b8a6b;
  --ok:    #1BA333;
  --warn:  #d4870a;
  --bad:   #c03030;
  --shadow-sm: 0 2px 8px rgba(32,59,118,0.08);
  --shadow-md: 0 4px 20px rgba(32,59,118,0.13);
}
* { margin:0; padding:0; box-sizing:border-box; }
body { background:var(--bg); color:var(--text); font-family:'Open Sans',sans-serif; min-height:100vh; overflow-x:hidden; }

/* HEADER */
header { background:var(--white); border-bottom:3px solid var(--verde); padding:0 32px; position:sticky; top:0; z-index:200; box-shadow:var(--shadow-md); }
.hi { display:flex; align-items:center; gap:18px; min-height:66px; max-width:1440px; margin:0 auto; flex-wrap:wrap; }
.hlogo { display:flex; align-items:center; gap:12px; text-decoration:none; flex-shrink:0; }
.hlogo img { width:46px; }
.hbrand { display:flex; flex-direction:column; gap:1px; }
.hbrand-name { font-family:'Montserrat',sans-serif; font-weight:800; font-size:14px; color:var(--azul); letter-spacing:-0.01em; }
.hbrand-unit { font-family:'Montserrat',sans-serif; font-size:10px; color:var(--verde); letter-spacing:.12em; text-transform:uppercase; font-weight:700; }
.hsep { width:1px; height:34px; background:var(--border); flex-shrink:0; }
.htitle { flex:1; }
.heyebrow { font-family:'Montserrat',sans-serif; font-size:9px; letter-spacing:.2em; color:var(--verde); text-transform:uppercase; font-weight:700; margin-bottom:2px; }
.hmain { font-family:'Montserrat',sans-serif; font-size:clamp(13px,1.8vw,18px); font-weight:800; color:var(--azul); }
.hactions { display:flex; gap:8px; align-items:center; margin-left:auto; }
.btn-dl { display:inline-flex; align-items:center; gap:6px; background:var(--verde); color:#fff; border:none; padding:7px 14px; border-radius:6px; font-size:11px; font-weight:700; font-family:'Montserrat',sans-serif; text-decoration:none; white-space:nowrap; transition:.2s; letter-spacing:.02em; }
.btn-dl:hover { background:var(--verde-dark); box-shadow:var(--shadow-md); }
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
.page-header { display:flex; align-items:flex-start; justify-content:space-between; gap:24px; margin-bottom:28px; flex-wrap:wrap; animation:fadeUp .4s ease both; }
.plabel { display:inline-flex; align-items:center; background:var(--verde); color:#fff; padding:4px 14px; border-radius:4px; font-family:'Montserrat',sans-serif; font-size:9px; letter-spacing:.2em; text-transform:uppercase; font-weight:700; margin-bottom:10px; }
.ptitle { font-family:'Montserrat',sans-serif; font-size:clamp(24px,4vw,40px); font-weight:900; color:var(--azul); line-height:1.05; letter-spacing:-.02em; margin-bottom:8px; }
.ptitle span { color:var(--verde); }
.psubtitle { font-size:13px; color:var(--text-muted); line-height:1.5; }
.pmeta { display:flex; flex-direction:column; gap:5px; text-align:right; flex-shrink:0; background:var(--white); border:1px solid var(--border); border-left:4px solid var(--verde); border-radius:8px; padding:14px 18px; box-shadow:var(--shadow-sm); }
.pmeta-item { font-size:11px; color:var(--text-muted); }
.pmeta-item strong { color:var(--azul); font-weight:700; }
.pmeta-item.hl strong { color:var(--verde); }

/* SECTION HEADING */
.sh { display:flex; align-items:center; gap:10px; margin:28px 0 14px; }
.sh-bar { width:4px; height:20px; background:var(--verde); border-radius:2px; flex-shrink:0; }
.sh-txt { font-family:'Montserrat',sans-serif; font-size:10px; letter-spacing:.18em; text-transform:uppercase; color:var(--azul); font-weight:800; }
.sh-line { flex:1; height:1px; background:var(--border); }

/* KPIs */
.kpis { display:grid; grid-template-columns:repeat(auto-fit,minmax(190px,1fr)); gap:14px; margin-bottom:8px; }
.kpi { background:var(--white); border:1px solid var(--border); border-top:4px solid var(--verde); border-radius:10px; padding:20px 22px; position:relative; overflow:hidden; box-shadow:var(--shadow-sm); transition:.2s; animation:fadeUp .45s ease both; }
.kpi:hover { box-shadow:var(--shadow-md); transform:translateY(-2px); }
.kpi.az { border-top-color:var(--azul); }
.kpi.am { border-top-color:var(--amarillo); }
.kpi.rd { border-top-color:var(--bad); }
.kpi.gr { border-top-color:var(--border-dk); }
.kpi::after { content:attr(data-icon); position:absolute; right:14px; bottom:10px; font-size:38px; opacity:.07; pointer-events:none; }
.kpi-lbl { font-family:'Montserrat',sans-serif; font-size:9px; letter-spacing:.16em; color:var(--text-muted); text-transform:uppercase; font-weight:700; margin-bottom:10px; }
.kpi-val { font-family:'Montserrat',sans-serif; font-size:36px; font-weight:900; color:var(--azul); line-height:1; margin-bottom:6px; }
.kpi-val.v { color:var(--verde); }
.kpi-val.a { color:var(--cafe); }
.kpi-val.r { color:var(--bad); }
.kpi-sub { font-size:11px; color:var(--text-muted); line-height:1.4; }

/* HIGHLIGHTS */
.hls { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:12px; margin-bottom:8px; }
.hl { background:var(--white); border:1px solid var(--border); border-radius:10px; padding:14px 18px; display:flex; align-items:center; gap:14px; box-shadow:var(--shadow-sm); transition:.2s; animation:fadeUp .45s ease both; }
.hl:hover { box-shadow:var(--shadow-md); }
.hl-icon { width:42px; height:42px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; }
.hiv { background:rgba(27,163,51,.12); } .hia { background:rgba(32,59,118,.10); }
.hiw { background:rgba(255,204,0,.18); } .hib { background:rgba(192,48,48,.10); }
.hl-lbl { font-family:'Montserrat',sans-serif; font-size:9px; text-transform:uppercase; letter-spacing:.14em; color:var(--text-muted); font-weight:700; margin-bottom:3px; }
.hl-val { font-family:'Montserrat',sans-serif; font-size:20px; font-weight:900; color:var(--azul); line-height:1; }
.hl-desc { font-size:10px; color:var(--text-muted); margin-top:2px; }

/* FILTERS */
.filters { background:var(--white); border:1px solid var(--border); border-radius:10px; padding:14px 20px; display:flex; gap:16px; align-items:center; flex-wrap:wrap; margin-bottom:8px; box-shadow:var(--shadow-sm); }
.flbl { font-family:'Montserrat',sans-serif; font-size:9px; letter-spacing:.16em; color:var(--azul); text-transform:uppercase; font-weight:700; white-space:nowrap; }
.fgrp { display:flex; gap:6px; flex-wrap:wrap; }
.fbtn { background:transparent; border:1.5px solid var(--border-dk); color:var(--text-muted); padding:5px 13px; border-radius:5px; font-family:'Montserrat',sans-serif; font-size:11px; font-weight:700; cursor:pointer; transition:.15s; }
.fbtn:hover { border-color:var(--verde); color:var(--verde); }
.fbtn.active { background:var(--verde); border-color:var(--verde); color:#fff; box-shadow:0 2px 8px rgba(27,163,51,.3); }
.fsep { width:1px; height:22px; background:var(--border); flex-shrink:0; }
select { background:var(--surface2); border:1.5px solid var(--border-dk); color:var(--text); padding:6px 30px 6px 12px; border-radius:6px; font-family:'Montserrat',sans-serif; font-size:11px; font-weight:700; cursor:pointer; appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23203B76' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 10px center; }
select:focus { outline:none; border-color:var(--verde); }

/* GRIDS */
.g2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px; }
.g3 { display:grid; grid-template-columns:2fr 1fr; gap:16px; margin-bottom:16px; }
@media(max-width:920px) { .g2,.g3 { grid-template-columns:1fr; } }

/* PANELS */
.panel { background:var(--white); border:1px solid var(--border); border-top:3px solid var(--verde); border-radius:10px; padding:22px; box-shadow:var(--shadow-sm); transition:.2s; animation:fadeUp .45s ease both; }
.panel:hover { box-shadow:var(--shadow-md); }
.panel.az { border-top-color:var(--azul); }
.panel.am { border-top-color:var(--amarillo); }
.panel-ey { font-family:'Montserrat',sans-serif; font-size:9px; letter-spacing:.2em; color:var(--verde); text-transform:uppercase; font-weight:700; margin-bottom:4px; }
.panel-ey.az { color:var(--azul); }
.panel-ey.am { color:var(--cafe); }
.panel-tt { font-family:'Montserrat',sans-serif; font-size:15px; font-weight:800; color:var(--azul); line-height:1.2; }
.panel-sub { font-size:10px; color:var(--text-muted); margin-top:3px; }
.panel-hd { margin-bottom:18px; }
.chart-wrap { position:relative; }

/* TABLE */
.tpanel { background:var(--white); border:1px solid var(--border); border-radius:10px; overflow:hidden; margin-bottom:16px; box-shadow:var(--shadow-sm); animation:fadeUp .45s ease both; }
.thead2 { display:flex; align-items:center; justify-content:space-between; padding:16px 22px 14px; border-bottom:1px solid var(--border); background:var(--surface2); }
.thead2-tt { font-family:'Montserrat',sans-serif; font-size:15px; font-weight:800; color:var(--azul); }
.twrap { overflow-x:auto; }
table { width:100%; border-collapse:collapse; }
thead tr { background:var(--surface2); }
th { padding:11px 18px; text-align:left; font-family:'Montserrat',sans-serif; font-size:9px; letter-spacing:.12em; text-transform:uppercase; color:var(--azul); font-weight:700; white-space:nowrap; border-bottom:2px solid var(--verde); }
td { padding:12px 18px; font-size:12px; border-bottom:1px solid var(--border); color:var(--text-dim); }
tr:last-child td { border-bottom:none; }
tr:hover td { background:#f7fdf7; }
.tdc { font-weight:600; color:var(--azul); max-width:260px; }
.tdn { font-family:'Montserrat',sans-serif; text-align:right; font-size:11px; font-weight:700; }
.tda { font-family:'Montserrat',sans-serif; font-weight:800; color:var(--verde); text-align:right; }
.bar-cell { display:flex; align-items:center; gap:8px; min-width:140px; }
.bar-track { flex:1; height:4px; background:var(--border); border-radius:2px; overflow:hidden; }
.bar-fill { height:100%; border-radius:2px; transition:width .6s ease; }
.bar-val { font-family:'Montserrat',sans-serif; font-size:10px; font-weight:700; color:var(--text-muted); min-width:30px; text-align:right; }
.badge { display:inline-block; padding:3px 9px; border-radius:4px; font-size:9px; letter-spacing:.08em; text-transform:uppercase; font-weight:700; font-family:'Montserrat',sans-serif; }
.bv { background:rgba(27,163,51,.12); color:var(--verde-dark); border:1px solid rgba(27,163,51,.3); }
.bw { background:rgba(212,135,10,.12); color:#a06b00; border:1px solid rgba(212,135,10,.3); }
.bb { background:rgba(192,48,48,.10); color:var(--bad); border:1px solid rgba(192,48,48,.25); }
.bi { background:rgba(32,59,118,.10); color:var(--azul); border:1px solid rgba(32,59,118,.25); }

/* WAVE FOOTER */
.wfooter { margin-top:48px; }
.wfooter svg { display:block; width:100%; }
.footer-bar { background:var(--verde); padding:18px 32px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; }
.fn { font-family:'Montserrat',sans-serif; font-weight:800; font-size:13px; color:#fff; }
.fs { font-size:11px; color:rgba(255,255,255,.75); }
.footer-bar img { height:50px; filter:brightness(0) invert(1); opacity:.9; }

@keyframes fadeUp { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }
.kpi:nth-child(1){animation-delay:.05s} .kpi:nth-child(2){animation-delay:.10s}
.kpi:nth-child(3){animation-delay:.15s} .kpi:nth-child(4){animation-delay:.20s}
.kpi:nth-child(5){animation-delay:.25s} .kpi:nth-child(6){animation-delay:.30s}
@media(max-width:768px){header{padding:0 16px} .container{padding:20px 16px 40px} .pmeta{display:none} .hactions .btn-dl:last-child{display:none}  .htitle { display:none; }   /* Mostrado en title-block ya */}
</style>

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
      <div class="hmain">Tiempo de Titulación por Carrera</div>
    </div>
    <div class="">
      <a class="btn-dl am" href="https://drive.google.com/file/d/1QzpB6Pb-ZrkdLN6CzJHtqHHV8l1tkryV/view?usp=sharing" target="_blank">
        <svg viewBox="0 0 16 16" fill="currentColor"><path d="M8 12l-4-4h2.5V4h3v4H12L8 12z"/><rect x="2" y="13" width="12" height="1.5" rx=".75"/></svg>Muestra Excel
      </a>
      <a class="btn-dl" href="https://drive.google.com/file/d/1qwu-0t1HoLaxfgPcarvgmC0tfT9zIMvs/view?usp=sharing" target="_blank">
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

<div class="container">

  <div class="page-header">
    <div>
      <div class="plabel">Cohortes 2016 – 2022 · Análisis de Egreso</div>
      <h1 class="ptitle">Dashboard — <span>Titulación</span> por Carrera</h1>
      <p class="psubtitle">Tiempo real de graduación vs. duración oficial por carrera </p>
      <p class="psubtitle">Nota: Este análisis está hecho en base a una muestra de 2,151 registros de estudiantes graduados que ingresaron del 2016 al 2022</p>
    </div>
    <div class="pmeta">
      <div class="pmeta-item hl">Registros: <strong id="total-count">—</strong></div>
      <div class="pmeta-item">Cohortes: <strong>2016 – 2022</strong></div>
      <div class="pmeta-item">Actualización: <strong>2025</strong></div>
      <div class="pmeta-item">Fuente: <strong>SETIC · UNAG</strong></div>
    </div>
  </div>

  <div class="sh"><div class="sh-bar"></div><div class="sh-txt">Indicadores Clave</div><div class="sh-line"></div></div>

  <div class="kpis">
    <div class="kpi" data-icon="🎓"><div class="kpi-lbl">Muestra Graduados</div><div class="kpi-val v" id="kpi-total">2,151</div><div class="kpi-sub">Registros en el dataset</div></div>
    <div class="kpi am" data-icon="⏱"><div class="kpi-lbl">Promedio Global</div><div class="kpi-val a" id="kpi-avg">—</div><div class="kpi-sub">Años reales de estudio</div></div>
    <div class="kpi rd" data-icon="📊"><div class="kpi-lbl">Máx. Rezago</div><div class="kpi-val r" id="kpi-max">—</div><div class="kpi-sub">Años sobre duración oficial</div></div>
    <div class="kpi az" data-icon="✅"><div class="kpi-lbl">Graduados a Tiempo</div><div class="kpi-val" id="kpi-ontime">—</div><div class="kpi-sub">Dentro de la duración oficial</div></div>
    <div class="kpi gr" data-icon="🌱"><div class="kpi-lbl">Carreras Analizadas</div><div class="kpi-val">9</div><div class="kpi-sub">Programas académicos</div></div>
    <div class="kpi gr" data-icon="📅"><div class="kpi-lbl">Cohortes</div><div class="kpi-val">6</div><div class="kpi-sub">Años de ingreso analizados</div></div>
  </div>

  <div class="hls" id="highlights"></div>

  <div class="filters">
    <span class="flbl">Año ingreso</span>
    <div class="fgrp" id="year-filters"></div>
    <div class="fsep"></div>
    <span class="flbl">Carrera</span>
    <select id="career-select"><option value="">Todas las carreras</option></select>
  </div>

  <div class="sh"><div class="sh-bar"></div><div class="sh-txt">Análisis Comparativo</div><div class="sh-line"></div></div>
  <div class="g2">
    <div class="panel">
      <div class="panel-hd"><div class="panel-ey">Comparativa</div><div class="panel-tt">Promedio Real vs. Duración Oficial</div><div class="panel-sub">Años promedio de estudio por carrera</div></div>
      <div class="chart-wrap" style="height:300px"><canvas id="chart-compare"></canvas></div>
    </div>
    <div class="panel az">
      <div class="panel-hd"><div class="panel-ey az">Rezago</div><div class="panel-tt">Años Adicionales por Carrera</div><div class="panel-sub">Diferencia respecto a la duración oficial</div></div>
      <div class="chart-wrap" style="height:300px"><canvas id="chart-delay"></canvas></div>
    </div>
  </div>

  <div class="sh"><div class="sh-bar"></div><div class="sh-txt">Tendencias y Distribución</div><div class="sh-line"></div></div>
  <div class="g3">
    <div class="panel">
      <div class="panel-hd"><div class="panel-ey">Tendencia temporal</div><div class="panel-tt">Evolución del Promedio por Cohorte</div><div class="panel-sub">¿Los estudiantes recientes tardan menos?</div></div>
      <div class="chart-wrap" style="height:270px"><canvas id="chart-trend"></canvas></div>
    </div>
    <div class="panel am">
      <div class="panel-hd"><div class="panel-ey am">Dispersión</div><div class="panel-tt">Distribución por Años</div><div class="panel-sub">Concentración de graduados</div></div>
      <div class="chart-wrap" style="height:270px"><canvas id="chart-dist"></canvas></div>
    </div>
  </div>

  <div class="sh"><div class="sh-bar"></div><div class="sh-txt">Mapa de Calor · Carrera × Cohorte</div><div class="sh-line"></div></div>
  <div class="panel" style="margin-bottom:16px">
    <div class="panel-hd"><div class="panel-ey">Mapa de calor</div><div class="panel-tt">Promedio de Años por Carrera y Cohorte</div><div class="panel-sub">Verde → graduación más rápida · Rojo/amarillo → mayor rezago</div></div>
    <div id="heatmap" style="overflow-x:auto;"></div>
  </div>

  <div class="sh"><div class="sh-bar"></div><div class="sh-txt">Detalle por Carrera</div><div class="sh-line"></div></div>
  <div class="tpanel">
    <div class="thead2"><div class="thead2-tt">Resumen Estadístico por Carrera</div><span class="badge bi">Interactivo</span></div>
    <div class="twrap">
      <table>
        <thead><tr>
          <th>Carrera</th><th style="text-align:right">N° Graduados</th>
          <th style="text-align:right">Dur. Oficial</th><th style="text-align:right">Prom. Real</th>
          <th style="text-align:right">Rezago</th><th style="min-width:150px">Tiempo Real</th>
          <th style="text-align:right">A Tiempo</th><th style="text-align:right">Estado</th>
        </tr></thead>
        <tbody id="table-body"></tbody>
      </table>
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
      <div class="fs">Secretaría de Tecnología de la Información y Comunicaciones (SETIC) · Dashboard Analítico · Tiempo de Titulación · 2025</div>
    </div>
    <img src="https://setic.unag.edu.hn/img/logo-setic-blanco.png" alt="SETIC UNAG">
  </div>
</div>

<script>
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

const CAREERS = [
  { carrera:"Administración de Empresas Agropecuarias", duracion:4, total:56, avg:4.57,
    dist:{4:38,5:10,6:5,7:1,8:1,9:1},
    byYear:{2016:{avg:6.08,n:12},2018:{avg:6,n:1},2019:{avg:5,n:5},2021:{avg:4,n:31},2022:{avg:4,n:7}} },
  { carrera:"Economía Social Agraria", duracion:4, total:3, avg:4.00, dist:{4:3}, byYear:{2021:{avg:4,n:3}} },
  { carrera:"Ingeniería Agronómica", duracion:4, total:1415, avg:4.27,
    dist:{4:1014,"4.3":152,5:182,6:50,7:15,8:2},
    byYear:{2016:{avg:4.42,n:624},2018:{avg:4.12,n:357},2019:{avg:4.08,n:208},2020:{avg:4.31,n:116},2021:{avg:4.19,n:110}} },
  { carrera:"Ing. Gestión Integral Rec. Naturales", duracion:4, total:71, avg:4.32,
    dist:{4:19,"4.3":42,5:10}, byYear:{2019:{avg:4.15,n:20},2020:{avg:4.43,n:34},2021:{avg:4.3,n:17}} },
  { carrera:"Ingeniería en Tecnología Alimentaria", duracion:4, total:153, avg:4.47,
    dist:{4:2,"4.3":122,5:24,6:4,7:1},
    byYear:{2018:{avg:7,n:1},2019:{avg:4.65,n:48},2020:{avg:4.4,n:61},2021:{avg:4.3,n:43}} },
  { carrera:"Ingeniería en Zootecnia", duracion:4, total:66, avg:4.02,
    dist:{4:65,5:1}, byYear:{2020:{avg:5,n:1},2021:{avg:4,n:35},2022:{avg:4,n:30}} },
  { carrera:"Medicina Veterinaria", duracion:5.6, total:45, avg:5.65,
    dist:{"5.6":39,6:6}, byYear:{2019:{avg:5.76,n:15},2020:{avg:5.6,n:30}} },
  { carrera:"Recursos Naturales y Ambiente", duracion:4, total:125, avg:4.35,
    dist:{4:100,5:15,6:6,8:3,9:1}, byYear:{2016:{avg:4.37,n:115},2018:{avg:4.1,n:10}} },
  { carrera:"Tecnología Alimentaria", duracion:4, total:217, avg:4.40,
    dist:{4:168,5:25,6:15,7:6,8:2,9:1}, byYear:{2016:{avg:4.44,n:183},2018:{avg:4.18,n:34}} },
];
const YEAR_AVG={2016:4.44,2018:4.14,2019:4.28,2020:4.51,2021:4.16,2022:4.0};
const ALL_YEARS=[2016,2018,2019,2020,2021,2022];
const PALETTE=['#1BA333','#203B76','#d4870a','#135423','#0094E9','#5B3700','#4caf72','#6bbd8e','#8faa8f'];

let activeYears=new Set(ALL_YEARS), activeCareer='', charts={};
const fmt=v=>Number(v).toFixed(2), fmtS=v=>Number(v).toFixed(1);
const getF=()=>activeCareer?CAREERS.filter(c=>c.carrera===activeCareer):CAREERS;

function initFilters(){
  const yf=document.getElementById('year-filters');
  const aBtn=document.createElement('button'); aBtn.className='fbtn active'; aBtn.textContent='Todos'; aBtn.dataset.year='all';
  aBtn.onclick=()=>{ activeYears=new Set(ALL_YEARS); yf.querySelectorAll('.fbtn').forEach(b=>b.classList.toggle('active',b.dataset.year==='all')); render(); };
  yf.appendChild(aBtn);
  ALL_YEARS.forEach(y=>{
    const b=document.createElement('button'); b.className='fbtn'; b.textContent=y; b.dataset.year=y;
    b.onclick=()=>{
      aBtn.classList.remove('active');
      activeYears.has(y)?(activeYears.delete(y),b.classList.remove('active')):(activeYears.add(y),b.classList.add('active'));
      if(!activeYears.size||activeYears.size===ALL_YEARS.length){activeYears=new Set(ALL_YEARS);yf.querySelectorAll('.fbtn').forEach(x=>x.classList.remove('active'));aBtn.classList.add('active');}
      render();
    };
    yf.appendChild(b);
  });
  const cs=document.getElementById('career-select');
  CAREERS.forEach(c=>{const o=document.createElement('option');o.value=c.carrera;o.textContent=c.carrera;cs.appendChild(o);});
  cs.onchange=()=>{activeCareer=cs.value;render();};
}

function renderKPIs(){
  const d=getF(), tot=d.reduce((s,c)=>s+c.total,0);
  const avg=d.reduce((s,c)=>s+c.avg*c.total,0)/tot;
  const mxr=Math.max(...d.map(c=>c.avg-c.duracion));
  const ot=d.reduce((s,c)=>s+(c.dist[c.duracion]||c.dist[String(c.duracion)]||0),0);
  document.getElementById('total-count').textContent=tot.toLocaleString('es');
  document.getElementById('kpi-total').textContent=tot.toLocaleString('es');
  document.getElementById('kpi-avg').textContent=fmt(avg)+'a';
  document.getElementById('kpi-max').textContent='+'+fmtS(mxr)+'a';
  document.getElementById('kpi-ontime').textContent=Math.round(ot/tot*100)+'%';
}

function renderHighlights(){
  const d=getF(), s=[...d].sort((a,b)=>a.avg-b.avg);
  const bc=Object.entries(YEAR_AVG).sort((a,b)=>a[1]-b[1])[0];
  const mr=[...d].sort((a,b)=>(b.avg-b.duracion)-(a.avg-a.duracion))[0];
  document.getElementById('highlights').innerHTML=`
    <div class="hl"><div class="hl-icon hiv">🏆</div><div><div class="hl-lbl">Más Rápida</div><div class="hl-val">${fmtS(s[0].avg)} años</div><div class="hl-desc">${s[0].carrera}</div></div></div>
    <div class="hl"><div class="hl-icon hia">⏳</div><div><div class="hl-lbl">Mayor Duración</div><div class="hl-val">${fmtS(s[s.length-1].avg)} años</div><div class="hl-desc">${s[s.length-1].carrera}</div></div></div>
    <div class="hl"><div class="hl-icon hib">📈</div><div><div class="hl-lbl">Mayor Rezago</div><div class="hl-val">+${fmtS(mr.avg-mr.duracion)} años</div><div class="hl-desc">${mr.carrera}</div></div></div>
    <div class="hl"><div class="hl-icon hiw">📅</div><div><div class="hl-lbl">Mejor Cohorte</div><div class="hl-val">${bc[0]}</div><div class="hl-desc">${fmtS(bc[1])} años promedio</div></div></div>`;
}

function renderCompare(){
  const d=getF(), lb=d.map(c=>c.carrera.replace('Ingeniería en ','Ing. ').replace('Administración de ','Adm. '));
  if(charts.c)charts.c.destroy();
  charts.c=new Chart(document.getElementById('chart-compare'),{type:'bar',data:{labels:lb,datasets:[
    {label:'Promedio Real',data:d.map(c=>c.avg),backgroundColor:'rgba(27,163,51,0.8)',borderColor:'#1BA333',borderWidth:1,borderRadius:5},
    {label:'Duración Oficial',data:d.map(c=>c.duracion),backgroundColor:'rgba(32,59,118,0.15)',borderColor:'#203B76',borderWidth:1.5,borderRadius:5}
  ]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{labels:{color:'#3d5c3d',font:{size:10,weight:'600'},boxWidth:12}},tooltip:{...TT,borderColor:'#1BA333'}},scales:{x:{ticks:{color:'#6b8a6b',font:{size:9,weight:'600'},maxRotation:40},grid:{color:'rgba(27,163,51,0.06)'}},y:{ticks:{color:'#6b8a6b',font:{size:10,weight:'600'}},grid:{color:'rgba(27,163,51,0.08)'},min:0}}}});
}

function renderDelay(){
  const d=getF().filter(c=>c.avg-c.duracion>0).sort((a,b)=>(b.avg-b.duracion)-(a.avg-a.duracion));
  const del=d.map(c=>+(c.avg-c.duracion).toFixed(2));
  const col=del.map(v=>v>1.5?'rgba(192,48,48,.8)':v>0.5?'rgba(212,135,10,.8)':'rgba(27,163,51,.8)');
  if(charts.d)charts.d.destroy();
  charts.d=new Chart(document.getElementById('chart-delay'),{type:'bar',data:{labels:d.map(c=>c.carrera.replace('Ingeniería en ','Ing. ').replace('Administración de ','Adm. ')),datasets:[{label:'Rezago (años)',data:del,backgroundColor:col,borderRadius:5,borderSkipped:false}]},options:{indexAxis:'y',responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false},tooltip:{...TT,borderColor:'#203B76',callbacks:{label:ctx=>` +${ctx.raw} años sobre la duración oficial`}}},scales:{x:{ticks:{color:'#6b8a6b',font:{size:10,weight:'600'}},grid:{color:'rgba(27,163,51,0.06)'}},y:{ticks:{color:'#3d5c3d',font:{size:9,weight:'600'}},grid:{color:'rgba(27,163,51,0.04)'}}}}});
}

function renderTrend(){
  const yrs=[...activeYears].sort(), ds=[];
  getF().filter(c=>Object.keys(c.byYear).length>1).forEach((c,i)=>{
    ds.push({label:c.carrera.replace('Ingeniería en ','Ing. ').replace('Ingeniería ','Ing. ').replace('Administración de ','Adm. '),
      data:yrs.map(y=>c.byYear[y]?c.byYear[y].avg:null),
      borderColor:PALETTE[i%PALETTE.length],backgroundColor:'transparent',tension:.4,borderWidth:2,pointRadius:4,pointHoverRadius:6,spanGaps:true});
  });
  ds.push({label:'— Global',data:yrs.map(y=>activeYears.has(y)?YEAR_AVG[y]:null),borderColor:'#203B76',backgroundColor:'transparent',tension:.4,borderWidth:2.5,borderDash:[6,3],pointRadius:3,spanGaps:true});
  if(charts.t)charts.t.destroy();
  charts.t=new Chart(document.getElementById('chart-trend'),{type:'line',data:{labels:yrs,datasets:ds},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{labels:{color:'#6b8a6b',font:{size:9,weight:'600'},boxWidth:14,padding:10}},tooltip:{...TT,borderColor:'#1BA333'}},scales:{x:{ticks:{color:'#6b8a6b',font:{size:10,weight:'600'}},grid:{color:'rgba(27,163,51,0.06)'}},y:{ticks:{color:'#6b8a6b',font:{size:10,weight:'600'}},grid:{color:'rgba(27,163,51,0.08)'},min:3.5}}}});
}

function renderDist(){
  const ad={};
  getF().forEach(c=>Object.entries(c.dist).forEach(([k,v])=>{ad[k]=(ad[k]||0)+v;}));
  const sr=Object.entries(ad).sort((a,b)=>+a[0]-(+b[0])), tot=sr.reduce((s,e)=>s+e[1],0);
  const col=sr.map(([k])=>{const n=+k;return n<=4.3?'rgba(27,163,51,0.85)':n<=5?'rgba(255,204,0,0.85)':'rgba(192,48,48,0.85)';});
  if(charts.di)charts.di.destroy();
  charts.di=new Chart(document.getElementById('chart-dist'),{type:'doughnut',data:{labels:sr.map(e=>e[0]+'a'),datasets:[{data:sr.map(e=>+(e[1]/tot*100).toFixed(1)),backgroundColor:col,borderColor:'#fff',borderWidth:2}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'bottom',labels:{color:'#3d5c3d',font:{size:10,weight:'600'},padding:12,boxWidth:12}},tooltip:{...TT,borderColor:'#1BA333',callbacks:{label:ctx=>` ${ctx.label}: ${ctx.raw}% de graduados`}}},cutout:'62%'}});
}

function renderHeatmap(){
  const d=getF(), yrs=[...activeYears].sort();
  const av=d.flatMap(c=>Object.values(c.byYear).map(v=>v.avg));
  const mn=Math.min(...av), mx=Math.max(...av);
  function hc(v){
    const t=(v-mn)/(mx-mn);
    if(t<0.5){const t2=t*2;return `rgb(${Math.round(27+(255-27)*t2)},${Math.round(163+(204-163)*t2)},${Math.round(51+(0-51)*t2)})`;}
    else{const t2=(t-0.5)*2;return `rgb(${Math.round(255+(192-255)*t2)},${Math.round(204+(48-204)*t2)},0)`;}
  }
  let h='<table style="width:100%;border-collapse:collapse;font-size:11px;">';
  h+='<thead><tr>';
  h+='<th style="padding:10px 16px;text-align:left;color:#203B76;font-size:9px;letter-spacing:.14em;text-transform:uppercase;font-weight:800;background:#eef4ee;border-bottom:2px solid #1BA333;font-family:Montserrat,sans-serif;">Carrera</th>';
  yrs.forEach(y=>{h+=`<th style="padding:10px 12px;text-align:center;color:#203B76;font-size:9px;letter-spacing:.14em;text-transform:uppercase;font-weight:800;background:#eef4ee;border-bottom:2px solid #1BA333;font-family:Montserrat,sans-serif;">${y}</th>`;});
  h+='<th style="padding:10px 12px;text-align:center;color:#1BA333;font-size:9px;letter-spacing:.14em;text-transform:uppercase;font-weight:800;background:#eef4ee;border-bottom:2px solid #1BA333;font-family:Montserrat,sans-serif;">GLOBAL</th></tr></thead><tbody>';
  d.forEach((c,ri)=>{
    h+=`<tr style="background:${ri%2?'#f7fdf7':'#fff'}">`;
    h+=`<td style="padding:10px 16px;color:#203B76;border-bottom:1px solid #d0e4d0;font-weight:600;max-width:230px;font-family:'Open Sans',sans-serif;">${c.carrera}</td>`;
    yrs.forEach(y=>{
      const e=c.byYear[y];
      if(e){const col=hc(e.avg),tc=e.avg<4.5?'#fff':'#1a2b1a';h+=`<td style="padding:10px 12px;text-align:center;border-bottom:1px solid #d0e4d0;"><div style="display:inline-block;background:${col};color:${tc};padding:5px 11px;border-radius:6px;font-weight:700;font-size:11px;font-family:Montserrat,sans-serif;">${fmtS(e.avg)}a<br><span style="font-size:9px;opacity:.8">n=${e.n}</span></div></td>`;}
      else h+=`<td style="padding:10px 12px;text-align:center;border-bottom:1px solid #d0e4d0;color:#d0e4d0;font-family:Montserrat,sans-serif;">—</td>`;
    });
    const gc=hc(c.avg),gt=c.avg<4.5?'#fff':'#1a2b1a';
    h+=`<td style="padding:10px 12px;text-align:center;border-bottom:1px solid #d0e4d0;"><div style="display:inline-block;background:${gc};color:${gt};padding:5px 11px;border-radius:6px;font-weight:800;font-size:11px;font-family:Montserrat,sans-serif;">${fmtS(c.avg)}a</div></td>`;
    h+='</tr>';
  });
  h+='</tbody></table>';
  document.getElementById('heatmap').innerHTML=h;
}

function renderTable(){
  const d=getF().sort((a,b)=>b.avg-a.avg), mxa=Math.max(...CAREERS.map(c=>c.avg));
  const tb=document.getElementById('table-body'); tb.innerHTML='';
  d.forEach(c=>{
    const rz=+(c.avg-c.duracion).toFixed(2);
    const ot=c.dist[c.duracion]||c.dist[String(c.duracion)]||0;
    const pct=Math.round(ot/c.total*100), bw=Math.round(c.avg/mxa*100);
    const bc=rz>1.5?'#c03030':rz>0.5?'#d4870a':'#1BA333';
    const badge=rz>1.5?'<span class="badge bb">Rezago alto</span>':rz>0.2?'<span class="badge bw">Rezago leve</span>':'<span class="badge bv">A tiempo</span>';
    const tr=document.createElement('tr');
    tr.innerHTML=`<td class="tdc">${c.carrera}</td><td class="tdn">${c.total.toLocaleString('es')}</td><td class="tdn" style="color:var(--text-muted)">${c.duracion}a</td><td class="tda">${fmt(c.avg)}a</td><td class="tdn" style="color:${bc}">${rz>0?'+':''}${fmt(rz)}a</td><td><div class="bar-cell"><div class="bar-track"><div class="bar-fill" style="width:${bw}%;background:${bc}"></div></div><div class="bar-val">${fmtS(c.avg)}a</div></div></td><td class="tdn" style="color:${pct>70?'#1BA333':'#d4870a'}">${pct}%</td><td>${badge}</td>`;
    tb.appendChild(tr);
  });
}

function render(){renderKPIs();renderHighlights();renderCompare();renderDelay();renderTrend();renderDist();renderHeatmap();renderTable();}
initFilters();render();
</script>
</html>