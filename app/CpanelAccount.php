<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CpanelAccount extends Model
{
	public function customer() {
		return $this->belongsTo('App\Customer');
	}
}
