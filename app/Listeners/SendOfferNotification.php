<?php

namespace App\Listeners;

use App\Events\ProductOfferUpdated;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Exceptions\Handler;
use App\Jobs\ProcessOffer;
use App\Models\Messages;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Throwable;

class SendOfferNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProductOfferUpdated  $event
     * @return void
     */
    public function handle(ProductOfferUpdated $event)
    {

        $user_id = Product::find($event->offer->product_id)->user_id;
        Messages::create([
            'to_user_id' => $user_id,
            'from_user_id' => $event->offer->user_id,
            'message' => json_encode([
                get_class($event) => $event->offer,
            ]),
        ])->save();
        try {
            ProcessOffer::dispatch($event->offer);
        } catch (Throwable $e) {
            // error_log('catch a error');
            //Log::critical('Error  ' . $e->getMessage());
            //error_log($e->getMessage());
        }
    }
}
