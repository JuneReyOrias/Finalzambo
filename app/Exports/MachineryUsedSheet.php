<?php

namespace App\Exports;

use App\Models\MachineriesUseds;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MachineryUsedSheet implements WithHeadings, WithTitle
{
  
    public function headings(): array
    {
        return [
            // plowing
            'plowing_machineries_used',
            'plo_ownership_status',
            'no_of_plowing',
            'plowing_cost',
           'plowing_cost_total',

            //harrowing
            'harrowing_machineries_used',
            'harro_ownership_status',
            'no_of_harrowing',
            'harrowing_cost',
            'harrowing_cost_total',
            // harvest
            'harvesting_machineries_used',
            'harvest_ownership_status',
            'harvesting_cost_total',

            // pst harvest
            'postharvest_machineries_used',
            'postharv_ownership_status',	
            'post_harvest_cost',

            'total_cost_for_machineries',
        ];
    }

    public function title(): string
    {
        return 'Machineries Cost'; // This will be the name of the worksheet
    }
}
