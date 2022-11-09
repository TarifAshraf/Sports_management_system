<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public $table = 'bookings';
    protected $fillable = [
        'bid', 'playerid','bookfor','bookerid','offerprice','txnid','paymethod','status',
    ];
}
