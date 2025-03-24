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
            $table->integer('redosled')->nullable()->after('u_sastavu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('protivnicki_igraci', function (Blueprint $table) {
            $table->dropColumn('redosled');
        });
    }
};