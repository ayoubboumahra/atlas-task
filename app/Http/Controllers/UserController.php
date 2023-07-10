<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Delete the authenticated user and revoke the access token.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $user = $request->user();
        $token = $user->token();

        $token->revoke();
        $user->delete();

        return response(null, 204);
    }
}
