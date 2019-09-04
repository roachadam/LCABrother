<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditCalendarAddCategoryID extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasColumn('calendar', 'calendar_catagory_id'))
        {
            Schema::table('calendar', function (Blueprint $table) {
                $table->unsignedBigInteger('calendar_catagory_id')->nullable();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('color', 'calendar_catagory_id'))
        {
            Schema::table('calendar', function (Blueprint $table) {
                $table->dropColumn('color');
            });
        }
    }
}
