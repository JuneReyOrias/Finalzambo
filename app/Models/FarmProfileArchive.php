<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmProfileArchive extends Model
{
    use HasFactory;

    protected $table='farm_profile_archives';
 
//  protected $guarded = [];
    protected $fillable=[
        'farm_profiles_id',
        'users_id', 
        'personal_informations_id',
            'agri_districts_id',
            'agri_districts',
            'polygons_id',
            'tenurial_status',
            'farm_address',
            'no_of_years_as_farmers',
            'gps_longitude',
            'gps_latitude',
            'total_physical_area',
            'total_area_cultivated',
            'land_title_no',
            'lot_no',
            'area_prone_to',
            'ecosystem',
            'type_rice_variety',
            'prefered_variety',
            'planting_schedule_wetseason',
            'planting_schedule_dryseason',
            'no_of_cropping_yr',
            'yield_kg_ha',
            'rsba_registered',
            'pcic_insured',
            'government_assisted',
            'source_of_capital',
            'remarks_recommendation',
            'oca_district_office',
            'name_of_field_officer_technician',
            'date_interviewed',
        'image',

    ];
}
