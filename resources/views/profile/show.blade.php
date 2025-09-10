<!DOCTYPE html>
 <html lang="ar" dir="rtl">
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card" style="max-width:720px;margin:auto;">
        <div class="card-body">
            <h4 class="card-title">الملف الشخصي</h4>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">الاسم</label>
                    <input name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="d-flex justify-content-between">
                        <a class="btn btn-outline-secondary me-2" href="{{ route('profile.password.show') }}">تغيير كلمة المرور</a>
                        <button type="submit" class="btn btn-success">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
