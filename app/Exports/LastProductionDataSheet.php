<?php

namespace App\Exports;

use App\Models\LastProductionData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
class LastProductionDataSheet implements WithHeadings, WithTitle
{

    public function headings(): array
    {
        return [
            'cropping_no',
            'seeds_typed_used',
        'seeds_used_in_kg',
        'seed_source',
        'no_of_fertilizer_used_in_bags',
        'no_of_pesticides_used_in_l_per_kg',
        'no_of_insecticides_used_in_l',
        'date_planted',
        'date_harvested',
        
        // 'yield_tons_per_kg',
        // 'unit_price_palay_per_kg',
        // 'unit_price_rice_per_kg',
        // 'type_of_product',
        // 'sold_to',
        // 'if_palay_milled_where',
        // 'gross_income_palay',
        // 'gross_income_rice',
        ];
    }
    public function title(): string
    {
        return 'Production'; // This will be the name of the worksheet
    }
}
