<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixTaskAssignmentColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_assignments', function (Blueprint $table) {
            $table->renameColumn('task_id', 'tasks_id');
            $table->dropForeign(['task_id']);

            $table->foreign('tasks_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('CreateTaskAssignments', function (Blueprint $table) {
            //
        });
    }
}
