<?php

namespace Vdvcoder\Payment\app\Providers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mollie\Laravel\Facades\Mollie;
use Vdvcoder\Payment\app\Payment;

class MolliePaymentProvider extends PaymentProvider
{
    public function __construct()
    {
        $this->provider = "Mollie";
    }

    protected function parsePayment(): string
    {
        $payment = Mollie::api()->payments()->create([
            "amount"      => [
                "currency" => $this->curreny,
                'value'    => number_format($this->total, 2, ".", "")
            ],
            "description" => $this->description,
            "webhookUrl"  => route('payments.webhooks.mollie'),
            "redirectUrl" => $this->returnUrl
        ]);

        return $payment->id;
    }

    public function webhook(Request $request)
    {
        $id      = $request->get('id');
        $payment = Payment::query()
            ->where('payment_id', $id)
            ->firstOrFail();

        if ($payment->api()->isPaid() && !$payment->paid_at) {
            $payment->paid_at        = Carbon::parse($payment->api()->paidAt);
            $payment->payment_method = $payment->api()->method;
            $payment->save();

            if ($payment->callback) {
                call_user_func(Str::parseCallback($payment->callback), $payment);
            }
        }
    }
}
