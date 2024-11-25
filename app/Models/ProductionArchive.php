<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionArchive extends Model
{
    use HasFactory;
    protected $table="production_archives";
    protected $fillable=[
     'personal_informations_id',
        'farm_profiles_id',
        'users_id',
        'last_production_datas_id',
        'crops_farms_id',
        'cropping_no',
        'seeds_typed_used',
        'seeds_used_in_kg',
        'seed_source',
        'no_of_fertilizer_used_in_bags',
        'no_of_pesticides_used_in_l_per_kg',
        'no_of_insecticides_used_in_l',
        'area_planted',
        'date_planted',
        'date_harvested',
        // 'yield_tons_per_kg',
        // 'unit_price_palay_per_kg',
        // 'unit_price_rice_per_kg',
        // 'type_of_product',
        // 'sold_to',
        // 'if_palay_milled_where',
        // 'gross_income_palay',
        // 'gross_income_rice',
    ];

}
