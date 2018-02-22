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

  Route::get('dominios-comprados', 'PurchasedDomainController@index');
	Route::get('dominios-comprados/crear', 'PurchasedDomainController@create');
	Route::post('dominios-comprados/crear', 'PurchasedDomainController@store');
	Route::put('dominios-comprados/{id}', 'PurchasedDomainController@update')
	->name('admin.dominios-comprados.actualizar');

	Route::put('cuentas-cpanel/{id}', function(Request $request, $id) { 
	
  	$request->validate([
    	'domain_name' => 'required|url|unique:cpanel_accounts,domain_name,'.$id,
    	'user' => 'required|unique:cpanel_accounts,user,'.$id,
    	'password' => 'nullable',
    	'public_ip' => 'nullable|ip'
   	]);  

  	$cpanelAccount = App\CpanelAccount::findOrFail($id);
  	$cpanelAccount->domain_name = $request->domain_name;
  	$cpanelAccount->user = $request->user;
  	$cpanelAccount->password = $request->password;
  	$cpanelAccount->public_ip = $request->public_ip;

  	if ( $cpanelAccount->save() ) {
    	return back()->with('status', 
    		'Los datos de la cuenta cPanel fueron actualizados con éxito.'
    	);
  	}

	})->name('admin.cuentas-cpanel.actualizar');	

	Route::post('renovar-dominio', function(Request $request) {

		$request->validate([
			'purchased_domain_id' => 'required|exists:purchased_domains,id',
			'start_date' => 'required|date', 
			'finish_date' => 'required|date|after:start_date',
			'total_price_in_dollars' => 'required|numeric'
		]);

		$renewedDomain = new App\RenewedDomain();
		$renewedDomain->purchased_domain_id = $request->purchased_domain_id;
		$renewedDomain->start_date = $request->start_date;
		$renewedDomain->finish_date = $request->finish_date;
		$renewedDomain->total_price_in_dollars = $request->total_price_in_dollars;
		$renewedDomain->user_id = $request->user_id;

		$purchasedDomain = App\PurchasedDomain::findOrFail($request->purchased_domain_id);
		if ($purchasedDomain->status === 'expired') {
			$purchasedDomain->status = 'active';
			$purchasedDomain->save();
		}

		if ( $renewedDomain->save() ) {
			return back()->with('status', 'La renovación del dominio fue registrada con éxito.');
		} 

	})->name('admin.renovar-dominio');	
	
});
