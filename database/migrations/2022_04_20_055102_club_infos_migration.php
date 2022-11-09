<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClubInfosMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clubinfos', function (Blueprint $table) {
            $table->id('cid');
            $table->string('cname');
            $table->string('email');
            $table->string('location');
            $table->string('league');
            $table->string('grade');
            $table->string('uid');
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
        Schema::dropIfExists('clubinfos');
    }
}
