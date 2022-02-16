<?php

namespace App\Repository;

use App\Entity\Item;
use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
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

    public function findForPerson(Person $person): ?Item
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.wishCollection', 'w')
            ->innerJoin('w.person', 'p')
            ->innerJoin('p.networkCollection', 'n')
            ->andWhere(':person MEMBER OF n.personCollection')
            ->setParameter('person', $person)
            ->getQuery()
            ->getResult()
        ;
    }
}
