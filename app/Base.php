<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{

	public function dataAsJson() {
		return json_decode($this->data, true);
	}
	
}
