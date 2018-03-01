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

Route::get('/mailable-2', function () {
	$PurchasedDomain = App\PurchasedDomain::find(1);
	return new App\Mail\DomainRenewal($PurchasedDomain);
});

Auth::routes();

Route::group([
		'as' => 'admin.', 'namespace' => 'Admin', 
		'middleware' => ['auth'], 'prefix' => 'dashboard',
	], function () {

  Route::view('user', 'admin.user');

  Route::resource('clientes', 'CustomerController', 
  	array( 'except' => ['show', 'edit'], 'parameters' => ['clientes' => 'id'] )
  );

  Route::resource('proveedores-de-dominios', 'DomainProviderController', 
  	array( 'except' => ['show', 'edit'], 'parameters' => ['proveedores-de-dominios' => 'id'] )
  );

  Route::resource('planes-hosting', 'HostingPlanController', 
  	array( 'except' => ['show', 'edit'], 'parameters' => ['planes-hosting' => 'id'] )
  );

	Route::post('dominios-comprados/renovar/{id}', 'PurchasedDomainController@renovate')
	->name('dominios-comprados.renovar');

  Route::resource('dominios-comprados', 'PurchasedDomainController', 
  	array( 'parameters' => ['dominios-comprados' => 'id'] )
  );

	Route::post('contratos-hosting/renovar/{id}', 'HostingContractController@renovate')
	->name('contratos-hosting.renovar');
	Route::put('cuentas-cpanel/{id}', 'HostingContractController@cpanelAccountUpdate')
	->name('cuentas-cpanel.actualizar');	

  Route::resource('contratos-hosting', 'HostingContractController', 
  	array( 'parameters' => ['contratos-hosting' => 'id'] )
  );

});
