<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $tickets = Ticket::where('user_id', $user->id)
            ->with(['latestMessage'])
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($ticket) {
                return [
                    'id' => $ticket->id,
                    'subject' => $ticket->subject,
                    'status' => $ticket->status,
                    'last_message' => $ticket->latestMessage ? strip_tags($ticket->latestMessage->message) : null,
                    'last_message_date' => $ticket->latestMessage ? $ticket->latestMessage->created_at : $ticket->created_at,
                    'created_at' => $ticket->created_at,
                    'updated_at' => $ticket->updated_at,
                ];
            });

        return response()->json($tickets);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $user = Auth::user();

        $ticket = Ticket::create([
            'user_id' => $user->id,
            'subject' => $validated['subject'],
            'status' => 'open',
        ]);

        $message = TicketMessage::create([
            'ticket_id' => $ticket->id,
            'sender' => 'user',
            'message' => $validated['message'],
        ]);

        return response()->json([
            'message' => 'Ticket created successfully',
            'ticket' => $ticket,
        ], 201);
    }

    public function show($id)
    {
        $user = Auth::user();

        $ticket = Ticket::where('id', $id)
            ->where('user_id', $user->id)
            ->with(['messages' => function ($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->firstOrFail();

        return response()->json([
            'id' => $ticket->id,
            'subject' => $ticket->subject,
            'status' => $ticket->status,
            'created_at' => $ticket->created_at,
            'updated_at' => $ticket->updated_at,
            'messages' => $ticket->messages->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'sender' => $msg->sender,
                    'message' => $msg->message,
                    'created_at' => $msg->created_at,
                ];
            }),
        ]);
    }

    public function sendMessage(Request $request, $id)
    {
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $user = Auth::user();

        $ticket = Ticket::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if ($ticket->status === 'close') {
            throw ValidationException::withMessages([
                'ticket' => ['Cannot send message to closed ticket'],
            ]);
        }

        $message = TicketMessage::create([
            'ticket_id' => $ticket->id,
            'sender' => 'user',
            'message' => $validated['message'],
        ]);

        $ticket->touch();

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => [
                'id' => $message->id,
                'sender' => $message->sender,
                'message' => $message->message,
                'created_at' => $message->created_at,
            ],
        ], 201);
    }
}
