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

    public function getTotalfeedbacksCount(): int
    {

        $qb = $this->createQueryBuilder('f')
        ->select('COUNT(f)');

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function getAverageFeedbacksCountPerProject(): float
    {
        $qb = $this->createQueryBuilder('f')
            ->select('COUNT(f)')
            ->groupBy('f.project');
    
        $query = $qb->getQuery();
        $results = $query->getScalarResult();
    
        $feedbacksCount = 0;
        $projectsCount = count($results);
    
        foreach ($results as $result) {
            $feedbacksCount += $result[1];
        }
    
        if ($projectsCount > 0) {
            $averageFeedbacksCount = $feedbacksCount / $projectsCount;
            $formattedAverage = number_format($averageFeedbacksCount, 2);
            return (float) $formattedAverage;
        }
    
        return 0;
    }

    public function getFeedbacksStatus(): array
    {

        $qb0 = $this->createQueryBuilder('f')
        ->select('COUNT(f)')
        ->where('f.status = 0');
        $query0 = $qb0->getQuery();

        $qb1 = $this->createQueryBuilder('f')
        ->select('COUNT(f)')
        ->where('f.status = 1');
        $query1 = $qb1->getQuery();

        $qb2 = $this->createQueryBuilder('f')
        ->select('COUNT(f)')
        ->where('f.status = 2');
        $query2 = $qb2->getQuery();

        $qb3 = $this->createQueryBuilder('f')
        ->select('COUNT(f)')
        ->where('f.status = 3');
        $query3 = $qb3->getQuery();



        $openFeedbacksCount = strval($query0->getSingleScalarResult());
        $inProgressFeedbacksCount = strval($query1->getSingleScalarResult());
        $toReviewFeedbacksCount = strval($query2->getSingleScalarResult());
        $completedFeedbacksCount = strval($query3->getSingleScalarResult());


        $feedbacksStatus = [
            'openFeedbacks' => $openFeedbacksCount,
            'inProgressFeedbacks' => $inProgressFeedbacksCount,
            'toReviewFeedbacks' => $toReviewFeedbacksCount,
            'completedFeedbacks' => $completedFeedbacksCount
        ];

        return $feedbacksStatus;

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
