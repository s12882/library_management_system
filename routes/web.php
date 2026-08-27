<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/books');

Route::resource('books', BookController::class)->except('show');
Route::resource('authors', AuthorController::class)->except('show');

Route::get('loans', [LoanController::class, 'index'])->name('loans.index');
Route::get('loans/data', [LoanController::class, 'data'])->name('loans.data');
Route::post('loans', [LoanController::class, 'store'])->name('loans.store');
Route::delete('loans/{loan}', [LoanController::class, 'destroy'])->name('loans.destroy');
