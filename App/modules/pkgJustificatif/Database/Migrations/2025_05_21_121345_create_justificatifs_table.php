<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\PkgJustificatif\App\Models\StatutJustificatif;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('justificatifs', function (Blueprint $table) {
            $table->id();
            $table->date('dateDepot');
            $table->date('dateDebut');
            $table->date('dateFin');
            $table->string('fichier');
            $table->text('description')->nullable();
            $table->string('status')->default(StatutJustificatif::ACCEPTE->name);
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
