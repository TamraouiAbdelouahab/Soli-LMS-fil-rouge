<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sanction_absences_previsionnelles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('regle_de_sanction_id')->constrained('regles_de_sanctions')->onDelete('cascade');
            $table->foreignId('absence_id')->constrained('absences')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sanction_absences_previsionnelles');
    }
};
