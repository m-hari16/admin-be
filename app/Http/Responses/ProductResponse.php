<?php

namespace App\Http\Responses;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $category = [
            'id' => $this->hasCategory->id,
            'role_name' => $this->hasCategory->name
        ];

        return [
            'id' => $this->id,
            'product_code' => $this->code,
            'product_name' => $this->name,
            'specification' => json_decode($this->specification),
            'uom' => $this->uom,
            'isActive' => $this->isActive,            
            'category' => $category,
            'stock' => (float)$this->hasStock->qty ?? 0,
            'created_at' => $this->created_at,
        ];
    }
}
