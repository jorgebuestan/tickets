<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketSelectionController;
use App\Http\Controllers\AdminTicketController;

Route::get('/', [TicketSelectionController::class, 'create'])->name('tickets.create');
Route::post('/tickets', [TicketSelectionController::class, 'store'])->name('tickets.store');

Route::middleware('admin.basic')->prefix('admin/tickets')->name('admin.tickets.')->group(function () {
    Route::get('/', [AdminTicketController::class, 'index'])->name('index');
    Route::get('/export', [AdminTicketController::class, 'export'])->name('export');
});
