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
        Schema::create('timovi', function (Blueprint $table) {
            $table->id();
            $table->string('naziv');
            $table->string('skraceni_naziv')->nullable();
            $table->string('zastava_url')->nullable();
            $table->string('grb_url')->nullable();
            $table->string('zemlja');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timovi');
    }
};
