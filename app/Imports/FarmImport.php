<?php

namespace App\Imports;

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
class FarmImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $personalInformationId;
    private $farmModel;



    public function __construct($personalInformationId)
    {
        $this->personalInformationId = $personalInformationId;
     
    }


 public function model(array $row)
{
    // Get the ID of the currently authenticated user
    $userId = Auth::id();
           // Find the user based on the retrieved ID
           $user = auth()->user();
           $agri_districts_id = $user->agri_districts_id;
           $agri_district = $user->district;
   // Check if the 'tenurial_status' column exists
   if (!isset($row['date_interviewed'])) {
    Log::warning("Column 'date_interviewed' is missing in the Excel file.");
    return null; // Skip this row
}

// Check if personalInformationId is set
if (!$this->personalInformationId) {
    Log::error("Personal Information ID is null.");
    return null; // Skip this row
}

// Debug to check the state of data before creating FarmProfile instance
// dd([
//    'users_id'=> $userId,
//    'agri_districts_id' => $user->agri_districts_id,
//    'agri_districts' => $user->agri_district,
//     'personalInformationId' => $this->personalInformationId,
//     'row' => $row

// ]);
// 
    // Create or update a FarmProfile instance
    $this->farmModel = FarmProfile::firstOrCreate(
        [
            'personal_informations_id' => $this->personalInformationId,
            'users_id' => $userId,
            // 'agri_districts_id' => $user->agri_districts_id,
            'agri_districts' => $user->agri_district,
        ],
        [
            'tenurial_status' => $row['tenurial_status'],
            'farm_address' => $row['farm_address'],
            'no_of_years_as_farmers' => $row['no_of_years_as_farmers'],
            'gps_longitude' => $row['gps_longitude'],
            'gps_latitude' => $row['gps_latitude'],
            'total_physical_area' => $row['total_physical_area'],
            'total_area_cultivated' => $row['total_area_cultivated'],
            'land_title_no' => $row['land_title_no'],
            'lot_no' => $row['lot_no'],
            'area_prone_to' => $row['area_prone_to'],
            'ecosystem' => $row['ecosystem'],
            // 'type_of_variety' => $row['type_of_variety'],
            // 'preferred_variety' => $row['preferred_variety'],
            
            // 'planting_schedule_wetseason' => Carbon::parse($row['planting_schedule_wetseason'])->format('Y-m-d'),
            // 'planting_schedule_dryseason' => Carbon::parse($row['planting_schedule_dryseason'])->format('Y-m-d'),
            // 'no_of_cropping_per_year' => $row['no_of_cropping_per_year'],
            // 'yield_kg_ha' => $row['yield_kg_ha'],
            'rsba_registered' => $row['rsba_registered'],
            'pcic_insured' => $row['pcic_insured'],
            'source_of_capital' => $row['source_of_capital'],
            'remarks_recommendation' => $row['remarks_recommendation'],
            'oca_district_office' => $row['oca_district_office'],
            'name_of_field_officer_technician' => $row['name_of_field_officer_technician'],
            'date_interviewed' => Carbon::parse($row['date_interviewed'])->format('Y-m-d'),
        ]
    );
    $this->farmModel->save();
    return $this->farmModel;
}

public function getFarmModel()
{
    return $this->farmModel;
}
       
    }
