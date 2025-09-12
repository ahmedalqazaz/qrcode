<?php

namespace App\Http\Controllers;

use App\Models\Rank;
use App\Models\Agency;
use App\Models\Gender;
use App\Models\Degree;
use App\Models\Chanel;
use App\Models\Ejaza;
use App\Models\Spcific;
use Illuminate\Http\Request;
use App\Models\Applicant;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreApplicantRequest;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Response;
use Illuminate\Routing\Controller;
use App\Http\Requests\UpdateApplicantRequest;



class DataController extends Controller
{
    public function create()
    {

        $ranks   = Rank::all();
        $agencis = Agency::all();
        $genders=Gender::all();
        $degrees=Degree::all();
        $degreess=Degree::where('code_degree','<', 3)->get();
        $ejazas=Ejaza::all();
        $chanels=Chanel::all();
        $spcifics=Spcific::all();
        return view('qrcode', compact('ranks', 'agencis','genders','degrees','ejazas','chanels','degreess','spcifics'));
    }

    // list and search applicants
    public function index(Request $request)
    {
        // validate filters
        $validated = $request->validate([
            'q' => ['nullable','string','max:100'],
            'FirstDropdown1' => ['nullable','integer','exists:chanels,id'],
            'SecondDropdown1' => ['nullable','string','max:100'],
            'DropDownListplceA1' => ['nullable','integer','exists:degrees,id'],
            'sort' => ['nullable','string','in:average_asc,average_desc'],
        ]);

        $q = $request->input('q');
        $filterChannel = $request->input('FirstDropdown1');
        $filterSpecialization = $request->input('SecondDropdown1');
        $filterRequestedDegree = $request->input('DropDownListplceA1');

        $query = Applicant::with(['rank','gender','agency','degree','requestedDegree','requestedSpecialization','channel','ejaza'])
            ->select(['id','first_name','second_name','last_name','rank_id','gender_id','agency_id','degree_id','specialization','directorate','requested_degree_id','requested_specialization','average','channel_id','ejaza_id','created_at','is_martyr_relative','notes']);

        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('first_name', 'like', "%{$q}%")
                    ->orWhere('second_name', 'like', "%{$q}%")
                    ->orWhere('last_name', 'like', "%{$q}%")
                    ->orWhere('statistical_number', 'like', "%{$q}%");

                // Split search query into parts and search each in full name
                $parts = explode(' ', trim($q));
                foreach ($parts as $part) {
                    if (!empty($part)) {
                        $sub->orWhereRaw("COALESCE(first_name, '') || ' ' || COALESCE(second_name, '') || ' ' || COALESCE(third_name, '') || ' ' || COALESCE(fourth_name, '') || ' ' || COALESCE(last_name, '') LIKE ?", ["%{$part}%"]);
                    }
                }
            });
        }

        if ($filterChannel) {
            $query->where('channel_id', $filterChannel);
        }

        if ($filterRequestedDegree) {
            $query->where('requested_degree_id', $filterRequestedDegree);
        }

        if ($filterSpecialization) {
            $query->where('requested_specialization', $filterSpecialization);
        }

        // New filter for is_martyr_relative
        $filterMartyr = $request->input('is_martyr_relative');
        if ($filterMartyr) {
            $query->where('is_martyr_relative', true);
        }

        // Handle sorting
        $sort = $request->input('sort');
        if ($sort === 'average_asc') {
            $query->orderBy('average', 'asc');
        } elseif ($sort === 'average_desc') {
            $query->orderBy('average', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // capture total count before pagination
        $total = (clone $query)->count();

        $applicants = $query->paginate(20)->withQueryString();

        $channels = \App\Models\Chanel::all();
        $degrees = Degree::all();
        $specializations = Spcific::all();

        // if AJAX request return JSON with rendered HTML and total
        if ($request->ajax()) {
            $html = view('applicants._table', compact('applicants'))->render();
            return response()->json(['html' => $html, 'total' => $total]);
        }

        return view('applicants.index', compact('applicants','q','channels','degrees','specializations','total'));
    }

    public function edit(Applicant $applicant)
    {
        $ranks = Rank::all();
        $agencis = Agency::all();
        $genders = Gender::all();
        $degrees = Degree::all();
        $degreess = Degree::where('code_degree','<', 3)->get();
        $ejazas = Ejaza::all();
        $chanels = Chanel::all();
        $spcifics = Spcific::all();

        return view('applicants.edit', compact('applicant','ranks','agencis','genders','degrees','degreess','ejazas','chanels','spcifics'));
    }

    public function update(\App\Http\Requests\UpdateApplicantRequest $request, Applicant $applicant)
    {
        $validated = $request->validated();

        // For date fields, accept raw input as is from the form
        $birthDate = $request->input('datebirth1');
        $graduationDate = $request->input('datedgr1');
        $adminOrderDate = $request->input('dateamr1');

        $data = [
            'rank_id' => $validated['DropDownListrank1'] ?? null,
            'first_name' => $validated['txtname11'] ?? null,
            'second_name' => $validated['txtname22'] ?? null,
            'third_name' => $validated['txtname33'] ?? null,
            'fourth_name' => $validated['txtname44'] ?? null,
            'last_name' => $validated['txtnameff'] ?? null,
            'statistical_number' => $validated['txtempcod1'] ?? null,
            'birth_place' => $validated['txtbirth1'] ?? null,
            'gender_id' => $validated['DropDownListgender1'] ?? null,
            'phone_number' => $validated['txtnumberphone1'] ?? null,
            'email' => $validated['txem1'] ?? null,
            'marital_status' => $validated['txtsts1'] ?? null,
            'birth_date' => $birthDate,
            'agency_id' => $validated['txtage1'] ?? null,
            'directorate' => $validated['txtgen1'] ?? null,
            'department' => $validated['txtdir1'] ?? null,
            'service_years' => $validated['khoyear1'] ?? null,
            'service_years_after_last_degree' => $validated['khyear1'] ?? null,
            'university_name' => $validated['txtunverQ1'] ?? null,
            'college_name' => $validated['txtnamecolge1'] ?? null,
            'degree_id' => $validated['DropDgr1'] ?? null,
            'specialization' => $validated['DropDownListT1'] ?? null,
            'average' => $validated['DropDownavg1'] ?? null,
            'graduation_date' => $graduationDate,
            'admin_order_number' => $validated['txtmamr1'] ?? null,
            'admin_order_date' => $adminOrderDate,
            'degree_country' => $validated['txtcount1'] ?? null,
            'requested_degree_id' => $validated['DropDownListplceA1'] ?? null,
            'channel_id' => $validated['FirstDropdown1'] ?? null,
            'requested_specialization' => $validated['SecondDropdown1'] ?? null,
            'requested_university' => $validated['txtcolgeQ1'] ?? null,
            'requested_college' => $validated['txtcolgeQ21'] ?? null,
            'academic_year' => $validated['DropDownListTA1'] ?? null,
            'ejaza_id' => $validated['datemoda1'] ?? null,
            'study_country' => $validated['txtplceQ1'] ?? null,
            'is_martyr_relative' => $validated['is_martyr_relative'] ?? false,
            'notes' => $validated['notes'] ?? null,

        ];

        $applicant->update($data);

        return back()->with('success', 'تم تحديث السجل');
    }

    public function destroy(Applicant $applicant)
    {
        $applicant->delete();
        return back()->with('success','تم حذف السجل');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return back()->with('error', 'لم يتم تحديد سجلات للحذف');
        }

        Applicant::whereIn('id', $ids)->delete();
        return back()->with('success', 'تم حذف السجلات المحددة');
    }

    public function export(Request $request)
    {
        $query = Applicant::with(['rank','agency','degree','requestedDegree','requestedSpecialization'])
            ->select(['id','first_name','second_name','last_name','rank_id','agency_id','degree_id','specialization','requested_degree_id','requested_specialization','average','created_at','is_martyr_relative','notes']);
        // apply same filters as index
        if ($q = $request->input('q')) {
            $query->where(function($sub) use ($q) {
                $sub->where('first_name', 'like', "%{$q}%")
                    ->orWhere('second_name', 'like', "%{$q}%")
                    ->orWhere('last_name', 'like', "%{$q}%")
                    ->orWhere('statistical_number', 'like', "%{$q}%");

                // Split search query into parts and search each in full name
                $parts = explode(' ', trim($q));
                foreach ($parts as $part) {
                    if (!empty($part)) {
                        $sub->orWhereRaw("COALESCE(first_name, '') || ' ' || COALESCE(second_name, '') || ' ' || COALESCE(third_name, '') || ' ' || COALESCE(fourth_name, '') || ' ' || COALESCE(last_name, '') LIKE ?", ["%{$part}%"]);
                    }
                }
            });
        }
        if ($channel = $request->input('FirstDropdown1')) {
            $query->where('channel_id', $channel);
        }
        if ($rd = $request->input('DropDownListplceA1')) {
            $query->where('requested_degree_id', $rd);
        }
        if ($spec = $request->input('SecondDropdown1')) {
            $query->where('requested_specialization', $spec);
        }

        // New filter for is_martyr_relative
        $filterMartyr = $request->input('is_martyr_relative');
        if ($filterMartyr) {
            $query->where('is_martyr_relative', true);
        }

        $rows = $query->get();

        $csvHeader = [
            'التسلسل','الرتبة','الاسم','الوكالة','الشهادة الحاصل عليها','الاختصاص','الدرجة العلمية المطلوبة','الاختصاص المطلوب','قناة التقديم','المعدل','تاريخ التقديم','ذوي الشهداء','الملاحظات'
        ];

        $callback = function() use ($rows, $csvHeader) {
            $file = fopen('php://output', 'w');
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            // Set semicolon as delimiter
            fputcsv($file, $csvHeader, ';');
            $counter = 1;
            foreach ($rows as $r) {
                fputcsv($file, [
                    $counter,
                    $r->rank?->name_rank,
                    $r->first_name . ' ' . $r->second_name . ' ' . $r->last_name,
                    $r->agency?->age_name,
                    $r->degree?->name_degree,
                    $r->specialization,
                    $r->requestedDegree?->name_degree,
                    $r->requestedSpecialization?->name_spcific,
                    $r->channel?->name_chanel,
                    $r->average,
                    $r->created_at->format('Y-m-d'),
                    $r->is_martyr_relative ? 'نعم' : 'لا',
                    $r->notes ?? ''
                ], ';');
                $counter++;
            }
            fclose($file);
        };

        $filename = 'applicants_export_' . date('Ymd_His') . '.csv';
        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    public function pdfPreview(Request $request)
    {
        // Log incoming request data for debugging
        Log::info('PDF Preview Request Data:', $request->all());

        // Build same query as export
        $query = Applicant::query();
        $q = $request->input('q');
        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('first_name', 'like', "%{$q}%")
                    ->orWhere('second_name', 'like', "%{$q}%")
                    ->orWhere('last_name', 'like', "%{$q}%")
                    ->orWhere('statistical_number', 'like', "%{$q}%");

                // Split search query into parts and search each in full name
                $parts = explode(' ', trim($q));
                foreach ($parts as $part) {
                    if (!empty($part)) {
                        $sub->orWhereRaw("COALESCE(first_name, '') || ' ' || COALESCE(second_name, '') || ' ' || COALESCE(third_name, '') || ' ' || COALESCE(fourth_name, '') || ' ' || COALESCE(last_name, '') LIKE ?", ["%{$part}%"]);
                    }
                }
            });
        }
        if ($channel = $request->input('FirstDropdown1')) {
            $query->where('channel_id', $channel);
        }
        if ($rd = $request->input('DropDownListplceA1')) {
            $query->where('requested_degree_id', $rd);
        }
        if ($spec = $request->input('SecondDropdown1')) {
            $query->where('requested_specialization', $spec);
        }

        // New filter for is_martyr_relative
        $filterMartyr = $request->input('is_martyr_relative');
        if ($filterMartyr) {
            $query->where('is_martyr_relative', true);
        }

        // Log the constructed query for debugging
        Log::info('Constructed PDF Preview Query:', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);

        $rows = $query->with(['requestedDegree','requestedSpecialization','channel','ejaza'])->get();

        // Check if rows are empty and log a warning
        if ($rows->isEmpty()) {
            Log::warning('No applicants found for the given filters in PDF preview.');
        }

        // Get filter values for the additional fields from actual applicants data
        $uniqueRequestedDegrees = $rows->pluck('requestedDegree.name_degree')->unique()->filter()->values();
        $uniqueRequestedSpecializations = $rows->pluck('requestedSpecialization.name_spcific')->unique()->filter()->values();

        $requestedDegree = $uniqueRequestedDegrees->isNotEmpty() ? $uniqueRequestedDegrees->join('، ') : 'غير محدد';
        $requestedSpecialization = $uniqueRequestedSpecializations->isNotEmpty() ? $uniqueRequestedSpecializations->join('، ') : 'غير محدد';

        // Calculate seat count: if specific filters provided, fetch from Spcific, else sum from applicants
        $filterSpecialization = $request->input('SecondDropdown1');
        $filterRequestedDegree = $request->input('DropDownListplceA1');
        $filterChannel = $request->input('FirstDropdown1');

        if ($filterSpecialization && $filterRequestedDegree && $filterChannel) {
            // Fetch specific seat_count
            $degree = Degree::find($filterRequestedDegree);
            $chanel = Chanel::find($filterChannel);
            if ($degree && $chanel) {
                \Log::info('pdfPreview seat count query:', [
                    'requested_specialization' => $filterSpecialization,
                    'code_degree' => $degree->code_degree,
                    'code_chanal' => $chanel->code_chanal,
                ]);
                $spcific = Spcific::where('code_spcific', $filterSpecialization)
                    ->where('code_degree', $degree->code_degree)
                    ->where('code_chanal', $chanel->code_chanal)
                    ->first();
                \Log::info('pdfPreview spcific result:', ['spcific' => $spcific, 'seat_count' => $spcific ? $spcific->seat_count : null]);
                $seatCount = $spcific ? $spcific->seat_count : 'غير محدد';
            } else {
                \Log::info('pdfPreview degree or chanel not found:', ['degree' => $degree, 'chanel' => $chanel]);
                $seatCount = 'غير محدد';
            }
        } else {
            // Sum from applicants' specializations
            $totalSeatCount = 0;
            foreach ($rows as $applicant) {
                if ($applicant->requestedSpecialization && $applicant->requestedSpecialization->seat_count > 0) {
                    $totalSeatCount += $applicant->requestedSpecialization->seat_count;
                }
            }
            $seatCount = $totalSeatCount > 0 ? $totalSeatCount : 'غير محدد';
        }

        return view('applicants.pdf-preview', compact('rows', 'requestedDegree', 'requestedSpecialization', 'seatCount'));
    }

    public function exportWord(Request $request)
    {
        // Log incoming request data for debugging
        Log::info('Export Word Request Data:', $request->all());

        // Build same query as export
        $query = Applicant::query();
        $q = $request->input('q');
        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('first_name', 'like', "%{$q}%")
                    ->orWhere('second_name', 'like', "%{$q}%")
                    ->orWhere('last_name', 'like', "%{$q}%")
                    ->orWhere('statistical_number', 'like', "%{$q}%");

                // Split search query into parts and search each in full name
                $parts = explode(' ', trim($q));
                foreach ($parts as $part) {
                    if (!empty($part)) {
                        $sub->orWhereRaw("COALESCE(first_name, '') || ' ' || COALESCE(second_name, '') || ' ' || COALESCE(third_name, '') || ' ' || COALESCE(fourth_name, '') || ' ' || COALESCE(last_name, '') LIKE ?", ["%{$part}%"]);
                    }
                }
            });
        }
        if ($channel = $request->input('FirstDropdown1')) {
            $query->where('channel_id', $channel);
        }
        if ($rd = $request->input('DropDownListplceA1')) {
            $query->where('requested_degree_id', $rd);
        }
        if ($spec = $request->input('SecondDropdown1')) {
            $query->where('requested_specialization', $spec);
        }

        // New filter for is_martyr_relative
        $filterMartyr = $request->input('is_martyr_relative');
        if ($filterMartyr) {
            $query->where('is_martyr_relative', true);
        }

        // Log the constructed query for debugging
        Log::info('Constructed Query:', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);

        $rows = $query->with(['rank','gender','agency','degree','requestedDegree','requestedSpecialization','channel'])->select(['id','first_name','second_name','last_name','rank_id','agency_id','degree_id','specialization','requested_degree_id','requested_specialization','average','channel_id','is_martyr_relative','notes'])->get();

        // Check if rows are empty and log a warning
        if ($rows->isEmpty()) {
            Log::warning('No applicants found for the given filters.');
        }

        // Get filter values for the additional fields from actual applicants data
        $uniqueRequestedDegrees = $rows->pluck('requestedDegree.name_degree')->unique()->filter()->values();
        $uniqueRequestedSpecializations = $rows->pluck('requestedSpecialization.name_spcific')->unique()->filter()->values();

        $requestedDegree = $uniqueRequestedDegrees->isNotEmpty() ? $uniqueRequestedDegrees->join('، ') : 'غير محدد';
        $requestedSpecialization = $uniqueRequestedSpecializations->isNotEmpty() ? $uniqueRequestedSpecializations->join('، ') : 'غير محدد';

        // Calculate seat count: if specific filters provided, fetch from Spcific, else sum from applicants
        $filterSpecialization = $request->input('SecondDropdown1');
        $filterRequestedDegree = $request->input('DropDownListplceA1');
        $filterChannel = $request->input('FirstDropdown1');

        if ($filterSpecialization && $filterRequestedDegree && $filterChannel) {
            // Fetch specific seat_count
            $degree = Degree::find($filterRequestedDegree);
            $chanel = Chanel::find($filterChannel);
            if ($degree && $chanel) {
                $spcific = Spcific::where('code_spcific', $filterSpecialization)
                    ->where('code_degree', $degree->code_degree)
                    ->where('code_chanal', $chanel->code_chanal)
                    ->first();
                $seatCount = $spcific ? $spcific->seat_count : 'غير محدد';
            } else {
                $seatCount = 'غير محدد';
            }
        } else {
            // Sum from applicants' specializations
            $totalSeatCount = 0;
            foreach ($rows as $applicant) {
                if ($applicant->requestedSpecialization && $applicant->requestedSpecialization->seat_count > 0) {
                    $totalSeatCount += $applicant->requestedSpecialization->seat_count;
                }
            }
            $seatCount = $totalSeatCount > 0 ? $totalSeatCount : 'غير محدد';
        }

        // Generate HTML content for Word document
        $html = '<!DOCTYPE html>
        <html dir="rtl">
        <head>
            <meta charset="UTF-8">
            <title>قائمة المتقدمين</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 10px; }
                h1 { text-align: center; color: #2c3e50; font-size: 18px; }
                table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                th, td { border: 1px solid #ddd; padding: 4px; text-align: center; font-size: 10px; }
                th { background-color: #f2f2f2; font-weight: bold; }
                tr:nth-child(even) { background-color: #f9f9f9; }
                .info-table { width: 100%; margin-bottom: 10px; border: none; }
                .info-table td { border: none; padding: 2px; font-weight: bold; font-size: 10px; }
                .additional-table { margin-top: 15px; }
            </style>
        </head>
        <body>
            <h1>مديرية التدريب والتاهيل</h1>
            <p style="text-align: center; font-size: 12px;">برنامج المتقدمين للدراسات العليا خارج العراق ' . date('Y-m-d H:i:s') . '</p>

            <!-- معلومات إضافية -->
            <table class="info-table">
                <tr>
                    <td>الشهادة المطلوبة:</td>
                    <td>' . $requestedDegree . '</td>
                </tr>
                <tr>
                    <td>الاختصاص المطلوب:</td>
                    <td>' . $requestedSpecialization . '</td>
                </tr>
                <tr>
                    <td>عدد المقاعد:</td>
                    <td>' . $seatCount . '</td>
                </tr>
                 <tr>
                    <td>عدد المتقدمين:</td>
                    <td>' . count($rows) . '</td>
                </tr>
            </table>

            <table>
                <tr>
                    <th>التسلسل</th>
                    <th>الرتبة</th>
                    <th>الاسم</th>
                    <th>الوكالة</th>
                    <th>الشهادة الحاصل عليها</th>
                    <th>الاختصاص</th>
                    <th>الشهادة المطلوبة</th>
                    <th>الاختصاص المطلوب</th>
                    <th>قناة التقديم</th>
                    <th>المعدل</th>
                    <th>ذوي الشهداء</th>
                    <th>الملاحظات</th>
                </tr>';

        $counter = 1;
        foreach ($rows as $applicant) {
            $html .= '<tr>
                <td>' . $counter . '</td>
                <td>' . ($applicant->rank?->name_rank ?? '') . '</td>
                <td>' . $applicant->first_name . ' ' . $applicant->second_name . ' ' . $applicant->last_name . '</td>
                <td>' . ($applicant->agency?->age_name ?? '') . '</td>
                <td>' . ($applicant->degree?->name_degree ?? '') . '</td>
                <td>' . ($applicant->specialization ?? '') . '</td>
                <td>' . ($applicant->requestedDegree?->name_degree ?? '') . '</td>
                <td>' . ($applicant->requestedSpecialization?->name_spcific ?? '') . '</td>
                <td>' . ($applicant->channel?->name_chanel ?? '') . '</td>
                <td>' . ($applicant->average ?? '') . '</td>
                <td>' . ($applicant->is_martyr_relative ? 'نعم' : 'لا') . '</td>
                <td>' . ($applicant->notes ?? '') . '</td>
            </tr>';
            $counter++;
        }


        $html .= '</table>
          <table class="additional-table" style="margin-top: 5px; width: 100%; border-collapse: collapse; direction: rtl; text-align: right;">
            <thead>
                <tr>
                    <th style="font-size: 10px; padding: 2px;"> اللجنة</th>
                    <th style="font-size: 10px; padding: 2px;">              .......................... راي اللجنة ......................... </th>
                    <th style="font-size: 10px; padding: 2px;">التوقيع</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid #333; padding: 2px; font-size: 9px;">عضو لجنة منح الاجازات الدراسية<br>العميد الدكتور رافد عبد الواحد مهاوي</td>
                    <td style="border: 1px solid #333; padding: 2px;"></td>
                    <td style="border: 1px solid #333; padding: 2px; font-size: 9px;"class="arabic-numbers">...../..../2025 </td>
                </tr>
                    <td style="border: 1px solid #333; padding: 2px; font-size: 9px;">عضو لجنة منح الاجازات الدراسية<br>العميد علي كاطع حاجم حسن</td>
                    <td style="border: 1px solid #333; padding: 2px;"></td>
                    <td style="border: 1px solid #333; padding: 2px; font-size: 9px;"class="arabic-numbers">   ...../....../2025  </td>
                </tr>
                    <td style="border: 1px solid #333; padding: 2px; font-size: 9px;">عضو لجنة منح الاجازات الدراسية<br>العميد المهندس داود سلمان عذيب</td>
                    <td style="border: 1px solid #333; padding: 2px;"></td>
                    <td style="border: 1px solid #333; padding: 2px; font-size: 9px;"class="arabic-numbers">   ...../....../2025  </td>
                </tr>
                   <td style="border: 1px solid #333; padding: 2px; font-size: 9px;">عضو لجنة منح الاجازات الدراسية<br>ممثل وكالة الوزارة للشؤون الادارية والمالية<br>اللواء الحقوقي فاضل فرحان صالح</td>
                    <td style="border: 1px solid #333; padding: 2px;"></td>
                    <td style="border: 1px solid #333; padding: 2px; font-size: 9px;"class="arabic-numbers">   ...../....../2025  </td>
                </tr>
                <td style="border: 1px solid #333; padding: 2px; font-size: 9px;">رئيس لجنة منح الاجازات الدراسية<br>اللواء الحقوقي صباح حوشي محمد</td>
                    <td style="border: 1px solid #333; padding: 2px;"></td>
                    <td style="border: 1px solid #333; padding: 2px; font-size: 9px;"class="arabic-numbers">   ...../....../2025  </td>
                </tr>

            </tbody>
        </table>';

        $filename = 'applicants_' . date('Ymd_His') . '.doc';

        // Convert HTML to UTF-8 encoding explicitly
        $htmlUtf8 = mb_convert_encoding($html, 'UTF-8', 'auto');

        return response($htmlUtf8)
            ->header('Content-Type', 'application/vnd.ms-word; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function exportPdf(Applicant $applicant)
    {
        // Load applicant with relationships
        $applicant->load(['rank', 'gender', 'agency', 'degree', 'requestedDegree', 'requestedSpecialization', 'channel', 'ejaza']);

        // Return view with applicant data for display and print
        return view('applicants.pdf-single', compact('applicant'));
    }
    public function store(StoreApplicantRequest $request)
    {
        // Assume you already split the input into $parts[]
        // log full incoming payload to help debug missing values

        if ($request->has('save')) {
            $validated = $request->validated();

            // For date fields, accept raw input as is from the form
            $birthDate = $request->input('datebirth1');
            $graduationDate = $request->input('datedgr1');
            $adminOrderDate = $request->input('dateamr1');

            $data = [
                'rank_id' => $validated['DropDownListrank1'] ?? null,
                'first_name' => $validated['txtname11'] ?? null,
                'second_name' => $validated['txtname22'] ?? null,
                'third_name' => $validated['txtname33'] ?? null,
                'fourth_name' => $validated['txtname44'] ?? null,
                'last_name' => $validated['txtnameff'] ?? null,
                'statistical_number' => $validated['txtempcod1'] ?? null,
                'birth_place' => $validated['txtbirth1'] ?? null,
                'gender_id' => $validated['DropDownListgender1'] ?? null,
                'phone_number' => $validated['txtnumberphone1'] ?? null,
                'email' => $validated['txem1'] ?? null,
                'marital_status' => $validated['txtsts1'] ?? null,
                'birth_date' => $birthDate,
                'agency_id' => $validated['txtage1'] ?? null,
                'directorate' => $validated['txtgen1'] ?? null,
                'department' => $validated['txtdir1'] ?? null,
                'service_years' => $validated['khoyear1'] ?? null,
                'service_years_after_last_degree' => $validated['khyear1'] ?? null,
                'university_name' => $validated['txtunverQ1'] ?? null,
                'college_name' => $validated['txtnamecolge1'] ?? null,
                'degree_id' => $validated['DropDgr1'] ?? null,
                'specialization' => $validated['DropDownListT1'] ?? null,
                'average' => $validated['DropDownavg1'] ?? null,
                'graduation_date' => $graduationDate,
                'admin_order_number' => $validated['txtmamr1'] ?? null,
                'admin_order_date' => $adminOrderDate,
                'degree_country' => $validated['txtcount1'] ?? null,
                'requested_degree_id' => $validated['DropDownListplceA1'] ?? null,
                'channel_id' => $validated['FirstDropdown1'] ?? null,
                'requested_specialization' => $validated['SecondDropdown1'] ?? null,
                'requested_university' => $validated['txtcolgeQ1'] ?? null,
                'requested_college' => $validated['txtcolgeQ21'] ?? null,
                'academic_year' => $validated['DropDownListTA1'] ?? null,
                'ejaza_id' => $validated['datemoda1'] ?? null,
                'study_country' => $validated['txtplceQ1'] ?? null,
                'is_martyr_relative' => $validated['is_martyr_relative'] ?? false,
                'notes' => $validated['notes'] ?? null,
            ];

            Applicant::create($data);

        return back()->with('success', 'تم حفظ السجل بنجاح');
        }

        return redirect()->back();
    }

    // new: parse QR data and return inputs to fill the form without saving
    public function parse(Request $request)
    {
        $parts = explode('|', $request->input('all_data'));

        $decodedRankName = base64_decode($parts[0] ?? '');
        $rank = Rank::where('name_rank', $decodedRankName)->first();
        $decodedgenderName = base64_decode($parts[6] ?? '');
        $gender = Gender::where('name_gender', $decodedgenderName)->first();
        $decodedAgeName = base64_decode($parts[13] ?? '');
        $Agency = Agency::where('age_name', $decodedAgeName)->first();
        $decodeddgrName = base64_decode($parts[32] ?? '');
        $degree = Degree::where('name_degree', $decodeddgrName)->first();
        $decodedEjazaName = base64_decode($parts[29] ?? '');
        $ejaza = Ejaza::where('name_ejaza', $decodedEjazaName)->first();
        $decodedchnaName = base64_decode($parts[34] ?? '');
        $chanel = Chanel::where('name_chanel', $decodedchnaName)->first();
        $decodeddgrmaName = base64_decode($parts[27] ?? '');
        $degreem = Degree::where('name_degree', $decodeddgrmaName)->first();
        $decodedspfmaName = base64_decode($parts[33] ?? '');
        $spcific=Spcific::where('name_spcific', $decodedspfmaName)->first();

        return back()->withInput([
            'DropDownListrank1'   => $rank?->id,
            'DropDownListgender1' => $gender?->id,
            'txtname11'           => base64_decode($parts[1]  ?? ''),
            'txtname22'           => base64_decode($parts[2]  ?? ''),
            'txtname33'           => base64_decode($parts[3]  ?? ''),
            'txtname44'           => base64_decode($parts[4]  ?? ''),
            'txtnameff'           => base64_decode($parts[9]  ?? ''),
            'txtempcod1'          => base64_decode($parts[5]  ?? ''),
            'txtbirth1'           => base64_decode($parts[7]  ?? ''),
            'txtnumberphone1'     => base64_decode($parts[8]  ?? ''),
            'txem1'               => base64_decode($parts[10] ?? ''),
            'txtsts1'             => base64_decode($parts[11] ?? ''),
            'datebirth1'          => base64_decode($parts[12] ?? ''),
            'txtage1'             => $Agency?->id,
            'txtgen1'             => base64_decode($parts[16] ?? ''),
            'txtdir1'             => base64_decode($parts[15] ?? ''),
            'khoyear1'            => base64_decode($parts[31] ?? ''),
            'khyear1'             => base64_decode($parts[14] ?? ''),
            'txtnamecolge1'       => base64_decode($parts[24] ?? ''),
            'txtunverQ1'          => base64_decode($parts[22] ?? ''),
            'DropDgr1'            => $degree?->id,
            'DropDownListT1'      => base64_decode($parts[23] ?? ''),
            'DropDownavg1'        => base64_decode($parts[21] ?? ''),
            'datedgr1'            => base64_decode($parts[19] ?? ''),
            'txtmamr1'            => base64_decode($parts[20] ?? ''),
            'dateamr1'            => base64_decode($parts[17] ?? ''),
            'txtcount1'           => base64_decode($parts[18] ?? ''),
            'DropDownListplceA1'  => $degreem?->id,
            'FirstDropdown1'      => $chanel?->id,
            'SecondDropdown1'     => $spcific->id,
            'txtcolgeQ1'          => base64_decode($parts[25] ?? ''),
            'txtcolgeQ21'         => base64_decode($parts[26] ?? ''),
            'DropDownListTA1'     => base64_decode($parts[28] ?? ''),
            'datemoda1'           => $ejaza?->id,
            'txtplceQ1'           => base64_decode($parts[30] ?? ''),
            'notes'               => base64_decode($parts[35] ?? ''),
        ]);
    }

    /**
     * AJAX: check whether a statistical number already exists.
     */
    public function checkStatisticalNumber(Request $request)
    {
        $request->validate(['txtempcod1' => ['required','string','max:50']]);
        $stat = trim($request->input('txtempcod1'));
        $applicant = Applicant::where('statistical_number', $stat)->first();
        if ($applicant) {
            // build a readable full name from available name parts
            $parts = array_filter([
                $applicant->first_name,
                $applicant->second_name,
                $applicant->third_name ?? null,
                $applicant->fourth_name ?? null,
                $applicant->last_name ?? null,
            ], fn($p) => !is_null($p) && (string)trim($p) !== '');
            $fullName = implode(' ', $parts);
            return response()->json([
                'exists' => true,
                'id' => $applicant->id,
                'name' => $fullName,
            ]);
        }

        return response()->json(['exists' => false]);
    }

    /**
     * Fetch seat_count based on requested_specialization, requestedDegree, channel
     */
    public function getSeatCount(Request $request)
    {
        $request->validate([
            'requested_specialization' => ['required', 'string'],
            'requested_degree_id' => ['required', 'integer', 'exists:degrees,id'],
            'channel_id' => ['required', 'integer', 'exists:chanels,id'],
        ]);

        $requestedSpecialization = $request->input('requested_specialization');
        $requestedDegreeId = $request->input('requested_degree_id');
        $channelId = $request->input('channel_id');

        // Get code_degree from Degree
        $degree = Degree::find($requestedDegreeId);
        if (!$degree) {
            return response()->json(['seat_count' => 0, 'error' => 'Degree not found']);
        }
        $codeDegree = $degree->code_degree;

        // Get code_chanal from Chanel
        $chanel = Chanel::find($channelId);
        if (!$chanel) {
            return response()->json(['seat_count' => 0, 'error' => 'Channel not found']);
        }
        $codeChanal = $chanel->code_chanal;

        // Query Spcific
        $spcific = Spcific::where('code_spcific', $requestedSpecialization)
            ->where('code_degree', $codeDegree)
            ->where('code_chanal', $codeChanal)
            ->first();

        $seatCount = $spcific ? $spcific->seat_count : 0;

        return response()->json(['seat_count' => $seatCount]);
    }
}
