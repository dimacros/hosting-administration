<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.tickets.index');
    }

  	public function indexByStatus($status_name) 
  	{
  		switch ($status_name) {
  				case 'open':
            $data = [
              'tickets' => Ticket::with('helpTopic:id,title', 'user:id,first_name,last_name')->where('solved', 0)->get(),
              'title' => 'sin Responder',
              'buttonTitle' => 'Responder'
            ];
  				break;
  				case 'closed':
            $data = [
              'tickets' => Ticket::with('helpTopic:id,title', 'user:id,first_name,last_name')->where('solved', 1)->get(),
              'title' => 'Respondidos',
              'buttonTitle' => 'Ver'
            ];
  				break;
  		}
  			
  		return view('admin.tickets.index-by-status', $data);
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
      if( Ticket::findOrFail($id)->delete() ) {
        return back()->with('status', 'El ticket fue eliminado exitosamente.');
      }
    }

}
