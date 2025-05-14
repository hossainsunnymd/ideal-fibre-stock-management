<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'category_id', 'unit', 'unit_type','minimum_stock','parts_no','rack_no','column_no','row_no'
    ];
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
