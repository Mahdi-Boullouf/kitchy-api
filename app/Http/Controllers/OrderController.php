<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;

class OrderController extends Controller {
    public function index(Request $request){
        $orders = Order::with(['items.product'])->latest()->paginate($request->integer('per_page', 15));
        return OrderResource::collection($orders);
    }

    public function show(Order $order){
        $order->load(['items.product']);
        return new OrderResource($order);
    }

    public function store(OrderStoreRequest $req){
        $payload = $req->validated();
        DB::beginTransaction();
        try {
            $order = Order::create(Arr::only($payload, ['full_name','mobile_number','wilaya','commune','exact_address','status','hidden']));

            $subtotal = 0; $total = 0;
            foreach($payload['items'] as $item){
                $product = Product::findOrFail($item['product_id']);
                $qty = $item['quantity'];
                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price' => $product->price,
                    'net_price' => $product->net_price,
                ]);
                $subtotal += $product->price * $qty;
            }
            $total = $subtotal; // add delivery/discount logic here later
            $order->update(['subtotal'=>$subtotal,'total'=>$total]);

            DB::commit();
            return (new OrderResource($order->load('items.product')))->response()->setStatusCode(201);
        } catch (Throwable $e) {
            DB::rollBack();
            report($e);
            return response()->json(['message'=>'order_failed'], 422);
        }
    }

    public function update(OrderUpdateRequest $req, Order $order){
        $order->update($req->validated());
        return new OrderResource($order->load('items.product'));
    }

    public function destroy(Order $order){
        $order->delete();
        return response()->json(['message'=>'deleted']);
    }
}