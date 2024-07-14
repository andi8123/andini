<?php

use App\Http\Controllers\Admin\Catin\VerifikasiCatinController;
use App\Http\Controllers\Admin\Catin\CatinController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'catin', 'as' => 'catin.'], function () {
    Route::resource('catin', CatinController::class)->names('catin')->except('create', 'store', 'edit', 'update', 'destroy');
    Route::resource('verifikasi-catin', VerifikasiCatinController::class)->names('verifikasi-catin')->except('create', 'store', 'destroy');
    Route::get('persyaratan-catin/{catin}', [VerifikasiCatinController::class, 'persyaratanCatin'])->name('persyaratan-catin');
    Route::post('/verfikasi-dispensasi/store/{dispensasi}', [VerifikasiCatinController::class, 'verify'])->name('verifikasi-dispensasi.store');
    Route::post('/verfikasi-dispensasi/reset/{dispensasi}', [VerifikasiCatinController::class, 'reset'])->name('verifikasi-dispensasi.reset');
    Route::post('/generate-dispensasi/{dispensasi}', [VerifikasiCatinController::class, 'generate'])->name('generate-dispensasi');
    Route::get('verifikasi-dispensasi/{dispensasi}/cetak-asesmen', [VerifikasiCatinController::class, 'cetakAsesmen'])->name('cetak-asesmen');
    Route::get('/download-surat-dispensasi/{id}', [VerifikasiCatinController::class, 'downloadDispensasi'])->name('download-surat-dispensasi');
});

Route::resource('/pengajuan-dispensasi', \App\Http\Controllers\Catin\PengajuanDispensasiController::class)->names('pengajuan-dispensasi')->except('show');
//Route::get('/pengajuan-dispensasi/{pengajuan_dispensasi}/print', [\App\Http\Controllers\Catin\PengajuanDispensasiController::class, 'print'])->name('pengajuan-dispensasi.print');
Route::get('/pengajuan-dispensasi/{pengajuan_dispensasi}/download', [\App\Http\Controllers\Catin\PengajuanDispensasiController::class, 'download'])->name('pengajuan-dispensasi.download');
Route::resource('/berkas-persyaratan', \App\Http\Controllers\Catin\BerkasPersyaratanController::class)->names('berkas-persyaratan')->except(['show', 'create', 'store', 'destroy', 'update']);
Route::get('/berkas-persyaratan/detail/{catin}', [\App\Http\Controllers\Catin\BerkasPersyaratanController::class, 'detail'])->name('berkas-persyaratan.detail');
Route::put('/berkas-persyaratan/detail/upload/{id?}', [\App\Http\Controllers\Catin\BerkasPersyaratanController::class, 'upload'])->name('berkas-persyaratan.upload');
Route::get('/berkas-persyaratan/detail/{persyaratan}/edit', [\App\Http\Controllers\Catin\BerkasPersyaratanController::class, 'edit_detail'])->name('berkas-persyaratan.edit_detail');
Route::post('/berkas-persyaratan/submit/{dispensasi}', [\App\Http\Controllers\Catin\BerkasPersyaratanController::class, 'submit'])->name('berkas-persyaratan.submit');
Route::get('/jadwal-asesmen', [\App\Http\Controllers\Catin\JadwalAsesmenController::class, 'index'])->name('jadwal-assesmen.index');
Route::get('jadwal-asesmen/print/{jadwalasesmen}/surat-dispensasi-nikah', [\App\Http\Controllers\Catin\JadwalAsesmenController::class, 'printSuratDispensasiNikah'])
    ->name('jadwal-asesmen.print.surat-dispensasi-nikah');
//Route::group(['prefix' => 'registrasi-catin', 'as' => 'registrasi-catin.'], function () {
//    Route::get('/', [\App\Http\Controllers\Catin\PengajuanDispensasiController::class, "index"])->name('index');
//});
