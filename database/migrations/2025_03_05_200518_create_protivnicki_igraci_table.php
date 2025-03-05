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
        Schema::create('protivnicki_igraci', function (Blueprint $table) {
            $table->id();
            $table->string('ime');
            $table->string('prezime');
            $table->foreignId('utakmica_id')->constrained()->onDelete('cascade');
            $table->foreignId('tim_id')->constrained('timovi');
            $table->boolean('kapiten')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('protivnicki_igraci');
    }
};