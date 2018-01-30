<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DomainProvider;

class DomainProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $domainProviders = App\DomainProvider::all();
        return view('dashboard.domain-providers', ['domainProviders' => $domainProviders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.domain-providers-create');
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
        'company_name' => 'required|string',
        'description' => 'required|string',
        'phone' => 'required|string|unique:domain_providers',
        'email' => 'required|string|email|unique:domain_providers'
      ]);  
      
      $domainProvider = new DomainProvider();
      $domainProvider->company_name = $request->company_name;
      $domainProvider->description = $request->description;
      $domainProvider->phone = $request->phone;
      $domainProvider->email = $request->email;

      if ($domainProvider->save()) {
        return back()->with('status', 'El cliente fue registrado correctamente.');
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $request->validate([
        'company_name' => 'required|string',
        'description' => 'required|string',
        'phone' => 'required|string|unique:domain_providers',
        'email' => 'required|string|email|unique:domain_providers'
      ]);  

      if (is_null(DomainProvider::find($id))) {
        return redirect('dashboard/domain-providers');
      }

      $domainProvider = DomainProvider::find($id);
      $domainProvider->company_name = $request->company_name;
      $domainProvider->description = $request->description;
      $domainProvider->phone = $request->phone;
      $domainProvider->email = $request->email;

      if ($domainProvider->save()) {
        return back()->with('status', 'Los datos del cliente fueron actualizados correctamente.');
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
        
        if(DomainProvider::find($id)->delete())
        {
            return back()->with('status', 'El cliente se elimino correctamente.');          
        }
        else {
            return back()->with('status', 'Ocurrió un problema al tratar de eliminar el cliente. Vuelva a intentarlo nuevamente.');     
        }
    }
}
