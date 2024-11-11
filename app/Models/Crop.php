<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    use HasFactory;
    protected $table="crops_farms";
    protected $fillable=[
        'users_id',
        'farm_profiles_id',
        'crop_name',
        'type_of_variety_planted',
        'preferred_variety' ,
       'planting_schedule_wetseason',
        'planting_schedule_dryseason',
        'no_of_cropping_per_year',
        'yield_kg_ha',
    ];
    
     // Relationship with CropFarm
     public function cropFarm()
     {
         return $this->belongsTo(Crop::class, 'crops_farms_id');
     }
     // If needed, set up the inverse relationship with FarmProfile
     public function farmProfiles()
     {
         return $this->hasMany(FarmProfile::class, 'personal_informations_id');
     }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id', )->withDefault();
    }
    public function categorize()
    {
        return $this->belongsTo(Categorize::class,'categorizes_id','id');
    }
    public function cropcategory()
    {
        return $this->belongsTo(CropCategory::class,'crop_categorys_id','id');
    }
    public function farmprofile()
    {
        return $this->belongsTo(FarmProfile::class, 'farm_profiles_id');
    }
    // public function production()
    // {
    //     return $this->belongsTo(LastProductionDatas::class, 'crops_farms_id');
    // }
    public function lastProductionData()
    {
        return $this->hasMany(LastProductionDatas::class, 'crops_farms_id');
    }

     // Relationship to VariableCost
    // Relationship to VariableCost
    public function variableCosts()
    {
        return $this->hasMany(VariableCost::class, 'crops_farms_id');
    }

    // Relationship to Crop
    public function crop()
    {
        return $this->belongsTo(Crop::class, 'crop_name', 'crop_name');
    }
    public function lastProductionDatas()
    {
        return $this->hasMany(LastProductionDatas::class, 'crops_farms_id');
    }

    public function fixedCosts()
    {
        return $this->hasMany(FixedCost::class, 'crops_farms_id');
    }

    public function machineries()
    {
        return $this->hasMany(MachineriesUsed::class, 'crops_farms_id');
    }

  
    public function productionSolds()
    {
        return $this->hasMany(ProductionSold::class, 'crops_farms_id');
    }
    

}
