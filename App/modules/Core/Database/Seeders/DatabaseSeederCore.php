<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Database\Seeders\RolesAndPermissionsSeeder;
use Modules\Core\Database\Seeders\UsersTableSeeder;

class DatabaseSeederCore extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RolesAndPermissionsSeeder::class,
            UsersTableSeeder::class,
        ]);
    }
}
