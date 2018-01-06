<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tag');
            $table->timestamps();
            
            $table->unique('tag');
        });
        
        Schema::create('file_tag', function (Blueprint $table) {
            $table->bigInteger('file_id')->unsigned();
            $table->integer('tag_id')->unsigned();
            
            $table->primary(['file_id', 'tag_id']);
        });
    }
    
    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('file_tag');
        Schema::dropIfExists('tags');
    }
}
