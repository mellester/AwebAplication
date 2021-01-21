<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UserOffer;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        dd($request);
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
