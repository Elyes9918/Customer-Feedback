<?php

namespace App\Repository;

use App\Entity\Feedback;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Feedback>
 *
 * @method Feedback|null find($id, $lockMode = null, $lockVersion = null)
 * @method Feedback|null findOneBy(array $criteria, array $orderBy = null)
 * @method Feedback[]    findAll()
 * @method Feedback[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeedbackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feedback::class);
    }

    
    public function getAllFeedbacksByIdUser(string $id): array
    {
        $qb = $this->createQueryBuilder('p')
            ->join('p.users', 'u')
            ->where('u.token_id = :id')
            ->setParameter('id', $id);

        $query = $qb->getQuery();

        return $query->getResult();
    }

    public function getAllFeedbacksByIdProject(string $projectId): array
    {
        $qb = $this->createQueryBuilder('f')
            ->where('f.project = :projectId') // replace "projectId" with your desired project id
            ->setParameter('projectId', $projectId);

        $query = $qb->getQuery();

        return $query->getResult();
    }


    

    public function save(Feedback $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Feedback $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Feedback[] Returns an array of Feedback objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Feedback
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
