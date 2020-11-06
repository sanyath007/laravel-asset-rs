<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    protected $table = 'asset_types';
    protected $primaryKey = 'type_id';
    public $incrementing = false; // false = ไม่ใช้ options auto increment
    public $timestamps = false; // false = ไม่ใช้ field updated_at และ created_at

    public function class()
  	{
      	return $this->belongsTo('App\Models\AssetClass', 'class_id', 'class_id');
  	}
    
    public function cate()
  	{
      	return $this->belongsTo('App\Models\AssetCate', 'cate_id', 'cate_id');
  	}

    public function asset()
    {
        return $this->hasMany('App\Models\Asset', 'asset_type', 'type_id');
    }
}
