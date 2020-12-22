<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomePageTest extends DuskTestCase
{
   /**
    * Gli utenti ospiti devono poter vedere la homepage.
    * @test
    */
    public function a_guest_can_visit_the_homepage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('by Marco Consiglio');
        });
    }
}
