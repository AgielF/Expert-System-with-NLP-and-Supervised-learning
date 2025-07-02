<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DiagnoseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Landing Page
Route::view('/', 'landing')->name('landing');

// 📝 Form Page
Route::view('/form', 'form', ['title' => 'Form'])->name('form');

// 🔍 Diagnose Static Page
Route::view('/diagnose', 'diagnose', ['title' => 'Diagnosa'])->name('diagnose');

// 📦 Auth Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register')->name('register.post');
    Route::post('/logout', 'logout')->name('logout');
});

// 💉 Diagnose Routes
Route::controller(DiagnoseController::class)->group(function () {
    Route::post('/diagnose/proses', 'proses')->name('diagnose.proses');
    Route::post('/chatbot-diagnose', 'parseInputToData')->name('chatbot.diagnose');
    Route::get('/hasil/export', 'exportPDF')->name('hasil.export');
    
    Route::middleware('auth')->group(function () {
        Route::get('/riwayat-diagnosa', 'riwayat')->name('diagnosa.riwayat');
    });
});
// Chatbot Page (requires auth)
Route::middleware('auth')->group(function () {
    Route::get('/chatbot', fn() => view('chatbot'))->name('chatbot');
    Route::post('/chatbot', [DiagnoseController::class, 'process_chatbot'])->name('chatbot.process_chatbot');
    
    
    
    });
Route::post('/submitBinaryQuestions', [DiagnoseController::class, 'handleBinaryInput']);
