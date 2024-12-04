<?php

namespace App\Exports;

use App\Models\PersonalInformations;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PersonalInformationsSheet implements FromCollection, WithHeadings, WithTitle
{
    /**
     * Fetch the data for the sheet.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return PersonalInformations::select([
            'id',
            'agri_district',
            'first_name',
            'middle_name',
            'last_name',
            'extension_name',
            'home_address',
            'sex',
            'religion',
            'date_of_birth',
            'place_of_birth',
            'contact_no',
            'civil_status',
            'name_legal_spouse',
            'no_of_children',
            'mothers_maiden_name',
            'highest_formal_education',
            'person_with_disability',
            'pwd_id_no',
            'government_issued_id',
            'id_type',
            'gov_id_no',
            'member_ofany_farmers_ass_org_coop',
            
            'name_contact_person',
            'cp_tel_no',
            'date_interview',
            // Ensure this field is included
        ])
        ->whereNotNull('agri_district') // Exclude NULL values
        ->where('agri_district', '<>', '') // Exclude empty strings
        ->orderByRaw("FIELD(agri_district, 'ayala', 'tumaga','culianan','manicahan','curuan','vitali') ASC") // Prioritize Ayala and Tumag
        ->orderBy('agri_district') // Sort remaining districts alphabetically
        ->get();
    }
    
        // Select only the required columns including the ID
       

    /**
     * Add headings to the Excel sheet.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Agri-District',
            'First Name',
            'Middle Name',
            'Last Name',
            'Extension Name',
            'Home Address',
            'Sex',
            'Religion',
            'Date of Birth',
            'Place of Birth',
            'Contact No',
            'Civil Status',
            'Name of Legal Spouse',
            'No. of Children',
            'Mother\'s Maiden Name',
            'Highest Formal Education',
            'Person with Disability',
            'PWD ID No',
            'Government Issued ID',
            'ID Type',
            'Government ID No',
            'Member of Any Farmers Ass. Org./Coop',
            'Name of Farmers Ass. Org./Coop',
            'Name of Contact Person',
            'CP/Tel No',
            'Date of Interview'
        ];
    }

    /**
     * Set the sheet title.
     *
     * @return string
     */
    public function title(): string
    {
        return 'Personal Informations';
    }
}
