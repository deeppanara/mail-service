<?php

namespace App\Service;

use App\Manager\MailManager;
use App\Repository\EmailGroupRepository;
use App\Twig\ContentProvider;
use Doctrine\ORM\Query;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MailSender
{

    /**
     * @var object|ContainerInterface
     */
    protected $container;
    /**
     * @var ContentProvider
     */
    protected $contentProvider;


    /**
     * Constructor.
     *
     * @param object $container
     */
    public function __construct(MailManager $mailManager, ContentProvider $contentProvider)
    {
        $this->mailManager = $mailManager;
        $this->contentProvider = $contentProvider;
    }

    public function sendDirecMail($content, $tags)
    {

    }
}
