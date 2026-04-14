<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('medecins', function (Blueprint $table) {
            $table->string('specialite')->nullable()->change();
            $table->string('diplome')->nullable()->change();
            $table->integer('annee_experience')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('medecins', function (Blueprint $table) {
            $table->string('specialite')->nullable(false)->change();
            $table->string('diplome')->nullable(false)->change();
            $table->integer('annee_experience')->nullable(false)->change();
        });
    }
};