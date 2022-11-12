<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\SomethingWentWrong;
use App\Http\Resources\CustomerListResource;
use App\Models\Customer;
use PhpParser\Node\Expr\New_;

class CustomerController extends Controller
{
    public const MODULO = 'clientes';
        /**
     * @OA\Get(
     *     tags={"Customer"},
     *     path="/api/customer",
     *     description="List customers",
     *     security={{"token": {}}},
     *     operationId="customer_list",
     *  @OA\Parameter(
     *          name="name",
     *          in="query",
     *          description="customer name",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="string",
     *              example="pedro",
     *          )
     *      ),
     *      *  @OA\Parameter(
     *          name="perPage",
     *          in="query",
     *          description="customer name",
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
            $customer = Customer::name($request->name)
              ->paginate($request->perPage ?? env('PAGINATE'));
            
            return CustomerListResource::collection($customer);
        } catch (\Throwable $th){
            throw new SomethingWentWrong($th);
        }
     }

             /**
     * @OA\Get(
     *     tags={"Customer"},
     *     path="/api/customer/{customer}/show",
     *     description="show a customer",
     *     security={{"token": {}}},
     *     operationId="customer_show",
     *  @OA\Parameter(
     *          name="customer",
     *          in="path",
     *          description="customer id",
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
    public function show(Customer $customer){
        auth()->user()->hasModulo(self::MODULO);
        auth()->user()->hasPermiso('read');

        try{
            return new CustomerListResource($customer);
        } catch(\Throwable $th){
            throw new SomethingWentWrong($th);
        }
    }

        /**
     * @OA\Post(
     *     tags={"Customer"},
     *     path="/api/customer",
     *     description="Create a new customer",
     *     security={{"token": {}}},
     *     operationId="customer_create",
     * @OA\RequestBody(
     *    required=true,
     *     @OA\MediaType(mediaType="multipart/form-data",
     *       @OA\Schema( required={"first_name", "last_name", },
     *                  @OA\Property(property="first_name", type="string", description="customer name", example="Pedro Manuel"),
     *                  @OA\Property(property="last_name", type="string", description="Customer last name", example="Martinez Perez"),
     *                  @OA\Property(property="phone", type="string", description="customer phone", example="809-555-99999"),
     *                  @OA\Property(property="email", type="string", description="Customer Email", example="customer1@test.com"),
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
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        try{
            $customer = New Customer();
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->phone = $request->phone;
            $customer->email = $request->email;
            $customer->save();

            return new CustomerListResource($customer);
        } catch (\Throwable $th){
            throw new SomethingWentWrong($th);
        }
    }

    
        /**
     * @OA\Post(
     *     tags={"Customer"},
     *     path="/api/customer/{customer}/update",
     *     description="Update a customer",
     *     security={{"token": {}}},
     *     operationId="customer_update",
     *      *  @OA\Parameter(
     *          name="customer",
     *          in="path",
     *          description="customer id",
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
     *       @OA\Schema( required={"first_name", "last_name", },
     *                  @OA\Property(property="first_name", type="string", description="customer name", example="Pedro Manuel"),
     *                  @OA\Property(property="last_name", type="string", description="Customer last name", example="Martinez Perez"),
     *                  @OA\Property(property="phone", type="string", description="customer phone", example="809-555-99999"),
     *                  @OA\Property(property="email", type="string", description="Customer Email", example="customer1@test.com"),
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

     public function update(Customer $customer, Request $request){
        auth()->user()->hasModulo(self::MODULO);
        auth()->user()->hasPermiso('create');

        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        try{
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->phone = $request->phone;
            $customer->email = $request->email;
            $customer->save();

            return new CustomerListResource($customer);
        } catch (\Throwable $th){
            throw new SomethingWentWrong($th);
        }
     }

         /**
     * @OA\Delete(
     *     tags={"Customer"},
     *     path="/api/customer/{customer}/delete",
     *     description="Delete a Customer",
     *     security={{"token": {}}},
     *     operationId="customer_delete",
     * @OA\Parameter(
     *          name="customer",
     *          in="path",
     *          description="customer id",
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
    public function destroy(Customer $customer){
        auth()->user()->hasModulo(self::MODULO);
        auth()->user()->hasPermiso('destroy');
        try {

            $customer->delete();
            return $this->deleted();
        } catch (\Throwable $th) {
            throw new SomethingWentWrong($th);
        }
    }
}
