<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClubInfo extends Model
{
    public $table = 'clubinfos';
    protected $fillable = [
        'cid', 'cname','email','location','league','grade','uid',
    ];
}
