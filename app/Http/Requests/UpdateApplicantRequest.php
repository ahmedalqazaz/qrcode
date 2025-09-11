<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicantRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // Personal Information
            'DropDownListrank1' => ['nullable','integer','exists:ranks,id'],
            'txtname11' => ['nullable','string','max:100'],
            'txtname22' => ['nullable','string','max:100'],
            'txtname33' => ['nullable','string','max:100'],
            'txtname44' => ['nullable','string','max:100'],
            'txtnameff' => ['nullable','string','max:100'],
            'txtempcod1' => ['nullable','string','max:50'],
            'txtbirth1' => ['nullable','string','max:150'],
            'DropDownListgender1' => ['nullable','integer','exists:genders,id'],
            'txtnumberphone1' => ['nullable','string','max:50'],
            'txem1' => ['nullable','email','max:150'],
            'txtsts1' => ['nullable','string','max:50'],
            'datebirth1' => ['nullable','string'],
            'is_martyr_relative' => ['nullable','boolean'],

            // Administrative Information
            'txtage1' => ['nullable','integer','exists:agencies,id'],
            'txtgen1' => ['nullable','string','max:150'],
            'txtdir1' => ['nullable','string','max:150'],
            'khoyear1' => ['nullable','integer'],
            'khyear1' => ['nullable','integer'],

            // Current Degree Information
            'txtnamecolge1' => ['nullable','string','max:200'],
            'txtunverQ1' => ['nullable','string','max:200'],
            'DropDgr1' => ['nullable','integer','exists:degrees,id'],
            'DropDownListT1' => ['nullable','string','max:200'],
            'DropDownavg1' => ['nullable','numeric'],
            'datedgr1' => ['nullable','string'],
            'txtmamr1' => ['nullable','string','max:100'],
            'dateamr1' => ['nullable','string'],
            'txtcount1' => ['nullable','string','max:150'],

            // Requested Degree Information
            'DropDownListplceA1' => ['nullable','integer','exists:degrees,id'],
            'FirstDropdown1' => ['nullable','integer','exists:chanels,id'],
            'SecondDropdown1' => ['nullable','integer','exists:spcifics,id'],
            'txtcolgeQ1' => ['nullable','string','max:200'],
            'txtcolgeQ21' => ['nullable','string','max:200'],
            'DropDownListTA1' => ['nullable','string','max:50'],
            'datemoda1' => ['nullable','integer','exists:ejazas,id'],
            'txtplceQ1' => ['nullable','string','max:150'],
            'notes' => ['nullable','string','max:1000'],

        ];
    }
}
