<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class HomeTest extends DuskTestCase
{
    /** @test */
    public function can_visit_homepage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Track My Time');
        });
    }
}
