<?php

namespace Tests\Browser;

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
}
