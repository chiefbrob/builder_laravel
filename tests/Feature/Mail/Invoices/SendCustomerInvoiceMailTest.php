<?php

namespace Tests\Feature\Mail\Invoices;

use App\Mail\Invoices\SendCustomerInvoiceMail;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SendCustomerInvoiceMailTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testEmailSentToCustomerOnPlacingInvoice(): void
    {
        $invoice = Invoice::factory()->create();

        $mailable = new SendCustomerInvoiceMail($invoice);

        $mailable->assertFrom(config('app.email'));
        $mailable->assertTo($invoice->user->email);
        $mailable->assertHasSubject('Order ' . $invoice->reference . ' received');

        $mailable->render();
        $mailable->assertSeeInOrderInHtml(
            [
                $invoice->user->name, 
                "received your order #" . $invoice->reference,
                'Track my Order',
                'Visit Shop',
            ],
        );
    }
}
