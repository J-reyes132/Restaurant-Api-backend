<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            // No mostramos id por que no es usado
            // 'id'  => $this->id,
            'email' => $this->user->email,
            'nombre' => $this->name,
            'imagen' => $this->image_url,
            'telefono' => $this->phone,
            'movil' => $this->movil,
        ];
    }
}
