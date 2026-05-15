<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained()->cascadeOnDelete();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('jours_ouvrables');
            $table->date('date_reprise_service');
            $table->string('type');
            $table->string('raison')->nullable();
            $table->integer('enfant_count')->default(0);
            $table->boolean('deduit')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
