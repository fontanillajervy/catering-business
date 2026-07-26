<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/services', [PublicController::class, 'services'])->name('services');
Route::get('/packages', [PublicController::class, 'packages'])->name('packages');
Route::get('/packages/{package:slug}', [PublicController::class, 'packageShow'])->name('packages.show');
Route::get('/gallery', [PublicController::class, 'gallery'])->name('gallery');
Route::get('/reservation', [PublicController::class, 'reservation'])->name('reservation');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
Route::get('/inquiry', [PublicController::class, 'inquiry'])->name('inquiry');
Route::post('/inquiry', [InquiryController::class, 'store'])->name('inquiry.store');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');

Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware(['ensure.admin', 'capture.activity'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/reservations', [AdminController::class, 'reservations'])->name('admin.reservations');
    Route::get('/inquiries', [AdminController::class, 'inquiries'])->name('admin.inquiries');
    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');
    Route::get('/reports/export/{type}', [ReportController::class, 'export'])->name('admin.reports.export');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('admin.activity-logs');
    Route::get('/backups', [BackupController::class, 'index'])->name('admin.backups');
    Route::post('/backups/create', [BackupController::class, 'createBackup'])->name('admin.backups.create');
    Route::post('/backups/restore', [BackupController::class, 'restoreBackup'])->name('admin.backups.restore');
});
