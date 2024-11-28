<?php

    namespace App\Services\Payment\Options;

    readonly class CreditCardOptions implements PaymentOptionsInterface
    {
        private string $number;
            private string $expiration;
            private string $cvv;

        public function __construct(array $data) {
            $this->number = $data['number'];
            $this->expiration = $data['expiration'];
            $this->cvv = $data['cvv'];
        }

        public function getNumber(): string
        {
            return $this->number;
        }

        public function getExpiration(): string
        {
            return $this->expiration;
        }

        public function getCvv(): string
        {
            return $this->cvv;
        }

        public function _toArray(): array
        {
            return [
                'number' => $this->number,
                'expiration' => $this->expiration,
                'cvv' => $this->cvv
            ];
        }
    }