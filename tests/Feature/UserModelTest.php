<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserModelTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     * @test
     * @return void
     */
    public function BasicCreate()
    {
        $data = [
            'name' => 'john',
            'email' => 'john@exmaple.com',
            'password' => Hash::make('password'),
        ];
        $user = User::firstOrCreate($data);
        $this->assertNotNull($user);
    }
}
