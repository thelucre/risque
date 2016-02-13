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

	public function index() {
		return layout('pages.game.index');
	}

	public function newGame() {
		return layout('pages.game.new');
	}

	public function createNewGame() {
		$game = Game::create();
		foreach(User::all() as $i => $user) {
			$game->users()->attach($user, [
				'color' => Game::$colors[$i],
				'name' => $user->name,
				'turnt' => ($i==0),
			]);

		}
		dd($game);
	}
}
