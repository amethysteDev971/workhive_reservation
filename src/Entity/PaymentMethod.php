<?php

    namespace App\Entity;

    use App\Repository\PaymentMethodRepository;
    use DateTime;
    use Doctrine\ORM\Mapping as ORM;

    /**
     * Represents a payment method associated with a user.
     */
    #[ORM\Entity(repositoryClass: PaymentMethodRepository::class)]
    #[ORM\Table(name: 'payment_methods')]
    class PaymentMethod
    {
        /**
         * The unique identifier of the payment method.
         *
         * @var int|null
         */
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(type: 'integer')]
        private ?int $id = null;

        /**
         * The user associated with this payment method.
         *
         * @var User
         */
        #[ORM\ManyToOne(targetEntity: User::class)]
        #[ORM\JoinColumn(nullable: false)]
        private User $user;

        /**
         * The label or name of the payment method (e.g., "Visa", "PayPal").
         *
         * @var string
         */
        #[ORM\Column(type: 'string', length: 100)]
        private string $label;

        /**
         * The type of the payment method (e.g., "credit_card", "paypal").
         *
         * @var string
         */
        #[ORM\Column(type: 'string', length: 50)]
        private string $type;

        /**
         * Additional data for the payment method (e.g., card details, PayPal ID).
         *
         * @var array
         */
        #[ORM\Column(type: 'json')]
        private array $data;

        /**
         * The timestamp when the payment method was created.
         *
         * @var DateTime
         */
        #[ORM\Column(type: 'datetime')]
        private DateTime $createdAt;

        /**
         * The timestamp when the payment method was last updated.
         *
         * @var DateTime|null
         */
        #[ORM\Column(type: 'datetime', nullable: true)]
        private ?DateTime $updatedAt;

        /**
         * Initializes the payment method with the creation timestamp.
         */
        public function __construct()
        {
            $this->createdAt = new DateTime();
        }

        /**
         * Get the unique identifier of the payment method.
         *
         * @return int|null
         */
        public function getId(): ?int
        {
            return $this->id;
        }

        /**
         * Get the user associated with this payment method.
         *
         * @return User|null
         */
        public function getUser(): ?User
        {
            return $this->user;
        }

        /**
         * Set the user associated with this payment method.
         *
         * @param User|null $user
         * @return $this
         */
        public function setUser(?User $user): static
        {
            $this->user = $user;

            return $this;
        }

        /**
         * Get the label or name of the payment method.
         *
         * @return string
         */
        public function getLabel(): string
        {
            return $this->label;
        }

        /**
         * Set the label or name of the payment method.
         *
         * @param string $label
         * @return $this
         */
        public function setLabel(string $label): static
        {
            $this->label = $label;

            return $this;
        }

        /**
         * Get the type of the payment method.
         *
         * @return string
         */
        public function getType(): string
        {
            return $this->type;
        }

        /**
         * Set the type of the payment method.
         *
         * @param string $type
         * @return $this
         */
        public function setType(string $type): static
        {
            $this->type = $type;

            return $this;
        }

        /**
         * Get additional data for the payment method.
         *
         * @return array
         */
        public function getData(): array
        {
            return $this->data;
        }

        /**
         * Set additional data for the payment method.
         *
         * @param array $data
         * @return $this
         */
        public function setData(array $data): static
        {
            $this->data = $data;

            return $this;
        }

        /**
         * Get the timestamp when the payment method was created.
         *
         * @return DateTime
         */
        public function getCreatedAt(): DateTime
        {
            return $this->createdAt;
        }

        /**
         * Get the timestamp when the payment method was last updated.
         *
         * @return DateTime|null
         */
        public function getUpdatedAt(): ?DateTime
        {
            return $this->updatedAt;
        }

        /**
         * Set the timestamp when the payment method was last updated.
         *
         * @param DateTime|null $updatedAt
         * @return $this
         */
        public function setUpdatedAt(?DateTime $updatedAt): static
        {
            $this->updatedAt = $updatedAt;

            return $this;
        }
    }
