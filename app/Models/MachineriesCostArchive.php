<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineriesCostArchive extends Model
{
    use HasFactory;

    protected $table="machineries_cost_archives";
    protected $fillable=[
        'machineries_useds_id',
        'personal_informations_id',
        'farm_profiles_id',
        'users_id',
        'last_production_datas_id',
        'crops_farms_id',
          // plowing
          'plowing_machineries_used',
          'plo_ownership_status',
          'no_of_plowing',
          'plowing_cost',
         'plowing_cost_total',

          //harrowing
          'harrowing_machineries_used',
          'harro_ownership_status',
          'no_of_harrowing',
          'harrowing_cost',
          'harrowing_cost_total',
          // harvest
          'harvesting_machineries_used',
          'harvest_ownership_status',
          'harvesting_cost_total',

          // pst harvest
          'postharvest_machineries_used',
          'postharv_ownership_status',	
          'post_harvest_cost',

          'total_cost_for_machineries',
    ];

}
