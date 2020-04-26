<?php

namespace App\MessageHandler;

use App\Message\MailQueue;
use App\Service\MailSenderService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class MailQueueHandler implements MessageHandlerInterface
{
    /**
     * @var MailSenderService
     */
    private $mailSenderService;

    public function __construct(MailSenderService $mailSenderService)
    {
        $this->mailSenderService = $mailSenderService;
    }

    public function __invoke(MailQueue $message)
    {
        $this->mailSenderService->sendMailFromQueue($message->getMailQueueObj());
//        EntityManager()->remove($message->getMessage());
//        EntityManager()->flush();
    }
}
