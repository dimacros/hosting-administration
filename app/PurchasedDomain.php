<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PurchasedDomain extends Model
{

  public function domainProvider()
  {
		return $this->belongsTo('App\DomainProvider');
  }	
  
	public function congruentDates($start_date, $due_date) {
		$start_date = new Carbon($start_date);
		$diffInDays = $start_date->diffInDays(new Carbon($due_date), false);
		if ($diffInDays > 0) {
			return true;
		}
		return false;
	}

	public function getExpirationDateForHumansAttribute() {
		$this->start_date = new Carbon($this->start_date);
		$this->due_date = new Carbon($this->due_date);
		return $this->start_date->diffInDays($this->due_date, false);
	}

}
