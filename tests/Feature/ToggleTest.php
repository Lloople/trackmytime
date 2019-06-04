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
    public function toggling_the_first_time_creates_a_start_timesheet()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->postJson(route('track.toggle'), [
            'comment' => 'Put Captain Solo in the cargo hold.'
        ]);

        $response->assertSuccessful();

        $timesheet = Timesheet::first();
        $this->assertEquals($timesheet->user_id, $user->id);
        $this->assertNull($timesheet->end_at);
        $this->assertNull($timesheet->duration);
        $this->assertNotNull($timesheet->start_at);
        $this->assertEquals($timesheet->comment, 'Put Captain Solo in the cargo hold.');
    }

    /** @test */
    public function toggling_the_second_time_fills_the_previously_created_timesheet()
    {
        $user = factory(User::class)->create();

        $timesheet = factory(Timesheet::class)->create([
            'user_id' => $user->id,
            'comment' => 'He\'s no good to me dead.',
            'start_at' => now()->subHours(3)
        ]);

        $response = $this->actingAs($user)->postJson(route('track.toggle'), [
            'comment' => 'Put Captain Solo in the cargo hold.'
        ]);

        $response->assertSuccessful();

        $this->assertEquals(1, Timesheet::count());

        $timesheet = Timesheet::first();
        $this->assertEquals($timesheet->user_id, $user->id);
        $this->assertNotNull($timesheet->end_at);
        $this->assertNotNull($timesheet->start_at);
        $this->assertEquals($timesheet->duration, $timesheet->end_at->diffInMinutes($timesheet->start_at));
        $this->assertEquals($timesheet->comment, 'Put Captain Solo in the cargo hold.');
    }
}
