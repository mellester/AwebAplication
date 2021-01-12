<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
        //
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
    public function edit($id)
    {
        //
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
        $data = $request->validateWithBag(
            'updateProduct',
            [
                'status' => 'required|string'
            ],
        );
        $product->update($data);
        return Redirect::back();
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
