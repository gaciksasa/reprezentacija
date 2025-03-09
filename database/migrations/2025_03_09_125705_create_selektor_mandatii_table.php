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
        Schema::create('selektor_mandati', function (Blueprint $table) {
            $table->id();
            $table->foreignId('selektor_id')->constrained()->onDelete('cascade');
            $table->foreignId('tim_id')->constrained('timovi')->onDelete('cascade');
            $table->date('pocetak_mandata');
            $table->date('kraj_mandata')->nullable();
            $table->boolean('v_d_status')->default(false); // Vršilac dužnosti
            $table->text('napomena')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selektor_mandati');
    }
};