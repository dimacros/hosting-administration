<?php

namespace App\Http\Controllers\Admin;

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
        $customers = Customer::all();
        return view('admin.customers', ['customers' => $customers]);
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
        'phone' => 'required|string|unique:customers',
        'email' => 'required|string|email|unique:customers'
      ]);  
      
      $customer = new Customer();
      $customer->first_name = $request->first_name;
      $customer->last_name = $request->last_name;
      $customer->phone = $request->phone;
      $customer->email = $request->email;

      if ($customer->save()) {
        return back()->with('status', 'El cliente fue registrado con éxito.');
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
        'phone' => 'required|string',
        'email' => 'required|string|email'
      ]);  

      $customer = Customer::find($id);
      $customer->first_name = $request->first_name;
      $customer->last_name = $request->last_name;
      $customer->phone = $request->phone;
      $customer->email = $request->email;

      if ($customer->save()) {
        return back()->with('status', 'Los datos del cliente '.$customer->getFullname().' fueron actualizados correctamente.');
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
        if(Customer::find($id)->delete())
        {
          return back()->with('status', 'El cliente fue eliminado exitosamente.');
        }
    }
}
