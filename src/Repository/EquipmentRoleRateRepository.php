<?php

    namespace App\Repository;

    use App\Entity\Equipment;
    use App\Entity\EquipmentRoleRate;
    use App\Enum\UserRole;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    /**
     * Repository class for the EquipmentRoleRate entity.
     *
     * @extends ServiceEntityRepository<EquipmentRoleRate>
     */
    class EquipmentRoleRateRepository extends ServiceEntityRepository
    {
        /**
         * Constructor for the EquipmentRoleRate repository.
         *
         * @param ManagerRegistry $registry The manager registry for the repository.
         */
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, EquipmentRoleRate::class);
        }

        /**
         * Finds all role rates for a specific equipment.
         *
         * @param int $equipmentId The ID of the equipment.
         * @return EquipmentRoleRate[] Returns an array of EquipmentRoleRate objects.
         */
        public function findByEquipment(int $equipmentId): array
        {
            return $this->createQueryBuilder('err')
                ->andWhere('err.equipment = :equipmentId')
                ->setParameter('equipmentId', $equipmentId)
                ->orderBy('err.userRole', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds the hourly rate for a specific role and equipment.
         *
         * @param int $equipmentId The ID of the equipment.
         * @param UserRole $userRole The user role to search for.
         * @return EquipmentRoleRate|null Returns the EquipmentRoleRate object or null if not found.
         */
        public function findRateByRoleAndEquipment(int $equipmentId, UserRole $userRole): ?EquipmentRoleRate
        {
            return $this->createQueryBuilder('err')
                ->andWhere('err.equipment = :equipmentId')
                ->andWhere('err.userRole = :userRole')
                ->setParameter('equipmentId', $equipmentId)
                ->setParameter('userRole', $userRole->value)
                ->getQuery()
                ->getOneOrNullResult();
        }

        /**
         * Finds all role rates within a specific hourly rate range.
         *
         * @param float $minRate The minimum hourly rate.
         * @param float $maxRate The maximum hourly rate.
         * @return EquipmentRoleRate[] Returns an array of EquipmentRoleRate objects.
         */
        public function findByRateRange(float $minRate, float $maxRate): array
        {
            return $this->createQueryBuilder('err')
                ->andWhere('err.hourlyRate BETWEEN :minRate AND :maxRate')
                ->setParameter('minRate', $minRate)
                ->setParameter('maxRate', $maxRate)
                ->orderBy('err.hourlyRate', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds all unique user roles for a specific equipment.
         *
         * @param int $equipmentId The ID of the equipment.
         * @return string[] Returns an array of user role strings.
         */
        public function findRolesByEquipment(int $equipmentId): array
        {
            return $this->createQueryBuilder('err')
                ->select('DISTINCT err.userRole')
                ->andWhere('err.equipment = :equipmentId')
                ->setParameter('equipmentId', $equipmentId)
                ->getQuery()
                ->getSingleColumnResult();
        }
    }
