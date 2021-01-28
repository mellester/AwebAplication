<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\UserOffer;

class OrderOffer extends Mailable
{
    use Queueable, SerializesModels;
    public $productOffer;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->productOffer = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $productOffer = $this->productOffer;
        return $this->from('example@example.com')->view('emails.orderOffer',  compact('productOffer'));
    }
}
