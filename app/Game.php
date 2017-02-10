<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public $primaryKey  = 'gameID';
    public $timestamps = false;
    
    
    public function gameMember(){
        return $this->hasMany('App\GameMember',"gameID");
    }
    
}