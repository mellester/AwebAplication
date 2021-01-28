<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\DashboardProduct;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CacheMiddleware;
use App\Http\Resources\PublishedProduct;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['cache:300,true'])->prefix('v1')->group(
    function () {
        Route::get('/DashboardProduct', function (Request $request) {
            if (!Auth::guest()) {
                return new DashboardProduct(Auth::user());
            } else {
                return [];
            }
        });
        Route::get('/PublishedProduct', function () {
            return new PublishedProduct(Product::find(1));
        });
    }
);

Route::prefix('v1')->group(function () {
});
