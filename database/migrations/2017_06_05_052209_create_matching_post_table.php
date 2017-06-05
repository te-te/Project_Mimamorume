<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchingPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
         Schema::create('matching_post', function (Blueprint $table) {
             $table->increments('num');
             $table->string('title', 30);
             $table->string('content');
             $table->string('athor', 20);
             $table->string('gender', 5);
             $table->string('age', 10);
             $table->string('disability', 20);
             $table->string('work_day', 20);
             $table->string('work_period', 20);
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
         Schema::dropIfExists('matching_post');
     }
}
