<?php

namespace App\Repository;

use App\Entity\StockCalculation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StockCalculation>
 *
 * @method StockCalculation|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockCalculation|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockCalculation[]    findAll()
 * @method StockCalculation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockCalculationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockCalculation::class);
    }

    public function save(StockCalculation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StockCalculation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
