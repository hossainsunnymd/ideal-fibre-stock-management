<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequisitionReceivedRequest extends Model
{
    protected $fillable=[
        'requisitionProduct_id',
        'received_qty',
        'product_id',
        'status'
    ];

    public function product(){
        return $this->belongsTo(product::class);
    }
}
