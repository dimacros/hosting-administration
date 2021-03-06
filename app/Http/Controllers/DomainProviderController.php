<?php

namespace App\Http\Controllers;

use App\DomainProvider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DomainProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('admin.domain-providers', ['domainProviders' => DomainProvider::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.domain-providers-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if($request->ajax()) {
        $domainProvider = DomainProvider::create(
          ['company_name' => $request->company_name]
        );
        if ( $domainProvider->id ) {
          return response()->json(['success' => true, 'id' => $domainProvider->id, 'company_name' => $domainProvider->company_name]);
        }
      }

      $request->validate([
        'company_name' => 'required|string',
        'description' => 'string|nullable',
        'email' => 'email|nullable'
      ]);  
      
      $domainProvider = new DomainProvider();
      $domainProvider->company_name = $request->company_name;
      $domainProvider->description = $request->description;
      $domainProvider->email = $request->email;

      if ($domainProvider->save()) {
        return back()->with('status', 'El proveedor de dominio fue registrado con éxito.');
      }
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
        'description' => 'string|nullable',
        'email' => 'email|nullable'
      ]);  

      $domainProvider = DomainProvider::findOrFail($id);
      $domainProvider->company_name = $request->company_name;
      $domainProvider->description = $request->description;
      $domainProvider->email = $request->email;

      if ($domainProvider->save()) {
        return back()->with('status', 'Se actualizó con éxito los nuevos datos del proveedor.');
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
      if(DomainProvider::findOrFail($id)->delete())
      {
        return back()->with('status', 'El proveedor de dominio fue eliminado exitosamente.');
      }
    }
}
