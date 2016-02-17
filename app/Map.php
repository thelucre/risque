<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
		// Convert map data to true json
		protected $casts = ['data' => 'json'];

		// Map data stub for creating maps
		public static function stub() {
			return json_encode([
				'regions' => [
					[
						'id' => 1,
						'name' => 'North America',
						'bonus' => 5,
						'tiles' => [1,2],
					]
				],
				'tiles' => [
					[
						'id'  => 1,
						'name' => 'Canada',
						'box' => [
							'top' => '20%',
							'left' => '30%',
							'width' => '5%',
							'height' => '10%',
						],
						'connections' => [2,],
					],
					[
						'id'  => 2,
						'name' => 'United States',
						'box' => [
							'top' => '20%',
							'left' => '35%',
							'width' => '5%',
							'height' => '10%',
						],
						'connections' => [1,],
					],
				],
			]);
		}
}
