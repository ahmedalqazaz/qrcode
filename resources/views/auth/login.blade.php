<!DOCTYPE html>
 <html lang="ar" dir="rtl">
@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height:70vh;">
    <div class="card p-4" style="max-width:520px; width:100%; border-radius:12px; box-shadow:0 10px 30px rgba(2,6,23,0.06);">
        <div class="text-center mb-3">
            <h3 class="mb-1">تسجيل الدخول</h3>
            <p class="text-muted">أدخل بياناتك للوصول إلى لوحة التحكم</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">كلمة المرور</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <a class="btn btn-outline-secondary" href="{{ route('register') }}">التسجيل كمستخدم جديد</a>
                </div>
                <div>
                    <button class="btn btn-primary">دخول</button>
                </div>
            </div>
            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
        </form>
    </div>
</div>
@endsection
