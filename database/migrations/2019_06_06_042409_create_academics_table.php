<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name')->nullable();
            $table->float('Cumulative_GPA')->nullable();
            $table->float('Previous_Term_GPA')->nullable();
            $table->float('Current_Term_GPA')->nullable();
            $table->string('Previous_Academic_Standing')->nullable();
            $table->string('Current_Academic_Standing')->nullable();
            $table->timestamps();
        });

        // Schema::table('academics', function ($table) {
        //     $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
        //     $table->foreign('involvement_id')->references('id')->on('involvements')->onDelete('cascade');
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academics');
    }
}
