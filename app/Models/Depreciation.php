<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depreciation extends Model
{
  	protected $table = 'depreciations';
  	
  	public function asset()
    {
        return $this->hasMany('App\Models\Asset', 'asset_id', 'asset_id');
    }
}
