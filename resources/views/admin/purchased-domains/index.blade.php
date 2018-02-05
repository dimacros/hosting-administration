@extends('layouts.dashboard')
@section('content')  
  <main class="app-content">
    <div class="app-title">
        <div class="tile-body">
          <h1><i class="fa fa-th-list"></i> Dominios Comprados</h1>
          <p>Lista de todos los dominios comprados</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Tables</li>
          <li class="breadcrumb-item active"><a href="#">Data Table</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <a href="{{ url('dashboard/dominios-comprados/crear') }}" class="btn btn-primary">Comprar un dominio</a>
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
              <table class="table table-hover table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Proveedor de Dominio</th>
                    <th scope="col">Nombre de Dominio</th>
                    <th scope="col">Fecha de Vencimiento</th>
                    <th scope="col">Precio de Compra</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                @foreach($purchasedDomains as $purchasedDomain)
                  <tr>
                    <td></td>
                    <td>{{ $purchasedDomain->domainProvider->company_name }}</td>
                    <td>{{ $purchasedDomain->domain_name }}</td>
                    <td>{{ $purchasedDomain->due_date }}</td>
                    <td>$ {{ $purchasedDomain->total_price_in_dollars }}</td>
                    <td>
                      <a href="#" class="btn btn-success w-100">VER</a>
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

@endpush