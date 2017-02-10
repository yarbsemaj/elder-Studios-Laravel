<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public $primaryKey  = 'memberID';
    public $timestamps = false;
    protected $hidden = array('gameMember');
    protected $appends = array('avgScore','gamesPlayed');
    
    public function gameMember(){
        return $this->hasMany('App\GameMember',"memberID");
    }
    
    public function getAvgScoreAttribute(){
        return $this->gameMember->avg('score');
    }
    
    public function getGamesPlayedAttribute(){
        return $this->gameMember->count();
    }
    
    public function getMemberScoresAttribute(){
        return $this->gameMember->where("memberID",$this->memberID);
    }
    
    public function getWinsAttribute(){
        $wins=0;
        foreach ($this->MemberScores as $yourScore){
            $yourGameScore=$yourScore["score"];
            $theirGameScore=$yourScore->opponentGame()["score"];
            if($yourGameScore>$theirGameScore)$wins++;
        }
        return $wins;
    }
    
    public function getLossAttribute(){
        $loss=0;
        foreach ($this->MemberScores as $yourScore){
            $yourGameScore=$yourScore["score"];
            $theirGameScore=$yourScore->opponentGame()["score"];
            if($yourGameScore<$theirGameScore)$loss++;
        }
        return $loss;
    }
}