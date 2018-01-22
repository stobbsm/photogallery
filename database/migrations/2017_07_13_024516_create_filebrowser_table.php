<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilebrowserTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filename');
            $table->text('fullpath');
            $table->string('filetype');
            $table->string('mimetype');
            $table->bigInteger('size')->unsigned()->nullable();
            $table->timestamps();
        
            $table->index('filename');
            $table->index('mimetype');
        });
    }
    
    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::drop('files');
    }
}
