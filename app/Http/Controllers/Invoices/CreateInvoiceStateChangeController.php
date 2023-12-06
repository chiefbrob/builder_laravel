<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoices\CreateInvoiceStateChangeRequest;
use App\Models\Invoice;
use App\Models\InvoiceState;
use Exception;
use Illuminate\Http\Response;

class CreateInvoiceStateChangeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateInvoiceStateChangeRequest $request)
    {
        try {
            $invoice = Invoice::findOrFail($request->invoice_id);
            if ($invoice->status === $request->status) {
                throw new Exception('Cannot change status to same');
            }
            $oldState = $invoice->status;
            $invoice->status = $request->status;
            $invoice->save();
            
            $params = array_merge(
                $request->validated(), 
                ['previous_status' => $oldState]
            );

            return InvoiceState::create($params);
        } catch (Exception $e) {
            return response()->json(
                [
                    'message' => 'Failed to create invoice state change'
                ], 
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
