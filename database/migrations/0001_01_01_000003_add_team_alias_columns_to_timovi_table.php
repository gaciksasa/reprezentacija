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
        Schema::table('timovi', function (Blueprint $table) {
            $table->boolean('glavni_tim')->default(false)->after('zemlja');
            $table->foreignId('maticni_tim_id')->nullable()->after('glavni_tim')
                  ->references('id')->on('timovi')->onDelete('set null');
            $table->dateTime('aktivan_od')->nullable()->after('maticni_tim_id');
            $table->dateTime('aktivan_do')->nullable()->after('aktivan_od');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timovi', function (Blueprint $table) {
            $table->dropForeign(['maticni_tim_id']);
            $table->dropColumn(['glavni_tim', 'maticni_tim_id', 'aktivan_od', 'aktivan_do']);
        });
    }
};