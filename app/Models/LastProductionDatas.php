<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LastProductionDatas extends Model
{
    use HasFactory;
    protected $table="last_production_datas";
    protected $fillable=[
        'users_id',
        'crops_farms_id', 
        'personal_informations_id',
        'farm_profiles_id',
        'agri_districts_id',
        'seeds_typed_used',
        'seeds_used_in_kg',
        'seed_source',
        'no_of_fertilizer_used_in_bags',
        'no_of_pesticides_used_in_l_per_kg',
        'no_of_insecticides_used_in_l',
        'area_planted',
        'date_planted',
        'date_harvested',
        'yield_tons_per_kg',
        'unit_price_palay_per_kg',
        'unit_price_rice_per_kg',
        'type_of_product',
        'sold_to',
        'if_palay_milled_where',
        'gross_income_palay',
        'gross_income_rice',
    ];
    public function cropFarm()
    {
        return $this->belongsTo(Crop::class, 'crops_farms_id');
    }
    public function crop()
    {
        return $this->belongsTo(Crop::class, 'crops_farms_id');
    }
    public function cropFarms()
    {
        return $this->belongsTo(Crop::class, 'crops_farms_id');
    }
    public function farmprofiles()
    {
        return $this->belongsTo(FarmProfile::class, 'farm_profiles_id','id')->withDefault();
    }
    public function personalInformations()
    {
        return $this->belongsTo(PersonalInformations::class,'personal_informations_id','id')->withDefault();
    }

    // relation with last productions with personal info anf farm profile
    public function personalinformation()
    {
        return $this->belongsTo(PersonalInformations::class, 'personal_informations_id');
    }

    public function farmprofile()
    {
        return $this->belongsTo(FarmProfile::class, 'farm_profiles_id');
    }
    public function agridistrict()
    {
        return $this->belongsTo(AgriDistrict::class, 'agri_districts_id');
    }
    // public function cropfarm()
    // {
    //     return $this->hasMany(Crop::class, 'crops_farms_id');
    // }



}
