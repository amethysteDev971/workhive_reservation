<?php

    namespace App\Services\Payment\Type;


    interface PaymentTypeInterface
    {
        public function getId(): string;
        public function getName(): string;
        /**
         * @return class-string<\App\Services\Payment\Method\PaymentMethodInterface>
         */
        public function getMethod(): string;
        /**
         * @return class-string<\App\Services\Payment\Options\PaymentOptionsInterface>
         */
        public function getOptions(): string;
    }