<?php

    namespace App\Repository;

    use App\Entity\DateSchedules;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    /**
     * Repository class for the DateSchedules entity.
     *
     * @extends ServiceEntityRepository<DateSchedules>
     */
    class DateSchedulesRepository extends ServiceEntityRepository
    {
        /**
         * Constructor for the DateSchedules repository.
         *
         * @param ManagerRegistry $registry The manager registry for the repository.
         */
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, DateSchedules::class);
        }

        /**
         * Finds all schedules for a specific room.
         *
         * @param int $roomId The ID of the room.
         *
         * @return DateSchedules[] Returns an array of DateSchedules objects.
         */
        public function findByRoom(int $roomId): array
        {
            return $this->createQueryBuilder('ds')
                ->andWhere('ds.room = :roomId')
                ->setParameter('roomId', $roomId)
                ->orderBy('ds.date', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds schedules that fall on a specific date.
         *
         * @param \DateTimeInterface $date The date to search for.
         *
         * @return DateSchedules[] Returns an array of DateSchedules objects.
         */
        public function findByDate(\DateTimeInterface $date): array
        {
            return $this->createQueryBuilder('ds')
                ->andWhere('ds.date = :date')
                ->setParameter('date', $date->format('Y-m-d'))
                ->orderBy('ds.startedAt', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds schedules that fall within a specific date range.
         *
         * @param \DateTimeInterface $startDate The start date of the range.
         * @param \DateTimeInterface $endDate   The end date of the range.
         *
         * @return DateSchedules[] Returns an array of DateSchedules objects.
         */
        public function findByDateRange(\DateTimeInterface $startDate, \DateTimeInterface $endDate): array
        {
            return $this->createQueryBuilder('ds')
                ->andWhere('ds.date BETWEEN :startDate AND :endDate')
                ->setParameter('startDate', $startDate->format('Y-m-d'))
                ->setParameter('endDate', $endDate->format('Y-m-d'))
                ->orderBy('ds.date', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds all open schedules for a specific room on a given date.
         *
         * @param int                $roomId The ID of the room.
         * @param \DateTimeInterface $date   The date to search for.
         *
         * @return DateSchedules[] Returns an array of open DateSchedules objects.
         */
        public function findOpenSchedulesByRoomAndDate(int $roomId, \DateTimeInterface $date): array
        {
            return $this->createQueryBuilder('ds')
                ->andWhere('ds.room = :roomId')
                ->andWhere('ds.date = :date')
                ->andWhere('ds.isOpen = true')
                ->setParameter('roomId', $roomId)
                ->setParameter('date', $date->format('Y-m-d'))
                ->orderBy('ds.startedAt', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds schedules by room that overlap with a specific time range on a given date.
         *
         * @param int                $roomId    The ID of the room.
         * @param \DateTimeInterface $date      The date to search for.
         * @param \DateTimeInterface $startTime The start time of the range.
         * @param \DateTimeInterface $endTime   The end time of the range.
         *
         * @return DateSchedules[] Returns an array of overlapping DateSchedules objects.
         */
        public function findOverlappingSchedules(
            int $roomId,
            \DateTimeInterface $date,
            \DateTimeInterface $startTime,
            \DateTimeInterface $endTime
        ): array {
            return $this->createQueryBuilder('ds')
                ->andWhere('ds.room = :roomId')
                ->andWhere('ds.date = :date')
                ->andWhere('((ds.startedAt < :endTime AND ds.endedAt > :startTime))')
                ->setParameter('roomId', $roomId)
                ->setParameter('date', $date->format('Y-m-d'))
                ->setParameter('startTime', $startTime->format('H:i:s'))
                ->setParameter('endTime', $endTime->format('H:i:s'))
                ->orderBy('ds.startedAt', 'ASC')
                ->getQuery()
                ->getResult();
        }
    }
