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
		'as' => 'admin.', 'namespace' => 'Admin', 
		'middleware' => ['auth', 'admin'], 'prefix' => 'dashboard',
	], function () {

  Route::view('admin', 'admin.user')->name('user');

  Route::resource('clientes', 'CustomerController', 
  	array( 'except' => ['show', 'edit'], 'parameters' => ['clientes' => 'id'] )
  );

  Route::post('contratos-hosting/renovar/{id}', 'HostingContractController@renovate')
  ->name('contratos-hosting.renovar');
  Route::put('cuentas-cpanel/{id}', 'HostingContractController@cpanelAccountUpdate')
  ->name('cuentas-cpanel.actualizar');  

  Route::resource('contratos-hosting', 'HostingContractController', 
    array( 'parameters' => ['contratos-hosting' => 'id'] )
  );

  Route::post('dominios-comprados/renovar/{id}', 'PurchasedDomainController@renovate')
  ->name('dominios-comprados.renovar');

  Route::resource('dominios-comprados', 'PurchasedDomainController', 
    array( 'parameters' => ['dominios-comprados' => 'id'] )
  );

  Route::resource('planes-hosting', 'HostingPlanController', 
    array( 'except' => ['show', 'edit'], 'parameters' => ['planes-hosting' => 'id'] )
  );

  Route::resource('proveedores-de-dominios', 'DomainProviderController', 
  	array( 'except' => ['show', 'edit'], 'parameters' => ['proveedores-de-dominios' => 'id'] )
  );

  Route::resource('respuesta', 'ReplyController',
    array( 'only' => ['store'], 'parameters' => ['tickets' => 'id'] )
  );

  Route::resource('temas-de-ayuda', 'HelpTopicController',
    array( 'except' => ['create', 'show', 'edit'], 'parameters' => ['temas-de-ayuda' => 'id'] )
  );

  Route::get('tickets/{status}', 'TicketController@indexByStatus')
  ->where('status', 'open|closed');

  Route::resource('tickets', 'TicketController',
    array( 'only' => ['show', 'destroy'], 'parameters' => ['tickets' => 'id'] )
  );

});

Route::group([
    'as' => 'customer.', 'namespace' => 'Customer', 
    'middleware' => ['auth', 'customer'], 'prefix' => 'dashboard',
  ], function () {

  Route::view('user', 'customer.user')->name('user');
});
