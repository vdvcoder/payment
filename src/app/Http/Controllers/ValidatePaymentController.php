<?php

namespace Vdvcoder\Payment\app\Http\Controllers;

use Illuminate\Routing\Controller;
use vdvcoder\Payment\app\Payment;

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
