<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PurchasedDomain extends Model
{
	public function validateDates($start_date, $due_date) {
		$work_star_date = new Carbon($start_date);
		$difference = $work_star_date->diffInDays(new Carbon($due_date), false);
		if ($difference > 0) {
			return true;
		}
		return false;
	}
}
