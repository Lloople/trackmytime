<?php

namespace Tests\Feature;

use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TimesheetsTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_create_new_timesheet()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->postJson(route('track.toggle'), [
            'comment' => 'Put Captain Solo in the cargo hold.'
        ]);

        $response->assertSuccessful();

        $timesheet = Timesheet::first();
        $this->assertEquals($timesheet->user_id, $user->id);
        $this->assertEquals($timesheet->end_at, null);
        $this->assertNotNull($timesheet->start_at);
        $this->assertEquals($timesheet->comment, 'Put Captain Solo in the cargo hold.');
    }

    /** @test */
    public function second_click_will_finish_the_current_timesheet()
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
        $this->assertEquals($timesheet->comment, 'Put Captain Solo in the cargo hold.');
    }
}
