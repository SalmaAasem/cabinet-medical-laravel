<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rendez_vous', function (Blueprint $table) {
            $table->enum('statut', ['en_attente', 'confirme', 'annule', 'termine'])->default('en_attente');
        });
    }

    public function down()
    {
        Schema::table('rendez_vous', function (Blueprint $table) {
            $table->dropColumn('statut');
        });
    }
};