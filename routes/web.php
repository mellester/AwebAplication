<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserOfferController;
use App\Http\Middleware\AllowProxy;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\DashboardProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Broadcast::routes();

Route::get('/', function () {
    $productsPaginate = Product::paginate(15);
    Inertia\Inertia::setRootView('app');
    return Inertia\Inertia::render('Index', compact('productsPaginate'));
})->name('landinpage');

Route::middleware(['auth:sanctum', 'verified', AllowProxy::class])->group(function () {
    Route::get('/dashboard', function (Request $request) {
        $request->user = Auth::user();
        $productInfo = Route::dispatch(Request::create('/api/v1/DashboardProduct'))->getData()->data;
        // dump(compact('productInfo'));
        return Inertia\Inertia::render(
            'Dashboard',
            compact('productInfo')
        );
    })->name('dashboard');
    Route::resource('product.userOffers', UserOfferController::class)->shallow();
    Route::get('product/indexYours', [ProductController::class, 'indexYours'])
        ->name('product.indexYours');
    Route::get('product/Publish/{product:id}', [ProductController::class, 'editPublish'])
        ->name('product.publish');
    Route::resource('product', ProductController::class, ['except' => [
        'index', 'show'
    ]]);
});
Route::resource('product', ProductController::class, ['only' => [
    'index', 'show'
]]);

Route::get('/test', function (Request $request) {

    return view('test');
});
