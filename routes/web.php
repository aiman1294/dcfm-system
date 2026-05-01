<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaseFileController;
use App\Http\Controllers\AdminController;

Route::get('/admin/role-requests', [AdminController::class, 'index']);
Route::post('/admin/approve/{id}', [AdminController::class, 'approve']);
Route::post('/admin/reject/{id}', [AdminController::class, 'reject']);

Route::get('/cases/create', [CaseFileController::class, 'create']);
Route::post('/cases', [CaseFileController::class, 'store']);
Route::get('/cases', [CaseFileController::class, 'index'])->name('cases');

Route::get('/cases/{id}/edit', [CaseFileController::class, 'edit']);
Route::put('/cases/{id}', [CaseFileController::class, 'update']);
Route::delete('/cases/{id}', [CaseFileController::class, 'destroy']);
Route::get('/cases/{id}', [CaseFileController::class, 'show']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function(){
    return view('home');
});




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
