<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\SomethingWentWrong;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public const MODULO = 'productos';
          /**
     * @OA\Get(
     *     tags={"Product"},
     *     path="/api/product",
     *     description="List products",
     *     security={{"token": {}}},
     *     operationId="product_list",
     *  @OA\Parameter(
     *          name="name",
     *          in="query",
     *          description="product name",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="string",
     *              example="agua",
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
        auth()->user()->hasModulo(self::MODULO);
        auth()->user()->hasPermiso('read');

        try{
            $product = Product::name($request->name)
              ->paginate($request->perPage ?? env('PAGINATE'));
            
            return ProductResource::collection($product);
        } catch (\Throwable $th){
            throw new SomethingWentWrong($th);
        }
     }

             /**
     * @OA\Get(
     *     tags={"Product"},
     *     path="/api/product/{product}/show",
     *     description="show a product",
     *     security={{"token": {}}},
     *     operationId="product_show",
     *  @OA\Parameter(
     *          name="product",
     *          in="path",
     *          description="product id",
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
    public function show(Product $product){
        auth()->user()->hasModulo(self::MODULO);
        auth()->user()->hasPermiso('read');

        try{
            return new ProductResource($product);
        } catch(\Throwable $th){
            throw new SomethingWentWrong($th);
        }
    }

        /**
     * @OA\Post(
     *     tags={"Product"},
     *     path="/api/product",
     *     description="Create a new product",
     *     security={{"token": {}}},
     *     operationId="product_create",
     * @OA\RequestBody(
     *    required=true,
     *     @OA\MediaType(mediaType="multipart/form-data",
     *       @OA\Schema( required={"name", "price","category" },
     *                  @OA\Property(property="name", type="string", description="product name", example="dulce de leche"),
     *                  @OA\Property(property="description", type="string", description="Product Description", example="Filete"),
     *                  @OA\Property(property="price", type="integer", description="product price", example="300"),
     *                  @OA\Property(property="category", type="string", description="Product category", example="plato"),
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
            'name' => 'required',
            'price' => 'required',
            'category' => 'required'
        ]);

        try{
            $product = New Product();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->category = $request->category;
            $product->save();

            return new ProductResource($product);
        } catch (\Throwable $th){
            throw new SomethingWentWrong($th);
        }
    }

    
        /**
     * @OA\Post(
     *     tags={"Product"},
     *     path="/api/product/{product}/update",
     *     description="Update a product",
     *     security={{"token": {}}},
     *     operationId="product_update",
     *      *  @OA\Parameter(
     *          name="product",
     *          in="path",
     *          description="product id",
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
     *       @OA\Schema( required={"name", "price","category" },
     *                  @OA\Property(property="name", type="string", description="product name", example="dulce de leche"),
     *                  @OA\Property(property="description", type="string", description="Product Description", example="Filete"),
     *                  @OA\Property(property="price", type="integer", description="product price", example="300"),
     *                  @OA\Property(property="category", type="string", description="Product category", example="plato"),
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

     public function update(Product $product, Request $request){
        auth()->user()->hasModulo(self::MODULO);
        auth()->user()->hasPermiso('create');
    
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'category' => 'required'
        ]);

        try{
         
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->category = $request->category;
            $product->save();
            return new ProductResource($product);
        } catch (\Throwable $th){
            throw new SomethingWentWrong($th);
        }
     }

         /**
     * @OA\Delete(
     *     tags={"Product"},
     *     path="/api/product/{product}/delete",
     *     description="Delete a Product",
     *     security={{"token": {}}},
     *     operationId="product_delete",
     * @OA\Parameter(
     *          name="product",
     *          in="path",
     *          description="product id",
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
    public function destroy(Product $product){
        auth()->user()->hasModulo(self::MODULO);
        auth()->user()->hasPermiso('destroy');
        try {

            $product->delete();
            return $this->deleted();
        } catch (\Throwable $th) {
            throw new SomethingWentWrong($th);
        }
    }
}
