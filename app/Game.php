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
		'Red' 		=> '#fb1c1c',
		'Green' 	=> '#09f219',
		'Blue' 		=> '#1221f9',
		'Yellow'	=>'#f2e80b',
		'Purple' 	=> '#b70df2',
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
	 * Determines if a player is part of this game
	 */
	public function isValidPlayer($user_id) {
		return $this->users->find($user_id)->count() ? true : false;
	}


	public function getUnusedColorsAttribute() {
		$colors = self::$colors;
		foreach($this->users as $user) {
			if($color = $user->pivot->color) {
				$key = array_search($color, $colors);
				unset($colors[$key]);
			}
		}
		return $colors;
	}
}
