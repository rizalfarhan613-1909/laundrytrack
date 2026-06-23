<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalServiceTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'unit',
        'base_price',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}