<?php

namespace App;

use Carbon\Carbon;
use App\Mail\RenewDomain;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;

class PurchasedDomain extends Model
{

  public function domainProvider()
  {
		return $this->belongsTo('App\DomainProvider');
  }	
  
	public function customer() {
		return $this->belongsTo('App\Customer');
	}

	public function user() {
		return $this->belongsTo('App\User');
	}

	public function newStartDate() {
		$finish_date = new Carbon($this->finish_date);
		return $finish_date->addDay()->toDateString();
	}

	public function getDaysToExpireAttribute() {
		$finish_date = new Carbon($this->finish_date);
		return Carbon::today()->diffInDays($finish_date, false);
	}

	public function sendRenewalNotification() {
		$email =  new RenewDomain($this);
		Mail::to('programador@dimacros.net')->cc('desarrollo@jypsac.com','Programador')->send($email);
	}

}
