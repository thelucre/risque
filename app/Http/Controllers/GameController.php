<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Game;
use App\User;
use Auth;
use App;

class GameController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
			$this->middleware('auth');
	}

	/**
	 * The main game view
	 */
	public function index($id = null) {
		// Must have a game id
		if(empty($id)) App::abort(404);

		// Grab the game instance
		$game = Game::with('users')->findOrFail($id);

		// If the current user is not part of the game, abort
		if(!$game->isValidPlayer(Auth::user()->id)) App::abort(404);

		return layout('pages.game.index', ['game' => $game]);
	}

	/**
	 * Form to create a new game
	 */
	public function newGame() {
		return layout('pages.game.new');
	}

	/**
	 * POST - new game form
	 */
	public function createNewGame(Request $request) {
		if($game = Game::createNew($request->all())) {
			return redirect()->route('game index', $game->id);
		}

		echo('failed to make game');
		dd($request->all());
	}

	/**
	 * When a user updates their settings
	 */
	public function playerSettings(Request $request, $id) {
		// Grab the game instance
		$game = Game::with('users')->findOrFail($id);

		if($game->updatePlayerSettings($request->all())) {

			if($game->checkPlayersReady()) {

			}
		}

		return redirect()->route('game index', $game->id);
	}


	public function gameReset(Request $request, $id) {
		// Grab the game instance
		$game = Game::with('users')->findOrFail($id);
		if($game->state == 'waiting_for_players')
			return 'cant be state `waiting_for_players`';

		// Use the first map for now
		$d = App\Map::first()->dataAsJson();

		// TODO: Add column to map table for default units per tile
		$per_tile = 3;

		// TODO: Add column to map table for neutral density
		$neutral_density = 0.3;

		$user_count = $game->users->count();

		$tile_count = count($d['tiles']);

		$tiles_for_users = $tile_count;
		$tiles_for_neutrals = 0;

		if($game->neutrals) {
			$tiles_for_neutrals = floor($tile_count * $neutral_density);
			$tiles_for_users = $tile_count - $tiles_for_neutrals;

			// just in case, if total tiles > actual. reduce neutral tile count
			$tiles_for_neutrals -= $tile_count - $tiles_for_users - $tiles_for_neutrals;
		}

		shuffle($d['tiles']);

		$game_tiles = [];

		foreach($game->users as $user) {

		}

		foreach($d['tiles'] as $i=>$tile) {
			if($tiles_for_neutrals-- > 0) {
				$tile['user'] = 'neutral';
			} else {
				$index = $i % $game->users->count();
				$tile['user'] = $game->users->get($index)->id;
			}
			$tile['units'] = $per_tile;
			$game_tiles[] = $tile;
		}

		$d['tiles'] = $game_tiles;

		$game_data = [
			'map' => $d,
		];
		$game->data = json_encode($game_data);
		$game->save();

		return redirect()->route('game index', $game->id);
	}
}
