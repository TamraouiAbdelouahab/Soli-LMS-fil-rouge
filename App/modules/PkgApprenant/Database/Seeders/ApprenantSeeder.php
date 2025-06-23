<?php

namespace Modules\PkgApprenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\PkgApprenant\App\Models\Apprenant;
use Modules\Core\App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Facades\Hash;

class ApprenantSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('fr_FR');

        $names = [
            ['fr' => 'Mohamed Alami', 'ar_first' => 'محمد', 'ar_last' => 'العلمي'],
            ['fr' => 'Fatima Zahra Benjelloun', 'ar_first' => 'فاطمة الزهراء', 'ar_last' => 'بنجلون'],
            ['fr' => 'Youssef El Amrani', 'ar_first' => 'يوسف', 'ar_last' => 'العماري'],
            ['fr' => 'Amina Belhaj', 'ar_first' => 'أمينة', 'ar_last' => 'بلحاج'],
            ['fr' => 'Mehdi Cherkaoui', 'ar_first' => 'مهدي', 'ar_last' => 'الشرقاوي'],
            ['fr' => 'Leila Mansouri', 'ar_first' => 'ليلى', 'ar_last' => 'المنصوري'],
            ['fr' => 'Omar El Fassi', 'ar_first' => 'عمر', 'ar_last' => 'الفاسي'],
            ['fr' => 'Houda Tazi', 'ar_first' => 'هدى', 'ar_last' => 'التازي'],
            ['fr' => 'Karim Bouzidi', 'ar_first' => 'كريم', 'ar_last' => 'البوزيدي'],
            ['fr' => 'Nadia El Khatib', 'ar_first' => 'نادية', 'ar_last' => 'الخطيب'],
            ['fr' => 'Adil Benbrahim', 'ar_first' => 'عادل', 'ar_last' => 'بنبراهيم'],
            ['fr' => 'Samira El Hajji', 'ar_first' => 'سميرة', 'ar_last' => 'الحجي'],
            ['fr' => 'Hamza Zaoui', 'ar_first' => 'حمزة', 'ar_last' => 'الزاوي'],
            ['fr' => 'Sanaa El Ouafi', 'ar_first' => 'سناء', 'ar_last' => 'الواعفي'],
            ['fr' => 'Rachid Naciri', 'ar_first' => 'رشيد', 'ar_last' => 'الناصري'],
            ['fr' => 'Zineb El Mansouri', 'ar_first' => 'زبينة', 'ar_last' => 'المنصوري'],
            ['fr' => 'Anas Berrada', 'ar_first' => 'أنس', 'ar_last' => 'البرادة'],
            ['fr' => 'Imane El Khamlichi', 'ar_first' => 'إيمان', 'ar_last' => 'الخمليشي'],
            ['fr' => 'Mehdi El Omari', 'ar_first' => 'مهدي', 'ar_last' => 'العمراوي'],
            ['fr' => 'Hafsa El Filali', 'ar_first' => 'حفصة', 'ar_last' => 'الفلالي'],
        ];

        $cities = [
            ['fr' => 'Casablanca', 'ar' => 'الدار البيضاء'],
            ['fr' => 'Rabat', 'ar' => 'الرباط'],
            ['fr' => 'Tanger', 'ar' => 'طنجة'],
            ['fr' => 'Tétouan', 'ar' => 'تطوان']
        ];

        foreach ($names as $index => $name) {
            // Split French name for first/last name
            $nameParts = explode(' ', $name['fr']);
            $lastName = array_pop($nameParts);
            $firstName = implode(' ', $nameParts);

            // Create user first
            $user = User::create([
                'name' => $name['fr'],
                'email' => strtolower($firstName[0] . $lastName) . ($index + 1) . '@gmail.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ])->assignRole('apprenant');

            // Select random city
            $city = $cities[array_rand($cities)];

            // Create corresponding apprentice
            Apprenant::create([
                'user_id' => $user->id,
                'nom' => $lastName,
                'prenom' => $firstName,
                'prenom_arab' => $name['ar_first'],
                'nom_arab' => $name['ar_last'],
                'tele_num' => '06' . $faker->numberBetween(10000000, 99999999),
                'profile_image' => 'default.png',
                'date_inscription' => $faker->dateTimeBetween('-2 years', 'now'),
                'cin' => strtoupper($faker->bothify('??######')),
                'adresse' => $city['fr'] . ', Maroc',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
