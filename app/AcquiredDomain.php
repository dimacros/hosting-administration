<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcquiredDomain extends Model
{
		public function getDomainNameAttribute($domain_name)
    {
        return 'http://'.$domain_name;
    }
}
