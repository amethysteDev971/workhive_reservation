<?php

    namespace App\Services\Payment\Type;

    use App\Services\Payment\Method\BankTransferPayment;
    use App\Services\Payment\Options\BankTransfertOptions;

    class BankTransferType implements PaymentTypeInterface
    {
        public function getId(): string
        {
            return "bank_transfer";
        }

        public function getName(): string
        {
            return "Virement bancaire";
        }

        /**
         * @return class-string<\App\Services\Payment\Method\PaymentMethodInterface>
         */
        public function getMethod(): string {
            return BankTransferPayment::class;
        }

        /**
         * @return class-string<\App\Services\Payment\Options\PaymentOptionsInterface>
         */
        public function getOptions(): string {
            return BankTransfertOptions::class;
        }
    }