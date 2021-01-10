<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class hasAdminTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDatabaseModel()
    {
        $user =User::find(1);
        $this->assertTrue($user->email == "admin@example.com", "Assert that the first user is Admin");
    }
}
