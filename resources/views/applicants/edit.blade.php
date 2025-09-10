@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4 text-center">تعديل بيانات المتقدم</h2>

    <form id="qrForm" method="POST" action="{{ route('applicants.update', $applicant) }}">
        @csrf
        @method('PUT')

        <!-- القسم الأول: بيانات شخصية أساسية -->
        <div class="form-section">
            <div class="section-header">البيانات الشخصية الأساسية</div>

            <div class="row g-3">
                <div class="col-md-4">
                    <label for="DropDownListrank1" class="form-label">الرتبة</label>
                    <select class="form-select" id="DropDownListrank1" name="DropDownListrank1" required>
                        <option value="">اختر الرتبة</option>
                        @foreach ($ranks as $rank)
                            <option value="{{ $rank->id }}" {{ old('DropDownListrank1', $applicant->rank_id) == $rank->id ? 'selected' : '' }}>
                                {{ $rank->name_rank}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="txtname11" class="form-label">الاسم 1</label>
                    <input type="text" class="form-control" id="txtname11" name="txtname11" value="{{ old('txtname11', $applicant->first_name) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="txtname22" class="form-label">الاسم 2</label>
                    <input type="text" class="form-control" id="txtname22" name="txtname22" value="{{ old('txtname22', $applicant->second_name) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="txtname33" class="form-label">الاسم 3</label>
                    <input type="text" class="form-control" id="txtname33" name="txtname33" value="{{ old('txtname33', $applicant->third_name) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="txtname44" class="form-label">الاسم 4</label>
                    <input type="text" class="form-control" id="txtname44" name="txtname44" value="{{ old('txtname44', $applicant->fourth_name) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="txtnameff" class="form-label">اللقب</label>
                    <input type="text" class="form-control" id="txtnameff" name="txtnameff" value="{{ old('txtnameff', $applicant->last_name) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="txtempcod1" class="form-label">الرقم الاحصائي</label>
                    <input type="number" class="form-control" id="txtempcod1" name="txtempcod1" value="{{ old('txtempcod1', $applicant->statistical_number) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="txtbirth1" class="form-label">محل الولادة</label>
                    <input type="text" class="form-control" id="txtbirth1" name="txtbirth1" value="{{ old('txtbirth1', $applicant->birth_place) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="DropDownListgender1" class="form-label">الجنس</label>
                    <select id="DropDownListgender1" name="DropDownListgender1" class="form-select" required>
                        <option value="">اختر الجنس</option>
                        @foreach ($genders as $gender)
                            <option value="{{ $gender->id }}" {{ old('DropDownListgender1', $applicant->gender_id) == $gender->id ? 'selected' : '' }}>
                                {{ $gender->name_gender}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="txtnumberphone1" class="form-label">رقم الهاتف</label>
                    <input type="tel" class="form-control" id="txtnumberphone1" name="txtnumberphone1" value="{{ old('txtnumberphone1', $applicant->phone_number) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="txem1" class="form-label">البريد الالكتروني</label>
                    <input type="email" class="form-control" id="txem1" name="txem1" value="{{ old('txem1', $applicant->email) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="txtsts1" class="form-label">الحالة الاجتماعية</label>
                    <input type="text" class="form-control" id="txtsts1" name="txtsts1" value="{{ old('txtsts1', $applicant->marital_status) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="datebirth1" class="form-label">تاريخ الميلاد</label>
                    <input type="date" class="form-control" id="datebirth1" name="datebirth1" value="{{ old('datebirth1', $applicant->birth_date) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="is_martyr_relative" class="form-label">ذوي الشهداء</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_martyr_relative" name="is_martyr_relative" value="1" {{ old('is_martyr_relative', $applicant->is_martyr_relative) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_martyr_relative">
                            نعم
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- القسم الثاني: المعلومات الادارية -->
        <div class="form-section">
            <div class="section-header">المعلومات الادارية</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="txtage1" class="form-label">الوكالة</label>
                    <select class="form-select" id="txtage1" name="txtage1" required>
                        <option value="">اختر الوكالة</option>
                        @foreach ($agencis as $agency)
                            <option value="{{ $agency->id }}" {{ old('txtage1', $applicant->agency_id) == $agency->id ? 'selected' : '' }}>
                                {{ $agency->age_name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="txtgen1" class="form-label">المديرية</label>
                    <input type="text" class="form-control" id="txtgen1" name="txtgen1" value="{{ old('txtgen1', $applicant->directorate) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="txtdir1" class="form-label">القسم</label>
                    <input type="text" class="form-control" id="txtdir1" name="txtdir1" value="{{ old('txtdir1', $applicant->department) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="khoyear1" class="form-label">عدد سنوات الخدمة</label>
                    <input type="number" class="form-control" id="khoyear1" name="khoyear1" value="{{ old('khoyear1', $applicant->service_years) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="khyear1" class="form-label">عدد سنوات الخدمة بعد اخر شهادة</label>
                    <input type="number" class="form-control" id="khyear1" name="khyear1" value="{{ old('khyear1', $applicant->service_years_after_last_degree) }}" required>
                </div>
            </div>
        </div>

        <!-- القسم الثالث: معلومات الشهادة الحاصل عليها -->
        <div class="form-section">
            <div class="section-header">معلومات الشهادة الحاصل عليها المتقدم</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="txtnamecolge1" class="form-label">اسم الجامعة</label>
                    <input type="text" class="form-control" id="txtnamecolge1" name="txtnamecolge1" value="{{ old('txtnamecolge1', $applicant->university_name) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="txtunverQ1" class="form-label">اسم الكلية</label>
                    <input type="text" class="form-control" id="txtunverQ1" name="txtunverQ1" value="{{ old('txtunverQ1', $applicant->college_name) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="DropDgr1" class="form-label">الدرجة العلمية</label>
                    <select id="DropDgr1" name="DropDgr1" class="form-select" required>
                        <option value="">اختر الشهادة الحاصل عليها</option>
                        @foreach ($degrees as $degree)
                            <option value="{{ $degree->id }}" {{ old('DropDgr1', $applicant->degree_id) == $degree->id ? 'selected' : '' }}>
                                {{ $degree->name_degree}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="DropDownListT1" class="form-label">الاختصاص</label>
                    <input type="text" class="form-control" id="DropDownListT1" name="DropDownListT1" value="{{ old('DropDownListT1', $applicant->specialization) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="DropDownavg1" class="form-label">المعدل</label>
                    <input type="number" step="0.01" class="form-control" id="DropDownavg1" name="DropDownavg1" value="{{ old('DropDownavg1', $applicant->average) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="datedgr1" class="form-label">تاريخ التخرج</label>
                    <input type="date" class="form-control" id="datedgr1" name="datedgr1" value="{{ old('datedgr1', $applicant->graduation_date) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="txtmamr1" class="form-label">رقم الامر الاداري لمنح شهادة الماجستير</label>
                    <input type="number" class="form-control" id="txtmamr1" name="txtmamr1" value="{{ old('txtmamr1', $applicant->admin_order_number) }}">
                </div>
                <div class="col-md-4">
                    <label for="dateamr1" class="form-label">تاريخ الامر الجامعي</label>
                    <input type="date" class="form-control" id="dateamr1" name="dateamr1" value="{{ old('dateamr1', $applicant->admin_order_date) }}">
                </div>
                <div class="col-md-4">
                    <label for="txtcount1" class="form-label">الدولة المانحة للشهادة</label>
                    <input type="text" class="form-control" id="txtcount1" name="txtcount1" value="{{ old('txtcount1', $applicant->degree_country) }}" required>
                </div>
            </div>
        </div>

        <!-- القسم الرابع: معلومات الشهادة المطلوبة -->
        <div class="form-section">
            <div class="section-header">معلومات الشهادة المطلوبة</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="DropDownListplceA1" class="form-label">الدرجة العلمية</label>
                    <select id="DropDownListplceA1" name="DropDownListplceA1" class="form-select" required>
                        <option value="">اختر الدرجة العلمية المطلوبة</option>
                        @foreach ($degreess as $degree)
                            <option value="{{ $degree->id }}" {{ old('DropDownListplceA1', $applicant->requested_degree_id) == $degree->id ? 'selected' : '' }}>
                                {{ $degree->name_degree}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="FirstDropdown1" class="form-label">قناة التقديم</label>
                    <select id="FirstDropdown1" name="FirstDropdown1" class="form-select" required>
                        <option value="">اختر قناة التقديم</option>
                        @foreach ($chanels as $chanel)
                            <option value="{{ $chanel->id }}" {{ old('FirstDropdown1', $applicant->channel_id) == $chanel->id ? 'selected' : '' }}>
                                {{ $chanel->name_chanel}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="SecondDropdown1" class="form-label">الاختصاص</label>
                    <select id="SecondDropdown1" name="SecondDropdown1" class="form-select" required>
                        <option value="">اختر الاختصاص</option>
                        @foreach ($spcifics as $spcific)
                            <option value="{{ $spcific->id }}" {{ old('SecondDropdown1', $applicant->requested_specialization) == $spcific->id ? 'selected' : '' }}>
                                {{ $spcific->name_spcific}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="txtcolgeQ1" class="form-label">اسم الجامعة</label>
                    <input type="text" class="form-control" id="txtcolgeQ1" name="txtcolgeQ1" value="{{ old('txtcolgeQ1', $applicant->requested_university) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="txtcolgeQ21" class="form-label">اسم الكلية</label>
                    <input type="text" class="form-control" id="txtcolgeQ21" name="txtcolgeQ21" value="{{ old('txtcolgeQ21', $applicant->requested_college) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="DropDownListTA1" class="form-label">السنة الدراسية</label>
                    <input type="text" class="form-control" id="DropDownListTA1" name="DropDownListTA1" value="{{ old('DropDownListTA1', $applicant->academic_year) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="datemoda1" class="form-label">مدة الاجازة</label>
                    <select id="datemoda1" name="datemoda1" class="form-select" required>
                        <option value="">اختر مدة الاجازة</option>
                        @foreach ($ejazas as $ejaza)
                            <option value="{{ $ejaza->id }}" {{ old('datemoda1', $applicant->ejaza_id) == $ejaza->id ? 'selected' : '' }}>
                                {{ $ejaza->name_ejaza}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="txtplceQ1" class="form-label">بلد الدراسة</label>
                    <input type="text" class="form-control" id="txtplceQ1" name="txtplceQ1" value="{{ old('txtplceQ1', $applicant->study_country) }}" required>
                </div>

                <div class="col-md-12">
                    <label for="notes" class="form-label">الملاحظات</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $applicant->notes) }}</textarea>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg">حفظ التغييرات</button>
            <a href="{{ route('applicants.index') }}" class="btn btn-secondary btn-lg ms-2">إلغاء</a>
        </div>

        <!-- Warning placeholder shown when client validation fails -->
        <div id="form-warning" class="alert alert-danger mt-3 d-none" role="alert">
            يرجى إدخال كافة الحقول المطلوبة قبل الحفظ.
        </div>
    </form>
</div>

<style>
    body {
        background: #f7f9fc;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        padding: 30px;
        direction: rtl;
        text-align: right;
    }
    .section-header {
        background-color: #0d6efd;
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: 600;
        text-align: center;
    }
    .form-section {
        background: white;
        padding: 20px 25px;
        border-radius: 10px;
        direction: rtl;
        text-align: right;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const form = document.getElementById('qrForm');
    const warning = document.getElementById('form-warning');

    // list of required field names in the form
    const requiredNames = [
        'DropDownListrank1','DropDownListgender1','txtname11','txtname22','txtname33','txtname44','txtnameff','txtempcod1','txtbirth1','txtnumberphone1','txem1','txtsts1','datebirth1','txtage1','txtgen1','txtdir1','khoyear1','khyear1','txtnamecolge1','txtunverQ1','DropDgr1','DropDownListT1','DropDownavg1','datedgr1','txtcount1','DropDownListplceA1','FirstDropdown1','SecondDropdown1','txtcolgeQ1','txtcolgeQ21','DropDownListTA1','datemoda1','txtplceQ1'
    ];

    function validateForm(){
        let valid = true;
        requiredNames.forEach(name => {
            const el = form.querySelector('[name="'+name+'"]');
            if (!el) return; // if element not present, ignore

            let filled = true;
            if (el.type === 'checkbox') {
                filled = el.checked;
            } else {
                filled = el.value.trim() !== '';
            }
            if (!filled) {
                valid = false;
                el.classList.add('is-invalid');
            } else {
                el.classList.remove('is-invalid');
            }
        });
        if (!valid) {
            warning.classList.remove('d-none');
        } else {
            warning.classList.add('d-none');
        }
        return valid;
    }

    form.addEventListener('submit', function(e){
        if (!validateForm()) {
            e.preventDefault();
        }
    });

    // check duplicate statistical number
    document.querySelector('[name="txtempcod1"]').addEventListener('blur', function(){
        const stat = this.value.trim();
        if (stat) {
            fetch('/form/check-stat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({txtempcod1: stat, id: {{ $applicant->id }}})
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    alert('الرقم الاحصائي مكرر للمتقدم: ' + data.name);
                }
            });
        }
    });
});
</script>
@endsection
