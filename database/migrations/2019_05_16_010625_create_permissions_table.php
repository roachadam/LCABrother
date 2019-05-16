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
            $table->unsignedTinyInteger('view_member_details');
            $table->unsignedTinyInteger('manage_member_details');
            $table->unsignedTinyInteger('log_service_event');
            $table->unsignedTinyInteger('log_involvement');
            $table->unsignedTinyInteger('view_all_service');
            $table->unsignedTinyInteger('view_all_involvement');
            $table->unsignedTinyInteger('manage_all_service');
            $table->unsignedTinyInteger('manage_all_involvement');
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
