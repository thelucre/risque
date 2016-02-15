<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GameUserSettingsNullable extends Migration
{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			DB::statement('ALTER TABLE `game_user` MODIFY `color` VARCHAR(255) NULL;');
			DB::statement('ALTER TABLE `game_user` MODIFY `name` VARCHAR(255) NULL;');
		}

		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
		}
}
