<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Support\Facades\Auth;
use App\HelpTopic;
use App\Reply;
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
    public function indexForCustomer()
    {
      $tickets = Ticket::where('user_id', Auth::id())->get();
      return view('customer.tickets.index', ['tickets' => $tickets]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('customer.tickets.create')->with('helpTopics', HelpTopic::all('id', 'title'));
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
        'help_topic_id' => 'required|exists:help_topics,id',
        'subject' => 'required|string',
        'content' => 'required',
        'has_attachments' => 'required|in:yes,no',
        'attachments_list' => 'required_if:has_attachments,yes'
      ]); 

      $ticket = new Ticket();
      $ticket->help_topic_id = $request->help_topic_id;
      $ticket->user_id = $request->user()->id;
      $ticket->subject = $request->subject;
      $ticket->status = 'open';
      $ticket->solved = 0;
      $ticketIsSaved = $ticket->save();
      $reply = new Reply();
      $reply->ticket_id = $ticket->id;
      $reply->user_id = $request->user()->id;
      $reply->content = $request->content;
      $reply->attached_files = $request->attachments_list;
      $replyIsSaved = $reply->save();
      if ($ticketIsSaved && $replyIsSaved) 
      {
        return redirect()->route('customer.tickets.indexForCustomer');
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
        //
    }
}
