<?php

namespace App\Exports;

use App\Models\FarmProfile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FarmProfileSheet  implements WithHeadings, WithTitle
{
    public function headings(): array
    {
        return [
            'tenurial_status' ,
            'farm_address',
            'no_of_years_as_farmers',
            'gps_longitude',
            'gps_latitude',
            'total_physical_area' ,
            'total_area_cultivated' ,
            'land_title_no',
            'lot_no',
            'area_prone_to',
            'ecosystem',
            'rsba_registered',
            'pcic_insured',
            'source_of_capital',
            'remarks_recommendation',
            'oca_district_office',
            'name_of_field_officer_technician',
            'date_interviewed',
        ];
    }

    public function title(): string
    {
        return 'Farm Profile'; // This will be the name of the worksheet
    }
}
