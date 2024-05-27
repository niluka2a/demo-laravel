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

class UserTest extends TestCase {
    use DatabaseTransactions, WithFaker;

    /**
     * Test student end-point.
     *
     * @return void
     */
    public function testShowUserEndpoint(): void {
        $user = User::factory()->create([
            'role_id' => RoleEnum::STUDENT->value,
            'address_id' => Address::inRandomOrder()->first()
        ]);
        $user->activities()->sync(Activity::inRandomOrder()->get()->slice(0, 3)->pluck('id')->toArray());
        $user->courses()->sync(Course::inRandomOrder()->get()->slice(0, 1)->pluck('id')->toArray());

        $user->refresh();

        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/users/' . $user->id, ['Accept' => 'application/json']);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->role->name,
                'address' => [
                    'id' => $user->address->id,
                    'line_1' => $user->address->line_1,
                    'line_2' => $user->address->line_2,
                    'city' => $user->address->city,
                    'zip_code' => $user->address->zip_code
                ],
                'activities' => [[
                    'id' => $user->activities->first()->id,
                    'name' => $user->activities->first()->name,
                    'subject' => $user->activities->first()->subject->name,
                    'score' => $user->activities->first()->score,
                ]],
                'courses' => [[
                    'id' => $user->courses->first()->id,
                    'name' => $user->courses->first()->name,
                    'grade' => $user->courses->first()->grade->name,
                ]],
            ]
        ]);
    }
}
