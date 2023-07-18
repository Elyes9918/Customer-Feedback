<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Project>
 *
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function getAllProjectsByIdUser(string $id): array
    {
        $qb = $this->createQueryBuilder('p')
            ->join('p.users', 'u')
            ->where('u.token_id = :id')
            ->setParameter('id', $id);

        $query = $qb->getQuery();

        return $query->getResult();
    }

    public function getProjectsCount(): int
    {
        $qb = $this->createQueryBuilder('p')
        ->select('COUNT(p)');

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    
    public function getCompletedProjectsCount(): int
    {
        $qb = $this->createQueryBuilder('p')
            ->select('COUNT(p)')
            ->where('p.status = :status')
            ->setParameter('status', 2);

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function getProjectStatus(): array
    {

        $qb0 = $this->createQueryBuilder('p')
        ->select('COUNT(p)')
        ->where('p.status = 0');
        $query0 = $qb0->getQuery();

        $qb1 = $this->createQueryBuilder('p')
        ->select('COUNT(p)')
        ->where('p.status = 1');
        $query1 = $qb1->getQuery();

        $qb2 = $this->createQueryBuilder('p')
        ->select('COUNT(p)')
        ->where('p.status = 2');
        $query2 = $qb2->getQuery();


        $openProjectsCount = strval($query0->getSingleScalarResult());
        $waitingProjectsCount = strval($query1->getSingleScalarResult());
        $closedProjectsCount = strval($query2->getSingleScalarResult());

        $projectsStatus = [
            'openProjects' => $openProjectsCount,
            'waitingProjects' => $waitingProjectsCount,
            'closedProjects' => $closedProjectsCount,
        ];

        return $projectsStatus;

    }

    public function getOrderedCompaniesWithTheMostProjects(): array
    {
        $qb = $this->createQueryBuilder('p')
        ->select('p.client AS company_name, COUNT(p) AS project_count')
        ->groupBy('p.client')
        ->orderBy('project_count', 'DESC');

        $query = $qb->getQuery();
        $results = $query->getResult();

        $orderedCompanies = [];
        foreach ($results as $result) {
            $companyName = $result['company_name'];
            $projectCount = $result['project_count'];
            $orderedCompanies[$companyName] = $projectCount;
        }

        return $orderedCompanies;    
    }

     // $qb = $this->createQueryBuilder('p');
        // $qb->select('p.client, COUNT(p) AS count');
        // $qb->groupBy('p.client');
        // $query = $qb->getQuery();

        // $array = [];
        // $results = $query->getResult();
        // foreach ($results as $row) {
        //     $company = $row['client'];
        //     $count = $row['count'];

        //     $array[$company] = $count;
        // }

        // krsort($array);

        // return array_keys($array, true);




    public function save(Project $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Project $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }



//    /**
//     * @return Project[] Returns an array of Project objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Project
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
