<?php

namespace App\Repository;

use App\Entity\Cart;
use App\Entity\CartProduct;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CartProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartProduct[]    findAll()
 * @method CartProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartProduct::class);
    }

    /**
     * @param int $cartId
     * @return CartProduct[]
     */
    public function findByCartId(int $cartId)
    {
        return $this->createQueryBuilder('cp')
            ->andWhere('cp.cart = :cartId')
            ->setParameter('cartId', $cartId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $cartId
     * @param int $productId
     * @return CartProduct|null
     * @throws NonUniqueResultException
     */
    public function findByCartIdProductId(int $cartId, int $productId): ?CartProduct
    {
        return $this->createQueryBuilder('cp')
            ->andWhere('cp.cart = :cartId')
            ->andWhere('cp.product = :productId')
            ->setParameter('cartId', $cartId)
            ->setParameter('productId', $productId)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    /**
     * @param int $cartId
     * @return CartProduct[]|null
     */
    public function getGroupedProductList(int $cartId): ?array
    {
        return $this->createQueryBuilder('cp')
            ->select('IDENTITY(cp.product) as id, count(cp.product) as productCount')
            ->andWhere('cp.cart = :cartId')
            ->setParameter('cartId', $cartId)
            ->join('cp.product', 'p')
            ->addSelect('p.name, p.price')
            ->join('p.productType', 'pt')
            ->addSelect('pt.name as productType')
            ->groupBy('cp.product')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return CartProducts[] Returns an array of CartProducts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CartProducts
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
