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
        Schema::table('protivnicki_igraci', function (Blueprint $table) {
            $table->boolean('u_sastavu')->default(true)->after('kapiten');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('protivnicki_igraci', function (Blueprint $table) {
            $table->dropColumn('u_sastavu');
        });
    }
};