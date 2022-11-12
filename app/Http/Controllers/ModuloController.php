<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use Illuminate\Http\Request;

use App\Http\Resources\ModuloResource;
use App\Exceptions\SomethingWentWrong;

class ModuloController extends Controller
{

    public const MODULO = 'roles';

    /**
     * @OA\Get(
     *     tags={"Roles"},
     *     path="/api/roles/modulos",
     *     description="Mostrar todos los modulos registrados",
     *     security={{"token": {}}},
     *     operationId="module_GetAllModules",
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
            $modulos = Modulo::all();
            return ModuloResource::collection($modulos);
        } catch (\Throwable $th) {
            throw new SomethingWentWrong($th);
        }
    }

}