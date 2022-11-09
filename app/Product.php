<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table = 'products';
    protected $fillable = [
        'proid', 'clubid','productname','price','image',
    ];
}
