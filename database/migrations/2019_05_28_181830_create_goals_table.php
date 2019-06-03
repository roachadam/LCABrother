<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->integer('points_goal')->nullable();
            $table->integer('study_goal')->nullable();
            $table->integer('service_hours_goal')->nullable();
            $table->integer('service_money_goal')->nullable();
            $table->timestamps();
        });
        Schema::table('goals', function($table) {
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goals');
    }
}
