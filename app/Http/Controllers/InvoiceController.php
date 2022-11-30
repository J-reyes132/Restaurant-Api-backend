<?php

namespace App\Http\Controllers;

use App\Exceptions\SomethingWentWrong;
use App\Http\Resources\InvoiceListResource;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
        /**
* @OA\Get(
*     tags={"Invoice"},
*     path="/api/invoice",
*     description="List invoices",
*     security={{"token": {}}},
*     operationId="invoice_list",
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
        $invoice = Invoice::groupBy('customer_id')->selecRaw('sum(total) as total')
          ->paginate($request->perPage ?? env('PAGINATE'));

        return InvoiceListResource::collection($invoice);
    } catch (\Throwable $th){
        throw new SomethingWentWrong($th);
    }
  }

}
