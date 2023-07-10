<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Authenticate a user and generate an access token.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }

        $user = User::whereEmail($request->email)->first();

        if ($user) {
            $hashed = Hash::check($request->password, $user->password);

            if ($hashed) {
                $token = $user->createToken('Access Token')->accessToken;

                return response(['access_token' => $token], 200);
            }

            return response()->json([
                'errors' => [
                    'password' => ['The password is not correct.']
                ]
            ], 422);
        }

        return response()->json([
            'errors' => [
                'email' => ['The user does not exist.']
            ]
        ], 422);
    }

    /**
     * Get the authenticated user's details.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'id' => $user->id,
            'email' => $user->email
        ], 200);
    }

    /**
     * Logout the authenticated user and revoke the access token.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        return response(null, 204);
    }

}
