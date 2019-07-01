<?php

namespace Tests\Browser;

use App\Models\Team;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TeamTest extends DuskTestCase {

    protected $user;
    public $pause = 2000;
    public $faker;

    public function setUp(): void {

        parent::setUp();
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
    public function test_create_team() {
        $this->login();
        $this->browse( function ( Browser $browser ) {
            $this->faker->addProvider( new \Faker\Provider\TeamProvider( $this->faker ) );
            $browser->visit( '/teams' )
                    ->waitForText( 'Teams List' )
                    ->assertSee( 'Teams List' )
                    ->clickLink( 'New Team' )
                    ->pause( $this->pause )
                    ->type( '#name', $this->faker->teamName() )
                    ->pressAndWaitFor( 'Create' )
                    ->pause( $this->pause )
                    ->assertUrlIs( $this->appUrl . '/teams' );
        } );
    }

    /**
     * @throws \Throwable
     */
    public function test_delete_team() {

        $this->browse( function ( Browser $browser ) {

            $browser->visit( '/teams' )
                    ->waitForText( 'Teams List' )
                    ->pause( $this->pause )
                    ->assertSee( 'Teams List' )
                    ->pause( $this->pause );
            $browser->with( '.table', function ( Browser $table ) {

                $team = Team::latest( 'id' )->first();
                $table->assertSee( $team->name )
                      ->clickLink( 'Delete' )
                      ->acceptDialog()
                      ->pause( $this->pause )
                      ->assertUrlIs( $this->appUrl . '/teams' )
                      ->pause( $this->pause )
                      ->assertDontSee( $team->name );

            } );
        } );
    }

    /**
     * @throws \Throwable
     */
    public function test_update_team() {

        $this->browse( function ( Browser $browser ) {
            $this->faker->addProvider( new \Faker\Provider\TeamProvider( $this->faker ) );
            $newTeamName = $this->faker->teamName();
            $browser->visit( '/teams' )
                    ->waitForText( 'Teams List' )
                    ->pause( $this->pause )
                    ->assertSee( 'Teams List' )
                    ->pause( $this->pause );
            $browser->with( '.table', function ( Browser $table ) {
                $team = Team::latest( 'id' )->first();

                $table->assertSee( $team->name )
                      ->clickLink( 'Edit' );

            } );
            $browser->pause( $this->pause )
                ->type( '#name', $newTeamName )
                ->pause( $this->pause )
                ->pressAndWaitFor( 'Update' )
                ->pause( $this->pause )
                ->assertUrlIs($this->baseUrl() . '/teams');
            $this->assertDatabaseHas( 'teams', [ 'name' => $newTeamName ] );
        } );
    }
}
