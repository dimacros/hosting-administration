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
Route::get('/test', function () {
  $SendingEmails = new App\Jobs\SendingEmails();
  $SendingEmails->handle();
   print 'Enviado';
});

Route::get('/mail', function () {
  $hostingContract = App\HostingContract::find(1);
  $purchasedDomain = App\PurchasedDomain::find(2);

  //return view('emails.billing');
  return view('emails.renew-contract', ['hostingContract' => $hostingContract]);
  return view('emails.renew-domain', ['purchasedDomain' => $purchasedDomain]);
});

Auth::routes();

Route::group([
		'as' => 'admin.', 'middleware' => ['auth', 'admin'], 'prefix' => 'dashboard',
	], function () {

  Route::get('admin', function(){

    $between_dates = [
      Carbon\Carbon::today()->toDateString(), 
      Carbon\Carbon::today()->addMonths(2)->toDateString()
    ];

    $data = [
      'hostingContracts' => App\HostingContract::whereBetween('finish_date', $between_dates)->get(),
      'tickets' => App\Ticket::where('solved', 0)->get(),
      'users' =>  App\User::where('active', 0)->get()
    ];     
           
    return view('admin.user', $data);

  })->name('user');

  Route::resource('clientes', 'CustomerController', 
  	array( 'except' => ['show', 'edit'], 'parameters' => ['clientes' => 'id'] )
  );
  
  Route::resource('cuentas-cpanel', 'CpanelAccountController', 
    array( 'only' => ['store', 'update'], 'parameters' => ['cuentas-cpanel' => 'id'] )
  );

  Route::get('contratos-hosting/por-expirar', 'HostingContractController@toExpire')->name('contratos-hosting.to-expire');

  Route::put('contratos-hosting/{id}/notificar', 'HostingContractController@notify')
  ->name('contratos-hosting.notify');

  Route::put('contratos-hosting/{id}/desactivar', 'HostingContractController@deactivate')
  ->name('contratos-hosting.deactivate');

  Route::resource('contratos-hosting', 'HostingContractController', 
    array( 'parameters' => ['contratos-hosting' => 'id'] )
  );

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

  Route::put('usuarios/{id}/activate', 'UserController@activate')->name('usuarios.activate');
  Route::resource('usuarios', 'UserController', 
    array( 'except' => ['create', 'edit'], 'parameters' => ['usuarios' => 'id'] )
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