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
            $table->string('featured_img')->nullable()->after('protivnik_alijas');
            $table->string('tickets_url')->nullable()->after('featured_img');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('utakmice', function (Blueprint $table) {
            $table->dropColumn(['featured_img', 'tickets_url']);
        });
    }
};