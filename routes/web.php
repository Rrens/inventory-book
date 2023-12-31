<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\DashboadController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'admin/dashboard');
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'post_login'])->name('post_login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth']
], function () {
    Route::get('dashboard', [DashboadController::class, 'index'])->name('admin.dashboard.index');
    Route::get('user-control', [AdminController::class, 'index'])->name('admin.user.index');
    Route::post('admin', [AdminController::class, 'store'])->name('admin.user.store');
    Route::post('admin/update', [AdminController::class, 'update'])->name('admin.user.update');
    Route::post('admin/delete', [AdminController::class, 'delete'])->name('admin.user.delete');
    Route::get('book', [BookController::class, 'index'])->name('admin.book.index');
    Route::post('book', [BookController::class, 'store'])->name('admin.book.store');
    Route::post('book/update', [BookController::class, 'update'])->name('admin.book.update');
    Route::post('book/delete', [BookController::class, 'delete'])->name('admin.book.delete');
    Route::get('peminjaman', [PeminjamanController::class, 'index'])->name('admin.peminjaman.index');
    Route::post('peminjaman', [PeminjamanController::class, 'store'])->name('admin.peminjaman.store');
    Route::post('peminjaman/update', [PeminjamanController::class, 'update'])->name('admin.peminjaman.update');
    Route::post('peminjaman/delete', [PeminjamanController::class, 'delete'])->name('admin.peminjaman.delete');
    Route::get('peminjaman/get-user-id/{id}', [PeminjamanController::class, 'get_user_id']);
    Route::get('peminjaman/get-book-id/{isbn}', [PeminjamanController::class, 'get_book_id']);
    Route::get('peminjaman/get-user-name/{member_name}', [PeminjamanController::class, 'get_user_name']);
    Route::post('pengembalian', [PeminjamanController::class, 'store_pengembalian'])->name('admin.pengembalian.store');
    Route::get('pengembalian/get-book-pengembalian/{member_name}/{isbn}', [PeminjamanController::class, 'get_book_for_pengembalian']);
    Route::get('laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
    Route::post('laporan-filter', [LaporanController::class, 'filter'])->name('admin.laporan.filter');
    Route::post('print-laporan', [LaporanController::class, 'print_laporan'])->name('admin.laporan.print');
});
