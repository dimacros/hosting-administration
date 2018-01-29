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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(
[
	'namespace' => 'Admin', 
	'middleware' => 'auth',
	'prefix' => 'dashboard',
], 

function () {

  Route::view('admin', 'dashboard.admin');
  Route::get('clientes', 'CustomerController@index');
	Route::get('clientes/crear', 'CustomerController@create');
	Route::post('clientes/crear', 'CustomerController@store');
	Route::put('clientes/{id}', 'CustomerController@update');
	Route::delete('clientes/{id}', 'CustomerController@destroy');

  Route::get('proveedores-de-dominios', 
  	'DomainProviderController@index');
	Route::get('proveedores-de-dominios/crear', 
		'DomainProviderController@create');
	Route::post('proveedores-de-dominios/crear', 
		'DomainProviderController@store');
	Route::put('proveedores-de-dominios/{id}', 
		'DomainProviderController@update');
	Route::delete('proveedores-de-dominios/{id}', 
		'DomainProviderController@destroy');

  Route::get('contratos-hosting', 'HostingContractController@index');
	Route::get('contratos-hosting/crear', 'HostingContractController@create');
	Route::post('contratos-hosting/crear', 'HostingContractController@store');
	Route::put('contratos-hosting/{id}', 'HostingContractController@update');
	Route::delete('contratos-hosting/{id}', 'HostingContractController@destroy');

  Route::get('planes-hosting', 'HostingPlanController@index');
	Route::get('planes-hosting/crear', 'HostingPlanController@create');
	Route::post('planes-hosting/crear', 'HostingPlanController@store');
	Route::put('planes-hosting/{id}', 'HostingPlanController@update');
	Route::delete('planes-hosting/{id}', 'HostingPlanController@destroy');

  Route::get('dominios-comprados', 'PurchasedDomainController@index');
	Route::get('dominios-comprados/crear', 'PurchasedDomainController@create');
	Route::post('dominios-comprados/crear', 'PurchasedDomainController@store');
	Route::put('dominios-comprados/{id}', 'PurchasedDomainController@update');
	Route::delete('dominios-comprados/{id}','PurchasedDomainController@destroy');

});
