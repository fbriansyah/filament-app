<?php

namespace Tests\Feature;

use App\Enums\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that unauthenticated users are redirected to the login page.
     */
    public function test_unauthenticated_users_are_redirected_to_login(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    /**
     * Test that the login page is accessible.
     */
    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
    }

    /**
     * Test that the login page contains email and password fields.
     */
    public function test_login_page_contains_login_form(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('Email');
        $response->assertSee('Password');
    }

    /**
     * Test that an active user can be authenticated and access admin.
     */
    public function test_active_user_can_access_admin_when_authenticated(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'status' => Status::Active->value,
        ]);

        // Simulate successful login by acting as the user
        $this->actingAs($user);

        $response = $this->get('/admin');
        $response->assertStatus(200);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test that an inactive user cannot access the admin panel.
     */
    public function test_inactive_user_cannot_access_admin_panel(): void
    {
        $user = User::factory()->create([
            'email' => 'inactive@example.com',
            'password' => bcrypt('password'),
            'status' => Status::Inactive->value,
        ]);

        $this->actingAs($user)
            ->get('/admin')
            ->assertStatus(403);
    }

    /**
     * Test that a blocked user cannot access the admin panel.
     */
    public function test_blocked_user_cannot_access_admin_panel(): void
    {
        $user = User::factory()->create([
            'email' => 'blocked@example.com',
            'password' => bcrypt('password'),
            'status' => Status::Blocked->value,
        ]);

        $this->actingAs($user)
            ->get('/admin')
            ->assertStatus(403);
    }

    /**
     * Test that authentication fails with non-existent email.
     */
    public function test_authentication_fails_with_nonexistent_email(): void
    {
        $result = Auth::attempt([
            'email' => 'nonexistent@example.com',
            'password' => 'password',
        ]);

        $this->assertFalse($result);
        $this->assertGuest();
    }

    /**
     * Test that authentication fails with wrong password.
     */
    public function test_authentication_fails_with_wrong_password(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'status' => Status::Active->value,
        ]);

        $result = Auth::attempt([
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $this->assertFalse($result);
        $this->assertGuest();
    }

    /**
     * Test that an authenticated active user can access the admin panel.
     */
    public function test_authenticated_active_user_can_access_admin(): void
    {
        $user = User::factory()->create([
            'status' => Status::Active->value,
        ]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(200);
    }

    /**
     * Test that a user can log out.
     */
    public function test_user_can_logout(): void
    {
        $user = User::factory()->create([
            'status' => Status::Active->value,
        ]);

        $this->actingAs($user);

        $response = $this->post('/admin/logout');

        $response->assertRedirect();
        $this->assertGuest();
    }
}
