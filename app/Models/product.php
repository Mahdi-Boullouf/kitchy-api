<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $fillable = ['name','description','stock','price','net_price','active'];
    protected $casts = [
        'active' => 'boolean',
        'price' => 'integer',
        'net_price' => 'integer',
    ];
    public function colors() { return $this->belongsToMany(Color::class); }
    public function images() { return $this->hasMany(ProductImage::class)->orderBy('sort_order'); }
}