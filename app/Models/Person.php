<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
	protected $guarded = [];

	protected $dates = [
		'created_at',
		'updated_at',
	];

	protected $casts = [
		'birthday' => 'date:m-d-Y',
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
