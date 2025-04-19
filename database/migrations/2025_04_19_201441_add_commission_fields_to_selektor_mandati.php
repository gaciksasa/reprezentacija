<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('selektor_mandati', function (Blueprint $table) {
            $table->boolean('komisija')->default(false)->after('v_d_status');
            $table->integer('redosled_u_komisiji')->nullable()->after('komisija');
            $table->boolean('glavni_selektor')->default(false)->after('redosled_u_komisiji');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('selektor_mandati', function (Blueprint $table) {
            $table->dropColumn(['komisija', 'redosled_u_komisiji', 'glavni_selektor']);
        });
    }
};