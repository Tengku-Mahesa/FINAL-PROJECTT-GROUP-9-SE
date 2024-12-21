<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\RMController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MainController::class, 'index'])->name('dashboard')->middleware('auth');

//Pasien
Route::get('/pasien', [PasienController::class, 'index'])->name('pasien')->middleware('auth');
Route::get('/pasien/tambah/', [PasienController::class, 'tambah_pasien'])->name('pasien.tambah')->middleware('auth');
Route::post('/pasien/tambah/simpan', [PasienController::class, 'simpan_pasien'])->name('pasien.simpan')->middleware('auth');
Route::post('/pasien/edit/update/', [PasienController::class, 'update_pasien'])->name('pasien.update')->middleware('auth');
Route::delete('/pasien/hapus/{id}', [PasienController::class, 'hapus_pasien'])->name('pasien.destroy')->middleware('auth');
Route::get('/pasien/edit/{id}', [PasienController::class, 'edit_pasien'])->name('pasien.edit')->middleware('auth');

//Obat
Route::get('/obat', [ObatController::class, 'index'])->name('obat')->middleware('auth');
Route::delete('/obat/hapus/{id}', [ObatController::class, 'hapus_obat'])->name('obat.destroy')->middleware('auth','staff');
Route::get('/obat/edit/{id}', [ObatController::class, 'edit_obat'])->name('obat.edit')->middleware('auth','staff');
Route::get('/obat/tambah/', [ObatController::class, 'tambah_obat'])->name('obat.tambah')->middleware('auth','staff');
Route::post('/obat/tambah/simpan', [ObatController::class, 'simpan_obat'])->name('obat.simpan')->middleware('auth','staff');
Route::post('/obat/edit/update/', [ObatController::class, 'update_obat'])->name('obat.update')->middleware('auth','staff');

//Lab
Route::get('/lab', [LabController::class, 'index'])->name('lab')->middleware('auth');
Route::delete('/lab/hapus/{id}', [LabController::class, 'hapus_lab'])->name('lab.destroy')->middleware('auth','staff');
Route::get('/lab/edit/{id}', [LabController::class, 'edit_lab'])->name('lab.edit')->middleware('auth','staff');
Route::get('/lab/tambah', [LabController::class, 'tambah_lab'])->name('lab.tambah')->middleware('auth','staff');
Route::post('/lab/tambah/simpan', [LabController::class, 'simpan_lab'])->name('lab.simpan')->middleware('auth','staff');
Route::post('/lab/edit/update/', [LabController::class, 'update_lab'])->name('lab.update')->middleware('auth','staff');

//RM
Route::get('/rm', [RMController::class, 'index'])->name('rm')->middleware('auth');
Route::delete('/rm/hapus/{id}', [RMController::class, 'hapus_rm'])->name('rm.destroy')->middleware('auth');
Route::get('/rm/edit/{id}', [RMController::class, 'edit_rm'])->name('rm.edit')->middleware('auth');
Route::get('/rm/tambah', [RMController::class, 'tambah_rm'])->name('rm.tambah')->middleware('auth');
Route::get('/rm/tambah/{idpasien}', [RMController::class, 'tambah_rmid'])->name('rm.tambah.id')->middleware('auth');
Route::post('/rm/simpan/', [RMController::class, 'simpan_rm'])->name('rm.simpan')->middleware('auth');
Route::post('/rm/update/', [RMController::class, 'update_rm'])->name('rm.update')->middleware('auth');
Route::get('/rm/list/{idpasien}', [RMController::class, 'list_rm'])->name('rm.list')->middleware('auth');
Route::get('/rm/lihat/{id}', [RMController::class, 'lihat_rm'])->name('rm.lihat')->middleware('auth');

//Tagihan
Route::get('/tagihan/{id}', [RMController::class, 'tagihan'])->name('tagihan')->middleware('auth');

//Pengaturan
Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan')->middleware('auth','admin');
Route::patch('/pengaturan/simpan', [PengaturanController::class, 'simpan'])->name('pengaturan.simpan')->middleware('auth','admin');

//Auth
Auth::routes([
    'register' => true,
    'verify' => false,
    'reset' => false
]);

//Profile
Route::get('users/profile', [ProfileController::class, 'index'])->name('profile.edit')->middleware('auth');
Route::get('users/profile/{id}', [ProfileController::class, 'edit'])->name('profile.edit.admin')->middleware('auth','admin');
Route::patch('users/profile/simpan', [ProfileController::class, 'simpan'])->name('profile.simpan')->middleware('auth');

//Users
Route::get('/users', [UserController::class, 'index'])->name('user')->middleware('auth','admin');
Route::delete('/users/delete/{id}', [UserController::class, 'hapus'])->name('user.destroy')->middleware('auth','admin');