<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdimagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('idimages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_image');
            $table->foreign('id_image')->references('id')->on('newsimages')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('news_i_id');
            $table->foreign('news_i_id')->references('id')->on('news')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('idimages');
    }
}
