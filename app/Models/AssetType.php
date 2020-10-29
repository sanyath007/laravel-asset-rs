<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    protected $table = 'asset_types';
    protected $primaryKey = 'type_id';
    public $incrementing = false; //ไม่ใช้ options auto increment
    // public $timestamps = false; //ไม่ใช้ field updated_at และ created_at

    public function cates()
  	{
      	return $this->belongsTo('App\Models\AssetCategory', 'cate_id', 'cate_id');
  	}

    public function asset()
    {
        return $this->hasMany('App\Models\Asset', 'asset_type', 'type_id');
    }
}
