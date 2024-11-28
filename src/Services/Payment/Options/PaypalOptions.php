<?php

    namespace App\Services\Payment\Options;

    readonly class PaypalOptions implements PaymentOptionsInterface
    {
        private string $email;
        private string $password;

        public function __construct(array $data)
        {
            $this->email = $data['email'];
            $this->password = $data['password'];
        }

        public function getEmail(): string
        {
            return $this->email;
        }

        public function getPassword(): string
        {
            return $this->password;
        }

        public function _toArray(): array
        {
            return [
                'email' => $this->email,
                'password' => $this->password
            ];
        }
    }