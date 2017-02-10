<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameMember extends Model
{
    public $timestamps = false;

    public function member(){
        return $this->hasOne('App\Member','memberID','memberID')->first();
    }

    public function game(){
        return $this->hasOne('App\Game','gameID','gameID')->first();
    }

    public function opponentGame(){
        $allGames= GameMember::all();
        return $allGames->where("gameID",$this->gameID)->where("memberID","!=",$this->memberID)->first();
    }

  
}
