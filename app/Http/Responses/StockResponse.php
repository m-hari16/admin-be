<?php

namespace App\Http\Responses;

use Illuminate\Http\Resources\Json\JsonResource;

class StockResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $product = [
            'id' => $this->hasProduct->id,
            'product_code' => $this->hasProduct->code,
            'name' => $this->hasProduct->name,
            'uom' => $this->hasProduct->uom,
        ];

        return [
            'id' => $this->id,
            'stock' => (float)$this->qty,
            'product' => $product,
            'created_at' => $this->created_at,
        ];
    }
}
