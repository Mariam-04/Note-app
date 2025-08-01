<?php
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Http\Request;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\LogoutController;
use App\Http\AuthRequest;
use App\Http\Controllers\FileUploadController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/signup', [AuthController::class, 'signup']);
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');


Route::get('/forgot-password', function () {
    return view('auth.reset-request');
})->name('password.request');

Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'resetPassword'])
    ->name('password.update');


Route::middleware(['auth'])->group(function () {
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::get('/notes/{note}/edit', [NoteController::class, 'edit'])->name('notes.edit');
    Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
    Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create');
    Route::get('notes/search-notes', [NoteController::class, 'searchNotes'])->name('notes.search');
});



Route::get('/file', [FileUploadController::class, 'showForm'])->name('file.upload');
Route::post('/file/upload', [FileUploadController::class, 'upload'])->name('file.upload.submit');

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
