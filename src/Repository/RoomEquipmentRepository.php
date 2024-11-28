<?php

    namespace App\Repository;

    use App\Entity\RoomEquipment;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    /**
     * Repository class for the RoomEquipment entity.
     *
     * @extends ServiceEntityRepository<RoomEquipment>
     */
    class RoomEquipmentRepository extends ServiceEntityRepository
    {
        /**
         * Constructor for the RoomEquipment repository.
         *
         * @param ManagerRegistry $registry The manager registry for the repository.
         */
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, RoomEquipment::class);
        }

        /**
         * Finds all equipment assigned to a specific room.
         *
         * @param int $roomId The ID of the room.
         * @return RoomEquipment[] Returns an array of RoomEquipment objects.
         */
        public function findByRoom(int $roomId): array
        {
            return $this->createQueryBuilder('re')
                ->andWhere('re.room = :roomId')
                ->setParameter('roomId', $roomId)
                ->orderBy('re.assignedAt', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds all rooms that use a specific equipment item.
         *
         * @param int $equipmentId The ID of the equipment.
         * @return RoomEquipment[] Returns an array of RoomEquipment objects.
         */
        public function findByEquipment(int $equipmentId): array
        {
            return $this->createQueryBuilder('re')
                ->andWhere('re.equipment = :equipmentId')
                ->setParameter('equipmentId', $equipmentId)
                ->orderBy('re.assignedAt', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds the total quantity of a specific equipment assigned across all rooms.
         *
         * @param int $equipmentId The ID of the equipment.
         * @return int Returns the total quantity assigned.
         */
        public function getTotalQuantityByEquipment(int $equipmentId): int
        {
            return (int) $this->createQueryBuilder('re')
                ->select('SUM(re.quantity)')
                ->andWhere('re.equipment = :equipmentId')
                ->setParameter('equipmentId', $equipmentId)
                ->getQuery()
                ->getSingleScalarResult();
        }

        /**
         * Finds the total quantity of equipment assigned to a specific room.
         *
         * @param int $roomId The ID of the room.
         * @return int Returns the total quantity of equipment.
         */
        public function getTotalQuantityByRoom(int $roomId): int
        {
            return (int) $this->createQueryBuilder('re')
                ->select('SUM(re.quantity)')
                ->andWhere('re.room = :roomId')
                ->setParameter('roomId', $roomId)
                ->getQuery()
                ->getSingleScalarResult();
        }

        /**
         * Finds the assignment details for a specific equipment in a specific room.
         *
         * @param int $roomId The ID of the room.
         * @param int $equipmentId The ID of the equipment.
         * @return RoomEquipment|null Returns the RoomEquipment object or null if not found.
         */
        public function findByRoomAndEquipment(int $roomId, int $equipmentId): ?RoomEquipment
        {
            return $this->createQueryBuilder('re')
                ->andWhere('re.room = :roomId')
                ->andWhere('re.equipment = :equipmentId')
                ->setParameter('roomId', $roomId)
                ->setParameter('equipmentId', $equipmentId)
                ->getQuery()
                ->getOneOrNullResult();
        }
    }
