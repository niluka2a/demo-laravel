<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Teacher', 'Student'];

        foreach ($types as $type) {
            Role::firstOrCreate(['name' => $type]);
        }
    }
}
