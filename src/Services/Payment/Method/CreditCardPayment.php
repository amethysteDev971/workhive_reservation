<?php

    namespace App\Services\Payment\Method;

    use App\Services\Payment\Exception\InvalidPaymentOptionsException;
    use App\Services\Payment\Options\CreditCardOptions;
    use App\Services\Payment\Options\PaymentOptionsInterface;
    use InvalidArgumentException;

    class CreditCardPayment implements PaymentMethodInterface
    {
        /**
         * @throws \App\Services\Payment\Exception\InvalidPaymentOptionsException
         */
        public function pay(float $amount, ?PaymentOptionsInterface $options = null): void
        {
            if (!$options instanceof CreditCardOptions) {
                throw new InvalidPaymentOptionsException("Les options de paiement ne sont pas valides pour ce mode de paiement.");
            }

            $cardNumber = $options->getNumber();
            $expirationDate = $options->getExpiration();
            $cvv = $options->getCvv();

            if (!$cardNumber || !$expirationDate || !$cvv) {
                throw new InvalidArgumentException("Informations de carte bancaire incomplètes.");
            }

            echo sprintf(
                "Paiement de %s € par Carte Bancaire avec le numéro %s.<br/><br/>",
                $amount,
                $cardNumber
            );
        }

    }