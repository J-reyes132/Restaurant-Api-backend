<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

use Hash;
use App\Exceptions\SomethingWentWrong;
use App\Tools\ResponseCodes;
use Carbon\Carbon;
use App\Tools\GoogleBucketTrait;

class ProfileController extends Controller
{

    use GoogleBucketTrait;

    public const MODULO = 'usuarios';

    /**
     * @OA\Get(
     *     tags={"Profile"},
     *     path="/api/profile/getProfile",
     *     description="Obtener el profile del usuario autenticado",
     *     security={{"token": {}}},
     *     operationId="profile_index",
     * @OA\Response(
     *    response=200,
     *    description="Successful Response",
     *    @OA\JsonContent(@OA\Property(property="data", type="Json", example="[...]"),
     *        )
     * ),
     * * @OA\Response(
     *    response=401,
     *    description="Bad Request",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unauthenticated")
     *        )
     *     ),
     * )
     */
    function getProfile()
    {
        try {
            $user = auth()->user();
            return new UserResource($user);
        } catch (\Throwable $th) {
            throw new SomethingWentWrong($th);
        }
    }

    /**
     * @OA\Post(
     *     tags={"Profile"},
     *     path="/api/profile/update",
     *     description="Actualizar el profile del usuario autenticado",
     *     security={{"token": {}}},
     *     operationId="profile_store",
     * @OA\RequestBody(
     *    required=true,
     *     @OA\MediaType(mediaType="multipart/form-data",
     *       @OA\Schema( required={"nombre"},
     *                  @OA\Property(property="nombre", type="string", example="Juan Perez"),
     *                  @OA\Property(property="telefono", type="string", example="123-123-1234"),
     *                  @OA\Property(property="movil", type="string", example="123-123-1234"),
     *                  @OA\Property(property="imagen", type="string", format="binary"),
     *
     *       ),
     *      ),
     *   ),
     * @OA\Response(
     *    response=201,
     *    description="Successful Stored",
     *    @OA\JsonContent(@OA\Property(property="data", type="Json", example="[...]"),
     *        )
     * ),
     * * @OA\Response(
     *    response=401,
     *    description="Bad Request",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unauthenticated")
     *        )
     *     ),
     * )
     */
    function update(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        //Tomamos el Usuario Con Sesion Iniciada
        $user = auth()->user();




        if (isset($request->imagen)) {
            $image = $this->uploadGoogle($request, "imagen");
        }

        try {
            $user->profile->name = $request->nombre;
            $user->profile->phone = $request->telefono;
            $user->profile->movil = $request->movil;
            if (isset($request->imagen)) {
                $user->profile->image_url = $image['url'];
                $user->profile->image_size = $image['size'];
                $user->profile->image_ext = $image['ext'];
                $user->profile->image_publicId = $image['name'];
            }
            $user->profile->updated_at = Carbon::now();
            $user->profile->save();
            return new UserResource($user);
        } catch (\Throwable $th) {
            throw new SomethingWentWrong($th);
        }
    }

    /**
     * @OA\Post(
     *     tags={"Profile"},
     *     path="/api/profile/changepassword",
     *     description="Cambiar la contraseña para el usuario autenticado",
     *     security={{"token": {}}},
     *     operationId="profile_changePassword",
     * @OA\RequestBody(
     *    required=true,
     *     @OA\MediaType(mediaType="multipart/form-data",
     *       @OA\Schema( required={"current_password","password","password_confirmation"},
     *                  @OA\Property(property="current_password", type="string", example="CurrentPasswordHere"),
     *                  @OA\Property(property="password", type="string", example="NewSuperPasswordHere"),
     *                  @OA\Property(property="password_confirmation", type="string", example="NewSuperPasswordHere"),
     *       ),
     *      ),
     *   ),
     * @OA\Response(
     *    response=201,
     *    description="Successful Stored",
     *    @OA\JsonContent(@OA\Property(property="data", type="Json", example="[...]"),
     *        )
     * ),
     * * @OA\Response(
     *    response=401,
     *    description="Bad Request",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unauthenticated")
     *        )
     *     ),
     * )
     */
    function changePassword(Request $request)
    {

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        $user = auth()->user();

        if (Hash::check($request->current_password, $user->password)) {
            try {
                $user->password = bcrypt($request->password);
                $user->save();
                return response()->json(['status' => 'successful', 'message' => 'Contraseña cambiada'], ResponseCodes::OK);
            } catch (\Throwable $th) {
                throw new SomethingWentWrong($th);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Contraseña actual incorrecta'], ResponseCodes::UNAUTHORIZED);
        }
    }
}