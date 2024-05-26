<?php

namespace Tests\Feature;

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
            'role_id' => 2,
            'address_id' => Address::inRandomOrder()->first()
        ]);
        $user->activities()->sync(Activity::inRandomOrder()->get()->slice(0, 3)->pluck('id')->toArray());
        $user->courses()->sync(Course::inRandomOrder()->get()->slice(0, 1)->pluck('id')->toArray());

        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/users/' . $user->id, ['Accept' => 'application/json']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'role',
                'address',
                'activities',
                'courses',
            ]
        ]);
    }
}
