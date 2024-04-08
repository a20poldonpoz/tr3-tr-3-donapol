<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmacionCompra;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        // Validar y guardar los datos del ticket en la base de datos
        $ticket = new Ticket();
        $ticket->movie_id = $request->input('movie_id');
        $ticket->seat_id = $request->input('seat_id');
        $ticket->preu = $request->input('preu');
        $ticket->email = $request->input('email');
        $ticket->save();
    

        // Enviar correo de confirmación 
      //Mail::to($ticket->email)->send(new ConfirmacionCompra($ticket, $movie->titol));

        return response()->json(['message' => 'Ticket creado correctamente', 'data' => $ticket], 201);
    }

    public function getTickets(Request $request)
    {
      $email = $request->query('email');

      // Buscar ticket asociat amb el correu 
      $tickets = Ticket::where('email', $email)->get();

      return response()->json(['tickets' => $tickets], 200);
    }
}
