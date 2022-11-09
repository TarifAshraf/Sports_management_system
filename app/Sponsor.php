<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    public $table = 'sponsors';
    protected $fillable = [
        'sid', 'sname','email','networth','uid',
    ];
}
