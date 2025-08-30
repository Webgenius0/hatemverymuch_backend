<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Backend\Contact\ContactController;

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/contact/message', [ContactController::class, 'index'])->name('contact.index');
    Route::get('/contact/message/{id}', [ContactController::class, 'show'])->name('contact.show');
    Route::delete('/contact/message/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');

});
