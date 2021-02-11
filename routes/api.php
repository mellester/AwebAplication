<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\DashboardProduct;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CacheMiddleware;
use App\Http\Resources\apiResourcCollection;
use App\Http\Resources\apiResource;
use App\Http\Resources\PublishedProduct;
use App\Models\Messages;
use App\Models\Product;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Validator;

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
        Route::get('/getResource', function (Request $request) {
            Auth::check();
            $validator = FacadesValidator::make($request->all(), [
                'resourceName' => 'required',
                'resourceId' => 'required',
            ]);
            $errors = $validator->errors();
            if ($validator->fails()) {
                throw new Exception($errors);
            }
            $resourceName = $request->get('resourceName');
            $resourceId = $request->get('resourceId');
            return new apiResource(Auth::user(), compact('resourceName', 'resourceId'));
        })->name('getResource');
        Route::get('/getResourceCollection', function (Request $request) {
            Auth::check();
            $validator = FacadesValidator::make($request->all(), [
                'resourceName' => 'required',
                'resourceIds' => 'required',
            ]);
            $errors = $validator->errors();
            if ($validator->fails()) {
                throw new Exception($errors);
            }
            $resourceName = $request->get('resourceName');
            $resourceIds = $request->get('resourceIds');
            return new apiResourcCollection(Auth::user(), compact('resourceName', 'resourceIds'));
        })->name('getResourceCollection');

        Route::get('/getMessages', function (Request $request) {
            return new MessagesResources(Auth::user(), $request);
        })->name('Messages');
    }
);

Route::prefix('v1')->group(function () {
});
