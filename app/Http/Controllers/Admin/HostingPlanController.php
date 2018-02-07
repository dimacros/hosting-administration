<?php

namespace App\Http\Controllers\Admin;

use App\HostingPlan;
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
      return view('admin.hosting-plans', ['hostingPlans' => HostingPlan::All()]);       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.hosting-plans-create'); 
    }
   
    public function store(Request $request)
    {
      $request->validate([
        'title' => 'required|unique:hosting_plans,title',
        'description' => 'required|string',
        'total_price' => 'required|numeric',
      ]);  
      
      $hostingPlan = new HostingPlan();
      $hostingPlan->title = $request->title;
      $hostingPlan->description = $request->description;
      $hostingPlan->total_price = $request->total_price;

      if ($hostingPlan->save()) {
        return back()->with('status', 'El Plan Hosting "'.$hostingPlan->title.'" fue registrado exitosamente.');
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
        'title' => 'required|unique:hosting_plans,title,'.$id,
        'description' => 'required|string',
        'total_price' => 'required|numeric',
      ]);  

      $hostingPlan = HostingPlan::findOrFail($id);
      $hostingPlan->title = $request->title;
      $hostingPlan->description = $request->description;
      $hostingPlan->total_price = $request->total_price;

      if ($hostingPlan->save()) {
        return back()->with('status', 'Se actualizó correctamente los nuevos datos de "'.$hostingPlan->title.'"');
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
          return back()->with('status', 'El plan hosting fue eliminado exitosamente.');
        }
    }
}
