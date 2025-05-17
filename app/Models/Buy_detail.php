<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'buy_id',
        'product_id',
        'cantidad',
        'precio_unitario',
    ];

    // Relationship with Buy
    public function buy()
    {
        return $this->belongsTo(Buy::class, 'buy_id');
    }

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
