<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\StorePersonRequest;

class PersonController extends ApiController
{
	public function index()
	{
		return Auth::user()->people;
	}

	public function show($id)
	{
		return Auth::user()->people()->findOrFail($id);
	}

	public function store(StorePersonRequest $request)
	{
		return Auth::user()->people()->create([
			'name' => $request->name,
			'birthday' => $request->birthday,
			'parent' => $request->parent,
		]);
	}

	public function update(Request $request)
	{
		$person = Auth::user()->people()->findOrFail($request->id);
		$person->name = $request->name ?? $person->name;
		$person->birthday = $request->birthday ?? $person->birthday;
		$person->parent = $request->parent ?? $person->parent;
		$person->save();
		return $person;
	}

	public function destroy($id)
	{
		return Auth::user()->people()->findOrFail($id)->delete();
	}
}
