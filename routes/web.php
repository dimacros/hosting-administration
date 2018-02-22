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
		'namespace' => 'Admin', 
		'middleware' => ['auth'], 
		'prefix' => 'dashboard',
	], function () {

  Route::view('user', 'admin.user');
  
  Route::get('clientes', 'CustomerController@index');
	Route::get('clientes/crear', 'CustomerController@create');
	Route::post('clientes/crear', 'CustomerController@store');
	Route::put('clientes/{id}', 'CustomerController@update')
	->name('admin.clientes.actualizar');
	Route::delete('clientes/{id}', 'CustomerController@destroy')
	->name('admin.clientes.eliminar');

  Route::get('proveedores-de-dominios', 
  	'DomainProviderController@index');
	Route::get('proveedores-de-dominios/crear', 
		'DomainProviderController@create');
	Route::post('proveedores-de-dominios/crear', 
		'DomainProviderController@store');
	Route::put('proveedores-de-dominios/{id}', 
		'DomainProviderController@update')->name('admin.proveedores-de-dominios.actualizar');
	Route::delete('proveedores-de-dominios/{id}', 
		'DomainProviderController@destroy')->name('admin.proveedores-de-dominios.eliminar');

  Route::get('planes-hosting', 'HostingPlanController@index');
	Route::get('planes-hosting/crear', 'HostingPlanController@create');
	Route::post('planes-hosting/crear', 'HostingPlanController@store');
	Route::put('planes-hosting/{id}', 'HostingPlanController@update')
	->name('admin.planes-hosting.actualizar');
	Route::delete('planes-hosting/{id}', 'HostingPlanController@destroy')
	->name('admin.planes-hosting.eliminar');

  Route::get('contratos-hosting', 'HostingContractController@index');
	Route::get('contratos-hosting/crear', 'HostingContractController@create');
	Route::post('contratos-hosting/crear', 'HostingContractController@store');
	Route::put('contratos-hosting/{id}', 'HostingContractController@update')
	->name('admin.contratos-hosting.actualizar');
	Route::post('contratos-hosting/renovar', 'HostingContractController@renovate')
	->name('admin.contratos-hosting.renovar');
	Route::put('cuentas-cpanel/{id}', 'HostingContractController@cpanelAccountUpdate')
	->name('admin.cuentas-cpanel.actualizar');	



  Route::get('dominios-comprados', 'PurchasedDomainController@index');
	Route::get('dominios-comprados/crear', 'PurchasedDomainController@create');
	Route::post('dominios-comprados/crear', 'PurchasedDomainController@store');
	Route::put('dominios-comprados/{id}', 'PurchasedDomainController@update')
	->name('admin.dominios-comprados.actualizar');
	Route::post('dominios-comprados/renovar', 'PurchasedDomainController@renovate')
	->name('admin.dominios-comprados.renovar');
	
});
