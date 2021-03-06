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

		Route::get('/home', 'HomeController@index')->name('home');

		Route::get('/', function() {
			return layout('pages.index', ['user' => Auth::user()]);
		})->name('index');

		Route::get('/game/new', 'GameController@newGame')->name('new game');
		Route::post('/game/new', 'GameController@createNewGame')->name('create new game');

		Route::post('/game/{id}/settings', 'GameController@playerSettings')
			->name('game player settings');
		Route::get('/game/{id}', 'GameController@index')->name('game index');
		Route::get('/game/reset/{id}', 'GameController@gameReset')->name('game reset');


});


Route::group(['prefix' => 'admin', 'middleware' => 'web'], function () {
		Route::get('/maps', 'MapController@index')->name('map index');
		Route::post('/maps/save', 'MapController@save')->name('save map');
});
