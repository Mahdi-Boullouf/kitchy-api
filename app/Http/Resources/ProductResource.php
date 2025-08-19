<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource {
    public function toArray($request){
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->description,
            'stock'=>$this->stock,
            'price'=>$this->price,
            'net_price'=>$this->net_price,
            'active'=>$this->active,
            'colors'=>$this->whenLoaded('colors', fn()=> $this->colors->map(fn($c)=>['id'=>$c->id,'name'=>$c->name,'hex'=>$c->hex])),
            'images'=>ProductImageResource::collection($this->whenLoaded('images')),
            'created_at'=>$this->created_at,
        ];
    }
}