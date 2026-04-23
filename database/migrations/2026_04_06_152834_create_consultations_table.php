<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rendez_vous_id')->constrained('rendez_vous')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('medecin_id')->constrained('medecins')->onDelete('cascade');
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
