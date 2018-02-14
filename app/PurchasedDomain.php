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
  
	public function getExpirationDateForHumansAttribute() {
		$this->start_date = new Carbon($this->start_date);
		$this->finish_date = new Carbon($this->finish_date);
		return $this->start_date->diffInDays($this->finish_date, false);
	}

}
