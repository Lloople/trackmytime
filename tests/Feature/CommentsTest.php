<?php

namespace Tests\Feature;

use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentsTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function can_update_a_comment()
    {
        $user = factory(User::class)->create();

        $timesheet = factory(Timesheet::class)->create([
            'user_id' => $user->id,
            'start_at' => now(),
            'end_at' => now()
        ]);

        $response = $this->actingAs($user)->putJson(route('timesheets.comment.update', $timesheet), [
            'comment' => 'First comment 🙌'
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('timesheets', ['id' => $timesheet->id, 'comment' => 'First comment 🙌']);
    }
}
