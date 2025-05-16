<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'supplier_id',
        'fecha',
        'total',
        'tipo_comprobante',
    ];

    // Relationship with Users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
