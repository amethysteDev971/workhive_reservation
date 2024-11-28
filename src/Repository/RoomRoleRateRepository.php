<?php

    namespace App\Repository;

    use App\Entity\RoomRoleRate;
    use App\Enum\UserRole;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    /**
     * Repository class for the RoomRoleRate entity.
     *
     * @extends ServiceEntityRepository<RoomRoleRate>
     */
    class RoomRoleRateRepository extends ServiceEntityRepository
    {
        /**
         * Constructor for the RoomRoleRate repository.
         *
         * @param ManagerRegistry $registry The manager registry for the repository.
         */
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, RoomRoleRate::class);
        }

        /**
         * Finds all role rates for a specific room.
         *
         * @param int $roomId The ID of the room.
         *
         * @return RoomRoleRate[] Returns an array of RoomRoleRate objects.
         */
        public function findByRoom(int $roomId): array
        {
            return $this->createQueryBuilder('rrr')
                ->andWhere('rrr.room = :roomId')
                ->setParameter('roomId', $roomId)
                ->orderBy('rrr.userRole', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds the hourly rate for a specific user role and room.
         *
         * @param int      $roomId   The ID of the room.
         * @param UserRole $userRole The user role to search for.
         *
         * @return RoomRoleRate|null Returns the RoomRoleRate object or null if not found.
         */
        public function findRateByRoomAndRole(int $roomId, UserRole $userRole): ?RoomRoleRate
        {
            return $this->createQueryBuilder('rrr')
                ->andWhere('rrr.room = :roomId')
                ->andWhere('rrr.userRole = :userRole')
                ->setParameter('roomId', $roomId)
                ->setParameter('userRole', $userRole->value)
                ->getQuery()
                ->getOneOrNullResult();
        }

        /**
         * Finds all role rates within a specific hourly rate range.
         *
         * @param float $minRate The minimum hourly rate.
         * @param float $maxRate The maximum hourly rate.
         *
         * @return RoomRoleRate[] Returns an array of RoomRoleRate objects.
         */
        public function findByRateRange(float $minRate, float $maxRate): array
        {
            return $this->createQueryBuilder('rrr')
                ->andWhere('rrr.hourlyRate BETWEEN :minRate AND :maxRate')
                ->setParameter('minRate', $minRate)
                ->setParameter('maxRate', $maxRate)
                ->orderBy('rrr.hourlyRate', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds all unique user roles for a specific room.
         *
         * @param int $roomId The ID of the room.
         *
         * @return string[] Returns an array of user role strings.
         */
        public function findRolesByRoom(int $roomId): array
        {
            return $this->createQueryBuilder('rrr')
                ->select('DISTINCT rrr.userRole')
                ->andWhere('rrr.room = :roomId')
                ->setParameter('roomId', $roomId)
                ->getQuery()
                ->getSingleColumnResult();
        }
    }
