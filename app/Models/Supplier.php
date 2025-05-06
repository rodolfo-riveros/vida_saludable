<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruc',
        'razon_social',
        'direccion',
        'telefono',
        'email',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
