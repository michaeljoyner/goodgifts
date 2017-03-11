<?php


use App\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     *@test
     */
    public function a_user_can_log_in()
    {
        $credentials = ['email' => 'joe@example.com', 'password' => 'password'];
        factory(User::class)->create($credentials);

        $response = $this->post('/admin/login', $credentials);

        $response->assertRedirect('/admin');
        $this->assertTrue(auth()->check());
        $this->assertEquals($credentials['email'], auth()->user()->email);
    }
}