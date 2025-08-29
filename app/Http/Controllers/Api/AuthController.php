<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
// In your register() function


    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        // Check if email already exists
        if (User::where('email', $validated['email'])->exists()) {
            return response()->json([
                'message' => 'This email is already registered. Please log in instead.',
            ], 409); // 409 Conflict
        }

        $baseUsername = Str::slug($validated['name'], '_');
        $uniqueUsername = $baseUsername;
        $counter = 1;

        while (User::where('username', $uniqueUsername)->exists()) {
            $uniqueUsername = $baseUsername . '_' . $counter++;
        }

        // Generate OTP
        $otp = random_int(1000, 9999);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'username' => $uniqueUsername,
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(15),
        ]);

        // Send verification email
        $user->sendEmailVerificationNotification();

        // Auto-login
        $token = auth('api')->login($user);

        return response()->json([
            'message' => 'Registered successfully. Please check your email for the verification code.',
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['nullable', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols()],
            'role' => ['required', 'in:admin,user'],
            'bio' => ['nullable', 'string', 'max:500'],
            'weblink' => ['nullable', 'url'],
        ]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'lastname' => $validated['lastname'] ?? null,
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'] ?? 'user',
                'bio' => $validated['bio'] ?? null,
                'weblink' => $validated['weblink'] ?? null,
                'profile_pic' => null, // handle upload later
                'banner_pic' => null, // handle upload later
            ]);

            // Send email verification
            $user->sendEmailVerificationNotification();

            // Auto-login (optional)
            $token = auth('api')->login($user);

            return response()->json([
                'message' => 'Registered successfully. Please verify your email.',
                'token' => $token,
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong during registration.',
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        // dd("authcontroller");
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user(),
        ]);
    }
}
