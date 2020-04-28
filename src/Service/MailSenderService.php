<?php

namespace App\Service;

use App\Entity\EmailLog;
use App\Entity\EmailQueue;
use App\Manager\MailManager;
use App\Provider\ContentProvider;
use App\Repository\EmailQueueRepository;
use App\Repository\EmailTemplateRepository;


class MailSenderService
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
        $messageObj = $this->emailTemplateRepository->findOneBy(['identifier' => $request['template_id']]);
        if (isset($request['personalizations']['subject'])) {
            $subject = $this->contentProvider->render($request['personalizations']['subject'], $request['personalizations']['custom_tags'] ?? []);
        } else {
            $subject = $this->contentProvider->render($messageObj->getSubject(), $request['personalizations']['custom_tags'] ?? []);
        }

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
        $queue->setSendAt($request['personalizations']['send_at'] ?? time());

        EntityManager()->persist($queue);
        EntityManager()->flush();

        return $queue;
    }

    public function moveMessageToLog(EmailQueue $mailQueue)
    {
        $queue = new EmailLog();
        $queue->setQueueId($mailQueue->getId());
        $queue->setIsSent(true);
        $queue->setTemplateId($mailQueue->getTemplateId());
        $queue->setMailFrom($mailQueue->getMailFrom());
        $queue->setReplyTo($mailQueue->getReplyTo());
        $queue->setMailTo($mailQueue->getMailTo());
        $queue->setCc($mailQueue->getCc());
        $queue->setBcc($mailQueue->getBcc());
        $queue->setSubject($mailQueue->getSubject());
        $queue->setContent($mailQueue->getContent());
        $queue->setCustomTags($mailQueue->getCustomTags());
        $queue->setExpectedSentTime($mailQueue->getSendAt());
        $queue->setRealSentAt(time());

        EntityManager()->persist($queue);
        EntityManager()->flush();

    }

    public function sendMailFromQueue(EmailQueue $mailQueue)
    {

        try {
            $this->mailManager->init();
            $this->mailManager->setToArray($mailQueue->getMailTo());
            $this->mailManager->setFromArray($mailQueue->getMailFrom());
            $this->mailManager->setSubject($mailQueue->getSubject());
            $this->mailManager->setBody($mailQueue->getContent());
            $this->mailManager->send();
        } catch (\Exception $exception) {
            dd($exception);
        }
    }

}
