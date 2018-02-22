<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HostingPlanContracted extends Model
{
	protected $table = 'hosting_plans_contracted';

	public function getRealTotalPriceAttribute() {
		return $this->total_price_per_year * $this->contract_duration_in_years;
	}

}
