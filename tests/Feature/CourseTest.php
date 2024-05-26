<?php

namespace Tests\Feature;

use App\Enums\RoleEnum;
use App\Models\Activity;
use App\Models\Address;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseTest extends TestCase {
    use DatabaseTransactions, WithFaker;

    /**
     * Test student end-point.
     *
     * @return void
     */
    public function testViewAnyCoursesEndpoint(): void {
        $courses = Course::inRandomOrder()->get();

        // Create student.
        $student = User::factory()->create([
            'role_id' => RoleEnum::STUDENT->value,
            'address_id' => Address::inRandomOrder()->first()
        ]);
        $student->activities()->sync(Activity::inRandomOrder()->get()->slice(0, 3)->pluck('id')->toArray());
        $student->courses()->sync($courses->slice(0, 1)->pluck('id')->toArray());

        // Create teacher.
        $teacher = User::factory()->create([
            'role_id' => RoleEnum::TEACHER->value,
            'address_id' => Address::inRandomOrder()->first()
        ]);
        $teacher->courses()->sync($courses->slice(0, 3)->pluck('id')->toArray());

        // Send api request.
        $response = $this->actingAs($teacher, 'api')
            ->json('GET', '/api/courses', ['Accept' => 'application/json']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'grade',
                    'students'
                ]
            ]
        ]);
    }
}
