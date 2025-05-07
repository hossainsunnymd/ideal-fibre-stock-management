<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequisitionProduct extends Model
{
    protected $fillable=[
        'requisition_id',
        'product_id',
        'total_requisition',
        'total_received'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function requisition(){
        return $this->belongsTo(Requisition::class);
    }
}
