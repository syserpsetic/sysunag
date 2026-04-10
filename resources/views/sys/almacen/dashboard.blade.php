@extends('layout.master')

@section('content')
<!-- Sección de resumen de citas -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Resumen Almacén</h5>
                    
                </div>
                
                <div class="row g-3" id="resumenCitasContainer">
                    <!-- Tarjetas generadas dinámicamente -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Título y card de gestión de citas -->
<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-3">Reportes</h2>
        <div class="card shadow-sm">
            <div class="card-body">
                <!-- Fechas -->
                <div class="d-flex align-items-center flex-wrap gap-3 mb-3">
                    <div>
                        Fecha inicio: <input class="form-control" type="date" id="inicio">
                    </div>
                    <div>
                        Fecha fin: <input class="form-control" type="date" id="fin">
                    </div>
                </div>

                <!-- Cards en fila -->
                <div class="row g-3">

                    <!-- Card Proveedor -->
                    <div class="col-xl-6 col-12">
                        <div class="card bg-info text-white h-100 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title mb-1 text-white">Proveedor</h6>
                                        <h3 class="card-text mb-0 fw-bold text-white">
                                            <i class="fas fa-spinner fa-spin text-white"></i>
                                        </h3>
                                    </div>
                                    <div>
                                       <a id="proveedor"> <i style="color:white" class="link-icon" data-feather="download"></i> </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <small class="text-white">
                                    <i class="fas fa-clock me-1"></i>
                                    <span style="color:white !important"></span>
                                </small>
                                <!-- Select dentro del footer de la card -->
                                <div class="mt-2">
                                    <select class="form-control form-control-sm" name="prov" id="prov">
                                        <option selected disabled value="0">Seleccionar Proveedor</option>
                                        @foreach($proveedores_list as $row)
                                        <option value="{{ $row['id'] }}">{{ $row['nombre'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Área -->
                    <div class="col-xl-6 col-12">
                        <div class="card bg-info text-white h-100 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title mb-1 text-white">AREA</h6>
                                        <h3 class="card-text mb-0 fw-bold text-white">
                                            <i class="fas fa-spinner fa-spin text-white"></i>
                                        </h3>
                                    </div>
                                    <div>
                                       <a  id="area"> <i style="color:white" class="link-icon" data-feather="download"></i> </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <small class="text-white">
                                    <i class="fas fa-clock me-1"></i>
                                    <span style="color:white !important"></span>
                                </small>
                                <!-- Select dentro del footer de la card -->
                                <div class="mt-2">
                                    <select class="form-control form-control-sm" name="areas" id="areas">
                                        <option selected disabled value="0">Seleccionar Area</option>
                                        @foreach($area_list as $row1)
                                        <option value="{{ $row1['id_departamento'] }}">{{ $row1['descripcion'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                </div><!-- fin row g-3 -->
            </div>
        </div>
    </div>
</div>



@endsection

@push('plugin-styles')

<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>

<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@push('custom-scripts')
    <script>
            
    document.addEventListener("DOMContentLoaded", function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Variables globales
        let calendar = null;
        let citaSeleccionada = null;
        let todasLasCitas = [];

        var inicio = null;
        var fin = null;
        var areas = null;
        var proveedores = null;


        //reportes
        $("#proveedor").on("click", function(e){
            e.preventDefault(); 

            inicio=document.getElementById("inicio").value;
            fin=document.getElementById("fin").value;
            proveedores=document.getElementById("prov").value;
            //alert(proveedores);

            if (proveedores==0 || proveedores==null) {
                // Mostrar notificación de error (opcional)
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Seleccionar un proveedor.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
                //alert('Seleccionar un proveedor.'); 
                return;
            }

            check();                 
        });


        $("#area").on("click", function(e){
            e.preventDefault(); 
        
            inicio=document.getElementById("inicio").value;
            fin=document.getElementById("fin").value;
            areas=document.getElementById("areas").value;
            //alert(proveedores);

            if (areas==0 || areas==null) {
                  // Mostrar notificación de error (opcional)
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Seleccionar una area.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
                //alert('Seleccionar una area.'); 
                return;
            }
            check2();                 
        });

        

        function check(){
            //alert(document.getElementById("inicio").value);
            if(inicio>fin || !inicio || !fin){      
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'La fecha de inicio es menor que la final o no son validas.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }      
                //alert("La fecha de inicio es menor que la final o no son validas.");
                return;
            }

            //alert(inicio);return;

            window.open("{{url('reporte_proveedores')}}"+"/"+inicio+"/"+fin+"/"+proveedores);

        }



        function check2(){
            //alert(document.getElementById("inicio").value);
            if(inicio>fin || !inicio || !fin){
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'La fecha de inicio es menor que la final o no son validas.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                } 
                //alert("La fecha de inicio es menor que la final o no son validas.");
                return;
            }


            window.open("{{url('reporte_area')}}"+"/"+inicio+"/"+fin+"/"+areas);

        }

      

        // Configuración de las tarjetas del resumen (actualizada)
        const resumenConfig = [
            { 
                id: "facturas", 
                title: "Facturas", 
                color: "primary", 
                icon: "credit-card",
                key: "facturas" 
            },
            { 
                id: "requisiciones", 
                title: "Requisiciones", 
                color: "success", 
                icon: "file-text",
                key: "requisiciones" 
            },
            { 
                id: "productos", 
                title: "Productos", 
                color: "warning", 
                icon: "shopping-bag",
                key: "productos" 
            },
            { 
                id: "proveedores", 
                title: "Proveedores", 
                color: "danger", 
                icon: "users",
                key: "proveedores" 
            },
            
        ];

        // Función para renderizar las tarjetas del resumen (mejorada)
        function renderizarResumen() {
            const container = $("#resumenCitasContainer");
            container.empty();
            
            resumenConfig.forEach((item) => {
                container.append(`
                    <div class="col-xl-3 col-md-6 col-12 mb-3">
                        <div class="card bg-${item.color} text-white h-100 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title mb-1 text-white">${item.title}</h6>
                                        <h3 class="card-text mb-0 fw-bold text-white" id="${item.id}">
                                            <i class="fas fa-spinner fa-spin text-white"></i>
                                        </h3>
                                    </div>
                                    <div>                                        
                                        <i style="color:white" class="link-icon" data-feather="${item.icon}"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <small class="text-white">
                                    <i class="fas fa-clock me-1"></i>
                                    <span id="timestamp-${item.id}">Cargando...</span>
                                </small>
                            </div>
                        </div>
                    </div>
                `);
            });
        }

        

        actualizarResumenAlmacen();



        // Función para actualizar resumen de almacen 
        async function actualizarResumenAlmacen() {
            try {
                // Mostrar indicador de carga
                resumenConfig.forEach((item) => {
                    $(`#${item.id}`).html('<i class="fas fa-spinner fa-spin"></i>');
                });

                const response = await $.ajax({
                    url: '{{ route("almacen_resumen") }}',
                    method: 'GET',
                    dataType: 'json'
                });

                if (response.estatus && response.estadisticas) {
                    const stats = response.estadisticas;
                    
                    // Actualizar cada tarjeta con animación
                    resumenConfig.forEach((item) => {
                        const valor = stats[item.key] || 0;
                        animarCambioValor(`#${item.id}`, valor);
                    });

                    // Actualizar tooltips
                    actualizarTooltipsResumen();
                    
                    console.log('Estadísticas actualizadas:', stats);
                } else {
                    throw new Error(response.mensaje || 'Error en la respuesta');
                }
            } catch (error) {
                console.error("Error al actualizar resumen:", error);
                
                // Mostrar error en las tarjetas
                resumenConfig.forEach((item) => {
                    $(`#${item.id}`).html('<i class="fas fa-exclamation-triangle text-danger"></i>');
                });
                
                // Mostrar notificación de error (opcional)
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudieron cargar las estadísticas',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            }
        }

        

        // Función para animar cambio de valor 
        function animarCambioValor(elemento, nuevoValor) {
            const $elemento = $(elemento);
            const valorActual = parseInt($elemento.text()) || 0;
            
            // Si el valor no ha cambiado, solo actualizar sin animación
            if (valorActual === nuevoValor) {
                $elemento.text(nuevoValor);
                return;
            }
            
            // Animación de contador
            $({ count: valorActual }).animate(
                { count: nuevoValor },
                {
                    duration: 800,
                    easing: 'swing',
                    step: function () {
                        $elemento.text(Math.floor(this.count));
                    },
                    complete: function() {
                        $elemento.text(nuevoValor);
                        
                        // Efecto de pulso para valores que cambiaron
                        if (valorActual !== nuevoValor) {
                            $elemento.closest('.card').addClass('border-light');
                            setTimeout(() => {
                                $elemento.closest('.card').removeClass('border-light');
                            }, 1000);
                        }
                    }
                }
            );
        }


           // Función para actualizar tooltips con timestamp
        function actualizarTooltipsResumen() {
            const timestamp = new Date().toLocaleString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            resumenConfig.forEach((item) => {
               $(`#timestamp-${item.id}`).text(`Actualizado: ${timestamp}`).addClass('text-white');
                $(`#${item.id}`).closest('.card').attr('title', `Última actualización: ${timestamp}`);
            });
        }

 

        // Llamar al renderizado inicial
        renderizarResumen();

   

 
});
</script>
@endpush