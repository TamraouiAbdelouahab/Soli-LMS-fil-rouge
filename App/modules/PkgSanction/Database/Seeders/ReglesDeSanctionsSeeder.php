<?php

namespace Modules\PkgSanction\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgSanction\App\Enum\SanctionType;
use Modules\PkgSanction\App\Models\ReglesDeSanction;

class ReglesDeSanctionsSeeder extends Seeder
{
    public function run()
    {
        // ReglesDeSanction::truncate();

        ReglesDeSanction::insert([
            [
                'titre' => 'Mise en garde niveau 1',
                'sanction_type' => SanctionType::AVERTISSEMENT->value,
                'description' => 'Première mise en garde suite à des absences répétées.',
                'absences_max' => 3,
                'seuil_de_notification' => 2,
                'duree_sanction' => 0,
                'est_actif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Mise en garde niveau 2',
                'sanction_type' => SanctionType::AVERTISSEMENT->value,
                'description' => 'Deuxième mise en garde en cas de récidive.',
                'absences_max' => 6,
                'seuil_de_notification' => 5,
                'duree_sanction' => 0,
                'est_actif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Avertissement niveau 1',
                'sanction_type' => SanctionType::AVERTISSEMENT->value,
                'description' => 'Premier avertissement officiel.',
                'absences_max' => 9,
                'seuil_de_notification' => 8,
                'duree_sanction' => 0,
                'est_actif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Avertissement niveau 2',
                'sanction_type' => SanctionType::AVERTISSEMENT->value,
                'description' => 'Deuxième avertissement avec possibilité de sanction disciplinaire.',
                'absences_max' => 12,
                'seuil_de_notification' => 11,
                'duree_sanction' => 0,
                'est_actif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Blâme',
                'sanction_type' => SanctionType::SUSPENSION->value,
                'description' => 'Blâme inscrit dans le dossier de l\'apprenant.',
                'absences_max' => 15,
                'seuil_de_notification' => 13,
                'duree_sanction' => 0,
                'est_actif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Suspension 2 jours',
                'sanction_type' => SanctionType::SUSPENSION->value,
                'description' => 'Suspension temporaire de 2 jours.',
                'absences_max' => 18,
                'seuil_de_notification' => 16,
                'duree_sanction' => 2,
                'est_actif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Suspension 4 jours',
                'sanction_type' => SanctionType::SUSPENSION->value,
                'description' => 'Suspension temporaire de 4 jours.',
                'absences_max' => 21,
                'seuil_de_notification' => 19,
                'duree_sanction' => 4,
                'est_actif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Suspension 8 jours',
                'sanction_type' => SanctionType::SUSPENSION->value,
                'description' => 'Suspension temporaire de 8 jours.',
                'absences_max' => 24,
                'seuil_de_notification' => 22,
                'duree_sanction' => 8,
                'est_actif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'titre' => 'Exclusion définitive',
                'sanction_type' => SanctionType::EXCLUSION->value,
                'description' => 'Exclusion définitive de l\'établissement.',
                'absences_max' => 30,
                'seuil_de_notification' => 28,
                'duree_sanction' => 0,
                'est_actif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
