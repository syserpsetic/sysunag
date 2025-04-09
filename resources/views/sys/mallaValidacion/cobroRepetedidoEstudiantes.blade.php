@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <h1 class="display-1 d-flex align-items-center">
                    <i data-feather="dollar-sign" class="me-3" style="width: 90px; height: 90px;"></i>
                    <strong>COBROS</strong>
                </h1>
                <h4 class="lead">Estudiantes con cobros repetidos.</h4>
                <br>
                <div class="col-md-3">
                        <a class="btn btn-info btn-sm" id="btn_volver_convenio" href="{{url('setic/malla_validacion')}}" data-toggle="tooltip" data-placement="top" title="Regresar a Malla de Validaciones">
                        <i class="btn-icon-prepend" data-feather="corner-up-left"></i> Regresar
                        </a>
                    </div>
                <hr />
                <div class="col-12 col-md-12 col-xl-12">
                    <div class="card border-secondary">
                        <h5 class="card-header bg-azul text-white"><i class="text-white icon-lg pb-3px" data-feather="users"></i> Estudiantes</h5>
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

@endsection