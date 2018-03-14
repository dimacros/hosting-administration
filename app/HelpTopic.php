<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HelpTopic extends Model
{
		public function tickets() {
			return $this->hasMany('App\Ticket');
		}

		public function setTitleAttribute($title) {
			$this->attributes['title'] = strtoupper($title);
		}
}
