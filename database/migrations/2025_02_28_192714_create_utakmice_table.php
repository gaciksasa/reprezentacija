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
        Schema::create('utakmice', function (Blueprint $table) {
            $table->id();
            $table->date('datum');
            $table->time('vreme')->nullable();
            $table->foreignId('takmicenje_id')->constrained();
            $table->foreignId('domacin_id')->constrained('timovi');
            $table->foreignId('gost_id')->constrained('timovi');
            $table->foreignId('stadion_id')->nullable()->constrained();
            $table->integer('rezultat_domacin')->default(0);
            $table->integer('rezultat_gost')->default(0);
            $table->integer('poluvreme_rezultat_domacin')->nullable();
            $table->integer('poluvreme_rezultat_gost')->nullable();
            $table->foreignId('sudija_id')->nullable()->constrained();
            $table->string('publika')->nullable();
            $table->integer('admin_id')->nullable();
            $table->string('sezona')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utakmice');
    }
};
