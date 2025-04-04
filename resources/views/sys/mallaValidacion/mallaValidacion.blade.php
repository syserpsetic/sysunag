@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<div class="row chat-wrapper">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row position-relative">
                    <div class="col-lg-4 chat-aside border-end-lg">
                        <div class="aside-content">
                            <div class="aside-body">
                                <ul class="nav nav-tabs nav-fill mt-3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="chats-tab" data-bs-toggle="tab" data-bs-target="#chats" role="tab" aria-controls="chats" aria-selected="true">
                                            <div class="d-flex flex-row flex-lg-column flex-xl-row align-items-center justify-content-center">
                                                <i data-feather="message-square" class="icon-sm me-sm-2 me-lg-0 me-xl-2 mb-md-1 mb-xl-0"></i>
                                                <p class="d-none d-sm-block">NEXUS</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3">
                                    <div class="tab-pane fade show active" id="chats" role="tabpanel" aria-labelledby="chats-tab">
                                        <div>
                                            <p class="text-muted mb-1">Tareas Pendientes</p>
                                            <ul class="list-unstyled chat-list px-1">
                                                @foreach ($personas as $row)
                                                <li class="chat-item pe-1">
                                                    <a href="#" class="d-flex align-items-center">
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
                                                                <p class="text-body fw-bolder">{{ $row['member'] }}</p>
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
                    <div class="col-lg-8 col-sm-12 chat-content">
                        <div class="chat-body">
                            <div class="row">
                                <div class="col-12 col-xl-12 col-sm-12 stretch-card">
                                    <div class="row flex-grow-1">
                                        @foreach($indicadoresMallaValidaciones as $row)
                                        <div class="col-md-3 grid-margin stretch-card">
                                            <div @if($row['estudiantes']!=0) class="card border-danger" @else class="card border-primary" @endif>
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-baseline">
                                                        <h6 class="card-title mb-0">{{$row['indicador_titulo']}}</h6>
                                                        <div class="dropdown mb-2">
                                                            <button class="btn btn-link p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="alert-circle" class="icon-sm me-2"></i> <span class="">Info</span></a>
                                                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="align-justify" class="icon-sm me-2"></i> <span class="">Ir a detalle</span></a>
                                                                @if($row['btn_accion_id'] != null)
                                                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="refresh-ccw" class="icon-sm me-2"></i> <span class="">Refrescar Vista</span></a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 col-md-12 col-xl-12">
                                                            <h2 class="mb-2">{{$row['estudiantes']}}</h2>
                                                            <!-- <div class="d-flex align-items-baseline">
                                                                <p class="text-success">
                                                                    <span>+3.3%</span>
                                                                    <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                                                                </p>
                                                            </div> -->
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


@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script>
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

        // $('.chat-content').toggleClass('show');
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
  </script>
@endpush