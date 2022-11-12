<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResourceLogin extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'  => $this->id,
            'email'  => $this->email,
            'activo'  => $this->active ? true : false,
            'role'  => new RoleResource($this->role),
            'modulos' => RoleModuloResource::collection($this->role->modulos),
            'permisos' => RolePermisoResource::collection($this->role->permisos),
        ];
    }
}