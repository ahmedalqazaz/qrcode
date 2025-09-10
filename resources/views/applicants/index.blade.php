<!DOCTYPE html>
 <html lang="ar" dir="rtl">
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>قائمة المتقدمين</h2>

    <form id="filtersForm" method="GET" action="{{ route('applicants.index') }}" class="mb-3">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="ابحث بالاسم أو الرقم الاحصائي">
            </div>
            <div class="col-md-3">
                <select name="FirstDropdown1" class="form-select">
                    <option value="">كل القنوات</option>
                    @foreach($channels as $ch)
                        <option value="{{ $ch->id }}" {{ request('FirstDropdown1') == $ch->id ? 'selected' : '' }}>{{ $ch->name_chanel }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="DropDownListplceA1" class="form-select">
                    <option value="">كل الدرجات المطلوبة</option>
                    @foreach($degrees as $d)
                        <option value="{{ $d->id }}" {{ request('DropDownListplceA1') == $d->id ? 'selected' : '' }}>{{ $d->name_degree }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="SecondDropdown1" class="form-select">
                    <option value="">كل الاختصاصات</option>
                    @foreach($specializations as $spec)
                        <option value="{{ $spec->id }}" {{ request('SecondDropdown1') == $spec->id ? 'selected' : '' }}>{{ $spec->name_spcific }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_martyr_relative" name="is_martyr_relative" value="1" {{ request('is_martyr_relative') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_martyr_relative">
                        من ذوي الشهداء
                    </label>
                </div>
            </div>
        </div>
            <div class="mt-2">
                <button id="filterBtn" class="btn btn-outline-secondary" type="submit">بحث</button>
                <span class="ms-3">عدد النتائج: <strong id="resultsCount">{{ $total ?? $applicants->total() }}</strong></span>
            </div>
    </form>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div id="resultsArea">
        @include('applicants._table')
    </div>

    <div class="mt-3">
        <a href="{{ route('applicants.exportComparisonForm', request()->query()) }}" class="btn btn-outline-success ms-2">استمارة المفاضلة (Word)</a>
    </div>
@endsection
