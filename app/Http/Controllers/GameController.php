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
		if(Game::createNew($request->all())) {
			return redirect()->route('home');
		}

		echo('failed to make game');
		dd($request->all());
	}
}
