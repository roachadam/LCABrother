<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvolvementLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('involvement_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->unsignedBigInteger('involvement_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->Integer('points')->nullable();
            $table->timestamps();
        });

        Schema::table('involvement_logs', function($table) {
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('involvement_id')->references('id')->on('involvements');
            $table->foreign('user_id')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('involvement_logs');
    }
}
