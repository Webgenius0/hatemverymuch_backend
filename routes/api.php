<?php


use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Contents\ContentController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\PasswordResetController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('profile/update', [AuthController::class, 'profile.update'])->middleware('auth:api');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});

/**
 * Email verification
 * Link example (signed): /api/email/verify/{id}/{hash}
 */

Route::post('email/verification-notification', [EmailVerificationController::class, 'resend'])
    ->middleware(['auth:api', 'throttle:6,1']); // resend verification

Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

/**
 * Password reset (via email link)
 */
Route::post('password/email', [PasswordResetController::class, 'sendResetLink']);   // request reset link
Route::post('password/reset', [PasswordResetController::class, 'resetPassword']);   // handle reset form submit
Route::post('password/resend', [PasswordResetController::class, 'resendResetLink']); // optional resend


// ------------ Contents: Creators making contents ------------ //
Route::middleware('auth:api')->prefix('auth')->group(function () {

    Route::post('content/create', [ContentController::class, 'createContent'])->name('content.create');
    Route::get('content/{id}/show', [ContentController::class, 'showContent'])->name('content.show');
    Route::post('content/{id}/update', [ContentController::class, 'updateContent'])->name('content.update');
    Route::delete('content/{contentID}/delete', [ContentController::class, 'deleteContent'])->name('content.delete');
});

Route::get('auth/content/all', [ContentController::class, 'allContents'])->name('content.contents');

// ------------ Utilities: Tags, Likes, Shares ------------ //
Route::middleware('auth:api')->prefix('auth')->group(function () {
    Route::get('utilities/tags/all', [ContentController::class, 'getAllTags'])->name('content.utilities.tags');
});

// routes/api.php

Route::post('/email/verify-otp', [EmailVerificationController::class, 'verifyOtp']);
