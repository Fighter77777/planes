<?php

namespace App\Repository;

use App\Entity\Hangar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class HangarRepository
 * @method Hangar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hangar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hangar[]    findAll()
 * @method Hangar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HangarRepository extends ServiceEntityRepository implements HangarRepositoryInterface, HangarSaveRepositoryInterface
{
    /**
     * HangarRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hangar::class);
    }

    /**
     * @return Hangar[]|null
     */
    public function getHangarsWithPlanes(): ?array
    {
        return $this->getHangarWithPlanesQueryBuilder()
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $hangarId
     *
     * @return Hangar|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getHangarWithPlanesById(int $hangarId): ?Hangar
    {
        return $this->getHangarWithPlanesQueryBuilder()
            ->where('hangar.id = :id')
            ->setParameter('id', $hangarId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return QueryBuilder
     */
    private function getHangarWithPlanesQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('hangar')
            ->select('hangar', 'planes', 'model', 'state')
            ->leftJoin('hangar.planes', 'planes')
            ->leftJoin('planes.planeModel', 'model')
            ->leftJoin('planes.state', 'state')
            ->orderBy('hangar.name', 'ASC')
            ->addOrderBy('model.name', 'ASC')
            ->addOrderBy('planes.tailNumber', 'ASC');
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(): void
    {
        $this->_em->flush();
    }
}
