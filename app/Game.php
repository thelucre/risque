<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

	/**
	 * The users playing this game
	 */
	public function users()
	{
			return $this->belongsToMany('App\User');
	}

	public static $colors = [
		'#fb1c1c',
		'#09f219',
		'#1221f9',
		'#f2e80b',
		'#b70df2',
	];
}
