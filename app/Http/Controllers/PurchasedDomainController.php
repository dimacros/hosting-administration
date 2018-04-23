<?php

namespace App\Http\Controllers;

use App\{AcquiredDomain, Customer, DomainProvider, PurchasedDomain};
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
      $purchasedDomains = PurchasedDomain::with(['domainProvider:id,company_name','customer:id,first_name,last_name,company_name'])
      ->where('is_active', 1)->paginate(15);             
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
        'domain_provider_id' => 'required|exists:domain_providers,id',
        'customer_id' => 'required|exists:customers,id',
        'start_date' => 'required|date',
        'finish_date' => 'required|date|after:start_date',
        'total_price_in_dollars' => 'required|numeric',
        'acquiredDomain.domain_name' => 'required|unique:acquired_domains,domain_name|url',
        'acquiredDomain.description' => 'nullable'
      ]);

      $acquiredDomain = new AcquiredDomain();
      $acquiredDomain->domain_name = $request->acquiredDomain['domain_name'];
      $acquiredDomain->description = $request->acquiredDomain['description'];
      $acquiredDomainIsSaved = $acquiredDomain->save();
      $purchasedDomain = new PurchasedDomain();
      $purchasedDomain->acquired_domain_id = $acquiredDomain->id;
      $purchasedDomain->domain_provider_id = $request->domain_provider_id;
      $purchasedDomain->customer_id = $request->customer_id;
      $purchasedDomain->start_date = $request->start_date;
      $purchasedDomain->finish_date = $request->finish_date;
      $purchasedDomain->total_price_in_dollars = $request->total_price_in_dollars;
      $purchasedDomain->status = 'active';
      $purchasedDomain->active = 1;
      $purchasedDomain->user_id = $request->user()->id;
      
      if ( $acquiredDomainIsSaved && $purchasedDomain->save() ) {
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
      ->with('purchasedDomain', PurchasedDomain::findOrFail($id) )
      ->with('domainProviders', DomainProvider::all('id', 'company_name') )
      ->with('customers', Customer::all('id', 'first_name', 'last_name', 'company_name') );
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
        'domain_provider_id' => 'required|exists:domain_providers,id',
        'customer_id' => 'required|exists:customers,id',
        'start_date' => 'required|date',
        'finish_date' => 'required|date|after:start_date',
        'total_price_in_dollars' => 'required|numeric',
        'acquiredDomain.id' => 'required|exists:acquired_domains,id',
        'acquiredDomain.domain_name' => 'bail|required|url|
          unique:acquired_domains,domain_name,'.$request->acquiredDomain['id'],
        'acquiredDomain.description' => 'nullable'
      ]);  

      $acquiredDomain = AcquiredDomain::findOrFail($request->acquiredDomain['id']);
      $acquiredDomain->domain_name = $request->acquiredDomain['domain_name'];
      $acquiredDomain->description = $request->acquiredDomain['description'];
      $purchasedDomain = PurchasedDomain::findOrFail($id);
      $purchasedDomain->domain_provider_id = $request->domain_provider_id;
      $purchasedDomain->customer_id = $request->customer_id;
      $purchasedDomain->start_date = $request->start_date;
      $purchasedDomain->finish_date = $request->finish_date;
      $purchasedDomain->total_price_in_dollars = $request->total_price_in_dollars;
      $purchasedDomain->user_id = $request->user()->id;
      
      if ( $acquiredDomain->save() && $purchasedDomain->save() ) {
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

    public function renovate(Request $request, $id) 
    {
      $request->validate([
        'start_date' => 'required|date',
        'finish_date' => 'required|date|after:start_date',
        'total_price_in_dollars' => 'required|numeric',
        'user_id' => 'required|exists:users,id'
      ]);  
      
      $oldPurchasedDomain = PurchasedDomain::findOrFail($id);
      $oldPurchasedDomain->active = 0;
      $oldPurchasedDomainIsSaved = $oldPurchasedDomain->save();

      $purchasedDomain = new PurchasedDomain();
      $purchasedDomain->domain_provider_id = $oldPurchasedDomain->domainProvider->id;
      $purchasedDomain->acquired_domain_id = $oldPurchasedDomain->acquiredDomain->id;
      $purchasedDomain->customer_id = $oldPurchasedDomain->customer->id; 
      $purchasedDomain->start_date = $request->start_date;
      $purchasedDomain->finish_date = $request->finish_date;
      $purchasedDomain->total_price_in_dollars = $request->total_price_in_dollars;
      $purchasedDomain->active = 1;
      $purchasedDomain->user_id = $request->user_id;
      $purchasedDomainIsSaved = $purchasedDomain->save();

      if ( $oldPurchasedDomainIsSaved && $purchasedDomainIsSaved ) {
        return back()->with('status', 'La compra de dominio fue renovada con éxito');
      }
    }
}
