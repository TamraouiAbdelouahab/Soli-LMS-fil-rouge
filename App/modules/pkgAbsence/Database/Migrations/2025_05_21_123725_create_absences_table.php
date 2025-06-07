<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsencesTable extends Migration
{
    public function up(): void
    {
        Schema::create('absences', function (Blueprint $table) {
            $table->id();

            // 👨‍🎓 Apprenant concerné
            $table->foreignId('apprenant_id')->constrained('apprenants')->onDelete('cascade');

            // 👤 Utilisateur (ex: surveillant) qui saisit l’absence
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // 📅 Séance liée
            $table->foreignId('seance_id')->constrained('seances')->onDelete('cascade');

            // ✅ Justification booléenne
            $table->boolean('justifie')->default(false);

            // 🟢 Absence sanctionnée
            $table->boolean('est_sanctionnée')->default(false);

            // 🟠 Sanction réelle
            $table->foreignId('sanction_absence_id')->nullable()->constrained('sanction_absences')->nullOnDelete();

            // 🔵 Sanction prévisionnelle
            $table->foreignId('sanction_absence_calculee_id')->nullable()->constrained('sanction_absences_calculees')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
}
