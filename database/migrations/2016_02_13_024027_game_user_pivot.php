<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GameUserPivot extends Migration
{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('games', function (Blueprint $table) {
					$table->increments('id');

					$table->string('name')->default('World War Thray');

					$table->string('card_type')->default('cycle');
					$table->boolean('neutrals')->default(1);

					$table->longtext('state')->nullable();

					$table->timestamps();
			});

			// Create pivot for many to many relationship between games and players
			Schema::create('game_user', function (Blueprint $table) {
				$table->integer('game_id');
				$table->integer('user_id');

				// Game-specific settings for the player
				$table->string('name');
				$table->string('color');
				// Player is out of the game?
				$table->boolean('dead')->default(0);
				// Current players turnt?
				$table->boolean('turnt')->default(0);
				// Current players turnt?
				$table->boolean('booted')->default(0);
			});

			Schema::table('game_user', function ($table) {
				$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
				$table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
			});
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
				Schema::drop('game_user');
				Schema::drop('games');
		}
}
