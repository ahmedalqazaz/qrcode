<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Applicant;

class StoreApplicantRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // tighten rules for the QR form
            'DropDownListrank1' => ['nullable','integer','exists:ranks,id'],
            'txtname11' => ['required','string','max:100'],
            'txtname22' => ['nullable','string','max:100'],
            'txtname33' => ['nullable','string','max:100'],
            'txtname44' => ['nullable','string','max:100'],
            'txtnameff' => ['nullable','string','max:100'],
            'txtempcod1' => ['nullable','string','max:50'],
            'txtbirth1' => ['nullable','string','max:150'],
            'DropDownListgender1' => ['required','integer','exists:genders,id'],
            'txtnumberphone1' => ['nullable','string','max:50'],
            'txem1' => ['nullable','email','max:150'],
            // marital status and birth date
            'txtsts1' => ['nullable','string','max:50'],
            'datebirth1' => ['nullable','string'],

            // administrative
            'txtage1' => ['nullable','integer','exists:agencies,id'],
            'txtgen1' => ['nullable','string','max:150'],
            'txtdir1' => ['nullable','string','max:150'],
            'khoyear1' => ['nullable','integer'],
            'khyear1' => ['nullable','integer'],

            // current degree
            'txtnamecolge1' => ['nullable','string','max:200'],
            'txtunverQ1' => ['nullable','string','max:200'],
            'DropDgr1' => ['nullable','integer','exists:degrees,id'],
            'DropDownListT1' => ['nullable','string','max:200'],
            'DropDownavg1' => ['nullable','numeric'],
            'datedgr1' => ['nullable','string'],
            'txtmamr1' => ['nullable','string','max:100'],
            'dateamr1' => ['nullable','string'],
            'txtcount1' => ['nullable','string','max:150'],

            // requested data
            'DropDownListplceA1' => ['required','integer','exists:degrees,id'],
            'FirstDropdown1' => ['required','integer','exists:chanels,id'],
            'SecondDropdown1' => ['required','string','max:200'],
            'txtcolgeQ1' => ['nullable','string','max:200'],
            'txtcolgeQ21' => ['nullable','string','max:200'],
            'DropDownListTA1' => ['nullable','string','max:50'],
            'datemoda1' => ['nullable','integer','exists:ejazas,id'],
            'txtplceQ1' => ['nullable','string','max:150'],

            'all_data' => ['nullable','string'],

            // Additional Fields
            'is_martyr_relative' => ['nullable','boolean'],
            'notes' => ['nullable','string','max:1000'],
        ];
    }

    /**
     * After the base rules, ensure the exact applicant doesn't already exist.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $this->only([
                'txtname11', 'txtname22', 'txtname33', 'txtname44', 'txtnameff', 'txtempcod1'
            ]);

            // Normalize values (trim)
            $first = trim($data['txtname11'] ?? '');
            $second = trim($data['txtname22'] ?? '');
            $third = trim($data['txtname33'] ?? '');
            $fourth = trim($data['txtname44'] ?? '');
            $last = trim($data['txtnameff'] ?? '');
            $stat = isset($data['txtempcod1']) ? trim($data['txtempcod1']) : null;

            // Determine duplicate using OR logic:
            // - match by statistical_number (if provided)
            // - OR match by full name (first+second+third+fourth+last)

            $isDuplicate = false;

            if ($stat !== null && $stat !== '') {
                $existsByStat = Applicant::where('statistical_number', $stat)->exists();
                if ($existsByStat) {
                    $isDuplicate = true;
                    $validator->errors()->add('txtempcod1', 'هذا القيد مكرر.');
                }
            }

            if (!$isDuplicate) {
                $existsByName = Applicant::where('first_name', $first)
                    ->where('second_name', $second)
                    ->where('third_name', $third)
                    ->where('fourth_name', $fourth)
                    ->where('last_name', $last)
                    ->exists();

                if ($existsByName) {
                    $isDuplicate = true;
                    $validator->errors()->add('txtname11', 'هذا القيد مكرر.');
                }
            }

            if ($isDuplicate) {
                $validator->errors()->add('duplicate', 'هذا القيد مكرر.');
            }
        });
    }
}
