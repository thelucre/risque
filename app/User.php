<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'name', 'email', 'password',
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [
			'password', 'remember_token',
	];

	/**
	 * The games played by this user
	 */
	public function games()
	{
			return $this->belongsToMany('App\Game')->withPivot(
				'color',
				'name',
				'dead',
				'turnt',
				'booted'
			);
	}

}
