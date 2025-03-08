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
            // Remove time field
            $table->dropColumn('vreme');
            
            // Remove season field
            $table->dropColumn('sezona');
            
            // Remove half-time score fields
            $table->dropColumn('poluvreme_rezultat_domacin');
            $table->dropColumn('poluvreme_rezultat_gost');
            
            // Change stadium and referee to be direct string fields instead of foreign keys
            $table->dropForeign(['stadion_id']);
            $table->dropForeign(['sudija_id']);
            
            $table->dropColumn('stadion_id');
            $table->dropColumn('sudija_id');
            
            // Add new string fields for stadium and referee
            $table->string('stadion')->nullable()->after('gost_id');
            $table->string('sudija')->nullable()->after('stadion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('utakmice', function (Blueprint $table) {
            // Add back original fields
            $table->time('vreme')->nullable();
            $table->string('sezona')->nullable();
            $table->integer('poluvreme_rezultat_domacin')->nullable();
            $table->integer('poluvreme_rezultat_gost')->nullable();
            
            // Remove string fields
            $table->dropColumn('stadion');
            $table->dropColumn('sudija');
            
            // Add back foreign key fields
            $table->foreignId('stadion_id')->nullable();
            $table->foreignId('sudija_id')->nullable();
            
            // Add foreign key constraints
            $table->foreign('stadion_id')->references('id')->on('stadioni');
            $table->foreign('sudija_id')->references('id')->on('sudije');
        });
    }
};