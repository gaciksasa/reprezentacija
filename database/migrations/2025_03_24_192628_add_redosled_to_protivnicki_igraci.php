<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRedosledToProtivnickiIgraci extends Migration
{
    public function up()
    {
        Schema::table('protivnicki_igraci', function (Blueprint $table) {
            $table->integer('redosled')->nullable()->default(0);
        });
    }

    public function down()
    {
        Schema::table('protivnicki_igraci', function (Blueprint $table) {
            $table->dropColumn('redosled');
        });
    }
}