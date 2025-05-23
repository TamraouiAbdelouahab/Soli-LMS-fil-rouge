<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Module\PkgJustificatif\App\Enums\StatutJustificatif;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('justificatifs', function (Blueprint $table) {
            $table->id();
            $table->date('dateDepot');
            $table->date('DateDebut');
            $table->date('DateFin');
            $table->string('fichier');
            $table->text('description')->nullable();
            $table->string('statut')->default(StatutJustificatif::ACCEPTE->name);
            $table->foreignId('raison_id')->constrained('raisons');
            $table->foreignId('apprenant_id')->constrained('apprenants');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('justificatifs');
    }
};
