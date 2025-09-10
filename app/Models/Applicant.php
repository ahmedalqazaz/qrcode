<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = [
        // Personal Information
        'rank_id', 'first_name', 'second_name', 'third_name', 'fourth_name', 'last_name',
        'statistical_number', 'birth_place', 'gender_id', 'phone_number', 'email',
        'marital_status', 'birth_date',

        // Administrative Information
        'agency_id', 'directorate', 'department', 'service_years', 'service_years_after_last_degree',

        // Current Degree Information
        'university_name', 'college_name', 'degree_id', 'specialization', 'average',
        'graduation_date', 'admin_order_number', 'admin_order_date', 'degree_country',

        // Requested Degree Information
        'requested_degree_id', 'channel_id', 'requested_specialization', 'requested_university',
        'requested_college', 'academic_year', 'ejaza_id', 'study_country',

        // QR Code Data
        'all_data',

        // Additional Fields
        'is_martyr_relative',
        'notes',
    ];

    // Define relationships
    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function requestedDegree()
    {
        return $this->belongsTo(Degree::class, 'requested_degree_id');
    }

    public function channel()
    {
        return $this->belongsTo(Chanel::class, 'channel_id');
    }

    public function ejaza()
    {
        return $this->belongsTo(Ejaza::class);
    }

    public function requestedSpecialization()
    {
        return $this->belongsTo(Spcific::class, 'requested_specialization');
    }
}
