<?php

namespace App\Http\Controllers\Admin;

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
      $purchasedDomains = 
      PurchasedDomain::where('active', 1)->with([
      'acquiredDomain:id,domain_name', 'domainProvider:id,company_name',
      'customer:id,first_name,last_name,company_name'])->get();             
      return 
        view('admin.purchased-domains.index')->with('purchasedDomains', $purchasedDomains);
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
        'acquiredDomain.domain_name' => 'required|unique:acquired_domains,domain_name',
        'acquiredDomain.description' => 'nullable',
        'user_id' => 'required|exists:users,id'
      ]);  
      
      $acquiredDomain = new AcquiredDomain();
      $acquiredDomain->domain_name = $request->acquiredDomain['domain_name'];
      $acquiredDomain->description = $request->acquiredDomain['description'];
      $acquiredDomain->save();
      $purchasedDomain = new PurchasedDomain();
      $purchasedDomain->acquired_domain_id = $acquiredDomain->id;
      $purchasedDomain->domain_provider_id = $request->domain_provider_id;
      $purchasedDomain->customer_id = $request->customer_id;
      $purchasedDomain->start_date = $request->start_date;
      $purchasedDomain->finish_date = $request->finish_date;
      $purchasedDomain->total_price_in_dollars = $request->total_price_in_dollars;
      $purchasedDomain->status = 'active';
      $purchasedDomain->active = 1;
      $purchasedDomain->user_id = $request->user_id;
      
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
       return view('admin.purchased-domains.show')->with('purchasedDomain', PurchasedDomain::findOrFail($id));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function renovate(Request $request, $id) 
    {
      $request->validate([
        'acquired_domain_id' => 'required|exists:acquired_domains,id',
        'domain_provider_id' => 'required|exists:domain_providers,id',
        'customer_id' => 'required|exists:customers,id',
        'start_date' => 'required|date',
        'finish_date' => 'required|date|after:start_date',
        'total_price_in_dollars' => 'required|numeric',
        'user_id' => 'required|exists:users,id'
      ]);  
      
      $purchasedDomain = PurchasedDomain::findOrFail($id);
      $purchasedDomain->active = 0;
      $purchasedDomain->save();

      $newPurchasedDomain = new PurchasedDomain();
      $newPurchasedDomain->acquired_domain_id = $request->acquired_domain_id;
      $newPurchasedDomain->domain_provider_id = $request->domain_provider_id;
      $newPurchasedDomain->customer_id = $request->customer_id;
      $newPurchasedDomain->start_date = $request->start_date;
      $newPurchasedDomain->finish_date = $request->finish_date;
      $newPurchasedDomain->total_price_in_dollars = $request->total_price_in_dollars;
      $newPurchasedDomain->active = 1;
      $newPurchasedDomain->user_id = $request->user_id;
      
      if ( $newPurchasedDomain->save() ) {
        return back()->with('status', 'La compra de dominio fue renovada con éxito');
      }
    }
}
