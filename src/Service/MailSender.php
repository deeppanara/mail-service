<?php

namespace App\Service;

use App\Manager\MailManager;
use App\Repository\EmailGroupRepository;
use Doctrine\ORM\Query;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MailSender
{

    /**
     * @var object|ContainerInterface
     */
    protected $container;

    /**
     * @var EmailGroupRepository
     */
    protected $emailGroupRepository;

    /**
     * Constructor.
     *
     * @param object $container
     */
    public function __construct(ContainerInterface $container, EmailGroupRepository $emailGroupRepository, MailManager $mailManager)
    {
        $this->container = $container;
        $this->emailGroupRepository = $emailGroupRepository;
        $this->mailManager = $mailManager;
    }
    
    public function sendByIentifier($identifier, $tags)
    {
        $this->mailManager->init();
        $this->mailManager->setTo('recipient222@example.com');
        $this->mailManager->render($identifier, $tags);
        $this->mailManager->send();
    }
}
