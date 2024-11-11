<?php

namespace App\Imports;

use App\Models\LastProductionDatas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class ImportLastProductionDatas implements ToModel,WithHeadingRow
{

    
    protected $personalInformationId;
    protected $farmProfileId;
    private $ProductionModel;
    protected  $CropId;
    public function __construct($personalInformationId, $farmProfileId,  $CropId)
    {
        $this->personalInformationId = $personalInformationId;
        $this->farmProfileId = $farmProfileId;
        $this->CropId = $CropId;
    }


    public function model(array $row)
    {
        // Get the ID of the currently authenticated user
        $userId = Auth::id();
        // Find the user based on the retrieved ID
        $user = auth()->user();
        $agri_districts_id = $user->agri_districts_id;
        $agri_district = $user->district;

        // Check if all required keys exist in the row
        $requiredKeys = ['cropping_no'];
        foreach ($requiredKeys as $key) {
            if (!isset($row[$key])) {
                Log::error("Undefined array key '$key'. Row: " . json_encode($row));
                return null; // Skip this row
            }
        }

        // Debug to check the state of data before creating FixedCost instance
        // dd([
        //     'users_id' => $userId,
        //     'agri_districts_id' => $user->agri_districts_id,
        //     // 'personalInformationId' => $this->personalInformationId,
        //     'farmProfileId' => $this->farmProfileId,
        //     'row' => $row
        // ]);

    // Create or update Last production instance
    $this->ProductionModel= LastProductionDatas::firstOrCreate([
        'personal_informations_id' => $this->personalInformationId,
        'users_id' => $userId,
    
     
    ], [
        'cropping_no'=>$row ['cropping_no'],
        'seeds_typed_used'=>$row ['seeds_typed_used'],
        'seeds_used_in_kg'=>$row ['seeds_used_in_kg'],
        'seed_source'=>$row ['seed_source'],
        'no_of_fertilizer_used_in_bags'=>$row ['no_of_fertilizer_used_in_bags'],
        'no_of_pesticides_used_in_l_per_kg'=>$row ['no_of_pesticides_used_in_l_per_kg'],
        'no_of_insecticides_used_in_l'=>$row ['no_of_insecticides_used_in_l'],
        'date_planted' => Carbon::parse($row['date_planted'])->format('m-d-Y'),
        'date_harvested' => Carbon::parse($row['date_harvested'])->format('m-d-Y'),
        
        // 'yield_tons_per_kg'=>$row ['yield_tons_per_kg'],
        // 'unit_price_palay_per_kg'=>$row ['unit_price_palay_per_kg'],
        // 'unit_price_rice_per_kg'=>$row ['unit_price_rice_per_kg'],
        // 'type_of_product'=>$row ['type_of_product'],
        // 'sold_to'=>$row ['sold_to'],
        // 'if_palay_milled_where'=>$row ['if_palay_milled_where'],
        // 'gross_income_palay'=>$row ['gross_income_palay'],
        // 'gross_income_rice'=>$row ['gross_income_rice'],
    
        'farm_profiles_id' => $this->farmProfileId,
        'crops_farms_id' => $this->CropId,
    ]);
    $this->ProductionModel->save();
}

public function getProductionId(){
    return $this->ProductionModel->id;
}
}
