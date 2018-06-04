<?php

namespace App\Http\Controllers;

use App\CpanelAccount;
use Illuminate\Http\Request;

class CpanelAccountController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
          'cpanel_customer_id' => 'required|exists:customers,id',
          'cpanel_domain_name' => 'required|unique:cpanel_accounts,domain_name',
          'cpanel_user' => 'required|unique:cpanel_accounts,user',
          'cpanel_public_ip' => 'nullable|ip'
        ]);

        $cpanelAccount = new CpanelAccount();
        $cpanelAccount->customer_id = $request->cpanel_customer_id;
        $cpanelAccount->domain_name = $request->cpanel_domain_name;
        $cpanelAccount->user = $request->cpanel_user;
        $cpanelAccount->password = $request->cpanel_password;
        $cpanelAccount->public_ip = $request->cpanel_public_ip;

        if( $cpanelAccount->save() ) {
          return response()->json(['success' => true, 'message' => 'La cuenta cPanel fue registrada exitosamente.'] ,200);
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
        'domain_name' => 'required|unique:cpanel_accounts,domain_name,'.$id,
        'user' => 'required|unique:cpanel_accounts,user,'.$id,
        'password' => 'nullable',
        'public_ip' => 'nullable|ip'
      ]);  

      $cpanelAccount = CpanelAccount::find($id);
      $cpanelAccount->domain_name = $request->domain_name;
      $cpanelAccount->user = $request->user;
      $cpanelAccount->password = $request->password;
      $cpanelAccount->public_ip = $request->public_ip;

      if ( $cpanelAccount->save() ) {
        return back()->with('status', 'Los datos de la cuenta cPanel fueron actualizados con éxito.'
        );
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
        //
    }
}
