<?php

namespace Tests\Feature;

use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToggleTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function toggling_the_first_time()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->postJson(route('track.toggle'));

        $response->assertSuccessful();

        $this->assertDatabaseMissing('timesheets', ['user_id' => $user->id]);

        $user->refresh();
        $this->assertNotNull($user->tracking_since);
    }

    /** @test */
    public function toggling_the_second_time_fills_the_previously_created_timesheet()
    {
        $user = factory(User::class)->create(['tracking_since' => now()->subHours(3)]);

        $response = $this->actingAs($user)->postJson(route('track.toggle'));

        $response->assertSuccessful();

        $this->assertEquals(1, Timesheet::count());

        $timesheet = Timesheet::first();
        $this->assertEquals($timesheet->user_id, $user->id);
        $this->assertNotNull($timesheet->end_at);
        $this->assertNotNull($timesheet->start_at);
        $this->assertEquals($timesheet->duration, $timesheet->end_at->diffInMinutes($timesheet->start_at));

        $user->refresh();
        $this->assertNull($user->tracking_since);
    }
}
