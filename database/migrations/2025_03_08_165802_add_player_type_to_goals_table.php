<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('golovi', function (Blueprint $table) {
        $table->enum('igrac_tip', ['regularni', 'protivnicki'])->default('regularni')->after('igrac_id');
    });
}

    public function down()
    {
        Schema::table('golovi', function (Blueprint $table) {
            $table->dropColumn('igrac_tip');
        });
    }
};
