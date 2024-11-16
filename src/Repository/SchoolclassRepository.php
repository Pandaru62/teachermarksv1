<?php

namespace App\Repository;

use App\Entity\Schoolclass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Schoolclass>
 */
class SchoolclassRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Schoolclass::class);
    }

    public function isDarkBackground($hexColor) {
        // Remove the '#' if present
        $hexColor = str_replace('#', '', $hexColor);
    
        // Convert hex to RGB
        $r = hexdec(substr($hexColor, 0, 2));
        $g = hexdec(substr($hexColor, 2, 2));
        $b = hexdec(substr($hexColor, 4, 2));
    
        // Calculate luminance
        $luminance = ($r * 0.299 + $g * 0.587 + $b * 0.114);
    
        // Return true if the background is dark (luminance < 128)
        return $luminance < 128;
    }


//    /**
//     * @return Schoolclass[] Returns an array of Schoolclass objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Schoolclass
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
