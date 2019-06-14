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
}
