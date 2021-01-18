<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\DashboardProduct;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

Route::get('/', function () {
    Inertia\Inertia::setRootView('app');
    return Inertia\Inertia::render('Index');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function (Request $request) {
        $request->user = Auth::user();
        $productinfo = Route::dispatch(Request::create('/api/v1/DashboardProduct'))->getData()->data;
        //dump($productinfo);
        return Inertia\Inertia::render(
            'Dashboard',
            compact('productinfo')
        );
    })->name('dashboard');
    Route::get('product/indexYours', [ProductController::class, 'indexYours'])
        ->name('product.indexyours');
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
    $user = auth()->user() ?? User::find(1);
    $request->user = $user;
    dd((new DashboardProduct(Auth::user() ?? User::find(1)))->toArray($request));

    return view('test');
});
