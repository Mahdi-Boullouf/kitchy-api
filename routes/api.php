<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ColorController;


// Public authentication endpoints
Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the API!']);
});

Route::prefix('auth')->group(function(){
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('me', [AuthController::class, 'me']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});


// Public product endpoints (GET one/all)
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{product}', [ProductController::class, 'show']);

// Admin-protected product CRUD
Route::middleware('auth:sanctum')->group(function(){

Route::apiResource('colors', ColorController::class);
    Route::post('products', [ProductController::class, 'store']);
    Route::put('products/{product}', [ProductController::class, 'update']);
    Route::delete('products/{product}', [ProductController::class, 'destroy']);
    Route::post('products/upload-image', [ProductController::class, 'uploadImage']);

    // Orders management
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{order}', [OrderController::class, 'show']);
    Route::put('orders/{order}', [OrderController::class, 'update']);
    Route::delete('orders/{order}', [OrderController::class, 'destroy']);
});

// Public create order (customers can place orders without auth)
Route::post('orders', [OrderController::class, 'store']);

?>