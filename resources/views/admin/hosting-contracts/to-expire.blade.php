@extends('layouts.dashboard')
@push('head')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="{{ asset('css/plugins/dataTables.checkboxes.css') }}">
<style>
  .text-success {
    color: #076c1e!important;
  }

  .text-warning {
    color: #c09001!important;
  }

  .alert {
    text-align: center;
    padding: 0.25rem;
    margin-bottom: 0;
  }
</style>
@endpush
@section('content')  
  <main class="app-content">
    <div class="app-title">
        <div class="tile-body">
          <h1><i class="fa fa-th-list"></i> Clientes Hosting </h1>
          <p>Lista de los clientes hosting prontos a expirar</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active"><a href="#">Data Table</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile bg-dark py-2">
            <div class="tile-body">
              <div class="row">
                <div class="col-9 align-self-center">
                  <h5 class="text-white mb-0">
                    Envíe un correo de renovación a todos sus clientes 
                    <i class="fa fa-arrow-right ml-1" aria-hidden="true"></i>
                  </h5>
                </div>
                <div class="col-3 text-right">
                  <button class="btn btn-primary " id="sendToAll" disabled="disabled">
                    Enviar a todos <i class="fa fa-envelope f-16 ml-1 mb-1"></i> 
                  </button>                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
            <div class="table-responsive">
              <table class="table table-hover table-bordered" id="hostingContracts">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col"></th>
                    <th scope="col">Cliente o Empresa</th>
                    <th scope="col">Plan Contratado</th>
                    <th scope="col">Expira en </th>
                    <th scope="col" class="text-center">Notificaciones enviadas</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                @foreach($hostingContracts as $hostingContract)
                  <tr>
                    <td>{{ $hostingContract->id }}</td>
                    <td>{{ $hostingContract->customer->full_name }}</td>
                    <td>
                      {{ $hostingContract->hostingPlanContracted->title }}
                    </td>
                    <td>
                      <span class="fw-600 text-warning">{{($hostingContract->days_to_expire !== 1)?$hostingContract->days_to_expire.' días':'1 día'}}</span>
                    </td>
                    <td>
                      {{ $hostingContract->notifications_sent }} 
                    </td>
                    <td class="text-center">
                      <button type="button" class="btn btn-primary send-notification" data-url="{{ route('admin.contratos-hosting.notify', $hostingContract->id) }}" id="btnNotification-{{ $hostingContract->id }}">
                        Enviar notificación
                      </button>
                    </td>
                  </tr> 
                @endforeach
                </tbody>
              </table>
            </div><!-- /.table-responsive -->
          </div><!-- /.tile-body -->
        </div><!-- /.tile -->
      </div><!-- /.col-md-12 -->
    </div><!-- /.row -->
  </main>
@endsection
@push('script')
<script src="{{ asset('js/plugins/dataTables.checkboxes.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {

  var table = $('#hostingContracts').dataTable({ 
    "paging":   false,
    "searching": false,
    "language": dataTableLanguage,
    "columnDefs": [{
      'targets': 0,
      'render': function (data, type, full, meta){
        return '<input type="checkbox" class="dt-checkboxes" name="id[]" value="' + data + '">';
      },
      'checkboxes': {
        'selectAll': true,
        'selectAllRender': '<input type="checkbox" name="select_all" id="select_all">',
        'selectAllCallback': function(nodes, selected, indeterminate) {      
          if(selected) {
            document.getElementById('sendToAll').disabled = false;
          }
          else {
            document.getElementById('sendToAll').disabled = true;
          }
        }
      }
    }],
   "order": [[1, 'asc']]
  });

  $('.send-notification').click(function(){
    btnNotification = this;
    btnNotification.disabled = true;
    btnNotification.innerHTML = 'Enviando notificación... <i class="fa fa-spinner fa-spin"></i>';
    var notifications_sent = $(this).parent().prev();
    var messageSuccess = document.createElement('strong');

    $.ajax({
      method: "POST",
      url: btnNotification.getAttribute("data-url"),
      data: { _token: "{{ csrf_token() }}", _method: "PUT"},
      success: function(data) {
        notifications_sent.text(data.notifications_sent);
        messageSuccess.className = 'text-success';
        messageSuccess.innerHTML = 'La notificación fue enviada con éxito.';
        btnNotification.parentNode.replaceChild(messageSuccess, btnNotification);
      },
      complete: function(jqXHR, textStatus ) {
        btnNotification.disabled = false;
        btnNotification.innerHTML = 'Enviar notificación';
      }
    });
    

  });

  $('#sendToAll').click(function(){
    this.disabled = true;
    this.innerHTML = 'Iniciando el envío... <i class="fa fa-spinner fa-spin"></i>';  
    var selected_ids = $('.dt-checkboxes:checked').map(function(){ return this.value; }).get();

    for (var i = 0; i < selected_ids.length; i++) {
      var btnNotification = document.getElementById('btnNotification-' + selected_ids[i]);
      $(btnNotification).click();
    }

    $(this).fadeOut(3500, function(){
      $(this).parent().append(
       '<div class="alert alert-success"><strong><i class="fa fa-check" aria-hidden="true"></i> Enviado a todos</strong></div>'
      );
    }); 
  });

});
</script>
@endpush