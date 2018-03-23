<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

	public function user() {
		return $this->belongsTo('App\User');
	}

	public function getCreatedAtAttribute($created_at) {
		//Carbon::setLocale('es');
		setlocale(LC_TIME, 'Spanish');
		Carbon::setUtf8(true);
		$created_at = new Carbon($created_at); 
		return $created_at->formatLocalized('%A %d de %B, %Y a las %H:%m');
	}

	public function getAttachedFilesAttribute($attached_files) {
		return json_decode($attached_files);
	}
}
