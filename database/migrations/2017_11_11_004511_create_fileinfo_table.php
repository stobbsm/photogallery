<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileinfoTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('fileinfo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('file_id')->unsigned()->references('id')->on('files');
            $table->integer('user_id')->unsigned()->references('id')->on('users');
            $table->string('title')->nullable();
            $table->string('desc')->nullable();
            $table->timestamps();
        });
    }
    
    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('fileinfo');
    }
}
