<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetClass extends Model
{
    protected $table = 'asset_classes';
    protected $primaryKey = 'class_id';
    // public $incrementing = false; // false = ไม่ใช้ options auto increment
    public $timestamps = false; // false = ไม่ใช้ field updated_at และ created_at

    public function types()
    {
        return $this->hasMany('App\Models\AssetType', 'class_id', 'class_id');
    }
}
