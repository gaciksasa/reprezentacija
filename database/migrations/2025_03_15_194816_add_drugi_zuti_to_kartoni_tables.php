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
        Schema::table('kartoni', function (Blueprint $table) {
            $table->boolean('drugi_zuti')->default(false)->after('minut');
        });
        
        Schema::table('protivnicki_kartoni', function (Blueprint $table) {
            $table->boolean('drugi_zuti')->default(false)->after('minut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kartoni', function (Blueprint $table) {
            $table->dropColumn('drugi_zuti');
        });
        
        Schema::table('protivnicki_kartoni', function (Blueprint $table) {
            $table->dropColumn('drugi_zuti');
        });
    }
};