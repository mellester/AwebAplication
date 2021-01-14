<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Facade\Ignition\DumpRecorder\Dump;
use Inertia\Inertia;


use Illuminate\Http\Request;
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
        dd($product, $request);
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
        return Redirect::route('product.show', $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
