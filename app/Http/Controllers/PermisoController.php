<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;

use App\Http\Resources\PermisoResource;
use App\Exceptions\SomethingWentWrong;

class PermisoController extends Controller
{

    public const MODULO = 'roles';

   /**
     * @OA\Get(
     *     tags={"Roles"},
     *     path="/api/roles/permisos",
     *     description="Get All Permissions",
     *     security={{"token": {}}},
     *     operationId="permissions_getAllPermissions",
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
    public function index()
    {
        auth()->user()->hasModulo(self::MODULO);
        auth()->user()->hasPermiso('read');
        try {
            $permisos = Permiso::all();
            return PermisoResource::collection($permisos);
        } catch (\Throwable $th) {
            throw new SomethingWentWrong($th);
        }
    }
}