<?php

namespace App;

use Carbon\Carbon;
use App\Mail\ContractRenewalHosting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;

class HostingContract extends Model
{

	public function hostingPlanContracted() {
		return $this->belongsTo('App\HostingPlanContracted');
	}

	public function customer() {
		return $this->belongsTo('App\Customer');
	}

	public function user() {
		return $this->belongsTo('App\User');
	}
		
	public function getIdAttribute($id) {
		return str_pad($id, 5, "0", STR_PAD_LEFT);
	}

  public function getStartDateAttribute($start_date) {
  	return new Carbon($start_date);
  }

  public function getNowAttribute() {
  	return Carbon::today();
  }

  public function getFinishDateAttribute($finish_date) {
  	return new Carbon($finish_date);
  }  

	public function calculateFinishDate(int $contract_period) {
		return $this->start_date->addYears($contract_period)->toDateString();
	}

	public function getExpirationDateForHumansAttribute() {
		return $this->now->diffInDays($this->finish_date, false);
	}

	public function getStartDateToRenovateAttribute() {
		return $this->finish_date->addDay()->toDateString();
	}
	
	public function bootstrapComponents() {
  	if ($this->expiration_date_for_humans > 14) {
  		return [
  			'status' => '<span class="ml-1 badge badge-pill badge-success">Activo</span>',
  			'expiration' => '<span class="fw-600 text-success">'. $this->expiration_date_for_humans .' Días</span>'
  		];
    }
    elseif ($this->expiration_date_for_humans > 0 ) {
  		return [
  			'status' => '<span class="ml-1 badge badge-pill badge-warning">Próximo a vencer</span>',
  			'expiration' => '<span class="fw-600 text-warning">'. $this->expiration_date_for_humans .' Días</span>'
  		];
    }
    else {  
  		return [
  			'status' => '<span class="ml-1 badge badge-pill badge-danger">Expirado</span>',
  			'expiration' => '<span class="fw-600 text-danger">0 Días</span>'
  		];                
    }
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
	
	public function getPdfAttribute() {
		return \PDF::loadView('pdf.hosting-contract', $this);
	}

	public function sendRenewalEmail() {
		Mail::to($this->customer->email, $this->customer->full_name)
		->cc('programador@dimacros.net', 'Marcos')
		->cc('desarrollo@jypsac.com', 'Programador')
		->send( new ContractRenewalHosting($this) );
	}
}
