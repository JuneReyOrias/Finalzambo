<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CropParcel extends Model
{
    use HasFactory;
    protected $fillable = ['coordinates', 'area', 'altitude'];

    protected $casts = [
        'coordinates' => 'array', // Cast coordinates as an array (JSON)
    ];
}
