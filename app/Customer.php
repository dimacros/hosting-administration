<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

	public function isExistsCompanyName() {
		if ( !is_null($this->company_name) || !empty($this->company_name) ) {
			return true;
		}
		return false;
	}

	public function getFullNameAttribute()
	{
		if ( $this->isExistsCompanyName() ) {
			return $this->company_name;
		}

    return "{$this->first_name} {$this->last_name}";
	}

}
