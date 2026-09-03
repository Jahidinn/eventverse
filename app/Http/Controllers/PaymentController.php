<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ) {
    }

    public function webhook(Request $request)
    {
        return $this->paymentService->handleWebhook($request);
    }
}