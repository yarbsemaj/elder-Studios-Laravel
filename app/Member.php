<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public $primaryKey  = 'memberID';
    public $timestamps = false;

    public function gameMember(){
        return $this->hasMany('App\GameMember',"memberID");
    }

}