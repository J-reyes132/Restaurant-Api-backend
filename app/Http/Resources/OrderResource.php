<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_date' => $this->order_date,
            'quantity' => $this->quantity,
            'table' => $this->table ?? null,
            'customer' => $this->customer ?? null,
            'product' => $this->product ?? null,
            'menu' => $this->menu,
            
        ];
    }
}
