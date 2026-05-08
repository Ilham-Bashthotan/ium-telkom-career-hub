<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\HomeController as UserHomeController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\LowonganController as UserLowonganController;
use App\Http\Controllers\User\PerusahaanController as UserPerusahaanController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LowonganController as AdminLowonganController;
use App\Http\Controllers\Admin\PerusahaanController as AdminPerusahaanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PPDBController;
use App\Http\Controllers\Admin\CrawlController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Routes (Alumni / Umum) - Public Access
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/lowongan', [UserLowonganController::class, 'index'])->name('lowongan.index');
    Route::get('/mitra', [UserPerusahaanController::class, 'index'])->name('mitra.index');
});

// User Routes (Alumni / Umum) - Require Authentication
Route::prefix('user')->name('user.')->middleware('auth')->group(function () {
    Route::get('/home', [UserHomeController::class, 'index'])->name('home');
    Route::get('/profil', [ProfileController::class, 'index'])->name('profil.index');
    Route::post('/profil', [ProfileController::class, 'update'])->name('profil.update');
    
    Route::get('/lowongan/{id}', [UserLowonganController::class, 'show'])->name('lowongan.show');
    Route::get('/mitra/{id}', [UserPerusahaanController::class, 'show'])->name('mitra.show');
});

// Admin Auth Routes
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('lowongan', AdminLowonganController::class);
    Route::resource('mitra', AdminPerusahaanController::class);
    Route::resource('users', UserController::class);
    Route::resource('ppdb', PPDBController::class);
    
    Route::get('/crawl', [CrawlController::class, 'index'])->name('crawl.index');
    Route::post('/crawl/process', [CrawlController::class, 'process'])->name('crawl.process');
    Route::post('/crawl/{id}/approve', [CrawlController::class, 'approve'])->name('crawl.approve');
});
