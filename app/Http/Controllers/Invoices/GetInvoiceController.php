<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoices\GetInvoiceRequest;
use App\Models\Invoice;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;

class GetInvoiceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetInvoiceRequest $request, string $reference)
    {
        try {
            $user = User::findOrFail(auth()->id());
            $invoice = Invoice::query();
            if (!$user->isAdmin()) {
                $invoice->where('user_id', $user->id);
            }
            return $invoice->where('reference', $reference)
                ->with('invoiceStates')
                ->with('address')->firstOrFail();
            
        } catch (Exception $e) {
            return response()->json(
                [
                    'message' => 'Failed to fetch invoice'
                ], 
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
