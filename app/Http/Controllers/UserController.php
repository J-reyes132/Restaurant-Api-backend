<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Role;
use Illuminate\Http\Request;

use App\Tools\ResponseCodes;
use App\Http\Resources\UserResource;
use App\Exceptions\SomethingWentWrong;
use App\Exceptions\SameUser;
use Carbon\Carbon;

class UserController extends Controller
{

    public const MODULO = 'usuarios';

    /**
     * @OA\Get(
     *     tags={"Usuarios"},
     *     path="/api/usuarios",
     *     description="Listado de Usuarios",
     *     security={{"token": {}}},
     *     operationId="usuarios_usuarios_index",
     * @OA\Parameter(
     *          name="activo",
     *          in="query",
     *          description="Si todos los usuarios o solo los activos, si pasan cualquier valor solo retorna los usuarios activos",
     *          required=false,
     *          @OA\Schema(
     *              type="boolean",
     *              example="true",
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
        auth()->user()->hasModulo(self::MODULO);
        auth()->user()->hasPermiso('read');

        try {
            $usuarios = User::activos($request->activo)->get();
            return UserResource::collection($usuarios);
        } catch (\Throwable $th) {
            throw new SomethingWentWrong($th);
        }
    }

    /**
     * @OA\Post(
     *     tags={"Usuarios"},
     *     path="/api/usuarios/store",
     *     description="Crear un nuevo usuario",
     *     security={{"token": {}}},
     *     operationId="usuarios_usuarios_store",
     * @OA\RequestBody(
     *    required=true,
     *     @OA\MediaType(mediaType="multipart/form-data",
     *       @OA\Schema( required={"nombre","email","role","institution_id","password","password_confirmation"},
     *                  @OA\Property(property="nombre", type="string", description="Nombre del usuario", example="Juan Perez"),
     *                  @OA\Property(property="email", type="string", description="Email del usuario", example="user@email.aqui"),
     *                  @OA\Property(property="role", type="integer", description="Role ID a asignar", example="1"),
     *                  @OA\Property(property="institution_id", type="integer", description="Institution ID a asignar", example="1"),
     *                  @OA\Property(property="telefono", type="string", description="Telefono Contacto", example="(999) 555-5555"),
     *                  @OA\Property(property="movil", type="string", description="Movil Contacto", example="(999) 444-3333"),
     *                  @OA\Property(property="password", type="string", description="Password", example="SuperStrongPasswordHere"),
     *                  @OA\Property(property="password_confirmation", type="string", description="Password Confirmation", example="SuperStrongPasswordHere"),
     *                  @OA\Property(property="imagen", type="string", format="binary"),
     *       ),
     *      ),
     *   ),
     * @OA\Response(
     *    response=201,
     *    description="Successful Stored",
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
        auth()->user()->hasModulo(self::MODULO);
        auth()->user()->hasPermiso('create');

        $this->validate($request, [
            'nombre'  => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'institution_id' => 'required',
            'password' => 'required|confirmed',
        ]);

        $imagen = $this->uploadGoogle($request, "imagen");

        $role = Role::findOrFail($request->role);

        try {
            $user = new User;
            $user->role_id = $role->id;
            $user->institution_id = $request->institution_id;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->email_verified_at = Carbon::now();
            $user->save();

            $profile = new Profile;
            $profile->user_id = $user->id;
            $profile->name = $request->nombre;
            $profile->phone = $request->telefono;
            $profile->movil = $request->movil;
            $profile->image_url = $imagen['url'];
            $profile->image_publicId = $imagen['name'];
            $profile->image_size = $imagen['size'];
            $profile->image_ext = $imagen['ext'];
            $profile->save();

            $this->bitacora(self::MODULO, __METHOD__, $user->profile);

            return new UserResource($user);
        } catch (\Throwable $th) {
            throw new SomethingWentWrong($th);
        }
    }

    /**
     * @OA\Get(
     *     tags={"Usuarios"},
     *     path="/api/usuarios/{usuario}/show",
     *     description="Mostrar un usuario",
     *     security={{"token": {}}},
     *     operationId="usuarios_usuarios_show",
     * @OA\Parameter(
     *          name="usuario",
     *          in="path",
     *          description="Id del usuario",
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
    public function show(User $usuario)
    {
        return new UserResource($usuario);
    }


    /**
     * @OA\Post(
     *     tags={"Usuarios"},
     *     path="/api/usuarios/{usuario}/update",
     *     description="Actualizar un usuario",
     *     security={{"token": {}}},
     *     operationId="usuarios_usuarios_update",
     * @OA\Parameter(
     *          name="usuario",
     *          in="path",
     *          description="Id del usuario",
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
     *       @OA\Schema( required={"nombre","role","institution_id"},
     *                  @OA\Property(property="nombre", type="string", description="Nombre del usuario", example="Juan Perez"),
     *                  @OA\Property(property="email", type="string", description="Email del usuario", example="user@email.aqui"),
     *                  @OA\Property(property="role", type="integer", description="Role ID Asignado", example="1"),
     *                  @OA\Property(property="institution_id", type="integer", description="Institution ID Asignado", example="1"),
     *                  @OA\Property(property="telefono", type="string", description="Telefono Contacto", example="(999) 555-5555"),
     *                  @OA\Property(property="movil", type="string", description="Movil Contacto", example="(999) 444-3333"),
     *                  @OA\Property(property="imagen", type="string", format="binary"),
     *       ),
     *      ),
     *   ),
     * @OA\Response(
     *    response=201,
     *    description="Successful Stored",
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
    public function update(Request $request, User $usuario)
    {
        auth()->user()->hasModulo(self::MODULO);
        auth()->user()->hasPermiso('update');

        $this->validate($request, [
            'nombre'  => 'required',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'role' => 'required',
            'institution_id' => 'required',
        ]);

        if (isset($request->imagen)) {
            $this->destroyGoogle($usuario->profile->image_publicId);
            $imagen = $this->uploadGoogle($request, "imagen");
        }

        $role = Role::findOrFail($request->role);

        try {
            $usuario->role_id = $role->id;
            $usuario->institution_id = $request->institution_id;
            $usuario->email = $request->email;
            $usuario->save();

            $usuario->profile->name = $request->nombre;
            $usuario->profile->phone = $request->telefono;
            $usuario->profile->movil = $request->movil;
            if (isset($request->imagen)) {
                $usuario->profile->image_url = $imagen['url'];
                $usuario->profile->image_publicId = $imagen['name'];
                $usuario->profile->image_size = $imagen['size'];
                $usuario->profile->image_ext = $imagen['ext'];
            }
            $usuario->profile->save();
            $this->bitacora(self::MODULO, __METHOD__, $usuario->profile);
            return new UserResource($usuario);
        } catch (\Throwable $th) {
            throw new SomethingWentWrong($th);
        }
    }

    /**
     * @OA\Post(
     *     tags={"Usuarios"},
     *     path="/api/usuarios/{usuario}/resetpassword",
     *     description="Reiniciar la clave de acceso de un usuario",
     *     security={{"token": {}}},
     *     operationId="usuarios_usuarios_resetPassword",
     * @OA\Parameter(
     *          name="usuario",
     *          in="path",
     *          description="Id del usuario",
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
     *       @OA\Schema( required={"password","password_confirmation"},
     *                  @OA\Property(property="password", type="string", description="Password", example="TheNewSuperPassword"),
     *                  @OA\Property(property="password_confirmation", type="string", description="Password Confirmation", example="TheNewSuperPassword"),
     *       ),
     *      ),
     *   ),
     * @OA\Response(
     *    response=201,
     *    description="Successful Stored",
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
    public function resetPassword(Request $request, User $usuario)
    {
        auth()->user()->hasModulo(self::MODULO);
        auth()->user()->hasPermiso('update');

        $this->validate($request, [
            'password' => 'required|confirmed',
        ]);

        if ($usuario->id == auth()->user()->id) {
            throw new SameUser;
        } else {
            try {
                $usuario->password = bcrypt($request->password);
                $usuario->save();
                $this->bitacora(self::MODULO, __METHOD__, $usuario->profile);
                return response()->json(['status' => 'Successful', 'message' => 'Password cambiado'], ResponseCodes::OK);
            } catch (\Throwable $th) {
                throw new SomethingWentWrong($th);
            }
        }
    }


    /**
     * @OA\Delete(
     *     tags={"Usuarios"},
     *     path="/api/usuarios/{usuario}/delete",
     *     description="Borrar un usuario",
     *     security={{"token": {}}},
     *     operationId="usuarios_usuarios_destroy",
     * @OA\Parameter(
     *          name="user",
     *          in="path",
     *          description="Id del usuario",
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
    public function destroy(User $user)
    {
        auth()->user()->hasModulo(self::MODULO);
        auth()->user()->hasPermiso('destroy');

        if ($user->id == auth()->user()->id) {
            throw new SameUser;
        } else {
            $this->bitacora(self::MODULO, __METHOD__, $user->profile);
            $user->delete();
            return $this->deleted();
        }
    }

    /**
     * @OA\Post(
     *     tags={"Usuarios"},
     *     path="/api/usuarios/{usuario}/toggle",
     *     description="Activar o des-activar un usuario",
     *     security={{"token": {}}},
     *     operationId="usuarios_usuarios_toggle",
     * @OA\Parameter(
     *          name="usuario",
     *          in="path",
     *          description="Id del usuario",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="integer",
     *              example="1",
     *          )
     *      ),
     * @OA\Response(
     *    response=201,
     *    description="Successful Activated or Deactivated",
     *    @OA\JsonContent(@OA\Property(property="data", type="Json", example="[...]"),
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
    public function toggle(User $usuario)
    {
        auth()->user()->hasModulo(self::MODULO);
        auth()->user()->hasPermiso('update');

        if ($usuario->id == auth()->user()->id) {
            throw new SameUser;
        } else {
            try {
                $usuario->active ? $usuario->active = false : $usuario->active = true;
                $usuario->save();
                $this->bitacora(self::MODULO, __METHOD__, $usuario);
                return new UserResource($usuario);
            } catch (\Throwable $th) {
                throw new SomethingWentWrong($th);
            }
        }
    }
}