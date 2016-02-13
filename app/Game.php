<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Game extends Model
{
	public static $rules = [
		'users' => 'required|array'
	];

	/**
	 * The users playing this game
	 */
	public function users()
	{
		return $this->belongsToMany('App\User')->withPivot(
			'color',
			'name',
			'dead',
			'turnt',
			'booted'
		);
	}

	public static $colors = [
		'#fb1c1c',
		'#09f219',
		'#1221f9',
		'#f2e80b',
		'#b70df2',
	];

	public static function createNew($data = null) {
		// dd($data);
		$game = self::create();

		// Link players to this game
		foreach(User::all() as $i => $user) {
			$game->users()->attach($user, [
				'color' => Game::$colors[$i],
				'name' => $user->name,
				'turnt' => ($i==0),
			]);
		}

		return true;
	}
}
