<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class ActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Game A',
            'Game B',
            'Game C',
            'Game D',
            'Game E',
            'Game F',
            'Game G',
            'Game H',
            'Game I'
        ];

        foreach ($types as $type) {
            $subject = Subject::inRandomOrder()->first();

            $activity = Activity::where('name', $type)->where('subject_id', $subject->id)->first() ?? new Activity();

            $activity->subject()->associate($subject);
            $activity->name = $type;
            $activity->save();
        }
    }
}
