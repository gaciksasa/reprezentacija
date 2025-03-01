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
        Schema::create('kartoni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utakmica_id')->constrained();
            $table->foreignId('igrac_id')->constrained('igraci');
            $table->foreignId('tim_id')->constrained('timovi');
            $table->enum('tip', ['zuti', 'crveni']);
            $table->integer('minut');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartoni');
    }
};
