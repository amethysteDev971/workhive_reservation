<?php

    namespace App\Entity;

    use App\Enum\Status;
    use App\Repository\RoomRepository;
    use DateTime;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Collection;
    use Doctrine\ORM\Mapping as ORM;

    /**
     * Represents a room that can be reserved.
     */
    #[ORM\Entity(repositoryClass: RoomRepository::class)]
    #[ORM\Table(name: 'rooms')]
    class Room
    {
        /**
         * The unique identifier of the room.
         *
         * @var int|null
         */
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(type: 'integer')]
        private ?int $id = null;

        /**
         * The name of the room.
         *
         * @var string
         */
        #[ORM\Column(type: 'string', length: 100)]
        private string $name;

        /**
         * The capacity of the room.
         *
         * @var int
         */
        #[ORM\Column(type: 'integer')]
        private int $capacity;

        /**
         * The width of the room in meters.
         *
         * @var float
         */
        #[ORM\Column(type: 'float')]
        private float $width;

        /**
         * The length of the room in meters.
         *
         * @var float
         */
        #[ORM\Column(type: 'float')]
        private float $length;

        /**
         * The status of the room (active or inactive).
         *
         * @var Status|null
         */
        #[ORM\Column(enumType: Status::class)]
        private ?Status $status = null;

        /**
         * A description of the room.
         *
         * @var string|null
         */
        #[ORM\Column(type: 'text', nullable: true)]
        private ?string $description;

        /**
         * A photo of the room.
         *
         * @var string|null
         */
        #[ORM\Column(type: 'string', length: 255, nullable: true)]
        private ?string $photo;

        /**
         * The timestamp when the room was created.
         *
         * @var DateTime
         */
        #[ORM\Column(type: 'datetime')]
        private DateTime $createdAt;

        /**
         * The timestamp when the room was last updated.
         *
         * @var DateTime|null
         */
        #[ORM\Column(type: 'datetime', nullable: true)]
        private ?DateTime $updatedAt;

        /**
         * Reservations associated with this room.
         *
         * @var Collection<int, Reservation>
         */
        #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'room', cascade: ['persist', 'remove'])]
        private Collection $reservations;

        /**
         * Weekly schedules associated with this room.
         *
         * @var Collection<int, WeekSchedules>
         */
        #[ORM\OneToMany(targetEntity: WeekSchedules::class, mappedBy: 'room', orphanRemoval: true)]
        private Collection $weekSchedules;

        /**
         * Date-specific schedules associated with this room.
         *
         * @var Collection<int, DateSchedules>
         */
        #[ORM\OneToMany(targetEntity: DateSchedules::class, mappedBy: 'room', orphanRemoval: true)]
        private Collection $dateSchedules;

        /**
         * Initializes the room with default values and empty collections.
         */
        public function __construct()
        {
            $this->status = Status::ACTIVE;
            $this->createdAt = new DateTime();
            $this->reservations = new ArrayCollection();
            $this->weekSchedules = new ArrayCollection();
            $this->dateSchedules = new ArrayCollection();
        }

        /**
         * Get the unique identifier of the room.
         *
         * @return int|null
         */
        public function getId(): ?int
        {
            return $this->id;
        }

        /**
         * Get the name of the room.
         *
         * @return string
         */
        public function getName(): string
        {
            return $this->name;
        }

        /**
         * Set the name of the room.
         *
         * @param string $name
         *
         * @return $this
         */
        public function setName(string $name): self
        {
            $this->name = $name;

            return $this;
        }

        /**
         * Get the capacity of the room.
         *
         * @return int
         */
        public function getCapacity(): int
        {
            return $this->capacity;
        }

        /**
         * Set the capacity of the room.
         *
         * @param int $capacity
         *
         * @return $this
         */
        public function setCapacity(int $capacity): self
        {
            $this->capacity = $capacity;

            return $this;
        }

        /**
         * Get the width of the room.
         *
         * @return float
         */
        public function getWidth(): float
        {
            return $this->width;
        }

        /**
         * Set the width of the room.
         *
         * @param float $width
         *
         * @return $this
         */
        public function setWidth(float $width): self
        {
            $this->width = $width;

            return $this;
        }

        /**
         * Get the length of the room.
         *
         * @return float
         */
        public function getLength(): float
        {
            return $this->length;
        }

        /**
         * Set the length of the room.
         *
         * @param float $length
         *
         * @return $this
         */
        public function setLength(float $length): self
        {
            $this->length = $length;

            return $this;
        }

        /**
         * Get the total area of the room (width × length).
         *
         * @return float
         */
        public function getArea(): float
        {
            return $this->width * $this->length;
        }

        /**
         * Get the description of the room.
         *
         * @return string|null
         */
        public function getDescription(): ?string
        {
            return $this->description;
        }

        /**
         * Set the description of the room.
         *
         * @param string|null $description
         *
         * @return $this
         */
        public function setDescription(?string $description): self
        {
            $this->description = $description;

            return $this;
        }

        /**
         * Get the photo of the room.
         *
         * @return string|null
         */
        public function getPhoto(): ?string
        {
            return $this->photo;
        }

        /**
         * Set the photo of the room.
         *
         * @param string|null $photo
         *
         * @return $this
         */
        public function setPhoto(?string $photo): self
        {
            $this->photo = $photo;

            return $this;
        }

        /**
         * Get the status of the room.
         *
         * @return Status|null
         */
        public function getStatus(): ?Status
        {
            return $this->status;
        }

        /**
         * Set the status of the room.
         *
         * @param Status $status
         *
         * @return $this
         */
        public function setStatus(Status $status): self
        {
            $this->status = $status;

            return $this;
        }

        /**
         * Check if the room is active.
         *
         * @return bool
         */
        public function isActive(): bool
        {
            return $this->status === Status::ACTIVE;
        }

        /**
         * Get the reservations associated with the room.
         *
         * @return Collection<int, Reservation>
         */
        public function getReservations(): Collection
        {
            return $this->reservations;
        }

        /**
         * Add a reservation to the room.
         *
         * @param Reservation $reservation
         *
         * @return $this
         */
        public function addReservation(Reservation $reservation): self
        {
            if (!$this->reservations->contains($reservation)) {
                $this->reservations->add($reservation);
                $reservation->setRoom($this);
            }

            return $this;
        }

        /**
         * Remove a reservation from the room.
         *
         * @param Reservation $reservation
         *
         * @return $this
         */
        public function removeReservation(Reservation $reservation): self
        {
            if ($this->reservations->removeElement($reservation)) {
                if ($reservation->getRoom() === $this) {
                    $reservation->setRoom(null);
                }
            }

            return $this;
        }

        /**
         * Get the collection of weekly schedules associated with the room.
         *
         * @return Collection<int, WeekSchedules> A collection of WeekSchedules objects.
         */
        public function getWeekSchedules(): Collection
        {
            return $this->weekSchedules;
        }

        /**
         * Add a weekly schedule to the room.
         *
         * @param WeekSchedules $weekSchedule The weekly schedule to add.
         *
         * @return $this
         */
        public function addWeekSchedule(WeekSchedules $weekSchedule): static
        {
            if (!$this->weekSchedules->contains($weekSchedule)) {
                $this->weekSchedules->add($weekSchedule);
                $weekSchedule->setRoom($this);
            }

            return $this;
        }

        /**
         * Remove a weekly schedule from the room.
         *
         * @param WeekSchedules $weekSchedule The weekly schedule to remove.
         *
         * @return $this
         */
        public function removeWeekSchedule(WeekSchedules $weekSchedule): static
        {
            if ($this->weekSchedules->removeElement($weekSchedule)) {
                // Set the owning side to null (unless already changed).
                if ($weekSchedule->getRoom() === $this) {
                    $weekSchedule->setRoom(null);
                }
            }

            return $this;
        }

        /**
         * Get the collection of date-specific schedules associated with the room.
         *
         * @return Collection<int, DateSchedules> A collection of DateSchedules objects.
         */
        public function getDateSchedules(): Collection
        {
            return $this->dateSchedules;
        }

        /**
         * Add a date-specific schedule to the room.
         *
         * @param DateSchedules $dateSchedule The date-specific schedule to add.
         *
         * @return $this
         */
        public function addDateSchedule(DateSchedules $dateSchedule): static
        {
            if (!$this->dateSchedules->contains($dateSchedule)) {
                $this->dateSchedules->add($dateSchedule);
                $dateSchedule->setRoom($this);
            }

            return $this;
        }

        /**
         * Remove a date-specific schedule from the room.
         *
         * @param DateSchedules $dateSchedule The date-specific schedule to remove.
         *
         * @return $this
         */
        public function removeDateSchedule(DateSchedules $dateSchedule): static
        {
            if ($this->dateSchedules->removeElement($dateSchedule)) {
                // Set the owning side to null (unless already changed).
                if ($dateSchedule->getRoom() === $this) {
                    $dateSchedule->setRoom(null);
                }
            }

            return $this;
        }

    }
