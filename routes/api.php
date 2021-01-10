<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\DashboardProduct;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CacheMiddleware;


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


Route::middleware(['auth:sanctum', 'cache:300'])->prefix('v1')->group(
    function () {
        Route::get('/DashboardProduct', function (Request $request) {
            return new DashboardProduct(Auth::user());
        });
    }
);
