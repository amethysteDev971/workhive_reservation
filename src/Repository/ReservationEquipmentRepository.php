<?php

    namespace App\Repository;

    use App\Entity\ReservationEquipment;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    /**
     * Repository class for the ReservationEquipment entity.
     *
     * @extends ServiceEntityRepository<ReservationEquipment>
     */
    class ReservationEquipmentRepository extends ServiceEntityRepository
    {
        /**
         * Constructor for the ReservationEquipment repository.
         *
         * @param ManagerRegistry $registry The manager registry for the repository.
         */
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, ReservationEquipment::class);
        }

        /**
         * Finds all equipment reserved for a specific reservation.
         *
         * @param int $reservationId The ID of the reservation.
         *
         * @return ReservationEquipment[] Returns an array of ReservationEquipment objects.
         */
        public function findByReservation(int $reservationId): array
        {
            return $this->createQueryBuilder('re')
                ->andWhere('re.reservation = :reservationId')
                ->setParameter('reservationId', $reservationId)
                ->orderBy('re.id', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds all reservations using a specific equipment item.
         *
         * @param int $equipmentId The ID of the equipment.
         *
         * @return ReservationEquipment[] Returns an array of ReservationEquipment objects.
         */
        public function findByEquipment(int $equipmentId): array
        {
            return $this->createQueryBuilder('re')
                ->andWhere('re.equipment = :equipmentId')
                ->setParameter('equipmentId', $equipmentId)
                ->orderBy('re.id', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds all reservations using a specific equipment item within a date range.
         *
         * @param int                $equipmentId The ID of the equipment.
         * @param \DateTimeInterface $startDate   The start date of the range.
         * @param \DateTimeInterface $endDate     The end date of the range.
         *
         * @return ReservationEquipment[] Returns an array of ReservationEquipment objects.
         */
        public function findByEquipmentAndDateRange(
            int $equipmentId,
            \DateTimeInterface $startDate,
            \DateTimeInterface $endDate
        ): array {
            return $this->createQueryBuilder('re')
                ->join('re.reservation', 'r')
                ->andWhere('re.equipment = :equipmentId')
                ->andWhere('r.startAt BETWEEN :startDate AND :endDate OR r.endAt BETWEEN :startDate AND :endDate')
                ->setParameter('equipmentId', $equipmentId)
                ->setParameter('startDate', $startDate->format('Y-m-d H:i:s'))
                ->setParameter('endDate', $endDate->format('Y-m-d H:i:s'))
                ->orderBy('r.startAt', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds the total quantity of equipment reserved for a specific reservation.
         *
         * @param int $reservationId The ID of the reservation.
         *
         * @return int Returns the total quantity of equipment reserved.
         */
        public function getTotalQuantityByReservation(int $reservationId): int
        {
            return (int)$this->createQueryBuilder('re')
                ->select('SUM(re.quantity)')
                ->andWhere('re.reservation = :reservationId')
                ->setParameter('reservationId', $reservationId)
                ->getQuery()
                ->getSingleScalarResult();
        }
    }
