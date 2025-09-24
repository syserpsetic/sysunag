@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
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
            background: linear-gradient(90deg, #135423, #000);
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

    .blink {
        animation: blink 1s steps(1) infinite;
    }

    @keyframes blink {
        0%, 50% { opacity: 1; }
        50.01%, 100% { opacity: 0; }
    }
</style>

<div class="row chat-wrapper">
    <div class="col-md-12">
        @if(in_array('malla_validacion_leer_cinta_noticias', $scopes))
        <div class="news-ticker">
            <div class="news-logo">
                <img src="{{asset('assets/images/logo_setic_new.png')}}" alt="Logo">
            </div>
            <div class="news-content">
                <div class="news-container" id="newsContainer">
                    @foreach($noticias as $row)
                    <h2 style="display: flex; align-items: center; gap: 8px;">
                        <div class="news-perfil">
                            <img src="https://portal.unag.edu.hn/matricula/documentos/fotos/{{$row['foto']}}" 
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
                    <div class="col-lg-3 chat-aside border-end-lg">
                        <div class="aside-content">
                            <div class="aside-body">
                                <div id="clock-container" class="text-center p-3 rounded shadow-sm mt-3"
                                        style="background-color: #d3eed7; border: 1px solid #135423; width: 100%; font-size: 2rem; font-family: 'Segoe UI', sans-serif;">
                                    <strong><div id="time" style="color: #135423;"></div></strong>
                                    <div id="date" style="font-size: 1rem; color: #1ba333;"></div>
                                    <div id="weather" style="font-size: 1rem; color: #1ba333;"></div>
                                </div>
                                @if(!empty($cumpleaños))
                                    <div class="text-center p-3 rounded shadow-sm mt-3" style="background-color: #d3eed7; border: 1px solid #135423;">
                                        <img class="rounded mb-2" 
                                            src="{{ url('assets/images/') }}/{{$cumpleaños['numero_empleado']}}.jpg" 
                                            alt="Cumpleaños" 
                                            style="width: 100%; max-width: 400px; height: auto; object-fit: cover;"
                                            onerror="this.onerror=null; this.src='{{ url(asset('/assets/images/user2-403d6e88.png')) }}';">

                                        <div>
                                            <small class="d-block mb-1" style="color: #135423;">
                                                🎉 ¡FELIZ CUMPLEAÑOS, <strong>{{$cumpleaños['nombre_completo']}}</strong>! 🎂
                                            </small>
                                            <p class="tx-11 mb-0" style="color: #1ba333;">{{$cumpleaños['mensaje']}} 🎈🎁</p>
                                        </div>
                                    </div>
                                @endif
                                @if(date('m-d') == '07-17')
                                    <div class="text-center p-3 rounded shadow-sm mt-3" style="background-color: #f1f1f1; border: 1px solid #ccc;">
                                        <img class="rounded mb-2" 
                                            src="{{ url('assets/images/FOTO_AMIGOS.png') }}" 
                                            alt="Amigos" 
                                            style="width: 100%; max-width: 400px; height: auto; object-fit: cover;"
                                            onerror="this.onerror=null; this.src='{{ url(asset('/assets/images/user2-403d6e88.png')) }}';">

                                        <div>
                                            <small class="d-block mb-1 text-dark">
                                                🕊️ En memoria de <strong>Marvin, Carlos y Robin</strong>
                                            </small>
                                            <p class="tx-11 text-muted mb-0">Siempre los recordaremos con cariño. 🖤</p>
                                        </div>
                                    </div>
                                @endif
                                                            

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
                                                                src="https://portal.unag.edu.hn/matricula/documentos/fotos/{{$row['foto']}}"
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
                        <div class="col-lg-9 col-sm-12 chat-content"  style="display: block;">
                    @else 
                        <div class="col-lg-12 col-sm-12 chat-content"  style="display: block;">
                    @endif
                        <div class="row">
                            <div class="col-3">
                                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#modal_vistas_materializadas">
                                    <p class="lead"><strong> <i data-feather="users" class="me-2"></i>{{ $porcentaje_matricula['obtenido'] }} {{--({{ $porcentaje_matricula['porcentaje_matricula'] }})--}} <small>Estudiantes</small> <i id="indicador_matricula"></i></strong></p>                         
                                    <cite title="Source Title">{{ $porcentaje_matricula['datos'] }}</cite>
                                </a>
                            </div>
                            <div class="col-6 text-center">
                                <p class="lead"><strong>{{ $periodo_actual['periodo'] }}</strong></p>
                                    <cite title="Source Title">Malla de Validación</cite>
                            </div>
                            <div class="col-3 text-end">
                                @if(in_array('malla_validacion_leer_carga_academica', $scopes))
                                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#modal_bloques">
                                    <p class="lead"><strong><i id="indicador_carga_academica"></i>{{ $porcentje_carga_academica['porcentaje_asignaturas_carga_academica'] }} <i data-feather="book" class="me-2"></i></strong></p>                         
                                    <cite title="Source Title">Carga Académica</cite>
                                </a>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                @if(in_array('malla_validacion_leer_recaudación', $scopes))
                                <strong>Recaudación {{$recaudacion['anio']}}: </strong> {{$recaudacion['money']}}
                                @endif
                            </div>
                            <div class="col-4">
                                <center>
                                    <span class="badge bg-primary">{{$totalPrimary}}</span> |
                                    <span class="badge bg-warning">{{$totalWarning}}</span> |
                                    <span class="badge bg-danger text-white">{{$totalDanger}}</span> |
                                    <span class="badge bg-light text-dark">{{$totalIndicadores}}</span>
                                </center>
                            </div> 
                            <div class="col-4">

                            </div>
                        </div>
                        <hr>
                        <div class="chat-body">
                            <div class="row">
                                <div class="col-12 col-xl-12 col-sm-12 stretch-card">
                                    <div class="row flex-grow-1">
                                        @foreach($indicadoresMallaValidaciones as $row)
                                        <div class="col-md-3 grid-margin stretch-card">
                                            <div @if($row['estudiantes']!=0 and $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_secciones_sobrepobladas' and $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_login_estudiantes' and $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_parametrizacion_secciones_limite_estudiantes' and $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_estudiantes_sin_matricula' and $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_cobros_incorrectos') class="card border-danger" 
                                                @elseif($row['estudiantes']!=0 and ($row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_secciones_sobrepobladas' || $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_login_estudiantes' || $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_parametrizacion_secciones_limite_estudiantes' || $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_estudiantes_sin_matricula' || $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_cobros_incorrectos')) class="card border-warning" 
                                                @else class="card border-primary" 
                                                @endif>
                                                <div @if($row['estudiantes']!=0 and $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_secciones_sobrepobladas' and $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_login_estudiantes' and $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_parametrizacion_secciones_limite_estudiantes' and $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_estudiantes_sin_matricula' and $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_cobros_incorrectos') class="card-header bg-danger" 
                                                @elseif($row['estudiantes']!=0 and ($row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_secciones_sobrepobladas' || $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_login_estudiantes' || $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_parametrizacion_secciones_limite_estudiantes' || $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_estudiantes_sin_matricula' || $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_cobros_incorrectos')) class="card-header bg-warning" 
                                                @else class="card-header bg-primary" 
                                                @endif>
                                                    <div class="d-flex justify-content-between align-items-baseline">
                                                        <h6 class="mb-0">
                                                            @if($row['estudiantes']!=0 and $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_secciones_sobrepobladas' and $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_login_estudiantes' and $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_parametrizacion_secciones_limite_estudiantes' and $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_estudiantes_sin_matricula' and $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_cobros_incorrectos')
                                                                <strong class="text-white"><i data-feather="alert-octagon" class="me-2"></i> {{$row['indicador_titulo']}}</strong>
                                                            @elseif($row['estudiantes']!=0 and ($row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_secciones_sobrepobladas' || $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_login_estudiantes' || $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_parametrizacion_secciones_limite_estudiantes' || $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_estudiantes_sin_matricula' || $row['btn_detalle_ruta'] != 'setic/malla_validacion/malla_cobros_incorrectos'))
                                                                <i data-feather="alert-triangle" class="me-2"></i>
                                                                <strong>{{$row['indicador_titulo']}}</strong>
                                                            @else
                                                                <strong class="text-white"><i data-feather="check-circle" class="me-2"></i> {{$row['indicador_titulo']}}</strong>
                                                            @endif
                                                        </h6>
                                                        <div class="dropdown mb-2">
                                                            <button class="btn btn-link p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            @if($row['estudiantes']!=0 and ($row['btn_detalle_ruta'] == 'setic/malla_validacion/malla_secciones_sobrepobladas' || $row['btn_detalle_ruta'] == 'setic/malla_validacion/malla_login_estudiantes' || $row['btn_detalle_ruta'] == 'setic/malla_validacion/malla_parametrizacion_secciones_limite_estudiantes' || $row['btn_detalle_ruta'] == 'setic/malla_validacion/malla_estudiantes_sin_matricula' || $row['btn_detalle_ruta'] == 'setic/malla_validacion/malla_cobros_incorrectos'))    
                                                                <i class="icon-lg pb-3px" data-feather="align-justify"></i>
                                                            @else
                                                                <i class="icon-lg pb-3px text-white" data-feather="align-justify"></i>
                                                            @endif
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <button class="dropdown-item d-flex align-items-center"
                                                                    data-bs-toggle="modal" data-bs-target="#modal_informacion"
                                                                    data-indicador_titulo_icono="{{$row['indicador_titulo_icono']}}"
                                                                    data-indicador_titulo="{{$row['indicador_titulo']}}"
                                                                    data-indicador_subtitulo="{{$row['indicador_subtitulo']}}"
                                                                    data-indicador_descripcion="{{$row['indicador_descripcion']}}">
                                                                    <i data-feather="alert-circle" class="icon-sm me-2"></i> <span class="">Info</span>
                                                                </button>
                                                                <a class="dropdown-item d-flex align-items-center" href="{{url($row['btn_detalle_ruta'])}}"><i data-feather="align-justify" class="icon-sm me-2"></i> <span class="">Ir a detalle</span></a>
                                                                @if($row['btn_accion_id'] != null)
                                                                    <button class="dropdown-item d-flex align-items-center {{$row['btn_accion_id']}}" type="button"><i data-feather="refresh-ccw" class="icon-sm me-2"></i> <span class="">{{$row['btn_accion_descripcion']}}</span></button>
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

      <!-- Small modal -->
        <div class="modal fade bd-example-modal-sm" id="modal_informacion" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h6 class="modal-title h6 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="alert-circle"></i> Información</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                    </div>
                    <div class="card-body">
                        <center>
                            <h2 class="brief" style="margin: 0;">
                                <strong id="indicador_titulo"><i class=""></i> </strong>
                            </h2>
                            <br />
                            <h4 class=""><strong id="indicador_subtitulo"></strong></h4>
                            <br />
                            <p class="text-justify" id="indicador_descripcion"></p>
                        </center>
                    </div>
                    <div class="modal-footer bg-secondary">
                        <button type="button" class="btn btn-primary btn-xs" data-bs-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example-modal-sm" id="modal_vistas_materializadas" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h6 class="modal-title h6 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="refresh-cw"></i> Actualizar Vistas Materializadas</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action btn_actualizar_vista_materializada_clases_matriculadas">VM CLASES MATRICULADAS</a>
                            <a href="#" class="list-group-item list-group-item-action btn_actualizar_vista_materializada_pago_minimo_alto_estudiantes">VM PAGO MÍNIMO ALTO ESTUDIANTES</a>
                        </div>
                    </div>
                    <div class="modal-footer bg-secondary">
                        <button type="button" class="btn btn-primary btn-xs" data-bs-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade bd-example" id="modal_bloques" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h6 class="modal-title h6 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="book"></i>Estados Bloques</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" role="tab" aria-controls="home" aria-selected="true">
                                            <strong><i class="icon-lg pb-3px" data-feather="check-circle"></i> Aprobados</strong> <span class="badge bg-primary"> {{$estados_bloques['aprobado']}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" role="tab" aria-controls="profile" aria-selected="false">
                                            <strong><i class="icon-lg pb-3px" data-feather="refresh-ccw"></i> Proceso</strong> <span class="badge bg-primary"> {{$estados_bloques['proceso']}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" role="tab" aria-controls="contact" aria-selected="false">
                                            <strong><i class="icon-lg pb-3px" data-feather="eye"></i> Revisión</strong> <span class="badge bg-primary"> {{$estados_bloques['revision']}}</span>
                                        </a> 
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled" role="tab" aria-controls="disabled" aria-selected="false">
                                            <strong><i class="icon-lg pb-3px" data-feather="x-circle"></i> Rechazados</strong> <span class="badge bg-primary"> {{$estados_bloques['rechazado']}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link disabled" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled" role="tab" aria-controls="disabled" aria-selected="false">
                                            <strong>{{ $porcentje_carga_academica['porcentaje_asignaturas_carga_academica'] }} <i data-feather="book" class="me-2"></i></strong>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content border border-top-0 p-3" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="col-12 col-md-12 col-xl-12">
                                            <div class="card border-secondary">
                                                <h5 class="card-header bg-azul text-white"><i class="text-white icon-lg pb-3px" data-feather="check-circle"></i> Bloques Aprobados</h5>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="jambo_table table table-hover" id="tbl_bloques_aprobados" border="1">
                                                            <thead  class="bg-primary">
                                                                <tr class="headings">
                                                                    <th scope="col" class="text-white">ID</th>
                                                                    <th scope="col" class="text-white">Id Carrera</th>
                                                                    <th scope="col" class="text-white">Detalle</th>
                                                                    <th scope="col" class="text-white">Creación</th>
                                                                    <th scope="col" class="text-white">Sede</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($bloques as $row)
                                                                    @if($row['id_estado_asignaturas'] === 3)
                                                                    <tr style="font-size: small;">
                                                                        <td scope="row">{{$row['id']}}</td>
                                                                        <td scope="row">{{$row['id_carrera']}}</td>
                                                                        <td scope="row"> 
                                                                            <strong>PA:</strong> {{$row['periodo_academico']}} | 
                                                                            <strong>ES:</strong> {{$row['etiqueta_bloque']}} | 
                                                                            <strong>JM:</strong> {{$row['id_jornada_modular']}}
                                                                        </td>
                                                                        <td scope="row">{{$row['fecha_creacion']}}</td>
                                                                        <td scope="row">{{$row['sede']}}</td>
                                                                    </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="col-12 col-md-12 col-xl-12">
                                            <div class="card border-secondary">
                                                <h5 class="card-header bg-azul text-white"><i class="text-white icon-lg pb-3px" data-feather="refresh-ccw"></i> Bloques En Proceso</h5>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="jambo_table table table-hover" id="tbl_bloques_proceso" border="1">
                                                            <thead  class="bg-primary">
                                                                <tr class="headings">
                                                                    <th scope="col" class="text-white">ID</th>
                                                                    <th scope="col" class="text-white">Id Carrera</th>
                                                                    <th scope="col" class="text-white">Detalle</th>
                                                                    <th scope="col" class="text-white">Creación</th>
                                                                    <th scope="col" class="text-white">Sede</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($bloques as $row)
                                                                    @if($row['id_estado_asignaturas'] === 1)
                                                                    <tr style="font-size: small;">
                                                                        <td scope="row">{{$row['id']}}</td>
                                                                        <td scope="row">{{$row['id_carrera']}}</td>
                                                                        <td scope="row"> 
                                                                            <strong>PA:</strong> {{$row['periodo_academico']}} | 
                                                                            <strong>ES:</strong> {{$row['etiqueta_bloque']}} | 
                                                                            <strong>JM:</strong> {{$row['id_jornada_modular']}}
                                                                        </td>
                                                                        <td scope="row">{{$row['fecha_creacion']}}</td>
                                                                        <td scope="row">{{$row['sede']}}</td>
                                                                    </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                        <div class="col-12 col-md-12 col-xl-12">
                                            <div class="card border-secondary">
                                                <h5 class="card-header bg-azul text-white"><i class="text-white icon-lg pb-3px" data-feather="eye"></i> Bloques En Revisión</h5>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="jambo_table table table-hover" id="tbl_bloques_revision" border="1">
                                                            <thead  class="bg-primary">
                                                                <tr class="headings">
                                                                    <th scope="col" class="text-white">ID</th>
                                                                    <th scope="col" class="text-white">Id Carrera</th>
                                                                    <th scope="col" class="text-white">Detalle</th>
                                                                    <th scope="col" class="text-white">Creación</th>
                                                                    <th scope="col" class="text-white">Sede</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($bloques as $row)
                                                                    @if($row['id_estado_asignaturas'] === 2)
                                                                    <tr style="font-size: small;">
                                                                        <td scope="row">{{$row['id']}}</td>
                                                                        <td scope="row">{{$row['id_carrera']}}</td>
                                                                        <td scope="row"> 
                                                                            <strong>PA:</strong> {{$row['periodo_academico']}} | 
                                                                            <strong>ES:</strong> {{$row['etiqueta_bloque']}} | 
                                                                            <strong>JM:</strong> {{$row['id_jornada_modular']}}
                                                                        </td>
                                                                        <td scope="row">{{$row['fecha_creacion']}}</td>
                                                                        <td scope="row">{{$row['sede']}}</td>
                                                                    </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="disabled" role="tabpanel" aria-labelledby="disabled-tab">
                                        <div class="col-12 col-md-12 col-xl-12">
                                            <div class="card border-secondary">
                                                <h5 class="card-header bg-azul text-white"><i class="text-white icon-lg pb-3px" data-feather="x-circle"></i> Bloques Rechazados</h5>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="jambo_table table table-hover" id="tbl_bloques_rechazado" border="1">
                                                            <thead  class="bg-primary">
                                                                <tr class="headings">
                                                                    <th scope="col" class="text-white">ID</th>
                                                                    <th scope="col" class="text-white">Id Carrera</th>
                                                                    <th scope="col" class="text-white">Detalle</th>
                                                                    <th scope="col" class="text-white">Creación</th>
                                                                    <th scope="col" class="text-white">Sede</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($bloques as $row)
                                                                    @if($row['id_estado_asignaturas'] === 4)
                                                                    <tr style="font-size: small;">
                                                                        <td scope="row">{{$row['id']}}</td>
                                                                        <td scope="row">{{$row['id_carrera']}}</td>
                                                                        <td scope="row"> 
                                                                            <strong>PA:</strong> {{$row['periodo_academico']}} | 
                                                                            <strong>ES:</strong> {{$row['etiqueta_bloque']}} | 
                                                                            <strong>JM:</strong> {{$row['id_jornada_modular']}}
                                                                        </td>
                                                                        <td scope="row">{{$row['fecha_creacion']}}</td>
                                                                        <td scope="row">{{$row['sede']}}</td>
                                                                    </tr>
                                                                    @endif
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
                    </div>
                    <div class="modal-footer bg-secondary">
                        <button type="button" class="btn btn-primary btn-xs" data-bs-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=mzutkZDE"></script>
  <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
  <script type="text/javascript">
    var btn_actualizar_vista_materializada_pago_minimo_alto_estudiantes = true;
    var btn_actualizar_vista_materializada_clases_matriculadas = true;
    var html = null;
    var table = null; 
    var table2 = null; 
    var table3 = null; 
    var table4 = null; 
    var url_setic_malla_validacion_tareas_pendientes_personas = "{{url('setic/malla_validacion/tareas_pendientes_personas')}}"; 
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const datosGuardados = JSON.parse(localStorage.getItem('validaciones') || '[]');
        const cargaAcademica = datosGuardados.find(item => item.indicador === 'Carga Academica')
        const Matricula = datosGuardados.find(item => item.indicador === 'Matricula')

        if(cargaAcademica && Matricula){

            var clase_indicador_carga_academica = null;
            var clase_indicador_matricula = null;
            var polyline_indicador_carga_academica = null;
            var polyline_indicador_matricula = null;

            if({{ $porcentje_carga_academica['porcentaje_asignaturas_carga_academica_entero'] }} > parseInt(cargaAcademica.total)){
                console.log('Subiendo')
                clase_indicador_carga_academica = 'feather feather-chevrons-up icon me-2 text-success';
                polyline_indicador_carga_academica = '<polyline points="17 11 12 6 7 11"></polyline><polyline points="17 18 12 13 7 18"></polyline>';
            }else if({{ $porcentje_carga_academica['porcentaje_asignaturas_carga_academica_entero'] }} < parseInt(cargaAcademica.total)){
                console.log('Bajando')
                clase_indicador_carga_academica = 'feather feather-chevrons-down icon me-2 text-danger';
                polyline_indicador_carga_academica = '<polyline points="7 13 12 18 17 13"></polyline><polyline points="7 6 12 11 17 6"></polyline>';
            }
            $("#indicador_carga_academica").html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'+clase_indicador_carga_academica+'">'+polyline_indicador_carga_academica+'</svg>');

            if({{ $porcentaje_matricula['obtenido'] }} > parseInt(Matricula.total)){
                console.log('Subiendo')
                clase_indicador_matricula = 'feather feather-chevrons-up icon me-2 text-success';
                polyline_indicador_matricula = '<polyline points="17 11 12 6 7 11"></polyline><polyline points="17 18 12 13 7 18"></polyline>';
            }else if({{ $porcentaje_matricula['obtenido'] }} < parseInt(Matricula.total)){
                console.log('Bajando')
                clase_indicador_matricula = 'feather feather-chevrons-down icon me-2 text-danger';
                polyline_indicador_matricula = '<polyline points="7 13 12 18 17 13"></polyline><polyline points="7 6 12 11 17 6"></polyline>';
            }
            $("#indicador_matricula").html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="'+clase_indicador_matricula+'">'+polyline_indicador_matricula+'</svg>');
        }

            const indicadores = [
                { indicador: 'Matricula', total: "{{ $porcentaje_matricula['obtenido'] }}" },
                { indicador: 'Carga Academica', total: "{{ $porcentje_carga_academica['porcentaje_asignaturas_carga_academica_entero'] }}" }
            ];

            localStorage.setItem('validaciones', JSON.stringify(indicadores));
        

        table = $('#tbl_bloques_aprobados').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, 100,-1],
                    [10, 30, 50, 100,"Todo"]
                ],
                "iDisplayLength": 10,
                language: {
                    processing:     "Procesando...",
                    search:         "Buscar:",
                    lengthMenu:     "Mostrar _MENU_ registros",
                    info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    infoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    infoFiltered:   "(filtrado de un total de _MAX_ registros)",
                    infoPostFix:    "",
                    loadingRecords: "Cargando...",
                    zeroRecords:    "No se encontraron resultados",
                    emptyTable:     "Ningún dato disponible en esta tabla",
                    paginate: {
                        first:      "Primero",
                        previous:   "Anterior",
                        next:       "Siguiente",
                        last:       "Último"
                    },
                    aria: {
                        sortAscending:  ": Activar para ordenar la columna de manera ascendente",
                        sortDescending: ": Activar para ordenar la columna de manera descendente"
                    }
                }
                });
            $('#tbl_bloques_aprobados').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Buscar');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
                });

            table2 = $('#tbl_bloques_proceso').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, 100,-1],
                    [10, 30, 50, 100,"Todo"]
                ],
                "iDisplayLength": 10,
                language: {
                    processing:     "Procesando...",
                    search:         "Buscar:",
                    lengthMenu:     "Mostrar _MENU_ registros",
                    info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    infoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    infoFiltered:   "(filtrado de un total de _MAX_ registros)",
                    infoPostFix:    "",
                    loadingRecords: "Cargando...",
                    zeroRecords:    "No se encontraron resultados",
                    emptyTable:     "Ningún dato disponible en esta tabla",
                    paginate: {
                        first:      "Primero",
                        previous:   "Anterior",
                        next:       "Siguiente",
                        last:       "Último"
                    },
                    aria: {
                        sortAscending:  ": Activar para ordenar la columna de manera ascendente",
                        sortDescending: ": Activar para ordenar la columna de manera descendente"
                    }
                }
                });
            $('#tbl_bloques_proceso').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Buscar');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
                });


            table3 = $('#tbl_bloques_revision').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, 100,-1],
                    [10, 30, 50, 100,"Todo"]
                ],
                "iDisplayLength": 10,
                language: {
                    processing:     "Procesando...",
                    search:         "Buscar:",
                    lengthMenu:     "Mostrar _MENU_ registros",
                    info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    infoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    infoFiltered:   "(filtrado de un total de _MAX_ registros)",
                    infoPostFix:    "",
                    loadingRecords: "Cargando...",
                    zeroRecords:    "No se encontraron resultados",
                    emptyTable:     "Ningún dato disponible en esta tabla",
                    paginate: {
                        first:      "Primero",
                        previous:   "Anterior",
                        next:       "Siguiente",
                        last:       "Último"
                    },
                    aria: {
                        sortAscending:  ": Activar para ordenar la columna de manera ascendente",
                        sortDescending: ": Activar para ordenar la columna de manera descendente"
                    }
                }
                });
            $('#tbl_bloques_revision').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Buscar');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
                });

        table4 = $('#tbl_bloques_rechazado').DataTable({
                "aLengthMenu": [
                    [10, 30, 50, 100,-1],
                    [10, 30, 50, 100,"Todo"]
                ],
                "iDisplayLength": 10,
                language: {
                    processing:     "Procesando...",
                    search:         "Buscar:",
                    lengthMenu:     "Mostrar _MENU_ registros",
                    info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    infoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    infoFiltered:   "(filtrado de un total de _MAX_ registros)",
                    infoPostFix:    "",
                    loadingRecords: "Cargando...",
                    zeroRecords:    "No se encontraron resultados",
                    emptyTable:     "Ningún dato disponible en esta tabla",
                    paginate: {
                        first:      "Primero",
                        previous:   "Anterior",
                        next:       "Siguiente",
                        last:       "Último"
                    },
                    aria: {
                        sortAscending:  ": Activar para ordenar la columna de manera ascendente",
                        sortDescending: ": Activar para ordenar la columna de manera descendente"
                    }
                }
                });
            $('#tbl_bloques_rechazado').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Buscar');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
                });

        //$('.sidebar-toggler not-active').trigger("click");

        @if(in_array('malla_validacion_reproducir_narrador', $scopes) && ($narracion['narracion'] != null || $narracion['narracion'] != ''))
            var mensaje = '{{$narracion["narracion"]}}';
            console.log(mensaje);
            responsiveVoice.speak(mensaje, "Spanish Latin American Female", {
                rate: 1.2,   // Aumenta la velocidad al 180%
                pitch: 1,  // Un poco más agudo
                volume: 1    // Máximo volumen
            });
        @endif

        @if(!empty($cumpleaños))
            @if(in_array('malla_validacion_reproducir_narrador', $scopes) && !empty($cumpleaños['mensaje']))
              
                    (function() {
                        const mensaje = @json($cumpleaños['mensaje']);
                        const ahora = new Date();
                        const horaActual = ahora.getHours();
                        const diaHoy = ahora.toISOString().slice(0, 10); // yyyy-mm-dd

                        // Horas permitidas para ejecutar el mensaje
                        const horasPermitidas = [10, 15]; // 10 AM y 3 PM

                        // Solo ejecutar si estamos en una hora permitida
                        if (horasPermitidas.includes(horaActual)) {
                            const claveStorage = 'narracion_' + diaHoy + '_' + horaActual;

                            // Solo si NO se ha ejecutado ya esta hora hoy
                            if (!localStorage.getItem(claveStorage)) {
                                responsiveVoice.speak(mensaje, "Spanish Latin American Female", {
                                    rate: 1.2,
                                    pitch: 1,
                                    volume: 1
                                });

                                // Guardar que ya se ejecutó en esta hora hoy
                                localStorage.setItem(claveStorage, '1');
                            }
                        }
                    })();
            @endif
        @endif

        /*(function () {
            const claveStorage = 'voz_1630_' + new Date().toISOString().slice(0, 10); // Solo una vez por día

            // Evitar repetir la reproducción
            if (localStorage.getItem(claveStorage)) return;

            // Verificar la hora cada 30 segundos
            const intervalo = setInterval(() => {
                const ahora = new Date();
                const hora = ahora.getHours();
                const minutos = ahora.getMinutes();

                // Condición: 4:30 PM o después
                if ((hora > 16 || (hora === 16 && minutos >= 30)) && !localStorage.getItem(claveStorage)) {
                    const mensaje = "El horario laboral ha finalizado. Gracias por su esfuerzo del día. Puede retirarse a su casa y descansar. ¡Hasta mañana!";

                    responsiveVoice.speak(mensaje, "Spanish Latin American Female", {
                        rate: 1.1,
                        pitch: 1,
                        volume: 1
                    });

                    localStorage.setItem(claveStorage, '1');
                    clearInterval(intervalo); // Detener verificación después de reproducir
                }
            }, 10000); // Verifica cada 10 segundos
        })();*/

        // (function () {
        //     const claveStorage = 'llamado_' + new Date().toISOString().slice(0, 10); // Solo una vez por día

        //     // Evitar repetir la reproducción
        //     if (localStorage.getItem(claveStorage)) return;

        //     // Verificar la hora cada 30 segundos
        //     const intervalo = setInterval(() => {
        //         const ahora = new Date();
        //         const hora = ahora.getHours();
        //         const minutos = ahora.getMinutes();

        //         // Condición: 4:30 PM o después
        //         if ((hora > 13 || (hora === 13 && minutos >= 00)) && !localStorage.getItem(claveStorage)) {
        //             const mensaje = "Se hace un llamado a todos los compañeros y practicantes: el tiempo de descanso ha concluido. Por favor, retomemos nuestras labores con el mismo compromiso y responsabilidad. ¡Gracias!";

        //             responsiveVoice.speak(mensaje, "Spanish Latin American Female", {
        //                 rate: 1.1,
        //                 pitch: 1,
        //                 volume: 1
        //             });

        //             localStorage.setItem(claveStorage, '1');
        //             clearInterval(intervalo); // Detener verificación después de reproducir
        //         }
        //     }, 30000); // Verifica cada 30 segundos
        // })();
        @if(in_array('malla_validacion_leer_lista_pendientes', $scopes))
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
        @endif

        setTimeout(function () {
            location.reload();
        }, 900000);

        $("#modal_informacion").on("show.bs.modal", function (e) { 
                                     var triggerLink = $(e.relatedTarget); 
                                     var indicador_titulo_icono=triggerLink.data("indicador_titulo_icono");
                                     var indicador_titulo=triggerLink.data("indicador_titulo");
                                     var indicador_subtitulo=triggerLink.data("indicador_subtitulo");
                                     var indicador_descripcion=triggerLink.data("indicador_descripcion");
                                    $("#indicador_titulo").html('<i class="'+indicador_titulo_icono+'"></i> '+indicador_titulo+'');
                                    $("#indicador_subtitulo").html(indicador_subtitulo);
                                    $("#indicador_descripcion").html(indicador_descripcion);
                                     }); 

    $(".btn_actualizar_vista_materializada_pago_minimo_alto_estudiantes").on("click", function () {
        if(btn_actualizar_vista_materializada_pago_minimo_alto_estudiantes){
            btn_actualizar_vista_materializada_pago_minimo_alto_estudiantes = false;
            $("#btn_actualizar_vista_materializada_pago_minimo_alto_estudiantes").html('Espere...');
            html = 'REFRESCANDO VM PAGO MÍNIMO ALTO ESTUDIANTES...';
            espera(html)
            window.location.href =  "{{url('setic/malla_validacion/pago_minimo_estudiantes/refrescar_vista_materializada_pago_minimo_alto_estudiantes')}}";
        }
    });

    $(".btn_actualizar_vista_materializada_clases_matriculadas").on("click", function () {
        if(btn_actualizar_vista_materializada_clases_matriculadas){
            btn_actualizar_vista_materializada_clases_matriculadas = false;
            html = 'REFRESCANDO VM CLASES MATRICULADAS...';
            espera(html)
            window.location.href =  "{{url('setic/malla_validacion/pago_minimo_estudiantes/refrescar_vista_materializada_clases_matriculadas')}}";
        }
    });

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

        //$('.loaded').addClass('loaded sidebar-folded');
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
                                    '<img width="120" height="120" class="rounded-circle" src="https://portal.unag.edu.hn/matricula/documentos/fotos/' + row.foto + '" alt="profile" onerror="this.onerror=null; this.src=\'{{ url(asset('/assets/images/user2-403d6e88.png')) }}\';">'+
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

    //Inicia reloj y clima
    @if(in_array('malla_validacion_leer_lista_pendientes', $scopes))
    function actualizarHora() {
        const ahora = new Date();
        let horas = ahora.getHours();
        const minutos = ahora.getMinutes().toString().padStart(2, '0');
        const ampm = horas >= 12 ? 'PM' : 'AM';
        horas = horas % 12 || 12;
        const segundos = ahora.getSeconds();
        const parpadeo = segundos % 2 === 0 ? ':' : ' ';
        document.getElementById('time').innerHTML = `<strong>${horas}${parpadeo}${minutos} ${ampm}</strong>`;
    }

    function actualizarFecha() {
        const dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
        const meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        const hoy = new Date();
        const textoFecha = `${dias[hoy.getDay()]}, ${hoy.getDate()} de ${meses[hoy.getMonth()]} de ${hoy.getFullYear()}`;
        document.getElementById('date').textContent = textoFecha;
    }

    async function obtenerClimaPorUbicacion() {
        if (!navigator.geolocation) {
            document.getElementById("weather").textContent = "Geolocalización no soportada.";
            return;
        }

        navigator.geolocation.getCurrentPosition(async (position) => {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            try {
                const response = await fetch(`https://wttr.in/${lat},${lon}?format=j1`);
                const data = await response.json();
                const weatherDescEn = data.current_condition[0].weatherDesc[0].value;
                const temp = data.current_condition[0].temp_C;

                const traducciones = {
                    "Sunny": "Soleado",
                    "Clear": "Despejado",
                    "Partly cloudy": "Parcialmente nublado",
                    "Cloudy": "Nublado",
                    "Overcast": "Cubierto",
                    "Mist": "Niebla",
                    "Patchy rain possible": "Posible lluvia intermitente",
                    "Light rain": "Lluvia ligera",
                    "Heavy rain": "Lluvia fuerte",
                    "Moderate rain": "Lluvia moderada",
                    "Thunderstorm": "Tormenta eléctrica",
                    "Snow": "Nieve",
                    "Fog": "Niebla"
                };

                const iconos = {
                    "Soleado": "☀️",
                    "Despejado": "🌕",
                    "Parcialmente nublado": "⛅",
                    "Nublado": "☁️",
                    "Cubierto": "☁️",
                    "Niebla": "🌫️",
                    "Posible lluvia intermitente": "🌦️",
                    "Lluvia ligera": "🌧️",
                    "Lluvia moderada": "🌧️",
                    "Lluvia fuerte": "🌧️",
                    "Tormenta eléctrica": "⛈️",
                    "Nieve": "❄️"
                };

                const weatherDescEs = traducciones[weatherDescEn] || weatherDescEn;
                const icono = iconos[weatherDescEs] || "🌡️";

                document.getElementById("weather").textContent = `${icono} ${weatherDescEs} - ${temp}°C`;
            } catch (error) {
                document.getElementById("weather").textContent = "No se pudo cargar el clima.";
                console.error(error);
            }
        }, (error) => {
            document.getElementById("weather").textContent = "Permiso de ubicación denegado.";
        });
    }
   
        actualizarHora();
        actualizarFecha();
        obtenerClimaPorUbicacion();
        setInterval(actualizarHora, 1000);
        setInterval(obtenerClimaPorUbicacion, 1800000); // cada 30 minutos
        //Finanila reloj y clima
    @endif
        function espera(html){
        Swal.fire({
            imageUrl: "{{ url(asset('/assets/images/unag_loading.gif')) }}",
            // icon: 'warning',
            title: '¡Espera!',
            html: html,
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: true, // puedes cambiar esto si no quieres el botón
            didOpen: () => {
                Swal.showLoading(); // opcional: si quieres mostrar el loader
            }
        });

    }
  </script>
@endpush