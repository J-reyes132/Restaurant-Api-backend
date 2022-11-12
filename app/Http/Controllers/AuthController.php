<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Tools\ResponseCodes;
use App\Http\Resources\UserResourceLogin;
use App\Exceptions\SomethingWentWrong;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     * tags={"Login"},
     * path="/api/profile/login",
     * description="Autenticarse en el sistema",
     * operationId="login",
     * @OA\RequestBody(
     *    required=true,
     *     @OA\MediaType(mediaType="multipart/form-data",
     *       @OA\Schema( required={"email","password"},
     *                  @OA\Property(property="email", type="string", description="Email Usuario", example="admin@pruebas.com"),
     *                  @OA\Property(property="password", type="string", description="Password", example="admin"),
     *       ),
     *      ),
     *   ),
     * @OA\Response(
     *    response=401,
     *    description="Bad Request",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="string", example="error"),
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     ),
     * @OA\Response(
     *    response=200,
     *    description="Successful Response",
     *    @OA\JsonContent(
     *       @OA\Property(property="user", type="json", example="User information"),
     *       @OA\Property(property="token", type="string", example="bearer token for user"),
     *        )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['status' => 'error', 'message' => 'Credenciales Invalidas'], ResponseCodes::UNAUTHORIZED);
        }

        $user = auth()->user();

        if(!$user->active) {
            return response(['status' => 'error', 'message' => 'Usuario desactivado'], ResponseCodes::UNAUTHORIZED);
        }

        $token = auth()->user()->createToken(env('TOKEN_SECRET'))->accessToken;

        return response(['user' => new UserResourceLogin($user), 'token' => $token], ResponseCodes::OK);
    }

    /**
     * @OA\Post(
     *     tags={"Login"},
     *     path="/api/profile/logout",
     *     description="Revocar autorizacion en el sistema",
     *     security={{"token": {}}},
     *
     * @OA\Response(
     *    response=200,
     *    description="Successful Response",
     *    @OA\JsonContent(
     *       @OA\Property(property="status", type="string", example="successful"),
     *       @OA\Property(property="message", type="string", example="User has been logged out"),
     *        )
     *     ),
     * * @OA\Response(
     *    response=401,
     *    description="Bad Request",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unauthenticated")
     *        )
     *     ),
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['status' => 'successful','message' => 'Usuario ha salido del sistema'], ResponseCodes::OK);
    }


}