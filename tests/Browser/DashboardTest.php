<?php

namespace Tests\Browser;

use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DashboardTest extends DuskTestCase
{

    use DatabaseMigrations;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create(['name' => 'Marta']);
    }

    /** @test */
    public function can_see_dashboard_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('dashboard')
                ->assertSee('Welcome, Marta 👋');
        });
    }

    /** @test */
    public function can_start_tracking()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('dashboard')
                ->press('START TRACKING')
                ->waitForReload()
                ->assertSee('STOP TRACKING');
        });

        $this->user->refresh();

        $this->assertNotNull($this->user->tracking_since);
    }

    /** @test */
    public function can_stop_tracking()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('dashboard')
                ->press('START TRACKING')
                ->waitForReload()
                ->press('STOP TRACKING')
                ->waitForReload()
                ->assertSee('START TRACKING');
        });

        $this->user->refresh();

        $this->assertNull($this->user->tracking_since);
        $this->assertDatabaseHas('timesheets', ['user_id' => $this->user->id]);
    }

    /** @test */
    public function can_create_a_timesheet()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('dashboard')
                ->press('CREATE')
                ->type('@start', '10')
                ->type('@end', '12')
                ->type('@comment', 'First timesheet')
                ->press('SAVE')
                ->waitForReload()
                ->assertSee('First timesheet');
        });
    }

    /** @test */
    public function can_edit_a_timesheet()
    {
        factory(Timesheet::class)->create([
            'user_id' => $this->user->id,
            'start_at' => now()->format('Y-m-d 12:15:00'),
            'end_at' => now()->format('Y-m-d 13:00:00'),
            'duration' => '45',
            'comment' => 'First timesheet'
        ]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->user)
                ->visit('dashboard')
                ->click('@container-start')
                ->type('@start', '12:00')
                ->type('@end', '13:00')
                ->type('@comment', 'First timesheet modified')
                ->press('SAVE')
                ->pause(250)
                ->assertSee('First timesheet modified');
        });

        $this->assertDatabaseHas('timesheets', [
            'start_at' => now()->format('Y-m-d 12:00:00'),
            'duration' => 60,
            'comment' => 'First timesheet modified'
        ]);
    }

}
