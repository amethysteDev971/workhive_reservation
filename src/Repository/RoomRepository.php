<?php

    namespace App\Repository;

    use App\Entity\Room;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    /**
     * Repository class for the Room entity.
     *
     * @extends ServiceEntityRepository<Room>
     */
    class RoomRepository extends ServiceEntityRepository
    {
        /**
         * Constructor for the Room repository.
         *
         * @param ManagerRegistry $registry The manager registry for the repository.
         */
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, Room::class);
        }

        /**
         * Finds all active rooms.
         *
         * @return Room[] Returns an array of active Room objects.
         */
        public function findActiveRooms(): array
        {
            return $this->createQueryBuilder('r')
                ->andWhere('r.status = :status')
                ->setParameter('status', 'active')
                ->orderBy('r.name', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds a room by its name.
         *
         * @param string $name The name of the room.
         * @return Room|null Returns the Room object if found, or null otherwise.
         */
        public function findByName(string $name): ?Room
        {
            return $this->createQueryBuilder('r')
                ->andWhere('r.name = :name')
                ->setParameter('name', $name)
                ->getQuery()
                ->getOneOrNullResult();
        }

        /**
         * Finds rooms by capacity range.
         *
         * @param int $minCapacity The minimum capacity.
         * @param int $maxCapacity The maximum capacity.
         * @return Room[] Returns an array of Room objects within the capacity range.
         */
        public function findByCapacityRange(int $minCapacity, int $maxCapacity): array
        {
            return $this->createQueryBuilder('r')
                ->andWhere('r.capacity BETWEEN :min AND :max')
                ->setParameter('min', $minCapacity)
                ->setParameter('max', $maxCapacity)
                ->orderBy('r.capacity', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds rooms that are inactive.
         *
         * @return Room[] Returns an array of inactive Room objects.
         */
        public function findInactiveRooms(): array
        {
            return $this->createQueryBuilder('r')
                ->andWhere('r.status = :status')
                ->setParameter('status', 'inactive')
                ->orderBy('r.name', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds rooms with specific dimensions.
         *
         * @param float $minWidth The minimum width.
         * @param float $minLength The minimum length.
         * @return Room[] Returns an array of Room objects that meet the dimensions.
         */
        public function findByDimensions(float $minWidth, float $minLength): array
        {
            return $this->createQueryBuilder('r')
                ->andWhere('r.width >= :minWidth')
                ->andWhere('r.length >= :minLength')
                ->setParameter('minWidth', $minWidth)
                ->setParameter('minLength', $minLength)
                ->orderBy('r.name', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds the total number of active rooms.
         *
         * @return int Returns the total count of active rooms.
         */
        public function countActiveRooms(): int
        {
            return (int) $this->createQueryBuilder('r')
                ->select('COUNT(r.id)')
                ->andWhere('r.status = :status')
                ->setParameter('status', 'active')
                ->getQuery()
                ->getSingleScalarResult();
        }
    }
