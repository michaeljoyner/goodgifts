<?php

namespace Tests\Feature;


use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations;
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

    /**
     *@test
     */
    public function a_logged_in_user_can_log_out()
    {
        $this->actingAs(factory(User::class)->create());

        $response = $this->post('/admin/logout');

        $response->assertRedirect('/');
        $this->assertFalse(auth()->check());
    }

    /**
     *@test
     */
    public function a_guest_user_cant_access_the_dashboard()
    {
        $this->assertFalse(auth()->check());

        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }
}