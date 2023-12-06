<?php

namespace App\Listeners\Invoices;

use App\Events\Invoices\InvoiceCreatedEvent;
use App\Events\Invoices\InvoiceCreatedEvent as InvoicesInvoiceCreatedEvent;
use App\Mail\Invoices\SendShopInvoiceMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendShopInvoiceNotification
{
    public function __construct()
    {
        //
    }

    public function handle(InvoiceCreatedEvent $event): void
    {
        Mail::to($event->invoice->user->email)
            ->queue(new SendShopInvoiceMail($event->invoice));
    }
}
