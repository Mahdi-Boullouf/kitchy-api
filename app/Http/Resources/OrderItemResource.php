<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource {
    public function toArray($request){
        return [
            'product_id' => $this->product_id,
            'quantity'   => $this->quantity,
            'price'      => $this->price,
            'net_price'  => $this->net_price,

            'product'    => $this->whenLoaded('product', fn() => [
                'id'   => $this->product->id,
                'name' => $this->product->name
            ]),

            'color'      => $this->whenLoaded('color', fn() => [
                'id'   => $this->color->id,
                'name' => $this->color->name
            ]),
        ];
    }
}