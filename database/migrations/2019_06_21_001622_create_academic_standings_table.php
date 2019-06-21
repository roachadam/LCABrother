<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicStandingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_standings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->string('name')->nullable();
            $table->float('Cumulative_GPA_Min')->nullable();
            $table->float('Term_GPA_Min')->nullable();
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
        Schema::dropIfExists('academic_standings');
    }
}
