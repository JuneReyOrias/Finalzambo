<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
class MultipleSheetsExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new PersonalInformationSheet(),
            new FarmProfileSheet(),
            new CropsSheet(),
            new LastProductionDataSheet(),
            new SoldsSheet(),
            new FixedCostSheet(),
            new MachineryUsedSheet(),
            new VariableCostSheet(),
       
        ];
    }
}
