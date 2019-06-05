<?php

namespace Tests\Feature;

use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackingTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_create_timesheet_without_end()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->postJson(route('track.store'), [
            'start_at' => now()->subHours(3)->format('Y-m-d H:i:s'),
            'comment' => 'Put Captain Solo in the cargo hold.'
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('timesheets', [
            'user_id' => $user->id,
            'start_at' => now()->subHours(3),
            'end_at' => null,
            'duration' => null,
            'comment' => 'Put Captain Solo in the cargo hold.',
        ]);
    }

    /** @test */
    public function duration_is_calculated()
    {

        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->postJson(route('track.store'), [
            'start_at' => now()->subHours(3)->format('Y-m-d H:i:s'),
            'end_at' => now()->format('Y-m-d H:i:s'),
            'comment' => 'Put Captain Solo in the cargo hold.'
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('timesheets', [
            'user_id' => $user->id,
            'start_at' => now()->subHours(3),
            'end_at' => now(),
            'duration' => 180,
            'comment' => 'Put Captain Solo in the cargo hold.',
        ]);
    }
}
