<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class InternalApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'pathInfo' => $request->path(),
            'retrieved_on' => Carbon::now('UTC'),
            'data' => $this->itsData($request),
        ];
        return $data;
    }
}
