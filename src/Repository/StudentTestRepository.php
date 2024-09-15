<?php

namespace App\Repository;

use App\Entity\StudentTest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StudentTest>
 */
class StudentTestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudentTest::class);
    }

    public function findByTestOrderedByStudentLastname($testid)
    {
        return $this->createQueryBuilder('st')
            ->join('st.student', 's')
            ->where('st.test = :testid')
            ->setParameter('testid', $testid)
            ->orderBy('s.lastname', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
