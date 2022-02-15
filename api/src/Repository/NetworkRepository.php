<?php

namespace App\Repository;

use App\Entity\Network;
use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Network|null find($id, $lockMode = null, $lockVersion = null)
 * @method Network|null findOneBy(array $criteria, array $orderBy = null)
 * @method Network[]    findAll()
 * @method Network[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NetworkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Network::class);
    }

    public function findForPerson(?Person $person): array
    {
        if (!$person) {
            return [];
        }

        return $this->createQueryBuilder('a')
            ->leftJoin('a.eventCollection', 'e')->addSelect('e')
            ->leftJoin('a.personCollection', 'p')->addSelect('p')
            ->andWhere(':person MEMBER OF a.personCollection')
            ->setParameter('person', $person)
            ->getQuery()
            ->getResult()
        ;
    }

}
