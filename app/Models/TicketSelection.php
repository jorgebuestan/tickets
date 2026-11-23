<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketSelection extends Model
{
    protected $fillable = [
        'ticket_number',
        'twitter_username',
        'ip_address',
        'ip_location',
        'user_agent',
    ];
}
