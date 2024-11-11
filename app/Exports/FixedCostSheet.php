<?php

namespace App\Exports;

use App\Models\FixedCost;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;


class FixedCostSheet implements WithHeadings, WithTitle
{
    public function headings(): array
    {
        return [
          'particular',
           'no_of_ha',
            'cost_per_ha',
            'total_amount',
        ];
    }

    public function title(): string
    {
        return 'Fixed Cost'; // This will be the name of the worksheet
    }
}
