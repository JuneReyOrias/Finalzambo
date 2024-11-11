<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionSold extends Model
{
    use HasFactory;
    protected $table='production_solds';
 
    protected $fillable=[
        'personal_informations_id',
        'farm_profiles_id',
        'last_production_datas_id',
        'crops_farms_id',
        'users_id',
        'sold_to',
        'measurement',
        'unit_price_rice_per_kg',
        'quantity',
        'gross_income',
      
    ];

    public function cropFarm()
    {
        return $this->belongsTo(Crop::class, 'crops_farms_id');
    }
}
