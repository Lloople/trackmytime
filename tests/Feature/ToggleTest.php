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
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->postJson(route('track.toggle'), [
            'comment' => 'Put Captain Solo in the cargo hold.'
        ]);

        $response->assertSuccessful();

        $timesheet = Timesheet::first();
        $this->assertEquals($timesheet->user_id, $user->id);
        $this->assertEquals(Timesheet::START, $timesheet->action);
        $this->assertEquals($timesheet->comment, 'Put Captain Solo in the cargo hold.');
    }

    /** @test */
    public function toggling_the_second_time_creates_a_end_timesheet()
    {
        $user = factory(User::class)->create();

        factory(Timesheet::class)->create([
            'user_id' => $user->id,
            'comment' => 'He\'s no good to me dead.',
            'created_at' => now()->subHours(3),
            'action' => Timesheet::START
        ]);

        $response = $this->actingAs($user)->postJson(route('track.toggle'), [
            'comment' => 'Put Captain Solo in the cargo hold.'
        ]);

        $response->assertSuccessful();

        $this->assertEquals(2, Timesheet::count());

        $this->assertDatabaseHas('timesheets', [
            'action' => Timesheet::END,
            'comment' => 'Put Captain Solo in the cargo hold.'
        ]);
    }
}
