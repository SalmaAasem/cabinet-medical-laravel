<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rendez_vous_id');
            $table->foreign('rendez_vous_id')->references('id')->on('rendez_vous')->onDelete('cascade');
            $table->text('diagnostic');
            $table->text('traitement');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultations');
    }
};