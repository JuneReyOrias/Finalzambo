<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmProfile extends Model
{
    use HasFactory;
//   protected $fillable=[
//     'tenurial_status',
//     'rice_farm_address',
//     'no_of_years_asfarmers',
//     'gps_longitude',
//     'gps_latitude',
//     'total_physical_area_has',
//   ];
    // public function PersonalInformation(){
    //     return$this->hasOne(\app\PersonalInformations::class);
    // }
    
 protected $table='farm_profiles';
 
//  protected $guarded = [];
    protected $fillable=[
   
            
            'agri_districts_id',
            'agri_districts',
            'polygons_id',
            'tenurial_status',
            'rice_farm_address',
            'no_of_years_as_farmers',
            'gps_longitude',
            'gps_latitude',
            'total_physical_area_has',
            'rice_area_cultivated_has',
            'land_title_no',
            'lot_no',
            'area_prone_to',
            'ecosystem',
            'type_rice_variety',
            'prefered_variety',
            'plant_schedule_wetseason',
            'plant_schedule_dryseason',
            'no_of_cropping_yr',
            'yield_kg_ha',
            'rsba_register',
            'pcic_insured',
            'government_assisted',
            'source_of_capital',
            'remarks_recommendation',
            'oca_district_office',
            'name_technicians',
            'date_interview',
        'image',
  'users_id', 
  'personal_informations_id',
    ];

    // In the FarmProfile model


    public function cropFarms()
    {
        return $this->hasMany(Crop::class, 'farm_profiles_id'); // Adjust the foreign key if necessary
    }
        public function crops()
    {
        return $this->hasMany(Crop::class, 'farm_profiles_id');
    }
    public function lastProduction()
    {
        return $this->hasMany(LastProductionDatas::class, 'farm_profiles_id');
    }
     // relationship  machineries used farm profiles
 public function varialeCosts()
 {
     return $this->hasMany(VariableCost::class, 'farm_profiles_id');
 }

 // relationship  machineries used farm profiles
 public function machineries()
 {
     return $this->hasMany(MachineriesUseds::class, 'farm_profiles_id');
 }


    // relatioship  fixed cost with the person info and farm profiles
    public function fixedCosts()
    {
        return $this->hasMany(FixedCost::class, 'farm_profiles_id');
    }
      // Add this method to fetch crops based on farm profiles
      public function cropsFarms()
      {
          return $this->hasMany(Crop::class, 'farm_profiles_id');
      }
    public function personalinfo()
    {
        return $this->belongsTo(PersonalInformations::class, 'personal_informations_id');
    }
    public function personalInformation()
    {
        return $this->belongsTo(PersonalInformations::class, 'personal_informations_id');
    }
// model realtion between farm profile and agri district
    public function agriDistrict()
    {
        return $this->belongsTo(AgriDistrict::class, 'agri_districts_id');
    }
//    protected $fillable=['farm_no'];
public function user()
{
    return $this->belongsTo(User::class,'users_id', )->withDefault();
}
public function personalInformations()
{
    return $this->belongsTo(PersonalInformations::class,'personal_informations_id')->withDefault();
}
    public function agridistricts()
    {
        return $this->belongsTo(AgriDistrict::class,'agri_districts_id','id');
    }
    public function polygon()
    {
        return $this->belongsTo(Polygon::class,'polygons_id' );
    }
    public function fixedcost()
    {
        return $this->hasMany(FixedCost::class,'id','farm_profiles_id');
    }
    public function machineriesuseds()
    {
        return $this->hasMany(MachineriesUseds::class,'id','farm_profiles_id');
    }
    public function machineriesused()
    {
        return $this->hasMany(MachineriesUsed::class,'id','farm_profiles_id');
    }
    public function variablecost()
    {
        return $this->hasMany(VariableCost::class,'id','farm_profiles_id');
    }
    public function seeds()
    {
        return $this->hasMany(Seed::class,'id','farm_profiles_id');
    }
    public function fertilizer()
    {
        return $this->hasMany(Fertilizer::class,'id','farm_profiles_id');
    }
    public function labor()
    {
        return $this->hasMany(Labor::class,'id','farm_profiles_id');
    }
    public function pesticide()
    {
        return $this->hasMany(Pesticide::class,'id','farm_profiles_id');
    }
    public function transport()
    {
        return $this->hasMany(Transport::class,'id','farm_profiles_id');
    }
    
 
}
