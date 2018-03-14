<?php

namespace App\Http\Controllers\Admin;

use App\HelpTopic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HelpTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $helpTopics = HelpTopic::withCount('tickets')->get();
      return view('admin.tickets.help-topics', ['helpTopics' => $helpTopics]);
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
        'title' => 'required|string|unique:help_topics,title',
      ]);  
      
      $helpTopic = new HelpTopic;
      $helpTopic->title = $request->title;

      if ( $helpTopic->save() ) {
        return back()->with('status', 'El tema de ayuda fue registrado con éxito.');
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
        'title' => 'required|string|unique:help_topics,title,'.$id
      ]);  

      $helpTopic = HelpTopic::findOrFail($id);
      $helpTopic->title = $request->title;

      if ( $helpTopic->save() ) {
        return back()->with('status', 'Se actualizó con éxito el tema de ayuda.');
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
      if( HelpTopic::findOrFail($id)->delete() ) {
        return back()->with('status', 'El tema de ayuda fue eliminado exitosamente.');
      }
    }
}
