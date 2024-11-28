<?php

    namespace App\Repository;

    use App\Entity\WeekSchedules;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    /**
     * Repository class for the WeekSchedules entity.
     *
     * @extends ServiceEntityRepository<WeekSchedules>
     */
    class WeekSchedulesRepository extends ServiceEntityRepository
    {
        /**
         * Constructor for the WeekSchedules repository.
         *
         * @param ManagerRegistry $registry The manager registry for the repository.
         */
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, WeekSchedules::class);
        }

        /**
         * Finds all schedules for a specific room.
         *
         * @param int $roomId The ID of the room.
         *
         * @return WeekSchedules[] Returns an array of WeekSchedules objects.
         */
        public function findByRoom(int $roomId): array
        {
            return $this->createQueryBuilder('ws')
                ->andWhere('ws.room = :roomId')
                ->setParameter('roomId', $roomId)
                ->orderBy('ws.weekDay', 'ASC')
                ->addOrderBy('ws.startedAt', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds all schedules for a specific day of the week.
         *
         * @param int $weekDay The day of the week (0 = Sunday, 6 = Saturday).
         *
         * @return WeekSchedules[] Returns an array of WeekSchedules objects.
         */
        public function findByWeekDay(int $weekDay): array
        {
            return $this->createQueryBuilder('ws')
                ->andWhere('ws.weekDay = :weekDay')
                ->setParameter('weekDay', $weekDay)
                ->orderBy('ws.startedAt', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds all schedules for a specific room on a specific day of the week.
         *
         * @param int $roomId  The ID of the room.
         * @param int $weekDay The day of the week (0 = Sunday, 6 = Saturday).
         *
         * @return WeekSchedules[] Returns an array of WeekSchedules objects.
         */
        public function findByRoomAndWeekDay(int $roomId, int $weekDay): array
        {
            return $this->createQueryBuilder('ws')
                ->andWhere('ws.room = :roomId')
                ->andWhere('ws.weekDay = :weekDay')
                ->setParameter('roomId', $roomId)
                ->setParameter('weekDay', $weekDay)
                ->orderBy('ws.startedAt', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds overlapping schedules for a specific room and day.
         *
         * @param int                $roomId    The ID of the room.
         * @param int                $weekDay   The day of the week (0 = Sunday, 6 = Saturday).
         * @param \DateTimeInterface $startTime The start time of the range.
         * @param \DateTimeInterface $endTime   The end time of the range.
         *
         * @return WeekSchedules[] Returns an array of overlapping WeekSchedules objects.
         */
        public function findOverlappingSchedules(
            int $roomId,
            int $weekDay,
            \DateTimeInterface $startTime,
            \DateTimeInterface $endTime
        ): array {
            return $this->createQueryBuilder('ws')
                ->andWhere('ws.room = :roomId')
                ->andWhere('ws.weekDay = :weekDay')
                ->andWhere('(
                (ws.startedAt < :endTime AND ws.endedAt > :startTime)
            )')
                ->setParameter('roomId', $roomId)
                ->setParameter('weekDay', $weekDay)
                ->setParameter('startTime', $startTime->format('H:i:s'))
                ->setParameter('endTime', $endTime->format('H:i:s'))
                ->orderBy('ws.startedAt', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds all schedules for a specific week and room.
         *
         * @param int $roomId The ID of the room.
         *
         * @return array Returns an array grouped by days of the week with schedules.
         */
        public function findGroupedByWeekDay(int $roomId): array
        {
            $schedules = $this->findByRoom($roomId);
            $grouped = [];

            foreach ($schedules as $schedule) {
                $grouped[$schedule->getWeekDay()][] = $schedule;
            }

            return $grouped;
        }
    }
