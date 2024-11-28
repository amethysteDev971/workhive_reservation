<?php

    namespace App\Services\Payment\Method;

    use App\Services\Payment\Options\PaymentOptionsInterface;

    interface PaymentMethodInterface
    {
        public function pay(float $amount, ?PaymentOptionsInterface $options = null): void;
    }