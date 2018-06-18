<?php

namespace App\Http\Controllers\Auth;

use App\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReplyController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
      $request->validate([
        'ticket_id' => 'required|exists:tickets,id',
        'content' => 'required',
        'has_attachments' => 'required|in:yes,no',
        'attachments_list' => 'required_if:has_attachments,yes'
      ]); 

      $reply = new Reply();
      $reply->ticket_id = $request->ticket_id;
      $reply->user_id = $request->user()->id;
      $reply->content = $request->content;
      $reply->attached_files = $request->attachments_list;
      $replyIsSaved = $reply->save();
      if ($request->user()->role === 'customer') {
        $reply->ticket->status = 'open';
        $reply->ticket->solved = 0;
        $reply->ticket->save();
      }
      else {
        $reply->ticket->status = 'closed';
        $reply->ticket->solved = 1;
        $reply->ticket->save();       
      }
      if ($replyIsSaved) 
      {
        return back()->with('status', 'Su respuesta fue registrada con éxito.');
      }
    }

    public function storeFiles(Request $request) 
    {
      $attachments_list = null;
      foreach ($request->file('attached_files') as $file) {
        if ( $file->isValid() ) 
        {
          $path = 'tickets/'. $request->ticket_id;
          $file_name = $file->store($path, 'public');
          $original_name = $file->getClientOriginalName();
          //array to json
          $attachments_list[] = 
          '{"file_name": "'.$file_name.'","original_name":"'.$original_name.'"}';
        }
      } 
      return ['attachments_list' => $attachments_list];
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
