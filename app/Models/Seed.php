<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seed extends Model
{
    use HasFactory;
    protected $table='seeds';
    protected $fillable=[
        'seed_name',
        'seed_type',
       
        'users_id',
       'personal_informations_id'
    ];
   
      public function variableCostforSeed(){
        return$this->hasMany(VariableCost::class, );
    }

    public function varieties()
    {
        return $this->hasMany(Categorize::class);
    }
   
}
