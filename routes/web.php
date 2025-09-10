<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Wordexport;
use App\Http\Middleware\AuthCheckMiddleware;

// تطبيق وسيط التحقق من المصادقة على جميع المسارات
Route::middleware([AuthCheckMiddleware::class])->group(function () {
    Route::get('/', function () {
        return redirect()->route('login'); // Redirect to the login page
    });
    Route::get('/form', [DataController::class, 'create'])->name('form.create');
    Route::post('/form', [DataController::class, 'store'])->name('form.store');
    Route::post('/form/parse', [DataController::class, 'parse'])->name('form.parse');
    // AJAX check for duplicate statistical number
    Route::post('/form/check-stat', [DataController::class, 'checkStatisticalNumber'])->name('form.checkStat');
    Route::get('/qrcode', [DataController::class, 'showForm'])->name('qrcode.show');

    // New route to get seat_count
    Route::post('/get-seat-count', [DataController::class, 'getSeatCount'])->name('getSeatCount');

    Route::get('/dashboard', function(){ return view('dashboard'); })->name('dashboard');

    // Profile routes
    Route::group(['middleware' => ['auth']], function() {
        Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
        Route::post('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/password', [\App\Http\Controllers\ProfileController::class, 'showPassword'])->name('profile.password.show');
        Route::post('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');
    });
    // Applicants management (admin-only)
    Route::get('/applicants', [DataController::class, 'index'])
        ->name('applicants.index');

    Route::get('/applicants/{applicant}/edit', [DataController::class, 'edit'])
        ->name('applicants.edit');

    Route::put('/applicants/{applicant}', [DataController::class, 'update'])
        ->name('applicants.update');

    Route::delete('/applicants/{applicant}', [DataController::class, 'destroy'])
        ->name('applicants.destroy');

    Route::post('/applicants/bulk-delete', [DataController::class, 'bulkDelete'])
        ->name('applicants.bulkDelete');

    Route::get('/applicants/export', [DataController::class, 'export'])
        ->name('applicants.export');

    Route::get('/applicants/pdf-preview', [DataController::class, 'pdfPreview'])
        ->name('applicants.pdfPreview');

    Route::get('/applicants/export-word', [DataController::class, 'exportWord'])
        ->name('applicants.exportWord');

    Route::get('/applicants/{applicant}/export-pdf', [DataController::class, 'exportPdf'])
        ->name('applicants.exportPdf');

    Route::get('/applicants/export-comparison-form-preview', [Wordexport::class, 'exportComparisonFormPreview'])
        ->name('applicants.exportComparisonFormPreview');

    Route::get('/applicants/export-comparison-form', [Wordexport::class, 'exportComparisonForm'])
        ->name('applicants.exportComparisonForm');

    // Admin: user management (admin-only)
    Route::get('/admin/users', [UserController::class, 'index'])
        ->name('admin.users.index');

    Route::post('/admin/users/{user}/role', [UserController::class, 'updateRole'])
        ->name('admin.users.updateRole');

    // Auth routes - خارج مجموعة الوسيط لتكون متاحة للجميع
    Route::get('/register', [\App\Http\Controllers\AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

});
