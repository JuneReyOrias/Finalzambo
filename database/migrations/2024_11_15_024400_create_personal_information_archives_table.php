<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personal_information_archives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personal_information_id'); // Reference to the original record
            $table->string('first_name',100);
            $table->string('middle_name',100)->nullable();
            $table->string('last_name',100);
            $table->string('extension_name',50)->nullable();
            $table->string('country',50);
            $table->string('province',50);
            $table->string('city',50);
            $table->string('agri_district',50);
            $table->string('barangay',50);
            $table->string('home_address',100);
            $table->string('sex',100);
            $table->string('religion',100)->nullable();
            $table->date('date_of_birth');
            $table->string('place_of_birth',100);
            $table->string('contact_no',50);
            $table->string('civil_status',50);
            $table->string('name_legal_spouse',50)->nullable();
            $table->integer('no_of_children')->nullable();
            $table->string('mothers_maiden_name',50)->nullable();
            $table->string('highest_formal_education',100)->nullable();
            $table->string('person_with_disability',50)->nullable();
            $table->string('pwd_id_no',50)->nullable();
            $table->string('government_issued_id',50)->nullable();
            $table->string('id_type',50)->nullable();
            $table->string('gov_id_no',50)->nullable();
            $table->string('member_ofany_farmers_ass_org_coop',50)->nullable();
            $table->string('nameof_farmers_ass_org_coop',50)->nullable();
            $table->string('name_contact_person',50)->nullable();
            $table->string('name_contact_no',50)->nullable();
            $table->date('date_interview')->nullable();

    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_information_archives');
    }
};
