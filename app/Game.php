<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Base;
use App\User;

class Game extends Base
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
		'red' 		=> '#fb1c1c',
		'green' 	=> '#09f219',
		'blue' 		=> '#1221f9',
		'yellow'	=>'#f2e80b',
		'purple' 	=> '#b70df2',
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
		$game->changeState(self::$states['WAITING_FOR_PLAYERS']);

		// Link players to this game
		foreach(User::all() as $i => $user) {
			$game->users()->attach($user, [
				'name' => $user->name,
			]);
		}

		$game->save();

		return $game;
	}

	/**
	 * Determines if a player is part of this game
	 */
	public function isValidPlayer($user_id) {
		return $this->users->find($user_id)->count() ? true : false;
	}


	/**
	 * Based on the current player settings, determine whic colors are still
	 * available to choose
	 */
	public function getUnusedColorsAttribute() {
		$colors = self::$colors;
		foreach($this->users as $user) {
			if($color = $user->pivot->color) {
				if(array_key_exists($color, $colors))
					unset($colors[$color]);
			}
		}
		return $colors;
	}

	/**
	 *
	 */
	public function updatePlayerSettings($data) {
		$player = $this->getPlayer($data['user_id']);

		if(array_key_exists($data['color'], $this->unused_colors)
			|| $player->pivot->color == $data['color']) {

			$this->checkPlayersReady();
			$player->pivot->color = $data['color'];
			$player->pivot->name = $data['name'];
			$player->pivot->save();
			return true;
		}

		return false;
	}

	/**
	 * If all players have updated their settings, the game is ready to start
	 */
	public function checkPlayersReady() {
		foreach($this->users as $user) {
			if(empty($user->pivot->color)) return false;

			$this->changeState(self::$states['PLAYER_TURN']);
		}
	}

	/**
	 * Update the game state
	 */
	public function changeState($state) {
		$this->state = $state;
		$this->save();
	}

	public function getPlayer($user_id) {
		return $this->users->find($user_id);
	}

	public function getJsonMap() {
		$data = $this->dataAsJson();
		return json_encode($data['map']);
	}

	public function getColorsAttribute() {
		return json_encode(self::$colors);
	}
}
