<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('memberID');
            $table->string('name');
            $table->string('adress1');
            $table->string('adress2');
            $table->string('postCode');
            $table->timestamp('joinDate');
        });
    }
    
    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::drop('members');
    }
}