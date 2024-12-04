<?php

namespace App\Exports;

use App\Models\FarmProfile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;


class FarmProfilessSheet implements WithHeadings, WithTitle, FromCollection
{    public function collection()
    {
        return DB::table('farm_profiles')
            ->join('personal_informations', 'farm_profiles.personal_informations_id', '=', 'personal_informations.id')
            ->select(
                'personal_informations.id as personal_informations_id',
                'personal_informations.agri_district',
                'farm_profiles.tenurial_status',
                'farm_profiles.farm_address',
                'farm_profiles.no_of_years_as_farmers',
                'farm_profiles.gps_longitude',
                'farm_profiles.gps_latitude',
                'farm_profiles.total_physical_area',
                'farm_profiles.total_area_cultivated',
                'farm_profiles.land_title_no',
                // 'farm_profiles.lot_no',
                // 'farm_profiles.area_prone_to',
                // 'farm_profiles.ecosystem',
                // 'farm_profiles.rsba_registered',
                // 'farm_profiles.pcic_insured',
                // 'farm_profiles.source_of_capital',
                // 'farm_profiles.remarks_recommendation',
                // // 'farm_profiles.oca_district_office',
                // 'farm_profiles.name_of_field_officer_technician',
                // 'farm_profiles.date_interviewed',
              
              
            )
            ->whereNotNull('personal_informations.agri_district')
            ->where('personal_informations.agri_district', '<>', '')
            ->orderByRaw("FIELD(personal_informations.agri_district,'ayala', 'tumaga','culianan','manicahan','curuan','vitali') ASC")
            ->orderBy('personal_informations.agri_district')
            ->orderBy('farm_profiles.personal_informations_id') // Ensure alignment with PersonalInformations ID
            ->get();
    }

    public function headings(): array
    {
        return [
              'Farmer No.',
              'Agri-District',
            'Tenurial Status',
            'Farm Address',
            'Years as Farmer',
            'GPS Longitude',
            'GPS Latitude',
            'Total Physical Area',
            'Total Area Cultivated',
            'Land Title No',
            'Lot No',
            'Area Prone To',
            'Ecosystem',
            'RSBA Registered',
            'PCIC Insured',
            'Source of Capital',
            'Remarks/Recommendation',
            'OCA District Office',
            'Field Officer/Technician Name',
            'Date Interviewed',
           // For reference/sorting alignment
        ];
    }

    public function title(): string
    {
        return 'Farm Profile';
    }
}
