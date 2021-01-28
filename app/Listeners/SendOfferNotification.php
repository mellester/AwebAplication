<?php

namespace App\Listeners;

use App\Events\ProductOfferUpdated;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Exceptions\Handler;
use App\Jobs\ProcessOffer;
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
        try {
            ProcessOffer::dispatch($event->offer);
        } catch (Throwable $e) {
            // error_log('catch a error');
            //Log::critical('Error  ' . $e->getMessage());
            //error_log($e->getMessage());
        }
    }
}
