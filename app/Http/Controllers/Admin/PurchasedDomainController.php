<?php

namespace App\Http\Controllers\Admin;

use App\{PurchasedDomain, DomainProvider};
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
      $purchasedDomains = PurchasedDomain::where('status', 'active')
                          ->with('domainProvider:id,company_name')
                          ->take(10)->get();
      return view(
        'admin.purchased-domains.index', ['purchasedDomains' => $purchasedDomains]
      );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      //domainProviders for Autocomplete 
      $domainProviders = DomainProvider::all('company_name as value', 'id as data');
      return view(
        'admin.purchased-domains.create', ['domainProviders' => $domainProviders]
      );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $domainProvider = DomainProvider::firstOrCreate(['company_name' => $request->autocomplete]);

      $request->validate([
        'domain_provider_id' => 'required|exists:domain_providers,id',
        'domain_name' => 'required|url|unique:purchased_domains,domain_name',
        'start_date' => 'required|date',
        'finish_date' => 'required|date|after:start_date',
        'total_price_in_dollars' => 'required|numeric',
        'description' => '',
        'user_id' => 'required|exists:users,id'
      ]);  
      
      $purchasedDomain = new PurchasedDomain();
      $purchasedDomain->domain_provider_id = $request->domain_provider_id;
      $purchasedDomain->domain_name = $request->domain_name;
      $purchasedDomain->start_date = $request->start_date;
      $purchasedDomain->finish_date = $request->finish_date;
      $purchasedDomain->total_price_in_dollars = $request->total_price_in_dollars;
      $purchasedDomain->description = $request->description;
      $purchasedDomain->status = 'active';
      $purchasedDomain->user_id = $request->user_id;

      if ($purchasedDomain->save()) {
        return back()->with('status', 'La compra de dominio fue registrado con éxito');
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
