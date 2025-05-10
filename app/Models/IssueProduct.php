<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueProduct extends Model
{
    protected $fillable=['product_id','unit','category_id'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
