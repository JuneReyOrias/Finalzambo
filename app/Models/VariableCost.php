<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariableCost extends Model
{
    use HasFactory;
    protected $table='variable_costs';
    protected $fillable=[
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
    public function cropFarm()
    {
        return $this->belongsTo(Crop::class, 'crops_farms_id');
    }  
  
     // Define the relationship with LastProductionData
     public function lastProductionData()
     {
         return $this->belongsTo(LastProductionDatas::class, 'last_production_datas_id');
     }
    // Relationship to CropFarm
    public function crop()
    {
        return $this->belongsTo(Crop::class, 'crops_farms_id');
    }  

    // relations to personal info and farm profile
    public function personalinformation()
    {
        return $this->belongsTo(PersonalInformations::class, 'personal_informations_id');
    }

    public function farmprofile()
    {
        return $this->belongsTo(FarmProfile::class, 'farm_profiles_id');
    }
    // relation to seeds
   public function seeds()
  {
      return $this->belongsTo(Seed::class, 'seeds_id');
  }
     // relation to labors
     public function labors()
     {
         return $this->belongsTo(Labor::class, 'labors_id');
     }

      // relation to fertilizers
      public function fertilizers()
      {
          return $this->belongsTo(Fertilizer::class, 'fertilizers_id');
      }
      // relation to pesticides
      public function pesticides()
      {
          return $this->belongsTo(Pesticide::class, 'pesticides_id');
      }

         // relation to transports
         public function transports()
         {
             return $this->belongsTo(Transport::class, 'transports_id');
         }
}
