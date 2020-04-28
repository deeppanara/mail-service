<?php

namespace App\MessageHandler;

use App\Message\MoveToLogMessage;
use App\Service\MailSenderService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class MoveToLogMessageHandler implements MessageHandlerInterface
{

    /**
     * @var MailSenderService
     */
    private $mailSenderService;

    /**
     * @var MessageBusInterface
     */
    private $eventBus;

    public function __construct(
        MessageBusInterface $eventBus,
        MailSenderService $mailSenderService
    )
    {
        $this->mailSenderService = $mailSenderService;
        $this->eventBus = $eventBus;
    }

    public function __invoke(MoveToLogMessage $message)
    {
        $message = EntityManager()->getReference('App\Entity\EmailQueue', $message->getMailQueueId());
        $messageclone =  clone $message;
        $this->mailSenderService->moveMessageToLog($messageclone);
        EntityManager()->remove($message);
        EntityManager()->flush();

    }
}
