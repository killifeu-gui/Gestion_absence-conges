<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('matricule_solde')->unique();
            $table->string('lieu_affectation');
            $table->string('direction')->nullable();
            $table->string('ufr')->nullable();
            $table->date('date_prise_service');
            $table->date('date_cessation_service')->nullable();
            $table->date('date_reprise_service')->nullable();
            $table->integer('jours_conges_dus')->default(0);
            $table->integer('jours_ouvrables_a_prendre')->default(0);
            $table->integer('absences_a_defalquer')->default(0);
            $table->integer('jours_restants')->default(0);
            $table->integer('enfants')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
