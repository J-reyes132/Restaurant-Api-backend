<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\SomethingWentWrong;
use App\Http\Resources\OrderListResource;
use App\Http\Resources\OrderResource;
use App\Models\Inventory;
use App\Models\Order;
use Carbon\Carbon;
use Cloudinary\Transformation\Quality;

class OrderController extends Controller
{
    public const MODULO = 'productos';
    /**
* @OA\Get(
*     tags={"Order"},
*     path="/api/order",
*     description="List orders",
*     security={{"token": {}}},
*     operationId="order_list",
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
      $order = Order::orderBy('order_date', 'desc')
        ->paginate($request->perPage ?? env('PAGINATE'));

      return OrderListResource::collection($order);
  } catch (\Throwable $th){
      throw new SomethingWentWrong($th);
  }
}

       /**
* @OA\Get(
*     tags={"Order"},
*     path="/api/order/{order}/show",
*     description="show a order",
*     security={{"token": {}}},
*     operationId="order_show",
*  @OA\Parameter(
*          name="order",
*          in="path",
*          description="order id",
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
public function show(Order $order){
  auth()->user()->hasModulo(self::MODULO);
  auth()->user()->hasPermiso('read');

  try{
      return new OrderResource($order);
  } catch(\Throwable $th){
      throw new SomethingWentWrong($th);
  }
}

  /**
* @OA\Post(
*     tags={"Order"},
*     path="/api/order",
*     description="Create a new order",
*     security={{"token": {}}},
*     operationId="order_create",
* @OA\RequestBody(
*    required=true,
*     @OA\MediaType(mediaType="multipart/form-data",
*       @OA\Schema( required={"table_id", "customer_id","quantity" },
*                  @OA\Property(property="table_id", type="integer", description="id Mesa", example="1"),
*                  @OA\Property(property="customer_id", type="integer", description="Id del cliente", example="1"),
*                  @OA\Property(property="product_id", type="integer", description="Id del producto", example="1"),
*                  @OA\Property(property="menu_id", type="integer", description="Id del menu", example="1"),
*                  @OA\Property(property="quantity", type="integer", description="Cantidad ordenada", example="1"),
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
      'table_id' => 'required',
      'customer_id' => 'required',
      'quantity' => 'required'
  ]);

  try{
      $order = New Order();
      $inventory = Inventory::where('product_id', $request->product_io)->first();

      $quantity = $inventory->quantity;
      if($quantity >= $request){
      if($request->menu_id && $request->product_id){

      }
      $order->table_id = $request->table_id;
      $order->customer_id = $request->customer_id;
      $order->product_id = $request->product_id;
      $order->menu_id = $request->menu_id;
      $order->quantity = $request->quantity;
      $order->order_date = Carbon::now();
      $order->save();

      $inventory->quantity = $quantity-1;
      $inventory->save();
    } else {
        return response()->json(['error'=> 'no se puede crear la orden', 'message' => 'la cantidad solicitada no esta disponible en el inventario']);
    }
      return new OrderResource($order);
  } catch (\Throwable $th){
      throw new SomethingWentWrong($th);
  }
}


  /**
* @OA\Post(
*     tags={"Order"},
*     path="/api/order/{order}/update",
*     description="Update a order",
*     security={{"token": {}}},
*     operationId="order_update",
*      *  @OA\Parameter(
*          name="order",
*          in="path",
*          description="order id",
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
*                  @OA\Schema( required={"table_id", "customer_id","quantity" },
*                  @OA\Property(property="table_id", type="integer", description="id Mesa", example="1"),
*                  @OA\Property(property="customer_id", type="integer", description="Id del cliente", example="1"),
*                  @OA\Property(property="product_id", type="integer", description="Id del producto", example="1"),
*                  @OA\Property(property="menu_id", type="integer", description="Id del menu", example="1"),
*                  @OA\Property(property="quantity", type="integer", description="Cantidad ordenada", example="1"),
*           ),
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

public function update(Order $order, Request $request){
  auth()->user()->hasModulo(self::MODULO);
  auth()->user()->hasPermiso('create');

  $this->validate($request, [
    'table_id' => 'required',
    'customer_id' => 'required',
    'quantity' => 'required'
]);

try{

    $order->table_id = $request->table_id;
    $order->customer_id = $request->customer_id;
    $order->product_id = $request->product_id;
    $order->menu_id = $request->menu_id;
    $order->quantity = $request->quantity;
    $order->save();
      return new OrderResource($order);
  } catch (\Throwable $th){
      throw new SomethingWentWrong($th);
  }
}

   /**
* @OA\Delete(
*     tags={"Order"},
*     path="/api/order/{order}/delete",
*     description="Delete a Order",
*     security={{"token": {}}},
*     operationId="order_delete",
* @OA\Parameter(
*          name="order",
*          in="path",
*          description="order id",
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
public function destroy(Order $order){
  auth()->user()->hasModulo(self::MODULO);
  auth()->user()->hasPermiso('destroy');
  try {

      $order->delete();
      return $this->deleted();
  } catch (\Throwable $th) {
      throw new SomethingWentWrong($th);
  }
}
}
