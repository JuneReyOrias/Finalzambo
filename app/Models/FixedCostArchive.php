<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedCostArchive extends Model
{
    use HasFactory;

    protected $table="fixed_cost_archives";
    protected $fillable=[
        'fixed_costs_id',
        'users_id',
        'personal_informations_id',
        'farm_profiles_id',
        'last_production_datas_id',
        'crops_farms_id',
        'particular',
        'no_of_ha',
         'cost_per_ha',
         'total_amount',
    ];
}
