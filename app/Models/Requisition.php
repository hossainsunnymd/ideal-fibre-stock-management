<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    protected $fillable=[
        'created_by',
        'total_by_kg',
        'total_by_pc',
        'total_by_feet',
        'total_by_coel',
    ];

    public function requistionProducts(){
        return $this->hasMany(RequisitionProduct::class);
    }
}
