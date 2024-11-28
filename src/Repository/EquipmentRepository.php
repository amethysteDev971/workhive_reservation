<?php

    namespace App\Repository;

    use App\Entity\Equipment;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    /**
     * Repository class for the Equipment entity.
     *
     * @extends ServiceEntityRepository<Equipment>
     */
    class EquipmentRepository extends ServiceEntityRepository
    {
        /**
         * Constructor for the Equipment repository.
         *
         * @param ManagerRegistry $registry The manager registry for the repository.
         */
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, Equipment::class);
        }

        /**
         * Finds all active equipment.
         *
         * @return Equipment[] Returns an array of active Equipment objects.
         */
        public function findActiveEquipment(): array
        {
            return $this->createQueryBuilder('e')
                ->andWhere('e.totalStock > 0')
                ->orderBy('e.name', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds equipment by name.
         *
         * @param string $name The name of the equipment to search for.
         * @return Equipment[] Returns an array of Equipment objects matching the name.
         */
        public function findByName(string $name): array
        {
            return $this->createQueryBuilder('e')
                ->andWhere('e.name LIKE :name')
                ->setParameter('name', '%' . $name . '%')
                ->orderBy('e.name', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds equipment with stock below a specified threshold.
         *
         * @param int $threshold The stock threshold.
         * @return Equipment[] Returns an array of Equipment objects with low stock.
         */
        public function findLowStockEquipment(int $threshold): array
        {
            return $this->createQueryBuilder('e')
                ->andWhere('e.totalStock < :threshold')
                ->setParameter('threshold', $threshold)
                ->orderBy('e.totalStock', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds all equipment added within a specific date range.
         *
         * @param \DateTimeInterface $startDate The start date.
         * @param \DateTimeInterface $endDate The end date.
         * @return Equipment[] Returns an array of Equipment objects added within the date range.
         */
        public function findByDateRange(\DateTimeInterface $startDate, \DateTimeInterface $endDate): array
        {
            return $this->createQueryBuilder('e')
                ->andWhere('e.createdAt BETWEEN :startDate AND :endDate')
                ->setParameter('startDate', $startDate->format('Y-m-d'))
                ->setParameter('endDate', $endDate->format('Y-m-d'))
                ->orderBy('e.createdAt', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds equipment by ID and ensures it's active.
         *
         * @param int $id The ID of the equipment.
         * @return Equipment|null Returns the Equipment object if found and active, or null otherwise.
         */
        public function findActiveById(int $id): ?Equipment
        {
            return $this->createQueryBuilder('e')
                ->andWhere('e.id = :id')
                ->andWhere('e.totalStock > 0')
                ->setParameter('id', $id)
                ->getQuery()
                ->getOneOrNullResult();
        }
    }
