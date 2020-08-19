<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\ORM\EntityRepository;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends EntityRepository
{
    /**
     * @param string $productTypeName
     * @return Product[]
     */
    public function findByProductType(string $productTypeName): array
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.productType', 'pt')
            ->where('pt.name = :pt_name')
            ->setParameter('pt_name', $productTypeName)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->execute();
    }
}
