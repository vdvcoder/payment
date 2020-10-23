<?php

namespace vdvcoder\Payment\App\Http\Traits;

use vdvcoder\Payment\App\Payment;

trait CanBuyItems
{
    public function payments()
    {
        return $this->morphMany(Payment::class, "payable", "user_model", "user_model_id");
    }
}
