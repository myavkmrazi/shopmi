<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderManager extends Mailable
{
    use Queueable, SerializesModels;

    public int $order_id;


    public function __construct(int $order_id)
    {
        $this->order_id = $order_id;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('no-reply@laravel-myavka.ru', 'Магазин'),
            subject: "Новый заказ #{$this->order_id}",
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'mail.order-manager',
            with: [
                'order_id' => $this->order_id,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

