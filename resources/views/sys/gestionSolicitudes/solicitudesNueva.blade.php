@extends('sys.gestionSolicitudes.solicitudes')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/easymde/easymde.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content_gs')
<style>
   .file-upload {
      border: 2px dashed #ccc;
      border-radius: 10px;
      padding: 20px;
      text-align: center;
      cursor: pointer;
      transition: 0.2s;
    }
    .file-upload:hover {
      background-color: #f9f9f9;
    }
    .file-list {
      margin-top: 15px;
    }
    .file-item {
      background: #f2f2f2;
      border-radius: 6px;
      padding: 8px 12px;
      margin-bottom: 5px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 14px;
    }
    .file-item button {
      background: none;
      border: none;
      color: #d33;
      font-weight: bold;
      cursor: pointer;
      font-size: 16px;
    }
</style>
<div>
    <div class="d-flex align-items-center p-3 border-bottom tx-16 bg-primary">
        <span data-feather="edit" class="icon-md me-2"></span>
        Nueva Solicitud
    </div>
</div>
<div class="p-3 pb-0">
    <div class="to">
        <div class="row mb-3">
            <label class="col-md-2 col-form-label">Para:</label>
            <div class="col-md-10">
                <select class="compose-multiple-select form-select" id="departamento">
                    @foreach($departamentos as $row)
                    <option value="{{$row['id_departamento']}}">{{$row['descripcion']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-md-4 col-form-label">Fecha y hora de vencimiento:</label>
            <div class="col-md-4">
                <div class="input-group flatpickr" id="flatpickr-date">
                    <input type="text" class="form-control" placeholder="Selecciona una fecha" data-input id="fecha_vencimiento">
                    <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group flatpickr" id="flatpickr-time">
                    <input type="text" class="form-control" placeholder="Selecciona una hora" data-input id="hora_vencimiento">
                    <span class="input-group-text input-group-addon" data-toggle><i data-feather="clock"></i></span>
                </div>
            </div>
            <div class="col-md-1 d-flex justify-content-end">
                <button type="button" class="btn btn-info btn-icon" id="btn_info_fechas">
                    <i data-feather="info"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="px-3">
    <div class="col-md-12">
        <div class="mb-3">
            <label class="form-label visually-hidden" for="descripcion_solicitud">Descriptions </label>
            <textarea class="form-control" name="easymde" id="descripcion_solicitud" rows="5" placeholder="Escriba aquí..."></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 stretch-card grid-margin grid-margin-md-0">
            <div class="card-body">
                <h6 class="card-title">Adjuntar Archivos</h6>
                <!-- <p class="text-muted mb-3">Arrastra y suelta tus archivos aquí, o haz clic para seleccionarlos y cargarlos.</p>
                <form action="#" class="dropzone" id="adjuntos_solicitud"></form> -->


                <div class="file-upload" id="fileUpload">
                  <p>Arrastra o haz clic para seleccionar archivos</p>
                  <input type="file" id="inputArchivos" multiple hidden>
                </div>

                <div id="fileList" class="file-list"></div>
            </div>
        </div>

        <div>
            <div class="col-md-12">
                <div class="d-grid gap-2">
                <button class="btn btn-primary me-1 mb-1" type="button" id="enviar_solicitud"><i data-feather="send" class="icon-lg me-2"></i> Enviar</button>
                </div>
                <!-- <button class="btn btn-secondary me-1 mb-1" type="button"> Cancel</button> -->
            </div>
        </div>
    </div>
</div>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/easymde/easymde.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/dropzone/dropzone.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/email.js') }}"></script>
  <script src="{{ asset('assets/js/dropzone.js') }}"></script>
  <script src="{{ asset('assets/js/tinymce.js') }}"></script>
  <script src="{{ asset('assets/js/easymde.js') }}"></script>
  <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
  <!-- <script src="{{ asset('assets/js/flatpickr.js') }}"></script> -->
  <script src="{{ asset('assets/js/flatpickr/dist/110n/es.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=mzutkZDE"></script>
  <script type="text/javascript">
    var accion = null;
    var btn_activo = true;
    var departamento = null;
    var fecha_vencimiento = null;
    var hora_vencimiento = null;
    var descripcion = null;
    var adjuntos = null;
    var url_guardar_solicitud = "{{url('/gestion_solicitudes/nueva/guardar')}}"; 
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    const fechaHoraValida = obtenerFechaHoraValida();
    $(function() {
                'use strict';

                //Tinymce editor
                if ($("#descripcion_solicitud").length) {
                    tinymce.init({
                    selector: '#descripcion_solicitud',
                    height: 250,
                    menubar: false,
                    default_text_color: 'red',
                    plugins: 'advlist autolink lists link image charmap preview anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen',
                    toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
                    //toolbar2: 'forecolor backcolor emoticons',
                    image_advtab: false,
                    paste_data_images: false,
                    templates: [{
                        title: 'Test template 1',
                        content: 'Test 1'
                        },
                        // {
                        // title: 'Test template 2',
                        // content: 'Test 2'
                        // }
                    ],
                    content_css: []
                    });
                }
                
            });

      // $(function() {
      //   'use strict';

      //   $("adjuntos_solicitud").dropzone({
      //     autoProcessQueue: false,   // No subir automáticamente
      //     addRemoveLinks: true,      // Muestra el enlace “Eliminar archivo”
      //     dictRemoveFile: "Eliminar",// Texto del botón
          
      //   });
      // });

    $(function() {
        'use strict';

        // date picker 
        if($('#flatpickr-date').length) {
            flatpickr("#flatpickr-date", {
            wrap: true,
            dateFormat: "Y-m-d",
            locale: "es",
            minDate: "today",
            disable: [
                    function(date) {
                        // 0 = domingo, 6 = sábado
                        return (date.getDay() === 0 || date.getDay() === 6);
                    }
                ],
            });
        }


        // time picker
        if($('#flatpickr-time').length) {
            flatpickr("#flatpickr-time", {
            wrap: true,
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            minTime: "today",
            minTime: "08:00",
            maxTime: "16:30"
            });
        }

    });

    $("#btn_info_fechas").on("click", function () {
        recomendacion_fecha(fechaHoraValida);
    });
      
    $("#enviar_solicitud").on("click", function () {
        departamento = $("#departamento").val();
        fecha_vencimiento = $("#fecha_vencimiento").val();
        hora_vencimiento = $("#hora_vencimiento").val();
        descripcion = tinymce.get('descripcion_solicitud').getContent();

        const ahora = new Date();
        const horas = String(ahora.getHours()).padStart(2, '0');
        const minutos = String(ahora.getMinutes()).padStart(2, '0');
        const horaActual = horas + ":" + minutos;
        
            if(fecha_vencimiento == null || fecha_vencimiento == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Por favor, asigne una fecha de vencimiento.'
                })
                return true;
            }

            if(hora_vencimiento == null || hora_vencimiento == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Por favor, asigne una hora de vencimiento.'
                })
                return true;
            }

            /*if(hora_vencimiento <= horaActual){
                Toast.fire({
                    icon: 'error',
                    title: 'No puede seleccionar una hora anterior a la actual.'
                })
                return true;
            }*/

            if((fecha_vencimiento+' '+hora_vencimiento) <= fechaHoraValida){
                recomendacion_fecha(fechaHoraValida);
                return true;
            }
            
            if(descripcion == null || descripcion == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Por favor, describe tu solicitud antes de enviarla.'
                })
                return true;
            }

            if(btn_activo){
                guardar_solicitud();
            }
            

    });

    });

     const inputArchivos = document.getElementById('inputArchivos');
        const fileUpload = document.getElementById('fileUpload');
        const fileList = document.getElementById('fileList');
        let archivosSeleccionados = [];

        // Abrir selector al hacer clic en el área
        fileUpload.addEventListener('click', () => inputArchivos.click());

        // Arrastrar y soltar
        fileUpload.addEventListener('dragover', e => {
          e.preventDefault();
          fileUpload.style.backgroundColor = '#eef';
        });
        fileUpload.addEventListener('dragleave', () => {
          fileUpload.style.backgroundColor = '';
        });
        fileUpload.addEventListener('drop', e => {
          e.preventDefault();
          fileUpload.style.backgroundColor = '';
          agregarArchivos(e.dataTransfer.files);
        });

        // Al seleccionar archivos manualmente
        inputArchivos.addEventListener('change', e => agregarArchivos(e.target.files));

        // Función para agregar archivos
        function agregarArchivos(files) {
          for (const file of files) {
            // Evitar duplicados por nombre
            if (!archivosSeleccionados.some(f => f.name === file.name)) {
              archivosSeleccionados.push(file);
            }
          }
          mostrarListaArchivos();
        }

        // Mostrar lista de archivos
        function mostrarListaArchivos() {
          fileList.innerHTML = '';
          archivosSeleccionados.forEach((file, index) => {
            const item = document.createElement('div');
            item.className = 'file-item';
            item.innerHTML = `
              <span>${file.name} (${(file.size/1024).toFixed(1)} KB)</span>
              <button onclick="eliminarArchivo(${index})">&times;</button>
            `;
            fileList.appendChild(item);
          });
        }

        // Eliminar archivo de la lista
        function eliminarArchivo(index) {
          archivosSeleccionados.splice(index, 1);
          mostrarListaArchivos();
        }

    function guardar_solicitud() {
        espera('Enviando tu solicitud...');
        const formData = new FormData();
        // Agregar archivos
        archivosSeleccionados.forEach((file, i) => {
            formData.append('archivos[]', file, file.name);
        });

        // Agregar otros campos
        formData.append('departamento', departamento);
        formData.append('fecha_vencimiento', fecha_vencimiento);
        formData.append('hora_vencimiento', hora_vencimiento);
        formData.append('descripcion', descripcion);

        btn_activo = false;

        $.ajax({
            type: "post",
            url: url_guardar_solicitud,
            data: formData,
            processData: false, // IMPORTANTE: evita que jQuery convierta los datos a string
            contentType: false, // IMPORTANTE: permite enviar multipart/form-data
            success: function (data) {
                if (data.msgError != null) {
                    titleMsg = "Error al Guardar";
                    textMsg = data.msgError;
                    typeMsg = "error";
                    timer = null;
                    btn_activo = true;
                    timeout = data.timeout;
                } else {
                    titleMsg = "Solicitud Enviada";
                    textMsg = data.msgSuccess;
                    typeMsg = "success";
                    timer = null;
                    timeout = false;
       
                    //btn_activo = true;
                }
                //console.log(textMsg);
                ToastLG({
                    icon: typeMsg,
                    title: titleMsg,
                    html: textMsg,
                    timer: timer,
                    timeout: timeout
                })

            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            },
        });
    }

    const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

    const ToastLG = (options) => {
        Swal.fire({
            showConfirmButton: (typeMsg == 'error') ? false : true,
            showDenyButton: timeout,
            showCancelButton: (typeMsg == 'success') ? false : true,
            confirmButtonText: 'Aceptar',
            denyButtonText: 'Reintentar',
            cancelButtonText: 'Cancelar',
            timerProgressBar: true,
            allowOutsideClick: false,
            ...options
        }).then((result) => {

            if (result.isConfirmed) {
                espera('Recargando...');
                location.reload(); // opción 1
            }

            else if (result.isDenied) {
                guardar_solicitud()
            }

            else if (result.isDismissed) {
                console.log('El usuario canceló'); // opción 3
            }

        });
    };

    function espera(html){
        let timerInterval
        Swal.fire({
            imageUrl: "{{ url(asset('/assets/images/unag_loading.gif')) }}",
            // icon: 'warning',
            title: '¡Espera!',
            html: html,
            timer: null,
            timerProgressBar: true,
            allowOutsideClick: false,
            didOpen: () => {
            Swal.showLoading()
            timerInterval = setInterval(() => {
                const content = Swal.getHtmlContainer()
                if (content) {
                const b = content.querySelector('b')
                if (b) {
                    b.textContent = Swal.getTimerLeft()
                }
                }
            }, 100)
            },
            willClose: () => {
            clearInterval(timerInterval)
            }
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
            console.log('I was closed by the timer')
            }
        })
    }

    function recomendacion_fecha(fechaHoraValida){
        Swal.fire({
            title: 'Recomendación',
            icon: 'info',
            confirmButtonText: 'Aceptar',
            html: `
                <div style="text-align: justify; line-height: 1.5;">
                    La fecha y hora de vencimiento de la solicitud deben establecerse de manera que sean al menos <b>seis (6) horas</b> posteriores a la hora actual,
                    respetando únicamente los días laborales de <b>lunes a viernes</b>,
                    dentro del horario comprendido entre <b>08:00 y 16:30</b>.<br><br>
                    Esto garantiza que las solicitudes se gestionen dentro de los períodos hábiles y evita la programación de vencimientos fuera del horario laboral.<br><br>
                    <center>Fecha y hora sugerida a partir de este momento:<br> <strong>${fechaHoraValida}</strong></center>
                </div>
            `
        });
    }

    function obtenerFechaHoraValida() {
       let ahora = new Date();

        // Definir horario laboral
        const horaInicio = 8;
        const horaFin = 16;
        const minutoFin = 30;

        // Sumar 6 horas
        let horasSumar = 6;
        let minutosSumar = 0;

        while (horasSumar > 0) {
            let horaActual = ahora.getHours();
            let minutoActual = ahora.getMinutes();

            // Si estamos antes de la jornada laboral, mover al inicio
            if (horaActual < horaInicio || (horaActual === horaInicio && minutoActual === 0)) {
                ahora.setHours(horaInicio, 0, 0, 0);
                horaActual = horaInicio;
                minutoActual = 0;
            }

            // Calcular minutos disponibles hasta el fin de jornada
            let minutosDisponibles = (horaFin * 60 + minutoFin) - (horaActual * 60 + minutoActual);

            if (horasSumar * 60 <= minutosDisponibles) {
                // Cabe en el día actual
                ahora.setMinutes(minutoActual + horasSumar * 60);
                horasSumar = 0;
            } else {
                // No cabe, usar lo que queda y pasar al siguiente día hábil
                horasSumar -= minutosDisponibles / 60;
                // Pasar al siguiente día
                ahora.setDate(ahora.getDate() + 1);
                ahora.setHours(horaInicio, 0, 0, 0);

                // Evitar sábados y domingos
                while (ahora.getDay() === 0 || ahora.getDay() === 6) {
                    ahora.setDate(ahora.getDate() + 1);
                }
            }
        }

        // Retornar en formato YYYY-MM-DD HH:MM
        const yyyy = ahora.getFullYear();
        const mm = String(ahora.getMonth() + 1).padStart(2, '0');
        const dd = String(ahora.getDate()).padStart(2, '0');
        const hh = String(ahora.getHours()).padStart(2, '0');
        const min = String(ahora.getMinutes()).padStart(2, '0');

        return `${yyyy}-${mm}-${dd} ${hh}:${min}`;
        }


  </script>
@endpush