<!DOCTYPE html>
 <html lang="ar" dir="rtl">
@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width:720px;margin:auto;">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">تغيير كلمة المرور</h4>
            <form method="POST" action="{{ route('profile.password.update') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">كلمة المرور الحالية</label>
                    <input name="current_password" type="password" class="form-control" required>
                    @error('current_password') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">كلمة المرور الجديدة</label>
                    <input name="password" type="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">تأكيد كلمة المرور الجديدة</label>
                    <input name="password_confirmation" type="password" class="form-control" required>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary">تحديث كلمة المرور</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
