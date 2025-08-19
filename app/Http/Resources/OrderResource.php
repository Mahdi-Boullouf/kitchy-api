<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource {
    public function toArray($request){
        return [
            'id'=>$this->id,
            'full_name'=>$this->full_name,
            'mobile_number'=>$this->mobile_number,
            'wilaya'=>$this->wilaya,
            'commune'=>$this->commune,
            'exact_address'=>$this->exact_address,
            'status'=>$this->status,
            'hidden'=>$this->hidden,
            'subtotal'=>$this->subtotal,
            'total'=>$this->total,
            'items'=>OrderItemResource::collection($this->whenLoaded('items')),
            'created_at'=>$this->created_at,
        ];
    }
}