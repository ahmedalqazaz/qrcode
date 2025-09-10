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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            
            // Personal Information
            $table->foreignId('rank_id')->nullable()->constrained('ranks');
            $table->string('first_name');
            $table->string('second_name');
            $table->string('third_name');
            $table->string('fourth_name');
            $table->string('last_name');
            $table->string('statistical_number')->nullable();
            $table->string('birth_place')->nullable();
            $table->foreignId('gender_id')->nullable()->constrained('genders');
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('marital_status')->nullable();
            $table->date('birth_date')->nullable();
            
            // Administrative Information
            $table->foreignId('agency_id')->nullable()->constrained('agencies');
            $table->string('directorate')->nullable();
            $table->string('department')->nullable();
            $table->integer('service_years')->nullable();
            $table->integer('service_years_after_last_degree')->nullable();
            
            // Current Degree Information
            $table->string('university_name')->nullable();
            $table->string('college_name')->nullable();
            $table->foreignId('degree_id')->nullable()->constrained('degrees');
            $table->string('specialization')->nullable();
            $table->decimal('average', 5, 2)->nullable();
            $table->date('graduation_date')->nullable();
            $table->string('admin_order_number')->nullable();
            $table->date('admin_order_date')->nullable();
            $table->string('degree_country')->nullable();
            
            // Requested Degree Information
            $table->foreignId('requested_degree_id')->nullable()->constrained('degrees');
            $table->foreignId('channel_id')->nullable()->constrained('chanels');
            $table->string('requested_specialization')->nullable();
            $table->string('requested_university')->nullable();
            $table->string('requested_college')->nullable();
            $table->string('academic_year')->nullable();
            $table->foreignId('ejaza_id')->nullable()->constrained('ejazas');
            $table->string('study_country')->nullable();
            
            // QR Code Data
            $table->text('all_data')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};