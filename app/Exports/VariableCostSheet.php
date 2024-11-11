<?php

namespace App\Exports;

use App\Models\VariableCost;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VariableCostSheet implements WithHeadings, WithTitle
{
    public function headings(): array
    {
        return [
             // SEED 
             'unit',
             'quantity',
             'unit_price',
             'total_seed_cost',

             // Labor
             'labor_no_of_person',
             'rate_per_person',
             'total_labor_cost',
             // fertilizers
             'no_of_sacks',
             'unit_price_per_sacks',
             'total_cost_fertilizers',
             // pesticides
             'no_of_l_kg',
             'unit_price_of_pesticides',
             'total_cost_pesticides',
             // transport
             'total_transport_delivery_cost',

             // total
             'total_machinery_fuel_cost',
             'total_variable_cost',
        ];
    }

    public function title(): string
    {
        return 'Variable Cost'; // This will be the name of the worksheet
    }
}
