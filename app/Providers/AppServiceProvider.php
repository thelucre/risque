<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth, View;

class AppServiceProvider extends ServiceProvider
{
		/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Global user context
		View::composer('*', function($view) {
			$view->with('user', Auth::user());
		});
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		if ($this->app->environment() == 'local') {
			$this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
		}
	}
}
