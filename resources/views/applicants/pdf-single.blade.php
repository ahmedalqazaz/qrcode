<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>

    <meta charset="UTF-8">
    <title>تصدير PDF للمتقدم</title>
    <style>
                body {
                    font-family: Arial;
                    font-weight: bold;
                    font-size: 14px;
                    margin: 10px 15px 10px 15px;
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
                .label-td {
                    background: #d3d3d3;


                }

                .print-button {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white;
                    border: none;
                    padding: 15px 30px;
                    font-size: 16px;
                    font-weight: bold;
                    border-radius: 10px;
                    cursor: pointer;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
                    transition: all 0.3s ease;
                    margin: 20px auto;
                    display: block;
                    position: relative;
                    text-transform: uppercase;
                    letter-spacing: 1px;
                }

                .print-button:hover {
                    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
                    transform: translateY(-2px);
                    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
                }

                .print-button:active {
                    transform: translateY(0);
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
                }

                @media print {
                    .print-button {
                        display: none !important;
                    }
                }
            </style>
</head>
<body>
    <div class="header">
        <h2 style="font-family: 'Dubai', Arial, sans-serif; font-weight: bold; font-size: 18px;">وزارة الداخلية - مديرية التدريب والتاهيل</h2>
        <h1 style="font-family: 'Dubai', Arial, sans-serif; font-weight: bold; font-size: 16px;">استمارة المفاضلة</h1>
    </div>
    <table >
        <thead>
            <tr>
                <th colspan="2">البيانات الشخصية والوظيفية</th>
                <th colspan="2">بيانات الشهادة الحاصل عليها</th>
                <th colspan="2">بيانات الشهادة المطلوبة</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="label-td">الرقم الاحصائي</td>
                <td class="arabic-numbers">{{ $applicant->statistical_number ?? '' }}</td>
                <td class="label-td">الدرجة العلمية الحاصل عليها</td>
                <td>{{ $applicant->degree?->name_degree ?? '' }}</td>
                <td class="label-td">الدرجة العلمية المطلوبة</td>
                <td>{{ $applicant->requestedDegree?->name_degree ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-td">الرتبة</td>
                <td>{{ $applicant->rank?->name_rank ?? '' }}</td>
                <td class="label-td">الاختصاص</td>
                <td>{{ $applicant->specialization ?? '' }}</td>
                <td class="label-td">الاختصاص المطلوب</td>
                <td>{{ $applicant->requestedSpecialization?->name_spcific ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-td">الاسم الكامل</td>
                <td>{{ $applicant->first_name }} {{ $applicant->second_name }} {{ $applicant->last_name }}</td>
                <td class="label-td">الجامعة</td>
                <td>{{ $applicant->university_name ?? '' }}</td>
                <td class="label-td">قناة التقديم</td>
                <td>{{ $applicant->channel?->name_chanel ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-td">الوكالة</td>
                <td>{{ $applicant->agency?->age_name ?? '' }}</td>
                <td class="label-td">الكلية</td>
                <td>{{ $applicant->college_name ?? '' }}</td>
                <td class="label-td">اسم الجامعة</td>
                <td>{{ $applicant->requested_university ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-td">المديرية العامة</td>
                <td>{{ $applicant->directorate ?? '' }}</td>
                <td class="label-td">المعدل</td>
                <td class="arabic-numbers">{{ $applicant->average ?? '' }}</td>
                <td class="label-td">اسم الكلية</td>
                <td>{{ $applicant->requested_college ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-td">تاريخ الولادة</td>
                <td class="arabic-numbers">{{ $applicant->birth_date ?? '' }}</td>
                <td class="label-td">بلد الدراسة</td>
                <td>{{ $applicant->degree_country ?? '' }}</td>
                <td class="label-td">بلد الدراسة</td>
                <td>{{ $applicant->study_country ?? '' }}</td>
            </tr>
            <tr>
                <td class="label-td">الخدمة الفعلية في الوظيفة</td>
                <td class="arabic-numbers">{{ $applicant->service_years ?? '' }}</td>
                <td class="label-td">عدد سنوات الخدمة بعد اخر شهادة</td>
                <td class="arabic-numbers">{{ $applicant->service_years_after_last_degree ?? '' }}</td>
                <td class="label-td">مدة الاجازة المطلوبة</td>
                <td>{{ $applicant->ejaza?->name_ejaza ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="6" style="padding: 10px; font-weight: bold; text-align: center;">
                    @php
                        $channelCode = $applicant->channel?->code_chanel ?? '';
                        $customLabel = '';
                        if ($channelCode === 'x') {
                            $customLabel = "قناة التقديم هي نفقة خاصة";
                        } elseif ($channelCode === 'y') {
                            $customLabel = "قناة التقديم اجازة دراسية";
                        } else {
                            $customLabel = "قناة التقديم: " . ($applicant->channel?->name_chanel ?? '');
                        }
                    @endphp
                    {{ $customLabel }}
                </td>
            </tr>
            <tr>
                <th colspan="2">اللجنة</th>
                <th colspan="2">راي اللجنة</th>
                <th colspan="2">التوقيع</th>
            </tr>
            <tr>
                <td colspan="2">عضو لجنة منح الاجازات الدراسية<br>العميد الدكتور رافد عبد الواحد مهاوي</td>
                <td colspan="2"></td>
                <td colspan="2" class="arabic-numbers">...../..../٢٠٢٥</td>
            </tr>
            <tr>
                <td colspan="2">عضو لجنة منح الاجازات الدراسية<br>العميد علي كاطع حاجم حسن</td>
                <td colspan="2"></td>
                <td colspan="2" class="arabic-numbers">...../..../٢٠٢٥</td>
            </tr>
            <tr>
                <td colspan="2">عضو لجنة منح الاجازات الدراسية<br>العميد المهندس داود سلمان عذيب</td>
                <td colspan="2"></td>
                <td colspan="2" class="arabic-numbers">...../..../٢٠٢٥</td>
            </tr>
            <tr>
                <td colspan="2">عضو لجنة منح الاجازات الدراسية<br>ممثل وكالة الوزارة للشؤون الادارية والمالية<br>اللواء الحقوقي فاضل فرحان صالح</td>
                <td colspan="2"></td>
                <td colspan="2" class="arabic-numbers">...../..../٢٠٢٥</td>
            </tr>
            <tr>
                <td colspan="2">رئيس لجنة منح الاجازات الدراسية<br>اللواء الحقوقي صباح حوشي محمد</td>
                <td colspan="2"></td>
                <td colspan="2" class="arabic-numbers">...../..../٢٠٢٥</td>
            </tr>
        </tbody>
    </table>
    <button class="print-button" onclick="window.print()">طباعة PDF</button>
</body>
</html>
<script>
function toArabicIndicNumbers(str) {
    return str.replace(/\d/g, d => "٠١٢٣٤٥٦٧٨٩"[d]);
}

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".arabic-numbers").forEach(el => {
        el.textContent = toArabicIndicNumbers(el.textContent);
    });
});
</script>
