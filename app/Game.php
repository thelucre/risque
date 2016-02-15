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

	public static $states = [
		// Players must accept the game and choose their name / color
		'WAITING_FOR_PLAYERS' => 'waiting_for_players',
		// Player turn cycled through
		'PLAYER_TURN' => 'player_turn',
		// Player is currently playing a turn
		'TURN_IN_PROGRESS' => 'turn_in_progress',
		// Game is over and winner is decided
		'FINISHED' => 'finished',
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
		$game->state = self::$states['WAITING_FOR_PLAYERS'];

		// Link players to this game
		foreach(User::all() as $i => $user) {
			$game->users()->attach($user, [
				'name' => $user->name,
				'turnt' => ($i==0),
			]);
		}

		$game->save();

		return true;
	}

	/**
	 * Determines if a player is part of a given game
	 */
	public function isValidPlayer($user_id) {
		$user = $this->users->filter(function($user) use ($user_id) {
			return $user->id == 45;//$user_id;
		});
		return $user->count();
	}
}
