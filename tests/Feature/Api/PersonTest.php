<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Person;

class PersonTest extends TestCase
{
	use DatabaseMigrations, DatabaseTransactions;

	protected function createPerson($user_id)
	{
		return factory(Person::class)->create([
			'user_id' => $user_id
		]);
	}

	/** @test */
	public function userCanAddPerson()
	{
		$user = $this->createUser();
		$token = auth()->login($user);

		$person = factory(Person::class)->make();

		$request = $this->json('POST', route('api.person.store'), $person->toArray());
		$request->assertStatus(200);
		$request->assertJsonStructure(['name', 'birthday', 'parent', 'user_id', 'updated_at', 'created_at', 'id', ]);
	}

	/** @test */
	public function userCanGetPersonDetails()
	{
		$user = $this->createUser();
		$token = auth()->login($user);
		$person = $this->createPerson($user->id);

		$request = $this->json('GET', route('api.person.show', ['id' => $person->id]));
		$request->assertStatus(200);
		$request->assertJsonStructure(['name', 'birthday', 'parent', 'user_id', 'updated_at', 'created_at', 'id', ]);
	}

	/** @test */
	public function userCanGetAssociatedPeople()
	{
		$user = $this->createUser();
		$token = auth()->login($user);
		$person = $this->createPerson($user->id);

		$request = $this->json('GET', route('api.person.index'));
		$request->assertStatus(200);
		$request->assertJsonStructure([['name', 'birthday', 'parent', 'user_id', 'updated_at', 'created_at', 'id', ]]);
	}

	/** @test */
	public function userCanPatchPerson()
	{
		$user = $this->createUser();
		$token = auth()->login($user);
		$person = $this->createPerson($user->id);

		$request = $this->json('PATCH', route('api.person.update', ['id' => $person->id]), ['name' => 'new name']);
		$request->assertStatus(200);
		$request->assertSee('new name');
	}
}
