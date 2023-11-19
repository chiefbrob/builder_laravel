<?php

namespace Tests\Feature\Mail\Invoices;

use App\Mail\Invoices\SendShopInvoiceMail;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SendShopInvoiceMailTest extends TestCase
{
    public function testShopGetsEmailWhenCustomerPlacesOrder(): void
    {
        $invoice = Invoice::factory()->create();

        $mailable = new SendShopInvoiceMail($invoice);

        $mailable->assertFrom(config('app.email'));
        $mailable->assertTo(config('app.email'));
        $mailable->assertHasSubject('New Order ' . $invoice->reference);

        $mailable->render();
        $mailable->assertSeeInOrderInHtml(['Their contacts are ', 'Process Order']);
    }
}
