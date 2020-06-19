<?php

namespace App\Repository;

use App\Entity\PhoneBook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhoneBook|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhoneBook|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhoneBook[]    findAll()
 * @method PhoneBook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhoneBookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhoneBook::class);
    }

    // /**
    //  * @return PhoneBook[] Returns an array of PhoneBook objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findAllBy($params): ?array
    {
        $list = [];
        $query = $this->createQueryBuilder('p');
        foreach ($params as $key => $value) {
            $query->andWhere('p.' . $key . ' = :' . $key);
            $query->setParameter($key, $value);
        }

        $queryResult = $query
            ->getQuery()
            ->getArrayResult();
        foreach ($queryResult as $k=>$item) {
            $links = ['links' => '<a href="/' . $item['id'] . '/edit">Редактировать</a>'];
            $list[] = array_merge($links, $item);

        }

        return $list;
    }

}
