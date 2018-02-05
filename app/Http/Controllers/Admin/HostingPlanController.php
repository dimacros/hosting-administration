<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HostingPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('admin.hosting-plans.index', ['hostingPlans' => HostingPlans::All()]);       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.hosting-plans.create'); 
    }
   
    public function store(Request $request)
    {
      $request->validate([
        'title' => 'required|string',
        'description' => 'nullable|string',
        'phone' => 'max:15',
        'email' => 'required|email|unique:customers,email'
      ]);  
      
      $hostingPlan = new HostingPlan();
      $hostingPlan->title = $request->title;
      $hostingPlan->description = $request->description;
      $hostingPlan->phone = $request->phone??'Sin número';
      $hostingPlan->email = $request->email;

      if ($hostingPlan->save()) {
        return back()->with('status', 'El cliente "'.$hostingPlan->getFullname().'" fue registrado exitosamente.');
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
        'title' => 'required|string',
        'description' => 'nullable|string',
        'phone' => 'required|max:15',
        'email' => 'required|email'
      ]);  

      $hostingPlan = HostingPlan::find($id);
      $hostingPlan->title = $request->title;
      $hostingPlan->description = $request->description;
      $hostingPlan->phone = $request->phone;
      $hostingPlan->email = $request->email;

      if ($hostingPlan->save()) {
        return back()->with('status', 'Los datos del cliente "'.$hostingPlan->getFullname().'" se actualizaron con éxito.');
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
        if(HostingPlan::find($id)->delete())
        {
          return back()->with('status', 'El cliente fue eliminado exitosamente.');
        }
    }
}
