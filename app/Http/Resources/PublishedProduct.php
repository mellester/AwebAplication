<?php

namespace App\Http\Resources;

use App\Enums\productStatus;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PublishedProduct extends InternalApiResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return Product::where('status', productStatus::Published)
            ->where('offer_at', '<', Carbon::now('UTC'))
            ->Where(function ($query) {
                $query->where('offer_until', '<', Carbon::now('UTC'))
                    ->orWhere('offer_until', null);
            })->paginate(3)->withPath($request->path());
    }
}
