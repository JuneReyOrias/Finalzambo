<?php

namespace App\Imports;

use App\Models\ProductionSold;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SoldsImport implements ToModel, WithHeadingRow
{
    // /**
    // * @param array $row
    // *
    // * @return \Illuminate\Database\Eloquent\Model|null
    // */
    // public function model(array $row)
    // {
    //     return new ProductionSold([
    //         'total_machinery_fuel_cost'=>$row ['total_machinery_fuel_cost'],
    //         'total_variable_cost'=>$row ['total_variable_cost'],
    //     ]);
    // }

    protected $personalInformationId;
    protected $farmProfileId;

   
    protected $CropId;
    protected $ProductionId;

    public function __construct($personalInformationId, $farmProfileId, $CropId,$ProductionId)
    {
        $this->personalInformationId = $personalInformationId;
        $this->farmProfileId = $farmProfileId;
        $this->ProductionId= $ProductionId;
        $this->CropId= $CropId;
      
    }


    public function model(array $row)
    {
        // Get the ID of the currently authenticated user
        $userId = Auth::id();
        // Find the user based on the retrieved ID
        $user = auth()->user();
        $agri_districts_id = $user->agri_districts_id;
        $agri_district = $user->agri_district;

        // Check if all required keys exist in the row
        $requiredKeys = ['gross_income'];
        foreach ($requiredKeys as $key) {
            if (!isset($row[$key])) {
                Log::error("Undefined array key '$key'. Row: " . json_encode($row));
                return null; // Skip this row
            }
        }

        // Debug to check the state of data before creating FixedCost instance
        // dd([
        //     'users_id' => $userId,
            
        //     // 'personalInformationId' => $this->personalInformationId,
        //     'farmProfileId' => $this->farmProfileId,
        //     'seeds_id' => $this->seedsIds,
        //     'labors_id'=>$this->laborsIds,
        //     'fertilizers_id'=> $this->fertilizerIds,
        //     'pesticides_id'=>$this->pesticidesIds,
        //     'transports_id'=>$this->transportIds,
        //     'row' => $row
        // ]);

        // Create or update FixedCost instance
        return ProductionSold::firstOrCreate([
            'personal_informations_id' => $this->personalInformationId,
            'users_id' => $userId,
        
         
        ], [
                
                    'sold_to'=>$row ['sold_to'],
                    'measurement'=>$row ['measurement'],
                    'unit_price_rice_per_kg'=>$row ['unit_price_rice_per_kg'],
                    'quantity'=>$row ['quantity'],
                    'gross_income'=>$row ['gross_income'],
                    
                    'farm_profiles_id' => $this->farmProfileId,
                    'crops_farms_id' => $this->CropId,
                    'last_production_datas_id' => $this->ProductionId,
                 
                    
        ]);
    }
}
