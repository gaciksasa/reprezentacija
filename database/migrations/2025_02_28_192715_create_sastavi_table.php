<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sastavi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utakmica_id')->constrained();
            $table->foreignId('tim_id')->constrained('timovi');
            $table->foreignId('igrac_id')->constrained('igraci');
            $table->boolean('starter')->default(true);
            $table->string('selektor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sastavi');
    }
};
