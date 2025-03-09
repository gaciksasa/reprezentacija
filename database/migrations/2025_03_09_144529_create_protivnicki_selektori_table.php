<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('protivnicki_selektori', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utakmica_id')->constrained()->onDelete('cascade');
            $table->foreignId('tim_id')->constrained('timovi');
            $table->string('ime_prezime');
            $table->text('napomena')->nullable();
            $table->timestamps();
            
            // Osigurajte da za svaku utakmicu i tim postoji samo jedan selektor
            $table->unique(['utakmica_id', 'tim_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('protivnicki_selektori');
    }
};