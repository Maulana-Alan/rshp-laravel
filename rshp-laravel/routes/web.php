<?php

use Illuminate\Support\Facades\Route;

// ==========================================================
// --- IMPORT SEMUA CONTROLLER ---
// ==========================================================

use App\Http\Controllers\PageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController; // <--- Controller Profile (Modul 13)

// (Admin Controllers)
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\JenisHewanController;
use App\Http\Controllers\Admin\PemilikController;
use App\Http\Controllers\Admin\RasHewanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\KategoriKlinisController;
use App\Http\Controllers\Admin\KodeTindakanTerapiController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PendaftaranController;

// (Role Controllers)
use App\Http\Controllers\Resepsionis\DashboardResepsionisController;
use App\Http\Controllers\Dokter\DashboardDokterController;
use App\Http\Controllers\Perawat\DashboardPerawatController;
use App\Http\Controllers\Pemilik\DashboardPemilikController;


// ==========================================================
// --- RUTE PUBLIK (BISA DIAKSES TANPA LOGIN) ---
// ==========================================================
Route::get('/', [PageController::class, 'showHome'])->name('home');
Route::get('/layanan', [PageController::class, 'showLayanan'])->name('layanan');
Route::get('/visimisi', [PageController::class, 'showVisiMisi'])->name('visimisi');
Route::get('/struktur', [PageController::class, 'showStruktur'])->name('struktur');
Route::get('/cek-koneksi', [PageController::class, 'cekKoneksi'])->name('site.cek-koneksi');

// --- AUTHENTICATION ROUTES (Login, Register, Reset Pass) ---
Auth::routes();


// ==========================================================
// --- RUTE GLOBAL (WAJIB LOGIN DULU) ---
// ==========================================================
Route::middleware(['auth'])->group(function () {
    
    // 1. Dashboard Redirect (Menentukan user dilempar ke mana)
    Route::get('/home', [HomeController::class, 'index'])->name('dashboard');

    // 2. FITUR PROFILE (MODUL 13)
    // Ditaruh disini supaya Dokter, Perawat, Admin semua bisa akses
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');     // Tampilkan Form
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Simpan Data
});


// ==========================================================
// --- GRUP RUTE SPESIFIK ROLE (DILINDUNGI MIDDLEWARE) ---
// ==========================================================

// --- 1. GRUP ADMIN (Hanya user dengan role Administrator) ---
Route::middleware(['isAdministrator'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');

    // --- DATA MASTER ---
    
    // Jenis Hewan
    Route::get('/jenis-hewan', [JenisHewanController::class, 'index'])->name('jenis-hewan.index');
    Route::get('/jenis-hewan/create', [JenisHewanController::class, 'create'])->name('jenis-hewan.create'); 
    Route::post('/jenis-hewan/store', [JenisHewanController::class, 'store'])->name('jenis-hewan.store');
    
    // Pemilik
    Route::get('/pemilik', [PemilikController::class, 'index'])->name('pemilik.index');
    Route::get('/pemilik/create', [PemilikController::class, 'create'])->name('pemilik.create'); 
    Route::post('/pemilik/store', [PemilikController::class, 'store'])->name('pemilik.store');  
    
    // Ras Hewan
    Route::get('/ras-hewan', [RasHewanController::class, 'index'])->name('ras-hewan.index');
    Route::get('/ras-hewan/create', [RasHewanController::class, 'create'])->name('ras-hewan.create');
    Route::post('/ras-hewan/store', [RasHewanController::class, 'store'])->name('ras-hewan.store');  
    
    // Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create'); 
    Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
    
    // Kategori Klinis
    Route::get('/kategori-klinis', [KategoriKlinisController::class, 'index'])->name('kategori-klinis.index');
    Route::get('/kategori-klinis/create', [KategoriKlinisController::class, 'create'])->name('kategori-klinis.create'); 
    Route::post('/kategori-klinis/store', [KategoriKlinisController::class, 'store'])->name('kategori-klinis.store');
    
    // Kode Tindakan
    Route::get('/kode-tindakan', [KodeTindakanTerapiController::class, 'index'])->name('kode-tindakan.index');
    Route::get('/kode-tindakan/create', [KodeTindakanTerapiController::class, 'create'])->name('kode-tindakan.create'); 
    Route::post('/kode-tindakan/store', [KodeTindakanTerapiController::class, 'store'])->name('kode-tindakan.store');
    
    // Pet (Hewan Peliharaan)
    Route::get('/pet', [PetController::class, 'index'])->name('pet.index');
    Route::get('/pet/create', [PetController::class, 'create'])->name('pet.create'); 
    Route::post('/pet/store', [PetController::class, 'store'])->name('pet.store');
    
    // Manajemen Role
    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create'); 
    Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');
    
    // Manajemen User
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create'); 
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    
    // Pendaftaran
    Route::get('/pendaftaran',[PendaftaranController::class, 'index'])->name('pendaftaran.index');

}); 

// --- 2. GRUP RESEPSIONIS ---
Route::middleware(['isResepsionis'])->prefix('resepsionis')->name('resepsionis.')->group(function () {
    Route::get('/dashboard', [DashboardResepsionisController::class, 'index'])->name('dashboard');
});

// --- 3. GRUP DOKTER ---
Route::middleware(['isDokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [DashboardDokterController::class, 'index'])->name('dashboard');
});

// --- 4. GRUP PERAWAT ---
Route::middleware(['isPerawat'])->prefix('perawat')->name('perawat.')->group(function () {
    Route::get('/dashboard', [DashboardPerawatController::class, 'index'])->name('dashboard');
});

// --- 5. GRUP PEMILIK ---
Route::middleware(['isPemilik'])->prefix('pemilik')->name('pemilik.')->group(function () {
    Route::get('/dashboard', [DashboardPemilikController::class, 'index'])->name('dashboard');
});