<?php

    namespace App\Services\Payment\Type;

    use App\Services\Payment\Method\CreditCardPayment;
    use App\Services\Payment\Options\CreditCardOptions;

    class CreditCardType implements PaymentTypeInterface
    {
        public function getId(): string
        {
            return "credit_card";
        }

        public function getName(): string
        {
            return "Credit Card";
        }

        /**
         * @return class-string<\App\Services\Payment\Method\PaymentMethodInterface>
         */
        public function getMethod(): string {
            return CreditCardPayment::class;
        }

        /**
         * @return class-string<\App\Services\Payment\Options\PaymentOptionsInterface>
         */
        public function getOptions(): string {
            return CreditCardOptions::class;
        }
    }