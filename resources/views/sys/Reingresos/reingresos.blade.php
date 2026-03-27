@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
   <link href="{{ asset('assets/plugins/prismjs/prism.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
            <div class="alert alert-dark" role="alert">
                <h1 class="display-1 d-flex align-items-center">
                    <i data-feather="dollar-sign" class="me-3" style="width: 90px; height: 90px;"></i>
                    <strong>COBROS</strong>
                </h1>
                <h4 class="lead bg-white"><div class="alert alert-fill-white" role="alert">"Ofrecemos opciones de financiamineto para facilitar tu acceso a nuestros programas academicos."</div></h4>
                <br>
            </div>
                <hr/>
                <div class="col-12 col-md-12 col-xl-12">
                    <div class="card border-secondary">
                            {{--INICIO  AGREGAR VL--}}
                       <h5 class="card-header bg-azul text-white d-flex justify-content-between align-items-center">
                                <span class="text-white">
                                    <i class="text-white icon-lg pb-3px" data-feather="layers"></i>
                                    Datos Generales de Cobros
                                </span>
                                {{--BOTON AGREGAR--}}
                              <button class="btn btn-primary btn-xs" id="btn_agregar_reingreso" data-bs-toggle="modal" data-bs-target="#modal_agregar_reingreso">
                                <i class="btn-icon-prepend" data-feather="plus"></i> Agregar
                            </butotn>
                                </h5>
                                {{--FIN DE BOTON AGREGAR VL--}}
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="jambo_table table table-hover" id="tbl_ver_reingresos" border="1">
                                    <thead  class="bg-primary">
                                        <tr class="headings">
                                            <th scope="col" class="text-white">ID</th>
                                            <th scope="col" class="text-white">Tipo de Beca</th>
                                            <th scope="col" class="text-white">Descripcion</th>
                                            <th scope="col" class="text-white">Monto </th>
                                            <th scope="col" class="text-white">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($ver_reingresos as $row)
                                        <tr style="font-size: small;">
                                            <td scope="row">{{$row['id']}}</td>
                                            <td scope="row">{{$row['nombre']}}</td>
                                            <td scope="row">{{$row['descripcion']}}</td>
                                            <td scope="row">{{$row['monto']}}</td>
                                          <td>
                                        <button type="button" class="btn btn-warning btn-icon btn-xs btn_editar_reingreso"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal_editar_reingreso"
                                                    data-id="{{$row['id']}}"
                                                    data-nombre="{{$row['nombre']}}"
                                                    data-descripcion="{{$row['descripcion']}}"
                                                    data-monto="{{$row['monto']}}"
                                                  >
                                                    <i data-feather="check-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-icon btn-xs btn_eliminar_reingreso"
                                                    data-id="{{$row['id']}}"
                                                    data-nombre="{{$row['nombre']}}"
                                                    >
                                                    <i data-feather="trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{--MODAL AGREGAR--}}
<div class="modal fade" id="modal_agregar_reingreso" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
       <h6 class="modal-title h6 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="plus-square"></i> Ingresar Nuevo Dato</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label>Tipo de Beca</label>
          <input type="text" id="modal_agregar_reingreso_nombre" class="form-control" />
        </div>
        <div class="mb-3">
          <label>Descripción</label>
          <textarea id="modal_agregar_reingreso_descripcion" class="form-control"></textarea>
        </div>
        <div class="mb-3">
          <label>Monto</label>
          <input type="number" id="modal_agregar_reingreso_monto" class="form-control" />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="boton_guardar_reingreso">Guardar</button>
      </div>
    </div>
  </div>
</div>
{{--MODAL EDITAR--}}
<div class="modal fade" id="modal_editar_reingreso" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-warning">
       <h6 class="modal-title h6 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="edit-3"></i> Editar Datos</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="modal_editar_reingreso_id" />
        <div class="mb-3">
          <label>Tipo de Cobro</label>
          <input type="text" id="modal_editar_reingreso_nombre" class="form-control" />
        </div>
        <div class="mb-3">
          <label>Descripción</label>
          <textarea id="modal_editar_reingreso_descripcion" class="form-control"></textarea>
        </div>
        <div class="mb-3">
          <label>Monto</label>
          <input type="number" id="modal_editar_reingreso_monto" class="form-control" />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-warning" id="boton_editar_reingreso">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  .is-invalid {
    border: 1px solid red !important;
  }
</style>

@endpush

@push('plugin-scripts')
    <script>
    var varyingModal = document.getElementById('varyingModal')
    varyingModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget
      var recipient = button.getAttribute('data-bs-whatever')
      var modalTitle = varyingModal.querySelector('.modal-title')
      var modalBodyInput = varyingModal.querySelector('.modal-body input')

      modalTitle.textContent = 'New message to ' + recipient
      modalBodyInput.value = recipient
    })
  </script>
  <script src="{{ asset('assets/plugins/prismjs/prism.js') }}"></script>
  <script src="{{ asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
   <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>


@endpush
@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=mzutkZDE"></script>
  <script src="{{ asset('assets/plugins/feather-icons/feather.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
<script type="text/javascript">
let id = null;
let nombre = '';
let descripcion = '';
let monto = '';
let accion = 1;
let rowNumber = null;
let table = null;

const url_guardar_reingresos = '/reingresos/guardar';

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    table = $('#tbl_ver_reingresos').DataTable({

        "aLengthMenu": [[10, 30, 50, 100, -1], [10, 30, 50, 100, "Todo"]],
        "iDisplayLength": 10,

        language: {
            processing: "Procesando...",
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ registros",
            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            loadingRecords: "Cargando...",
            zeroRecords: "No se encontraron resultados",
            emptyTable: "Ningún dato disponible en esta tabla",
            paginate: {
                first: "Primero", previous: "Anterior", next: "Siguiente", last: "Último"
            },
            aria: {
                sortAscending: ": Activar para ordenar ascendente",
                sortDescending: ": Activar para ordenar descendente"
            }
        }
    });

    $('#tbl_ver_reingresos').each(function () {
        let datatable = $(this);
        let search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
        search_input.attr('placeholder', 'Buscar').removeClass('form-control-sm');
        datatable.closest('.dataTables_wrapper').find('div[id$=_length] select').removeClass('form-control-sm');
    });

    $("#tbl_ver_reingresos tbody").on("click", "tr", function () {
        rowNumber = parseInt(table.row(this).index());
        accion = 2;
        table.$("tr.selected").removeClass("selected");
        $(this).addClass("selected");
        localStorage.setItem("tbl_reingresos_id_seleccionar", table.row(this).data()[0]);
    });
});

function espera(mensaje) {
    Swal.fire({
        title: mensaje,
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });
}

const ToastLG = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

// Guardar/Actualizar/Eliminar
function guardar_tipos_reingreso() {
    if (accion !== 3 && (!nombre || !descripcion || !monto)) {
        Swal.fire('Campos vacíos', 'Todos los campos son obligatorios.', 'warning');
        return;
    }

    espera('Tu información se está guardando...');

    $.ajax({
        url: url_guardar_reingresos,
        method: "POST",
            headers: {
            'Authorization': '{{ session("token") }}'
        },
        data: {
        accion : accion,
        id : id,
        nombre : nombre,
        descripcion : descripcion,
        monto : monto
     },
        success: function (data) {
            let titleMsg, textMsg = '', typeMsg, timer;

            if (data.msgError) {
                titleMsg = "Error al guardar";
                textMsg = data.msgError;
                typeMsg = "error";
                timer = null;
            } else {
                titleMsg = data.msgSuccess || "Operación exitosa";
                typeMsg = "success";
                timer = 2000;

                if (data.reingreso_list) {
                    let row = data.reingreso_list;
                    let nuevaFilaDT = [
                        row.id,
                        row.nombre,
                        row.descripcion,
                        row.monto,
                        generarBotones(row)
                    ];

                    if (accion == 1) {
                        table.row.add(nuevaFilaDT).draw();
                          feather.replace();
                    } else if (accion == 2) {
                        table.row(rowNumber).data(nuevaFilaDT).draw();
                          feather.replace();
                    } else if (accion == 3) {
                        table.row(rowNumber).remove().draw();
                    }
                }

                // Ocultar todos los modales
                $('.modal').modal('hide');
            }

            ToastLG.fire({ icon: typeMsg, title: titleMsg, html: textMsg, timer });
        },
        error: function (xhr) {
            Swal.fire('Error', xhr.responseText || 'No se pudo procesar la solicitud.', 'error');
        }
    });
}

// Botones de acción
function generarBotones(row) {
    return `
        <button type="button" class="btn btn-warning btn-icon btn-xs btn_editar_reingreso"
            data-bs-toggle="modal" data-bs-target="#modal_editar_reingreso"
            data-id="${row.id}"
            data-nombre="${row.nombre}"
            data-descripcion="${row.descripcion}"
            data-monto="${row.monto}">
            <i data-feather="edit"></i>
        </button>
          <button type="button" class="btn btn-danger btn-icon btn-xs btn_eliminar_reingreso"
            data-id="${row.id}"
            data-nombre="${row.nombre}"
            data-descripcion="${row.descripcion}"
            data-monto="${row.monto}">
            <i data-feather="trash"></i>
        </button>`
        ;

}

// BOTÓN AGREGAR
$("#boton_guardar_reingreso").on("click", function () {
    accion = 1;
    id = null;

    let nombreInput = $("#modal_agregar_reingreso_nombre");
    let descripcionInput = $("#modal_agregar_reingreso_descripcion");
    let montoInput = $("#modal_agregar_reingreso_monto");

    nombre = nombreInput.val().trim();
    descripcion = descripcionInput.val().trim();
    monto = montoInput.val().trim();

    nombreInput.removeClass('is-invalid');
    descripcionInput.removeClass('is-invalid');
    montoInput.removeClass('is-invalid');

    let valido = true;

    if (!nombre) {
        nombreInput.addClass('is-invalid');
        valido = false;
    }
    if (!descripcion) {
        descripcionInput.addClass('is-invalid');
        valido = false;
    }
    if (!monto) {
        montoInput.addClass('is-invalid');
        valido = false;
    }

    if (!valido) {
        Swal.fire('Campos obligatorios', 'Completa todos los campos para continuar.', 'warning');
        return;
    }
     guardar_tipos_reingreso();
});

// LIMPIAR MODAL
$("#modal_agregar_reingreso").on("hidden.bs.modal", function () {
    $(this).find("input, textarea").val('');
    accion = 1;
});
$(".modal").on("hidden.bs.modal", function () {
    $(this).find("input, textarea").val('').removeClass('is-invalid');
});

// MODAL EDITAR
$("#modal_editar_reingreso").on("show.bs.modal", function (e) {
    let trigger = $(e.relatedTarget);
    rowNumber = table.row(trigger.parents('tr')).index();

    id = trigger.data("id");
    nombre = trigger.data("nombre");
    descripcion = trigger.data("descripcion");
    monto = trigger.data("monto");

    $("#modal_editar_reingreso_id").val(id);
    $("#modal_editar_reingreso_nombre").val(nombre);
    $("#modal_editar_reingreso_descripcion").val(descripcion);
    $("#modal_editar_reingreso_monto").val(monto);
});

$("#boton_editar_reingreso").on("click", function () {
    accion = 2;
    id = $("#modal_editar_reingreso_id").val();

    let nombreInput = $("#modal_editar_reingreso_nombre");
    let descripcionInput = $("#modal_editar_reingreso_descripcion");
    let montoInput = $("#modal_editar_reingreso_monto");

    nombre = nombreInput.val().trim();
    descripcion = descripcionInput.val().trim();
    monto = montoInput.val().trim();

    nombreInput.removeClass('is-invalid');
    descripcionInput.removeClass('is-invalid');
    montoInput.removeClass('is-invalid');

    let valido = true;

    if (!nombre) {
        nombreInput.addClass('is-invalid');
        valido = false;
    }
    if (!descripcion) {
        descripcionInput.addClass('is-invalid');
        valido = false;
    }
    if (!monto) {
        montoInput.addClass('is-invalid');
        valido = false;
    }

    if (!valido) {
        Swal.fire('Campos obligatorios', 'Completa todos los campos para continuar.', 'warning');
        return;
    }
    guardar_tipos_reingreso();
});

$(document).on("click", ".btn_eliminar_reingreso", function () {
    accion = 3;
    let boton = $(this);
    id = boton.data("id");
    nombre = boton.data("nombre");

    Swal.fire({
        title: '¿Estás seguro?',
        text: `De eliminar la informacion de: "${nombre}"`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            guardar_tipos_reingreso();
        }
    });
});

</script>
@endpush
