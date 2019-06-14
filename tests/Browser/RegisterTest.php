<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{

    use DatabaseMigrations;

    /** @test */
    public function cannot_register_with_the_same_email()
    {
        factory(User::class)->create(['email' => 'registered@tmt.com']);

        $this->browse(function (Browser $browser) {
            $browser->visitRoute('register')
                ->type('email', 'registered@tmt.com')
                ->type('name', 'User')
                ->type('password', 'trackmytime')
                ->type('password_confirmation', 'trackmytime')
                ->type('city', 'Girona')
                ->select('timezone', 'Europe/Madrid')
                ->press('REGISTER')
                ->assertPathIs('/register')
                ->assertSee('The email has already been taken');
        });
    }

    /** @test */
    public function can_register_a_user()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('register')
                ->type('email', 'user@tmt.com')
                ->type('name', 'User')
                ->type('password', 'trackmytime')
                ->type('password_confirmation', 'trackmytime')
                ->type('city', 'Girona')
                ->select('timezone', 'Europe/Madrid')
                ->press('REGISTER')
                ->assertPathIs('/dashboard');

            $this->assertDatabaseHas('users', [
                'name' => 'User',
                'email' => 'user@tmt.com',
                'city' => 'Girona',
                'timezone' => 'Europe/Madrid'
            ]);
        });
    }
}
