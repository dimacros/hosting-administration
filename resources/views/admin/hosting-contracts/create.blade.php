@extends('layouts.dashboard')
@push('head')
<style>
  .autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow-y: auto; overflow-x: hidden; }
  .autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
  .autocomplete-selected { background: #F0F0F0; }
  .autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
  .autocomplete-group { padding: 2px 5px; }
  .autocomplete-group strong { display: block; border-bottom: 1px solid #000; }
</style>
@endpush
@section('content')  
  <main class="app-content">
    <div class="app-title">
      <div class="tile-body">
        <h1><i class="fa fa-edit"></i> Formulario para Compra de Dominio</h1>
        <p>Registrar Compra de dominios</p>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item">Forms</li>
        <li class="breadcrumb-item"><a href="#">Sample Forms</a></li>
      </ul>
    </div>   
    <!-- FIRST SECTION -->
    <section class="row">
      <div class="col-md-8 offset-md-2">
        <div class="tile">
          <div class="tile-body">
            <a href="{{ url('dashboard/dominios-comprados') }}" class="btn btn-primary">
              <i class="fa fa-arrow-left" aria-hidden="true"></i>Regresar
            </a>
          </div>
        </div>
      </div>
    </section>  
    <!-- SECOND SECTION -->
    <section class="row">
      <div class="col-md-8 offset-md-2">
        <div class="tile">
          <h3 class="tile-title">Registrar Compra de dominio</h3>
          <hr>
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              <strong>{{ session('status') }}</strong>
            </div>
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
        <!-- START FORM -->
          <form method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="user_id" value="{{Auth::id()}}">
            <div class="tile-body">
              <div class="form-group">
                <label for="autocomplete">
                  Nombre del Cliente:
                </label>
                <select class="form-control" id="customers" name="customer_id" required>
                  <option value="" selected disabled>Seleccione un cliente</option>
                </select>
              </div> 
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="url_domain_name">Nombre de dominio:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">http://</span>
                    </div>
                    <input type="text" class="form-control" id="url_domain_name" name="url_domain_name" value="{{ old('url_domain_name') }}" autocomplete="off" required>
                    <input type="hidden" id="domain_name" name="domain_name" value="{{ old('domain_name') }}">
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <label for="total_price_in_dollars">Precio total en dólares</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">$</span>
                    </div>
                    <input type="text" class="form-control" id="total_price_in_dollars" name="total_price_in_dollars" value="{{ old('total_price_in_dollars') }}" required pattern="\d*">
                    <div class="input-group-append">
                      <span class="input-group-text">.00</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="datepicker_start">Fecha de compra:</label>
                  <input type="text" class="form-control" id="datepicker_start" name="datepicker_start" value="{{ old('datepicker_start') }}" required>
                  <input type="hidden" id="start_date" name="start_date" value="{{ old('start_date') }}">
                </div>
                <div class="form-group col-md-6">
                  <label for="datepicker_end">Fecha de vencimiento:</label>
                  <input type="text" class="form-control" id="datepicker_end" name="datepicker_end" value="{{ old('datepicker_end') }}" required>
                  <input type="hidden" id="due_date" name="due_date" value="{{ old('due_date') }}">
                </div>
              </div>
              <div class="form-group">
                <label for="description">
                  Agregar una descripción sobre el dominio (DNS, soporte, etc):
                </label>
                <textarea class="form-control" id="description" name="description" value="{{ old('description') }}" rows="3"></textarea>
              </div>
            </div><!-- /.tile-body -->
            <div class="tile-footer">
              <button class="btn btn-primary btn-lg" type="submit">
                <i class="fa fa-fw fa-lg fa-check-circle"></i>Registrar
              </button>
            </div>
          </form>
        </div><!-- /.tile -->
      </div><!-- /.col-md-8 offset-md-2 -->
    </section><!-- /.row -->
  </main>
@endsection
@push('script')
<!-- Autocomplete plugin-->
  <script src="{{ asset('js/plugins/jquery.autocomplete.min.js') }}"></script>
  <script src="{{ asset('js/plugins/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('js/plugins/bootstrap-datepicker.es.min.js') }}"></script>
  <script type="text/javascript">
  $(document).ready(function() {
    /*
      CUSTOM AUTOCOMPLETE
    *****************************
    */
      var domainProviders = @json($customers);
      $('#autocomplete').autocomplete({
        lookup: domainProviders,
        onSelect: function (suggestion) {
          $('#domain_provider_id').attr("value", suggestion.data);
        }
      });

    /*
      CUSTOM URL
    *****************************
    */
      $('#url_domain_name').keyup(function() {
        $('#domain_name').attr("value", "http://"+$(this).val());
      });

    /*
      CUSTOM DATEPICKER
    *****************************
    */
      $('#datepicker_start').datepicker({
        autoclose: true,
        format: "dd/mm/yyyy",
        language: "es",
        todayHighlight: true
      }).on('hide', function(e) {
        startDate = $(this).val().split("/");
        parseStartDate = startDate[2]+"-"+startDate[1]+"-"+startDate[0];
        $('#start_date').attr("value", parseStartDate);
      });

      $('#datepicker_end').datepicker({
        autoclose: true,
        format: "dd/mm/yyyy",
        language: "es",
        todayHighlight: true
      }).on('hide', function(e) {
        dueDate = $(this).val().split("/");
        parseDueDate = dueDate[2]+"-"+dueDate[1]+"-"+dueDate[0];
        $('#due_date').attr("value", parseDueDate);
      });

  });
  </script>
@endpush