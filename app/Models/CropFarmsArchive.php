<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CropFarmsArchive extends Model
{
    use HasFactory;

    protected $table="crop_farms_archives";
    protected $fillable=[
        'users_id',
        'farm_profiles_id',
        'personal_informations_id',
        'crops_farms_id',
        'crop_name',
        'type_of_variety_planted',
        'preferred_variety' ,
       'planting_schedule_wetseason',
        'planting_schedule_dryseason',
        'no_of_cropping_per_year',
        'yield_kg_ha',
    ];
}
