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
      $purchasedDomains = PurchasedDomain::with('domainProvider:id,company_name')->get();
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
      $request->validate([
        'domain_provider_id' => 'required|exists:domain_providers,id',
        'domain_name' => 'required|url|unique:purchased_domains,domain_name',
        'start_date' => 'required|date',
        'due_date' => 'required|date',
        'total_price_in_dollars' => 'required|numeric',
        'description' => ''
      ]);  
      
      $purchasedDomain = new PurchasedDomain();
      
      if (!$purchasedDomain->validateDates($request->start_date, $request->due_date)) {
        return back()->with('status', 'Error al registrar. La fecha de vencimiento no puede ser menor a la fecha de compra.');
      }

      $purchasedDomain->domain_provider_id = $request->domain_provider_id;
      $purchasedDomain->domain_name = $request->domain_name;
      $purchasedDomain->start_date = $request->start_date;
      $purchasedDomain->due_date = $request->due_date;
      $purchasedDomain->total_price_in_dollars = $request->total_price_in_dollars;
      $purchasedDomain->description = $purchasedDomain->description;
      $purchasedDomain->status = 'activo';
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
