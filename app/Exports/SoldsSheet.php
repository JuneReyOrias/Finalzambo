<?php

namespace App\Exports;

use App\Models\ProductionSold;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
class SoldsSheet implements WithHeadings, WithTitle
{
    public function headings(): array
    {
        return [
            'sold_to',
            'measurement',
            'unit_price_rice_per_kg',
            'quantity',
            'gross_income',
            
        ];
    }

    public function title(): string
    {
        return 'Production Sold'; // This will be the name of the worksheet
    }
  
}
