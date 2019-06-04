<?php

namespace Tests\Feature;

use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_shows_the_total_worked_today()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        factory(Timesheet::class)->create(['user_id' => $user->id, 'start_at' => now()->subHours(3), 'end_at' => now()->addHours(3), 'duration' => 360]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertSuccessful();

        $response->assertSeeText('You\'ve worked 6 hours today');
    }
}
