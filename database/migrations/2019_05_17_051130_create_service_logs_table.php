<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->unsignedBigInteger('service_event_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->double('hours_served')->nullable();
            $table->double('money_donated')->nullable();
            $table->timestamps();
        });

        Schema::table('service_logs', function($table) {
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');;
            $table->foreign('service_event_id')->references('id')->on('service_events')->onDelete('cascade');;
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
     }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_logs');
    }
}
