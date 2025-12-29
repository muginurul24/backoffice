<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuestResponseController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        return match ($request->post('method')) {
            'login' => $this->login($request),
            'register' => $this->register($request),
            'forgot' => $this->forgot($request),
            default => throw new HttpResponseException(response()->json(['errors' => ['message' => 'Invalid Method']], 404))
        };
    }

    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new HttpResponseException(response()->json(['errors' => ['message' => 'The provided credentials are incorrect.']], 401));
        }

        return response()->json([
            'totp' => (bool)$user->two_factor_secret !== null,
            'token' => $user->createToken($user->email)->plainTextToken
        ]);
    }

    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'string', 'min:8', 'same:password']
        ]);

        $user = User::create([
            'name' => Str::title($data['name']),
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        return response()->json([
            'data' => $user
        ]);
    }

    public function forgot(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            throw new HttpResponseException(response()->json(['errors' => ['message' => 'The provided credentials are incorrect.']], 401));
        }

        return response()->json([
            'message' => 'We have emailed your password reset link.'
        ]);
    }
}
