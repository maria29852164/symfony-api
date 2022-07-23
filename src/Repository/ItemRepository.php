<?php

namespace App\Repository;

use App\Entity\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Item>
 *
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    public function add(Item $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function saveItem(string $title,string $description, string $image, float $price){
        $item = new Item();
        $item->setDescription($description);
        $item->setImage($image);
        $item->setPrice($price);
        $item->setTitle($title);
        $this->getEntityManager()->persist($item);
        $this->getEntityManager()->flush();

        return $item;


    }
    public function updateItem(Item $item,string $title,string $description, string $image, float $price){

        $item->setDescription($description);
        $item->setImage($image);
        $item->setPrice($price);
        $item->setTitle($title);
        $this->getEntityManager()->persist($item);
        $this->getEntityManager()->flush();
        return $item;


    }

    public function remove(Item $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function getItems(string $orderBy , string $type){
        return $this->createQueryBuilder('i')
            ->orderBy('i.'.$orderBy,$type)
            ->getQuery();
    }
    public function getCount(){
        return $this->createQueryBuilder('i')
            ->select('count(i.id)')
            ->getQuery()
            ->getSingleScalarResult();


}



//    /**
//     * @return Item[] Returns an array of Item objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Item
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function getAllItems(string $orderBy,string $type){
        $dql = "SELECT * FROM item ORDER BY item.id DESC";
        return $this->getEntityManager()->createQuery($dql);

    }
}
