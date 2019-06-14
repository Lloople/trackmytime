<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_log_in()
    {
        factory(User::class)->create(['email' => 'user@tmt.com', 'password' => Hash::make('usertmt')]);

        $this->browse(function (Browser $browser) {

            $browser->visitRoute('login')
                    ->type('email', 'user@tmt.com')
                    ->type('password', 'usertmt')
                    ->press('LOGIN')
                    ->assertPathIs('/dashboard');
        });
    }
}
