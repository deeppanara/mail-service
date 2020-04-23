<?php


namespace App\Repository;

/**
 * EmailQueueRepository.
 *
 * @author Deep Panara
 *
 * @version 1.0
 */

use App\Entity\EmailQueue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EmailQueueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailQueue::class);
    }
}