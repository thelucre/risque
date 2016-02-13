<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Game extends Model
{

	protected $fillable = ['name', 'card_type', 'neutrals'];

	public static $rules = [
		'users' => 'required|array'
	];

	public static $card_settings = [
		'cycle' => 'Cycle',
		'ramped' => 'Ramped',
	];

	public static $colors = [
		'#fb1c1c',
		'#09f219',
		'#1221f9',
		'#f2e80b',
		'#b70df2',
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

	public static function createNew($data = null) {
		$game = self::create($data);
		$game->neutrals = array_key_exists("neutrals",$data) ? 1 : 0;

		// Link players to this game
		foreach(User::all() as $i => $user) {
			$game->users()->attach($user, [
				'color' => Game::$colors[$i],
				'name' => $user->name,
				'turnt' => ($i==0),
			]);
		}

		$game->save();

		return true;
	}
}
