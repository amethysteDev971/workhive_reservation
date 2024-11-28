<?php

    namespace App\Repository;

    use App\Entity\User;
    use App\Enum\UserRole;
    use App\Enum\Status;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    /**
     * Repository class for the User entity.
     *
     * @extends ServiceEntityRepository<User>
     */
    class UserRepository extends ServiceEntityRepository
    {
        /**
         * Constructor for the User repository.
         *
         * @param ManagerRegistry $registry The manager registry for the repository.
         */
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, User::class);
        }

        /**
         * Finds all users by status.
         *
         * @param Status $status The status to filter by (e.g., active or inactive).
         *
         * @return User[] Returns an array of User objects with the specified status.
         */
        public function findByStatus(Status $status): array
        {
            return $this->createQueryBuilder('u')
                ->andWhere('u.status = :status')
                ->setParameter('status', $status->value)
                ->orderBy('u.createdAt', 'DESC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds all users with a specific role.
         *
         * @param UserRole $role The role to filter by (e.g., admin, user, member).
         *
         * @return User[] Returns an array of User objects with the specified role.
         */
        public function findByRole(UserRole $role): array
        {
            return $this->createQueryBuilder('u')
                ->andWhere('u.userRole = :role')
                ->setParameter('role', $role->value)
                ->orderBy('u.lastName', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds a user by their email.
         *
         * @param string $email The email to search for.
         *
         * @return User|null Returns the User object if found, or null otherwise.
         */
        public function findByEmail(string $email): ?User
        {
            return $this->createQueryBuilder('u')
                ->andWhere('u.email = :email')
                ->setParameter('email', $email)
                ->getQuery()
                ->getOneOrNullResult();
        }

        /**
         * Finds all users created within a specific date range.
         *
         * @param \DateTimeInterface $startDate The start date of the range.
         * @param \DateTimeInterface $endDate   The end date of the range.
         *
         * @return User[] Returns an array of User objects created within the date range.
         */
        public function findByCreationDateRange(\DateTimeInterface $startDate, \DateTimeInterface $endDate): array
        {
            return $this->createQueryBuilder('u')
                ->andWhere('u.createdAt BETWEEN :startDate AND :endDate')
                ->setParameter('startDate', $startDate->format('Y-m-d H:i:s'))
                ->setParameter('endDate', $endDate->format('Y-m-d H:i:s'))
                ->orderBy('u.createdAt', 'ASC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Finds all active users.
         *
         * @return User[] Returns an array of active User objects.
         */
        public function findActiveUsers(): array
        {
            return $this->findByStatus(Status::ACTIVE);
        }

        /**
         * Counts the total number of users by role.
         *
         * @param UserRole $role The role to count (e.g., admin, user, member).
         *
         * @return int Returns the total number of users with the specified role.
         */
        public function countByRole(UserRole $role): int
        {
            return (int)$this->createQueryBuilder('u')
                ->select('COUNT(u.id)')
                ->andWhere('u.userRole = :role')
                ->setParameter('role', $role->value)
                ->getQuery()
                ->getSingleScalarResult();
        }
    }
