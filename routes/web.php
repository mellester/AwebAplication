<?php

use App\Enums\productStatus;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserOfferController;
use App\Http\Middleware\AllowProxy;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\DashboardProduct;
use App\Models\Messages;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\DB;

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
    $PublishedProductApi = Route::dispatch(Request::create('api/v1/PublishedProduct'))->getData();
    Inertia\Inertia::setRootView('app');
    return Inertia\Inertia::render('Index', compact('PublishedProductApi'));
})->name('landinpage');

Route::get('/chat', function () {
    Inertia\Inertia::setRootView('app');
    return Inertia\Inertia::render('chat');
})->name('chat');


Route::get('/Paginate', function () {
    $PublishedProductApi = Route::dispatch(Request::create('api/v1/PublishedProduct'))->getData();
    Inertia\Inertia::setRootView('app');
    return Inertia\Inertia::render('Paginate', compact('PublishedProductApi'));
})->name('paginate');


Route::middleware(['auth:sanctum', 'verified', AllowProxy::class])->group(function () {
    Route::resource('message', MessagesController::class);
    Route::resource('user', UserController::class);
    Route::get('/dashboard', function (Request $request) {
        $request->user = Auth::user();
        $productinfoApi = Route::dispatch(Request::create('/api/v1/DashboardProduct'))->getData();
        // dump(compact('productInfo'));
        return Inertia\Inertia::render(
            'Dashboard',
            compact('productinfoApi')
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
