<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\SomethingWentWrong;
use App\Http\Resources\TableResource;
use App\Models\Table;

class TableController extends Controller
{
    //
            /**
     * @OA\Get(
     *     tags={"Table"},
     *     path="/api/table",
     *     description="List tables",
     *     security={{"token": {}}},
     *     operationId="table_list",
     *  @OA\Parameter(
     *          name="capacity",
     *          in="query",
     *          description="table capacity",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="integer",
     *              example="6",
     *          )
     *      ),
     *      *  @OA\Parameter(
     *          name="perPage",
     *          in="query",
     *          description="per page",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="integer",
     *              example="20",
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

    public function index(Request $request){
        auth()->user()->hasPermiso('read');

        try{
            $table = Table::capacity($request->capacity)
              ->paginate($request->perPage ?? env('PAGINATE'));
            
            return TableResource::collection($table);
        } catch (\Throwable $th){
            throw new SomethingWentWrong($th);
        }
     }

             /**
     * @OA\Get(
     *     tags={"Table"},
     *     path="/api/table/{table}/show",
     *     description="show a table",
     *     security={{"token": {}}},
     *     operationId="table_show",
     *  @OA\Parameter(
     *          name="table",
     *          in="path",
     *          description="table id",
     *          required=false,
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
    public function show(Table $table){
        auth()->user()->hasPermiso('read');

        try{
            return new TableResource($table);
        } catch(\Throwable $th){
            throw new SomethingWentWrong($th);
        }
    }

        /**
     * @OA\Post(
     *     tags={"Table"},
     *     path="/api/table",
     *     description="Create a new table",
     *     security={{"token": {}}},
     *     operationId="table_create",
     * @OA\RequestBody(
     *    required=true,
     *     @OA\MediaType(mediaType="multipart/form-data",
     *       @OA\Schema( required={"capacity"},
     *                  @OA\Property(property="capacity", type="integer", description="table capacity", example="7"),
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
    public function store(Request $request){
        auth()->user()->hasPermiso('create');

        $this->validate($request, [
            'capacity' => 'required'
        ]);

        try{
            $table = New Table();
            $table->capacity = $request->capacity;
            $table->save();

            return new TableResource($table);
        } catch (\Throwable $th){
            throw new SomethingWentWrong($th);
        }
    }

    
        /**
     * @OA\Post(
     *     tags={"Table"},
     *     path="/api/table/{table}/update",
     *     description="Update a table",
     *     security={{"token": {}}},
     *     operationId="table_update",
     *      *  @OA\Parameter(
     *          name="table",
     *          in="path",
     *          description="table id",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="integer",
     *              example="1",
     *          )
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *     @OA\MediaType(mediaType="multipart/form-data",
     *       @OA\Schema( required={"capacity"},
     *                  @OA\Property(property="capacity", type="string", description="table capacity", example="9"),
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

     public function update(Table $table, Request $request){
        auth()->user()->hasPermiso('create');
    
        $this->validate($request, [
            'capacity' => 'required'
        ]);

        try{
         
            $table->capacity = $request->capacity;

            $table->save();
            return new TableResource($table);
        } catch (\Throwable $th){
            throw new SomethingWentWrong($th);
        }
     }

         /**
     * @OA\Delete(
     *     tags={"Table"},
     *     path="/api/table/{table}/delete",
     *     description="Delete a Table",
     *     security={{"token": {}}},
     *     operationId="table_delete",
     * @OA\Parameter(
     *          name="table",
     *          in="path",
     *          description="table id",
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
    public function destroy(Table $table){

        auth()->user()->hasPermiso('destroy');
        try {

            $table->delete();
            return $this->deleted();
        } catch (\Throwable $th) {
            throw new SomethingWentWrong($th);
        }
    }
}
