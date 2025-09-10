<form method="POST" action="{{ route('form.create') }}">
    @csrf

    <label>البيانات (مفصولة بـ |):</label>
    <input type="text" name="all_data" value="{{ old('all_data') }}">
    <br><br>

    <label>الاسم الأول:</label>
    <input type="text" name="first_name" value="{{ old('first_name') }}">
    <br><br>

    <label>الاسم الثاني:</label>
    <input type="text" name="last_name" value="{{ old('last_name') }}">
    <br><br>

    <label>العمر:</label>
    <input type="text" name="age" value="{{ old('age') }}">
    <br><br>

    <label>المدينة:</label>
    <input type="text" name="city" value="{{ old('city') }}">
    <br><br>

    <button type="submit">حفظ</button>
</form>
