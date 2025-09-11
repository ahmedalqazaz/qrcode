<table class="table table-striped">
    <thead>
        <tr>
            <th><input type="checkbox" id="selectAll"></th>
            <th>التسلسل</th>
            <th>الرتبة</th>
             <th>الاسم</th>
            <th>الوكالة</th>
            <th>الشهادة الحاصل عليها</th>
            <th>الاختصاص</th>
            <th>الدرجة العلمية المطلوبة</th>
            <th>الاختصاص المطلوب</th>
            <th>قناة التقديم</th>
            <th>
                <a href="?sort={{ request('sort') === 'average_asc' ? 'average_desc' : 'average_asc' }}{{ request()->except('sort') ? '&' . http_build_query(request()->except('sort')) : '' }}" style="text-decoration: none; color: inherit;">
                    المعدل
                    @if(request('sort') === 'average_asc')
                        ↑
                    @elseif(request('sort') === 'average_desc')
                        ↓
                    @endif
                </a>
            </th>
            <th>محفوظ</th>
            <th>ذوي الشهداء</th>
            <th>الملاحظات</th>
            <th>اجراءات</th>
        </tr>
    </thead>
    <tbody>
        @foreach($applicants as $index => $app)
            <tr>
                <td class="arabic-numbers" ><input type="checkbox" class="rowCheckbox" value="{{ $app->id }}"></td>
                <td>{{ ($applicants->currentPage() - 1) * $applicants->perPage() + $loop->iteration }}</td>
                <td>{{ $app->rank?->name_rank }}</td>
                <td>{{ $app->first_name }} {{ $app->second_name }} {{ $app->last_name }}</td>
                <td>{{ $app->agency?->age_name }}</td>
                <td>{{ $app->degree?->name_degree }}</td>
                <td>{{ $app->specialization }}</td>
                <td>{{ $app->requestedDegree?->name_degree }}</td>
                <td>{{ $app->requestedSpecialization?->name_spcific }}</td>
                <td>{{ $app->channel?->name_chanel }}</td>
                <td class="arabic-numbers">{{ $app->average }}</td>
                <td class="arabic-numbers">{{ $app->created_at->format('Y-m-d') }}</td>
                <td>{{ $app->is_martyr_relative}}</td>
                <td>{{ $app->notes }}</td>
                <td>
                    <div style="display: flex; gap: 5px; justify-content: center;">
                        <a href="{{ route('applicants.edit', $app) }}"
                           style="background: #007bff; color: white; padding: 8px 12px; border-radius: 4px; text-decoration: none; font-size: 12px;"
                           title="تعديل">تعديل</a>

                        <a href="{{ route('applicants.exportPdf', $app) }}"
                           style="background: #dc3545; color: white; padding: 8px 12px; border-radius: 4px; text-decoration: none; font-size: 12px;"
                           target="_blank" title="تصدير PDF">PDF</a>

                        <form method="POST" action="{{ route('applicants.destroy', $app) }}" style="display: inline;" onsubmit="return confirm('هل تريد الحذف؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    style="background: #6c757d; color: white; padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;"
                                    title="حذف">حذف</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-between align-items-center">
        <div>
            <button id="bulkDeleteBtn" class="btn btn-danger btn-sm">حذف المحدد</button>
            <a id="exportBtn" class="btn btn-secondary btn-sm ms-2" href="#">تصدير CSV</a>
            <a id="exportPdfBtn" class="btn btn-outline-secondary btn-sm ms-2" href="#">تصدير PDF</a>
            <a id="exportWordBtn" class="btn btn-info btn-sm ms-2" href="#">تصدير Word</a>
        </div>
        <div>
            {{ $applicants->withQueryString()->links() }}
    </div>
</div>

<script>
    (function(){
        const exportBtn = document.getElementById('exportBtn');
        const exportPdfBtn = document.getElementById('exportPdfBtn');
        const exportWordBtn = document.getElementById('exportWordBtn');
        if(exportBtn){
            const base = '{{ route("applicants.export") }}';
            exportBtn.href = base + window.location.search;
        }
        if(exportPdfBtn){
            const basePdf = '{{ route("applicants.pdfPreview") }}';
            exportPdfBtn.href = basePdf + window.location.search;
            exportPdfBtn.addEventListener('click', function(e){
                // allow navigation to PDF preview
            });
        }
        if(exportWordBtn){
            const baseWord = '{{ route("applicants.exportWord") }}';
            exportWordBtn.href = baseWord + window.location.search;
            exportWordBtn.addEventListener('click', function(e){
                // allow navigation to Word download
            });
        }

        // ensure select all toggles checkboxes correctly
        document.getElementById('selectAll')?.addEventListener('change', function(e){
            document.querySelectorAll('.rowCheckbox').forEach(cb => cb.checked = e.target.checked);
        });

        // single bulk delete handler (uses checkboxes with class .rowCheckbox)
        document.getElementById('bulkDeleteBtn')?.addEventListener('click', function(){
            const ids = Array.from(document.querySelectorAll('.rowCheckbox:checked')).map(cb => cb.value);
            if (!ids.length) { alert('لم يتم اختيار سجلات'); return; }
            if (!confirm('تأكيد حذف ' + ids.length + ' سجل؟')) return;
            fetch('{{ route("applicants.bulkDelete") }}', {
                method: 'POST',
                headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ ids })
            }).then(()=>{
                // trigger central refresh handled by index view
                const evt = new Event('refreshResults');
                document.getElementById('filtersForm').dispatchEvent(evt);
            });
        });

        // Fix for checkbox visibility in RTL and Bootstrap 5
        document.querySelectorAll('input[type="checkbox"]').forEach(cb => {
            cb.style.width = '16px';
            cb.style.height = '16px';
            cb.style.margin = '0 auto';
            cb.style.display = 'inline-block';
            cb.style.verticalAlign = 'middle';
        });
    })();
</script>
