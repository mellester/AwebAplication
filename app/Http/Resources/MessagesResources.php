<?php

namespace App\Http\Resources;

use App\Models\Messages;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Request;

class MessagesResources extends ResourceCollection
{
    public function __construct($user, Request $request)
    {
        $all = Messages::where('to_user_id', $user->id)->get();
        parent::__construct($all);
    }
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
