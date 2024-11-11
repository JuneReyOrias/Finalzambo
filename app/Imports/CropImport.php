<?php

namespace App\Imports;

use App\Models\Crop;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\FarmProfile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\PersonalInformations;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Log; // Import the Log facade
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CropImport implements ToModel, WithHeadingRow
{
    protected $personalInformationId;
    protected $farmProfileId;
    private $CropModel; 
    public function __construct($personalInformationId, $farmProfileId)
    {
        $this->personalInformationId = $personalInformationId;
        $this->farmProfileId = $farmProfileId;
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
        $requiredKeys = ['crop_name'];
        foreach ($requiredKeys as $key) {
            if (!isset($row[$key])) {
                Log::error("Undefined array key '$key'. Row: " . json_encode($row));
                return null; // Skip this row
            }
        }

        // Debug to check the state of data before creating FixedCost instance
        // dd([
        //     'users_id' => $userId,
            
        //     'personalInformationId' => $this->personalInformationId,
        //     'farmProfileId' => $this->farmProfileId,
        //     'row' => $row
        // ]);

        // Create or update FixedCost instance


    $this->CropModel= Crop::firstOrCreate([
        'personal_informations_id' => $this->personalInformationId,
        'users_id' => $userId,
        'farm_profiles_id' => $this->farmProfileId,
    
     
    ], [
        'crop_name' => $row['crop_name'],
        'type_of_variety_planted' => $row['type_of_variety_planted'],
        'preferred_variety' => $row['preferred_variety'],
       'planting_schedule_wetseason' => Carbon::parse($row['planting_schedule_wetseason'])->format('Y-m-d'),
        'planting_schedule_dryseason' => Carbon::parse($row['planting_schedule_dryseason'])->format('Y-m-d'),
        'no_of_cropping_per_year' => $row['no_of_cropping_per_year'],
        'yield_kg_ha' => $row['yield_kg_ha'],
       
    ]);
    $this->CropModel->save();
}

public function getCropId(){
    return $this->CropModel->id;
}
}
