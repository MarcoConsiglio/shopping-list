<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomePageTest extends DuskTestCase
{
    use DatabaseMigrations;

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

    /**
     * Un utente può accedere all'indice delle liste dalla
     * homepage.
     * @test
     */
    public function a_user_can_access_shopping_list_index() {
        $user = User::factory()->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/')
                    ->assertSeeLink('Le tue liste')
                    ->clickLink('Le tue liste')
                    ->assertRouteIs("shopping_list.index");
        });
    }
}
