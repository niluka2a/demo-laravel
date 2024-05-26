<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Computer Science',
            'Science',
            'Mathematics',
            'Engineering',
            'Physics',
            'Art',
            'Drama',
            'Social Studies',
            'English',
            'Health',
            'History'
        ];

        foreach ($types as $type) {
            Subject::firstOrCreate(['name' => $type]);
        }
    }
}
