<?php

namespace App\Repository;

use App\Entity\Horaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Horaires|null find($id, $lockMode = null, $lockVersion = null)
 * @method Horaires|null findOneBy(array $criteria, array $orderBy = null)
 * @method Horaires[]    findAll()
 * @method Horaires[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HorairesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Horaires::class);
    }
}
