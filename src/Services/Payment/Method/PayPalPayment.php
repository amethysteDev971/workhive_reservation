<?php

    namespace App\Services\Payment\Method;

    use App\Services\Payment\Exception\InvalidPaymentOptionsException;
    use App\Services\Payment\Options\PaymentOptionsInterface;
    use App\Services\Payment\Options\PaypalOptions;
    use InvalidArgumentException;

    class PayPalPayment implements PaymentMethodInterface
    {
        /**
         * @throws \App\Services\Payment\Exception\InvalidPaymentOptionsException
         */
        public function pay(float $amount, ?PaymentOptionsInterface $options = null): void
        {
            if (!$options instanceof PaypalOptions) {
                throw new InvalidPaymentOptionsException("Les options de paiement ne sont pas valides pour ce mode de paiement.");
            }

            if (!$options->getEmail()) {
                throw new InvalidArgumentException("Adresse email PayPal requise.");
            }

            echo sprintf(
                "Paiement de %s € via PayPal avec l'email %s.<br/><br/>",
                $amount,
                $options->getEmail()
            );
        }
    }