<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $table = 'support_tickets';

    protected $fillable = [
        'ticket_id',
        'sender_name',
        'sender_email',
        'subjek',
        'modul',
        'deskripsi',
        'status',
    ];
}