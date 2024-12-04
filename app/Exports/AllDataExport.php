<?php

namespace App\Exports;

use App\Models\PersonalInformation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AllDataExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new PersonalInformationsSheet(),
            new FarmProfilessSheet(),
            // new CropFrsSheet(),
            // new ProductionsSheet(),
        ];
    }
}
