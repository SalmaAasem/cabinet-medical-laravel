<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rendez_vous', function (Blueprint $table) {
            // Ajouter les colonnes si elles n'existent pas
            if (!Schema::hasColumn('rendez_vous', 'patient_id')) {
                $table->unsignedBigInteger('patient_id')->after('id');
            }
            
            if (!Schema::hasColumn('rendez_vous', 'medecin_id')) {
                $table->unsignedBigInteger('medecin_id')->after('patient_id');
            }
            
            if (!Schema::hasColumn('rendez_vous', 'date_heure')) {
                $table->dateTime('date_heure')->after('medecin_id');
            }
            
            if (!Schema::hasColumn('rendez_vous', 'motif')) {
                $table->text('motif')->nullable()->after('statut');
            }
        });
    }

    public function down()
    {
        Schema::table('rendez_vous', function (Blueprint $table) {
            $table->dropColumn(['patient_id', 'medecin_id', 'date_heure', 'motif']);
        });
    }
};