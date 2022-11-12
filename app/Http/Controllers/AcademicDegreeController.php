<?php

namespace App\Http\Controllers;

use App\Exceptions\SomethingWentWrong;
use App\Http\Resources\AcademicDegreeResource;
use App\Models\AcademicDegree;
use Illuminate\Http\Request;

class AcademicDegreeController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Academic Degree"},
     *     path="/api/academic-degree",
     *     description="List Academic Degree",
     *     security={{"token": {}}},
     *     operationId="academic_degree_list",
     *  @OA\Parameter(
     *          name="academic_degree_id",
     *          in="query",
     *          description="academic degree",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="integer",
     *              example="1",
     *          )
     *      ),
     * @OA\Parameter(
     *          name="name",
     *          in="query",
     *          description="academic degree name",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="string",
     *              example="",
     *          )
     *      ),
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
    public function index(Request $request)
    {
        /*         auth()->user()->hasModulo(self::MODULO);
        auth()->user()->hasPermission('read'); */



        try {
            $serviceAvalible = AcademicDegree::name($request->name)
                ->academicdegree($request->academic_degree_id)
                ->paginate($request->perPage ?? env('PAGINATE'));
            return AcademicDegreeResource::collection($serviceAvalible);
        } catch (\Throwable $th) {
            throw new SomethingWentWrong($th);
        }
    }

    /**
     * @OA\Get(
     *     tags={"Academic Degree"},
     *     path="/api/academic-degree/{academic_degree}/show",
     *     description="Show a academic_degree",
     *     security={{"token": {}}},
     *     operationId="backoffice_academic_degree_show",
     *  @OA\Parameter(
     *          name="academic_degree",
     *          in="path",
     *          description="Id del academic degree",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="integer",
     *              example="1",
     *          )
     *      ),
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

    public function show(AcademicDegree $academic_degree)
    {
        try {
            /*             auth()->user()->hasModule(self::MODULO);
            auth()->user()->hasPermission('read'); */
            return new AcademicDegreeResource($academic_degree);
        } catch (\Throwable $th) {
            throw new SomethingWentWrong($th);
        }
    }

    /**
     * @OA\Post(
     *     tags={"Academic Degree"},
     *     path="/api/academic-degree/store",
     *     description="Create Academic degree",
     *     security={{"token": {}}},
     *     operationId="academic_degree_create",
     * @OA\RequestBody(
     *    required=true,
     *     @OA\MediaType(mediaType="multipart/form-data",
     *       @OA\Schema( required={"name"},
     *                  @OA\Property(property="name", type="string", description="Requirement name", example="Adjuntar documento"),
     *       ),
     *      ),
     *   ),
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
    public function store(Request $request)
    {

        /*         auth()->user()->hasModule(self::MODULO);
        auth()->user()->hasPermission('create'); */

        $this->validate($request, [
            'name' => 'required',
        ]);


        try {
            $academic_degree = new AcademicDegree;
            $academic_degree->name = $request->name;

            $academic_degree->save();

            return new AcademicDegreeResource($academic_degree);
        } catch (\Throwable $th) {
            throw new SomethingWentWrong($th);
        }
    }

    /**
     * @OA\Post(
     *     tags={"Academic Degree"},
     *     path="/api/academic-degree/{academic_degree}/update",
     *     description="Update service o requirement",
     *     security={{"token": {}}},
     *     operationId="academic_degree_update",
     *  @OA\Parameter(
     *          name="academic_degree",
     *          in="path",
     *          description="Id del academic degree",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="integer",
     *              example="1",
     *          )
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *     @OA\MediaType(mediaType="multipart/form-data",
     *       @OA\Schema( required={"name"},
     *                  @OA\Property(property="name", type="string", description="Requirement name", example="Adjuntar documento"),
     *       ),
     *      ),
     *   ),
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

    public function update(Request $request, AcademicDegree $academic_degree)
    {
        /* 
        auth()->user()->hasModule(self::MODULO);
        auth()->user()->hasPermission('update'); */

        $this->validate($request, [
            'name' => 'required',
        ]);

        try {
            $academic_degree->name = $request->name;

            $academic_degree->save();
            return new AcademicDegreeResource($academic_degree);
        } catch (\Throwable $th) {
            throw new SomethingWentWrong($th);
        }
    }

    /**
     * @OA\Delete(
     *     tags={"Academic Degree"},
     *     path="/api/academic-degree/{academic_degree}/delete",
     *     description="Borrar un requirement",
     *     security={{"token": {}}},
     *     operationId="academic_degree_delete",
     * @OA\Parameter(
     *          name="academic_degree",
     *          in="path",
     *          description="Id del academic degree",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="integer",
     *              example="1",
     *          )
     *      ),
     * @OA\Response(
     *    response=200,
     *    description="Successful Deleted",
     *    @OA\JsonContent(@OA\Property(property="status", type="string", example="successful"),
     *                     @OA\Property(property="message", type="string", example="Recurso borrado"),
     *        )
     * ),
     * @OA\Response(
     *    response=404,
     *    description="Error recurso no encontrado",
     *    @OA\JsonContent(@OA\Property(property="status", type="string", example="error"),
     *                     @OA\Property(property="message", type="string", example="Recurso no encontrado"),
     *        )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Bad Request",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unauthenticated")
     *        )
     *     ),
     * )
     */
    public function destroy(AcademicDegree $academic_degree)
    {
        /*         auth()->user()->hasModulo(self::MODULO);
        auth()->user()->hasPermission('destroy'); */

        try {

            $academic_degree->delete();
            return $this->deleted();
        } catch (\Throwable $th) {
            throw new SomethingWentWrong($th);
        }
    }
}
