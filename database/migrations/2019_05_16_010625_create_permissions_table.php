<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('view_member_details')->default('0');
            $table->unsignedTinyInteger('manage_member_details')->default('0');
            $table->unsignedTinyInteger('log_service_event')->default('0');
            $table->unsignedTinyInteger('view_all_service')->default('0');
            $table->unsignedTinyInteger('view_all_involvement')->default('0');
            $table->unsignedTinyInteger('manage_all_service')->default('0');
            $table->unsignedTinyInteger('manage_all_involvement')->default('0');
            $table->unsignedTinyInteger('manage_events')->default('0');
            $table->unsignedTinyInteger('manage_alumni')->default('0');
            $table->unsignedTinyInteger('manage_surveys')->default('0');
            $table->unsignedTinyInteger('view_all_study')->default('0');
            $table->unsignedTinyInteger('manage_all_study')->default('0');
            $table->unsignedTinyInteger('manage_calendar')->default('0');
            $table->unsignedTinyInteger('manage_attendance')->default('0');
            $table->unsignedTinyInteger('take_attendance')->default('0');
            $table->unsignedTinyInteger('manage_goals')->default('0');
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
        Schema::dropIfExists('permissions');
    }
}
