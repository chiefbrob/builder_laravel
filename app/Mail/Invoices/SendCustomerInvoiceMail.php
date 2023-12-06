<?php

namespace App\Mail\Invoices;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendCustomerInvoiceMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Invoice $invoice;

    /**
     * Create a new message instance.
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function build()
    {
        return $this->view('emails.invoices.customer-invoice-mail')
            ->from(config('app.email'))
            ->to($this->invoice->user->email)
            ->subject('Order '  . $this->invoice->reference . ' received')
            ->with('invoice', $this->invoice);
    }
}
