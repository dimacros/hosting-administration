<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mailable', function () {
	$HostingContract = App\HostingContract::find(1);
	return new App\Mail\ContractRenewalHosting($HostingContract);
});

Route::get('/mailable-basic', function () {
  return view('emails.action');
});

Auth::routes();

Route::group([
		'as' => 'admin.', 'middleware' => ['auth', 'admin'], 'prefix' => 'dashboard',
	], function () {

  Route::view('admin', 'admin.user')->name('user');

  Route::resource('clientes', 'CustomerController', 
  	array( 'except' => ['show', 'edit'], 'parameters' => ['clientes' => 'id'] )
  );
  
  Route::resource('cuentas-cpanel', 'CpanelAccountController', 
    array( 'only' => ['store', 'update'], 'parameters' => ['cuentas-cpanel' => 'id'] )
  );

  Route::put('contratos-hosting/{id}/desactivar', 'HostingContractController@deactivate')
  ->name('contratos-hosting.deactivate');

  Route::resource('contratos-hosting', 'HostingContractController', 
    array( 'parameters' => ['contratos-hosting' => 'id'] )
  );

  Route::get('/contratos-hosting-prontos-a-expirar', function () {
    $start_date = Carbon\Carbon::now()->startOfDay();  
    $finish_date = $start_date->copy()->addMonth(); 
    $hostingContracts = App\HostingContract::whereBetween('finish_date', [$start_date->toDateString(), $finish_date->toDateString()])->get();
    return view('admin.hosting-contracts.ready-to-expire', ['hostingContracts' => $hostingContracts]);
  });

  Route::post('dominios-comprados/renovar-dominio', 'PurchasedDomainController@renovate')
  ->name('dominios-comprados.renovate');

  Route::resource('dominios-comprados', 'PurchasedDomainController', 
    array( 'parameters' => ['dominios-comprados' => 'id'] )
  );

  Route::resource('planes-hosting', 'HostingPlanController', 
    array( 'except' => ['show', 'edit'], 'parameters' => ['planes-hosting' => 'id'] )
  );

  Route::resource('proveedores-de-dominios', 'DomainProviderController', 
  	array( 'except' => ['show', 'edit'], 'parameters' => ['proveedores-de-dominios' => 'id'] )
  );

  Route::resource('temas-de-ayuda', 'HelpTopicController',
    array( 'except' => ['create', 'show', 'edit'], 'parameters' => ['temas-de-ayuda' => 'id'] )
  );

  Route::get('tickets/{status}', 'TicketController@indexByStatus')
  ->where('status', 'open|closed');

  Route::resource('tickets', 'TicketController',
    array( 'only' => ['destroy'], 'parameters' => ['tickets' => 'id'] )
  );

});

Route::group([
    'as' => 'customer.', 'namespace' => 'Customer', 
    'middleware' => ['auth', 'customer'], 'prefix' => 'dashboard',
  ], function () {

  Route::view('user', 'customer.user')->name('user');
  Route::get('tickets/crear', 'TicketController@create')->name('tickets.create');
  Route::post('tickets/store', 'TicketController@store')->name('tickets.store');
  Route::get('tickets/mis-tickets', 'TicketController@indexForCustomer')->name('tickets.indexForCustomer');
  Route::get('contratos-hosting/mis-contratos-hosting', 'HostingContractController@indexForCustomer');
});

Route::group([
    'as' => 'auth.', 'namespace' => 'Auth', 
    'middleware' => ['auth'], 'prefix' => 'dashboard',
  ], function () {

  Route::get('tickets/{id}', 'TicketController@show')->name('tickets.show');
  Route::post('reply/store', 'ReplyController@store')->name('reply.store');
  Route::post('reply/storeFiles', 'ReplyController@storeFiles')->name('reply.storeFiles');

});