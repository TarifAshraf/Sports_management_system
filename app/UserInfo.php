<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    public $table = 'userinfos';
    protected $fillable = [
        'uid', 'uname','email','contactno','address','uid',
    ];
}
