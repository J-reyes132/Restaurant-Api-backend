<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'  => $this->id,
            'email'  => $this->email,
            'image'  => $this->image_url,
            'activo'  => $this->active ? true : false,
            'role'  => new RoleResource($this->role),
            'profile' => new ProfileResource($this->profile),
            'modulos' => RoleModuloResource::collection($this->role->modulos),
            'permisos' => RolePermisoResource::collection($this->role->permisos),
        ];
    }
}