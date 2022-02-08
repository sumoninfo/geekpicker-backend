<?php

namespace App\Repository\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class EloquentAuthRepository implements AuthRepository
{
    /**
     * login
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $user        = $request->user();
        $tokenResult = $user->createToken('appToken');
        return response()->json([
            'access_token' => $tokenResult->plainTextToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::now()->addWeeks(1)->toDateTimeString(),
            'user'         => $user,
            'message'      => 'Successfully Login',
        ]);
    }

    /**
     * register
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($request->password);
        $user->save();

        $tokenResult = $user->createToken('appToken');
        return response()->json([
            'message'      => 'Successfully Register',
            'access_token' => $tokenResult->plainTextToken,
            'token_type'   => 'Bearer',
            'role_id'      => $user->role_id,
            'expires_at'   => Carbon::now()->addWeeks(1)->toDateTimeString(),
        ]);
    }

    /**
     * logout
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
    }
}
