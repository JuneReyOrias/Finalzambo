<?php

namespace App\Exports;

use App\Models\PersonalInformations;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PersonalInformationSheet implements WithHeadings, WithTitle
{
    public function headings(): array
    {
        return [
            'first name',
            'middle name',
            'last name',
            'extension name',
            'home address',
            'sex',
            'religion',
            'date of birth',
            'place of birth',
            'contact no',
            'civil status',
            'name legal spouse',
            'no of children',
            'mothers maiden name',
            'highest formal education',
            'person with disability',
            'pwd id no',
            'government issued id',
            'id type',
            'gov id no',
            'member ofany farmers ass org coop',
            'nameof farmers ass org coop',
            'name contact person',
            'cp tel no',
            'date interview'
        ];
    }
    public function title(): string
    {
        return 'Personal Informations'; // This will be the name of the worksheet
    }
}
