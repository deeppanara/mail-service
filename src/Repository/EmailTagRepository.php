<?php


namespace App\Repository;

/**
 * EmailTemplateRepository.
 *
 * @author Deep Panara
 *
 * @version 1.0
 */

use App\Entity\EmailTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EmailTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailTag::class);
    }
}