<?php

    namespace App\Services\Payment\Options;

    interface PaymentOptionsInterface
    {
        public function __construct(array $data);
        public function _toArray(): array;
    }