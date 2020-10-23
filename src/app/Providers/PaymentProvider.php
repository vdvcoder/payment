<?php

namespace Vdvcoder\Payment\app\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\RouteAction;
use Illuminate\Support\Str;
use Vdvcoder\Payment\app\Payment;

abstract class PaymentProvider
{
    abstract protected function parsePayment(): string;

    protected ?Model     $itemModel = null;
    protected ?Model     $userModel = null;
    protected string     $provider;
    protected float      $total;
    protected ?string    $callback  = null;
    protected string     $description;
    protected string     $curreny   = 'EUR';
    protected string     $returnUrl;

    public static function Mollie(): MolliePaymentProvider
    {
        return (new MolliePaymentProvider());
    }

    public function linkToItem(Model $model): PaymentProvider
    {
        $this->itemModel = $model;
        return $this;
    }

    public function linkToUser(Model $model): PaymentProvider
    {
        $this->userModel = $model;
        return $this;
    }

    public function setTotal(float $total): PaymentProvider
    {
        $this->total = $total;
        return $this;
    }

    public function setCallback($callback): PaymentProvider
    {
        $this->callback = RouteAction::parse("/", $callback)["uses"];
        [$class, $method] = Str::parseCallback($this->callback);
        if (!method_exists($class, $method)) {
            throw new \Exception("Function [{$method}] is not a method of the class [{$class}]");
        }

        $methodChecker = new \ReflectionMethod($class, $method);
        if (!$methodChecker->isStatic()) {
            throw new \Exception("Function [{$method}] in class [{$class}] is not static");
        }

        return $this;
    }

    public function setDescription(string $description): PaymentProvider
    {
        $this->description = $description;
        return $this;
    }

    public function setPaymentProvider(string $provider): PaymentProvider
    {
        $this->provider = $provider;
        return $this;
    }

    public function setCurreny(string $currency): PaymentProvider
    {
        $this->curreny = $currency;
        return $this;
    }

    public function setReturnUrl(string $returnUrl): PaymentProvider
    {
        $this->returnUrl = $returnUrl;
        return $this;
    }

    public function getPayment(): Payment
    {
        $payment_id = $this->parsePayment();
        return Payment::create([
            "uuid"             => (string) Str::orderedUuid(),
            "payment_provider" => $this->provider,
            "payment_id"       => $payment_id,
            "total"            => $this->total,
            "item_model"       => $this->itemModel ? get_class($this->itemModel) : null,
            "item_model_id"    => optional($this->itemModel)->id,
            "user_model"       => $this->userModel ? get_class($this->userModel) : null,
            "user_model_id"    => optional($this->userModel)->id,
            "callback"         => $this->callback
        ]);
    }
}
