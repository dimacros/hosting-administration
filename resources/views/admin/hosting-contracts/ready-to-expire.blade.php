@extends('layouts.dashboard')
@push('head')
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="{{ asset('css/bootstrap-table.min.css') }}">
<style>
  .text-success {
    color: #076c1e!important;
  }

  .text-warning {
    color: #c09001!important;
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
                    Envíe una notificación a todos sus clientes 
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
              @if (session('status'))
              <div class="alert alert-success" role="alert">
                <strong>{{ session('status') }}</strong>
              </div>
              <hr>
              @endif
              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
            <div class="table-responsive">
              <table class="table table-hover table-bordered" data-toggle="table" id="hostingContracts">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col" data-checkbox="true"></th>
                    <th scope="col" data-field="id" data-visible="false">#</th>
                    <th scope="col">Cliente o Empresa</th>
                    <th scope="col">Plan Contratado</th>
                    <th scope="col">Expira en </th>
                    <th scope="col">Precio total</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                @foreach($hostingContracts as $hostingContract)
                  <tr>
                    <td></td>
                    <td>{{ $hostingContract->id }}</td>
                    <td>{{ $hostingContract->customer->full_name }}</td>
                    <td>
                      {{ $hostingContract->hostingPlanContracted->title }}
                      {!! $hostingContract->bootstrapComponents()['status'] !!}
                    </td>
                    <td>
                      {!! $hostingContract->bootstrapComponents()['expiration'] !!}
                    </td>
                    <td>
                      {{ $hostingContract->total_price }} soles
                    </td>
                    <td class="text-center">
                      <button type="button" class="btn btn-primary">Enviar notificación</button>
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
<script src="{{ asset('js/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-table-es-ES.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
 
  $('#sendToAll').click(function(){
    
  });

  $('#hostingContracts').on("check-all.bs.table", function(){
    document.getElementById('sendToAll').disabled = false;
  }); 

  $('#hostingContracts').on("uncheck-all.bs.table", function(){
    document.getElementById('sendToAll').disabled = true;
  }); 

  $('#hostingContracts').on("check.bs.table", function(){
    if ($(this).bootstrapTable('getSelections').length > 0) {
      document.getElementById('sendToAll').disabled = false;
    }
  }); 

  $('#hostingContracts').on("uncheck.bs.table", function(){
    if ($(this).bootstrapTable('getSelections').length === 0) {
      document.getElementById('sendToAll').disabled = true;
    }
  }); 

});
</script>
@endpush