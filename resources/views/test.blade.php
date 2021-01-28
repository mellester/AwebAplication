


<?php

use App\Events\ProductOfferUpdated;
use App\Models\UserOffer;
use Illuminate\Support\Facades\DB;

dump("database.default\n" . config('database.default'));
dump(config('database.connections'));
dump("queue.default\n" . config('queue.default'));
dump(config('queue.connections'));


dd(ProductOfferUpdated::dispatch(UserOffer::find(1)));
?>