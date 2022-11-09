<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AgentInfoMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agentinfos', function (Blueprint $table) {
            $table->id('aid');
            $table->string('aname');
            $table->string('age');
            $table->string('email');
            $table->string('experience');
            $table->string('marketvalue');
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
        Schema::dropIfExists('agentinfos');
    }
}
