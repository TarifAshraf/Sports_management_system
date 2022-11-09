<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentInfo extends Model
{
    public $table = 'agentinfos';
    protected $fillable = [
        'aid', 'aname','age','email','experience','marketvalue','uid',
    ];
}
