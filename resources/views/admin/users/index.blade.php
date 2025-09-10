<!DOCTYPE html>
 <html lang="ar" dir="rtl">
@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">إدارة المستخدمين</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>البريد</th>
                <th>الصلاحية</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role ?? 'user' }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.users.updateRole', $user) }}" class="d-inline">
                        @csrf
                        <select name="role" class="form-select d-inline w-auto">
                            <option value="user" {{ ($user->role ?? 'user') == 'user' ? 'selected' : '' }}>user</option>
                            <option value="admin" {{ ($user->role ?? 'user') == 'admin' ? 'selected' : '' }}>admin</option>
                        </select>
                        <button class="btn btn-sm btn-primary">تحديث</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
</div>
@endsection
