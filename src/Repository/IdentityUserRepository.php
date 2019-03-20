<?php

namespace App\Repository;

use App\Entity\IdentityUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IdentityUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method IdentityUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method IdentityUser[]    findAll()
 * @method IdentityUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdentityUserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IdentityUser::class);
    }

//    /**
//     * @return IdentityUser[] Returns an array of IdentityUser objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IdentityUser
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
