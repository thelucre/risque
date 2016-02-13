<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Game;
use App\User;

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

	public function index($id = null) {
		if(empty($id)) App::abort(404);
		$game = Game::with('users')->findOrFail($id);
		return layout('pages.game.index', ['game' => $game]);
	}

	public function newGame() {
		return layout('pages.game.new');
	}

	public function createNewGame(Request $request) {
		if(Game::createNew($request->all())) {
			return redirect()->route('home');
		}

		echo('failed to make game');
		dd($request->all());
	}
}
