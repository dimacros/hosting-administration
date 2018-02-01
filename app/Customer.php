<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	public function getFullname() {
		return $this->first_name .' '.$this->last_name;
	}
}
