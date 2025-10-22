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
.file-attachment {
  position: relative;
  display: inline-block;
  cursor: pointer;
}

.file-attachment img {
  width: 200px;
  border-radius: 6px;
  transition: opacity 0.3s ease;
}

.download-btn {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: rgba(0, 123, 255, 0.9);
  color: #fff;
  padding: 8px 12px;
  border-radius: 6px;
  font-size: 14px;
  text-decoration: none;
  display: none; /* oculto por defecto */
}

.file-attachment:hover img {
  opacity: 0.6;
}

.file-attachment:hover .download-btn {
  display: block; /* aparece solo al pasar el mouse */
}

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
@foreach($detalle_solicitud as $row) @if($loop->first)
<div class="d-flex align-items-center justify-content-between p-3 border-bottom tx-16">
    <div class="d-flex align-items-center">
        <!--<i data-feather="star" class="text-primary icon-lg me-2"></i>-->
        <span>{{$row['departamento_remitente']}} | GS-{{$row['id_solicitud']}}</span>
    </div>
    <div>
        <!-- <span>Remisiones</span> -->
         @if($remitir)
          <a class="me-2" type="button" data-bs-toggle="modal" data-bs-target="#modal_remision"><i data-feather="share" class="text-muted icon-lg"></i></a>
          @endif
        <!--  <div class="actions dropdown">
                    <a href="#" data-bs-toggle="dropdown"><i data-feather="share" class="icon-lg text-muted"></i></a>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal_remision">Remisión Interna</a>
                      <a class="dropdown-item" href="#">Remisión Externa</a>
                      <a class="dropdown-item" href="#">Spam</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item text-danger" href="#">Delete</a> 
                    </div>
                  </div>-->
        <!-- <a class="me-2" type="button" data-bs-toggle="tooltip" data-bs-title="Print"><i data-feather="printer" class="text-muted icon-lg"></i></a>
                <a type="button" data-bs-toggle="tooltip" data-bs-title="Delete"><i data-feather="trash" class="text-muted icon-lg"></i></a> -->
        <!-- <button type="button" class="btn btn-success btn-xs">Externa</button>
        <button type="button" class="btn btn-info btn-xs">Interna</button> -->
    </div>
</div>
<div class="d-flex align-items-center justify-content-between flex-wrap px-3 py-2 border-bottom">
    <div class="d-flex align-items-center">
        <div class="me-2">
            <img src="https://portal.unag.edu.hn/matricula/documentos/fotos/{{$row['foto']}}" alt="Avatar" class="rounded-circle img-xs" onerror="this.onerror=null; this.src='{{ url(asset('/assets/images/user2-403d6e88.png')) }}';" />
        </div>
        <div class="d-flex align-items-center">
            <a href="#" class="text-body">{{$row['name_remitente']}}</a>
            <span class="mx-2 text-muted">para</span>
            <a href="#" class="text-body me-2">{{$row['departamento_destinatario']}}<small class="mx-2 text-muted">{{$row['name_destinatario']}}</small></a>
            <!-- <div class="actions dropdown">
                    <a href="#" data-bs-toggle="dropdown"><i data-feather="chevron-down" class="icon-lg text-muted"></i></a>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item" href="#">Mark as read</a>
                      <a class="dropdown-item" href="#">Mark as unread</a>
                      <a class="dropdown-item" href="#">Spam</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item text-danger" href="#">Delete</a>
                    </div>
                  </div> -->
        </div>
    </div>
    <div class="tx-13 text-muted mt-2 mt-sm-0">{{$row['fecha_hora']}} @if($row['solicitud_vista'])<i data-feather="check" class="icon-xs text-success"></i>@endif</div>
</div>
<div class="p-4 border-bottom">
    <div class="d-flex justify-content-end">
        <p class="ms-3 tx-13">@if($row['solicitud_vencida']) <span class="badge bg-danger text-white"> {{$row['fecha_hora_vencimiento']}}</span>@else ◉ Vence: {{$row['fecha_hora_vencimiento']}} @endif</p><P></P>
    </div>
    {!!$row['descripcion']!!}
    <hr />
    @php $conteoAdjuntos = 0; @endphp @foreach($adjuntos as $row2) @php if($row2['id_trazabilidad'] == $row['id_trazabilidad']){ $conteoAdjuntos++; } @endphp @endforeach @foreach($adjuntos as $row2) @if($loop->first)
    <div class="mb-3"><span>Adjuntos ({{$conteoAdjuntos}} archivos) </span></div>
    @endif
    <ul class="nav flex-column">
        @if($row2['id_trazabilidad'] == $row['id_trazabilidad'])
        <li class="nav-item">
            <a href="{{ url('/gestion_solicitudes/solicitud/') }}/{{$row['id_solicitud']}}/leer/trazabilidad/{{$row['id_trazabilidad']}}/adjuntos/{{$row2['archivo']}}/descargar" class="nav-link text-body">
                <span data-feather="file" class="icon-lg text-muted"></span> {{$row2['archivo']}}
                <!-- <span class="text-muted tx-11">(250 KB)</span> -->
            </a>
        </li>
        @endif
    </ul>
    @endforeach
</div>
<hr />
<div class="p-3">
    <strong><i data-feather="git-commit" class="icon-lg me-2"></i> Trazabilidad</strong>
    @else

    <div class="d-flex align-items-center justify-content-between flex-wrap px-3 py-2 border-bottom">
        <div class="d-flex align-items-center">
            <div class="me-2">
                <img src="https://portal.unag.edu.hn/matricula/documentos/fotos/{{$row['foto']}}" alt="Avatar" class="rounded-circle img-xs" onerror="this.onerror=null; this.src='{{ url(asset('/assets/images/user2-403d6e88.png')) }}';" />
            </div>
            <div class="d-flex align-items-center">
                <a href="#" class="text-body">{{$row['name_remitente']}}</a>
                <span class="mx-2 text-muted">para</span>
                <a href="#" class="text-body me-2">{{$row['departamento_destinatario']}}<small class="mx-2 text-muted">{{$row['name_destinatario']}}</small></a>
            </div>
        </div>
        <div class="tx-13 text-muted mt-2 mt-sm-0">{{$row['fecha_hora']}} @if($row['solicitud_vista'])<i data-feather="check" class="icon-xs text-success"></i>@endif</div>
    </div>
    <div class="p-4 border-bottom">
        <div class="d-flex justify-content-end">
            <p class="ms-3 tx-13">@if($row['solicitud_vencida']) <span class="badge bg-danger text-white"> {{$row['fecha_hora_vencimiento']}}</span>@else ◉ Vence: {{$row['fecha_hora_vencimiento']}} @endif</p><P></P>
        </div>
        {!!$row['descripcion']!!}
        <hr />
        @php $conteoAdjuntos = 0; @endphp @foreach($adjuntos as $row2) @php if($row2['id_trazabilidad'] == $row['id_trazabilidad']){ $conteoAdjuntos++; } @endphp @endforeach @foreach($adjuntos as $row2) @if($loop->first)
        <div class="mb-3"><span>Adjuntos ({{$conteoAdjuntos}} archivos)</span></div>
        @endif
        <ul class="nav flex-column">
            @if($row2['id_trazabilidad'] == $row['id_trazabilidad'])
            <li class="nav-item">
                <a href="{{ url('/gestion_solicitudes/solicitud/') }}/{{$row['id_solicitud']}}/leer/trazabilidad/{{$row2['id_trazabilidad']}}/adjuntos/{{$row2['archivo']}}/descargar" class="nav-link text-body">
                    <span data-feather="file" class="icon-lg text-muted"></span> {{$row2['archivo']}}
                    <!-- <span class="text-muted tx-11">(250 KB)</span> -->
                </a>
            </li>
            @endif
        </ul>
        @endforeach
    </div>
    <hr />
    @endif @endforeach

    <!--<div class="mb-3">Adjuntos <span>(2 archivos, 1.25 MB)</span></div>
     <ul class="nav flex-column">
                    <li class="nav-item">
                    <a href="javascript:;" class="nav-link text-body">
                        <span data-feather="file" class="icon-lg text-muted"></span> SolicitudCambioCarrera.docx 
                        <span class="text-muted tx-11">(250 KB)</span>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="javascript:;" class="nav-link text-body">
                        <span data-feather="file" class="icon-lg text-muted"></span> PlanEstudio_Carreras.pdf 
                        <span class="text-muted tx-11">(1 MB)</span>
                    </a>
                    </li>
                </ul> 

    <div class="file-attachment">
        <img
            src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxITEhMTExMWFhUXGRgbGRgYGBoZHxcaIBcbFxsaFhcaHCggGhslGxoZITEiJikrLi4uFyAzODMsOSgtLisBCgoKDg0OGxAQGy0lHyUvLy0tLS0vLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLf/AABEIAMgA/QMBIgACEQEDEQH/xAAbAAACAwEBAQAAAAAAAAAAAAAABAIDBQEGCP/EAEgQAAECBQICBQULDAICAwEAAAECEQADBCExEkEiUQUTYXGRMlKBsdEGFBUjMzRCoaKywyRTVGJyc5KTwtLh8AfBQ4JE4vEW/8QAGAEBAQEBAQAAAAAAAAAAAAAAAAECAwT/xAAmEQEAAgEDAgYDAQAAAAAAAAAAARECEiExA1ETQWGBkfAiUnEy/9oADAMBAAIRAxEAPwDx1DMlhSesfqxkJsWbA5RqPQWOudjBAF+EZAP65LchY71dHdDzQ/W0VUoEpYiTNsGUTgB3Oj0PFNX0FUP8XSVWlh5UmY7tfCLXjKrRMpApF5qksrW7A/J8IADf+S2cDfMWTZ9Fw6Qu6peo3slz1jc1aWGMu0MHoUMv8irHPk/EzrcO9udznEZ9J0HUP8ZSVRDfRkzHdx+ryeAbXModJvM1EquHYB7AAjkN7km5GysxdNrTpUspDlWoC7ajpSQxBICQC3034WaHB0Gzfkdcbh3krHC4fCHJbUdthfMI03QdTqGukqSm/wD4JuWOl2ALOzsQWeAbUqh1KOueEudIDYswcpO737PSeINEBeZNIIGAAQoDiHkkaS4bJ4DziXwHYfklc9n+JW3a3BEx0GHH5HXtu8lfYwsjGd94Bcmj4fjJxsNRYBi6XAGkvYr9KRzeLUKog7rmKBxkFLKL4ABJQUs9tQL2hOq6BqH+LpapmGZEzLX+jh4dHQji9FXAvtKXgsTlJfS5Aw4Dm5aAjINFlUybYl024hqADMkZS5Nwz5teKTR2+Mm5LuzMFdiXugFu3ThzpXPQVR1lqSq6vUMyJjlL3wmxI8HhxXQRP/xK0YxImNs5AIJZnIc98BzrKFidc0EiyQPJsbkl3U7ck3/9gtPnU3XDSV9U6HDOWfju4ItcZzkQ38Bj9Er2/cruXu/By8eyE6zoOe46qkqglvpSZju5/V5NAMpnULEvNckEJOwcggtnnl7C5uD2bMoSVFK5oGnhTtqZQuWJAfSd97RxPQiiBqo6wKYWTJmMeEOeIEvqfsxC1d0FP1HqqSq0tgyJljv9HH+3yQalLoQSSucU2DMHuH1AMBYggufpWdnMZa6LSrVMm6tIYAYLIL4vxaw3I9xi5HQgP/w61Lk3MmYQBqJBsh30sOztuYzJnQVU500lTpcs8iY7PZ2TloB8TaEOSqcXDaQzg8N9VgT5Zw3YIlKm0IKHVMVnXm4BUxSzEEgp/h2LxmfAVX+iVP8AIm/2wfAVX+iVP8ib/bAPJNFZ5k7yrlgCE8eOFiT8X9fcCQaOxXMmHjPCPNCQeLhs6nxtb9aEfgKr/RKn+RN/tg+Aqv8ARKn+RN/tgI1dQgrV1YIQ/CCXLYcvuc+mKeuhj4Cq/wBEqf5E3+2D4Cq/0Sp/kTf7YBfroOuhj4Cq/wBEqf5E3+2D4Cq/0Sp/kTf7YBfroOuhj4Cq/wBEqf5E3+2D4Cq/0Sp/kTf7YBfroYpp0rSrW+ra5DW2azvzg+Aqv9Eqf5E3+2D4Cq/0Sp/kTf7YC+VNkOhxZjquq5a2pi4v5rQjXmWpZ0h0vZ7+u7PF/wABVf6JU/yJv9sRV0LVDNNPHfJmD1piafyu29f4aajm78/5/H0NUlYkDQWUAjstZw7FrbsYlJmrMpRB1KALFmc6eWMxcmYyR2BPMkvYAAAk4jhqk51ps5ycBWg7edbtjTmz+h51QVNMCtOkniSxCtTAPvw39MX9L1U1FNUTEIPWIRMKAnjKiEkpZLXJP0WMNe+EuRrQG1O5IbSQC5ItkRw1KN1oDEgupmYkXcWwb9kWZsiKZHuf6QnzJ89EwK0JRJKCU6QVKVO1gHSHICZb5a3O8OjelatdQUTKcIknXpmalEljw6pbcFtzlrO4jYl1qFEBKkknYaifSNNsbw31KuzxPsgFa2apKCUglWwAd74PIHD9sQpJ61ytRSpK2PCQAQeXIth+yHepV2eJ9kVTV6XKilIG5Uw23I7WiKT6PqVqUUrGH9bNBT1CzMUFWGopCSlrAAhQO4PdsYanzwhJUqwGWvu1ohRVPWIC9JS+yrN/iFpe9Jz5igHSHPjEJMxZSpxcY2ez+u0FJViY5SFNsohgoXunn/mCVVoUtcsHiQ2oMbPi+IsFwhSTphLKDBndiL2t6HI9EUSp8/3wpCh8T9FQSQX0hWlVy6Rc6wznhs3E8qcApKfpKBIHYGc9nlDxjO6V90EinXKRNXpVNUUoDKOouA3CkgXUM84aZnhYzjG7PValBCigalAOEu2prsDzOIp6PnrWjiYLYYfhJGC+4OYtFSHYZtz9nZCtF01Kmrmy5anVKLLDKGkuRkpY3ScPiHknmj0bWzTMWiYjS2M3zgklxb640wYpVUN2eJjiahywIfuPdFym5IiockTphmLCpelAbQrUDq5uAbdnZ4Ryaqd1qAkJ6og6iX1AjDXu/dZovKrPCSOl5R0kKB1EAZ3bYi2R4xLKNp8sBgUurUSccIYDie5PI4ON7KopSl0hyHsDc2JaEE9MSizLF2td7s1mfcQz74HZ4/4gJSitzqZrMwZ+G5ybP6orXMWFix0ktZiw05O44rPi/piXvkdnj/iJSZwUHGP95i0B2dMYf7aE+kKlaQNIBLAsS2x7Ru0W1deEKloYqXMUwSGfSDxLPJKRvzIGTF86clAKlKCUjJJYDa5MSJhaYiOkqhw6Es4fiYgcxxHw7d2c6NNVal6fbyPOx9EMVNQEBz62i9MtRAI0se0/2xUKSZi9ZCgWIJB2sRuMZ35d4CXTijw8+4EtqDtqtiNnqV8k+J/tiEykKspQe8//AFgPPe5iqUtc3UhSClS0jUEjUngZQ0gWPbcF4d6U1EgFIAD6S76sO4a3iY05dGRhKB3H/wCsLV8suAW9Bf8A6HKILkynSHFiE8trg98LIkSjMMsSkuA/kIZgw5frCG0T0gSkF3UkNY7Ju5wP8iFaT52r9g/hxqIDKOjki4loB/ZTyblyMcPRyWI6tDFiRpTciwOI0YIgRl0eltKUhsMEhvqi5l8/V7IYggF2Xz9XsiuZTk5v4eyHIIBCdQhaSlaQpJdwd3BBf0ExYqnJBBDghjfaG4IBKTSaQyUgByWHMkk/WTEJfR4StSwkalZLkvjnjAxyHKNCCAS96cWtuJil32JBIbGQPCEq7oCVOUlUyWFFJdJUEnQXBdLpJBcDwjagi3QzJfRjF+L0kepu2IyOh5aFLUiWlKll1FIAKi5LqIF7k+MasEQImj7PFj6xAmja4DeHsh6CASVSE/8A7CvwMhwdIcMx4bNhrbRrwQGP8CS/MHgn+3sHhFvwb3+I9kacEBmfBnf4j2RbT0egMH9Jf64eggEBQjXr0jWzat25PyuS3bFpkk5AhqCFBQyDy9X/AGOwR1EpYAAsAGAGkADkA0NQQC2mZzP2fZBpmcz9n2QzBAIVc5UtOpRLWFtO5blCtbNwSScjbbuhjp75E96fvCMqtJ5nyl79sJ4DM5CjOptP0UOo2slm3vc27Hiyk+dq/YP4cNypKSJaikagkMpg4tscjJ8YUpPnav2D+HFx5GzBBBEBFNTUpQAVblgBcqPIDcxdGIJKpqyV8IuCSQ4S9kSwDZ2BUvPLbTz6mWURWMbunTxid8p2O1fS8iUlC1rCQssmxJUWKmAAd2BLdhhikqUTUJmS1BaFB0qSXBHYYyem+ieuVSaFiWiTMUpWlRQoJ6iZLAllIsXWnlZ4y5/ubWiYkU6pYkPRk6pi9SeoqVTlNwnWVhRuVC4u7uPRjjExFzu45TN7cPS/CUnqxN1jQpQSFbFRWJYHeVkJi+ROSsaklxfYjBY57RHhqb3JTgRxSEspBJStR65q2XU6pgKAykIQpCcvrN0i0NUvucnImylqMiYEtdS1vJIqJs0qkgDiK0LSkuU/Jh9QtGpww8pZjLLs9nFEysQNbk8DamBLOHDADiPYHjwlP7kakFSlmmWCqUpcnWUy5ykpnpXraVYEzJaxqEwvKAUSwUHqj3Nzjc9RMAVKJkrXMEtYTTdSQolKzZfGHCn0h73Dw8b5NWXZ7SKampRLAK1BIKkpD7qUoJSO8kgemPJU/uWmpVKWqahcyX7zaYVK1NKJE5nBI1pLZOr6Ri/pn3PzJtUJw6lSesplhS1KC5aZUwKXLlpCSClTPkXyMETRjfJOWVcPWQR5T3Ke56bTJnCZOBUtKU60rB1KGt5yk9Wlph1B3KydIdRYQt0f7nqiUmQUppkrlTUqITMmNO/J5klcxaiiy1FYU2kvpuokuJoxud11T2e0gjwkr3GL6jQsy1zBT0kpJ1kMZXynEqWoBKmTlKgpmUlon/8Ay1SRJClySUIQgKBUn3sUzlL1yEpQEqUpBSg2lg9WLMdIvh4/smqez3EZkr3QUqhLKZyD1izLRfyljKR2iM33MdCzaedUKUZeiYXACtSidai6ldWg4IsorOeJmjH6O9xU2XNlzDMlshSFgAqssqHWqDp3RKkt268PdGGG9yasvKHvYqqqlEtJWtQSkM5PaWH1kR4il9yM9KNJMksJIWjWvTWFClFUypJRwqWCHDLwxKgwBO9x9QUoBVJWyQBrWv8AJ2qVT2kcJKk6FJlOdNpScjhF8PH9jXl2e2palExOpCgpLqS45pUUKHoUCPRF0eGl+5GeJ0lZmJ0oWpXCtjLerm1DoeUokrQtKFAFHksSoGPcPGM8YjibaxmZ5h2COPHXjDQggggCCCCAzunvkT3p+8Iyqz+pfrjV6e+RPen7wjJrDf8A9leuLPBBydUBIQHUCRZtWzDawyI7RfOlfuz+HCXSKfjKcsHZfKwYXDjta17+DtF86V+7P4cMeRtQQQRAR4+b/wAZ9GqUVGUp1Ek/GLyS53j15MIfDMln1Wcg2wz5OwLEgnO0bwyzx/zLOWOM/wCoedH/ABj0Z+ZV/MX7YkP+NOjfzSv5i/bHovhaVupmDl7MO3l7L4i734jUtL3QAVYsM39F/SOcb8Xq/tPyx4XS/WPh5kf8b9HfmlfzF+2Jj/jvo/8ANK/jV7Y3ldKSgrTquxPhm/8AuDBN6UlJKQVNqTqB2I2v/v1iHidXvJ4XT7Qwx7gKD82r+NXtiY9wlD+bV/Gr2xsq6VlDKms+Dh2x3t4jmI4elZN+J2y1922/1r4ia+p3lfD6faGSPcPRfm1fxq9sSHuLo/MV/Gr2xsGvlsk6gygCDzBx43bmx5QDpGW2oKGl2d7Ozn6rvhr4ia+p3k0YdoZQ9x1H5h/iV7YkPclSeYf4j7Y0E9KySxCgQXuOzN9m35PHZHSctYJSp9Ic8wM3Hd/1zhq6neV0YdoID3LUvmH+IxMe5mm80/xGHlV8sM6gxAUC9mOC/ax8DyiCOlZRID3Ie427u6/cx3hqz7mnDsWHudp/NP8AEYkOgJHmnxMX/CkqzF3/AMP4AueQBdmjq+k5QSFlXCd/TpJPIAkB+2JeZWKkdCSfNPiYmOh5PI+Ji41yGBexAL7McF9n7eR5RWelJV+LGeywPhcd7jmIXktYgdFyuR8TEh0fL5fXEajpSWggKLOEkdxOkGOTOlpQZ1ZIHidN+QCrE7FxmJ+R+K4USOX1xIUyeUQRXIIQQfLcJ7SMiITekpacq3b06gm3O5a3I8jCpXYwJIiYEKHpSVw8Y4g6e0YsM5EX01QladSS4ch+6x+uJMSXC2CCCIrO6e+RPen7wjK6ZHkW871xq9PfInvT94Rk14dncsVt2cUWeCB0kOOnufpWs2B2Pvsdh2mHaL50r92fw4qqacHSt1OkYGPVnuPZFtF86V+7P4cMeRtQQQRAGMdU6kIvoKe2WG4Q1+FhpTzwCMAxsRke/KQlIZOocQAll+8DT+s/peNYpI62kJCCEuo6WMtnV5pdGb47YaXMk61JJGosFcI4nZIBLcXlAekQrL6SpGQWSMKHB5LtkgMk48IvNXTnQvhOsjSrQbkKCASWsxUACecan3S1UyZTJUUFKQwH0A3lMADpvfliOLqqZg+kgWAKMMPJDpsw22cc4nMq5BQqYEa3KQWRdRJADamf/EUiupAmyQyQ7CWdgSALZZ/rh8oskz6VZBATqUwugOx0tq4bB9Od2GYkr3sVKlkIKnDjQDfZ+FsnfcxwdIUo0+SMaXQ3Mgi1sqI9Mc+E5T6urIe5UQh2CgglXE9lMOdrYhuIzZlMeFQHxbpAKHDJS5AASzAHHceUCqql4E2urUEiWfKY306ct6xzEcX0pJBUTKIUArKUOQFKSWv+qstySoxeJkg6dSEhSipIBSCXSdJFnFiwzARmzKZADlCQUkjhSxSRcjhvYX7BE6ISFhQlhLWfgAcXY+TcWPgYFV9OpWgkFQOltJJDnQ2LA+DdkVnpOml6iGDK0nSg2Ls1hs32eyJutwqE6lU2pIuEoCSkKtlCWAIS+oECx8InLVSrUEgIJLMDLG4KhlO4BMC66kAUDoZKiD8WWCg+eHNj4GLKSpplKUEJSCm76GtpBBBbkr17RflHFJpwJitKPi/K4EgggdoipdbSkBJYhnSOrcF3PDwsTY4hiTXU5ClJIYF1HSRd+65BbxEUmupSNRCTkfJlW/Yk2Lv/AO0PkS62mmFMs6VagyQUBiA7gOnHCfDsiYTTlelkldx5A2BDPp5A+BiKa+mBB4QQzHQRpBwx02BBfuMTo62nUpkadRJJ4WOpnLlssecTdUJ02nwrTYMxQ9g4DDT5Ivi2YgpVLoMwJSQhjaWObAh08xtuDygNfSO7ByCSeqU5B0u/D+ul/wBoc4uNbToRq4UpKgnySHLAizXszHui7+qKUVtNw3A0lWngHCymUUkJsH0l/wBZJ3EdkGmmLUkJTruSFSwCb5Lp5ne+YDW0rsyXD/8AjNmcn6O3E/JjFqaqQiZ1YASsaRZLZwAQO7xEPkKifRoAI0jQlxwXACXyUv5LHuvi8aVB1egdU2guzDSM3YABrvGeqspEulk8AIICMBKiDkX4gfSDGlRzEKQDL8nZhp35MGiZcLC6CCCMNM7p75E96fvCMqs/qX641envkT3p+8Iyqz+pfrizwsJ108pVJTqYKCnDC7Nue/194ZovnSv3Z/DhPpAnXItZl5b9XAd3HNsGHKL50r92fw4Y8o2oIIIgIyJfSFKlgALvbQSSCb7O1/8AcRrxESwMAXvjfnFiUlmzOk6dJILBlMeHcFuWxSf4e6O0/SchZEsDYcOmwBLXa2WEaKZYGABk43Jc+JjoSOUW4KlmI6ap9OoHhv8AROzk29H12iB6Yp7gg41HgN8kuGd3G/ONbSOQgCRyH+2hcFSzqjpOQlSkKygAkaX7mYXL2YXjk3pGnFy2yn0vkJL4vZSf4uwtpFI5f7iDSOULgqWV8LSAop0sSb8IuSLk+r08rxbJ6SkKCCnBXpTwmyu5uEMRfkY0CkcoNI5QuCpZI6Zpw5YggJUWQ5AUxvpBu7emJ03SchZCWZSnLFPYTcizsD22MaekcoNI5QuCpZUquppgK9I4SRdO5Vo7rlr8j3xIdKU4NmcgXCfODgEtk8o09I5CDSOQhcFSpkJlqSCkJ0qA2yMhx6YsElPmjwETgjKq1SUnKR4D/dh4R1MpILhIe92G+YnBAVpkpGEjwEC5CCGKQRezDJye+5iyCArEhHmp22G2PCO9Ul3YPzb0C8TggIGSnzR4CJISAGAAHZHYIAggggM7p75E96fvCMqs/qX641envkT3p+8Iyqz+pfrizwsI9Iq+MkD9oi3jfVawOx+uHqH50r92fw47NB0DHh/mOUXzpX7s/hwx5RtQQQRARmHpCaBeQo9z9xOMOC3MFJ3LacZIk1YPyqLtkbu5+iLMDb/9jWKS4OlJzJ/J1vd8+a9uHnz25m0XzekVhQAkqPAlRZ7Ek8Jsz2597C8UTpVWAohaTYaQNLvguooAbfG0Wrk1JHyiX1E25WYeT+14jLEG1DO4pekJihMKpKk6QSM8XIBw7+jn2PWOlJujUadf7N35hxp9D84tnpqOHStAskF+eFEDTfIa47o6iVUBReYnSSrTYP5JZwwcvf0HLhmy7o/CMzU3ULwS9xh+HyfKYbWc5a8Sl9ITChS+pUCMJu5udtLszeO2Y4iVU8TrR5NrHy3BG1k5ERp5FVrBXMQU8gG5PZr7gXHPshsbramuWlSkiUpTCxDsTaz6WGTd/om2H5Lr1kqBkqGlKiM8RBYAOAL98QlyarUnVMRpcOALkObY5erxjNl1XGy0Di4SbslsNp7d3bTu8KguVgr5mhaupUCAkgX4nzhL27jaKU9JTrvTqNiQ1sEhseUWf0jvhhYnOplpYlOnuYv9Es5bng4e1XVVVvjEO51ActmOnObkcrHdsbuHpKa6PydTKF7nhu17d/1cy0zXTGlq6ksoK1C7pIIbbcP9WA5iEyXVElpiBjId+EOQGsNT5fbDXlLkVIKvjEkEKZ+ekBJsmwcO187w2N0VdJTgB+TqclmBJa7X4bc+6LaWuWpWkylJDeUXbLN5PpiExFRwcaPJSFbOvci2Ha27NvEEyakpQRMQVMQT9EgqcKDJudLDxhUG7orJ5UyZbjWoOUqSyR5znc7h7NbYWVlZMSoaJZUkgHBckk2fCdiSccjERLqCXExJS9jzFmcBLPa/O7aYrVTVdvjUWzZnOoHZNuFxvdrZBbG65VVM6tRSnUsFIHCU6gVAE6VEEMNVifovgxRL6QnkpeSQHDlj5LpSTsQbrNw7AWuWBTVbJ+NRbPbwtfhve+1+eIYmy5ytBTMSGCgpg+omzg7aSHZjy7YbJunNrSCv4tTJRqCrsqzsGBP/AHY2w9CekZpxTqGclsAHzTm/1drQlU1U6dU1LAEHDnybtoYmx7tW8WJk1OggzEatVi22lmLjOq/txCoXdKjrZilMqUUi9y+AEttkkkf+pPZDNFPK0BSkFBL8JyGJHLfPphBEqpJfrUHsFmDp/VIwFeMP0SZgQBNIK7uRjJbYbNEmiF8EEEZaZ3T3yJ70/eEZVZ/Uv1xq9PfInvT94RlVn9S/XFnhYX1VSU9WjTZQPE4szWAyc/7draL50r92fw4S6RWdcgA+c7EYLM4N2JBuNwBuIdovnSv3Z/DhjyktqCCCICMGXKpjpVrWTps4JLeSnCcglgfO7Y3oxjOdh70fvTgZOUei277MTrFnJUE02hKetUyCpiQ7uoKNyhiAWxZlAGxvJVJTaFnWsJSriupwolLOGcn+5Xo6ia4KvelypL2u7ZAKdsbZ7YZnTtMsKTIcrWNSQP1rqPDfDgqA2do1uhFdNSnUnrF2HEA7p4QCTwuCwF8gkYJESn+9VpR8YQkatLdrm3D5LEi1mDF2aLqxZ0JWmmSpStTpKcFiEvZ21N2sSeyITahuEUjtjhsLEj6PotuoM4dQqOTU0y1AmYoH07hKAFApvgFj5xexMcn0lOF6FTF6lKDd7FkpISw8t27uyHKIpW5XI0KHNIuA2C2Hx/rKmtUSlRpFEk+bcEGynKcct+6zzdRMkU6dSFTFA6kk3ZiAWZksA3oDWZohPFKtS1mao6rEC4DA4GksWBv+qRzEWz6pTl6UqIe7anuBY6cG/hEukEpBlKFNrPEcHhdO4AZ8C9+T4gFVyaYkca975DHUHDpNvogjLgXjs6gpkhBVNWApJYvkaQ5UQnldz6hZ2fpQZZTTBWq5ZIdBtm3f/txQiuURemNrJBSbBj+rzAG3lDta3JUBIp1Tn1q1ujZhYsAeG1wxdiCWtqvGdLpwshUxb4ZrOVM76bkEm7nF3aGpakiWJnvdjskJ4hlsC17emKVVKipOqldyLs+lzcnh2d/4vTBWmRT9Uo61lIIvuFIBUGYXIy9/JGwtSJFIlgJiuEOEjzW5acN9lndIEOVk/QdAptSHcsmz2Oohm7ObjaxNRnhnFI5H6rWyNPBdz2DmWixaOU9JT6JqUzFaSkFbltKQSdxbB+vnFi5FOJYeYrSSVgvezJJw/LtuYJdQQoJTTMFW8kgZNlHS3InIvbVF1RMA6kGnKgoF+F+qDAlwx7mHKJuuxRC6ZKgrrFcJ9ANrYZPOzW1bOI7Ko6VQUQokAAEctWGGlyrlk4GwEEqcWcUYBc7NZ8vo7sPg9jylVRdQ96kJLA8JuLs4Cdgw3udheLuiuVR0ylp0zFFRDJDjADW4bWT38NsWtnUcg6ppWtkrc7gK1JIsUlw+lvRtE0LCJSFopmU7aWunIJdnuALlshyIsnKBlAmQ+pTqRpOQSQojS5cpGQMh2iXK1DPl09KlJaYtiHvyaxulsEB+RA3Y7dCU6E6SSkBgTm1r2EYxq2OpdKAwAfSQ5umzp3AGkZZQfTcDYoFOgcHV54WZrnZh6omRiYgggjDbO6e+RPen7wjKrP6l+uNXp75E96fvCMqs/qX64s8LB6aOAd0RovnSv3Z/DhqWkMLDA9ULUfzpX7B/DhjyjZgggiAjKFNU2+MF1IfsAHH3hR22jVjzyZVMx+NWBzPrB02HE9myFcjGsWcjS6OeGacyili5NzpS5ANhcKNucMpE0plALRqBGsvq1JFlNaxJb2xmS6WmPEJkzh27uCw0u9wzX4ksziOCnpSNfXKZ1DIy4mFjpcMWxbG5jVfaRoz6ecVEpUG1A+WrADMUgbF8G++GjsuXOTLKSpOu2lRUTnLuLnJw12YNCNMmllhY6xTKDqCgcPqxpDcz2EnckwMik4R1q7jhYm+Tw8Oc43B3eFfaGlJlT2XqWkqPkttc9lizB2ON8RX1VSXaYh3tYENfPDzb64TnU1KlwqYoMFA7ZWSSTpZgbDYaABhoskSqdCZhExTAFK3tp1HcacuMbXcOS6vtB6bLnkICVJHnndnHk8LEs4wA5dtorppc9KhrmIKXUSN2OALbFvRCk005EsmYocIA7g9zw2OeXkg/RBFS6Wl/OLDEWFrpdW6fKDd4PIm6vtFnuoqiR8YkB7sAbdjotvz2GxJqVJqy/wAYhL62HpOkjhtkbHa5xHZFPIm6UpWolF7FvpK7AAHew81PIRL4Bl24llgwcpLYduHkAIXH2BaZdR1YAWjrNRJLW03YY7RyxEZEqo1AmYghxqDchcC3p9gtHB0HLGniW6d3ubg8Ra+B4DkI7M6GllWrUseVYEAcSisnGXJY5HfeJcLUpyZc8TCVLT1ZUbbszJAsN/8Au5e1KZFW4JmI3fl5QONNywIdxnG5D0DL85fiOxttmtycjBIi2f0ShWl1LGlISGIFgXvbmB2WhcfYKkvJlVZCSZiLi+OWAQhvTcXNomKeq/OIe/bsycps1rc3O7C2b0UlRSdawyNFmxzcjLP48xHFdDoKEo1LZOpjqvcEFy3aYXCVK9SZutwpOjQzb63zjEKFFUkj4xCuI54eHZ+HOBbDnL2up+ikIUlQUslLsCbXTpvbkAe8Pkl6T0DKsApYbkQH5va+38I5QiYXdJNPUuT1qW2Db+kYd4iZFVwkzUWfUwZ87lJbI7mGbvcvopBKDqXwpCBcMQC7kEMT/uYqHQcvzpm24GARgBsE+m+SYXH2CpTEuoMsjrEayqxGAnTbbL37txkNUSZgQBMIK7uU2GbN6IVpOh5ctQUkrcPZw3khOAAMAY3uXhqipRKQEJJID3UXOXuYkzBC+CCCMtM7p75E96fvCMqs/qX641envkT3p+8Iyqz+pfrizwsNeVgdw9UK0nzpX7B/DhqVgdw9UK0nzpX7B/DhjyjZgggiAij3lK/No/hHfyi+MyRTT06QZoPk6n9GoJcHIFr2c2xpsJJwUcsBhLQxs2kYd2xzvHfestm0JZ3bSM8++FalM9RPVrQElm7A1yOE3d/qwxeVKmc51rSRpDNkK3NgLO49HfF9xf7zluVaEuRpJYXF7d1zEUUEoHUJaX5s7bWfHohNEmqt8Yizdve/CMuOWNoupJVQNetaS44N2N/K4Q4uPDaHunsY95y3fQl3JcgG5zeD3pLYjq0MWcaRdsOGvFUyXP0JAWkLCrkhwU3tgXxgDBxEJUuocOtBS9+bdpa9uTXv2F7qZFJL8xH8I7uUBpJbvoS7u+kZ54zCk2TPKllExOkmz3awBDaeY+tW5cVqlVTuJqNDWdnJ2fhZs/VCvVL9GhKpkJ8lCR3JA9UWwksTimXoWh8LJDg4B0tuL8vRHOjpc8autWlTszbWbkGx2+iJS2egjI6urYfGIK3uAw4SbG6cs+zWxDNHKnhfGtJQxdnfVqsRaw02zFos9BCVIieFnrFIKWLAZd35DZ4W6ur3XLGLcsOLJy735EDIcyi2tBGQaWqv8YndrnD/ALLPysfTAqRWMWmS3e3dyVw3P+32un1L9GvBCMyXOMpQ1pC3PFhhdvoliLbbdrjhlzzKI1p6y/ELDsaxbbbHjEos/BGSumqiD8akWLN3AD6L5c5ia5VUygFy8cJvlvpcNwDyZ/1cRdPqW04ITokTQSJiweQFyORJYOcv6GAi2iTMCAJpBXdymwzZvREmC18EEERWd098ie9P3hGVWf1L9cavT3yJ70/eEZVZ/Uv1xZ4WGvKwO4eqFaT50r9g/hw1KwO4eqFaT50r9g/hwx5RswQQRAR51MumGl56nCbDDsHKwNP1jvzePRRSaSWW4E2sOEWHLEaiaSYtjS6WmJ0CatwWbtsjOm4uBy4gPpXslyqdKtXWKJ1H0FJCjYJffuCSWYGNUUsu3AmxccIseYjopkDCE7/RG4Y+IA8IupNLIle9krUoTVPMJ7Lm1iEg7Zf6O+m1ZRTFyZq2YNgBNwoaQE2Jv6ArYRsIopQDCWnL+SMu7x0Ucv8ANo5eSMeENUFEJaJIUiX1inlkkbA3LuWZnBG2+8L+96ZLHrFpYAMHFuHICXDgJHce2Nn3sjVq0J1c2D8sxAUMoO0tF88Iv32hqKZcuRTIS3WqZQa5dwk63YpvkZsQoZcR0SKdKAgzFMVBYcvkAAXSzXHdY2tGr71ls2hLX+iN8+McNFLJcoSTbIG2G5Q1FMamoaVboRMWTaztpYcmsef7R5w4roKWSTqWCQxZXYRy7T4nmYdk0ctDaUJDNgDbEXxJynyIxhnzeh5alJUSp0pCM+UA/lWvk+J5xBPQksK1OvAADhgwYEW8rd+cacENUrUMr4Bl8PEvhe5IJuCC5I7T4nnE19DIMvqypbatTuHdmy3pfL7xpQQ1SaYITOikFKQ6uEMC4cZ7O36hyikdBp4h1kxlBIYEPYk+Uz8u5uVo1YIapKhlJ6ClguFrw2UttcjTc2dzjbZrpPRSElRCluoEZwDyYZ3fL3h+CGqTTDNk9EJSoK1rLEEBwAG/VA5f4YFoiOg0XJUsuGNwB3gNYvfvuXN41IIapNMMxXQkvUC6wwYMQNweXMA99+UO0lOJaAhLsOfe8XQRJmZKgQQQRFZ3T3yJ70/eEZVZ/Uv1xq9PfInvT94Rl1iC+2Vb9r+qLPBDUlrSwuMDfsjgSjVqcasO92t29g8IIIyqfWDzvtH2wdYPO+0fbBBAHWDzvtH2wdYPO+0fbBBAHWDzvtH2wdYPO+0fbBBAHWDzvtH2wdYPO+0fbBBAHWDzvtH2wdYPO+0fbBBAHWDzvtH2wdYPO+0fbBBAHWDzvtH2wdYPO+0fbBBAHWDzvtH2wdYPO+0fbBBAHWDzvtH2wdYPO+0fbBBAHWDzvtH2wdYPO+0fbBBAHWDzvtH2wdYPO+0fbBBAHWDzvtH2wdYPO+0fbBBAHWDzvtH2wdYPO+0fbBBAHWDzvtH2wdYPO+0fbBBARmaFBlFxyKn/AO4XrNNsb790cggP/9k="
            alt="Adjunto"
        />
        <a href="documento.pdf" download class="download-btn">⬇ Descargar</a>
    </div>

    <div class="file-attachment">
        <img
            src="data:image/jpeg;base64,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"
            alt="Adjunto"
        />
        <a href="documento.pdf" download class="download-btn">⬇ Descargar</a>
    </div>-->
</div>

<div class="modal fade bd-example modal_remision" id="modal_remision" tabindex="-1" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h6 class="modal-title h6 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="share"></i> Remitir</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="card-body">
                <div></div>
                <div class="p-3 pb-0">
                    <div class="to">
                        <div class="row mb-3">
                            <label class="col-md-2 col-lg-2 col-form-label">Para:</label>
                            <div class="col-md-5">
                                <div class="mb-2 d-flex align-items-center">
                                    <div class="form-check me-2">
                                        <input type="radio" class="form-check-input" name="remision" id="remisionInterna" checked />
                                        <label class="form-check-label mb-0" for="remisionInterna">Remisión Interna</label>
                                    </div>
                                </div>

                                <select class="js-example-basic-single form-select" id="empleado">
                                    @foreach($empleados as $row)
                                    <option value="{{$row['id']}}">{{$row['name']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-5">
                                <div class="mb-2 d-flex align-items-center">
                                    <div class="form-check me-2">
                                        <input type="radio" class="form-check-input" name="remision" id="remisionExterna" />
                                        <label class="form-check-label mb-0" for="remisionExterna">Remisión Externa</label>
                                    </div>
                                </div>

                                <select class="js-example-basic-single form-select" id="departamento" disabled>
                                    @foreach($departamentos as $row)
                                    <option value="{{$row['id_departamento']}}">{{$row['descripcion']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Fecha y hora de vencimiento:</label>
                            <div class="col-md-5">
                                <div class="input-group flatpickr" id="flatpickr-date">
                                    <input type="text" class="form-control" placeholder="Selecciona una fecha" data-input id="fecha_vencimiento">
                                    <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group flatpickr" id="flatpickr-time">
                                    <input type="text" class="form-control" placeholder="Selecciona una hora" data-input id="hora_vencimiento">
                                    <span class="input-group-text input-group-addon" data-toggle><i data-feather="clock"></i></span>
                                </div>
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
                                    <input type="file" id="inputArchivos" multiple hidden />
                                </div>

                                <div id="fileList" class="file-list"></div>
                            </div>
                        </div>

                        <div>
                            <div class="col-md-12">
                                <div class="d-grid gap-2">
                                <button class="btn btn-primary me-1 mb-1" type="button" id="enviar_remision"><i data-feather="send" class="icon-lg me-2"></i> Enviar</button>
                                </div>
                                <!-- <button class="btn btn-secondary me-1 mb-1" type="button"> Cancel</button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer bg-secondary">
                <button type="button" class="btn btn-danger btn-xs" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-xs" id="btn_guardar_datos_academicos">Guardar</button>
            </div> -->
        </div>
    </div>
</div>

@endsection

@push('plugin-scripts')
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
  <script src="{{ asset('assets/js/flatpickr/dist/110n/es.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=mzutkZDE"></script>
  <script type="text/javascript">
    var accion = null;
    var id_solicitud = {{$id_solicitud}};
    var btn_activo = true;
    var empleado = null;
    var departamento = null;
    var fecha_vencimiento = null;
    var hora_vencimiento = null;
    var descripcion = null;
    var adjuntos = null;
    var url_guardar_remision = "{{url('/gestion_solicitudes/solicitud/remitir/guardar')}}"; 
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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
                    image_advtab: true,
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

    $(function() {
        'use strict';

        // date picker 
        if($('#flatpickr-date').length) {
            flatpickr("#flatpickr-date", {
            wrap: true,
            dateFormat: "Y-m-d",
            locale: "es",
            });
        }


        // time picker
        if($('#flatpickr-time').length) {
            flatpickr("#flatpickr-time", {
            wrap: true,
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            });
        }

    });
      
    $("#enviar_remision").on("click", function () {
        departamento = $("#departamento").val();
        empleado = $("#empleado").val();
        fecha_vencimiento = $("#fecha_vencimiento").val();
        hora_vencimiento = $("#hora_vencimiento").val();
        descripcion = tinymce.get('descripcion_solicitud').getContent();
        
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
            
            if(descripcion == null || descripcion == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Por favor, describe tu solicitud antes de enviarla.'
                })
                return true;
            }
            
            if(btn_activo){
                guardar_remision();
            }
            

    });

    $("#modal_remision").on("show.bs.modal", function (e) {
            $('#empleado').select2({
              dropdownParent: $('#modal_remision'),
              width: '100%'
            });
            $('#departamento').select2({
              dropdownParent: $('#modal_remision'),
              width: '100%'
            });
    });

      $('#remisionInterna').prop('checked', true);
      $('#empleado').prop('disabled', false);
      $('#departamento').prop('disabled', true);
      accion = 1;

      $('input[name="remision"]').on('change', function() {
        if ($('#remisionInterna').is(':checked')) {
          $('#empleado').prop('disabled', false);
          $('#departamento').prop('disabled', true);
          accion = 1;
        } else {
          $('#empleado').prop('disabled', true);
          $('#departamento').prop('disabled', false);
          accion = 2;
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




    function guardar_remision() {
        espera('Enviando tu remisión...');
        const formData = new FormData();
        // Agregar archivos
        archivosSeleccionados.forEach((file, i) => {
            formData.append('archivos[]', file, file.name);
        });

        // Agregar otros campos
        formData.append('accion', accion);
        formData.append('id_solicitud', id_solicitud);
        formData.append('empleado', empleado);
        formData.append('departamento', departamento);
        formData.append('fecha_vencimiento', fecha_vencimiento);
        formData.append('hora_vencimiento', hora_vencimiento);
        formData.append('descripcion', descripcion);

        btn_activo = false;

        $.ajax({
            type: "post",
            url: url_guardar_remision,
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
                } else {
                    titleMsg = "Remisión Enviada";
                    textMsg = data.msgSuccess;
                    typeMsg = "success";
                    timer = null;
       
                    //btn_activo = true;
                }
                //console.log(textMsg);
                ToastLG({
                    icon: typeMsg,
                    title: titleMsg,
                    html: textMsg,
                    timer: timer
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
            timerProgressBar: true,
            confirmButtonText: 'Aceptar',
            ...options, // permite pasar icon, title, text, etc.
        }).then((result) => {
            if (result.isConfirmed) {
                espera('Recargadno...');
                location.reload(); // 🔁 recarga al confirmar
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

  </script>
@endpush