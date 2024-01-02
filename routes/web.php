<?php

use App\Http\Controllers\MedicineController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('IsGuest')->group(function(){
    Route::get('/', function () {return view('login');})->name('login');
    Route::post('/login', [UserController::class, 'authLogin'])->name('auth-login');
});


Route::middleware('IsLogin')->group(function() {
    Route::get('/logout', [UserController::class, 'logout'])->name('auth-logout');
    Route::get('/dashboard', function () {return view('dashboard');
    });
    
    Route::middleware('IsAdmin')->group(function() {
        route::prefix('/medicine')->name('medicine.')->group(function() {
            route::get('/data',[MedicineController::class, 'index'])->name('data');
            route::get('/create', [MedicineController::class, 'create'])->name('create');
            route::post('store', [MedicineController::class, 'store'])->name('store');
            // {} -> path dinamis/parameter path : untuk mengirim data identitas yang akan diambil datanya harus diisi ketika pemanggilan nama route
            route::get('/edit{id}', [MedicineController::class, 'edit'])->name('edit');
            route::patch('/update{id}', [MedicineController::class, 'update'])->name('update');
            route::delete('/delete/{id}', [MedicineController::class, 'destroy'])->name('delete');
            Route::get('/data/stock', [MedicineController::class, 'stockData'])->name('data.stock');
            Route::get('/{id}', [MedicineController::class, 'show'])->name('show');
            Route::patch('/stock/update/{id}', [MedicineController::class, 'updateStock'])->name('stock.update');
        });
        route::prefix('/user')->name('user.')->group(function() {
            Route::get('/data',[UserController::class, 'index'])->name('data');
            route::post('/store', [UserController::class, 'store'])->name('store');
            route::get('/create', [UserController::class, 'create'])->name('create');
            route::get('/edit{id}', [UserController::class, 'edit'])->name('edit');
            route::patch('/update{id}', [UserController::class, 'update'])->name('update');
            route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
        });
        Route::prefix('/admin/order')->name('admin.order.')->group(function() {
            Route::get('/', [OrderController::class, 'data'])->name('data');
            Route::get('/download-excel', [OrderController::class, 'downloadExcel'])->name('download-excel');
            Route::get('/searchAdmin', [OrderController::class, 'searchAdmin'])->name('searchAdmin');
        });
    });
    Route::middleware('IsKasir')->group(function() {
        Route::prefix('/order')->name('order.')->group(function() {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/create', [OrderController::class, 'create'])->name('create');
            Route::post('/store', [OrderController::class, 'store'])->name('store');
            Route::get('struk/{id}', [OrderController::class, 'strukPembelian'])->name('struk');
            Route::get('download-pdf/{id}', [OrderController::class, 'downloadPDF'])->name('download-pdf');
            Route::get('/search', [OrderController::class, 'search'])->name('search');
        });
    });
});


// prefix : awalan (mengelompokan url path sesuai dengan fiturnya)
// name prefix : awalan name route pada kelompok url path
// group : mengelompokan url path
// ::get ->menampilkan halaman, ::post ->menambah data ke db, ::patch -> mengubah data ke db,
// ::delete -> menghapus data ke db
// NamaController::class, 'namafunction'
