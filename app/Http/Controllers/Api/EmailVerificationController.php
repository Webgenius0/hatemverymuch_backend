<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return response()->json(['message' => 'Invalid verification link'], 403);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified']);
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return response()->json(['message' => 'Email verified successfully']);
    }



    public function resend(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified'], 422);
        }

        // Generate a new 4-digit OTP for resend
        $otp = random_int(1000, 9999);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(15);
        $user->save();

        $user->sendEmailVerificationNotification();

        return response()->json(['message' => 'Verification code resent']);
    }


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'digits:4'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Check if email is already verified
        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified']);
        }

        // Check if the OTP matches and is not expired
        if ($user->otp !== $request->otp || now()->gt($user->otp_expires_at)) {
            return response()->json(['message' => 'Invalid or expired OTP'], 403);
        }

        // Mark email as verified and clear OTP
        $user->markEmailAsVerified();
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        event(new Verified($user));

        return response()->json(['message' => 'Email verified successfully']);
    }

}
