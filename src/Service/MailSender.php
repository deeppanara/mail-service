<?php

namespace App\Service;

use App\Entity\EmailQueue;
use App\Manager\MailManager;
use App\Repository\EmailGroupRepository;
use App\Repository\EmailQueueRepository;
use App\Repository\EmailTemplateRepository;
use App\Twig\ContentProvider;

class MailSender
{
    /**
     * @var ContentProvider
     */
    protected $contentProvider;
    /**
     * @var EmailQueueRepository
     */
    protected $emailQueueRepository;
    /**
     * @var EmailTemplateRepository
     */
    protected $emailTemplateRepository;
    /**
     * @var MailManager
     */
    protected $mailManager;


    /**
     * Constructor.
     *
     * @param object $container
     */
    public function __construct(
        MailManager $mailManager,
        ContentProvider $contentProvider,
        EmailQueueRepository $emailQueueRepository,
        EmailTemplateRepository $emailTemplateRepository
    )
    {
        $this->mailManager = $mailManager;
        $this->contentProvider = $contentProvider;
        $this->emailQueueRepository = $emailQueueRepository;
        $this->emailTemplateRepository = $emailTemplateRepository;
    }

    public function processRequest($request)
    {

        $subject = $this->contentProvider->render($request['personalizations']['subject'], $request['personalizations']['custom_tags'] ?? []);
        $messageObj = $this->emailTemplateRepository->findOneBy(['identifier' => $request['template_id']]);
        $message = $this->contentProvider->render($messageObj->getBodyHtml(), $request['personalizations']['custom_tags'] ?? []);

        $queue = new EmailQueue();
        $queue->setTemplateId($request['template_id']);
        $queue->setMailFrom($request['from']);
        $queue->setReplyTo($request['reply_to']);
        $queue->setMailTo($request['personalizations']['to']);
        $queue->setCc($request['personalizations']['cc']);
        $queue->setBcc($request['personalizations']['bcc']);
        $queue->setSubject($subject);
        $queue->setContent($message);
        $queue->setCustomTags($request['personalizations']['custom_tags'] ?? []);
        $queue->setSendAt($request['personalizations']['send_at']);

        EntityManager()->persist($queue);
        EntityManager()->flush();
    }
}
