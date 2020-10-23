<?php

namespace Vdvcoder\Payment\app\Http\Traits;

use Mollie\Api\Types\PaymentStatus;
use Vdvcoder\Payment\app\Payment;

trait CanBeSold
{
    public function payments()
    {
        return $this->morphMany(Payment::class, "payable", "item_model", "item_model_id");
    }
    public function payment() {
        return $this->payments->where('paid_at', true)->first();
    }

    public function paid() {
        $paymentPaid = $this->payments->where('paid_at', '!=', null)->first();

        if (!$paymentPaid)
            return false;

        return $paymentPaid->paid_at;
    }

    public function status(bool $withHtml = false) {
        return $this->payments->map(function(Payment $payment) use ($withHtml) {
            $status = $payment->api()->status;

            if (!$withHtml) {
                return $status;
            }

            if ($status === PaymentStatus::STATUS_OPEN) {
                return '<span class="badge badge-info">Open</span>';
            }

            if ($status === PaymentStatus::STATUS_CANCELED) {
                return '<span class="badge badge-secondary">Canceled</span>';
            }

            if ($status === PaymentStatus::STATUS_PENDING) {
                return '<span class="badge badge-warning">Pending</span>';
            }

            if ($status === PaymentStatus::STATUS_EXPIRED) {
                return '<span class="badge badge-secondary">Expired</span>';
            }

            if ($status === PaymentStatus::STATUS_FAILED) {
                return '<span class="badge badge-danger">Failed</span>';
            }

            if ($status === PaymentStatus::STATUS_PAID) {
                return '<span class="badge badge-success">Paid</span>';
            }
        });
    }
}
