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
        Schema::create('selektori', function (Blueprint $table) {
            $table->id();
            $table->string('ime');
            $table->string('prezime');
            $table->date('datum_rodjenja')->nullable();
            $table->string('mesto_rodjenja')->nullable();
            $table->date('datum_smrti')->nullable();
            $table->string('mesto_smrti')->nullable();
            $table->string('drzavljanstvo')->nullable();
            $table->text('biografija')->nullable();
            $table->string('fotografija_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selektori');
    }
};
