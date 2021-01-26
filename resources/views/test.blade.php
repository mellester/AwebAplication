


<?php

use App\Events\ProductOfferUpdated;
use App\Models\UserOffer;
use Illuminate\Support\Facades\DB;

dd(ProductOfferUpdated::dispatch(UserOffer::find(1)));
?>