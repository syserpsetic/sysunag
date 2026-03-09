<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Titulación Oportuna</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<link rel="shortcut icon" href="{{ asset('/favicon.png') }}">
<style>
  :root {
    --bg: #0d1117;
    --surface: #161b22;
    --surface2: #1c2330;
    --border: #2a3441;
    --accent: #f0b429;
    --accent4: #6e9ef5;
    --text: #e6edf3;
    --muted: #7d8590;
    --ontime: #3ecf8e;
    --extra1: #f0b429;
    --extra2: #e07b54;
    --extra3: #e05454;
    --nograd: #2a3441;
  }
  * { margin:0; padding:0; box-sizing:border-box; }
  body { background:var(--bg); color:var(--text); font-family:sans-serif; min-height:100vh; }

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
  .logo { font-family:sans-serif; font-weight:800; font-size:18px; letter-spacing:-0.5px; }
  .logo span { color:var(--accent); }
  .header-meta { font-size:12px; color:var(--muted); dgap:24px;margin-left: auto;}
  .badge { background:rgba(240,180,41,0.12); color:var(--accent); border:1px solid rgba(240,180,41,0.3); padding:3px 10px; border-radius:20px; font-size:11px; font-weight:500; }
 
  .eyebrow {
    font-family: sans-serif;
    font-size: 11px;
    letter-spacing: 0.2em;
    color: var(--accent);
    text-transform: uppercase;
    
  }
  .container { max-width:1440px; margin:0 auto; padding:24px 32px; }

  .filters {
    background:var(--surface); border:1px solid var(--border); border-radius:12px;
    padding:16px 24px; margin-bottom:24px; display:flex; gap:24px; align-items:center; flex-wrap:wrap;
  }
  .filter-group { display:flex; flex-direction:column; gap:4px; }
  .filter-label { font-size:10px; text-transform:uppercase; letter-spacing:1px; color:var(--muted); font-weight:500; }
  select {
    background:var(--surface2); border:1px solid var(--border); color:var(--text);
    padding:7px 32px 7px 12px; border-radius:8px; font-family:'DM Sans',sans-serif; font-size:13px;
    cursor:pointer; outline:none; appearance:none; min-width:180px; transition:border-color .2s;
    background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%237d8590'/%3E%3C/svg%3E");
    background-repeat:no-repeat; background-position:right 10px center;
  }
  select:hover { border-color:var(--accent); }
  .filter-divider { width:1px; height:36px; background:var(--border); }

  .kpi-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px; }
  .kpi-card {
    background:var(--surface); border:1px solid var(--border); border-radius:12px;
    padding:20px 24px; position:relative; overflow:hidden; transition:transform .2s,border-color .2s;
  }
  .kpi-card:hover { transform:translateY(-2px); border-color:var(--accent); }
  .kpi-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; }
  .kpi-card.green::before { background:var(--ontime); }
  .kpi-card.yellow::before { background:var(--accent); }
  .kpi-card.orange::before { background:var(--extra2); }
  .kpi-card.blue::before { background:var(--accent4); }
  .kpi-label { font-size:11px; text-transform:uppercase; letter-spacing:1px; color:var(--muted); font-weight:500; margin-bottom:10px; }
  .kpi-value { font-family:'Syne',sans-serif; font-size:32px; font-weight:800; line-height:1; margin-bottom:6px; }
  .kpi-sub { font-size:12px; color:var(--muted); }
  .kpi-card.green .kpi-value { color:var(--ontime); }
  .kpi-card.yellow .kpi-value { color:var(--accent); }
  .kpi-card.orange .kpi-value { color:var(--extra2); }
  .kpi-card.blue .kpi-value { color:var(--accent4); }

  .panel-grid { display:grid; grid-template-columns:1.8fr 1fr; gap:20px; margin-bottom:20px; }
  .panel-grid-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px; margin-bottom:20px; }
  .panel-full { margin-bottom:20px; }
  .panel { background:var(--surface); border:1px solid var(--border); border-radius:12px; overflow:hidden; }
  .panel-header { padding:16px 24px 12px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center; }
  .panel-title { font-family:'Syne',sans-serif; font-size:14px; font-weight:700; letter-spacing:-0.2px; }
  .panel-subtitle { font-size:11px; color:var(--muted); margin-top:2px; }
  .panel-body { padding:20px 24px; }

  .legend { display:flex; gap:16px; flex-wrap:wrap; }
  .legend-item { display:flex; align-items:center; gap:6px; font-size:11px; color:var(--muted); }
  .legend-dot { width:8px; height:8px; border-radius:2px; flex-shrink:0; }

  .stacked-bar-container { display:flex; flex-direction:column; gap:10px; }
  .bar-row { display:flex; align-items:center; gap:12px; }
  .bar-label { font-size:11px; color:var(--muted); width:130px; flex-shrink:0; text-align:right; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
  .bar-track { flex:1; height:26px; border-radius:4px; overflow:hidden; display:flex; background:var(--surface2); }
  .bar-segment { height:100%; transition:width .6s cubic-bezier(.4,0,.2,1); cursor:pointer; }
  .bar-segment:hover { filter:brightness(1.25); }
  .bar-total { font-size:11px; color:var(--muted); width:50px; text-align:right; }

  .funnel { display:flex; flex-direction:column; gap:8px; }
  .funnel-bar { height:26px; border-radius:4px; display:flex; align-items:center; padding:0 10px; transition:width .5s; }
  .funnel-bar span { font-size:10px; font-weight:600; white-space:nowrap; }

  .donut-wrap { display:flex; align-items:center; gap:24px; }
  .donut-labels { display:flex; flex-direction:column; gap:10px; flex:1; }
  .donut-label-row { display:flex; align-items:center; gap:8px; font-size:12px; }

  .cohort-table { width:100%; border-collapse:collapse; font-size:12px; }
  .cohort-table th { text-align:left; font-size:10px; text-transform:uppercase; letter-spacing:1px; color:var(--muted); font-weight:500; padding:8px 12px; border-bottom:1px solid var(--border); }
  .cohort-table td { padding:9px 12px; border-bottom:1px solid rgba(42,52,65,0.5); vertical-align:middle; }
  .cohort-table tr:last-child td { border-bottom:none; }
  .cohort-table tr:hover td { background:rgba(255,255,255,0.02); }
  .chip { display:inline-block; padding:2px 8px; border-radius:4px; font-size:10px; font-weight:600; }
  .chip-green { background:rgba(62,207,142,0.1); color:var(--ontime); }
  .chip-yellow { background:rgba(240,180,41,0.1); color:var(--extra1); }
  .chip-orange { background:rgba(224,123,84,0.1); color:var(--extra2); }

  #tooltip {
    position:fixed; background:var(--surface2); border:1px solid var(--border);
    border-radius:8px; padding:10px 14px; font-size:12px; pointer-events:none;
    opacity:0; transition:opacity .15s; z-index:1000; min-width:180px;
    box-shadow:0 8px 24px rgba(0,0,0,0.4);
  }
  #tooltip .tt-title { font-weight:600; margin-bottom:6px; font-size:13px; }
  #tooltip .tt-row { display:flex; justify-content:space-between; gap:16px; margin:2px 0; }
  #tooltip .tt-key { color:var(--muted); }
  #tooltip .tt-val { font-weight:600; }

  .note-bar {
    background:rgba(110,158,245,0.08); border:1px solid rgba(110,158,245,0.2);
    border-radius:8px; padding:10px 16px; font-size:12px; color:var(--accent4);
    margin-bottom:20px; display:flex; align-items:center; gap:8px;
  }
  .title-block { margin-bottom:20px; }
  .title-block h1 { font-family:sans-serif; ont-size: clamp(22px, 3vw, 36px);font-weight:800; letter-spacing:-0.5px; }
  .title-block p { font-size:13px; color:var(--muted); margin-top:4px; }
  .no-data { text-align:center; padding:32px; color:var(--muted); font-size:13px; }
  .animate-in { animation:fadeUp .4s ease both; }
  @keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }

  @media(max-width:1100px){
    .kpi-grid{grid-template-columns:repeat(2,1fr);}
    .panel-grid{grid-template-columns:1fr;}
    .panel-grid-3{grid-template-columns:1fr 1fr;}
  }
  @media(max-width:720px){
    .container{padding:16px;}
    .panel-grid-3{grid-template-columns:1fr;}
    .kpi-grid{grid-template-columns:1fr 1fr;}
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
  <div class="logo" >
    <img src="https://sys.unag.edu.hn/assets/images/escudo.png" style="width: 40px;" alt="unag">
  </div>
  <div class="logo">TITULACIÓN <span>OPORTUNA</span></div>
  <div  class="header-meta">
     <a style="text-decoration: none;" href="https://drive.google.com/file/d/1FfGcXCFLVw3O-KiQY9fe8V7lrZPKjh06/view?usp=sharing" target="_blank" rel="titulacion"><span class="badge">Descargar Muestra en EXCEL</span></a>     
     <a style="text-decoration: none;" href="https://drive.google.com/file/d/18CXw0QC1J_13FRCo7FkHRXPaT1KgWTw1/view?usp=sharing" target="_blank" rel="titulacion"><span class="badge"> Descargar Analisis en PDF</span></a>   
  </div>
</header>

<div id="tooltip"></div>
<div class="container"> 
  <div class="title-block animate-in">     
    <div class="eyebrow">Análisis Académico · Universidad Nacional de Agricultura (UNAG)</div> 
    <h1>Dashboard — Eficiencia de Titulación</h1>
    <div class="eyebrow">Unidad de Análisis · Secretaria de Tecnología de la Información y Comunicaciones (SETIC)</div>
    <p>Medición de cuántos estudiantes se gradúan dentro del tiempo establecido por el plan de estudios</p>
  </div>

  <div class="note-bar animate-in">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    Análisis restringido a cohortes <strong style="color:var(--text)">2016 – 2022</strong>: únicos años de ingreso con tiempo suficiente para haber completado el plan de estudios al momento del análisis.
  </div>

  <div class="filters animate-in">
    <div class="filter-group">
      <span class="filter-label">Carrera</span>
      <select id="filterCarrera" onchange="update()">
        <option value="all">Todas las carreras</option>
      </select>
    </div>
    <div class="filter-divider"></div>
    <div class="filter-group">
      <span class="filter-label">Año de ingreso</span>
      <select id="filterIngreso" onchange="update()">
        <option value="all">Todos (2016–2022)</option>
      </select>
    </div>
    <div style="margin-left:auto">
      <div class="legend">
        <div class="legend-item"><div class="legend-dot" style="background:var(--ontime)"></div>A tiempo</div>
        <div class="legend-item"><div class="legend-dot" style="background:var(--extra1)"></div>+1 año</div>
        <div class="legend-item"><div class="legend-dot" style="background:var(--extra2)"></div>+2 años</div>
        <div class="legend-item"><div class="legend-dot" style="background:var(--extra3)"></div>+3 o más</div>
        <div class="legend-item"><div class="legend-dot" style="background:var(--nograd);border:1px solid #3a4553"></div>Sin graduarse</div>
      </div>
    </div>
  </div>

  <div class="kpi-grid animate-in">
    <div class="kpi-card green">
      <div class="kpi-label">Graduados a tiempo</div>
      <div class="kpi-value" id="kpi1">—</div>
      <div class="kpi-sub" id="kpi1s">dentro del plan de estudios</div>
    </div>
    <div class="kpi-card yellow">
      <div class="kpi-label">Tasa de graduación</div>
      <div class="kpi-value" id="kpi2">—</div>
      <div class="kpi-sub" id="kpi2s">sobre total ingresantes</div>
    </div>
    <div class="kpi-card orange">
      <div class="kpi-label">Graduados tardíos</div>
      <div class="kpi-value" id="kpi3">—</div>
      <div class="kpi-sub" id="kpi3s">superaron el tiempo plan</div>
    </div>
    <div class="kpi-card blue">
      <div class="kpi-label">Sin graduarse</div>
      <div class="kpi-value" id="kpi4">—</div>
      <div class="kpi-sub" id="kpi4s">no registran egreso</div>
    </div>
  </div>

  <div class="panel-grid animate-in">
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
    <div class="panel">
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

  <div class="panel panel-full animate-in">
    <div class="panel-header">
      <div>
        <div class="panel-title">Análisis por cohorte de ingreso (2016–2022)</div>
        <div class="panel-subtitle">Seguimiento generacional — titulación oportuna por año de ingreso</div>
      </div>
    </div>
    <div class="panel-body">
      <table class="cohort-table">
        <thead>
          <tr>
            <th>Cohorte</th>
            <th>Ingresantes</th>
            <th>Graduados</th>
            <th>% Graduación</th>
            <th>A tiempo</th>
            <th>+1 año</th>
            <th>+2 años</th>
            <th>+3 o más</th>
            <th>Sin graduarse</th>
            <th>Distribución visual</th>
          </tr>
        </thead>
        <tbody id="cohortBody"></tbody>
      </table>
    </div>
  </div>

  <div class="panel-grid-3 animate-in">
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
    <div class="panel">
      <div class="panel-header">
        <div class="panel-title">Promedio años cursados</div>
        <div class="panel-subtitle">vs. duración del plan (línea verde)</div>
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

  <footer>
    <div>Dashboard Analítico · Titulación Oportuna</div>
    <div> <img src="https://setic.unag.edu.hn/img/logo-setic-blanco.png" style="width: 200px;" alt="setic"> </div>
  </footer>

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

const C={ontime:'#3ecf8e',extra1:'#f0b429',extra2:'#e07b54',extra3:'#e05454',nograd:'#2a3441'};

// Init selects
const selC=document.getElementById('filterCarrera');
const selY=document.getElementById('filterIngreso');
Object.keys(CARRERA_DATA).forEach(n=>{const o=document.createElement('option');o.value=n;o.textContent=n;selC.appendChild(o);});
Object.keys(COHORT_DATA).forEach(y=>{const o=document.createElement('option');o.value=y;o.textContent=y;selY.appendChild(o);});

// Tooltip
const tip=document.getElementById('tooltip');
function showTip(e,title,rows){
  tip.innerHTML=`<div class="tt-title">${title}</div>`+rows.map(([k,v,c])=>`<div class="tt-row"><span class="tt-key">${k}</span><span class="tt-val" style="color:${c||'#e6edf3'}">${v}</span></div>`).join('');
  tip.style.opacity=1;
}
document.addEventListener('mousemove',e=>{tip.style.left=Math.min(e.clientX+14,window.innerWidth-200)+'px';tip.style.top=(e.clientY-10)+'px';});
function hideTip(){tip.style.opacity=0;}

function breakdown(d){
  let on=0,e1=0,e2=0,e3=0;
  for(const yr in d.dist){const ex=parseInt(yr)-d.dur,n=d.dist[yr];if(ex<=0)on+=n;else if(ex<=1)e1+=n;else if(ex<=2)e2+=n;else e3+=n;}
  return{ontime:on,extra1:e1,extra2:e2,extra3:e3,nograd:d.total-d.grad};
}

function getFiltered(){
  const fc=selC.value,fy=selY.value;
  const cData=fc==='all'?{...CARRERA_DATA}:{[fc]:CARRERA_DATA[fc]};
  const cohData=fy==='all'?{...COHORT_DATA}:{[fy]:COHORT_DATA[fy]};
  return{cData,cohData};
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
  const el=document.getElementById('barByCarrera');
  el.innerHTML='';
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
      const seg=document.createElement('div');
      seg.className='bar-segment';seg.style.width=pct+'%';seg.style.background=color;
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
  ctx.beginPath();ctx.arc(70,70,38,0,2*Math.PI);ctx.fillStyle='#161b22';ctx.fill();
  ctx.fillStyle='#e6edf3';ctx.font='bold 18px Syne,sans-serif';ctx.textAlign='center';
  ctx.fillText(sum>0?(a.grad/a.total*100).toFixed(0)+'%':'—',70,74);
  ctx.fillStyle='#7d8590';ctx.font='10px DM Sans,sans-serif';ctx.fillText('graduados',70,88);
  const labEl=document.getElementById('donutLabels');
  labEl.innerHTML='';
  segs.filter(s=>s.val>0).forEach(s=>{
    const pct=sum>0?(s.val/sum*100).toFixed(1):'0';
    labEl.innerHTML+=`<div class="donut-label-row"><div style="width:10px;height:10px;border-radius:2px;background:${s.color};flex-shrink:0"></div><span style="color:var(--muted);font-size:11px;flex:1">${s.label}</span><span style="font-weight:700;font-size:13px;color:${s.color}">${pct}%</span></div>`;
  });
}

function renderFunnel(a){
  const el=document.getElementById('funnelChart');el.innerHTML='';
  const steps=[
    {label:'Ingresantes totales',val:a.total,color:'#6e9ef5'},
    {label:'Se gradúan',val:a.grad,color:'#3ecf8e'},
    {label:'A tiempo (≤ plan)',val:a.ontime,color:'#3ecf8e'},
    {label:'Acumulado con +1 año',val:a.ontime+a.extra1,color:'#f0b429'},
    {label:'Acumulado con +2 años',val:a.ontime+a.extra1+a.extra2,color:'#e07b54'},
  ];
  steps.forEach(s=>{
    const pct=a.total>0?(s.val/a.total*100):0;
    el.innerHTML+=`<div><div style="display:flex;justify-content:space-between;margin-bottom:3px"><span style="font-size:11px;color:var(--muted)">${s.label}</span><span style="font-size:11px;font-weight:600;color:${s.color}">${s.val.toLocaleString()}</span></div><div class="funnel-bar" style="width:${Math.max(pct,1)}%;background:${s.color}20;border-left:3px solid ${s.color}"><span style="color:${s.color}">${pct.toFixed(1)}%</span></div></div>`;
  });
}

function renderCohortTable(cohData){
  const tbody=document.getElementById('cohortBody');tbody.innerHTML='';
  Object.entries(cohData).sort((a,b)=>a[0]-b[0]).forEach(([yr,d])=>{
    const ng=d.total-d.grad,T=d.total;
    const pG=T>0?(d.grad/T*100):0,pOn=T>0?(d.ontime/T*100):0;
    const p1=T>0?(d.extra1/T*100):0,p2=T>0?(d.extra2/T*100):0,p3=T>0?(d.extra3/T*100):0,pNG=T>0?(ng/T*100):0;
    const col=pG>=60?'var(--ontime)':pG>=30?'var(--accent)':'var(--extra2)';
    tbody.innerHTML+=`<tr>
      <td><strong style="font-family:Syne,sans-serif;font-size:15px">${yr}</strong></td>
      <td>${T.toLocaleString()}</td>
      <td>${d.grad.toLocaleString()}</td>
      <td><div style="display:flex;align-items:center;gap:8px"><div style="height:6px;width:${Math.min(pG,60)}px;border-radius:3px;background:${col}"></div><span style="font-weight:600;color:${col}">${pG.toFixed(1)}%</span></div></td>
      <td><span class="chip chip-green">${d.ontime} (${pOn.toFixed(0)}%)</span></td>
      <td>${d.extra1>0?`<span class="chip chip-yellow">${d.extra1} (${p1.toFixed(0)}%)</span>`:'<span style="color:var(--muted)">—</span>'}</td>
      <td>${d.extra2>0?`<span class="chip chip-orange">${d.extra2} (${p2.toFixed(0)}%)</span>`:'<span style="color:var(--muted)">—</span>'}</td>
      <td>${d.extra3>0?`<span style="color:var(--extra3);font-weight:600;font-size:12px">${d.extra3} (${p3.toFixed(0)}%)</span>`:'<span style="color:var(--muted)">—</span>'}</td>
      <td><span style="color:var(--muted)">${ng.toLocaleString()} (${pNG.toFixed(0)}%)</span></td>
      <td><div style="display:flex;height:10px;border-radius:4px;overflow:hidden;width:130px;gap:1px">
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
  if(!Object.keys(dist).length){el.innerHTML='<div class="no-data">Sin datos</div>';return;}
  const sorted=Object.entries(dist).sort((a,b)=>+a[0]-+b[0]);
  const maxV=Math.max(...sorted.map(s=>s[1]));
  sorted.forEach(([yr,cnt])=>{
    const h=Math.max((cnt/maxV)*160,4);
    const col=document.createElement('div');
    col.style.cssText='flex:1;display:flex;flex-direction:column;align-items:center;gap:4px;cursor:pointer;';
    col.innerHTML=`<span style="font-size:9px;color:var(--muted)">${cnt}</span><div style="width:100%;height:${h}px;background:var(--accent4);border-radius:3px 3px 0 0;transition:.3s"></div>`;
    col.addEventListener('mouseenter',e=>{col.querySelector('div').style.background='var(--accent)';showTip(e,`Año ${yr} de cursado`,[['Graduados',cnt.toLocaleString()],['Proporción',(cnt/maxV*100).toFixed(0)+'% del máximo']]);});
    col.addEventListener('mouseleave',()=>{col.querySelector('div').style.background='var(--accent4)';hideTip();});
    el.appendChild(col);
    labEl.innerHTML+=`<span style="flex:1;text-align:center;font-size:9px;color:var(--muted)">${yr}a</span>`;
  });
}

function renderAvgChart(cData){
  const el=document.getElementById('avgChart');el.innerHTML='';
  const entries=Object.entries(cData).filter(([,d])=>d.grad>0);
  if(!entries.length){el.innerHTML='<div class="no-data">Sin datos</div>';return;}
  const avgs=entries.map(([name,d])=>{let s=0,c=0;for(const yr in d.dist){s+=parseInt(yr)*d.dist[yr];c+=d.dist[yr];}return{name,avg:c?s/c:0,dur:d.dur};}).sort((a,b)=>a.avg-b.avg);
  const maxAvg=Math.max(...avgs.map(a=>a.avg));
  avgs.forEach(({name,avg,dur})=>{
    const short=name.replace('Ingeniería en ','').replace('Ingeniería ','Ing. ').replace('Administración de Empresas Agropecuarias','Admón. Agropec.').replace('Recursos Naturales y Ambiente','Rec. Naturales');
    const over=avg>dur,color=over?'var(--extra2)':'var(--ontime)';
    el.innerHTML+=`<div><div style="display:flex;justify-content:space-between;margin-bottom:3px"><span style="font-size:10px;color:var(--muted)">${short}</span><span style="font-size:11px;font-weight:600;color:${color}">${avg.toFixed(2)}a <span style="color:var(--muted);font-weight:400;font-size:10px">(plan: ${dur}a)</span></span></div><div style="height:10px;background:var(--surface2);border-radius:4px;overflow:hidden;position:relative"><div style="height:100%;width:${(dur/maxAvg*100).toFixed(0)}%;background:rgba(62,207,142,0.15);position:absolute;border-right:2px dashed var(--ontime)"></div><div style="height:100%;width:${(avg/maxAvg*100).toFixed(0)}%;background:${color};border-radius:4px;transition:.4s"></div></div></div>`;
  });
}

function renderRateChart(cData){
  const el=document.getElementById('rateChart');el.innerHTML='';
  Object.entries(cData).sort((a,b)=>(b[1].grad/b[1].total)-(a[1].grad/a[1].total)).forEach(([name,d])=>{
    const rate=d.total?(d.grad/d.total*100):0;
    const short=name.replace('Ingeniería en ','').replace('Ingeniería ','Ing. ').replace('Administración de Empresas Agropecuarias','Admón. Agropec.').replace('Recursos Naturales y Ambiente','Rec. Naturales');
    const color=rate>=60?'var(--ontime)':rate>=30?'var(--accent)':'var(--extra2)';
    el.innerHTML+=`<div><div style="display:flex;justify-content:space-between;margin-bottom:3px"><span style="font-size:10px;color:var(--muted)">${short}</span><span style="font-size:11px;font-weight:600;color:${color}">${rate.toFixed(1)}%</span></div><div style="height:10px;background:var(--surface2);border-radius:4px;overflow:hidden"><div style="height:100%;width:${rate.toFixed(0)}%;background:${color};border-radius:4px;transition:.4s"></div></div></div>`;
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