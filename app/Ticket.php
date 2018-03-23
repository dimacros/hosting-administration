<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

	public function helpTopic() {
		return $this->belongsTo('App\HelpTopic');
	}

	public function user() {
		return $this->belongsTo('App\User');
	}

	public function replies() {
		return $this->hasMany('App\Reply');
	}

	public function getIdAttribute($id) {
		return str_pad($id, 6, "0", STR_PAD_LEFT);
	}

	public function getBadgeAttribute() {
		if ($this->status === 'open') 
		{
			return '<span class="badge badge-success p-sm-2 float-right">Abierto</span>';
		}

		return '<span class="badge badge-danger p-sm-2 float-right">Cerrado</span>';
	}
}
