<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getUsersCount(): int
    {
        $qb = $this->createQueryBuilder('u')
        ->select('COUNT(u)');

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function getValidatedUsersCount(): int
    {
        $qb = $this->createQueryBuilder('u')
            ->select('COUNT(u)')
            ->where('u.isVerified = :isVerified')
            ->setParameter('isVerified', 1);

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function getAdminUsersCount(): int
    {
        $qb = $this->createQueryBuilder('u')
            ->select('COUNT(u)')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%"ROLE_ADMIN"%');
    
        $query = $qb->getQuery();
    
        return $query->getSingleScalarResult();
    }

    public function getGestionnaireUsersCount(): int
    {
        $qb = $this->createQueryBuilder('u')
            ->select('COUNT(u)')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%"ROLE_GESTIONNAIRE"%');
    
        $query = $qb->getQuery();
    
        return $query->getSingleScalarResult();
    }
    


    public function getMemberUsersCount(): int
    {
        $qb = $this->createQueryBuilder('u')
            ->select('COUNT(u)')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%"ROLE_MEMBER"%');
    
        $query = $qb->getQuery();
    
        return $query->getSingleScalarResult();
    }
    


    public function getClientUsersCount(): int
    {
        $qb = $this->createQueryBuilder('u')
            ->select('COUNT(u)')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%"ROLE_CLIENT"%');
    
        $query = $qb->getQuery();
    
        return $query->getSingleScalarResult();
    }
    

    


    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
