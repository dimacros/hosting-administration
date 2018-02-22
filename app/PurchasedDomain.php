<?php

namespace App;

use Carbon\Carbon;
use App\Mail\DomainRenewal;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;

class PurchasedDomain extends Model
{

  public function domainProvider()
  {
		return $this->belongsTo('App\DomainProvider');
  }	

  public function getNowAttribute() {
  	return new Carbon();
  }

  public function getFinishDateAttribute($finish_date) {
  	return new Carbon($finish_date);
  }  

	public function getExpirationDateForHumansAttribute() {
		return $this->now->diffInDays($this->finish_date, false);
	}

	public function getStartDateToRenewDomainAttribute() {
		return $this->finish_date->addDay()->toDateString();
	}

	public function isDayToSendRenewalEmail() {
		$numberOfMissingDays = [3, 7, 15, 30];
		if ( in_array($this->expiration_date_for_humans, $numberOfMissingDays) ) {
			return true;
		}
		return false; 
	}	

	public function isExpired() {
		if ( $this->expiration_date_for_humans === -1 ) {
			return true;
		}
		return false;
	}

	public function sendRenewalEmailTo(string $email) {
		Mail::to($email)->send(new DomainRenewal($this));
	}

}
