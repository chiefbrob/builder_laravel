<?php

namespace Tests\Feature\Invoices;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetInvoiceControllerTest extends TestCase
{
    public $invoice;

    public function setUp(): void
    {
        parent::setUp();
        $this->actingAsRandomUser();
        $this->invoice = Invoice::factory()->create(['user_id' => $this->user->id]);
    }

    public function testUserCanViewSingleInvoice(): void
    {
        $this->get(url('/api/v1/invoices/' . $this->invoice->reference))->assertOk()
            ->assertJson([
                'reference' => $this->invoice->reference,
                'address' => [
                    'id' => $this->invoice->address->id,
                    'first_name' => $this->invoice->address->first_name
                ]
            ]);
        
    }

    public function testAdminCanViewAnyInvoice(): void
    {
        $this->actingAsAdmin();
        $this->get(url('/api/v1/invoices/' . $this->invoice->reference))->assertOk()
            ->assertJson([
                'reference' => $this->invoice->reference,
                'address' => [
                    'id' => $this->invoice->address->id,
                    'first_name' => $this->invoice->address->first_name
                ]
            ]);
    }

    public function testUserCannotViewOtherUserInvoice(): void
    {
        $anotherUser = User::factory()->create();
        $this->actingAs($anotherUser);
        $this->get(url('/api/v1/invoices/' . $this->invoice->reference))
            ->assertUnprocessable();
    }
}
