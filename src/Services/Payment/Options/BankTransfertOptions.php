<?php

    namespace App\Services\Payment\Options;

    readonly class BankTransfertOptions implements PaymentOptionsInterface
    {
        private string $iban;
        private string $bic;

        public function __construct(array $data) {
            $this->iban = $data['iban'];
            $this->bic = $data['bic'];
        }

        public function getIban(): string
        {
            return $this->iban;
        }

        public function getBic(): string
        {
            return $this->bic;
        }

        public function _toArray(): array
        {
            return [
                'iban' => $this->iban,
                'bic' => $this->bic
            ];
        }
    }