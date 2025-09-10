<!DOCTYPE html>
 <html lang="ar" dir="rtl">
@extends('layouts.app')

@section('content')
<style>
    .hero {
        min-height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f5f7ff 0%, #eef6ff 100%);
        border-radius: 12px;
        padding: 40px 20px;
        box-shadow: 0 6px 30px rgba(13,110,253,0.06);
    }
    .login-card {
        max-width: 520px;
        width: 100%;
        background: #fff;
        border-radius: 12px;
        padding: 26px;
        box-shadow: 0 10px 30px rgba(2,6,23,0.06);
    }
    .app-stat { background: linear-gradient(90deg,#0d6efd22,#6f42c122); border-radius:10px; padding:18px; }
    .stat-number { font-size: 28px; font-weight:700; }
    .stat-label { color:#666; }
</style>

@auth
    <div class="container mt-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0">لوحة التحكم</h2>
                <small class="text-muted">مرحبًا، {{ auth()->user()->name }}</small>
            </div>
            <div>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">إدارة المستخدمين</a>
                @endif
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="app-stat p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number">{{ \App\Models\Applicant::count() }}</div>
                            <div class="stat-label">إجمالي المتقدمين</div>
                        </div>
                        <div class="fs-2">📋</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="app-stat p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number">{{ \App\Models\User::count() }}</div>
                            <div class="stat-label">إجمالي المستخدمين</div>
                        </div>
                        <div class="fs-2">👥</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="app-stat p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-number">{{ \App\Models\Degree::count() }}</div>
                            <div class="stat-label">الدرجات المعرفة</div>
                        </div>
                        <div class="fs-2">🎓</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">روابط سريعة</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('form.create') }}" class="btn btn-outline-primary">نموذج إدخال</a>
                        <a href="{{ route('applicants.index') }}" class="btn btn-primary">قائمة المتقدمين</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endguest

@endsection
