<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::post('admin/login', [AuthAdminController::class, 'login'])->name('login');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('admin', [HomeAdminController::class, 'index']);
    Route::get('admin/home', [HomeAdminController::class, 'index'])->name('home_admin');
    Route::get('admin/logout', [AuthAdminController::class, 'logout'])->name('logout_admin');
    Route::resource('admin/relasi', RelasiController::class); 
    Route::resource('admin/account', AccountController::class); 
    Route::resource('admin/nourut', NoUrutController::class); 
    Route::get('admin/ambil_nourut/{kode}', [NoUrutController::class, 'ambil_nourut']);

    Route::resource('admin/sawal', SaldoAwalController::class);   
    Route::resource('admin/user', UserController::class);
    Route::resource('admin/kasm', KasMasukController::class); 
    Route::resource('admin/kask', KasKeluarController::class); 
    Route::resource('admin/bankm', BankMasukController::class); 
    Route::resource('admin/bankk', BankKeluarController::class); 
    Route::resource('admin/jurum', JurumController::class); 
     
	Route::get('admin/edit_kasmd/{id}', [KasMasukController::class, 'edit_detail']);
    Route::post('admin/simpan_kasmd', [KasMasukController::class, 'simpan_detail']);
    Route::post('admin/update_kasmd/{id}', [KasMasukController::class, 'update_detail']);
    Route::delete('admin/hapus_kasmd/{id}', [KasMasukController::class, 'hapus_detail']);
    Route::get('admin/tampilkan_kasmd/{bukti}', [KasMasukController::class, 'tampilkan_detail']);    

    Route::get('admin/edit_kaskd/{id}', [KasKeluarController::class, 'edit_detail']);
    Route::post('admin/simpan_kaskd', [KasKeluarController::class, 'simpan_detail']);
    Route::post('admin/update_kaskd/{id}', [KasKeluarController::class, 'update_detail']);
    Route::delete('admin/hapus_kaskd/{id}', [KasKeluarController::class, 'hapus_detail']);
    Route::get('admin/tampilkan_kaskd/{bukti}', [KasKeluarController::class, 'tampilkan_detail']);

    Route::get('admin/edit_bankmd/{id}', [BankMasukController::class, 'edit_detail']);
    Route::post('admin/simpan_bankmd', [BankMasukController::class, 'simpan_detail']);
    Route::post('admin/update_bankmd/{id}', [BankMasukController::class, 'update_detail']);
    Route::delete('admin/hapus_bankmd/{id}', [BankMasukController::class, 'hapus_detail']);
    Route::get('admin/tampilkan_bankmd/{bukti}', [BankMasukController::class, 'tampilkan_detail']);  

    Route::get('admin/edit_bankkd/{id}', [BankKeluarController::class, 'edit_detail']);
    Route::post('admin/simpan_bankkd', [BankKeluarController::class, 'simpan_detail']);
    Route::post('admin/update_bankkd/{id}', [BankKeluarController::class, 'update_detail']);
    Route::delete('admin/hapus_bankkd/{id}', [BankKeluarController::class, 'hapus_detail']);
    Route::get('admin/tampilkan_bankkd/{bukti}', [BankKeluarController::class, 'tampilkan_detail']);

    Route::get('admin/edit_jurumd/{id}', [JurumController::class, 'edit_detail']);
    Route::post('admin/simpan_jurumd', [JurumController::class, 'simpan_detail']);
    Route::post('admin/update_jurumd/{id}', [JurumController::class, 'update_detail']);
    Route::delete('admin/hapus_jurumd/{id}', [JurumController::class, 'hapus_detail']);
    Route::get('admin/tampilkan_jurumd/{bukti}', [JurumController::class, 'tampilkan_detail']);
	
    Route::get('admin/lap_kas_harian', [LapKasHarianController::class, 'index']);
    Route::post('admin/cetak_lap_kas_harian', [LapKasHarianController::class, 'cetak']);
    Route::get('admin/lap_bank_harian', [LapBankHarianController::class, 'index']);
    Route::post('admin/cetak_lap_bank_harian', [LapBankHarianController::class, 'cetak']);
    Route::get('admin/lap_buku_besar', [LapBukuBesarController::class, 'index']);
    Route::post('admin/cetak_buku_besar', [LapBukuBesarController::class, 'cetak']);
    Route::get('admin/lap_rekap_buku_besar', [LapRekapBukuBesarController::class, 'index']);
    Route::post('admin/cetak_rekap_buku_besar', [LapRekapBukuBesarController::class, 'cetak']);
  });