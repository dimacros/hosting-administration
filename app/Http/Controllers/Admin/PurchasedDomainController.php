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
      PurchasedDomain::with([
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
      $domainProviders = DomainProvider::all('id', 'company_name');
      $customers = Customer::all('id', 'first_name', 'last_name', 'company_name');
      return 
        view('admin.purchased-domains.create')
        ->with('domainProviders', $domainProviders)->with('customers', $customers); 
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
      $acquiredDomain->status = 'active';
      $acquiredDomain->save();
      $purchasedDomain = new PurchasedDomain();
      $purchasedDomain->acquired_domain_id = $acquiredDomain->id;
      $purchasedDomain->domain_provider_id = $request->domain_provider_id;
      $purchasedDomain->customer_id = $request->customer_id;
      $purchasedDomain->start_date = $request->start_date;
      $purchasedDomain->finish_date = $request->finish_date;
      $purchasedDomain->total_price_in_dollars = $request->total_price_in_dollars;
      $purchasedDomain->user_id = $request->user_id;
      
      if ( $purchasedDomain->save() ) {
        return back()->with('status', 'La compra de dominio fue registrada con éxito');
      }
    }

    public function renovate(Request $request) 
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
      
      $purchasedDomain = new PurchasedDomain();
      $purchasedDomain->acquired_domain_id = $request->acquired_domain_id;
      $purchasedDomain->domain_provider_id = $request->domain_provider_id;
      $purchasedDomain->customer_id = $request->customer_id;
      $purchasedDomain->start_date = $request->start_date;
      $purchasedDomain->finish_date = $request->finish_date;
      $purchasedDomain->total_price_in_dollars = $request->total_price_in_dollars;
      $purchasedDomain->user_id = $request->user_id;
      
      if ( $purchasedDomain->save() ) {
        return back()->with('status', 'La compra de dominio fue renovada con éxito');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
}
