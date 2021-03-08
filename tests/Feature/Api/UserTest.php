<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class UserTest extends TestCase
{
	use DatabaseMigrations, DatabaseTransactions;

	/** @test */
	public function canRegisterUser()
	{
		$request = $this->json('POST', route('api.user.store'), [
			'name' => 'test',
			'email' => 'email@example.com',
			'password' => 'testing',
			'password_confirmation' => 'testing',
		]);
		$request->assertStatus(200);
	}

	/** @test */
	public function emailRequiredToRegister()
	{
		$request = $this->json('POST', route('api.user.store'), [
			'name' => 'test',
			'password' => 'testing',
			'password_confirmation' => 'testing',
		]);
		$request->assertStatus(422);
		$request->assertJsonStructure(['message', 'errors']);
		$request->assertSee('The email field is required.');
	}

	/** @test */
	public function nameRequiredToRegister()
	{
		$request = $this->json('POST', route('api.user.store'), [
			'email' => 'email@example.com',
			'password' => 'testing',
			'password_confirmation' => 'testing',
		]);
		$request->assertStatus(422);
		$request->assertJsonStructure(['message', 'errors']);
		$request->assertSee('The name field is required.');
	}

	/** @test */
	public function passwordRequiredToRegister()
	{
		$request = $this->json('POST', route('api.user.store'), [
			'name' => 'test',
			'email' => 'email@example.com',
		]);
		$request->assertStatus(422);
		$request->assertJsonStructure(['message', 'errors']);
		$request->assertSee('The password field is required.');
	}

	/** @test */
	public function passwordMustBeConfirmedToRegister()
	{
		$request = $this->json('POST', route('api.user.store'), [
			'name' => 'test',
			'email' => 'email@example.com',
			'password' => 'testing',
		]);
		$request->assertStatus(422);
		$request->assertJsonStructure(['message', 'errors']);
		$request->assertSee('The password confirmation does not match.');
	}

	/** @test */
	public function canLogin()
	{
		$user = $this->createUser(['password' => bcrypt('testpass')]);

		$request = $this->json('POST', route('api.auth.login'), [
			'email' => $user->email,
			'password' => 'testpass',
		]);
		$request->assertStatus(200);
		$request->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
	}
}
