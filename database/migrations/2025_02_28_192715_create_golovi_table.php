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
        Schema::create('golovi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utakmica_id')->constrained();
            $table->foreignId('igrac_id')->constrained('igraci');
            $table->integer('minut');
            $table->foreignId('tim_id')->constrained('timovi');
            $table->boolean('penal')->default(false);
            $table->boolean('auto_gol')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('golovi');
    }
};
