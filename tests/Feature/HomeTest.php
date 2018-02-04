<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeTest extends TestCase
{
	use DatabaseMigrations, DatabaseTransactions;

	/** @test */
	public function homeContent()
	{
		$response = $this->get('/');

		$response->assertStatus(200);
		$response->assertSee('Lazy Uncle');
	}
}
