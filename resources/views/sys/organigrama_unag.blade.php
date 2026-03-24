
<link rel="shortcut icon" href="{{ asset('/favicon.png') }}">
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap');

* { box-sizing: border-box; margin: 0; padding: 0; }

.org-wrap {
  font-family: 'Montserrat', sans-serif;
  background: #fff;
  padding: 0 0 48px;
  width: 100%;
  overflow-x: auto;
}

.org-header {
  background: #203B76;
  padding: 18px 24px 16px;
  display: flex;
  align-items: center;
  gap: 16px;
  position: relative;
  overflow: hidden;
}

.org-header::after {
  content: '';
  position: absolute;
  top: -20px; right: -20px;
  width: 80px; height: 80px;
  background: #FFCC00;
  border-radius: 50%;
  opacity: 0.9;
}

.logo-text {
  display: flex;
  gap: 0;
  font-size: 28px;
  font-weight: 700;
  line-height: 1;
  letter-spacing: -1px;
}
.logo-u { color: #203B76; background:#fff; padding: 2px 4px; }
.logo-n { color: #FFCC00; background: #fff; padding: 2px 2px; }
.logo-a { color: #1BA333; background: #fff; padding: 2px 2px; }
.logo-g { color: #203B76; background: #fff; padding: 2px 4px; }

.header-title {
  color: #fff;
  font-size: 12px;
  font-weight: 600;
  letter-spacing: 1px;
  text-transform: uppercase;
  line-height: 1.4;
  z-index: 1;
}

.wave-top {
  width: 100%;
  display: block;
  line-height: 0;
}

.legend {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
  padding: 12px 24px;
  background: #f7f8fa;
  border-bottom: 2px solid #1BA333;
}
.leg-item {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 10px;
  font-weight: 600;
  color: #444;
  text-transform: uppercase;
  letter-spacing: 0.3px;
}
.leg-dot {
  width: 14px; height: 14px;
  border-radius: 3px;
  flex-shrink: 0;
}

.tree {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 32px 16px 0;
  min-width: 360px;
}

.node-wrap {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.node {
  padding: 9px 16px;
  border-radius: 8px;
  cursor: pointer;
  font-family: 'Montserrat', sans-serif;
  font-size: 10.5px;
  font-weight: 700;
  text-align: center;
  text-transform: uppercase;
  letter-spacing: 0.4px;
  line-height: 1.35;
  min-width: 130px;
  max-width: 170px;
  transition: transform 0.18s, box-shadow 0.18s;
  user-select: none;
  position: relative;
  border: none;
}
.node:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(0,0,0,0.15); }

.expand-pill {
  position: absolute;
  bottom: -10px;
  left: 50%;
  transform: translateX(-50%);
  width: 20px; height: 20px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11px;
  font-weight: 700;
  transition: transform 0.3s;
  z-index: 3;
}
.node.open .expand-pill { transform: translateX(-50%) rotate(180deg); }

/* COLORS */
.n-gestion { background: #203B76; color: #FFCC00; }
.n-gestion .expand-pill { background: #FFCC00; color: #203B76; }

.n-ejecutivo { background: #203B76; color: #fff; }
.n-ejecutivo .expand-pill { background: #1BA333; color: #fff; }

.n-control { background: #1BA333; color: #fff; }
.n-control .expand-pill { background: #203B76; color: #fff; }

.n-normativo { background: #FFCC00; color: #203B76; }
.n-normativo .expand-pill { background: #203B76; color: #FFCC00; }

.n-operativo { background: #135423; color: #fff; }
.n-operativo .expand-pill { background: #FFCC00; color: #135423; }

.n-staff { background: #fff; color: #203B76; border: 1.5px dashed #203B76; }
.n-staff .expand-pill { background: #203B76; color: #fff; }

/* CONNECTORS */
.vline {
  width: 2px;
  background: #1BA333;
  min-height: 22px;
  margin: 0 auto;
}

.children-row {
  display: flex;
  gap: 8px;
  align-items: flex-start;
  position: relative;
}

.children-row::before {
  content: '';
  position: absolute;
  top: 0; left: 50%;
  transform: translateX(-50%);
  width: calc(100% - 85px);
  height: 2px;
  background: #1BA333;
}

.child-col {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.child-col::before {
  content: '';
  width: 2px;
  height: 20px;
  background: #1BA333;
}

.children-wrap {
  overflow: hidden;
  max-height: 0;
  opacity: 0;
  transition: max-height 0.45s cubic-bezier(0.4,0,0.2,1), opacity 0.3s ease;
}
.children-wrap.open {
  max-height: 1400px;
  opacity: 1;
}

/* Staff row */
.staff-row {
  display: flex;
  gap: 8px;
  justify-content: center;
  flex-wrap: wrap;
  margin-bottom: 8px;
}

/* Leaf list */
.leaf-box {
  background: #f4f8f4;
  border: 1.5px solid #1BA333;
  border-radius: 8px;
  padding: 8px 12px;
  margin-top: 8px;
  min-width: 150px;
  max-width: 190px;
}
.leaf-item {
  font-size: 9.5px;
  font-weight: 600;
  color: #203B76;
  padding: 3px 0;
  border-bottom: 1px solid rgba(27,163,51,0.2);
  text-transform: uppercase;
  letter-spacing: 0.2px;
  display: flex;
  align-items: flex-start;
  gap: 5px;
  line-height: 1.4;
}
.leaf-item:last-child { border-bottom: none; }
.leaf-item::before { content: '▸'; color: #1BA333; font-size: 8px; margin-top: 1px; flex-shrink: 0; }

/* Responsive */
@media (max-width: 600px) {
  .node { min-width: 100px; max-width: 130px; font-size: 9px; padding: 8px 10px; }
  .children-row { gap: 5px; }
  .leaf-box { min-width: 120px; max-width: 150px; }
  .leaf-item { font-size: 8.5px; }
}
</style>

<div class="org-wrap">

  <div class="org-header">
    <div class="logo-text">
      <span class="logo-u">U</span><span class="logo-n">N</span><span class="logo-a">A</span><span class="logo-g">G</span>
    </div>
    <div class="header-title">Organigrama<br>Universidad Nacional de Agricultura</div>
  </div>

  <svg class="wave-top" viewBox="0 0 1200 40" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="height:40px;">
    <path d="M0,0 C200,40 400,0 600,20 C800,40 1000,0 1200,20 L1200,40 L0,40 Z" fill="#1BA333"/>
    <path d="M0,5 C200,45 400,5 600,25 C800,45 1000,5 1200,25" fill="none" stroke="#fff" stroke-width="1.5" opacity="0.4"/>
  </svg>

  <div class="legend">
    <div class="leg-item"><div class="leg-dot" style="background:#203B76"></div> Gestión</div>
    <div class="leg-item"><div class="leg-dot" style="background:#1BA333"></div> Control y Apoyo</div>
    <div class="leg-item"><div class="leg-dot" style="background:#203B76;opacity:.7"></div> Dir. Ejecutiva</div>
    <div class="leg-item"><div class="leg-dot" style="background:#FFCC00"></div> Normativo Acad.</div>
    <div class="leg-item"><div class="leg-dot" style="background:#135423"></div> Operativo</div>
  </div>

  <div class="tree" id="tree"></div>

  <svg viewBox="0 0 1200 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="width:100%;height:50px;display:block;margin-top:32px;">
    <path d="M0,50 C300,0 600,30 900,10 C1050,0 1150,20 1200,10 L1200,50 Z" fill="#1BA333"/>
    <path d="M0,50 C300,5 600,35 900,15 C1050,5 1150,25 1200,15" fill="none" stroke="#fff" stroke-width="1.5" opacity="0.4"/>
  </svg>

</div>

<script>
const data = {
  id:'csu', label:'Consejo Superior\nUniversitario (CSU)', cls:'n-gestion',
  children:[{
    id:'jdu', label:'Junta de Dirección\nUniversitaria (JDU)', cls:'n-gestion',
    children:[{
      id:'rectoria', label:'Rectoría', cls:'n-ejecutivo',
      staff:['Órganos de Control\ny Apoyo','Comisionado\nDDHH','Gerencia Financiera\ny Administrativa','Asesoría Legal'],
      children:[
        {
          id:'vrac', label:'Vicerrectoría\nAcadémica', cls:'n-ejecutivo',
          children:[
            { id:'dec', label:'Decanaturas', cls:'n-operativo',
              leaves:['Facultad de Ciencias','Facultad de Ciencias Tecnológicas','Fac. Medicina Veterinaria y Zootecnia','Facultad de Ciencias Agrarias','Fac. Ciencias de la Tierra y la Conservación','Fac. Ciencias Administrativas y Económicas'] },
            { id:'dir', label:'Direcciones\nAcadémicas', cls:'n-normativo',
              leaves:['Sistema de Admisión','Sistema de Vinculación','Docencia e Innovación Educativa','Investigación Científica y Posgrado','Sistema de Carrera Docente','Autoevaluación y Acreditación','Educación a Distancia','Desarrollo e Innovación Tecnológica','Sistema de Centros Regionales'] },
            { id:'sed', label:'Sedes\nUniversitarias', cls:'n-operativo',
              leaves:['UNAG Catacamas','Sede UNAG Comayagua','Sede UNAG Tomalá','Instituto de Investigación y\nCapacitación Mistruck'] }
          ]
        },
        { id:'vri', label:'Vicerrectoría de\nInternacionalización', cls:'n-ejecutivo', children:[] },
        { id:'vve', label:'Vicerrectoría de\nVida Estudiantil', cls:'n-ejecutivo', children:[] },
        { id:'sg', label:'Secretaría\nGeneral', cls:'n-ejecutivo', children:[] }
      ]
    }]
  }]
};

function build(node) {
  const hasKids = node.children && node.children.length > 0;
  const hasLeaves = node.leaves && node.leaves.length > 0;
  const hasStaff = node.staff && node.staff.length > 0;
  const expandable = hasKids || hasLeaves;

  const wrap = document.createElement('div');
  wrap.className = 'node-wrap';

  const box = document.createElement('div');
  box.className = 'node ' + node.cls;
  box.innerHTML = node.label.replace(/\n/g,'<br>');

  if (expandable) {
    const pill = document.createElement('div');
    pill.className = 'expand-pill';
    pill.textContent = '▾';
    box.appendChild(pill);
  }
  wrap.appendChild(box);

  if (!expandable) return wrap;

  const vline = document.createElement('div');
  vline.className = 'vline';
  vline.style.height = '28px';
  wrap.appendChild(vline);

  const cWrap = document.createElement('div');
  cWrap.className = 'children-wrap';

  if (hasStaff) {
    const sr = document.createElement('div');
    sr.className = 'staff-row';
    node.staff.forEach(s => {
      const sn = document.createElement('div');
      sn.className = 'node n-control';
      sn.style.fontSize = '9px';
      sn.style.minWidth = '100px';
      sn.style.maxWidth = '130px';
      sn.style.cursor = 'default';
      sn.innerHTML = s.replace(/\n/g,'<br>');
      sr.appendChild(sn);
    });
    cWrap.appendChild(sr);
    const sv = document.createElement('div');
    sv.className = 'vline'; sv.style.height = '16px';
    cWrap.appendChild(sv);
  }

  if (hasKids) {
    const row = document.createElement('div');
    row.className = 'children-row';
    node.children.forEach(c => {
      const col = document.createElement('div');
      col.className = 'child-col';
      col.appendChild(build(c));
      row.appendChild(col);
    });
    cWrap.appendChild(row);
  }

  if (hasLeaves) {
    const lb = document.createElement('div');
    lb.className = 'leaf-box';
    node.leaves.forEach(l => {
      const li = document.createElement('div');
      li.className = 'leaf-item';
      li.textContent = l;
      lb.appendChild(li);
    });
    cWrap.appendChild(lb);
  }

  wrap.appendChild(cWrap);

  box.addEventListener('click', () => {
    const open = cWrap.classList.contains('open');
    cWrap.classList.toggle('open', !open);
    box.classList.toggle('open', !open);
  });

  return wrap;
}

document.getElementById('tree').appendChild(build(data));

setTimeout(() => {
  const nodes = document.querySelectorAll('.node.n-gestion, .node.n-ejecutivo');
  if (nodes[0]) nodes[0].click();
  setTimeout(() => { if (nodes[1]) nodes[1].click(); }, 280);
  setTimeout(() => { if (nodes[2]) nodes[2].click(); }, 520);
}, 120);
</script>
