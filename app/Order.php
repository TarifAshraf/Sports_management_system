<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = 'orders';
    protected $fillable = [
        'oid', 'product','userid','unitprice','qty','size','delivery','paymethod','status',
    ];
}
