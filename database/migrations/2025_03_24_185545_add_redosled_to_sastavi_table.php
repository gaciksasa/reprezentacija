<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRedosledToSastavi extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('sastavi', 'redosled')) {
            Schema::table('sastavi', function (Blueprint $table) {
                $table->integer('redosled')->nullable()->default(0);
            });
        }
    }

    public function down()
    {
        Schema::table('sastavi', function (Blueprint $table) {
            $table->dropColumn('redosled');
        });
    }
}