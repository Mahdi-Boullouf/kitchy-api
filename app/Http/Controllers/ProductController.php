<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductController extends Controller {
       public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // max 5MB
        ]);

        $file = $request->file('image');
        $path = $file->store('products', 'public');

        return response()->json([
            'success' => true,
            'url' => Storage::url($path)
        ]);
    }
    public function index(Request $request) {
        $q = Product::with(['images','colors'])
            ->when($request->filled('active'), fn($x)=>$x->where('active', (bool)$request->boolean('active')))
            ->paginate($request->integer('per_page', 15));
        return ProductResource::collection($q);
    }

    public function show(Product $product){
        $product->load(['images','colors']);
        return new ProductResource($product);
    }

    public function store(ProductStoreRequest $req){
        $data = $req->validated();
        $product = Product::create(Arr::only($data, ['name','description','stock','price','net_price','active']));
        if (!empty($data['colors'])) $product->colors()->sync($data['colors']);
        if (!empty($data['images'])) {
            foreach($data['images'] as $img){ $product->images()->create($img); }
        }
        return (new ProductResource($product->load(['images','colors'])))->response()->setStatusCode(201);
    }

    public function update(ProductUpdateRequest $req, Product $product){
        $data = $req->validated();
        $product->update(Arr::only($data, ['name','description','stock','price','net_price','active']));
        if (array_key_exists('colors',$data)) $product->colors()->sync($data['colors'] ?? []);
        if (array_key_exists('images',$data)) {
            $product->images()->delete();
            foreach($data['images'] ?? [] as $img){ $product->images()->create($img); }
        }
        return new ProductResource($product->load(['images','colors']));
    }

    public function destroy(Product $product){
        $product->delete();
        return response()->json(['message'=>'deleted']);
    }
}