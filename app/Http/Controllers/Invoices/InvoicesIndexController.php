<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoices\InvoicesIndexRequest;
use App\Models\Invoice;
use App\Models\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class InvoicesIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(InvoicesIndexRequest $request)
    {
        try {
            $user = User::findOrFail(auth()->id());
            
            $invoices = Invoice::query();
            if (!$user->isAdmin()) {
                $invoices->where('user_id', $user->id);
            }
            return $invoices->with('address')
                ->with('invoiceStates')
                ->orderBy('id', 'DESC')
                ->paginate();
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(
                ['message' => 'Failed to get Invoices'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }
}
