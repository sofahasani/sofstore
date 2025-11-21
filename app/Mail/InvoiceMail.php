<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $invoiceNumber;
    public $orderDate;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad($order->id, 4, '0', STR_PAD_LEFT);
        $this->orderDate = $order->created_at->format('d F Y, H:i');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('merbabuakun@gmail.com', 'Project Wahab Store'),
            subject: '🎉 Invoice Pembelian - ' . $this->invoiceNumber,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice',
            with: [
                'order' => $this->order,
                'invoiceNumber' => $this->invoiceNumber,
                'orderDate' => $this->orderDate,
            ]
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
