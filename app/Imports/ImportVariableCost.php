<?php

namespace App\Imports;

use App\Models\VariableCost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportVariableCost implements ToModel,WithHeadingRow
{
    // /**
    // * @param array $row
    // *
    // * @return \Illuminate\Database\Eloquent\Model|null
    // */
    // public function model(array $row)
    // {
    //     return new VariableCost([
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
        $requiredKeys = ['total_seed_cost','total_labor_cost','total_cost_fertilizers','total_cost_pesticides',
         'total_transport_delivery_cost', 'total_machinery_fuel_cost', 'total_variable_cost'];
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
        return VariableCost::firstOrCreate([
            'personal_informations_id' => $this->personalInformationId,
            'users_id' => $userId,
        
         
        ], [
                    // SEED 
                    'unit'=>$row ['unit'],
                    'quantity'=>$row ['quantity'],
                    'unit_price'=>$row ['unit_price'],
                    'total_seed_cost'=>$row ['total_seed_cost'],

                    // Labor
                    'labor_no_of_person'=>$row ['labor_no_of_person'],
                    'rate_per_person'=>$row ['rate_per_person'],
                    'total_labor_cost'=>$row ['total_labor_cost'],
                    // fertilizers
                    'no_of_sacks'=>$row ['no_of_sacks'],
                    'unit_price_per_sacks'=>$row ['unit_price_per_sacks'],
                    'total_cost_fertilizers'=>$row ['total_cost_fertilizers'],
                    // pesticides
                    'no_of_l_kg'=>$row ['no_of_l_kg'],
                    'unit_price_of_pesticides'=>$row ['unit_price_of_pesticides'],
                    'total_cost_pesticides'=>$row ['total_cost_pesticides'],
                    // transport
                    'total_transport_delivery_cost'=>$row ['total_transport_delivery_cost'],

                    // total
                    'total_machinery_fuel_cost'=>$row ['total_machinery_fuel_cost'],
                    'total_variable_cost'=>$row ['total_variable_cost'],
                
                    'farm_profiles_id' => $this->farmProfileId,
                    'crops_farms_id' => $this->CropId,
                    'last_production_datas_id' => $this->ProductionId,
                    // 'labors_id'=>$this->laborsIds,
                    // 'fertilizers_id'=> $this->fertilizerIds,
                    // 'pesticides_id'=>$this->pesticidesIds,
                    // 'transports_id'=>$this->transportIds,
                    
        ]);
    }
}
