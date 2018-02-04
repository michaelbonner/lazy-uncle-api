<?php

namespace App\Http\Controllers\Api;

use JWTAuth;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;

class UserController extends ApiController
{
	public function show()
	{
		return Auth::user();
	}

	public function store(StoreUserRequest $request)
	{
		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password),
		]);
		return JWTAuth::fromUser($user);
	}
}
