<?php

    namespace App\Repository;

    use App\Entity\PaymentMethod;
    use App\Entity\User;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    /**
     * Repository class for the PaymentMethod entity.
     *
     * @extends ServiceEntityRepository<PaymentMethod>
     */
    class PaymentMethodRepository extends ServiceEntityRepository
    {
        /**
         * Constructor for the PaymentMethod repository.
         *
         * @param ManagerRegistry $registry The manager registry for the repository.
         */
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, PaymentMethod::class);
        }

        /**
         * Finds all payment methods for a specific user.
         *
         * @param int $userId The ID of the user.
         * @return PaymentMethod[] Returns an array of PaymentMethod objects.
         */
        public function findByUser(int $userId): array
        {
            return $this->createQueryBuilder('pm')
                ->andWhere('pm.user = :userId')
                ->setParameter('userId', $userId)
                ->orderBy('pm.createdAt', 'DESC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds a payment method by its label for a specific user.
         *
         * @param int $userId The ID of the user.
         * @param string $label The label of the payment method.
         * @return PaymentMethod|null Returns the PaymentMethod object if found, or null otherwise.
         */
        public function findByUserAndLabel(int $userId, string $label): ?PaymentMethod
        {
            return $this->createQueryBuilder('pm')
                ->andWhere('pm.user = :userId')
                ->andWhere('pm.label = :label')
                ->setParameter('userId', $userId)
                ->setParameter('label', $label)
                ->getQuery()
                ->getOneOrNullResult();
        }

        /**
         * Finds all payment methods of a specific type for a user.
         *
         * @param int $userId The ID of the user.
         * @param string $type The type of payment method (e.g., 'card', 'paypal').
         * @return PaymentMethod[] Returns an array of PaymentMethod objects.
         */
        public function findByUserAndType(int $userId, string $type): array
        {
            return $this->createQueryBuilder('pm')
                ->andWhere('pm.user = :userId')
                ->andWhere('pm.type = :type')
                ->setParameter('userId', $userId)
                ->setParameter('type', $type)
                ->orderBy('pm.createdAt', 'DESC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds all active payment methods for a specific user.
         *
         * @param int $userId The ID of the user.
         * @return PaymentMethod[] Returns an array of active PaymentMethod objects.
         */
        public function findActiveByUser(int $userId): array
        {
            return $this->createQueryBuilder('pm')
                ->andWhere('pm.user = :userId')
                ->andWhere('pm.updatedAt IS NULL OR pm.updatedAt > :now')
                ->setParameter('userId', $userId)
                ->setParameter('now', new \DateTime())
                ->orderBy('pm.createdAt', 'DESC')
                ->getQuery()
                ->getResult();
        }
    }
