<?php

namespace App\Repository;

use App\Entity\Plane;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Plane|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plane|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plane[]    findAll()
 * @method Plane[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plane::class);
    }
}
