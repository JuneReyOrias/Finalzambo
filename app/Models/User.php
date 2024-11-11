<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\DatabaseNotification;

use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table="users";
    protected $fillable = [
    
        'name',
        'email',
        'agri_district',
        'password',
        'role',
        'image',

      
    ];
    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable');
    }
    public function personalinformations()
    {
        return $this->hasMany(PersonalInformations::class,'id','users_id');
    }
    public function farmprofiles()
    {
        return $this->hasMany(FarmProfile::class,'id','users_id');
    }
    public function agridistricts()
    {
        return $this->hasOne(AgriDistrict::class,'id','users_id');
    }
    public function categorize()
    {
        return $this->hasMany(Categorize::class,'id','users_id');
    }
    public function cropcategory()
    {
        return $this->hasMany(CropCategory::class,'id','users_id');
    }
    public function fisheriescategory()
    {
        return $this->hasMany(FisheriesCategory::class,'id','users_id');
    }
    public function livestockcategory()
    {
        return $this->hasMany(LivestockCategory::class,'id','users_id');
    }
    public function crop()
    {
        return $this->hasMany(Crop::class,'id','users_id');
    }
    public function livestock()
    {
        return $this->hasMany(Livestock::class,'id','users_id');
    }
    public function parcellaryboundaries()
    {
        return $this->hasMany(ParcellaryBoundaries::class,'id','users_id');
    }
    public function riceboarders()
    {
        return $this->hasMany(RicefieldBoarder::class,'id','users_id');
    }
    public function getPrimaryKey()
    {
        return $this->getKey();
    }

  // Define the relationship with AgriDistrict
  public function agriDistrict()
  {
      return $this->belongsTo(AgriDistrict::class, 'agri_districts_id');
  }


    // The 'boot' method to automatically load personalInformations after user creation
    protected static function boot()
    {
        parent::boot();

        // Listen for the 'created' event
        static::created(function ($user) {
            // Automatically fetch the related PersonalInformations
            $user->load('personalInformations');
        });
    }
    // protected static function boots()
    // {
    //     parent::boot();

    //     // Listen for the 'created' event
    //     static::created(function ($user) {
    //         // Automatically fetch the related PersonalInformations
    //         $user->load('farmprofile');
    //     });
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
  
    
    // Define the relationship with FarmProfile
   
}
