<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariableCostArchive extends Model
{
    use HasFactory;

    protected $table='variable_cost_archives';
    protected $fillable=[
        'variable_costs_id',
        'personal_informations_id',
        'farm_profiles_id',
        'last_production_datas_id',
        'crops_farms_id',
        'users_id',
           // SEED 
           'unit',
           'quantity',
           'unit_price',
           'total_seed_cost',

           // Labor
           'labor_no_of_person',
           'rate_per_person',
           'total_labor_cost',
           // fertilizers
           'no_of_sacks',
           'unit_price_per_sacks',
           'total_cost_fertilizers',
           // pesticides
           'no_of_l_kg',
           'unit_price_of_pesticides',
           'total_cost_pesticides',
           // transport
           'total_transport_delivery_cost',

           // total
           'total_machinery_fuel_cost',
           'total_variable_cost',
     

    ];
}
