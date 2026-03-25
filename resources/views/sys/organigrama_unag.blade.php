<link rel="shortcut icon" href="{{ asset('/favicon.png') }}">
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap');
*{box-sizing:border-box;margin:0;padding:0;}
body{background:#fff;}
.wrap{font-family:'Montserrat',sans-serif;background:#fff;width:100%;overflow-x:auto;min-width:700px;}

/* HEADER */
.hdr{background:#203B76;padding:16px 24px;display:flex;align-items:center;gap:14px;position:relative;overflow:hidden;}
.hdr::after{content:'';position:absolute;top:-18px;right:-18px;width:72px;height:72px;background:#FFCC00;border-radius:50%;}
.logo{display:flex;font-size:26px;font-weight:700;letter-spacing:-1px;}
.lu{color:#203B76;background:#fff;padding:2px 4px;}
.ln{color:#FFCC00;background:#fff;padding:2px 2px;}
.la{color:#1BA333;background:#fff;padding:2px 2px;}
.lg{color:#203B76;background:#fff;padding:2px 4px;}
.htitle{color:#fff;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;line-height:1.4;z-index:1;}

/* WAVE */
.wave{width:100%;display:block;line-height:0;}

/* LEGEND */
.legend{display:flex;gap:12px;flex-wrap:wrap;padding:10px 20px;background:#f7f8fa;border-bottom:2px solid #1BA333;}
.li{display:flex;align-items:center;gap:6px;font-size:9.5px;font-weight:700;color:#444;text-transform:uppercase;}
.ld{width:12px;height:12px;border-radius:50%;}

/* CHART AREA */
.chart{padding:28px 20px 0;width:100%;}

/* NODE PILL */
.pill{display:inline-flex;align-items:center;justify-content:center;border-radius:50px;padding:8px 18px;font-size:10px;font-weight:700;text-align:center;text-transform:uppercase;letter-spacing:0.4px;line-height:1.3;cursor:pointer;transition:transform .15s,box-shadow .15s;user-select:none;white-space:nowrap;}
.pill:hover{transform:translateY(-1px);box-shadow:0 4px 14px rgba(0,0,0,.18);}
.pill.no-click{cursor:default;}
.pill.no-click:hover{transform:none;box-shadow:none;}

/* COLORS */
.p-green{background:#1BA333;color:#fff;}
.p-navy{background:#203B76;color:#fff;}
.p-cyan{background:#00BCD4;color:#fff;}
.p-yellow{background:#FFCC00;color:#203B76;}
.p-brown{background:#5D3A00;color:#fff;}

/* CONNECTOR */
.spine{width:2px;background:#1BA333;margin:0 auto;}
.hline{height:2px;background:#1BA333;}

/* COLUMN/ROW helpers */
.col{display:flex;flex-direction:column;align-items:center;}
.row{display:flex;align-items:flex-start;justify-content:center;}

/* ROW with horizontal top bar */
.branch-row{display:flex;align-items:flex-start;justify-content:center;position:relative;}
.branch-row::before{content:'';position:absolute;top:0;left:50%;transform:translateX(-50%);height:2px;background:#1BA333;}

.branch-col{display:flex;flex-direction:column;align-items:center;}
.branch-col::before{content:'';width:2px;height:20px;background:#1BA333;}

/* COLLAPSIBLE */
.cw{overflow:hidden;max-height:0;opacity:0;transition:max-height .45s cubic-bezier(.4,0,.2,1),opacity .3s ease;}
.cw.open{max-height:2000px;opacity:1;}

/* EXPAND DOT */
.edot{width:18px;height:18px;border-radius:50%;background:#1BA333;display:flex;align-items:center;justify-content:center;font-size:10px;color:#fff;font-weight:700;margin:0 auto;transition:transform .3s;cursor:pointer;}
.edot.rotated{transform:rotate(180deg);}

/* LIST ITEMS */
.list-box{border-left:2px solid #555;padding-left:10px;margin-top:4px;}
.list-item{font-size:9px;font-weight:600;color:#333;padding:2.5px 0;line-height:1.3;}

/* DASHED SVG overlay */
#dash-svg{position:absolute;top:0;left:0;pointer-events:none;overflow:visible;}
</style>

<div class="wrap">
<div class="hdr">
  <div class="logo"><span class="lu">U</span><span class="ln">N</span><span class="la">A</span><span class="lg">G</span></div>
  <div class="htitle">Organigrama<br>Universidad Nacional de Agricultura</div>
</div>
<svg class="wave" viewBox="0 0 1200 36" preserveAspectRatio="none" style="height:36px;">
  <path d="M0,0 C200,36 400,0 600,18 C800,36 1000,0 1200,18 L1200,36 L0,36 Z" fill="#1BA333"/>
  <path d="M0,4 C200,40 400,4 600,22 C800,40 1000,4 1200,22" fill="none" stroke="#fff" stroke-width="1.2" opacity="0.4"/>
</svg>
<div class="legend">
  <div class="li"><div class="ld" style="background:#1BA333"></div>Gestión</div>
  <div class="li"><div class="ld" style="background:#00BCD4"></div>Control y Apoyo</div>
  <div class="li"><div class="ld" style="background:#203B76"></div>Dir. Ejecutiva</div>
  <div class="li"><div class="ld" style="background:#FFCC00"></div>Normativo Acad.</div>
  <div class="li"><div class="ld" style="background:#5D3A00"></div>Operativo</div>
</div>

<div class="chart" id="chart" style="position:relative;">

  <!-- CSU -->
  <div class="col">
    <div class="pill p-green" id="csu-node">Consejo Superior Universitario (CSU)</div>
    <div class="spine" style="height:24px;"></div>

    <!-- JDU -->
    <div class="col">
      <div class="pill p-green" id="jdu-node">Junta de Dirección Universitaria (JDU)</div>
      <div class="spine" style="height:24px;" id="jdu-spine"></div>

      <!-- JDU children wrap -->
      <div class="cw" id="jdu-cw">

        <!-- ROW: Órganos | [spine→Rectoría] | Comisionado -->
        <div class="row" id="row-jdu-staff" style="width:100%;align-items:center;gap:0;">
          <!-- LEFT: Órganos -->
          <div style="flex:1;display:flex;justify-content:flex-end;padding-right:16px;">
            <div class="pill p-cyan no-click" id="organos" style="white-space:normal;max-width:150px;text-align:center;">Órganos de Control y Apoyo (SEAPI, SETIC, SEPEG)</div>
          </div>
          <!-- CENTER spine going down to Rectoría -->
          <div class="col" style="flex:0 0 auto;">
            <div class="spine" style="height:48px;" id="pre-rect-spine"></div>
          </div>
          <!-- RIGHT: Comisionado -->
          <div style="flex:1;display:flex;justify-content:flex-start;padding-left:16px;">
            <div class="pill p-cyan no-click" id="comisionado" style="white-space:normal;max-width:150px;text-align:center;">Comisionado Universitario de Derechos Humanos</div>
          </div>
        </div>

        <!-- RECTORÍA -->
        <div class="col">
          <div class="pill p-navy" id="rect-node">Rectoría</div>
          <div class="spine" style="height:24px;" id="rect-spine"></div>

          <!-- RECT children wrap -->
          <div class="cw" id="rect-cw">

            <!-- ROW: Gerencia | [spine→Vices] | Asesoría -->
            <div class="row" id="row-rect-staff" style="width:100%;align-items:center;gap:0;">
              <div style="flex:1;display:flex;justify-content:flex-end;padding-right:16px;">
                <div class="pill p-cyan no-click" id="gerencia" style="white-space:normal;max-width:150px;text-align:center;">Gerencia Financiera y admi</div>
              </div>
              <div class="col" style="flex:0 0 auto;">
                <div class="spine" style="height:48px;" id="pre-vice-spine"></div>
              </div>
              <div style="flex:1;display:flex;justify-content:flex-start;padding-left:16px;">
                <div class="pill p-cyan no-click" id="asesoria" style="white-space:normal;max-width:150px;text-align:center;">Asesoría Legal</div>
              </div>
            </div>

            <!-- VICERRECTORÍAS ROW -->
            <div class="col">
              <div class="branch-row" id="vice-row" style="gap:20px;">

                <!-- VRAC -->
                <div class="branch-col" >
                  <div class="pill p-navy" style="margin-left:360px;" id="vrac-node">Vicerrectoría<br>Académica</div>
                  <div class="spine" style="height:20px;"></div>
                  <div class="cw open" id="vrac-cw">
                    <div class="branch-row" style="gap:12px;" id="vrac-children">

                      <!-- DECANATURAS -->
                      <div class="branch-col">
                        <div class="pill p-brown" id="dec-node">Decanaturas</div>
                        <div class="cw" id="dec-cw">
                          <div class="list-box" style="margin-top:8px;">
                            <div class="list-item">Facultad de Ciencias</div>
                            <div class="list-item">Facultad de Ciencias Tecnológicas</div>
                            <div class="list-item">Facultad de Medicina Veterinaria y Zootecnia</div>
                            <div class="list-item">Facultad de Ciencias Agrarias</div>
                            <div class="list-item">Facultad de Ciencias de la Tierra y la Conservación</div>
                            <div class="list-item">Facultad de Ciencias Administrativas y Económicas</div>
                          </div>
                        </div>
                      </div>

                      <!-- DIRECCIONES -->
                      <div class="branch-col">
                        <div class="pill p-yellow" id="dir-node">Direcciones Académicas</div>
                        <div class="cw" id="dir-cw">
                          <div class="list-box" style="margin-top:8px;">
                            <div class="list-item">Sistema de Admisión</div>
                            <div class="list-item">Sistema de Vinculación</div>
                            <div class="list-item">Sistema de Docencia e Innovación Educativa</div>
                            <div class="list-item">Sistema de Investigación Científica y Posgrado</div>
                            <div class="list-item">Sistema de Carrera Docente</div>
                            <div class="list-item">Sistema de Autoevaluación y Acreditación para la Calidad Educativa</div>
                            <div class="list-item">Sistema de Educación a Distancia</div>
                            <div class="list-item">Sistema de Desarrollo e Innovación Tecnológica</div>
                            <div class="list-item">Sistema de Centro Regionales</div>
                          </div>
                        </div>
                      </div>

                      <!-- SEDES -->
                      <div class="branch-col">
                        <div class="pill p-brown" id="sed-node">Sedes Universitarias</div>
                        <div class="cw" id="sed-cw">
                          <div class="list-box" style="margin-top:8px;">
                            <div class="list-item">UNAG Catacamas</div>
                            <div class="list-item">Sede UNAG Comayagua</div>
                            <div class="list-item">Sede UNAG Tomalá</div>
                            <div class="list-item">Instituto de Investigación y Capacitación Mistruck</div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>

                <!-- VRINT -->
                <div class="branch-col">
                  <div class="pill p-navy no-click">Vicerrectoría de<br>Internacionalización</div>
                </div>

                <!-- VREST -->
                <div class="branch-col">
                  <div class="pill p-navy no-click">Vicerrectoría de<br>Vida Estudiantil</div>
                </div>

                <!-- SECGEN -->
                <div class="branch-col">
                  <div class="pill p-navy no-click">Secretaría<br>General</div>
                </div>

              </div><!-- vice-row -->
            </div>

          </div><!-- rect-cw -->
        </div><!-- col rect -->

      </div><!-- jdu-cw -->
    </div><!-- col jdu -->
  </div><!-- col csu -->

</div><!-- chart -->

<svg viewBox="0 0 1200 50" preserveAspectRatio="none" style="width:100%;height:46px;display:block;margin-top:28px;">
  <path d="M0,50 C300,0 600,30 900,10 C1050,0 1150,20 1200,10 L1200,50 Z" fill="#1BA333"/>
  <path d="M0,50 C300,5 600,35 900,15 C1050,5 1150,25 1200,15" fill="none" stroke="#fff" stroke-width="1.2" opacity="0.4"/>
</svg>
</div>

<script>
/* ── TOGGLE helpers ── */
function toggle(nodeId, cwId) {
  const n = document.getElementById(nodeId);
  const cw = document.getElementById(cwId);
  if (!n || !cw) return;
  n.addEventListener('click', () => {
    cw.classList.toggle('open');
    setTimeout(drawDashes, 480);
  });
}
toggle('jdu-node','jdu-cw');
toggle('rect-node','rect-cw');
toggle('vrac-node','vrac-cw');
toggle('dec-node','dec-cw');
toggle('dir-node','dir-cw');
toggle('sed-node','sed-cw');

/* ── branch-row widths via JS ── */
function fixBranchRows() {
  document.querySelectorAll('.branch-row').forEach(row => {
    const cols = row.querySelectorAll(':scope > .branch-col');
    if (cols.length < 2) { row.style.setProperty('--bw','0%'); return; }
    const first = cols[0].getBoundingClientRect();
    const last  = cols[cols.length-1].getBoundingClientRect();
    const rowR  = row.getBoundingClientRect();
    const pct   = ((last.right - first.left) / rowR.width * 100).toFixed(1);
    row.style.setProperty('--bw', pct + '%');
    // apply directly
    const pseudo = row.querySelector(':scope > .branch-line');
    if (!pseudo) {
      // set via inline style on ::before equivalent — use a real div instead
    }
  });
}

/* Replace CSS ::before on branch-row with real divs for reliable positioning */
document.querySelectorAll('.branch-row').forEach(row => {
  row.style.position = 'relative';
});
document.querySelectorAll('.branch-col').forEach(col => {
  const bar = document.createElement('div');
  bar.style.cssText = 'width:2px;height:20px;background:#1BA333;margin:0 auto;';
  col.insertBefore(bar, col.firstChild);
  // remove ::before
  col.classList.remove('branch-col');
  col.classList.add('bcol');
});
// horizontal bar for branch rows
function addHBar(row) {
  const cols = row.querySelectorAll(':scope > .bcol');
  if (cols.length < 2) return;
  const hbar = document.createElement('div');
  hbar.className = 'hbar-line';
  hbar.style.cssText = 'position:absolute;top:0;height:2px;background:#1BA333;';
  row.appendChild(hbar);
  function update() {
    if (!row.offsetParent) return;
    const rr = row.getBoundingClientRect();
    const fc = cols[0].getBoundingClientRect();
    const lc = cols[cols.length-1].getBoundingClientRect();
    const fcCX = fc.left + fc.width/2 - rr.left;
    const lcCX = lc.left + lc.width/2 - rr.left;
    hbar.style.left  = fcCX + 'px';
    hbar.style.width = (lcCX - fcCX) + 'px';
  }
  update();
  return update;
}

const updateFns = [];
document.querySelectorAll('.branch-row').forEach(row => {
  const fn = addHBar(row);
  if (fn) updateFns.push(fn);
});

function refreshBars() { updateFns.forEach(f => f()); }

/* ── DASHED LINES ── */
function drawDashes() {
  const old = document.getElementById('dash-svg');
  if (old) old.remove();

  const chart = document.getElementById('chart');
  const cr = chart.getBoundingClientRect();

  // --- ROW 1: JDU level ---
  // spine between JDU and Rectoría
  const preRect = document.getElementById('pre-rect-spine');
  const organos = document.getElementById('organos');
  const comis   = document.getElementById('comisionado');
  if (!preRect || !organos || !comis) return;

  const prR  = preRect.getBoundingClientRect();
  const spineX1 = prR.left + prR.width/2 - cr.left;
  // Y midpoint of the pre-rect spine
  const spineY1 = prR.top  + prR.height/2 - cr.top;

  const oR = organos.getBoundingClientRect();
  const cR = comis.getBoundingClientRect();
  const oCY = oR.top + oR.height/2 - cr.top;
  const cCY = cR.top + cR.height/2 - cr.top;

  // --- ROW 2: Rectoría level ---
  const preVice = document.getElementById('pre-vice-spine');
  const gerencia = document.getElementById('gerencia');
  const asesoria = document.getElementById('asesoria');
  if (!preVice || !gerencia || !asesoria) return;

  const pvR  = preVice.getBoundingClientRect();
  const spineX2 = pvR.left + pvR.width/2 - cr.left;
  const spineY2 = pvR.top  + pvR.height/2 - cr.top;

  const gR = gerencia.getBoundingClientRect();
  const aR = asesoria.getBoundingClientRect();
  const gCY = gR.top + gR.height/2 - cr.top;
  const aCY = aR.top + aR.height/2 - cr.top;

  const maxH = Math.max(oCY, cCY, gCY, aCY) + 20;

  const svg = document.createElementNS('http://www.w3.org/2000/svg','svg');
  svg.id = 'dash-svg';
  svg.style.cssText = `position:absolute;top:0;left:0;width:100%;height:${maxH}px;pointer-events:none;overflow:visible;`;

  function dl(x1,y1,x2,y2) {
    const l = document.createElementNS('http://www.w3.org/2000/svg','line');
    l.setAttribute('x1',x1); l.setAttribute('y1',y1);
    l.setAttribute('x2',x2); l.setAttribute('y2',y2);
    l.setAttribute('stroke','#00BCD4');
    l.setAttribute('stroke-width','1.8');
    l.setAttribute('stroke-dasharray','6,4');
    svg.appendChild(l);
  }
  function dc(cx,cy,r,fill) {
    const c = document.createElementNS('http://www.w3.org/2000/svg','circle');
    c.setAttribute('cx',cx); c.setAttribute('cy',cy);
    c.setAttribute('r',r||3); c.setAttribute('fill',fill||'#00BCD4');
    svg.appendChild(c);
  }

  // ROW 1 dashes
  // Órganos right edge → spineX1
  dl(oR.right - cr.left, oCY, spineX1, oCY);
  dc(spineX1, oCY, 3);
  // vertical on spine from oCY to spineY1
  if (Math.abs(oCY - spineY1) > 1) dl(spineX1, oCY, spineX1, spineY1);
  // Comisionado left edge ← spineX1
  dl(spineX1, cCY, cR.left - cr.left, cCY);
  dc(spineX1, cCY, 3);
  if (Math.abs(cCY - spineY1) > 1) dl(spineX1, cCY, spineX1, spineY1);
  dc(spineX1, spineY1, 4, '#1BA333');

  // ROW 2 dashes
  dl(gR.right - cr.left, gCY, spineX2, gCY);
  dc(spineX2, gCY, 3);
  if (Math.abs(gCY - spineY2) > 1) dl(spineX2, gCY, spineX2, spineY2);
  dl(spineX2, aCY, aR.left - cr.left, aCY);
  dc(spineX2, aCY, 3);
  if (Math.abs(aCY - spineY2) > 1) dl(spineX2, aCY, spineX2, spineY2);
  dc(spineX2, spineY2, 4, '#1BA333');

  chart.appendChild(svg);
  refreshBars();
}

// Auto-open and draw
setTimeout(() => {
  document.getElementById('jdu-cw').classList.add('open');
  document.getElementById('rect-cw').classList.add('open');
  document.getElementById('dec-cw').classList.add('open');
  document.getElementById('dir-cw').classList.add('open');
  document.getElementById('sed-cw').classList.add('open');
  setTimeout(() => { refreshBars(); drawDashes(); }, 550);
}, 200);

window.addEventListener('resize', () => { refreshBars(); setTimeout(drawDashes,100); });
</script>
