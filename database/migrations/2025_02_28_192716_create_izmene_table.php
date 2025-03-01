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
        Schema::create('izmene', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utakmica_id')->constrained();
            $table->foreignId('tim_id')->constrained('timovi');
            $table->foreignId('igrac_out_id')->constrained('igraci');
            $table->foreignId('igrac_in_id')->constrained('igraci');
            $table->integer('minut');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izmene');
    }
};
