<?php

    namespace App\Entity;

    use App\Enum\UserRole;
    use App\Repository\RoomRoleRateRepository;
    use Doctrine\ORM\Mapping as ORM;

    /**
     * Represents the hourly rate for a room based on the user's role.
     */
    #[ORM\Entity(repositoryClass: RoomRoleRateRepository::class)]
    #[ORM\Table(name: 'room_role_rate')]
    class RoomRoleRate
    {
        /**
         * The unique identifier of the room-role rate.
         *
         * @var int|null
         */
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(type: 'integer')]
        private ?int $id = null;

        /**
         * The room associated with this rate.
         *
         * @var Room
         */
        #[ORM\ManyToOne(targetEntity: Room::class)]
        #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
        private Room $room;

        /**
         * The user role for which this rate applies.
         *
         * @var UserRole
         */
        #[ORM\Column(type: 'string', enumType: UserRole::class)]
        private UserRole $userRole;

        /**
         * The hourly rate for the room based on the user role.
         *
         * @var float
         */
        #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
        private float $hourlyRate;

        /**
         * Get the unique identifier of the room-role rate.
         *
         * @return int|null
         */
        public function getId(): ?int
        {
            return $this->id;
        }

        /**
         * Get the room associated with this rate.
         *
         * @return Room
         */
        public function getRoom(): Room
        {
            return $this->room;
        }

        /**
         * Set the room associated with this rate.
         *
         * @param Room $room The room to associate with this rate.
         *
         * @return $this
         */
        public function setRoom(Room $room): self
        {
            $this->room = $room;

            return $this;
        }

        /**
         * Get the user role for which this rate applies.
         *
         * @return UserRole
         */
        public function getUserRole(): UserRole
        {
            return $this->userRole;
        }

        /**
         * Set the user role for which this rate applies.
         *
         * @param UserRole $userRole The user role to set.
         *
         * @return $this
         */
        public function setUserRole(UserRole $userRole): self
        {
            $this->userRole = $userRole;

            return $this;
        }

        /**
         * Get the hourly rate for the room based on the user role.
         *
         * @return float
         */
        public function getHourlyRate(): float
        {
            return $this->hourlyRate;
        }

        /**
         * Set the hourly rate for the room based on the user role.
         *
         * @param float $hourlyRate The hourly rate to set.
         *
         * @return $this
         */
        public function setHourlyRate(float $hourlyRate): self
        {
            $this->hourlyRate = $hourlyRate;

            return $this;
        }
    }
