<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $table = 'document_types';
    protected $primaryKey = 'document_type_id';
    public $incrementing = false; //ไม่ใช้ options auto increment
    // public $timestamps = false; //ไม่ใช้ field updated_at และ created_at
    
    public function asset()
  	{
      	return $this->hasMany('App\Models\Asset', 'document_type', 'document_type_id');
  	}
}
