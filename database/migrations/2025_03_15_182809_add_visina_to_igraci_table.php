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
        Schema::table('igraci', function (Blueprint $table) {
            $table->integer('visina')->nullable()->after('pozicija')->comment('Visina igrača u cm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('igraci', function (Blueprint $table) {
            $table->dropColumn('visina');
        });
    }
};