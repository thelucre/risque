<?php

/**
 * Define layout and a helper method to DRY up the use of the layout.
 *
 * @param $view string The name of the view file, like "home.index"
 * @param $vars array Key-val pairs of data to pass to the view
 * @return Illuminate\View\Factory
 */
function layout($view, $vars = []) {
	return View::make('layouts.default')->nest('content', $view, $vars);
}

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//
// });

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
		//
});

Route::group(['middleware' => 'web'], function () {
		Route::auth();

		Route::get('/home', 'HomeController@index');

		Route::get('/', function() {
			return layout('pages.home', ['user' => Auth::user()]);
		});

		Route::get('/game', 'GameController@index');
		Route::get('/game/new', 'GameController@newGame')->name('new game');
		Route::post('/game/new', 'GameController@createNewGame')->name('create new game');
});
