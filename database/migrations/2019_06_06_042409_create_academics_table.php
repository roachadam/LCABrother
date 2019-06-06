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
            $table->unsignedBigInteger('Cumulative GPA')->nullable();
            $table->unsignedBigInteger('Previous Term GPA')->nullable();
            $table->unsignedBigInteger('Current Term GPA')->nullable();
            $table->string('Previous Academic Standing')->nullable();
            $table->string('Current Academic Standing')->nullable();
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
