<?php


namespace App\Repository;

/**
 * EmailGroupRepository.
 *
 * @author Deep Panara
 *
 * @version 1.0
 */

use App\Entity\EmailGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EmailGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailGroup::class);
    }
}