<?php

namespace App\Repository;

use App\Entity\CategoriePlat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoriePlat|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoriePlat|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoriePlat[]    findAll()
 * @method CategoriePlat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriePlatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoriePlat::class);
    }

    /**
      * @return CategoriePlat[] Returns an array of CategoriePlat objects
      */
	public function findCategoriesWithNoMenu()
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.menu is null')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?CategoriePlat
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
