<?php

    namespace App\Entity;

    use App\Enum\Status;
    use App\Enum\UserRole;
    use App\Repository\UserRepository;
    use DateTime;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Collection;
    use Doctrine\ORM\Mapping as ORM;

    /**
     * Represents a user in the application.
     */
    #[ORM\Entity(repositoryClass: UserRepository::class)]
    #[ORM\Table(name: 'users')]
    class User
    {
        /**
         * The unique identifier of the user.
         *
         * @var int|null
         */
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(type: 'integer')]
        private ?int $id = null;

        /**
         * The first name of the user.
         *
         * @var string
         */
        #[ORM\Column(type: 'string', length: 50)]
        private string $firstName;

        /**
         * The last name of the user.
         *
         * @var string
         */
        #[ORM\Column(type: 'string', length: 50)]
        private string $lastName;

        /**
         * The photo of the user.
         *
         * @var string|null
         */
        #[ORM\Column(type: 'string', length: 255, nullable: true)]
        private ?string $photo;

        /**
         * The role of the user (e.g., member, user, admin).
         *
         * @var UserRole|null
         */
        #[ORM\Column(enumType: UserRole::class)]
        private ?UserRole $userRole;

        /**
         * The phone number of the user.
         *
         * @var string|null
         */
        #[ORM\Column(type: 'string', length: 15, nullable: true)]
        private ?string $phone;

        /**
         * The email address of the user.
         *
         * @var string
         */
        #[ORM\Column(type: 'string', length: 100, unique: true)]
        private string $email;

        /**
         * The hashed password of the user.
         *
         * @var string
         */
        #[ORM\Column(type: 'string')]
        private string $password;

        /**
         * The status of the user (active or inactive).
         *
         * @var Status|null
         */
        #[ORM\Column(enumType: Status::class)]
        private ?Status $status = null;

        /**
         * The timestamp when the user was created.
         *
         * @var DateTime
         */
        #[ORM\Column(type: 'datetime')]
        private DateTime $createdAt;

        /**
         * The timestamp when the user was last updated.
         *
         * @var DateTime|null
         */
        #[ORM\Column(type: 'datetime', nullable: true)]
        private ?DateTime $updatedAt;

        /**
         * The collection of payment methods associated with the user.
         *
         * @var Collection<int, PaymentMethod>
         */
        #[ORM\OneToMany(targetEntity: PaymentMethod::class, mappedBy: 'user')]
        private Collection $paymentMethods;

        /**
         * The collection of reservations made by the user.
         *
         * @var Collection<int, Reservation>
         */
        #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'user', cascade: ['persist', 'remove'])]
        private Collection $reservations;

        /**
         * Initializes the user with default values and empty collections.
         */
        public function __construct()
        {
            $this->userRole = UserRole::USER;
            $this->status = Status::ACTIVE;
            $this->createdAt = new DateTime();
            $this->paymentMethods = new ArrayCollection();
            $this->reservations = new ArrayCollection();
        }

        /**
         * Get the unique identifier of the user.
         *
         * @return int|null
         */
        public function getId(): ?int
        {
            return $this->id;
        }

        /**
         * Get the first name of the user.
         *
         * @return string
         */
        public function getFirstName(): string
        {
            return $this->firstName;
        }

        /**
         * Set the first name of the user.
         *
         * @param string $firstName
         *
         * @return $this
         */
        public function setFirstName(string $firstName): static
        {
            $this->firstName = $firstName;

            return $this;
        }

        /**
         * Get the last name of the user.
         *
         * @return string
         */
        public function getLastName(): string
        {
            return $this->lastName;
        }

        /**
         * Set the last name of the user.
         *
         * @param string $lastName
         *
         * @return $this
         */
        public function setLastName(string $lastName): static
        {
            $this->lastName = $lastName;

            return $this;
        }

        /**
         * Get the photo of the user.
         *
         * @return string|null
         */
        public function getPhoto(): ?string
        {
            return $this->photo;
        }

        /**
         * Set the photo of the user.
         *
         * @param string|null $photo
         *
         * @return $this
         */
        public function setPhoto(?string $photo): static
        {
            $this->photo = $photo;

            return $this;
        }

        /**
         * Get the role of the user.
         *
         * @return UserRole|null
         */
        public function getUserRole(): ?UserRole
        {
            return $this->userRole;
        }

        /**
         * Set the role of the user.
         *
         * @param UserRole $role
         *
         * @return $this
         */
        public function setUserRole(UserRole $role): static
        {
            $this->userRole = $role;

            return $this;
        }

        /**
         * Get the phone number of the user.
         *
         * @return string|null
         */
        public function getPhone(): ?string
        {
            return $this->phone;
        }

        /**
         * Set the phone number of the user.
         *
         * @param string|null $phone
         *
         * @return $this
         */
        public function setPhone(?string $phone): static
        {
            $this->phone = $phone;

            return $this;
        }

        /**
         * Get the email address of the user.
         *
         * @return string
         */
        public function getEmail(): string
        {
            return $this->email;
        }

        /**
         * Set the email address of the user.
         *
         * @param string $email
         *
         * @return $this
         */
        public function setEmail(string $email): static
        {
            $this->email = $email;

            return $this;
        }

        /**
         * Get the hashed password of the user.
         *
         * @return string
         */
        public function getPassword(): string
        {
            return $this->password;
        }

        /**
         * Set the hashed password of the user.
         *
         * @param string $password
         *
         * @return $this
         */
        public function setPassword(string $password): static
        {
            $this->password = $password;

            return $this;
        }

        /**
         * Get the status of the user.
         *
         * @return Status|null
         */
        public function getStatus(): ?Status
        {
            return $this->status;
        }

        /**
         * Set the status of the user.
         *
         * @param Status $status
         *
         * @return $this
         */
        public function setStatus(Status $status): static
        {
            $this->status = $status;

            return $this;
        }

        /**
         * Get the payment methods associated with the user.
         *
         * @return Collection<int, PaymentMethod>
         */
        public function getPaymentMethods(): Collection
        {
            return $this->paymentMethods;
        }

        /**
         * Add a payment method to the user.
         *
         * @param PaymentMethod $paymentMethod
         *
         * @return $this
         */
        public function addPaymentMethod(PaymentMethod $paymentMethod): self
        {
            if (!$this->paymentMethods->contains($paymentMethod)) {
                $this->paymentMethods[] = $paymentMethod;
                $paymentMethod->setUser($this);
            }

            return $this;
        }

        /**
         * Remove a payment method from the user.
         *
         * @param PaymentMethod $paymentMethod
         *
         * @return $this
         */
        public function removePaymentMethod(PaymentMethod $paymentMethod): static
        {
            if ($this->paymentMethods->removeElement($paymentMethod)) {
                if ($paymentMethod->getUser() === $this) {
                    $paymentMethod->setUser(null);
                }
            }

            return $this;
        }

        /**
         * Get the reservations made by the user.
         *
         * @return Collection<int, Reservation>
         */
        public function getReservations(): Collection
        {
            return $this->reservations;
        }

        /**
         * Add a reservation made by the user.
         *
         * @param Reservation $reservation
         *
         * @return $this
         */
        public function addReservation(Reservation $reservation): self
        {
            if (!$this->reservations->contains($reservation)) {
                $this->reservations->add($reservation);
                $reservation->setUser($this);
            }

            return $this;
        }

        /**
         * Remove a reservation made by the user.
         *
         * @param Reservation $reservation
         *
         * @return $this
         */
        public function removeReservation(Reservation $reservation): self
        {
            if ($this->reservations->removeElement($reservation)) {
                if ($reservation->getUser() === $this) {
                    $reservation->setUser(null);
                }
            }

            return $this;
        }
    }
