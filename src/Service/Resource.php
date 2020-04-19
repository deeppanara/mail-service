<?php

namespace App\Service;

use App\Repository\EmailGroupRepository;
use Doctrine\ORM\Query;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Resource
{
    /**
     * @var EmailGroupRepository
     */
    protected $emailGroupRepository;
    
    /**
     * @var object|ContainerInterface
     */
    protected $container;

    /**
     * Constructor.
     *
     * @param object $container
     */
    public function __construct(ContainerInterface $container, EmailGroupRepository $emailGroupRepository)
    {
        $this->container = $container;
        $this->emailGroupRepository = $emailGroupRepository;
    }
    
    public function getGropListForSidebar()
    {
        $groups = $this->emailGroupRepository->findAll();
        foreach ($groups as $group) {
            $array['id'] = $group->getId();
            $array['name'] = $group->getName();
            $list[] = $array;
        }

        return $list ?? [];
    }

}
