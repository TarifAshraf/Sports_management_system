<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PlayerInfoMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playerinfos', function (Blueprint $table) {
            $table->id('pid');
            $table->string('pname');
            $table->string('age');
            $table->string('email');
            $table->string('club');
            $table->string('marketvalue');
            $table->string('uid');
            $table->string('sponsor')->nullable();
            $table->string('currentclub')->nullable();
            $table->string('currentagent')->nullable();
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
        Schema::dropIfExists('playerinfos');
    }
}
