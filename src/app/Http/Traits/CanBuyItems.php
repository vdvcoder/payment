<?php

namespace Vdvcoder\Payment\app\Http\Traits;

use Vdvcoder\Payment\app\Payment;

trait CanBuyItems
{
    public function payments()
    {
        return $this->morphMany(Payment::class, "payable", "user_model", "user_model_id");
    }
}
