<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Faker\Generator as Faker;
use Tests\Browser\Pages\Homepage;
use Tests\Browser\Pages\Dashboard;
use Tests\DuskTestCase;
use Facebook\WebDriver\WebDriverBy;
use Faker\Factory;
use Database\Factories\UserFactory;
use Tests\Traits\RefreshDatabaseWithSeeds;

class LoginTest extends DuskTestCase
{
    use RefreshDatabaseWithSeeds;
    private static function inputByLabelText($label)
    {
        return WebDriverBy::xpath("//input[@id=(//Label[contains(text(),'$label')]/@for)]");
    }
    private static function idOfLabel($browser, $label)
    {
        return $browser->driver->findElement(self::inputByLabelText($label))->getAttribute('id');
    }

    private static $userEmail = 'admin@example.com';

    /**
     * Test Register 
     */
    public function testRegister()
    {
        $faker = new UserFactory();
        $data = $faker->definition();
        $this->browse(function (Browser $browser) use ($data) {
            $browser->logout();
            $browser->visit(new Homepage)
                ->pause(1000)
                ->assertPresent('#menuBttn')
                ->click('#menuBttn')
                ->waitForText('Register', 1)
                ->clickLink('Register')
                ->assertRouteIs('register')
                ->type(
                    self::idOfLabel($browser, 'Email'),
                    $data['email']
                )->type(
                    self::idOfLabel($browser, 'Name'),
                    $data['name']
                )->type(
                    self::idOfLabel($browser, 'Password'),
                    'password'
                )
                ->type(
                    self::idOfLabel($browser, 'Confirm Password'),
                    'password'
                );
            $browser->screenshot('login1');
        });
    }
    /**
     * Test a false password 
     * 
     * @return void
     */
    public function testBasicLoginFailure()
    {
        $this->browse(function (Browser $browser) {
            $browser->logout();
            $browser->visit(new Homepage)
                ->click('#menuBttn')
                ->clickLink('Sign in');
            $Email = self::idOfLabel($browser, 'Email');
            $browser->type($Email, self::$userEmail);
            $Password = self::idOfLabel($browser, 'Password');
            $browser->type($Password, 'WrongPawword');
            $browser->press("LOGIN");
            $browser->assertSee('Something went wrong');
        });
    }
    /**
     * Test a Good password 
     * 
     * @return void
     */
    public function testBasicLoginSuccses()
    {
        $user = User::where('email',  self::$userEmail)->first();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->logout();

            $browser->visit(new Homepage)
                ->pause(1000)
                ->click('#menuBttn')
                ->waitForText('Sign in', 1)
                ->clickLink('Sign in')
                ->type(
                    self::idOfLabel($browser, 'Email'),
                    self::$userEmail
                )->type(
                    self::idOfLabel($browser, 'Password'),
                    'password'
                );
            $browser->press("LOGIN")
                ->assertRouteIs('dashboard')
                ->assertSee($user->name)
                ->screenshot('Login')
                ->assertAuthenticatedAs($user);
        });
    }

    /**
     * Test a false password 
     * 
     * @return void
     */
    public function testBasicLogout()
    {
        $user = User::where('email',  self::$userEmail)->first();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(new Dashboard)
                ->press($user->name)
                ->waitForText('Logout')
                ->press('Logout');
            $browser->screenshot('press');
        });
    }
}
