<?php

namespace App\Http\Controllers;

use App\{Customer, DomainProvider, PurchasedDomain};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurchasedDomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $purchasedDomains = PurchasedDomain::with(['domainProvider:id,company_name','customer:id,first_name,last_name,company_name'])->where('is_active', 1)->paginate(15);             
      return view('admin.purchased-domains.index')->with('purchasedDomains', $purchasedDomains);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.purchased-domains.create')
      ->with('domainProviders', DomainProvider::all('id', 'company_name') )
      ->with('customers', Customer::all('id', 'first_name', 'last_name', 'company_name') ); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'domain_provider_id' => 'required|exists:domain_providers,id',
        'start_date' => 'required|date',
        'finish_date' => 'required|date|after:start_date',
        'total_price_in_dollars' => 'required|numeric',
        'domain_name' => 'bail|required|url|unique:purchased_domains,domain_name',
        'domain_description' => 'nullable'
      ]);
      
      $purchasedDomain = new PurchasedDomain();
      $purchasedDomain->domain_provider_id = $request->domain_provider_id;
      $purchasedDomain->customer_id = $request->customer_id;
      $purchasedDomain->start_date = $request->start_date;
      $purchasedDomain->finish_date = $request->finish_date;
      $purchasedDomain->total_price_in_dollars = $request->total_price_in_dollars;
      $purchasedDomain->domain_name = $request->domain_name;
      $purchasedDomain->domain_description = $request->domain_description;
      $purchasedDomain->status = 'active';
      $purchasedDomain->is_active = 1;
      $purchasedDomain->user_id = $request->user()->id;
      
      if ( $purchasedDomain->save() ) {
        return back()->with('status', 'La compra de dominio fue registrada con éxito');
      }
    }

    public function renovate(Request $request) {

      $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'domain_provider_id' => 'required|exists:domain_providers,id',
        'start_date' => 'required|date',
        'finish_date' => 'required|date|after:start_date',
        'total_price_in_dollars' => 'required|numeric'
      ]);

      $customer = Customer::find($request->customer_id);
      if( !$customer->hasPurchasedDomains() ) {
        return back()->withErrors(['No existe ninguna compra registrada con ese cliente.']);
      }  

      $latestDomainPurchase = PurchasedDomain::where('customer_id', $customer->id)->latest()->first();
      $latestDomainPurchase->is_active = 0;
      $latestDomainPurchase->save();

      $purchasedDomain = new PurchasedDomain();
      $purchasedDomain->domain_provider_id = $request->domain_provider_id;
      $purchasedDomain->customer_id = $request->customer_id;
      $purchasedDomain->start_date = $request->start_date;
      $purchasedDomain->finish_date = $request->finish_date;
      $purchasedDomain->total_price_in_dollars = $request->total_price_in_dollars;
      $purchasedDomain->domain_name = $latestDomainPurchase->domain_name;
      $purchasedDomain->domain_description = $latestDomainPurchase->domain_description;
      $purchasedDomain->status = 'active';
      $purchasedDomain->is_active = 1;
      $purchasedDomain->user_id = $request->user()->id;
      
      if ( $purchasedDomain->save() ) {
        return back()->with('status', 'La compra de dominio fue registrada con éxito');
      }

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $purchasedDomain = PurchasedDomain::findOrFail($id);
      return view('admin.purchased-domains.show')->with('purchasedDomain', $purchasedDomain);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      return view('admin.purchased-domains.edit')
      ->with('customers', Customer::all('id', 'first_name', 'last_name', 'company_name') )
      ->with('domainProviders', DomainProvider::all('id', 'company_name') )
      ->with('purchasedDomain', PurchasedDomain::findOrFail($id) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'domain_provider_id' => 'required|exists:domain_providers,id',
        'start_date' => 'required|date',
        'finish_date' => 'required|date|after:start_date',
        'total_price_in_dollars' => 'required|numeric',
        'domain_name' => 'required|url',
        'domain_description' => 'nullable'
      ]);  

      $purchasedDomain = PurchasedDomain::find($id);
      $purchasedDomain->customer_id = $request->customer_id;
      $purchasedDomain->domain_provider_id = $request->domain_provider_id;
      $purchasedDomain->start_date = $request->start_date;
      $purchasedDomain->finish_date = $request->finish_date;
      $purchasedDomain->total_price_in_dollars = $request->total_price_in_dollars;
      $purchasedDomain->domain_name = $request->domain_name;
      $purchasedDomain->domain_description = $request->domain_description;
      $purchasedDomain->user_id = $request->user()->id;
      
      if ( $purchasedDomain->save() ) {
        return back()->with('status', 'Se actualizó con éxito los nuevos datos de la compra de dominio.');
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $purchasedDomain = PurchasedDomain::findOrFail($id);
      $purchasedDomain->status = 'suspended';
      if( $purchasedDomain->save() ) {
        return back()->with('status', 'El dominio del cliente "'.$purchasedDomain->customer->full_name.'" fue suspendido con éxito');
      }
    }
}
