@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<style>
.limit-text-tittle {
    display: -webkit-box;
    -webkit-line-clamp: 2; /* Limita a 4 líneas */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    min-height: calc(1.2em * 2); /* Mantiene el espacio para 4 líneas (ajusta según el tamaño de fuente) */
    line-height: 1.2em; /* Espaciado entre líneas */
}

.limit-text {
    display: -webkit-box;
    -webkit-line-clamp: 4; /* Limita a 4 líneas */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    min-height: calc(1.2em * 4); /* Mantiene el espacio para 4 líneas (ajusta según el tamaño de fuente) */
    line-height: 1.2em; /* Espaciado entre líneas */
}


/* Contenedor principal */
 /* Contenedor principal */
 .news-ticker {
            display: flex;
            align-items: center;
            width: 100%;
            background: linear-gradient(90deg, #1ba333, #000);
            padding: 10px 20px;
            overflow: hidden;
            position: relative;
            border-radius: 10px;
        }

        /* Estilo del círculo */
        .news-logo {
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, #ffffff, #c6f7ff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .news-logo img {
            width: 70px;
            height: auto;
        }

        /* Estilo del círculo */
        .news-perfil {
            width: 40px;
            height: 40px;
            background: radial-gradient(circle, #ffffff, #c6f7ff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            overflow: hidden; /* Para evitar que la imagen sobresalga */
        }

        .news-perfil img {
            width: 100%;  /* Ajusta al tamaño del contenedor */
            height: 100%;
            border-radius: 50%;
            object-fit: cover; /* Evita deformaciones */
        }

        .news-perfil-nexus {
            width: 15px;
            height: 15px;
            background: radial-gradient(circle, #ffffff, #c6f7ff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
            overflow: hidden; /* Para evitar que la imagen sobresalga */
                }

                .news-perfil-nexus img {
                    width: 100%;  /* Ajusta al tamaño del contenedor */
            height: 100%;
            border-radius: 50%;
            object-fit: cover; /* Evita deformaciones */
                }

        /* Contenedor de noticias */
        .news-content {
            flex: 1;
            overflow: hidden;
            position: relative;
        }

        /* Animación de desplazamiento */
        @keyframes scrollNews {
            0% { opacity: 0; transform: translateX(100%); }
            5% { opacity: 1; transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }

        /* Contenedor de noticias */
        .news-container {
            display: flex;
            gap: 40px;
            width: max-content; /* Se ajusta al tamaño del contenido */
            white-space: nowrap;
            position: relative;
        }

  /* Estilo de los textos */
  .news-container h2 {
            display: flex;
            align-items: center;
            color: white;
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }

        .news-container a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .news-container a:hover {
            text-decoration: underline;
        }
        .modal-xl {
        width: 90%; /* Ajusta el ancho del modal */
        max-width: 1200px; /* Máximo ancho */
    }
</style>

<div class="row chat-wrapper">
    <div class="col-md-12">
        @if(in_array('malla_validacion_leer_cinta_noticias', $scopes))
        <div class="news-ticker">
            <div class="news-logo">
                <img src="{{asset('/assets/images/logo_setic.png')}}" alt="Logo">
            </div>
            <div class="news-content">
                <div class="news-container" id="newsContainer">
                    @foreach($noticias as $row)
                    <h2 style="display: flex; align-items: center; gap: 8px;">
                        <div class="news-perfil">
                            <img src="{{ asset('/matricula/documentos/fotos/')}}/{{$row['foto']}}" 
                            alt="Foto_perfil"
                            onerror="this.onerror=null; this.src='{{ url(asset('/assets/images/user2-403d6e88.png')) }}';">

                        </div>
                        <span><a href="#">{{$row['proyeccion'] }}</a></span>
                    </h2>

                    @endforeach {{--<span>📢 <a href="#">Muy pronto sección de anuncios, sitio en construcción oye.</a></span>--}}
                </div>
            </div>
        </div>
        <br>
        @endif
        <div class="card">
            <div class="card-body">
                <div class="row position-relative">
                @if(in_array('malla_validacion_leer_lista_pendientes', $scopes))
                    <div class="col-lg-4 chat-aside border-end-lg">
                        <div class="aside-content">
                            <div class="aside-body">
                                <ul class="nav nav-tabs nav-fill mt-3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active bg-primary" id="chats-tab" data-bs-toggle="tab" data-bs-target="#chats" role="tab" aria-controls="chats" aria-selected="true">
                                            <div class="d-flex flex-row flex-lg-column flex-xl-row align-items-center justify-content-center">
                                                <p class="d-none d-sm-block text-white"><i class="icon-lg pb-3px" data-feather="clipboard"></i> <strong>NEXUS</strong></p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3">
                                    <div class="tab-pane fade show active" id="chats" role="tabpanel" aria-labelledby="chats-tab">
                                        <div>
                                            <p class="mb-1">Tareas Pendientes</p>
                                            <ul class="list-unstyled chat-list px-1">
                                                @foreach ($personas as $row)
                                                <li class="chat-item pe-1">
                                                    <a href="javascript:void(0);" onclick="detalle_tareas({{ $row['id_member'] }}, {{ $row['tareas'] }})" class="d-flex align-items-center">
                                                        <figure class="mb-0 me-2">
                                                            <img
                                                                src="{{ asset('/matricula/documentos/fotos/')}}/{{$row['foto']}}"
                                                                class="img-xs rounded-circle"
                                                                alt="user"
                                                                onerror="this.onerror=null; this.src='{{ url(asset('/assets/images/user2-403d6e88.png')) }}';"
                                                            />
                                                            <div class="status online"></div>
                                                        </figure>
                                                        <div class="d-flex justify-content-between flex-grow-1 border-bottom">
                                                            <div>
                                                               <p class="text-body"><strong>{{ $row['member'] }}</strong></p>
                                                                <!-- <p class="text-muted tx-13">Hi, How are you?</p> -->
                                                            </div>
                                                            <div class="d-flex flex-column align-items-end">
                                                                <!-- <p class="text-muted tx-13 mb-1">4:32 PM</p> -->
                                                                <div class="badge rounded-pill bg-primary ms-auto">{{ $row['tareas'] }}</div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if(in_array('malla_validacion_leer_lista_pendientes', $scopes))
                        <div class="col-lg-8 col-sm-12 chat-content">
                    @else 
                        <div class="col-lg-12 col-sm-12 chat-content">
                    @endif
                        <div class="chat-body">
                            <div class="row">
                                <div class="col-12 col-xl-12 col-sm-12 stretch-card">
                                    <div class="row flex-grow-1">
                                        @foreach($indicadoresMallaValidaciones as $row)
                                        <div class="col-md-3 grid-margin stretch-card">
                                            <div @if($row['estudiantes']!=0) class="card border-danger" @else class="card border-primary" @endif>
                                                <div @if($row['estudiantes']!=0) class="card-header bg-danger" @else class="card-header bg-primary" @endif>
                                                    <div class="d-flex justify-content-between align-items-baseline">
                                                        <h6 class="mb-0 text-white"><strong>{{$row['indicador_titulo']}}</strong></h6>
                                                        <div class="dropdown mb-2">
                                                            <button class="btn btn-link p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="icon-lg pb-3px text-white" data-feather="chevrons-down"></i>
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="alert-circle" class="icon-sm me-2"></i> <span class="">Info</span></a>
                                                                <a class="dropdown-item d-flex align-items-center" href="{{url($row['btn_detalle_ruta'])}}"><i data-feather="align-justify" class="icon-sm me-2"></i> <span class="">Ir a detalle</span></a>
                                                                @if($row['btn_accion_id'] != null)
                                                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="refresh-ccw" class="icon-sm me-2"></i> <span class="">Refrescar Vista</span></a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 col-md-12 col-xl-12">
                                                            <h2 class="mb-2">{{$row['estudiantes']}}</h2>
                                                            <div class="d-flex align-items-baseline">
                                                                <p class="text-info">
                                                                    <i data-feather="info" class="icon-sm mb-1"></i>
                                                                    <span>{{$row['indicador_subtitulo']}}</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Extra large modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".modal_detalle_tareas_personas">Extra large modal</button> -->
      <div class="modal fade modal_detalle_tareas_personas" id="modal_detalle_tareas_personas" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
      
            <div class="modal-header bg-primary">
              <h5 class="modal-title h4 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="clock"></i> Detalles de tareas pendientes</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="position-relative">
                                <center>
                                    <br>
                                    <div id="modal_detalle_tareas_personas_responsable">
                                        <img class="wd-70 rounded-circle" src="https://portal.unag.edu.hn/matricula/documentos/fotos/" alt="profile" onerror="this.onerror=null; this.src='{{ url(asset('/assets/images/user2-403d6e88.png')) }}';">
                                        <span class="h4 ms-3 text-dark">Amiah Burton</span>
                                    </div>
                                </center>
                                <div class="card-body">
                                    <div class="card border-secondary">
                                        <h5 class="card-header bg-azul text-white"><i class="text-white icon-lg pb-3px" data-feather="list"></i> Tareas Pendientes</h5>
                                        <div class="card-body">
                                            <div class="list-group" id="modal_detalle_tareas_personas_lista">
                                                <a href="#" class="list-group-item list-group-item-action" aria-current="true">
                                                    <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">List group item heading</h5>
                                                    <small>3 days ago</small>
                                                    </div>
                                                    <p class="mb-1">Some placeholder content in a paragraph.</p>
                                                    <small>And some small print.</small>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-secondary">
            <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">Aceptar</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Large modal -->

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=mzutkZDE"></script>
  <script type="text/javascript">
    var url_setic_malla_validacion_tareas_pendientes_personas = "{{url('setic/malla_validacion/tareas_pendientes_personas')}}"; 
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.sidebar-toggler not-active').trigger("click");

        @if(in_array('malla_validacion_reproducir_narrador', $scopes) && ($narracion['narracion'] != null || $narracion['narracion'] != ''))
            var mensaje = 'SE HAN ASIGNADO NUEVAS TAREAS A: {{$narracion->narracion}}';
            console.log(mensaje);
            responsiveVoice.speak(mensaje, "Spanish Latin American Female", {
                rate: 1.2,   // Aumenta la velocidad al 180%
                pitch: 1,  // Un poco más agudo
                volume: 1    // Máximo volumen
            });
        @endif

        const newsContainer = document.getElementById("newsContainer");
            let position = window.innerWidth;

            function scrollNews() {
                position -= 1.8; // Velocidad del desplazamiento
                newsContainer.style.transform = `translateX(${position}px)`;

                // Si toda la cinta salió de la pantalla, reiniciar
                if (position < -newsContainer.offsetWidth) {
                    position = window.innerWidth;
                }

                requestAnimationFrame(scrollNews); // Llamada continua para suavidad
            }

            scrollNews(); // Iniciar animación
            
        setTimeout(function () {
            location.reload();
        }, 300000);


    });
    $(function() {
        'use strict';

        // Applying perfect-scrollbar 
        if ($('.chat-aside .tab-content #chats').length) {
            const sidebarBodyScroll = new PerfectScrollbar('.chat-aside .tab-content #chats');
        }
        if ($('.chat-aside .tab-content #calls').length) {
            const sidebarBodyScroll = new PerfectScrollbar('.chat-aside .tab-content #calls');
        }
        if ($('.chat-aside .tab-content #contacts').length) {
            const sidebarBodyScroll = new PerfectScrollbar('.chat-aside .tab-content #contacts');
        }

        if ($('.chat-content .chat-body').length) {
            const sidebarBodyScroll = new PerfectScrollbar('.chat-content .chat-body');
        }

        $('.loaded').addClass('loaded sidebar-folded');
        // $('.chat-aside').toggleClass('show');
        
        $( '.chat-list .chat-item' ).each(function(index) {
            $(this).on('click', function(){
            $('.chat-content').toggleClass('show');
            });
        });

        $('#backToChatList').on('click', function(index) {
            $('.chat-content').toggleClass('show');
        });

        });


        function detalle_tareas(id_member, pendientes){
            //alert(id_member);
            $.ajax({
                type: "post",
                url: url_setic_malla_validacion_tareas_pendientes_personas,
                data: {
                    "id_member": id_member,
                },
                success: function (data) {
                    if (data.msgError != null) {
                        titleMsg = "Error al Cargar";
                        textMsg = data.msgError;
                        typeMsg = "error";
                    } else {
                        titleMsg = "Datos Cargados";
                        textMsg = data.msgSuccess;
                        typeMsg = "success";
                        var detalle_tareas = data.detalle_tareas;
                        $("#modal_detalle_tareas_personas_responsable").html('');
                        $("#modal_detalle_tareas_personas_total").html('');
                        $("#modal_detalle_tareas_personas_lista").html('');
                        for (var i = 0; i < detalle_tareas.length; i++) {
                            var row = detalle_tareas[i];
                            $("#modal_detalle_tareas_personas_responsable").html(
                                '<div style="display: flex; align-items: center; justify-content: center; text-align: center; gap: 10px; width: 100%;">' +
                                    '<img width="120" height="120" class="rounded-circle" src="{{ asset('/matricula/documentos/fotos/')}}/' + row.foto + '" alt="profile" onerror="this.onerror=null; this.src=\'{{ url(asset('/assets/images/user2-403d6e88.png')) }}\';">'+
                                    '<h4><strong>' + row.member + '</strong></h4>'+
                                '</div>'
                            );



                            $("#modal_detalle_tareas_personas_total").html(pendientes+' <i class="fa fa-exclamation-circle"></i>');
                            $("#modal_detalle_tareas_personas_lista").append(
                                                '<a href="#" class="list-group-item list-group-item-action" aria-current="true">'+
                                                    '<div class="d-flex w-100 justify-content-between">'+
                                                    '<h5 class="mb-1">' + row.name + '</h5>'+
                                                    '<small>'+ row.estado +'</small>'+
                                                    '</div>'+
                                                    '<p class="mb-1"></p>'+
                                                    '<small><strong>Fecha de Inicio:</strong> ' + row.fecha_inicio +' | <strong>Fecha de Finalización: </strong>' + row.fecha_vencimiento +'</small>'+
                                                '</a>'
                                );

                            //console.log(row.id)
                        }
                        $("#modal_detalle_tareas_personas").modal('show');
                    }
                    // $(function () {
                    //     new PNotify({
                    //         title: titleMsg,
                    //         text: textMsg,
                    //         type: typeMsg,
                    //         shadow: true,
                    //     });
                    // });
                },
                error: function (xhr, status, error) {
                    alert(xhr.responseText);
                },
            });
        }
  </script>
@endpush