<?php

namespace App;

use Carbon\Carbon;
use App\Mail\RenewContract;
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

	public function newStartDate() {
		$finish_date = new Carbon($this->finish_date);
		return $finish_date->addDay()->toDateString();
	}

	public function calculateFinishDate(int $contract_period) {
		$start_date = new Carbon($this->start_date);
		return $start_date->addYears($contract_period)->toDateString();
	}

	public function getDaysToExpireAttribute() {
		$finish_date = new Carbon($this->finish_date);
		return Carbon::today()->diffInDays($finish_date, false);
	}

	public function sendRenewalNotification() {
		$email =  new RenewContract($this);
		Mail::to('programador@dimacros.net')->cc('desarrollo@jypsac.com','Programador')->send($email);
	}

	public function toPDF() {
		return \PDF::loadView('pdf.hosting-contract', $this);
	}
}
