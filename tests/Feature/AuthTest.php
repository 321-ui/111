<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
	use RefreshDatabase;

	public function test_login_page_renders_successfully(): void
	{
		$response = $this->get('/login');

		$response->assertStatus(200);
		$response->assertViewIs('auth.login');
	}

	public function test_registration_page_renders_successfully(): void
	{
		$response = $this->get('/register');

		$response->assertStatus(200);
		$response->assertViewIs('auth.register');
	}

	public function test_user_can_login_with_valid_credentials(): void
	{
		$user = User::factory()->create([
			'email' => 'test@example.com',
			'password' => bcrypt('password123'),
		]);

		$response = $this->post('/login', [
			'email' => 'test@example.com',
			'password' => 'password123',
		]);

		$response->assertRedirect();
		$this->assertAuthenticatedAs($user);
	}

	public function test_user_cannot_login_with_invalid_credentials(): void
	{
		$user = User::factory()->create([
			'email' => 'test@example.com',
			'password' => bcrypt('password123'),
		]);

		$response = $this->post('/login', [
			'email' => 'test@example.com',
			'password' => 'wrongpassword',
		]);

		$response->assertSessionHasErrors('email');
		$this->assertGuest();
	}

	public function test_user_can_register(): void
	{
		$response = $this->post('/register', [
			'full_name' => 'Test User',
			'email' => 'newuser@example.com',
			'password' => 'password123',
			'phone' => '+79001234567',
		]);

		$response->assertRedirect();
		$this->assertDatabaseHas('users', [
			'email' => 'newuser@example.com',
		]);
	}

	public function test_registration_requires_valid_email(): void
	{
		$response = $this->post('/register', [
			'full_name' => 'Test User',
			'email' => 'not-an-email',
			'password' => 'password123',
			'phone' => '+79001234567',
		]);

		$response->assertSessionHasErrors('email');
	}

	public function test_registration_requires_unique_email(): void
	{
		User::factory()->create(['email' => 'existing@example.com']);

		$response = $this->post('/register', [
			'full_name' => 'Test User',
			'email' => 'existing@example.com',
			'password' => 'password123',
			'phone' => '+79001234567',
		]);

		$response->assertSessionHasErrors('email');
	}

	public function test_user_can_logout(): void
	{
		$user = User::factory()->create();

		$response = $this->actingAs($user)->post('/logout');

		$response->assertRedirect('/');
		$this->assertGuest();
	}
}