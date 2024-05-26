<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Activity;
use App\Models\Address;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserSeeder extends Seeder
{
    use DatabaseTransactions;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::inRandomOrder()->get();

        // Seed student.
        $students = User::factory(5)->create([
            'role_id' => RoleEnum::STUDENT->value,
            'address_id' => Address::inRandomOrder()->first()
        ]);

        foreach ($students as $student) {
            $student->activities()->sync(Activity::inRandomOrder()->get()->slice(0, 3)->pluck('id')->toArray());
            $student->courses()->sync($courses->slice(0, 1)->pluck('id')->toArray());
        }

        // Seed teacher.
        $teachers = User::factory(2)->create([
            'role_id' => RoleEnum::TEACHER->value,
            'address_id' => Address::inRandomOrder()->first()
        ]);

        foreach ($teachers as $teacher) {
            $teacher->courses()->sync($courses->slice(0, 5)->pluck('id')->toArray());
        }
    }
}
