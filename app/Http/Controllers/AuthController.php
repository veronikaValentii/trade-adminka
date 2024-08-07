<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Helpers\ApiResponse;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Token;

class AuthController extends Controller
{
    public function __construct(public readonly User $user)
    {
    }

    public function authenticate(AuthRequest $request): JsonResponse
    {
        //todo:not login if user not verified email
        if ($token = Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
            // Authentication passed...
            $parseToken = JWTAuth::decode(new Token($token));
            return ApiResponse::sendResponse([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Carbon::parse($parseToken->get('exp'))
            ]);
        }

        throw new ApiException(httpCode: 401);
    }

    public function registration(RegisterRequest $request): JsonResponse
    {
        $user = User::query()->create($request->only(['email', 'password', 'name']));
        return ApiResponse::sendResponse(['user' => $user]);
    }

    public function logout(): JsonResponse
    {
        try {
            auth()->logout(true);
        } catch (\Exception $e) {
            throw new ApiException(httpCode:401);
        }
        return ApiResponse::sendResponse(['result' => true]);
    }
}
