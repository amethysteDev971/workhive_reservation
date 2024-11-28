<?php

    namespace App\Services\Payment\Type;

    use App\Services\Payment\Method\PayPalPayment;
    use App\Services\Payment\Options\PaypalOptions;

    class PaypalType implements PaymentTypeInterface
    {
        public function getId(): string
        {
            return "paypal";
        }

        public function getName(): string
        {
            return "Paypal";
        }

        /**
         * @return class-string<\App\Services\Payment\Method\PaymentMethodInterface>
         */
        public function getMethod(): string {
            return PayPalPayment::class;
        }

        /**
         * @return class-string<\App\Services\Payment\Options\PaymentOptionsInterface>
         */
        public function getOptions(): string {
            return PaypalOptions::class;
        }
    }