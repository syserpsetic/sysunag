@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@endpush

@section('content')
<style>
*{box-sizing:border-box;margin:0;padding:0}
:root{
  --verde:#1BA333;--verde-osc:#135423;--amarillo:#FFCC00;
  --azul:#203B76;--celeste:#0094E9;--cafe:#5B3700;
  --white:#fff;--gray-bg:#F5F6FA;--gray-border:#DDE1EA;
  --text-dark:#1A2340;--text-muted:#5A6278;
}
body{font-family:'Open Sans',sans-serif;background:var(--gray-bg);min-height:100vh;padding:0}
.wrap{max-width:80%;margin:0 auto;background:var(--white)}

.header{background:var(--azul);position:relative;overflow:hidden;padding:18px 28px 14px}
.header-inner{display:flex;align-items:center;gap:16px;position:relative;z-index:2}
.escudo{width:52px;height:52px;background:var(--white);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.header-text h1{font-family:'Montserrat',sans-serif;color:var(--white);font-size:15px;font-weight:700;letter-spacing:.3px;line-height:1.2}
.header-text p{font-family:'Open Sans',sans-serif;color:rgba(255,255,255,.72);font-size:11px;margin-top:3px}
.header-wave{position:absolute;bottom:0;right:0;z-index:1;opacity:.18}
.badge-doc{margin-left:auto;background:var(--amarillo);border-radius:6px;padding:6px 14px;text-align:center;flex-shrink:0}
.badge-doc span{display:block;font-family:'Montserrat',sans-serif;font-weight:700;font-size:10px;color:var(--azul);text-transform:uppercase;letter-spacing:.4px}
.badge-doc strong{display:block;font-family:'Montserrat',sans-serif;font-weight:700;font-size:18px;color:var(--azul);line-height:1.1}
.yellow-dot{position:absolute;width:80px;height:80px;border-radius:50%;background:var(--amarillo);opacity:.55;top:-30px;right:90px;z-index:1}

.section-title{display:flex;align-items:center;gap:0;margin:20px 24px 14px}
.section-bar{width:5px;height:22px;background:var(--verde);border-radius:2px;flex-shrink:0}
.section-label{font-family:'Montserrat',sans-serif;font-size:13px;font-weight:700;color:var(--azul);text-transform:uppercase;letter-spacing:.5px;padding-left:10px}

.form-body{padding:0 24px 24px}
.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px}
.field{display:flex;flex-direction:column;gap:5px}
.field.full{grid-column:1/-1}
label{font-family:'Montserrat',sans-serif;font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.4px}
label span.req{color:var(--verde);margin-left:2px}
input[type=text],input[type=date],input[type=number]{font-family:'Open Sans',sans-serif;font-size:13px;color:var(--text-dark);background:var(--white);border:1.5px solid var(--gray-border);border-radius:6px;padding:9px 12px;transition:border-color .18s,box-shadow .18s;outline:none;width:100%}
input:hover{border-color:#B0B8CC}
input:focus{border-color:var(--verde);box-shadow:0 0 0 3px rgba(27,163,51,.12)}
input::placeholder{color:#B0B8CC}

/* SELECT2 CUSTOM THEME */
.select2-container--default .select2-selection--single{
  height:38px;border:1.5px solid var(--gray-border);border-radius:6px;
  background:var(--white);display:flex;align-items:center;
}
.select2-container--default .select2-selection--single:hover{border-color:#B0B8CC}
.select2-container--default.select2-container--focus .select2-selection--single,
.select2-container--default.select2-container--open .select2-selection--single{
  border-color:var(--verde);box-shadow:0 0 0 3px rgba(27,163,51,.12);outline:none;
}
.select2-container--default .select2-selection--single .select2-selection__rendered{
  font-family:'Open Sans',sans-serif;font-size:13px;color:var(--text-dark);
  line-height:36px;padding-left:12px;padding-right:30px;
}
.select2-container--default .select2-selection--single .select2-selection__placeholder{color:#B0B8CC}
.select2-container--default .select2-selection--single .select2-selection__arrow{height:36px;right:8px}
.select2-container--default .select2-selection--single .select2-selection__arrow b{
  border-color:var(--text-muted) transparent transparent transparent;
}
.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b{
  border-color:transparent transparent var(--verde) transparent;
}
.select2-dropdown{border:1.5px solid var(--verde);border-radius:6px;box-shadow:0 4px 16px rgba(32,59,118,.1);font-family:'Open Sans',sans-serif;font-size:13px;overflow:hidden}
.select2-container--default .select2-search--dropdown .select2-search__field{
  border:1.5px solid var(--gray-border);border-radius:5px;padding:7px 10px;
  font-family:'Open Sans',sans-serif;font-size:12px;outline:none;margin:6px 6px 4px;width:calc(100% - 12px);
}
.select2-container--default .select2-search--dropdown .select2-search__field:focus{border-color:var(--verde)}
.select2-container--default .select2-results__option--highlighted[aria-selected]{
  background:var(--verde);color:var(--white);
}
.select2-results__option{padding:8px 12px;color:var(--text-dark)}
.select2-results__option[aria-selected=true]{background:#EAF7ED;color:var(--verde-osc);font-weight:600}
.select2-container--default .select2-results__option--highlighted.select2-results__option--selectable{background:var(--verde)}
.opt-meta{font-size:11px;color:var(--text-muted);display:block;margin-top:1px}
.select2-results__option--highlighted .opt-meta{color:rgba(255,255,255,.8)}

/* detalle */
.detail-wrap{padding:0 24px}
.detail-header{display:grid;grid-template-columns:2.4fr 0.8fr 1.2fr 0.9fr 1.1fr 36px;gap:8px;padding:7px 10px;background:var(--azul);border-radius:6px 6px 0 0}
.detail-header span{font-family:'Montserrat',sans-serif;font-size:10px;font-weight:700;color:rgba(255,255,255,.9)!important;text-transform:uppercase;letter-spacing:.4px}
.detail-row{display:grid;grid-template-columns:2.4fr 0.8fr 1.2fr 0.9fr 1.1fr 36px;gap:8px;padding:7px 10px;border-left:1.5px solid var(--gray-border);border-right:1.5px solid var(--gray-border);border-bottom:1px solid var(--gray-border);align-items:center;transition:background .15s}
.detail-row:hover{background:#F8FBF9}
.detail-row input[type=number]{font-size:12px;padding:7px 9px;border-radius:5px}
.detail-row select.iselect{font-family:'Open Sans',sans-serif;font-size:12px;color:var(--text-dark);background:var(--white);border:1.5px solid var(--gray-border);border-radius:5px;padding:7px 28px 7px 9px;width:100%;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='7' fill='none'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%235A6278' stroke-width='1.4' stroke-linecap='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 9px center;cursor:pointer;outline:none;transition:border-color .15s}
.detail-row select.iselect:focus{border-color:var(--verde);box-shadow:0 0 0 3px rgba(27,163,51,.12)}

/* select2 dentro de fila de detalle */
.detail-row .select2-container{width:100%!important}
.detail-row .select2-container--default .select2-selection--single{height:34px}
.detail-row .select2-container--default .select2-selection--single .select2-selection__rendered{font-size:12px;line-height:32px;padding-left:9px}
.detail-row .select2-container--default .select2-selection--single .select2-selection__arrow{height:32px}

.subtotal-cell{font-family:'Montserrat',sans-serif;font-size:12px;font-weight:700;color:var(--verde-osc);text-align:right;padding-right:4px}
.btn-del{width:28px;height:28px;background:none;border:1.5px solid var(--gray-border);border-radius:5px;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-muted);transition:all .15s;padding:0}
.btn-del:hover{background:#FFF0F0;border-color:#F0A0A0;color:#C84040}
.btn-add{margin:10px 0 0;background:none;border:1.5px dashed var(--verde);border-radius:6px;color:var(--verde);font-family:'Montserrat',sans-serif;font-size:11px;font-weight:700;padding:8px 16px;cursor:pointer;width:100%;letter-spacing:.3px;transition:all .15s}
.btn-add:hover{background:rgba(27,163,51,.06)}

.divider{height:1px;background:var(--gray-border);margin:6px 24px 0}

.totales-wrap{margin:16px 0 0;display:flex;justify-content:flex-end}
.totales-card{background:var(--gray-bg);border:1.5px solid var(--gray-border);border-radius:8px;padding:14px 20px;min-width:280px}
.tot-row{display:flex;justify-content:space-between;align-items:center;padding:4px 0}
.tot-row span:first-child{font-size:12px;color:var(--text-muted);font-family:'Open Sans',sans-serif}
.tot-row span:last-child{font-size:13px;font-weight:600;color:var(--text-dark);font-family:'Montserrat',sans-serif}
.tot-divider{height:1px;background:var(--gray-border);margin:8px 0}
.tot-total span:first-child{font-size:13px;font-weight:700;color:var(--azul);font-family:'Montserrat',sans-serif}
.tot-total span:last-child{font-size:16px;font-weight:700;color:var(--verde-osc);font-family:'Montserrat',sans-serif}

.actions{display:flex;justify-content:flex-end;gap:10px;padding:20px 24px 24px;border-top:1px solid var(--gray-border);margin-top:20px}
.btn-cancel{background:none;border:1.5px solid var(--gray-border);border-radius:7px;color:var(--text-muted);font-family:'Montserrat',sans-serif;font-size:12px;font-weight:600;padding:10px 22px;cursor:pointer;transition:all .15s}
.btn-cancel:hover{background:var(--gray-bg);border-color:#B0B8CC}
.btn-save{background:var(--verde);border:none;border-radius:7px;color:var(--white);font-family:'Montserrat',sans-serif;font-size:12px;font-weight:700;padding:10px 28px;cursor:pointer;transition:all .15s;letter-spacing:.3px}
.btn-save:hover{background:var(--verde-osc)}
</style>

<div class="wrap">
  <div class="header">
    <div class="yellow-dot"></div>
    <svg class="header-wave" viewBox="0 0 260 80" width="260" height="80" fill="none">
      <path d="M0 40 Q65 0 130 40 Q195 80 260 40 L260 80 L0 80Z" fill="#FFCC00"/>
    </svg>
    <div class="header-inner">
      
    </div>
  </div>

  <div class="section-title">
    <div class="section-bar"></div>
    <span class="section-label">Encabezado de Factura</span>
  </div>

  <div class="form-body">
    <div style="margin-bottom:14px">
      <div class="field">
        <label>Proveedor <span class="req">*</span></label>
        <select id="sel-proveedor" style="width:100%">            
          <option value=""></option>
        @foreach($proveedores_list as $row)
          <option value="{{ $row['id'] }}" >{{ $row['nombre'] }}</option>
         @endforeach
        </select>
      </div>
    </div>
    <div class="grid-3">
      <div class="field">
        <label>Número de Factura <span class="req">*</span></label>
        <input type="text" id="numfac" placeholder="Ej. 00001-2024">
      </div>
      <div class="field">
        <label>Fecha en Libros <span class="req">*</span></label>
        <input type="date" id="fechalibros">
      </div>
      <div class="field">
        <label>Fecha de Registro <span class="req">*</span></label>
        <input readonly type="date" id="fechareg">
      </div>
    </div>
  </div>

  <div class="divider"></div>

  <div class="section-title">
    <div class="section-bar"></div>
    <span class="section-label">Detalle de Productos</span>
  </div>

  <div class="detail-wrap">
    <div class="detail-header">
      <span>Producto / Descripción</span>
      <span>Cantidad</span>
      <span>Precio Unit.</span>
      <span>Impuesto</span>
      <span style="text-align:right">Subtotal</span>
      <span></span>
    </div>
    <div id="rows"></div>
    <button class="btn-add" onclick="addRow()">＋ Agregar Línea</button>

    <div class="totales-wrap">
      <div class="totales-card">
        <div class="tot-row"><span>Subtotal sin impuesto</span><span id="t-sub">L 0.00</span></div>
        <div class="tot-row"><span>Impuesto (ISV)</span><span id="t-tax">L 0.00</span></div>
        <div class="tot-divider"></div>
        <div class="tot-row tot-total"><span>Total Factura</span><span id="t-total">L 0.00</span></div>
      </div>
    </div>
  </div>

  <div class="actions">
    <button class="btn-cancel" onclick="cancelar()">Cancelar</button>
    <button class="btn-save" onclick="guardar()">Guardar Factura</button>
  </div>
</div>

@endsection
@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush
@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=mzutkZDE"></script>
  <script type="text/javascript">
    const PRODUCTOS = @json($producto_list);
    const PRODUCTOS_S2   = PRODUCTOS.map(p => ({ id: p.id, text: p.nombre + ' (' +  p.descripcion + ' - ' +  p.presentacion + ')'}));
    //console.log(<?php echo json_encode($producto_list); ?>);
    /* const PRODUCTOS = [
  {id:1, text:'Resma de Papel Bond T/Carta', cat:'Papelería', precio:95.00, impuesto:15},
  {id:2, text:'Tóner HP LaserJet 85A', cat:'Informática', precio:1250.00, impuesto:15},
  {id:3, text:'Fertilizante Urea 46%', cat:'Agroquímicos', precio:880.00, impuesto:0},
  {id:4, text:'Silla Ergonómica Ejecutiva', cat:'Mobiliario', precio:3200.00, impuesto:15},
  {id:5, text:'Computadora Portátil i7', cat:'Informática', precio:22500.00, impuesto:15},
  {id:6, text:'Herbicida Glifosato 1L', cat:'Agroquímicos', precio:320.00, impuesto:0},
  {id:7, text:'Archivador 4 Gavetas', cat:'Mobiliario', precio:2800.00, impuesto:15},
  {id:8, text:'Marcadores de Pizarra (caja)', cat:'Papelería', precio:120.00, impuesto:15},
  {id:9, text:'Vacuna Newcastle 1000 dosis', cat:'Veterinaria', precio:450.00, impuesto:0},
  {id:10,text:'Memoria USB 64GB', cat:'Informática', precio:350.00, impuesto:15},
  {id:11,text:'Aceite de Motor 5W30 1L', cat:'Mantenimiento', precio:280.00, impuesto:15},
  {id:12,text:'Botiquín de Primeros Auxilios', cat:'Salud', precio:620.00, impuesto:15},
]; */

function fmt(n){return 'L '+n.toLocaleString('es-HN',{minimumFractionDigits:2,maximumFractionDigits:2});}

$(function(){
  $('#sel-proveedor').select2({
    placeholder:'— Buscar proveedor —',
    allowClear:true,
    width:'100%',
    templateResult:function(d){
      if(!d.id)return d.text;
      const rtn=$(d.element).data('rtn')||'';
      return $('<span>'+d.text+'<span class="opt-meta"> </span></span>');
    },
    templateSelection:function(d){return d.text||d.id;}
  });
});

/* const opcionesProductos = PRODUCTOS.map(p =>
        `<option value="${p.id}">${p.nombre}</option>`
    ).join(''); */

let rowId=0;
function addRow(){
  rowId++;
  const id=rowId;
  const d=document.getElementById('rows');
  const r=document.createElement('div');
  r.className='detail-row';r.id='row'+id;
  r.innerHTML=`
     <select id="prod${id}" style="width:100%">
            <option value=""></option>
        </select>
    <input type="number" id="qty${id}" placeholder="0" min="1" value="1" style="text-align:center" oninput="calcRow(${id})">
    <input type="number" id="prc${id}" placeholder="0.00" min="0" step="0.01" value="" oninput="calcRow(${id})">
    <select class="iselect" id="tax${id}" onchange="calcRow(${id})">
      <option value="0">Sin ISV</option>
      <option value="15">ISV 15%</option>
      <option value="18">ISV 18%</option>
    </select>
    <div class="subtotal-cell" id="sub${id}">L 0.00</div>
    <button class="btn-del" onclick="delRow(${id})" title="Eliminar">
      <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 2l8 8M10 2l-8 8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
    </button>`;
  d.appendChild(r);

  $(`#prod${id}`).select2({
        placeholder   : '— Buscar producto —',
        allowClear    : true,
        width         : '100%',
        dropdownParent: $(`#row${id}`),
        data          : PRODUCTOS_S2,          // array JS, no opciones DOM
        minimumInputLength: 1,                 // no carga nada hasta que escribas
        language           : {
        inputTooShort  : () => 'Escriba para buscar...',
        noResults      : () => 'No se encontraron resultados',
        searching      : () => 'Buscando...',
        loadingMore    : () => 'Cargando más resultados...',
    },
    });

  calcTotals();
}

function delRow(id){
  const el=document.getElementById('row'+id);
  if(el){try{$('#prod'+id).select2('destroy');}catch(e){}el.remove();}
  calcTotals();
}

function calcRow(id){
  const qty=parseFloat(document.getElementById('qty'+id)?.value)||0;
  const prc=parseFloat(document.getElementById('prc'+id)?.value)||0;
  const tax=parseFloat(document.getElementById('tax'+id)?.value)||0;
  const sub=qty*prc*(1+tax/100);
  const cel=document.getElementById('sub'+id);
  if(cel)cel.textContent=fmt(sub);
  calcTotals();
}

function calcTotals(){
  let base=0,taxes=0;
  document.querySelectorAll('.detail-row').forEach(r=>{
    const m=r.id.replace('row','');
    const qty=parseFloat(document.getElementById('qty'+m)?.value)||0;
    const prc=parseFloat(document.getElementById('prc'+m)?.value)||0;
    const tax=parseFloat(document.getElementById('tax'+m)?.value)||0;
    base+=qty*prc;taxes+=qty*prc*(tax/100);
  });
  document.getElementById('t-sub').textContent=fmt(base);
  document.getElementById('t-tax').textContent=fmt(taxes);
  document.getElementById('t-total').textContent=fmt(base+taxes);
}

function guardar(){
  const num=document.getElementById('numfac').value.trim();
  const prov=$('#sel-proveedor').val();
  if(!prov){alert('Seleccione un proveedor.');return;}
  if(!num){alert('Ingrese el número de factura.');return;}
  alert('Factura '+num+' registrada correctamente.');
}

function cancelar(){
        //alert(username)
        window.location.href = "{{url('/almacen/factura/')}}";
    }

document.getElementById('fechareg').value=new Date().toISOString().split('T')[0];
addRow();addRow();
  </script>
@endpush