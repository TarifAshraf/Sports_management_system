<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlayerInfo extends Model
{
    public $table = 'playerinfos';
    protected $fillable = [
        'pid', 'pname','age','email','club','marketvalue','uid', 'sponsor', 'currentclub', 'currentagent',
    ];
}
