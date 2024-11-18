<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInformationArchive extends Model
{
    use HasFactory;


      // Specify the table if it's not pluralized automatically
      protected $table = 'personal_information_archives';
  // Specify the fillable attributes for mass assignment
  protected $fillable = [
   ' users_id',
    'personal_informations_id',
    'first_name',
    'middle_name',
    'last_name',
    'extension_name',
    'country',
    'province',
    'city',
    'agri_district',
    'barangay',
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
    'nameof_farmers_ass_org_coop',
    'name_contact_person',
    'cp_tel_no',
    'date_interview'
];


}
