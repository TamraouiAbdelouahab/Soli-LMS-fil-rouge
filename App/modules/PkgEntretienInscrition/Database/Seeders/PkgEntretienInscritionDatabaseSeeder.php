<?php

namespace modules\PkgEntretienInscrition\Database\Seeders;

use Illuminate\Database\Seeder;

class PkgEntretienInscritionDatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $this->call([
      TrainerSeeder::class,
      CandidateSeeder::class,
      InterviewSeeder::class,
      BranchSeeder::class,
      QuestionSeeder::class,
      ParticipationSeeder::class,
      AnswerSeeder::class,
      TrainerParticipationSeeder::class,
      EvaluationSeeder::class,
      InterviewBranchSeeder::class,
    ]);
  }
}
