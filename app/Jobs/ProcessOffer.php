<?php

namespace App\Jobs;

use App\Mail\OrderOffer;
use App\Models\Product;
use App\Models\UserOffer;
use Illuminate\Bus\Queueable;
use Throwable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessOffer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $productOffer;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(UserOffer $productOffer)
    {
        $this->productOffer = $productOffer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->productOffer->product()->owner()->email;
        Mail::to($email)->send(new OrderOffer());
    }
}
