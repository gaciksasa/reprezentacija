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
        Schema::create('bivsi_klubovi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('igrac_id')->constrained('igraci')->onDelete('cascade');
            $table->string('naziv');
            $table->string('drzava')->nullable();
            $table->string('stepen_takmicenja')->nullable();
            $table->integer('broj_nastupa')->nullable();
            $table->integer('broj_golova')->nullable();
            $table->date('period_od')->nullable();
            $table->date('period_do')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bivsi_klubovi');
    }
};