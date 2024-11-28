<?php

    namespace App\Repository;

    use App\Entity\Reservation;
    use App\Enum\ReservationStatus;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    /**
     * Repository class for the Reservation entity.
     *
     * @extends ServiceEntityRepository<Reservation>
     */
    class ReservationRepository extends ServiceEntityRepository
    {
        /**
         * Constructor for the Reservation repository.
         *
         * @param ManagerRegistry $registry The manager registry for the repository.
         */
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, Reservation::class);
        }

        /**
         * Finds all reservations for a specific user.
         *
         * @param int $userId The ID of the user.
         * @return Reservation[] Returns an array of Reservation objects.
         */
        public function findByUser(int $userId): array
        {
            return $this->createQueryBuilder('r')
                ->andWhere('r.user = :userId')
                ->setParameter('userId', $userId)
                ->orderBy('r.startAt', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds all reservations for a specific room.
         *
         * @param int $roomId The ID of the room.
         * @return Reservation[] Returns an array of Reservation objects.
         */
        public function findByRoom(int $roomId): array
        {
            return $this->createQueryBuilder('r')
                ->andWhere('r.room = :roomId')
                ->setParameter('roomId', $roomId)
                ->orderBy('r.startAt', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds all reservations within a specific date range.
         *
         * @param \DateTimeInterface $startDate The start date.
         * @param \DateTimeInterface $endDate The end date.
         * @return Reservation[] Returns an array of Reservation objects.
         */
        public function findByDateRange(\DateTimeInterface $startDate, \DateTimeInterface $endDate): array
        {
            return $this->createQueryBuilder('r')
                ->andWhere('r.startAt BETWEEN :startDate AND :endDate OR r.endAt BETWEEN :startDate AND :endDate')
                ->setParameter('startDate', $startDate->format('Y-m-d H:i:s'))
                ->setParameter('endDate', $endDate->format('Y-m-d H:i:s'))
                ->orderBy('r.startAt', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds reservations for a specific room that overlap with a given time range.
         *
         * @param int $roomId The ID of the room.
         * @param \DateTimeInterface $startTime The start time.
         * @param \DateTimeInterface $endTime The end time.
         * @return Reservation[] Returns an array of overlapping Reservation objects.
         */
        public function findOverlappingReservations(int $roomId, \DateTimeInterface $startTime, \DateTimeInterface $endTime): array
        {
            return $this->createQueryBuilder('r')
                ->andWhere('r.room = :roomId')
                ->andWhere('r.startAt < :endTime AND r.endAt > :startTime')
                ->setParameter('roomId', $roomId)
                ->setParameter('startTime', $startTime->format('Y-m-d H:i:s'))
                ->setParameter('endTime', $endTime->format('Y-m-d H:i:s'))
                ->orderBy('r.startAt', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds reservations with a specific status.
         *
         * @param ReservationStatus $status The status to filter by.
         * @return Reservation[] Returns an array of Reservation objects with the specified status.
         */
        public function findByStatus(ReservationStatus $status): array
        {
            return $this->createQueryBuilder('r')
                ->andWhere('r.status = :status')
                ->setParameter('status', $status->value)
                ->orderBy('r.startAt', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds the next reservation for a specific room.
         *
         * @param int $roomId The ID of the room.
         * @return Reservation|null Returns the next Reservation object, or null if none found.
         */
        public function findNextReservationForRoom(int $roomId): ?Reservation
        {
            return $this->createQueryBuilder('r')
                ->andWhere('r.room = :roomId')
                ->andWhere('r.startAt > :now')
                ->setParameter('roomId', $roomId)
                ->setParameter('now', new \DateTime())
                ->orderBy('r.startAt', 'ASC')
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
        }
    }
