<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameMemberTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('game_Members', function (Blueprint $table) {
            $table->integer('gameID');
            $table->integer('memberID');
            $table->integer('score');
            $table->primary(['gameID', 'memberID']);
        });
    }
    
    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::drop('game_Members');
    }
}