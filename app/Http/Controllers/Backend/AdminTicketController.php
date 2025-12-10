<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminTicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['user', 'latestMessage'])
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($ticket) {
                return [
                    'id' => $ticket->id,
                    'subject' => $ticket->subject,
                    'status' => $ticket->status,
                    'user_name' => $ticket->user->nama,
                    'user_email' => $ticket->user->email,
                    'last_message' => $ticket->latestMessage ? strip_tags($ticket->latestMessage->message) : null,
                    'last_message_date' => $ticket->latestMessage ? $ticket->latestMessage->created_at : $ticket->created_at,
                    'created_at' => $ticket->created_at,
                    'updated_at' => $ticket->updated_at,
                ];
            });

        return response()->json($tickets);
    }

    public function show($id)
    {
        $ticket = Ticket::with(['user', 'messages' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }])->findOrFail($id);

        return response()->json([
            'id' => $ticket->id,
            'subject' => $ticket->subject,
            'status' => $ticket->status,
            'user' => [
                'id' => $ticket->user->id,
                'name' => $ticket->user->nama,
                'email' => $ticket->user->email,
            ],
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

        $ticket = Ticket::findOrFail($id);

        if ($ticket->status === 'close') {
            throw ValidationException::withMessages([
                'ticket' => ['Cannot send message to closed ticket'],
            ]);
        }

        $message = TicketMessage::create([
            'ticket_id' => $ticket->id,
            'sender' => 'admin',
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

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,close',
        ]);

        $ticket = Ticket::findOrFail($id);

        $ticket->update([
            'status' => $validated['status'],
        ]);

        return response()->json([
            'message' => 'Ticket status updated successfully',
            'ticket' => $ticket,
        ]);
    }
}