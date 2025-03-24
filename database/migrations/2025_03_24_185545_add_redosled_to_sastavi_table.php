// database/migrations/yyyy_mm_dd_add_redosled_to_sastavi_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRedosledToSastaviTable extends Migration
{
    public function up()
    {
        Schema::table('sastavi', function (Blueprint $table) {
            $table->integer('redosled')->nullable()->default(999);
        });
    }

    public function down()
    {
        Schema::table('sastavi', function (Blueprint $table) {
            $table->dropColumn('redosled');
        });
    }
}