<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class News extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('desc');
            $table->string('user');
            $table->text('link');
            $table->boolean('status')->default(0)->comment('0=>news 1=>article ');
            $table->boolean('const')->default(0)->comment('0=>nonconst 1=>const ');
            $table->integer('governorate_id');
            $table->integer('user_id');
            $table->integer('initiative_id')->nullable();
            $table->integer('government_id')->nullable();
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
        //
    }
}
