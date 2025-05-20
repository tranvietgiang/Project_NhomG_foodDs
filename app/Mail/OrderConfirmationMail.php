<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cart;

    public function __construct($cart)
    {
        $this->cart = $cart;
    }

    public function build()
    {
        return $this->subject('Xác nhận đơn hàng của bạn')
            ->markdown('emails.order.confirmation')
            ->with('cart', $this->cart);
    }
}
