<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Grade;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'A',
            'B',
            'C',
            'D',
            'E'
        ];

        foreach (Grade::all() as $grade) {
            foreach ($types as $type) {
                $course = Course::where('name', $type)->where('grade_id', $grade->id)->first() ?? new Course();

                $course->grade()->associate($grade);
                $course->name = $type;
                $course->save();
            }
        }
    }
}
