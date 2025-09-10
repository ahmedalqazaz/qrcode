<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Style\Table;
use PhpOffice\PhpWord\Style\Font;
use PhpOffice\PhpWord\Style\Paragraph;
use Barryvdh\DomPDF\Facade\Pdf;

class Wordexport extends Controller
{
    public function exportComparisonForm(Request $request)
    {
        // Log incoming request data for debugging
        Log::info('Export Comparison Form Request Data:', $request->all());

        // Build same query as export
        $query = Applicant::query();
        $q = $request->input('q');
        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('first_name', 'like', "%{$q}%")
                    ->orWhere('second_name', 'like', "%{$q}%")
                    ->orWhere('last_name', 'like', "%{$q}%")
                    ->orWhere('statistical_number', 'like', "%{$q}%");
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

        $rows = $query->with(['rank','gender','agency','degree','requestedDegree','requestedSpecialization','channel','ejaza'])->select(['id','first_name','second_name','last_name','rank_id','agency_id','degree_id','specialization','requested_degree_id','requested_specialization','average','channel_id','is_martyr_relative','ejaza_id','notes','directorate','birth_date','service_years','service_years_after_last_degree','degree_country','university_name','college_name','requested_university','requested_college','study_country','statistical_number'])->get();

        // Check if rows are empty and log a warning
        if ($rows->isEmpty()) {
            Log::warning('No applicants found for the given filters.');
        }




        // Generate HTML content for Word document with field labels on the right in 3 columns
        $html = '<!DOCTYPE html>
        <html dir="rtl">
        <head>
            <meta charset="UTF-8">
            <title>استمارة المفاضلة</title>
                <style>
                body {
                    font-family: Arial;
                    font-weight: bold;
                    font-size: 14px;
                    margin: 0;
                    direction: rtl;
                    background: white;
                    line-height: 1.2;
                    page-break-inside: avoid;
                }


                @page {
                    size: A4;
                    margin: 0;
                }
                    .header {
                        text-align: right;
                        text-align-last: center;
                        font-size: 12px;
                        font-weight: bold;
                        margin-bottom: 0;
                        color: #2c3e50;
                        padding: 0;

                        border-bottom: 2px solid #000; padding: 10px;
                    }
                 .header img { width: 100%; height: auto; max-height: 100px; }
                .applicant-section {
                    margin-bottom: 0;
                    padding: 0;
                    page-break-inside: avoid;
                    background: white;
                }
                .applicant-section:first-child {
                    page-break-before: avoid;
                }
                .applicant-number {
                    font-size: 10px;
                    font-weight: bold;
                    margin-bottom: 0;
                    color: #2c3e50;
                    background: #f8f9fa;
                    padding: 0 3px;
                    border-radius: 2px;
                    display: inline-block;
                    border: 1px solid #3498db;
                }
                .title {
                    text-align: center;
                    font-size: 12px;
                    font-weight: bold;
                    margin: 0;
                    color: #34495e;
                    padding: 0;
                }
                table {
                  width: 100%;
                   margin: 0;
                   border-collapse: collapse;
                   border-spacing: 0;
                   border: 1px solid #333;
                   direction: rtl;
                   text-align:center;
                   font-size: 14px;
                   border-radius: 8px;
                   box-shadow: 0 0 10px rgba(0,0,0,0.1);
                   background-color: #f9f9f9;
                }
                th {

                    color: #333;
                    padding: 10px;
                    font-weight: 600;
                    font-size: 16px;
                    border: 1px solid #333;
                    background-color: #e2e2e2;
                    border-radius: 8px 8px 0 0;

                }
                td {
                    padding: 10px;
                    border: 1px solid #333;
                    background-color: white;

                }
                .additional-table {
                    margin-top: 0;
                    border-collapse: collapse;
                }
                .additional-table th {

                    color: #333;
                    padding: 2px 2px;
                    font-size: 12px;

                }
                .additional-table td {
                    padding: 2px 2px;


                }
                .arabic-numbers {
                    font-family: "Courier New", monospace;
                    font-weight: bold;
                    color: #2a1b19ff;
                    text-align: center;
                    font-size: 10px;
                }
                .label-td {
                    background: #d3d3d3;


                }
            </style>
        </head>
        <body>';


        foreach ($rows as $applicant) {

            $html .= '</div>
            <div class="applicant-section">
            <table >
            <thead>
            <tr>
                <th colspan="2"class="label-td">البيانات الشخصية والوظيفية </th>
                <th colspan="2"class="label-td">بيانات الشهادة الحاصل عليا</th>
                <th colspan="2"class="label-td">بيانات الشهادة المطلوبة</th>
            </tr>
            </thead>
<tr>
    <td class="label-td">الرقم الاحصائي</td>
    <td>' . ($applicant->statistical_number ?? '') . '</td>
    <td class="label-td">الدرجة العلمية الحاصل عليها</td>
    <td>' . ($applicant->degree?->name_degree ?? '') . '</td>
    <td class="label-td">الدرجة العلمية المطلوبة</td>
    <td>' . ($applicant->requestedDegree?->name_degree ?? '') . '</td>
</tr>
<tr>
    <td class="label-td">الرتبة</td>
    <td>' . ($applicant->rank?->name_rank ?? '') . '</td>
    <td class="label-td">الاختصاص</td>
    <td>' . ($applicant->specialization ?? '') . '</td>
    <td class="label-td">الاختصاص المطلوب</td>
    <td>' . ($applicant->requestedSpecialization?->name_spcific ?? '') . '</td>
</tr>
<tr>
    <td class="label-td">الاسم الكامل</td>
    <td>' . $applicant->first_name . ' ' . $applicant->second_name . ' ' . $applicant->last_name . '</td>
    <td class="label-td">الجامعة</td>
    <td>' . ($applicant->university_name ?? '') . '</td>
    <td class="label-td">قناة التقديم</td>
    <td>' . ($applicant->channel?->name_chanel ?? '') . '</td>
</tr>
<tr>
    <td class="label-td">الوكالة</td>
    <td>' . ($applicant->agency?->age_name ?? '') . '</td>
    <td class="label-td">الكلية</td>
    <td>' . ($applicant->college_name ?? '') . '</td>
    <td class="label-td">اسم الجامعة</td>
    <td>' . ($applicant->requested_university ?? '') . '</td>
</tr>
<tr>
    <td class="label-td">المديرية العامة</td>
    <td>' . ($applicant->directorate ?? '') . '</td>
    <td class="label-td">المعدل</td>
    <td>' . ($applicant->average ?? '') . '</td>
    <td class="label-td">اسم الكلية</td>
    <td>' . ($applicant->requested_college ?? '') . '</td>
</tr>
<tr>
    <td class="label-td">تاريخ الولادة</td>
    <td>' . ($applicant->birth_date ?? '') . '</td>
    <td class="label-td">بلد الدراسة</td>
    <td>' . ($applicant->degree_country ?? '') . '</td>
    <td class="label-td">بلد الدراسة</td>
    <td>' . ($applicant->study_country ?? '') . '</td>
</tr>
<tr>
    <td class="label-td">الخدمة الفعلية في الوظيفة</td>
    <td>' . ($applicant->service_years ?? '') . '</td>
    <td class="label-td">عدد سنوات الخدمة بعد اخر شهادة</td>
    <td>' . ($applicant->service_years_after_last_degree ?? '') . '</td>
    <td class="label-td">مدة الاجازة المطلوبة</td>
    <td>' . ($applicant->ejaza?->name_ejaza ?? '') . '</td>
</tr>

                <tr>

                <td  colspan="6" style=" padding: 5px;">
               ';
                $channelCode = $applicant->channel_id;
                $customLabel = '';
                if ($channelCode == 1) {
                    $customLabel = "ملاحظة:"."<br>"."اصدار امر اداري يتضمن الموافقة على اكمال الدراسة اثناء التوظيف وعلى النفقة الخاصة ومنحه مدة الاجازة المطلوبة استناداً الى قانون رقم 20 لسنة 2020";
                } elseif ($channelCode == '2') {
                   $customLabel = "ملاحظة:"."<br>"." اصدار امر اداري يتضمن الموافقة على الاجازة الدراسية استناداً الى قانون رقم 14 لسنة 2009 و قانون تعديل قانون الخدمة المدنية رقم 24 لسنة 1960 وتعليمات رقم 165 لسنة 2011 ونظام رقم 19 لسنة 1988";

                } else {
                    $customLabel = "ملاحظة:".$channelCode;
                }
                $html .= $customLabel . '</td>
                </tr>
                <tr>
                    <th colspan="2">اللجنة</th>
                    <th colspan="2"> راي اللجنة </th>
                    <th colspan="2">التوقيع</th>
                </tr>
                <tr>
                    <td colspan="2"><label>عضو لجنة منح الاجازات الدراسية<br>العميد الدكتور رافد عبد الواحد مهاوي</label></td>
                    <td colspan="2"><label></label></td>
                    <td colspan="2" class="arabic-numbers"><label>...../..../2025</label></td>
                </tr>
                <tr>
                    <td colspan="2"><label>عضو لجنة منح الاجازات الدراسية<br>العميد علي كاطع حاجم حسن</label></td>
                    <td colspan="2"><label></label></td>
                    <td colspan="2" class="arabic-numbers"><label>...../..../2025</label></td>
                </tr>
                <tr>
                    <td colspan="2"><label>عضو لجنة منح الاجازات الدراسية<br>العميد المهندس داود سلمان عذيب</label></td>
                    <td colspan="2"><label></label></td>
                    <td colspan="2" class="arabic-numbers"><label>...../..../2025</label></td>
                </tr>
                <tr>
                    <td colspan="2"><label>عضو لجنة منح الاجازات الدراسية<br>ممثل وكالة الوزارة للشؤون الادارية والمالية<br>اللواء الحقوقي فاضل فرحان صالح</label></td>
                    <td colspan="2"><label></label></td>
                    <td colspan="2" class="arabic-numbers"><label>...../..../2025</label></td>
                </tr>
                <tr>
                    <td colspan="2"><label>رئيس لجنة منح الاجازات الدراسية<br>اللواء الحقوقي صباح حوشي محمد</label></td>
                    <td colspan="2"><label></label></td>
                    <td colspan="2" class="arabic-numbers"><label>...../..../2025</label></td>
                </tr>
            </tbody>
        </table>
        ';
        }

        $html .= '</body>
        </html>';

        $filename = 'applicants_' . date('Ymd_His') . '.doc';

        return response($html)
            ->header('Content-Type', 'application/vnd.ms-word; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename=' . $filename)
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');

    }
}
