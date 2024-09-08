<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CropCategory extends Model
{
    use HasFactory;
    protected $table="crop_categorys";
    protected $fillable=[
        'users_id',
        'agri_districts_id',
        'categorizes_id',
        'crop_name',
        'crop_descript',
        
    ];
    public function varieties()
    {
        return $this->hasMany(Categorize::class, 'crop_categorys_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'users_id', )->withDefault();
    }
    public function agridistricts()
    {
        return $this->belongsToe(AgriDistrict::class,'agri_districts_id','id')->withDefault();;
    }
    public function categorizes()
    {
        return $this->belongsTo(Categorize::class,'categorizes_id','id')->withDefault();;
    }
    public function crop()
    {
        return $this->hasMany(Crop::class,'id','crop_categorys_id');
    }
}
