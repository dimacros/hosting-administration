<?php

namespace App;
use App\Notifications\ContractRenewal;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

	use Notifiable; //$user->notify(new InvoicePaid($invoice));

  public function user()
  {
  	return $this->belongsTo('App\User');
  }

  public function cpanelAccount() {
  	return $this->hasOne('App\CpanelAccount');
  }

	public function purchasedDomains() {
		return $this->hasMany('App\PurchasedDomain');
	}

	public function hostingContracts() {
		return $this->hasMany('App\HostingContract');
	}

	public function getFullNameAttribute()
	{ 
		if ( $this->hasCompany() ) {
			return $this->company_name;
		}

    return "{$this->first_name} {$this->last_name}";
	}

	private function hasCompany() {
		if ( !is_null($this->company_name) || !empty($this->company_name) ) {
			return true;
		}
		return false;
	}

	public function hasPurchasedDomains() {
		if ( $this->purchasedDomains->count() > 0 ) {
			return true;
		}
		return false;
	}

	public function hasHostingContracts() {
		if ( $this->hostingContracts->count() > 0 ) {
			return true;
		}
		return false;
	}

}
