<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller 
{
public function index(Request $request)
{
    $orders = Order::with(['items.product', 'items.color'])
        ->when($request->query('status'), function ($query, $status) {
            $query->where('status', $status);
        })
        ->latest()
        ->get();

    return OrderResource::collection($orders);
}

    public function show(Order $order){
        $order->load(['items.product']);

        return new OrderResource($order);
    }
public function store(Request $request)
{
    $data = $request->validate([
        'full_name'     => 'required|string|max:255',
        'mobile_number' => 'required|string|max:20',
        'wilaya'        => 'required|string|max:255',
        'commune'       => 'required|string|max:255',
        'exact_address' => 'required|string|max:500',
        'status'        => 'nullable|string',
        'hidden'        => 'nullable|boolean',
        'items'         => 'required|array',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity'   => 'required|integer|min:1',
        'items.*.color_id'   => 'nullable|exists:colors,id',
    ]);

    $order = Order::create([
        'full_name'     => $data['full_name'],
        'mobile_number' => $data['mobile_number'],
        'wilaya'        => $data['wilaya'],
        'commune'       => $data['commune'],
        'exact_address' => $data['exact_address'],
        'status'        => $data['status'] ?? 'pending',
        'hidden'        => $data['hidden'] ?? false,
    ]);




    $subtotal = 0;


    foreach ($data['items'] as $item) {

        $product = Product::findOrFail($item['product_id']);
        $qty = $item['quantity'];

        $order->items()->create([
            'product_id' => $product->id,
            'quantity'   => $qty,
            'price'      => $product->price,
            'net_price'  => $product->net_price,
            'color_id'   => $item['color_id'] ?? null,
        ]);

        $subtotal += $product->price * $qty;
    }

    $order->update([
        'subtotal' => $subtotal,
        'total'    => $subtotal,
    ]);

    return response()->json([
        'message' => 'Order created successfully',
        'order_id' => $order->id
    ], 201);
}
    public function update(OrderUpdateRequest $req, Order $order){
        $order->update($req->validated());
       
        return new OrderResource($order->load([
    'items.product',
     'items.color',

]));
    }

    public function destroy(Order $order){
        $order->delete();
        return response()->json(['message'=>'deleted']);
    }
    public function clear(){
   Order::query()->delete();
        return response()->json(['message'=>'deleted']);


    }
}