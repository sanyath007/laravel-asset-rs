<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $connection = 'person';

    protected $table = 'depart';

    // public function reserve()
    // {
    //     return $this->hasMany('App\Reservation', 'depart_id', 'department');
    // }
  
    // public function user()
    // {
    //     return $this->hasMany('App\User', 'depart_id', 'office_id');
    // }
}
