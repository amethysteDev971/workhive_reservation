<?php

    namespace App\Services\Payment\Type;

    use App\Services\Payment\Method\BitcoinPayment;
    use App\Services\Payment\Options\BitcoinOptions;

    class BitcoinType implements PaymentTypeInterface
    {
        public function getId(): string
        {
            return "bitcoin";
        }

        public function getName(): string
        {
            return "Bitcoin";
        }

        /**
         * @return class-string<\App\Services\Payment\Method\PaymentMethodInterface>
         */
        public function getMethod(): string {
            return BitcoinPayment::class;
        }

        /**
         * @return class-string<\App\Services\Payment\Options\PaymentOptionsInterface>
         */
        public function getOptions(): string {
            return BitcoinOptions::class;
        }
    }