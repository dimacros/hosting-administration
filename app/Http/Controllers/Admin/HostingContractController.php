<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HostingContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hostingContracts = HostingContract::paginate(6);
        return view('admin.hosting-contracts.all', ['hostingContracts' => $hostingContracts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.hosting-contracts.create');
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
        'customer_id' => 'required|integer',
        'hosting_plan_contracted_id' => 'required|integer',
        'start_date' => 'required',
        'due_date' => '',
        'public_ip' => 'required|ipv4',
        'cpanel_user' => 'required|unique:hosting_contracts',
        'cpanel_password' => '',
        'domain_name' => 'required|unique:hosting_contracts',
        'user_id' => 'required|integer'
      ]);  
      
      $hostingContract = new HostingContract();
      $hostingContract->customer_id = $request->customer_id;
      $hostingContract->hosting_plan_contracted_id = $request->hosting_plan_contracted_id;
      $hostingContract->start_date = $request->start_date;
      $hostingContract->due_date = $request->due_date;
      $hostingContract->public_ip = $request->public_ip;
      $hostingContract->cpanel_user = $request->cpanel_user;
      $hostingContract->cpanel_password = $request->cpanel_password;
      $hostingContract->domain_name = $request->domain_name;
      $hostingContract->user_id = $request->user_id;

      if ($hostingContract->save()) {
        return back()->with('status', 'El contrato de hosting fue registrado con éxito.');
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
      $request->validate([
        'company_name' => 'required|string',
        'description' => 'required|string',
        'email' => 'required|string|email|unique:domain_providers'
      ]);  

      if (is_null(HostingContract::find($id))) {
        return redirect('dashboard/domain-providers');
      }

      $hostingContract = HostingContract::find($id);
      //$hostingContract->customer_id = $request->customer_id;
      $hostingContract->hosting_plan_contracted_id = $request->hosting_plan_contracted_id;
      //$hostingContract->start_date = $request->start_date;
      $hostingContract->due_date = $request->due_date;
      $hostingContract->public_ip = $request->public_ip;
      $hostingContract->cpanel_user = $request->cpanel_user;
      $hostingContract->cpanel_password = $request->cpanel_password;
      $hostingContract->domain_name = $request->domain_name;
      $hostingContract->user_id = $request->user_id;

      if ($hostingContract->save()) {
        return back()->with('status', 'Los datos del proveedor de dominio fueron actualizados correctamente.');
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
        if(HostingContract::find($id)->delete())
        {
            return back()->with('status', 'El cliente se elimino correctamente.');          
        }
        else {
            return back()->with('status', 'Ocurrió un problema al tratar de eliminar el cliente. Vuelva a intentarlo nuevamente.');     
        }
    }
}
