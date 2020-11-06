<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'assets';
    
    protected $primaryKey = 'asset_id';

    public $incrementing = false; //ไม่ใช้ options auto increment

    public $timestamps = false; //ไม่ใช้ field updated_at และ created_at

    protected $fillable = ['status'];

    public function assetType()
    {
        return $this->belongsTo('App\Models\AssetType', 'asset_type', 'type_id');
    }
  
    public function deprecType()
    {
        return $this->belongsTo('App\Models\DeprecType', 'deprec_type', 'deprec_type_id');
    }
  
    public function budgetType()
    {
        return $this->belongsTo('App\Models\BudgetType', 'budget_type', 'budget_type_id');
    }
    
    public function docType()
    {
        return $this->belongsTo('App\Models\DocumentType', 'document_type', 'document_type_id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\AssetUnit', 'asset_unit', 'unit_id');
    }

    public function purchasedMethod()
    {
        return $this->belongsTo('App\Models\PurchasedMethod', 'purchased_method', 'method_id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier', 'supplier', 'supplier_id');
    }

  	// public function app_detail()
  	// {
   //    	return $this->hasMany('App\Models\ApprovementDetail', 'debt_id', 'debt_id');
  	// }
}
