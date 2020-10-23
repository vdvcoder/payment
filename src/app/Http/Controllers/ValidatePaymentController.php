<?php

namespace vdvcoder\Payment\App\Http\Controllers;

use Illuminate\Routing\Controller;
use vdvcoder\Payment\App\Payment;

class ValidatePaymentController extends Controller
{

    public function validate(string $uuid)
    {
        $payment = Payment::where('uuid', $uuid)->firstOrFail();
        return response()->json([
            'paid' => !!$payment->paid_at
        ]);
    }

}
