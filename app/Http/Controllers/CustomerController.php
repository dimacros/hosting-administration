<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('admin.customers', ['customers' => Customer::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.customers-create');
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
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'phone' => 'max:15',
        'email' => 'required|email|unique:customers,email'
      ]);  
      
      $customer = new Customer();
      $customer->first_name = $request->first_name;
      $customer->last_name = $request->last_name;
      $customer->company_name = $request->company_name;
      $customer->phone = $request->phone??'Sin número';
      $customer->email = $request->email;

      if ($customer->save()) {
        return back()->with('status', 'El cliente "'.$customer->full_name.'" fue registrado con éxito.');
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
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'phone' => 'required|max:15',
        'email' => 'required|email|unique:customers,email,'.$id
      ]);  

      $customer = Customer::findOrFail($id);
      $customer->first_name = $request->first_name;
      $customer->last_name = $request->last_name;
      $customer->company_name = $request->company_name;
      $customer->phone = $request->phone;
      $customer->email = $request->email;

      if ($customer->save()) {
        return back()->with('status', 'Los datos del cliente "'.$customer->full_name.'" se actualizaron con éxito.');
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
        if(Customer::findOrFail($id)->delete())
        {
          return back()->with('status', 'El cliente fue eliminado exitosamente.');
        }
    }
}
