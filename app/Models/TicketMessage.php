<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TicketMessage extends Model
{
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'message',
        'sender',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}