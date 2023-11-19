<?php

namespace App\Listeners\Invoices;

use App\Events\Invoices\InvoiceCreatedEvent;
use App\Mail\Invoices\SendCustomerInvoiceMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCustomerInvoiceNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(InvoiceCreatedEvent $event): void
    {
        Mail::to($event->invoice->user->email)
            ->queue(new SendCustomerInvoiceMail($event->invoice));
    }
}
