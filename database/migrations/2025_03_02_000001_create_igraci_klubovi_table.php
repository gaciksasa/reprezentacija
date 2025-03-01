<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        
        // Dodati tabelu za praćenje klubova igrača kroz karijeru
        Schema::create('igraci_klubovi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('igrac_id')->constrained('igraci')->onDelete('cascade');
            $table->string('klub');
            $table->string('drzava_kluba')->nullable();
            $table->date('od_datuma')->nullable();
            $table->date('do_datuma')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('igraci_klubovi');
    }
};