<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGameStates extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('games', function (Blueprint $table) {
			$table->dropColumn('state');
		});

		Schema::table('games', function (Blueprint $table) {
			$table->string('state');
			$table->longtext('data');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('games', function (Blueprint $table) {
				//
		});
	}
}
