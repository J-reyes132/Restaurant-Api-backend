<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\SomethingWentWrong;
use App\Http\Resources\MenuListResource;
use App\Http\Resources\MenuResource;
use App\Models\Menu;

class MenuController extends Controller
{
    public const MODULO = 'menus';
        /**
* @OA\Get(
*     tags={"Menu"},
*     path="/api/menu",
*     description="List menus",
*     security={{"token": {}}},
*     operationId="menu_list",
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
    auth()->user()->hasModulo(self::MODULO);
    auth()->user()->hasPermiso('read');
  
    try{
        $menu = Menu::all()->paginate($request->perPage ?? env('PAGINATE'));
        
        return MenuResource::collection($menu);
    } catch (\Throwable $th){
        throw new SomethingWentWrong($th);
    }
  }
  
         /**
  * @OA\Get(
  *     tags={"Menu"},
  *     path="/api/menu/{menu}/show",
  *     description="show a menu",
  *     security={{"token": {}}},
  *     operationId="menu_show",
  *  @OA\Parameter(
  *          name="menu",
  *          in="path",
  *          description="menu id",
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
  public function show(Menu $menu){
    auth()->user()->hasModulo(self::MODULO);
    auth()->user()->hasPermiso('read');
  
    try{
        return new MenuResource($menu);
    } catch(\Throwable $th){
        throw new SomethingWentWrong($th);
    }
  }
  
    /**
  * @OA\Post(
  *     tags={"Menu"},
  *     path="/api/menu",
  *     description="Create a new menu",
  *     security={{"token": {}}},
  *     operationId="menu_create",
  * @OA\RequestBody(
  *    required=true,
  *     @OA\MediaType(mediaType="multipart/form-data",
  *       @OA\Schema( required={"name"},
  *                  @OA\Property(property="name", type="integer", description="nombre del combo", example="Combo 1"),
  *                  @OA\Property(property="price", type="integer", description="precio del combo", example="240"),
  *                  @OA\Property(property="product_id[0]", type="integer", description="Id del producto", example="1"),
  *                  @OA\Property(property="product_id[1]", type="integer", description="Id del producto", example="2"),
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
    auth()->user()->hasModulo(self::MODULO);
    auth()->user()->hasPermiso('create');
  
    $this->validate($request, [
       'name' => 'required'
    ]);
  
    try{
        $menu = New Menu();
        $menu->name = $request->name;
        $menu->menu_price = $request->price;
        $menu->save();
        if ($request->product_id && count($request->product_id)) {
            foreach ($request->product_id as $product) {
                $menu->products()->attach($product);
            }
        }
  
        return new MenuResource($menu);
    } catch (\Throwable $th){
        throw new SomethingWentWrong($th);
    }
  }
  
  
    /**
  * @OA\Post(
  *     tags={"Menu"},
  *     path="/api/menu/{menu}/update",
  *     description="Update a menu",
  *     security={{"token": {}}},
  *     operationId="menu_update",
  *      *  @OA\Parameter(
  *          name="menu",
  *          in="path",
  *          description="menu id",
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
  *       @OA\Schema( required={"name"},
  *                  @OA\Property(property="name", type="integer", description="nombre del combo", example="Combo 1"),
  *                  @OA\Property(property="price", type="integer", description="precio del combo", example="240"),
  *                  @OA\Property(property="product_id[0]", type="integer", description="Id del producto", example="1"),
  *                  @OA\Property(property="product_id[1]", type="integer", description="Id del producto", example="2"),
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
  
  public function update(Menu $menu, Request $request){
    auth()->user()->hasModulo(self::MODULO);
    auth()->user()->hasPermiso('create');
  
  
    $this->validate($request, [
        'name' => 'required',
        'price' => 'required'
     ]);
   
     try{

         $menu->name = $request->name;
         $menu->menu_price = $request->price;
         $menu->save();
         if ($request->product_id && count($request->product_id)) {
             foreach ($request->product_id as $product) {
                 $menu->products()->attach($product);
             }
         }

        return new MenuResource($menu);
    } catch (\Throwable $th){
        throw new SomethingWentWrong($th);
    }
  }
  
     /**
  * @OA\Delete(
  *     tags={"Menu"},
  *     path="/api/menu/{menu}/delete",
  *     description="Delete a Menu",
  *     security={{"token": {}}},
  *     operationId="menu_delete",
  * @OA\Parameter(
  *          name="menu",
  *          in="path",
  *          description="menu id",
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
  public function destroy(Menu $menu){
    auth()->user()->hasModulo(self::MODULO);
    auth()->user()->hasPermiso('destroy');
    try {
  
        $menu->delete();
        return $this->deleted();
    } catch (\Throwable $th) {
        throw new SomethingWentWrong($th);
    }
  }
}
