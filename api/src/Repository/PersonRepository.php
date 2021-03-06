<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[]    findAll()
 * @method Person[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    public function findForPerson(Person $person): array
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.networkCollection', 'n')
            ->andWhere(':person MEMBER OF n.personCollection')
            ->setParameter('person', $person)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneForUser(UserInterface $user): ?Person
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.networkCollection', 'n')->addSelect('n')
            ->leftJoin('a.wishCollection', 'w')->addSelect('w')
            ->leftJoin('a.reservationCollection', 'r')->addSelect('r')
            ->andWhere('a.user = :id')
            ->setParameter('id', $user)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
