<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = ['full_name','mobile_number','wilaya','commune','exact_address','status','hidden','subtotal','total'];
    protected $casts = [ 'hidden'=>'boolean','subtotal'=>'integer','total'=>'integer' ];
    public function items(){ return $this->hasMany(OrderItem::class); }
}