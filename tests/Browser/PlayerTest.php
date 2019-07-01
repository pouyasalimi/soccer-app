<?php

namespace Tests\Browser;

use App\Models\Player;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PlayerTest extends DuskTestCase
{
    protected $user;
    public $pause = 2000;
    public $appUrl;
    public $faker;

    public function setUp(): void {

        parent::setUp();
        $this->appUrl = env( 'APP_URL' );
        $this->faker  = \Faker\Factory::create();
    }

    /**
     * @throws \Throwable
     */
    public function login() {
        $email = "admin@test.com";
        $pass  = "admin";
        $this->browse( function ( Browser $browser ) use ( $email, $pass ) {

            $browser->visit( '/login' )
                    ->waitForText( 'Register' )
                    ->type( '#email', $email )
                    ->type( '#password', $pass )
                    ->pressAndWaitFor( 'Login' )
                    ->pause( $this->pause )
                    ->assertUrlIs( $this->appUrl . '/dashboard' );
        } );
    }

    /**
     * @throws \Throwable
     */
    public function test_create_player() {
        $this->login();
        $this->browse( function ( Browser $browser ) {
            $this->faker->addProvider( new \Faker\Provider\TeamProvider( $this->faker ) );
            $name = $this->faker->name;
            $email = $this->faker->email;
            $browser->visit( '/players' )
                    ->waitForText( 'Players List' )
                    ->assertSee( 'Players List' )
                    ->clickLink( 'New Player' )
                    ->pause( $this->pause )
                    ->type( '#name', $name )
                    ->type( '#email', $email )
                    ->type( '#password', 'admin' )
                    ->type( '#password_confirmation', 'admin' )
                    ->pressAndWaitFor( 'Create' )
                    ->pause( $this->pause )
                    ->assertUrlIs( $this->appUrl . '/players' );
            $this->assertDatabaseHas( 'users', [ 'name' => $name ] );
        } );
    }

    /**
     * @throws \Throwable
     */
    public function test_delete_player() {

        $this->browse( function ( Browser $browser ) {

            $browser->visit( '/players' )
                    ->waitForText( 'Players List' )
                    ->pause( $this->pause )
                    ->assertSee( 'Players List' )
                    ->pause( $this->pause );
            $browser->with( '.table', function ( Browser $table ) {

                $player = Player::latest( 'id' )->first();
                $table->assertSee( $player->user->name )
                      ->clickLink( 'Delete' )
                      ->acceptDialog()
                      ->pause( $this->pause )
                      ->assertUrlIs( $this->baseUrl() . '/players' )
                      ->pause( $this->pause )
                      ->assertDontSee( $player->name );

            } );
        } );
    }

    /**
     * @throws \Throwable
     */
    public function test_update_player() {

        $this->browse( function ( Browser $browser ) {
            $newName  = $this->faker->name;
            $newEmail = $this->faker->email;
            $newPass  = '123456';
            $browser->visit( '/players' )
                    ->waitForText( 'Players List' )
                    ->pause( $this->pause )
                    ->assertSee( 'Players List' )
                    ->pause( $this->pause );
            $browser->with( '.table', function ( Browser $table ) {
                $player = Player::latest( 'id' )->first();

                $table->assertSee( $player->user->name )
                      ->clickLink( 'Edit' );

            } );
            $browser->pause( $this->pause )
                    ->type( '#name', $newName )
                    ->type( '#email', $newEmail )
                    ->type( '#password', $newPass )
                    ->type( '#password_confirmation', $newPass )
                    ->pause( $this->pause )
                    ->pressAndWaitFor( 'Update' )
                    ->pause( $this->pause )
                    ->assertUrlIs( $this->baseUrl() . '/players' );
            $this->assertDatabaseHas( 'users', [ 'name' => $newName ] );
        } );
    }
}
