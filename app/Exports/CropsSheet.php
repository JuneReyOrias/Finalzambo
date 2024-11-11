<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;


class CropsSheet implements WithHeadings, WithTitle
{
    public function headings(): array
    {
        return [
            'crop_name',
            'type_of_variety_planted',
            'preferred_variety' ,
           'planting_schedule_wetseason',
            'planting_schedule_dryseason',
            'no_of_cropping_per_year',
            'yield_kg_ha',
        ];
    }

    public function title(): string
    {
        return 'Crops'; // This will be the name of the worksheet
    }
}
