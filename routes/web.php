<?php

use App\Http\Controllers\SclassController;
use App\Http\Controllers\SstudentController;
use App\Http\Controllers\SsubjectController;
use App\Http\Controllers\CstudentController;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth')->group(function () {
    Route::resource('sclass', SclassController::class);
    Route::resource('sstudent', SstudentController::class);
    Route::get('sstudent/{sstudent}/receipt', [SstudentController::class, 'printReceipt'])->name('sstudent.receipt');
    Route::get('sstudent-export', [SstudentController::class, 'export'])->name('sstudent.export');
    Route::post('sstudent/bulk-delete', [SstudentController::class, 'bulkDelete'])->name('sstudent.bulk-delete');
    Route::resource('ssubject', SsubjectController::class);
    Route::resource('cstudent', CstudentController::class);
    Route::get('cstudent/{cstudent}/receipt', [CstudentController::class, 'printReceipt'])->name('cstudent.receipt');
    Route::get('cstudent-export', [CstudentController::class, 'export'])->name('cstudent.export');
    Route::post('cstudent/bulk-delete', [CstudentController::class, 'bulkDelete'])->name('cstudent.bulk-delete');

    Route::view('/', 'index');
    Route::view('/analytics', 'analytics');
    Route::view('/finance', 'finance');
    Route::view('/crypto', 'crypto');
// });

Route::view('/auth/boxed-lockscreen', 'auth.boxed-lockscreen');
Route::view('/auth/boxed-signin', 'auth.boxed-signin');
Route::view('/auth/boxed-signup', 'auth.boxed-signup');
Route::view('/auth/boxed-password-reset', 'auth.boxed-password-reset');
Route::view('/auth/cover-login', 'auth.cover-login');
Route::view('/auth/cover-register', 'auth.cover-register');
Route::view('/auth/cover-lockscreen', 'auth.cover-lockscreen');
Route::view('/auth/cover-password-reset', 'auth.cover-password-reset');
