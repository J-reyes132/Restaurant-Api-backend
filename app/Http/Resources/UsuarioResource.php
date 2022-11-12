<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioResource extends JsonResource
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
            'activo'  => $this->active ? true : false,
            'profile' => new ProfileResource($this->profile),
            'institution' => new InstitutionResource($this->institution)
        ];
    }
}