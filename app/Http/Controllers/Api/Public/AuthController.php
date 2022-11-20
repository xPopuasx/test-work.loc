<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Public\AuthUserRequest;
use App\Http\Resources\Api\User\UserResource;
use App\Models\User\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AuthController extends Controller
{
    /**
     * @param  AuthUserRequest  $request
     * @return JsonResponse
     *
     * @throws Throwable
     */
    public function login(AuthUserRequest $request): JsonResponse
    {
        $input = $request->all();

        $data = [
            'email' => $input['email'],
            'password' => $input['password'],
        ];

        throw_if(!Auth::attempt($data), new AuthenticationException('Bad attempt'));

        /** @var User $user */
        $user = Auth::user();

        return response()->json([
            'user' => (new UserResource($user)),
            'token' => $user->createToken('api')->plainTextToken,
        ]);
    }

    public function logout(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $user->tokens()->delete();

        return Response()->json('ok');
    }
}
