<?php

namespace App\Http\Controllers;

use App\Events\ProductOfferUpdated;
use App\Models\Product;
use App\Models\UserOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class UserOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $product = $product->load('UserOffers');
        // dd($product);
        return Inertia::render(
            'products/UserOffer',
            compact('product')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        dd($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        // dd(true);
        $validator = Validator::make($request->all(), UserOffer::ValidatorRules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        $maxPrice = ($product->UserOffers()->max('price'));
        if ($validator->validated()['price'] <= $maxPrice) {
            return redirect()->back()->withErrors("The offer you made is lower than the current highest offer");
        }
        $ret = $product->UserOffers()->create(
            array_merge(
                $validator->validated(),
                ['user_id' => Auth::user()->id]
            )
        );
        ProductOfferUpdated::dispatch($ret);
        return Redirect()->back()->with('success', 'Successfully created a new offer for this product');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserOffer  $userOffer
     * @return \Illuminate\Http\Response
     */
    public function show(UserOffer $userOffer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserOffer  $userOffer
     * @return \Illuminate\Http\Response
     */
    public function edit(UserOffer $userOffer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserOffer  $userOffer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserOffer $userOffer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserOffer  $userOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserOffer $userOffer)
    {
        //
    }
}
