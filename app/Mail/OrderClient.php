<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderClient extends Mailable
{
    use Queueable, SerializesModels;

    public array $cart;
    public int $total;
    public int $order_id;
    public string $note;

    /**
     * Create a new message instance.
     */
    public function __construct(array $cart, int $total, int $order_id, string $note = '')
    {
        $this->cart = $cart;
        $this->total = $total;
        $this->order_id = $order_id;
        $this->note = $note;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('no-reply@laravel-myavka.ru', 'Магазин'), // Используем правильный домен
            subject: "Заказ #{$this->order_id}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.order-client',
            with: [
                'cart' => $this->cart,
                'total' => $this->total,
                'order_id' => $this->order_id,
                'note' => $this->note,
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
