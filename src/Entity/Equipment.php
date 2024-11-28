<?php

    namespace App\Entity;

    use App\Repository\EquipmentRepository;
    use Doctrine\ORM\Mapping as ORM;

    /**
     * Represents a piece of equipment that can be associated with rooms or reservations.
     */
    #[ORM\Entity(repositoryClass: EquipmentRepository::class)]
    #[ORM\Table(name: 'equipments')]
    class Equipment
    {
        /**
         * The unique identifier of the equipment.
         *
         * @var int|null
         */
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(type: 'integer')]
        private ?int $id = null;

        /**
         * The name of the equipment.
         *
         * @var string
         */
        #[ORM\Column(type: 'string', length: 100)]
        private string $name;

        /**
         * A brief description of the equipment.
         *
         * @var string|null
         */
        #[ORM\Column(type: 'text', nullable: true)]
        private ?string $description = null;

        /**
         * A path or URL to a photo representing the equipment.
         *
         * @var string|null
         */
        #[ORM\Column(type: 'string', length: 255, nullable: true)]
        private ?string $photo = null;

        /**
         * The total stock available for the equipment.
         *
         * @var int
         */
        #[ORM\Column(type: 'integer')]
        private int $totalStock;

        /**
         * The timestamp when the equipment was created.
         *
         * @var \DateTime
         */
        #[ORM\Column(type: 'datetime')]
        private \DateTime $createdAt;

        /**
         * The timestamp when the equipment was last updated.
         *
         * @var \DateTime|null
         */
        #[ORM\Column(type: 'datetime', nullable: true)]
        private ?\DateTime $updatedAt;

        /**
         * Initializes the equipment with a creation timestamp.
         */
        public function __construct()
        {
            $this->createdAt = new \DateTime();
        }

        /**
         * Get the unique identifier of the equipment.
         *
         * @return int|null
         */
        public function getId(): ?int
        {
            return $this->id;
        }

        /**
         * Get the name of the equipment.
         *
         * @return string
         */
        public function getName(): string
        {
            return $this->name;
        }

        /**
         * Set the name of the equipment.
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
         * Get a brief description of the equipment.
         *
         * @return string|null
         */
        public function getDescription(): ?string
        {
            return $this->description;
        }

        /**
         * Set a brief description of the equipment.
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
         * Get the path or URL to a photo representing the equipment.
         *
         * @return string|null
         */
        public function getPhoto(): ?string
        {
            return $this->photo;
        }

        /**
         * Set the path or URL to a photo representing the equipment.
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
         * Get the total stock available for the equipment.
         *
         * @return int
         */
        public function getTotalStock(): int
        {
            return $this->totalStock;
        }

        /**
         * Set the total stock available for the equipment.
         *
         * @param int $totalStock
         *
         * @return $this
         */
        public function setTotalStock(int $totalStock): self
        {
            $this->totalStock = $totalStock;

            return $this;
        }

        /**
         * Get the timestamp when the equipment was created.
         *
         * @return \DateTime
         */
        public function getCreatedAt(): \DateTime
        {
            return $this->createdAt;
        }

        /**
         * Get the timestamp when the equipment was last updated.
         *
         * @return \DateTime|null
         */
        public function getUpdatedAt(): ?\DateTime
        {
            return $this->updatedAt;
        }

        /**
         * Set the timestamp when the equipment was last updated.
         *
         * @param \DateTime|null $updatedAt
         *
         * @return $this
         */
        public function setUpdatedAt(?\DateTime $updatedAt): self
        {
            $this->updatedAt = $updatedAt;

            return $this;
        }
    }
