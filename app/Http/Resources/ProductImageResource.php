<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductImageResource extends JsonResource {
    public function toArray($request){
        return [
            'id'=>$this->id,
            'path'=>$this->path,
            'is_primary'=>$this->is_primary,
            'sort_order'=>$this->sort_order,
        ];
    }
}