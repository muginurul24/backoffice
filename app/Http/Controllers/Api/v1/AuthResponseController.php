<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthResponseController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        return match ($request->post('method')) {
            'logout' => $this->logout($request),
            'delete' => $this->delete($request),
            default => throw new HttpResponseException(response()->json(['errors' => ['message' => 'Invalid Method']], 404))
        };
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    public function delete(Request $request): JsonResponse
    {
        $user = User::find($request->user()->id);

        if (is_null($user)) {
            throw new HttpResponseException(response()->json(['errors' => ['message' => 'User not found']], 404));
        }

        $user->tokens()->delete();
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
