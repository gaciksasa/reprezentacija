<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('protivnicki_kartoni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utakmica_id')->constrained()->onDelete('cascade');
            $table->foreignId('tim_id')->constrained('timovi');
            $table->foreignId('igrac_id')->constrained('protivnicki_igraci')->onDelete('cascade');
            $table->enum('tip', ['zuti', 'crveni']);
            $table->integer('minut');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('protivnicki_kartoni');
    }
};