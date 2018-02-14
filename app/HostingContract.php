<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class HostingContract extends Model
{
	public function calculateFinishDate(int $contract_period) {
		$startDate = new Carbon($this->start_date);
		$this->finish_date = $startDate->addYears($contract_period);
		$this->finish_date = $this->finish_date->toDateString();
	}
}
