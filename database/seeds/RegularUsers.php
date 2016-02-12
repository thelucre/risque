<?php

use Illuminate\Database\Seeder;

class RegularUsers extends Seeder
{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			DB::table('users')->insert([
					'name' => 'Storks',
					'email' => 'michael@bkwld.com',
					'password' => bcrypt('brickhouse'),
			]);
			DB::table('users')->insert([
					'name' => 'Erack',
					'email' => 'eric@bkwld.com',
					'password' => bcrypt('brickhouse'),
			]);
			DB::table('users')->insert([
					'name' => 'Jerf',
					'email' => 'jeff@bkwld.com',
					'password' => bcrypt('brickhouse'),
			]);
			DB::table('users')->insert([
					'name' => 'Dant',
					'email' => 'dan@bkwld.com',
					'password' => bcrypt('brickhouse'),
			]);
		}
}
