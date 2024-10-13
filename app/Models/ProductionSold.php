<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionSold extends Model
{
    use HasFactory;
    protected $table='production_solds';


    public function cropFarm()
    {
        return $this->belongsTo(Crop::class, 'crops_farms_id');
    }
}
