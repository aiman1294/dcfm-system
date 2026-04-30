<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaseFileController;

Route::get('/cases/create', [CaseFileController::class, 'create']);
Route::post('/cases', [CaseFileController::class, 'store']);
Route::get('/cases', [CaseFileController::class, 'index'])->name('cases');

Route::get('/cases/{id}/edit', [CaseFileController::class, 'edit']);
Route::put('/cases/{id}', [CaseFileController::class, 'update']);

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
