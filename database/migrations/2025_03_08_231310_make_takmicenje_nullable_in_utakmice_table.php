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
            // Prvo uklonimo strani ključ
            $table->dropForeign(['takmicenje_id']);
            
            // Zatim promenimo kolonu da bude nullable
            $table->foreignId('takmicenje_id')->nullable()->change();
            
            // Dodajmo ponovo strani ključ, ali sa opcijom nullOnDelete
            $table->foreign('takmicenje_id')
                  ->references('id')->on('takmicenja')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('utakmice', function (Blueprint $table) {
            // Uklonimo strani ključ sa nullOnDelete
            $table->dropForeign(['takmicenje_id']);
            
            // Vratimo kolonu nazad na required
            $table->foreignId('takmicenje_id')->nullable(false)->change();
            
            // Dodajmo ponovo originalni strani ključ
            $table->foreign('takmicenje_id')
                  ->references('id')->on('takmicenja')
                  ->onDelete('restrict');
        });
    }
};