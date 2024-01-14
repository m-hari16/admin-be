<?php

namespace App\Http\Responses;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResponse extends JsonResource
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
            'purchase_code' => $this->code,
            'qty' => (float)$this->qty,
            'price' => (float)$this->price ?? 0,
            'isRelease' => boolval($this->isRelease),
            'product' => $product,
            'created_at' => $this->created_at,
        ];
    }
}
