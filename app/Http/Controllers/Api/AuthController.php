<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /** Failed logins allowed per email per hour, on top of the per-IP route throttle. */
    private const MAX_FAILURES = 10;

    /** Checked when the email is unknown, so response time doesn't reveal which emails exist. */
    private const DUMMY_HASH = '$2y$10$1qHSxtL0eSJK95GxVtrYkeXIaNUl5/qZwDYfk7dAS859qQGk/CTkS';

    public function __construct() {}

    public function token(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email'       => 'required|email',
            'password'    => 'required|string',
            'device_name' => 'nullable|string|max:255',
        ]);

        $key = 'api-login:' . strtolower($data['email']);
        if (RateLimiter::tooManyAttempts($key, self::MAX_FAILURES)) {
            throw ValidationException::withMessages([
                'email' => 'Too many failed attempts. Try again in ' . ceil(RateLimiter::availableIn($key) / 60) . ' minutes.',
            ])->status(429);
        }

        $user = User::where('email', $data['email'])->first();
        $valid = Hash::check($data['password'], $user?->password ?? self::DUMMY_HASH);

        if (! $user || ! $valid) {
            RateLimiter::hit($key, 3600);
            throw ValidationException::withMessages(['email' => 'The provided credentials are incorrect.']);
        }

        RateLimiter::clear($key);

        return response()->json([
            'token' => $user->createToken($data['device_name'] ?? 'api', ['*'], now()->addYear())->plainTextToken,
        ]);
    }

    public function revoke(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['revoked' => true]);
    }

    /** Revoke every API token, e.g. after a leak or a password change. */
    public function revokeAll(Request $request): JsonResponse
    {
        return response()->json(['revoked' => $request->user()->tokens()->delete()]);
    }
}
