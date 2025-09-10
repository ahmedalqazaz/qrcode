<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <title>المتقدمين للدراسات العليا خارج العراق</title>
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 5px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid #007bff;
        }

        .header h1 {
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .print-actions {
            text-align: center;
            margin-bottom: 15px;
        }

        .btn {
            padding: 8px 16px;
            margin: 0 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #545b62;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            direction: rtl;
            text-align: right;
        }

        th, td {
            border: 1px solid #333;
            padding: 2px;
            font-size: 10px;
            direction: rtl;
        }

        th {
            background: #f0f0f0;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        @media print {
            .print-actions {
                display: none;
            }

            body {
                background-color: white;
                margin: 0;
                padding: 0;
            }

            .container {
                box-shadow: none;
                padding: 0;
                margin: 0;
            }

            .header {
                border-bottom: 2px solid #000;
            }
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="header">
        <!-- Logo and Ministry Header -->
        <div style="text-align: center; margin-bottom: 10px;">
    <img src="/2324.jpg" alt="وزارة الداخلية - مديرية التدريب والتاهيل" style="position: absolute; top: 5px; left: 0; width: 100%; height: 200px;; object-fit:fill ; z-index: 1; background-color: white;">

        <!-- معلومات إضافية -->
        <table class="info-table" style="width: 100%; margin-bottom: 10px; margin-top:210px; margin-right:10px; border: none;">
            <tr>
                <td style="border: none; padding: 1px; font-weight: bold; font-size: 10px;">الدرجة العلمية المطلوبة:</td>
                <td style="border: none; padding: 1px; font-size: 10px;">{{ $requestedDegree ?? 'غير محدد' }}</td>
            </tr>
            <tr>
                <td style="border: none; padding: 1px; font-weight: bold; font-size: 10px;">الاختصاص المطلوب:</td>
                <td style="border: none; padding: 1px; font-size: 10px;">{{ $requestedSpecialization ?? 'غير محدد' }}</td>
            </tr>
            <tr>
                <td style="border: none; padding: 1px; font-weight: bold; font-size: 10px;">عدد المقاعد:</td>
                <td style="border: none; padding: 1px; font-size: 10px;" class="arabic-numbers">{{ $seatCount ?? 'غير محدد' }}</td>
            </tr>
            <tr>
                <td style="border: none; padding: 1px; font-weight: bold; font-size: 10px;">عددالمتفدمين:</td>
                <td style="border: none; padding: 1px; font-size: 10px;" class="arabic-numbers">{{ count($rows) }}</td>
            </tr>
        </table>
    </div>

        <div class="print-actions">
            <button class="btn btn-primary" onclick="window.print()">
                🖨️ طباعة الصفحة
            </button>
            <button class="btn btn-secondary" onclick="window.history.back()">
                ↩️ رجوع
            </button>
        </div>

        <table style="margin-right:1px;" >
            <thead>
                <tr>
                    <th class="arabic-numbers">التسلسل</th>
                    <th>الرتبة</th>
                    <th>الاسم</th>
                    <th>الوكالة</th>
                    <th>الشهادة الحاصل عليها</th>
                    <th>الاختصاص</th>
                    <th>قناة التقديم</th>
                    <th>الدرجة العلمية المطلوبة</th>
                    <th>الاختصاص المطلوب</th>
                     <th>مدة الاجازة</th>
                    <th >المعدل</th>
                    <th>ذوي الشهداء</th>

                    <th>الملاحظات</th>
                </tr>
            </thead>
            <tbody>
                @php $counter = 1; @endphp
                @foreach($rows as $r)
                    <tr>
                        <td style="border: 1px solid #333; padding: 2px; font-size: 9px;" class="arabic-numbers">{{ $counter++ }}</td>
                        <td>{{ $r->rank?->name_rank ?? '' }}</td>
                        <td>{{ $r->first_name }} {{ $r->second_name }} {{ $r->last_name }}</td>
                        <td>{{ $r->agency?->age_name ?? '' }}</td>
                        <td>{{ $r->degree?->name_degree ?? '' }}</td>
                        <td>{{ $r->specialization ?? '' }}</td>
                        <td>{{ $r->channel?->name_chanel ?? '' }}</td>
                        <td>{{ $r->requestedDegree?->name_degree ?? '' }}</td>
                        <td>{{ $r->requestedSpecialization?->name_spcific ?? '' }}</td>
                        <td style="border: 1px solid #333; padding: 2px; font-size: 9px;" class="arabic-numbers">{{ $r->ejaza?->name_ejaza ?? '' }}</td>
                        <td style="border: 1px solid #333; padding: 2px; font-size: 9px;" class="arabic-numbers">{{ $r->average ?? '' }}</td>
                        <td>{{ $r->is_martyr_relative ? 'نعم' : 'لا' }}</td>
                        <td>{{ $r->notes ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if(count($rows) === 0)
            <div style="text-align: center; padding: 20px; color: #6c757d;">
                <h3 style="font-size: 14px;">لا توجد بيانات للعرض</h3>
                <p style="font-size: 12px;">لم يتم العثور على أي سجلات تطابق معايير البحث</p>
            </div>
        @endif
        <style>
  table {
    width: 100%; /* Optional: make the table span the full width */
  }
  th, td {
    text-align: center;
  }
</style>
        <!-- جدول إضافي مكون من عامودين و 5 صفوف -->
        <table class="additional-table" style="margin-top: 5px; width: 100%; border-collapse: collapse; direction: rtl; text-align: right;margin-right:1px;">
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
                    <td style="border: 1px solid #333; padding: 2px; font-size: 9px;" class="arabic-numbers">...../..../2025 </td>
                </tr>
                    <td style="border: 1px solid #333; padding: 2px; font-size: 9px;">عضو لجنة منح الاجازات الدراسية<br>العميد علي كاطع حاجم حسن</td>
                    <td style="border: 1px solid #333; padding: 2px;"></td>
                    <td style="border: 1px solid #333; padding: 2px; font-size: 9px;" class="arabic-numbers">   ...../....../2025  </td>
                </tr>
                    <td style="border: 1px solid #333; padding: 2px; font-size: 9px;">عضو لجنة منح الاجازات الدراسية<br>العميد المهندس داود سلمان عذيب</td>
                    <td style="border: 1px solid #333; padding: 2px;"></td>
                    <td style="border: 1px solid #333; padding: 2px; font-size: 9px;" class="arabic-numbers">   ...../....../2025  </td>
                </tr>
                   <td style="border: 1px solid #333; padding: 2px; font-size: 9px;">عضو لجنة منح الاجازات الدراسية<br>ممثل وكالة الوزارة للشؤون الادارية والمالية<br>اللواء الحقوقي فاضل فرحان صالح</td>
                    <td style="border: 1px solid #333; padding: 2px;"></td>
                    <td style="border: 1px solid #333; padding: 2px; font-size: 9px;" class="arabic-numbers">   ...../....../2025  </td>
                </tr>
                <td style="border: 1px solid #333; padding: 2px; font-size: 9px;">رئيس لجنة منح الاجازات الدراسية<br>اللواء الحقوقي صباح حوشي محمد</td>
                    <td style="border: 1px solid #333; padding: 2px;"></td>
                    <td style="border: 1px solid #333; padding: 2px; font-size: 9px;" class="arabic-numbers">   ...../....../2025  </td>
                </tr>

            </tbody>
        </table>
    </div>

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

</body>
</html>
