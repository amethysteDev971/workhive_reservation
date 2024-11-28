<?php

    namespace App\Entity;

    use App\Repository\DateSchedulesRepository;
    use Doctrine\DBAL\Types\Types;
    use Doctrine\ORM\Mapping as ORM;

    /**
     * Represents a specific schedule for a date, including open/close times and status.
     */
    #[ORM\Entity(repositoryClass: DateSchedulesRepository::class)]
    #[ORM\Table(name: 'date_schedules')]
    class DateSchedules
    {
        /**
         * The unique identifier of the schedule.
         *
         * @var int|null
         */
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id = null;

        /**
         * An optional name or label for the schedule.
         *
         * @var string|null
         */
        #[ORM\Column(length: 255, nullable: true)]
        private ?string $name = null;

        /**
         * The date of the schedule.
         *
         * @var \DateTimeInterface|null
         */
        #[ORM\Column(type: Types::DATE_MUTABLE)]
        private ?\DateTimeInterface $date = null;

        /**
         * The starting time of the schedule.
         *
         * @var \DateTimeInterface|null
         */
        #[ORM\Column(type: Types::TIME_MUTABLE)]
        private ?\DateTimeInterface $startedAt = null;

        /**
         * The ending time of the schedule.
         *
         * @var \DateTimeInterface|null
         */
        #[ORM\Column(type: Types::TIME_MUTABLE)]
        private ?\DateTimeInterface $endedAt = null;

        /**
         * Indicates whether the schedule is open during the specified time.
         *
         * @var bool|null
         */
        #[ORM\Column]
        private ?bool $isOpen = null;

        /**
         * The room associated with this schedule.
         *
         * @var Room|null
         */
        #[ORM\ManyToOne(inversedBy: 'dateSchedules')]
        #[ORM\JoinColumn(nullable: false)]
        private ?Room $room = null;

        /**
         * Get the unique identifier of the schedule.
         *
         * @return int|null
         */
        public function getId(): ?int
        {
            return $this->id;
        }

        /**
         * Get the name or label of the schedule.
         *
         * @return string|null
         */
        public function getName(): ?string
        {
            return $this->name;
        }

        /**
         * Set the name or label of the schedule.
         *
         * @param string|null $name
         *
         * @return $this
         */
        public function setName(?string $name): static
        {
            $this->name = $name;

            return $this;
        }

        /**
         * Get the date of the schedule.
         *
         * @return \DateTimeInterface|null
         */
        public function getDate(): ?\DateTimeInterface
        {
            return $this->date;
        }

        /**
         * Set the date of the schedule.
         *
         * @param \DateTimeInterface $date
         *
         * @return $this
         */
        public function setDate(\DateTimeInterface $date): static
        {
            $this->date = $date;

            return $this;
        }

        /**
         * Get the starting time of the schedule.
         *
         * @return \DateTimeInterface|null
         */
        public function getStartedAt(): ?\DateTimeInterface
        {
            return $this->startedAt;
        }

        /**
         * Set the starting time of the schedule.
         *
         * @param \DateTimeInterface $startedAt
         *
         * @return $this
         */
        public function setStartedAt(\DateTimeInterface $startedAt): static
        {
            $this->startedAt = $startedAt;

            return $this;
        }

        /**
         * Get the ending time of the schedule.
         *
         * @return \DateTimeInterface|null
         */
        public function getEndedAt(): ?\DateTimeInterface
        {
            return $this->endedAt;
        }

        /**
         * Set the ending time of the schedule.
         *
         * @param \DateTimeInterface $endedAt
         *
         * @return $this
         */
        public function setEndedAt(\DateTimeInterface $endedAt): static
        {
            $this->endedAt = $endedAt;

            return $this;
        }

        /**
         * Check if the schedule is open during the specified time.
         *
         * @return bool|null
         */
        public function isOpen(): ?bool
        {
            return $this->isOpen;
        }

        /**
         * Set whether the schedule is open during the specified time.
         *
         * @param bool $isOpen
         *
         * @return $this
         */
        public function setIsOpen(bool $isOpen): static
        {
            $this->isOpen = $isOpen;

            return $this;
        }

        /**
         * Get the room associated with this schedule.
         *
         * @return Room|null
         */
        public function getRoom(): ?Room
        {
            return $this->room;
        }

        /**
         * Set the room associated with this schedule.
         *
         * @param Room|null $room
         *
         * @return $this
         */
        public function setRoom(?Room $room): static
        {
            $this->room = $room;

            return $this;
        }
    }
