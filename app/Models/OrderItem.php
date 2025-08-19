<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {
    protected $fillable=['order_id','product_id','quantity','price','net_price','color_id'];
    public function order(){ return $this->belongsTo(Order::class); }
    public function product(){ return $this->belongsTo(Product::class);}
    public function color() {
        return $this->belongsTo(Color::class);
    }
    
    }
