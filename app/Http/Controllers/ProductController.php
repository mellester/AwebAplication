<?php

namespace App\Http\Controllers;

use App\Enums\Duration;
use App\Enums\productStatus;
use App\Events\ProductPublished;
use App\Events\ProductUpdated;
use App\Models\Product;
use Facade\Ignition\DumpRecorder\Dump;
use Inertia\Inertia;


use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productlist = Product::where('status', '!=', 'notPublished')->with('owner:id,name')->orderBy('created_at')->paginate(50);
        return Inertia::render(
            'products/index',
            compact('productlist')
        );
    }

    /** 
     * Display a list of resources you own
     */
    public function indexYours()
    {
        $productlist = Product::where('user_id', Auth::user()->id)->orderBy('created_at')->paginate(50);
        return Inertia::render(
            'products/indexYours',
            compact('productlist')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = Product::find(1);
        unset($product->id);
        $mode = "new";
        return Inertia::render(
            'products/edit',
            compact('product', 'mode')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $product)
    {
        return Inertia::render(
            'products/show',
            compact('product')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //dd($product);
        return Inertia::render(
            'products/edit',
            compact('product')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // dd($product, $request);
        if ($product->user_id != Auth::user()->id) {
            return Redirect::back()->withErrors(['default' => 'You do not own this resource']);
        }
        $fillable = [];
        foreach ($product->getFillable() as $value) {
            // Creare a rule set that all fillable properties somtimes may be added
            $fillable[$value] = 'sometimes';
        }
        $data = $request->validateWithBag(
            'updateProduct',
            array_merge($fillable, [
                'status' => 'required|string',
            ]),
        );
        $product->update($data);
        ProductUpdated::dispatchIf(
            $product->wasChanged(),
            $product->id
        );
        if ($request->has('offer')) {
            $items = $request->input('offer');
            $it_1 = json_decode($items, TRUE) ?? [];
            $it_2 = json_decode($product->offer, TRUE) ?? [];
            $result_array = array_diff($it_1, $it_2);
            if (empty($result_array[0])) {
                // dump($result_array);
                // dump("We have a new offer ");
                $product->offer = $request->input('offer');
                // calls Product::setOfferAttribute
            } else {
                // dump("We do not have a new offer ");
            }
        }
        return Redirect::away(route('product.show', $product, false));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
        return Redirect::away(route('product.indexYours', [], false));
    }

    /**
     * show the for to Publish the resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPublish(Product $product)
    {
        return Inertia::render(
            'products/publish',
            compact('product')
        );
    }
    /**
     * show the for to Offer page
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function offer(Product $product)
    {
        return Inertia::render(
            'products/offer',
            compact('product')
        );
    }
}
