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
        Schema::create('protivnicke_izmene', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utakmica_id')->constrained()->onDelete('cascade');
            $table->foreignId('tim_id')->constrained('timovi');
            $table->foreignId('igrac_out_id')->constrained('protivnicki_igraci')->onDelete('cascade');
            $table->foreignId('igrac_in_id')->constrained('protivnicki_igraci')->onDelete('cascade');
            $table->integer('minut');
            $table->text('napomena')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('protivnicke_izmene');
    }
};