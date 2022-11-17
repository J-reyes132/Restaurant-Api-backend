<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\SomethingWentWrong;
use App\Http\Resources\EmployeeListResource;
use App\Models\Employee;


class EmployeeController extends Controller
{

    //
    public const MODULO = 'empleados';
    /**
 * @OA\Get(
 *     tags={"Employee"},
 *     path="/api/employee",
 *     description="List employees",
 *     security={{"token": {}}},
 *     operationId="employee_list",
 *  @OA\Parameter(
 *          name="name",
 *          in="query",
 *          description="employee name",
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
 *          description="employee name",
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
        $employee = Employee::name($request->name)
          ->paginate($request->perPage ?? env('PAGINATE'));
        
        return EmployeeListResource::collection($employee);
    } catch (\Throwable $th){
        throw new SomethingWentWrong($th);
    }
 }

         /**
 * @OA\Get(
 *     tags={"Employee"},
 *     path="/api/employee/{employee}/show",
 *     description="show a employee",
 *     security={{"token": {}}},
 *     operationId="employee_show",
 *  @OA\Parameter(
 *          name="employee",
 *          in="path",
 *          description="employee id",
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
public function show(Employee $employee){
    auth()->user()->hasModulo(self::MODULO);
    auth()->user()->hasPermiso('read');

    try{
        return new EmployeeListResource($employee);
    } catch(\Throwable $th){
        throw new SomethingWentWrong($th);
    }
}

    /**
 * @OA\Post(
 *     tags={"Employee"},
 *     path="/api/employee",
 *     description="Create a new employee",
 *     security={{"token": {}}},
 *     operationId="employee_create",
 * @OA\RequestBody(
 *    required=true,
 *     @OA\MediaType(mediaType="multipart/form-data",
 *       @OA\Schema( required={"first_name", "last_name", },
 *                  @OA\Property(property="first_name", type="string", description="employee name", example="Pedro Manuel"),
 *                  @OA\Property(property="last_name", type="string", description="Employee last name", example="Martinez Perez"),
 *                  @OA\Property(property="phone", type="string", description="employee phone", example="809-555-99999"),
 *                  @OA\Property(property="email", type="string", description="Employee Email", example="employee1@test.com"),
 *                  @OA\Property(property="address", type="string", description="Employee address", example="address example #1"),
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
        'last_name' => 'required',
        'phone' => 'required',
        'address' => 'required'
    ]);

    try{
        $employee = New Employee();
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->address = $request->address;
        $employee->save();

        return new EmployeeListResource($employee);
    } catch (\Throwable $th){
        throw new SomethingWentWrong($th);
    }
}


    /**
 * @OA\Post(
 *     tags={"Employee"},
 *     path="/api/employee/{employee}/update",
 *     description="Update a employee",
 *     security={{"token": {}}},
 *     operationId="employee_update",
 *      *  @OA\Parameter(
 *          name="employee",
 *          in="path",
 *          description="employee id",
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
 *       @OA\Schema( required={"first_name", "last_name","phone","address" },
 *                  @OA\Property(property="first_name", type="string", description="employee name", example="Pedro Manuel"),
 *                  @OA\Property(property="last_name", type="string", description="Employee last name", example="Martinez Perez"),
 *                  @OA\Property(property="phone", type="string", description="employee phone", example="809-555-99999"),
 *                  @OA\Property(property="email", type="string", description="Employee Email", example="employee1@test.com"),
 *                  @OA\Property(property="address", type="string", description="Employee address", example="address example #1"),
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

 public function update(Employee $employee, Request $request){
    auth()->user()->hasModulo(self::MODULO);
    auth()->user()->hasPermiso('create');

    $this->validate($request, [
        'first_name' => 'required',
        'last_name' => 'required',
        'phone' => 'required',
        'address' => 'required'
    ]);

    try{
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->address = $request->address;
        $employee->save();

        return new EmployeeListResource($employee);
    } catch (\Throwable $th){
        throw new SomethingWentWrong($th);
    }
 }

     /**
 * @OA\Delete(
 *     tags={"Employee"},
 *     path="/api/employee/{employee}/delete",
 *     description="Delete a Employee",
 *     security={{"token": {}}},
 *     operationId="employee_delete",
 * @OA\Parameter(
 *          name="employee",
 *          in="path",
 *          description="employee id",
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
public function destroy(Employee $employee){
    auth()->user()->hasModulo(self::MODULO);
    auth()->user()->hasPermiso('destroy');
    try {

        $employee->delete();
        return $this->deleted();
    } catch (\Throwable $th) {
        throw new SomethingWentWrong($th);
    }
}
}
