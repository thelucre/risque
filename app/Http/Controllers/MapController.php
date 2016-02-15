<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Map;

class MapController extends Controller
{
		public function index() {
			return layout('admin.maps.index', ['map' => Map::first()]);
		}

		public function save(Request $request) {
			$map = Map::find(1);
			$map->data = json_encode($request->get('map'));
			$map->save();
			return response()->json($map);
		}
}
