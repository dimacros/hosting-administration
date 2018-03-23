<?php

namespace App\Http\Controllers\Auth;

use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    public function show($id)
    {
      $ticket = Ticket::findOrFail($id);
      $replies = $ticket->replies;
		  return view('auth.tickets.show', ['ticket' => $ticket, 'replies' => $replies] );
    }
}

