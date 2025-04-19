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
        Schema::table('utakmice', function (Blueprint $table) {
            $table->string('protivnik_alijas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('utakmice', function (Blueprint $table) {
            $table->dropColumn('protivnik_alijas');
        });
    }
};